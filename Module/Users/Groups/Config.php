<?php
/**
 * Класс настроек модуля Users_Groups
 * 
 * @version 0.1
 * @package Users
 */

class Module_Users_Groups_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Группы пользователей';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Управление группами пользователей';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
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
                "INSERT INTO ".$table_name." (gr_id, gr_name, gr_is_active) VALUES(1, 'Администраторы', 1);",
                "INSERT INTO ".$table_name." (gr_id, gr_name, gr_is_active) VALUES(2, 'Контент-менеджеры', 1);"
            );
            return $sql;
        } else {
            /*Обычные сайты*/
            $sql = "";
            return $sql;
        }
    }
}