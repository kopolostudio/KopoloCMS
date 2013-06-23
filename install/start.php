<?php
/**
 * Инсталлер системы
 *
 * @version 1 / 25.05.2011
 * @author kopolo.ru
 * @developers Andrey Kondratev [andr@kopolo.ru]
 */

require_once 'Installer.php';

$installer = new Kopolo_Installer();

if (empty($_POST)) {
    /*POST не пришел - первый шаг*/
    $step_template = 'templates/step1.php';
    
    if (is_file('../config.php') && filesize('../config.php')>500) {
        require 'templates/installed.php'; exit();
    }
    
    $all_requirements_pass = $installer->checkRequirements();
    $all_recommendations_pass = $installer->checkRecommendations();
    $requirements = $installer->getRequirements();
    $recommendations = $installer->getRecommendations();

} else {
    if (isset($_POST['db-name'])) {
        /*Пришел пост с параметрами базы данных - второй шаг*/
        
        if (is_file('../config.php') && filesize('../config.php')>500) {
            require 'templates/installed.php'; exit();
        }
        
        $step_template = 'templates/step2.php';
        $db_link = $installer->mysqlConnect();
        if ($db_link!=false) {
            /*Если удалось успешно соединиться - создадим конфиг*/
            $config_created = $installer->makeConfig();
            $db_connect_success = true;
        } else {
            $connection_status = $installer->connection_status;
            $db_connect_success = false;
            $config_created = false;
        }
        $dump_loaded = $installer->loadMysqlDump();
    }
}

require_once 'templates/global.php';