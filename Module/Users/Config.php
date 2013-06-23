<?php
/**
 * Класс настроек модуля Users
 * 
 * @version 0.1
 * @package Users
 */

class Module_Users_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Пользователи';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'Пользователь';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Добавление, изменение, удаление пользователей';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'us_group' => array (
                'quicktype' => 'select',
                'title' => 'Группа',
                'actions' => array (
                    'list' => array (
                        'editable' => true
                    ),
                ),
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Users_Groups',
                        'default' => 'Гости'
                    )
                ),
                'actions' => array (
                    'list' => array (
                        'editable' => true,
                        'sortable' => true
                    )
                )
            ),
            'us_name' => array (
                'type' => 'text',
                'length' => 100,
                'title' => 'Имя',
                'form' => array (
                    'type' => 'text',
                    'rules' => array(
                        'required' => 'Заполнение этого поля обязательно'
                    )
                ),
                'actions' => array (
                    'list' => array (
                        'editable' => true,
                        'sortable' => true
                    )
                )
            ),
            'us_login' => array (
                'type' => 'text',
                'length' => 50,
                'title' => 'Логин',
                'form' => array (
                    'type' => 'text',
                    'rules' => array(
                        'required' => 'Заполнение этого поля обязательно'
                    )
                ),
                'actions' => array (
                    'list' => array (
                        'editable' => true,
                        'sortable' => true
                    )
                )
            ),
            'us_password' => array (
                'type' => 'text',
                'length' => 50,
                'title' => 'Пароль',
                'form' => array (
                    'type' => 'password',
                    'rules' => array(
                        'required' => 'Заполнение этого поля обязательно'
                    )
                ),
            )
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
                "INSERT INTO ".$table_name." (us_id, us_name, us_login, us_password, us_is_active, us_group) VALUES(1, 'Администратор', 'admin', 'admin', 1, 1);",
                "INSERT INTO ".$table_name." (us_id, us_name, us_login, us_password, us_is_active, us_group) VALUES(2, 'Менеджер', 'manager', 'manager', 1, 2);"
            
            );
            return $sql;
        } else {
            /*Обычные сайты*/
            $sql = "";
            return $sql;
        }
    }
}