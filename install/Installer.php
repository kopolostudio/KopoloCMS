<?php

/**
 * Инсталлер системы
 *
 * @version 1 / 25.05.2011
 * @author kopolo.ru
 * @developers Andrey Kondratev [andr@kopolo.ru]
 */

class Kopolo_Installer
{
    /**
     * Требования к серверу
     * @var array
     */
    public $requirements = array(
        'php_version'=>array(
            'required_value' => '5.2.4',
            'text' => 'PHP версии >= 5.2.4'
        ),
        'mysql_available'=>array(
            'text' => 'Поддержка MySQL'
        ),
        'config_writable'=>array(
            'text' => 'Возможность записи в config.php'
        ),
        'GD_enabled'=>array(
            'text' => 'Поддержка GD'
        ),
        'mbstring_enabled'=>array(
            'text' => 'Поддержка mbstring'
        ),
        'json_enabled'=>array(
            'text' => 'Поддержка JSON'
        )
    );
    
    /**
     * Рекомендованные настройки сервера
     * @var array
     */
    public $recommendations = array(
        'safe_mode'=>array(
            'text'=>'Safe Mode',
            'recommended'=>false
        ),
        'register_globals'=>array(
            'text'=>'Register Globals',
            'recommended'=>false
        ),
        'display_errors'=>array(
            'text'=>'Display Errors',
            'recommended'=>false
        )
    );
    
    /**
     * Статус соединения с БД
     * @var string;
     */
    public $connection_status = 'Соединение еще не устанавливалось';
    
    /**
     * Линк соединения с БД
     */
    public $db_link = false;
    
    /**
     * Проверка сервера совместимость с овновными требованиями системы
     * Возвращает true, если все ключевые требования соответствуют
     * @return boolean
     */
    public function checkRequirements()
    {
        // Проверка на PHP 5
        if (version_compare(PHP_VERSION, $this->requirements['php_version']['required_value'], '>=')) {
            $this->requirements['php_version']['pass'] = true;
        }
        
        // Подключен MySQL
        if (function_exists('mysql_connect')) {
            $this->requirements['mysql_available']['pass'] = true;
        }
        
        // Проверка возможности записи в config.php
        if (is_writable('../config.php') && is_file('../config.php')) {
            $this->requirements['config_writable']['pass'] = true;
        } elseif (!is_file('../config.php')) {
            $result = file_put_contents('../config.php', "<?php /* Пустой config.php */");
            if ($result != false && $result>10) {
                $this->requirements['config_writable']['pass'] = true;
            }
        }
        
        // Проверка наличия GD
        if (function_exists('gd_info')) {
            $gd_info = gd_info();
            if (
                (isset($gd_info['JPG Support']) && $gd_info['JPG Support'] == true) ||
                (isset($gd_info['JPEG Support']) && $gd_info['JPEG Support'] == true)
            ) {
                $this->requirements['GD_enabled']['pass'] = true;
            }
        }
        
        // Проверка наличия mbstring
        if (extension_loaded('mbstring')) {
            $this->requirements['mbstring_enabled']['pass'] = true;
        }
        
        // Проверка наличия JSON
        if (function_exists('json_encode') && function_exists('json_decode')) {
            $this->requirements['json_enabled']['pass'] = true;
        }
        
        //Проверка общего результата по требованиям
        $this->all_requirements_pass = true;
        foreach ($this->requirements as $requirement) {
            if ($requirement['pass']!=true) {
                $this->all_requirements_pass = false;
            }
        } 
        return $this->all_requirements_pass;
    }
    
    /**
     * Возвращает массив с требованиями
     * @return array
     */
    public function getRequirements()
    {
        if (!isset($this->all_requirements_pass)) {
            $this->checkRequirements();
        }
        return $this->requirements;
    }
    
