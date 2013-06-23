<?php

/**
 * Установщик обновлений
 * @author  kopolo.ru
 * @version 0.5 [09.07.2011]
 * @package Updates
 *
 */
class Kopolo_Updates_Installer
{
    
    /**
     * Массив с сообщениями класса
     * @var array
     */
    public $messages = array();
    
    /**
     * Конфиг обновления (см. образец данных в документации)
     * @var array
     */
    public $update_config = array();
    
    /**
     * Полный путь к директории с обновлением, с закрывающим слэшем
     * @var string
     */
    public $update_dir = '';
    
    /**
     * Имя конфигурационного файла обновлений
     * @var string
     */
    protected $updates_config_file = 'update.ini';
    
    /**
     * Имя основного конфигурационного файла системы
     * @var stirng
     */
    protected $system_config_file = 'config.php'; 
    
    /**
     * Конструктор
     * @param string $update_dir - Полный путь к директории с обновлением, с закрывающим слэшем
     */
    public function __construct($update_dir)
    {
        $this->update_dir = $update_dir;
        if (is_file($update_dir.$this->updates_config_file)) {
            $update_config_serialized = file_get_contents($update_dir.$this->updates_config_file);
            $this->update_config = unserialize($update_config_serialized);
        } else {
            $this->messages[] = array(
                'status'=>'error',
                'text'=>'Конфигурационный файл обновления не найден в директории обновления'
            );
            return false;
        }
    }
    
    /**
     * Проверяет версию системы на совместимость с обновлением
     * @return boolean
     */
    public function checkVersionCompatibility()
    {
        if (in_array(KOPOLO_VERSION,$this->update_config['compatible_versions'])) {
            return true;
        } else {
            $this->messages[] = array(
                'status'=>'error',
                'text'=>'Пакет обновлений не совместим с установленной версией системы.'
            );
            return false;
        }
    }
    
    /**
     * Проверяет зависимости обновления
     * @return boolean - true если все зависимости в порядке иначе false 
     */
    public function checkDependings()
    {
        if (is_array($this->update_config['dependings']) && count($this->update_config['dependings'])>0) {
            $all_dependings_ok = true;
            foreach ($this->update_config['dependings'] as $file_dependings) {
                if ($file_dependings['compatible_hashes'] != 0) {
                    /*Проверка файла который должен быть*/
                    if (is_file($file_dependings['file'])) {
                        $hash = md5_file($file_dependings['file']);
                        if (!in_array($hash,$file_dependings['compatible_hashes'])) {
                            /*Хэш файла не соответствует ни одному из указанных в конфиге*/
                            $all_dependings_ok = false;
                            $nohash_message = 'Хэш-сумма файла '.$file_dependings['file'].' не соответствует совместимой, вероятно файл был изменен';
                            $this->messages[] = array(
                                'status'=>'error',
                                'text'=>$this->checkFileVersion($nohash_message, $file_dependings)
                            );
                        }
                    } else {
                        $this->messages[] = array(
                            'status'=>'error',
                            'text'=>'Файл '.$file_dependings['file'].' указанный в списке зависимостей не найден'
                        );
                        $all_dependings_ok = false;
                    }
                } else {
                    /*Проверка файла которого не должно быть*/
                    if (is_file($file_dependings['file'])) {
                        $this->messages[] = array(
                            'status'=>'error',
                            'text'=>'Файла '.$file_dependings['file'].' не должно быть в системе, вероятно прошлое обновление прошло неудачно'
                        );
                        $all_dependings_ok = false;
                    }
                }
            }
            return $all_dependings_ok;
        } else {
            /*Раз зависимости не описаны, значит зависимостей нет*/
            return true;
        }
    }
    
    /**
     * Проверяет соответствие версии файла
     * Для не PHP файлов и файлов без версии возвращает сообщение по умолчанию
     * @param string $default_message - сообщение по умолчанию
     * @param array $file_dependings - требования к файлу из update.ini
     */
    public function checkFileVersion($default_message,$file_dependings){
        $pathinfo = pathinfo(KOPOLO_PATH.$file_dependings['file']);
        if ($pathinfo['extension']=='php') {
            /*Если это PHP файл, то проверим его версию*/
            $php_file_contents = file_get_contents(KOPOLO_PATH.$file_dependings['file']);
            preg_match("/\* @version ([0-9.]+)/",$php_file_contents,$matches_version);
            if (isset($matches_version[1])) {
                if (in_array($matches_version[1], $file_dependings['compatible_versions'])) {
                    $message = 'Хэш-сумма файла '.$file_dependings['file'].' не соответствует совместимой, однако версия файла соответствует требуемой, вероятно файл был изменен'; 
                } else {
                    $message = 'Хэш-сумма файла '.$file_dependings['file'].' и версия файла не соответствуют совместимым, вероятно файл был изменен';
                }
            } else {
                /*Не найдена информация о версии - просто сообщаем о том, что ХЭШ файла не соответствует*/
                $message = $default_message; 
            }
        } else {
            /*Не PHP файл - просто сообщаем о том, что ХЭШ файла не соответствует*/
            $message = $default_message;
        }
        return $message;
    }
    
