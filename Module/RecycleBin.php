<?php
/**
 * Корзина
 *
 * хранение удаленных позиций
 *
 * @author  kopolo.ru
 * @version 1.0 [16.06.2011]
 * @package System
 * @package RecycleBin
 */

class Module_RecycleBin extends Kopolo_Module
{
    /*** Base class properties ***/
    public $__prefix = 'rb_';
    public $__multilang = false;
    public $__multisiting = false;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'belongs_to' => array (
            'Module_Modules'    => 'rb_module',
            'Module_Users'      => 'rb_user',
            'Module_RecycleBin' => 'rb_related_to',
        ),
        'has_many' => array (
            'Module_RecycleBin' => 'rb_id'
        )
    );
    
    /*** Db fields (with specific prefix) ***/
    public $rb_id;


    public $rb_action;
    public $rb_user;
    public $rb_datetime;
    public $rb_name;
    public $rb_module;
    public $rb_object;
    public $rb_related_to;
    
    /**
     * Добавление позиции в корзину
     * 
     * @param string  название действия (edit, delete)
     * @param string  название класса модуля
     * @param integer ID позиции модуля
     * @param integer ID пользователя, совершившего действие
     * @param integer ID связанной позиции корзины
     * 
     * @return integer ID добавленной позиции
     */
    public static function addObject($action, $module, $id, $user_id, $related_id=0) {
        if ($module != 'Module_RecycleBin') {
            $object = new $module;
            
            $module_config = $object->getConfigClass();
            $object_config = new $module_config;
            $name_field = $object_config->getNameField();
            $object->get($id);
            if ($object->N > 0) {
                $recyclebin = new Module_RecycleBin();
                $recyclebin->rb_action = $action;
                $recyclebin->rb_name = $object->$name_field;
                $recyclebin->rb_user = $user_id;
                $recyclebin->rb_datetime = time();
                $recyclebin->rb_module = Module_Modules::getIDByClass($module);
                $recyclebin->rb_object = serialize($object->toArray());
                $recyclebin->rb_related_to = $related_id;
                
                $insert_id = $recyclebin->insert();
                if ($insert_id) {
                    return $insert_id;
                }
            }
        }
        return false;
    }
    
    /**
     * Очистка корзины
     * 
     * @return boolean
     */
    public function clear() {
        $this->query('TRUNCATE TABLE `' . $this->__table . '`');
        return true;
    }
    
    
    /**
     * Получение общего числа объектов в корзине
     * 
     * @return integer
     */
    public function getTotalCount() {
        $this->query('SELECT count(*) AS total_count FROM `' . $this->__table . '`');
        $this->fetch();
        return $this->total_count;
    }
}