    /**
     * Проверка системы на соответствие рекомендациям
     * Возвращает true, если все рекомендации соответствуют
     * @return boolean
     */
    public function checkRecommendations()
    {
        $this->recommendations['safe_mode']['value'] = (bool) ini_get('safe_mode');
        $this->recommendations['register_globals']['value'] = (bool) ini_get('register_globals');
        $this->recommendations['display_errors']['value'] = (bool) ini_get('display_errors');
        
        //Проверка общего результата по рекомендациям
        $this->all_recommendations_pass = true;
        foreach ($this->recommendations as $recommendation) {
            if ($recommendation['recommended']!=$recommendation['value']) {
                $this->all_recommendations_pass = false;
            }
        } 
        return $this->all_recommendations_pass;
    }
    
    /**
     * Возвращает массив с рекомендациями
     * @return array
     */
    public function getRecommendations()
    {
        if (!isset($this->all_recommendations_pass)) {
            $this->checkRecommendations();
        }
        return $this->recommendations;
    }
    
    /**
     * Создает конфигурационный файл config.php
     * Получает параметры соединения с БД из POST
     * Возвращает тру, в случае успешного создания конфига
     * @return boolean
     */
    public function makeConfig()
    {
        $config_sample = file_get_contents('../config_sample.php');
        $config_sample = preg_replace('/(!!!-.+-!!!)/s','',$config_sample);
        $config_sample = str_replace('db_username', $_POST['db-user'], $config_sample);
        $config_sample = str_replace('db_password', $_POST['db-password'], $config_sample);
        $config_sample = str_replace('@localhost/', '@'.$_POST['db-host'].'/', $config_sample);
        $config_sample = str_replace('db_name', $_POST['db-name'], $config_sample);
        $config_sample = str_replace("kpl_');", $_POST['db-prefix']."');", $config_sample);
        $result = file_put_contents('../config.php', $config_sample);
        if ($result != false && $result>10) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Соединение с базой данных
     * @return db_link
     */
    public function mysqlConnect()
    {
        $db_link = @mysql_connect($_POST['db-host'],$_POST['db-user'],$_POST['db-password']);
        if ($db_link!=false) {
            if (@!mysql_select_db($_POST['db-name'],$db_link)) {
                $this->connection_status = 'Соединение с сервером MySQL произошло успешно, но базы данных с именем '
                 .$_POST['db-name'].' не существует'
                 .'<br /><small>Код ошибки:'.mysql_error().'</small>';
                return false;
            }
        } else {
            $this->connection_status = 'Соединение с сервером MySQL не удалось, проверте параметры соединение с базой данных.'
             .'<br /><small>Код ошибки:'.mysql_error().'</small>';
            return false;
        }
        mysql_query('SET NAMES utf8',$db_link);
        $this->connection_status = 'Соединение установлено';
        $this->db_link = $db_link;
        return $db_link;
    }
    
    /**
     * Загружает MySQL дамп
     * @return boolean
     */
    public function loadMysqlDump()
    {
        if ($this->db_link == false) {
            $this->mysqlConnect();
        }
        if ($this->db_link != false) {
            $dump = file_get_contents('sql/default.sql');
            $queries = $this->explodeDump($dump);
            $errors_counter = 0;
            foreach ($queries as $query) {
                if (!empty($query)) {
                    $res = mysql_query($query,$this->db_link);
                    if ($res===false) {
                        $errors_counter++;
                    }
                }
            }
            if ($errors_counter==0) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Разбивает дамп на отдельные запросы
     * @param string - MySQL дамп
     * @return array - массив отдельных запросов
     */
    public function explodeDump($sql)
    {
        $sql = trim($sql);
        /*Уберем комменты*/
        $sql = preg_replace("/\n\--[^\n]*/", '', "\n".$sql);
        /*Подставим префикс таблиц*/
        $sql = str_replace('%db-prefix%', $_POST['db-prefix'], $sql);
        /*
         * Разобъем дамп на запросы, мы предполагаем, что строка запроса не может обрываться на символе ;
         * "\n" содержащиеся в запросе в виде обычного символа не обрабатываются  
         */
        $queries = explode(";\n", $sql);
        return $queries;
    }
}