<?php
/**
 * Модули
 *
 * управление модулями системы
 *
 * @author  kopolo.ru
 * @version 1.1 [27.05.2011]
 * @package Modules
 */

class Module_Modules extends Kopolo_Module //Kopolo_Tree_AdjacencyList
{
    /*** Base class properties ***/
    
    /**
    * Префикс свойств класса (полей)
    * @var string
    */
    public $__prefix = 'md_';
    
    /**
    * Мультиязычность
    * @var boolean
    */
    public $__multilang = false;
    
    /**
    * Мультисайтовость
    * @var boolean
    */
    public $__multisiting = false;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'has_many'   => array (
            'Module_Controllers' => 'md_id',
            'Module_Params'      => 'md_id',
            'Module_Users_Permissions' => 'md_id',
        ),
        /*'belongs_to' => array (
            'Module_Modules'     => 'md_parent'
        )*/
    );
    
    /*** Db fields (with specific prefix) ***/
    public $md_id;
    //public $md_parent;

    public $md_group;
    public $md_name;
    public $md_comment;

    public $md_nick;
    public $md_icon_group;
    public $md_is_active;
    public $md_in_menu;
    public $md_is_system;
    public $md_position;
    
    
    /**
     * Получение ID модуля по названию класса
     *
     * @param string полное название класса
     * @return integer
     */
    public static function getIDByClass($class) {
        $nick = substr($class, 7); //удаление "Module_"
        $module = new Module_Modules();
        $module->md_nick = $nick;
        $module->find(true);
        if (!empty($module->md_id)) {
            return $module->md_id;
        }
        return false;
    }
}