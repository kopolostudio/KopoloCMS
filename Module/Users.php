<?php

/**
 * Модуль пользователей
 *
 * @author  kopolo.ru
 * @version 0.1 [16.11.2010]
 * @package Users
 */

class Module_Users extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'us_';
    public $__multilang = false;
    public $__multisiting = true;
    public $__table = 'kpl_module_users_1';
    
    /**
     * Вероятно пользователей админки нужно будет переименовать в Admins или что-то типа этого
     * Они в свою очередь будут наследовать от этого модуля
     */
    
    /*Db fields*/
    public $us_id;
    public $us_group;
    public $us_name;
    public $us_login;
    public $us_password;
    public $us_is_active;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'belongs_to' => array (
            'Module_Users_Groups' => 'us_group'
        )
    );
}