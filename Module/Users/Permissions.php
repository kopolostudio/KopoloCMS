<?php

/**
 * Права пользователей и групп пользователей
 *
 * @author  kopolo.ru
 * @version 1.0 [15.06.2011]
 * @package Users
 * @subpackage Permissions
 */

class Module_Users_Permissions extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'ps_';
    public $__multilang = false;
    public $__multisiting = true;
    public $__table = 'kpl_module_users_permissions_1';
    
    /*Db fields*/
    public $ps_id;
    public $ps_module;
    public $ps_item;
    public $ps_group;
    public $ps_user;
    public $ps_action_view;
    public $ps_action_addition;
    public $ps_action_change;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'has_many'   => array (
            'Module_Forms_Groups' => 'form_id'
        ),
        'belongs_to' => array (
            'Module_Modules' => 'ps_module'
        )
    );
    
    /**
     * Получение прав пользователя для доступа конкретного типа к позициям
     * 
     * @param string  тип доступа (view, addition, change)
     * @param string  название модуля
     * @param array   текущий пользователь (массив с данными объекта класса Module_Users)
     * 
     * @return array массив с ID разрешенных позиций
     */
    public function getPermissibleItems($action, $module_name, $user) 
    {
        $items = array();
        
        /* выбираем разрешения для пользователя, группы и всех */
        $this->whereAdd("ps_action_" . $action . "='1'");
        $this->whereAdd("ps_item != 0");
        $this->whereAdd("ps_user='" . $user['us_id'] . "' OR ps_group='" . $user['us_group'] . "' OR (ps_user=0 AND ps_group=0)");
        $modules = new Module_Modules();
        $this->joinAdd($modules);
        $this->whereAdd("md_nick='" . substr($module_name, 7) . "'"); /* ник модуля без 'Module_' */
        
        $this->find();
        if ($this->N > 0) {
            while ($this->fetch()) {
                $items[] = $this->ps_item;
            }
        }
        return $items;
    }
}