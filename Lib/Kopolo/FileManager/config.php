<?php
/**
* Configuration file
*/

define('KFM_VERSION', '1.1.1');

/**************/
/*** Basic ***/
/**************/

$config['dir'] = '/Files'; // Relative path to files (without closing slash)
$config['dirabs'] = KOPOLO_PATH_USER_FILES; // Full path to files directory (without closing slash)
$config['url'] = '/Lib/Kopolo/FileManager/'; // Relative URL of KopoloFileManager for loading css, javascripts etc. (with opening and closing slashes)


/********************/
/*** Localization ***/
/********************/

$config['lang'] = 'ru'; // Language of interface (see all langs in /lang/ directory)


/*******************/
/*** Permissions ***/
/*******************/

$config['options']['dir'] = array (
    'add' => true,
    'remove' => false, //not implemented
    'rename' => false //not implemented
);
$config['options']['file'] = array (
    'add' => true,
    'remove' => false, //not implemented
    'rename' => false //not implemented
);


$config['extensions']['allow'] = array(
    '7z', 'csv', 'doc', 'docx', 'gz', 'gzip', 'ods', 'odt', 'pdf', 'ppt', 'pxd', 'qt', 'rar', 'rtf', 'sdc', 'sitd', 'sxc', 'sxw', 'tar', 'tgz', 'tif', 'tiff', 'txt', 'vsd', 'xls', 'xml', 'zip', 'chm',
    
    'jpg', 'jpeg', 'gif', 'png', 'bmp',
    
    'swf', 'flv', 'fla', 'flv',
    
    'aiff', 'asf', 'avi', 'mid', 'mov', 'mp3', 'mp4', 'mpc', 'mpeg', 'mpg', 'qt', 'ram', 'rm', 'rmi', 'rmvb', 'wav', 'wma', 'wmv'
);

/**************/
/*** Upload ***/
/**************/

// Must not be greater than 'post_max_size' and 'upload_max_filesize' in the servers settings
$config['file_size_limit'] = 2 * 1024 * 1024;
$config['image_width_limit'] = 1200;
$config['image_height_limit'] = 1200;


/**************/
/*** Design ***/
/**************/

/**
* Name of the skin (see all skins in /skins/ ditectory)
* @var string
*/
$config['skin'] = 'light';

$config['dirname']['length'] = 30;
$config['filename']['length'] = 8;

/**
* On/off images thumbnails (required GD support)
* @var boolean
*/
$config['thumbnail']['show'] = true;

/**
* Directory for images previews (will be created, if not exists)
* @var string
*/
$config['thumbnail']['dir'] = '.thumbnails';

/**
* Absolute path to directory for images previews
* (optional, comment this line if you want to keep thumbnails in the same ditectory as the files)
* @var string
*/
$config['thumbnail']['dir_abs'] = KOPOLO_PATH . 'Tmp/Clones/KFMThumbs';

$config['thumbnail']['extensions'] = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
$config['thumbnail']['width']   = 64;
$config['thumbnail']['height']  = 64;
$config['thumbnail']['quality'] = 80;
