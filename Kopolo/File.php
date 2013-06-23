<?php

/**
 * Класс включающий методы для работы с файлами
 *
 * @version 0.3 / 28.01.2011
 * @author kopolo.ru
 * @developers Andrey Kondratiev [andr@kopolo.ru]
 *             Elena Kondratieva [elena@kopolo.ru]
 */
final class Kopolo_File
{
    
    /**
     * Перемещает загружаемый файл в соответсвующую директорию
     * @param array $file_info - информация о файле pathinfo
     * @param string $dst_virt_path - относительный путь к файлу
     * @return string - путь к файлу, относительно UPLOAD_DIR_ABS
     */
    static function moveUploadedFile ($file_info,$dst_virt_path)
    {
        /* преобразование пути */
        $dst_virt_path = Kopolo_File::getCorrectDir($dst_virt_path);
        
        $dst_path = KOPOLO_PATH . 'Files/' . $dst_virt_path . '/';
        if (!is_dir($dst_path)) {
            mkdir($dst_path, 0777, true);
        }
        /*Проверим на наличие такого файла в целевой дериктории*/
        $dst_file = Kopolo_File::newFileName($dst_path,$file_info['name']);
        
        if ($dst_file != false) {
            $result = move_uploaded_file($file_info['tmp_name'], $dst_path.$dst_file);
            if ($result==true) {
                return '/Files/' . $dst_virt_path . '/' . $dst_file;
            }
        }
        return false;
    }
    
    /**
     * Создает новое имя файла, до тех пор, пока не окажется,
     * что такого файла нет, либо возвращает входное имя файла
     * @param string $dst_dir - путь к назначенной дериктории
     * @param string $filename - имя файла
     * @return string
     */
    static function newFileName($dst_dir, $filename)
    {
        $filename = Kopolo_File::getCorrectFileName($filename);
        if (!is_file($dst_dir.$filename)) {
            return $filename;
        } else {
            $pathinfo = pathinfo($filename);
            
            preg_match('/^(.*)_n(\d)+$/i', $pathinfo['filename'], $filename_matches);
            if (!is_array($filename_matches) || !isset($filename_matches[2])) {
                $new_filename = $pathinfo['filename'].'_n1';
            } else {
                $new_filename = $filename_matches[1].'_n'.($filename_matches[2]+1);
            }
            $new_filename_full = $new_filename.'.'.$pathinfo['extension'];
            return Kopolo_File::newFileName($dst_dir,$new_filename_full); /*Рекурсия!*/
        }
    }
    
    /**
     * Возвращает корректное имя для файла с запрещенными символами (все, кроме a-z0-9_-.)
     * 
     * @param string имя файла
     * @return string новое имя файла
     */
    static function getCorrectFileName($filename)
    {
        $filename_result = Kopolo_String::transliterate4filename($filename);
        
        /* Если не удалось получить корректный файл - генерируем для него новое имя */
        if ($filename_result == false) {
            $pathinfo = pathinfo($filename);
            $filename_result = md5($filename . time()).'.'.$pathinfo['extension'];
        }
        return $filename_result;
    }
    
    /**
     * Возвращает корректный путь для директории
     * 
     * @param string путь
     * @return string путь
     */
    static function getCorrectDir($dirpath)
    {
        if (strstr($dirpath, 'Module_')) {
            $dirpath = substr($dirpath, 7, strlen($dirpath)); //без "Module_"
        }
        //замена всех подчеркиваний на слеши
        $dirpath = str_replace("_","/",$dirpath);
        return $dirpath;
    }
    
    function __construct()
    {}
    
    function __clone()
    {}
}