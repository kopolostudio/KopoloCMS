<?php

/**
* Модуль альбомов галереи
* 
* @version 1.0 [17.02.2011]
*/

class Module_Gallery_Albums extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'al_';
    public $__multisiting = true;
    
    /*Db fields*/
    public $al_id;
    public $al_name;
    public $al_is_active;
    public $al_position;
    
    /**
     * Получение связей с другими модулями в формате массива с элеменами: тип связи, модуль, поле для связи
     * Возможные типы: belongs_to, has_one, has_many, many_to_many
     * 
     * @example array('has_many', 'Module_Gallery_Images', 'pg_id')
     * @return array
    */
    public function getRelations()
    {
        $relations = array();
        
        $relations['has_many']['Module_Gallery_Images'] = 'al_id';
        
        return $relations;
    }
}