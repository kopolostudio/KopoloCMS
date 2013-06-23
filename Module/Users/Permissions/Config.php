<?php
/**
 * Класс настроек модуля Users_Permissions
 * 
 * @version 0.1
 * @package Users
 * @subpackage Permissions
 */

class Module_Users_Permissions_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Разграничение прав пользователей';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'запись';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Управление правами доступа пользователей';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'ps_module' => array (
                'quicktype' => 'select',
                'title' => 'Модуль',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Modules'
                    )
                ),
                'actions' => array (
                    'list' => true
                )
            ),
            'ps_item' => array (
                'quicktype' => 'integer',
                'title' => 'Позиция',
                'actions' => array (
                    'list' => true
                )
            ),
            'ps_group' => array (
                'quicktype' => 'select',
                'title' => 'Группа',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Users_Groups',
                        'default' => 'все'
                    )
                ),
                'actions' => array (
                    'list' => true
                )
            ),
            'ps_user' => array (
                'quicktype' => 'select',
                'title' => 'Пользователь',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Users',
                        'default' => 'все'
                    )
                ),
                'actions' => array (
                    'list' => true
                )
            ),
            'ps_action_view' => array (
                'quicktype' => 'checkbox',
                'title' => 'Просмотр'
            ),
            'ps_action_addition' => array (
                'quicktype' => 'checkbox',
                'title' => 'Добавление'
            ),
            'ps_action_change' => array (
                'quicktype' => 'checkbox',
                'title' => 'Изменение'
            ),
        );
        return $definition;
    }
    
    /**
     * (non-PHPdoc)
     * @see Kopolo_Module_Config::getDefaultSQL()
     */
    public function getDefaultSQL($table_name,$site_id=1)
    {
        if ($site_id == 1) {
            /*Админка*/
            $sql = array(
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(1, 20, 8, 0, 0, 1, 0, 0);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(2, 20, 9, 0, 0, 1, 0, 0);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(3, 20, 10, 0, 0, 1, 0, 0);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(4, 20, 11, 1, 0, 1, 0, 0);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(5, 20, 12, 1, 0, 1, 0, 0);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(6, 20, 13, 1, 0, 1, 0, 0);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(7, 20, 14, 1, 0, 1, 0, 0);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(8, 20, 15, 1, 0, 1, 0, 0);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(9, 20, 16, 0, 0, 1, 0, 0);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(10, 20, 1, 1, 0, 1, 1, 1);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(11, 20, 2, 1, 0, 1, 1, 1);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(12, 20, 3, 1, 0, 1, 1, 1);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(13, 20, 4, 1, 0, 1, 1, 1);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(14, 20, 5, 1, 0, 1, 1, 1);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(15, 20, 6, 1, 0, 1, 1, 1);",
                "INSERT INTO ".$table_name." (ps_id, ps_module, ps_item, ps_group, ps_user, ps_action_view, ps_action_addition, ps_action_change) VALUES(16, 20, 7, 1, 0, 1, 1, 1);",
            );
            return $sql;
        } else {
            /*Обычные сайты*/
            $sql = "";
            return $sql;
        }
    }
}