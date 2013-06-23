<?php

/**
 * Модуль групп пользователей
 *
 * @author  kopolo.ru
 * @version 0.1 [18.12.2010]
 * @package Users
 */

class Module_Users_Groups extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'gr_';
    public $__multilang = false;
    public $__multisiting = true;
    public $__table = 'kpl_module_users_groups_1';
    
    /*Db fields*/
    public $gr_id;
    public $gr_name;
    public $gr_is_active;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'has_many'   => array (
            'Module_Users' => 'gr_id'
        )
    );
}