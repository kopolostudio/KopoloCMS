<?php

/**
 * Модуль компонентов
 *
 * @author  kopolo.ru
 * @version 0.1 [16.11.2010]
 * @package Components
 */

class Module_Components extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'com_';
    public $__multilang = true;
    public $__site_field = 'com_site';
    
    /*Db fields*/
    public $com_id;
    public $com_site;
    public $com_page;
    public $com_name;
    public $com_nick;
    public $com_controller;
    public $com_template;
    public $com_position;
    public $com_is_active;
    public $com_is_system;
    
    /**
     * Получение связей с другими модулями в формате массива с элеменами: тип связи, модуль, поле для связи
     * Возможные типы: belongs_to, has_one, has_many, many_to_many
     * 
     * @example array('has_many', 'Module_Images', 'pg_id')
     * @return array
    */
    public function getRelations()
    {
        $relations = array();
        
        $relations['has_many']['Module_Params'] = 'com_id';
        $relations['belongs_to']['Module_Sites'] = 'com_site';
        $relations['belongs_to']['Module_Controllers'] = 'com_controller';
        $relations['belongs_to']['Module_Templates'] = 'com_template';
        $relations['belongs_to']['Module_Pages'] = 'com_page';
        
        return $relations;
    }
}