    /**
     * Проверка прав доступа к файлам
     * @return boolean - если доступ ко всем файлам есть true иначе false
     */
    public function checkRights()
    {
        $all_writable = true;
        /*check files for writing rights*/
        foreach ($this->update_config['updated_files'] as $file) {
            if (is_file(KOPOLO_PATH.$file)) {
                if (!is_writable(KOPOLO_PATH.$file)) {
                    $this->messages[] = array(
                        'status'=>'error',
                        'text'=>'Нет прав записи в файл '.$file
                    );
                    $all_writable = false;
                }
            } else {
                $pathinfo = pathinfo(KOPOLO_PATH.$file);
                if (!is_writable($pathinfo['dirname'])) {
                    $this->messages[] = array(
                        'status'=>'error',
                        'text'=>'Нет прав записи в директорию '.$pathinfo['dirname']
                    );
                    $all_writable = false;
                }
            }
        }
        
        /*check files marked for removing for writing rights*/
        foreach ($this->update_config['removed_files'] as $file) {
            if (is_file(KOPOLO_PATH.$file) && !is_writable(KOPOLO_PATH.$file)) {
                $this->messages[] = array(
                    'status'=>'error',
                    'text'=>'Файл '.$file.' помеченный на удаление не имеет прав на запись'
                );
                $all_writable = false;
            }
        }
        
        /*Проверим config.php на права на запись*/
        if (!is_writable(KOPOLO_PATH.$this->system_config_file)) {
                $this->messages[] = array(
                    'status'=>'error',
                    'text'=>'Нет прав на запись в конфигурационный файл '.$this->system_config_file.''
                );
                $all_writable = false;
        }
        
        return $all_writable;
    }
    
    /**
     * Обновляет систему
     * @return boolean
     */
    public function update()
    {
        $update_successful = true;
        $updates_dir = $this->update_dir;
        /*copy new files*/
        foreach ($this->update_config['updated_files'] as $file) {
            if (!copy($updates_dir.'/files/'.$file,KOPOLO_PATH.$file)) {
                $this->messages[] = array(
                    'status'=>'error',
                    'text'=>'Ошибка при копировании файла '.$file
                );
                $update_successful = false;
            }
        }        
        /*removing files*/
        foreach ($this->update_config['removed_files'] as $file) {
            if (is_file(KOPOLO_PATH.$file)) {
                if (!unlink(KOPOLO_PATH.$file)) {
                    $this->messages[] = array(
                        'status'=>'error',
                        'text'=>'Файл '.$file.' помеченный на удаление не был удален'
                    );
                    $update_successful = false;
                }
            }
        }
        if (!$this->changeSystemVersion()) {
            $this->messages[] = array(
                'status'=>'error',
                'text'=>'Конфигурационный файл '.$this->system_config_file.' не был изменен, вероятно нет прав на изменение файла'
            );
            $update_successful = false;
        }
        
        if ($update_successful==true) {
            /*Удалим файлы этого обновления, если обновление прошло успешно*/
            Kopolo_FileSystem::removeRecursively($updates_dir);
        }
        return $update_successful;
    }
    
    /**
     * Обновлеят версию в конфигурационном файле системы
     * @return boolean
     */
    protected function changeSystemVersion()
    {
        /*define ('KOPOLO_VERSION', ".KOPOLO_VERSION.");*/
        if (!is_file(KOPOLO_PATH.$this->system_config_file)) {
            $this->messages[] = array(
                'status'=>'error',
                'text'=>'Конфигурационный файл '.$this->system_config_file.' не найден'
            );
            return false;
        }
        $config_string = file_get_contents(KOPOLO_PATH.$this->system_config_file);
        $old_version_string = "define ('KOPOLO_VERSION', '".KOPOLO_VERSION."');";
        $new_version_string = "define ('KOPOLO_VERSION', '".$this->update_config['version']."');";
        $new_config_string = str_replace($old_version_string, $new_version_string, $config_string);
        echo $new_config_string;
        $result = file_put_contents(KOPOLO_PATH.$this->system_config_file, $new_config_string);
        if ($result != false && $result>100) {
            return true;
        } else {
            return false;
        }
    }

}