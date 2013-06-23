<?php
/**
 * Модуль страниц
 *
 * @author  kopolo.ru
 * @version 1.3 / 15.06.2011
 * @package System
 * @subpackage Pages
 */

class Module_Pages extends Kopolo_Tree_AdjacencyList
{
    /*Base class properties*/
    public $__prefix = 'pg_';
    public $__multilang = true;
    public $__multisiting = true;
    
    /*Db fields*/
    public $pg_id;
    public $pg_parent;

    public $pg_name;
    public $pg_header;
    //public $pg_picture;
    public $pg_info;

    public $pg_nick;
    public $pg_template;
    public $pg_is_active;
    public $pg_in_menu;
    public $pg_in_map;
    public $pg_position;

    public $pg_title;
    public $pg_keywords;
    public $pg_description;
    
    //public $pg_added;
    public $pg_last_modified;
    public $pg_is_system;
    
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
        
        $relations['has_many']['Module_Gallery_Images'] = 'pg_id';
        $relations['has_many']['Module_Pages'] = 'pg_id';
        $relations['has_many']['Module_Components'] = 'pg_id';
        $relations['has_many']['Module_Forms'] = 'pg_id';
        $relations['belongs_to']['Module_Pages'] = 'pg_parent';
        
        return $relations;
    }
}