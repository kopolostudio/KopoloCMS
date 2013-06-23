<?php

/**
 * Класс включающий методы для работы с файловой системой
 *
 * @version 1.1 / 11.07.2011
 * @author kopolo.ru
 * @developers Elena Kondrateva [elena@kopolo.ru], Andrey Kondratev [andr@kopolo.ru] 
 */
 
final class Kopolo_FileSystem
{
    /**
     * Getting list of directories in specified path (not recursively)
     * 
     * @param strind    path (without closing slash)
     * @return array
    */
    public static function getDirs($dirpath) 
    {
        $dirlist = array();
        
        // Opening current directory
        $dir = opendir($dirpath);
        
        // Reading directory in cycle
        while (($dirname = readdir($dir)) !== false) {
            $curdirpath = $dirpath . '/' . $dirname;
            if (is_dir($curdirpath) && substr($dirname, 0, 1) != '.') {
                $dirlist[] = $dirname;
            }
        }
        
        // Closing directory
        closedir($dir);
        
        return $dirlist;
    }
    
    /**
     * Getting directory ans files tree array in specified path
     * 
     * Recursion!
     * 
     * @param strind    path (without closing slash)
     * @param strind    current level (for internal using)
     * 
     * @return array
     * 
     * Structure:
     *     name    (string)
     *     level   (integer)
     *     dirs    (array)
     *     is_file (boolean)
    */
    public static function getFilesArray($dirpath, $level=0) 
    {
        $dirlist = array();
        
        // Opening current directory
        $dir = opendir($dirpath);
        
        // Reading directory in cycle
        while (($dirname = readdir($dir)) !== false) {
            // If it's directory and it's not hidden, calling this function recursively
            $curdirpath = $dirpath . '/' . $dirname;
            
            if (substr($dirname, 0, 1) != '.') {
                $item = array();
                $item['name'] = $dirname;
                $item['level'] = $level;
                
                if(is_dir($curdirpath)) {
                    $item['dirs'] = self::getFilesArray($curdirpath, $level+1);
                    $item['is_file'] = false;
                } elseif (is_file($curdirpath)) {
                    $item['is_file'] = true;
                }
                $dirlist[] = $item;
            }
        }
        
        // Closing directory
        closedir($dir);
        
        return $dirlist;
    }
    
    /**
     * Удаляет директорию рекурсивно, либо просто удаляет, если это файл
     * @param string $path - путь к удаляемой директории или файлу
     * @return boolean - возвращает TRUE в случае успешного удаления, иначе FALSE
     */
    public static function removeRecursively($path)
    {
        $all_files_removed = true;
        if (is_dir($path)) {
            /*Это директория, удаляем рекурсивно*/
            $files = glob( $path . '*', GLOB_MARK );
            foreach( $files as $file ){
                if( is_dir($file) ) {
                    /*Удаление субдиректорий*/
                    if (!self::removeRecursively( $file )) { /*рекурсия*/
                        $all_files_removed = false;
                    } 
                } else {
                    /*Удаление файлов*/
                    if (!unlink( $file )) {
                        $all_files_removed = false;
                    }
                }
            }
            if ($all_files_removed == true) {
                /*Если все содержимое удалено успешно, то удалим саму директорию*/
                if (!rmdir( $path )) {
                    $all_files_removed = false;
                }
            }
        } elseif (is_file($path)) {
            /*Просто удалим, если это файл*/
            if (!unlink( $file )) {
                $all_files_removed = false;
            }
        } else {
            /*Если это не директория и не файл, то это какой-то глюк*/
            $all_files_removed = false;
        }
        
        return $all_files_removed;
    }
    
    /**
     * Копирует директорию рекурсивно, либо просто копирует, если это файл
     * @param string $path_src - путь к директории источнику 
     * @param string $path_dst - путь к директории назначения
     * @return boolean - возвращает TRUE в случае успешного копирование всех файлов, иначе FALSE
     */
    public static function copyRecursively($path_src,$path_dst) {
        $all_files_copied = true;
        if (is_dir($path_src)) {
            /*Это директория копируем рекурсивно*/
            $dir = opendir($path_src); 
            @mkdir($path_dst); 
            while(false !== ( $file = readdir($dir)) ) { 
                if (( $file != '.' ) && ( $file != '..' )) { 
                    if ( is_dir($path_src . '/' . $file) ) {
                        /*Удаление субдиректорий*/
                        if (!self::copyRecursively($path_src . '/' . $file,$path_dst . '/' . $file)) { /*рекурсия*/
                            $all_files_copied = false;
                        }
                    } else { 
                        /*Удаление файлов*/
                        if (!copy($path_src . '/' . $file,$path_dst . '/' . $file)) {
                            $all_files_copied = false;
                        } 
                    } 
                } 
            } 
            closedir($dir); 
        } elseif (is_file($path_src)) {
            /*Это файл - просто копируем*/
            if (!copy($path_src,$path_dst)) {
                $all_files_copied = false;
            }
        } else {
            /*Если это не директория и не файл, то это какой-то глюк*/
            $all_files_copied = false;
        }
        return $all_files_copied;
    }
    
    function __construct()
    {}
    
    function __clone()
    {}
}