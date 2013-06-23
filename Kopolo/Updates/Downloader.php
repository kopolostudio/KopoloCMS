<?php
require_once 'Archive/Tar.php';

/**
 * Загрузчик обновлений
 * @author  kopolo.ru
 * @version 0.1 [09.07.2011]
 * @package Updates
 *
 */
class Kopolo_Updates_Downloader
{
    /**
     * Массив с сообщениями класса
     * @var array
     */
    public $messages = array();
    
    /**
     * Флаг говорящий о том, что продолжение установки возможно
     * @var boolean
     */
    public $continuation_is_possible = true;
    
    /**
     * URL к информации об обновлениях c закрывающим слешем
     * @var string
     */
    protected static $updates_url = 'http://downloads.kopolocms.ru/updates/info/';
    
    /**
     * Имя файла с информацией об обновлениях
     * @var string
     */
    protected static $updates_info_file = 'info.ini';
    
    /**
     * Имя файла с информацией о конкретном пакете обновлений
     * @var string
     */
    protected static $update_info_file = 'update.ini';
    
    /**
     * Путь к временной директории для распаковки обновлений с закрывающим слешем
     * @var string
     */
    protected static $updates_tmp_path = 'Tmp/Updates/';
    
    /**
     * Информация об обновлениях, загружается в конструкторе
     * @var array
     */
    protected $updates_info = false;
    
    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->updates_info = self::checkAvailable();
    }
    
    /**
     * Проверка наличия обновлений для этой версии
     * @return array - информация о доступных обновлениях для этой версии системы
     */
    public static function checkAvailable ()
    {
        $version = str_replace('.','_',KOPOLO_VERSION);
        $updates_info_fullpath = self::$updates_url.$version.'/'.self::$updates_info_file;
        $updates_info = @file_get_contents($updates_info_fullpath);
        if ($updates_info != false) {
            return unserialize($updates_info);
        } else {
            return false;
        }
    }
    
    /**
     * Проверка наличия уже скачанных и готовых к установке обновлений
     * возвращает массив содержащий информацию об каждом из готовых к установке обновлений
     * ключем является версия обновления
     * @return array
     */
    public static function checkDownloaded ()
    {
        $updates_dir = KOPOLO_PATH.self::$updates_tmp_path;
        $subdirs = glob( $updates_dir . '*', GLOB_ONLYDIR );
        $updates_info = array();
        foreach ($subdirs as $dir) {
            if (is_file($dir.'/'.self::$update_info_file)) {
                $update_info_string = @file_get_contents($dir.'/'.self::$update_info_file);
                $update_info = unserialize($update_info_string);
                if (version_compare($update_info['version'],KOPOLO_VERSION,'>')) {
                    /*Предлагаем к установке, только если обновление свежее установленной сейчас версии*/
                    if (is_file($dir.'/wronghash')) {
                        $update_info['wronghash'] = true;
                    }
                    $update_info['update_dir'] = $dir.'/'; 
                    $updates_info[$update_info['version']] = $update_info;
                }
            }
        }
        return $updates_info;
    }
    
    /**
     * Скачивает архив с пакетом обновлений
     * @param string - версия запрашиваемого обновления
     */
    public function download ($update_version)
    {
        if ($this->updates_info == false || !isset($this->updates_info[$update_version])) {
            $this->messages[] = array(
                'status'=>'error',
                'text'=>'Невозможно соединиться с сервером обновлений, повторите попытку позже'
            );
            $this->continuation_is_possible = false;
            return false;
        }
        $update_info = $this->updates_info[$update_version];
        $update_url = $update_info['download_url'];
        $file_name_full = basename($update_url);
        $file_name = basename($update_url,'.tar');
        $package_path = KOPOLO_PATH.self::$updates_tmp_path.$file_name_full;
        if (is_file($package_path)) {
            /*Удаление архива, если вдруг уже есть*/
            unlink($package_path);
        }
        $package_dir = KOPOLO_PATH.self::$updates_tmp_path.$file_name.'/';
        if (is_dir($package_dir)) {
            /*Удаление директории с пакетом, если таковая есть*/
            Kopolo_FileSystem::removeRecursively($package_dir);
        }
        if (!@copy($update_url, $package_path)) {
            $this->messages[] = array(
                'status'=>'error',
                'text'=>'Загрузка пакета обновлений не удалась, повторите попытку позже'
            );
            $this->continuation_is_possible = false;
            return false;
        }
        if (md5_file($package_path) != $update_info['hash']) {
            $this->messages[] = array(
                'status'=>'error',
                'text'=>'Загруженный файл не прошел проверку контрольной суммы, попробуйте скачать обновление заново'
            );
            $wronghash = true;
        }
        if ($this->unpack($package_path,true)) {
            /*Все прошло успешно, обновление готово к установке*/
            if (isset($wronghash)) {
                /*Если хэш неверный, но архив все-равно как-то распаковался - создадим в директории пакета метку*/
                touch($package_dir.'wronghash');
                return false;
            } else {
                return true;
            }
        } else {
            $this->messages[] = array(
                'status'=>'error',
                'text'=>'Не удалось распаковать пакет обновлений, попробуйте скачать обновление заново'
            );
            return false;
        }
    }

    
    /**
     * Распаковывает архив с пакетом во временную директорию
     * @param string $package_path - путь к архиву
     * @param boolean $remove_archive - удалить архив, после распаковки
     * @return boolean - возвращает TRUE вслучае успеха операции, иначе FALSE
     */
    public function unpack ($package_path,$remove_archive=false) {
        $tar = new Archive_Tar($package_path);
        $untar_result = $tar->extract(KOPOLO_PATH.self::$updates_tmp_path);
        if ($untar_result && $remove_archive) {
            unlink($package_path);
        }
        return $untar_result;
    }
}