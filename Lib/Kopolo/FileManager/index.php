<?php
/**
 * Main controller
 * 
 * KopoloFileManager
 * @author Elena Kondrateva [elena@kopolo.ru]
*/

error_reporting(E_ALL);
ini_set('display_errors', 'on');
mb_internal_encoding('UTF-8');

define('KFM_PATH', str_replace("\\", "/", realpath (dirname (__FILE__))) . '/');
require_once realpath (KFM_PATH . "/../../..") . '/config.php';
require_once realpath (KFM_PATH . "/../../..") . '/bootstrap.php';
require_once KFM_PATH .'config.php';

// Loading language file
$lang_file = KFM_PATH .'lang/' . $config['lang'] . '.php';
if (file_exists($lang_file)) {
    require_once $lang_file;
} else {
    echo 'Undefined language "' . $config['lang'] . '".';
    exit();
}

//Skin path
$config['skin_path'] = $config['url'] . 'skins/' . $config['skin'];

require_once KFM_PATH . 'lib/php/functions.php';

// Check user auth
$auth = new Controller_Users_Auth(array('table'=>'kpl_module_users_1'));
if (isset($auth->auth) && !isset($auth->auth->user)) {
    echo message('access_denied');
    die();
}


/*** Getting data ***/
if (!empty($_GET['dir'])) {
    $selected_dir = rawurldecode($_GET['dir']);
    setcookie ('dir', $selected_dir, time()+(60*60*24*30), '/');
} else {
    $selected_dir = isset($_COOKIE['dir']) ? $_COOKIE['dir'] : false;
}

$dirpath = $selected_dir ? $config['dirabs'] . substr($selected_dir,1) : $config['dirabs'];

if (isset($_GET['action'])) { // Ajax data
    switch($_GET['action']) {
        case 'files_list':
            if (file_exists($dirpath)) {
                $files = get_files($dirpath);
                include KFM_PATH . 'templates/files.php';
            } else {
                echo error('dir_not_exists');
            }
            break;
        case 'upload'; // From CKeditor
            if (isset($_FILES['upload'])) {
                $_FILES['qqfile'] = $_FILES['upload'];
            }
            require_once KFM_PATH . 'lib/php/qqUploadedFile.php';
            $uploader = new qqFileUploader($config['extensions']['allow'], $config['file_size_limit']);

            $result = $uploader->handleUpload($dirpath . '/');
            
            $message = '';
            $url = '';
            if (isset($result['success']) && !empty($result['file'])) {
                $url = substr($result['file'], strlen(KOPOLO_PATH)-1);
            } elseif(isset($result['error'])) {
                $message = $result['error'];
            }
            $funcNum = $_GET['CKEditorFuncNum'];
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', \"$message\");</script>";
            break;
        case 'upload_file'; // From KopoloFileManager
            require_once KFM_PATH . 'lib/php/qqUploadedFile.php';
            $uploader = new qqFileUploader($config['extensions']['allow'], $config['file_size_limit']);
            $result = $uploader->handleUpload($dirpath . '/');
            echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            break;
        default:
            echo error('undefined_action');
    }
    exit();
} else { // Default data
    
    /* List of directory */
    $tree = get_dir_array($config['dirabs']);

    /* Files of selected directory */
    if(file_exists($dirpath)) {
        $files = get_files($dirpath);
    }

    /* HTML */
    include 'templates/index.php';
}
