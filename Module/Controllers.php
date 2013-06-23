<?php

/**
 * Модуль контроллеров
 *
 * @author  kopolo.ru
 * @version 0.1 [16.11.2010]
 * @package Controllers
 */

class Module_Controllers extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'cr_';
    public $__multilang = false;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'belongs_to' => array (
            'Module_Modules' => 'cr_module'
        )
    );
    
    /*Db fields*/
    public $cr_id;
    public $cr_module;
    public $cr_name;
    public $cr_nick;
}