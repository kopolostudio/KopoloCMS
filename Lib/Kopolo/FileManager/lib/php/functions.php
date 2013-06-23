<?php
/**
 * Functions
*/

/**
 * Getting directory tree array in specified path
 * Structure:
 *     name   (string)
 *     subdir (array)
 * 
 * @param strind    path (without closing slash)
 * 
 * @return array
*/
function get_dir_array($dirpath, $level=1) 
{ 
    $dirlist = array();
    
    // Opening current directory
    $dir = opendir($dirpath);
    
    // Reading directory in cycle
    while (($dirname = readdir($dir)) !== false) {
        // If it's directory and it's not hidden, calling this function recursively
        $curdirpath = $dirpath . '/' . $dirname;
        if(is_dir($curdirpath) && substr($dirname, 0, 1) != '.') {
            $item = array();
            $item['name']   = $dirname;
            $item['level'] = $level;
            $item['subdir'] = get_dir_array($curdirpath, $level+1);
            
            $dirlist[] = $item;
        }
    }
    
    // Closing directory
    closedir($dir);
    
    return $dirlist;
}

/**
 * Getting the list of files (array)
 * Structure:
 *     basename   (string)
 *     filename   (string)
 *     extension  (string)
 *     thumbnail  (string) URL, if it's picture
 *     size       (float)  Kb
 * 
 * @param  strind   path
 * 
 * @return array
*/
function get_files($dirpath)
{
    $files = array();
    
    // Opening current directory
    $dir = opendir($dirpath);
    
    // Reading directory in cycle
    while (($filename = readdir($dir)) !== false) {
        $filepath = $dirpath . '/' . $filename;
        if(is_file($filepath) && substr($filename, 0, 1) != '.') {
            $item = pathinfo($filepath);
            $item['extension'] = mb_strtolower($item['extension']);
            $item['size'] = round(filesize($filepath)/1024, 2);
            $item['thumbnail'] = fit($filepath, $item);
            
            $files[] = $item;
        }
    }
    
    // Closing directory
    closedir($dir);
    
    return $files;
}

/**
 * Fit image
 * 
 * @param string absolute file path
 * @param array file info (of functions pathinfo)
 * 
 * @return string absolute thumbnail path
*/
function fit($filepath, $fileinfo) 
{
    global $config;
    if ($config['thumbnail']['show']==true && in_array($fileinfo['extension'], $config['thumbnail']['extensions'])) {
        $width  = $config['thumbnail']['width'];
        $height = $config['thumbnail']['height'];
        
        $size = getimagesize($filepath);
        
        /* проверка, не больше ли изображение допустимых размеров */
        if ($size[0] > $config['image_width_limit'] ||  $size[1] > $config['image_height_limit']) {
            return false;
        }
        
        /* определение имени и пути миниатюры */
        $file_dir = '/' . substr ($fileinfo['dirname'], strlen($config['dirabs'])) . '/';
        $file = $fileinfo['filename'].'_'.$width.'x'.$height.'.'.$fileinfo['extension'];
        if (isset($config['thumbnail']['dir_abs'])) {
            $thumbnail_dir_abs = $config['thumbnail']['dir_abs'] . $file_dir;
            $thumbnail_path_abs = $thumbnail_dir_abs . $file;
            $root_path = substr ($config['dirabs'], 0, strlen($config['dirabs'])-strlen($config['dir'])-1); //-1 Ч slash
            $thumbnail_url = substr ($thumbnail_dir_abs, strlen($root_path)) . $file;
        } else {
            $thumbnail_dir = $config['dir'] . '/' . $config['thumbnail']['dir'];
            $thumbnail_dir_abs = $config['dirabs'] . '/' . $config['thumbnail']['dir'] . '/' . $file_dir;
            $thumbnail_path = $config['thumbnail']['dir'] . $file_dir . $file;
            $thumbnail_path_abs = $config['dirabs'] . '/' . $thumbnail_path;
            $thumbnail_url = $config['dir'] . '/' . $thumbnail_path;
        }
        
        /* провер€ем, нужно ли уменьшать изображение */
        if ($size[0] > $width || $size[1] > $height) {
            if (!file_exists($thumbnail_path_abs)) {
                /* вычисл€ем размеры миниатюры (по бќльшей стороне) */
                if ($size[0] >= $size[1]) {
                    $height = ceil($size[1]/($size[0]/$width));
                } else {
                    $width = ceil($size[0]/($size[1]/$height));
                }
                
                switch($fileinfo['extension']){
                    case 'jpeg':
                    case 'jpg':
                        $big_img = @ImageCreateFromJPEG($filepath);
                        break;
                    case 'gif':
                        $big_img = @ImageCreateFromGIF($filepath);
                        break;
                    case 'bmp':
                        $big_img = @imagecreatefromwbmp($filepath);
                        break;
                    case 'png':
                        $big_img = @imagecreatefrompng($filepath);
                        break;
                }
                
                $thumbnail_img = imagecreatetruecolor($width, $height);
                imagecopyresized($thumbnail_img, $big_img, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
                
                /* сохранение изображени€ */
                if (!file_exists($thumbnail_dir_abs)) {
                    $res = mkdir($thumbnail_dir_abs, 0777, true);
                    if (!$res) return false;
                }
                
                switch($fileinfo['extension']){
                    case 'bmp':
                    case 'jpeg':
                    case 'jpg':
                        imagejpeg($thumbnail_img, $thumbnail_path_abs, $config['thumbnail']['quality']);
                    break;
                    case 'gif':
                        imagegif($thumbnail_img, $thumbnail_path_abs);
                    break;
                    case 'png':
                        imagealphablending($thumbnail_img, false);
                        imagesavealpha($thumbnail_img, true);
                        imagepng($thumbnail_img, $thumbnail_path_abs);
                }
                imagedestroy($big_img);
                imagedestroy($thumbnail_img);
            }
        } else {
            $thumbnail_url = $config['dir'] . $file_dir . $fileinfo['basename'];
        }
        return $thumbnail_url;
    }
    return false;
}

function message($key) {
    global $msg;
    if (isset($msg[$key])) {
        return $msg[$key];
    }
    return error('undefined_error');
}

function error($key) {
    global $msg;
    //TO DO запись в лог
    if (isset($msg[$key])) {
        return $msg[$key];
    }
    return 'Undefined error.';
}