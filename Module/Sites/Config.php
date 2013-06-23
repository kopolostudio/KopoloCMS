<?php
/**
 * Класс настроек модуля Sites
 * 
 * @version 0.1
 * @package Sites
 */

class Module_Sites_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Сайты';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'Сайт';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Добавление новых сайтов в систему, изменение существующих';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'st_domain ASC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'st_name';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition()
    {
        /* получение массива со списком тем, в котором ключи равны значениям (для записи в БД из select) */
        $themes_list = Kopolo_FileSystem::getDirs(KOPOLO_PATH . '/Themes/');
        $themes = array_combine($themes_list, $themes_list);
        
        $definition = array (
            'st_domain' => array (
                'quicktype' => 'text',
                'title' => 'Домен'
            ),
            'st_theme' => array (
                'quicktype' => 'select',
                'type' => 'text',
                'length' => 255,
                'default' => 'default',
                'title' => 'Тема оформления',
                'form' => array (
                    'options' => $themes
                )
            ),
        );
        return $definition;
    }
    
    /**
     * Действия модуля (для всех позиций)
     * 
     * @return array
     */
    public function getActions()
    {
        $actions[] = array (
            'action' => 'list',
            'name' => 'список сайтов',
            'title' => 'Список сайтов'
        );
        
        if (defined('MULTISITING') && MULTISITING === true) {
            $actions[] = array (
                'action' => 'add',
                'name' => 'добавить сайт',
                'title' => 'Добавление сайта'
            );
        }
        return $actions;
    }
    
    /**
     * Действия для каждой позиции
     * 
     * @return array
     */
    public function getForEachActions()
    {
        $actions[] = array (
            'action' => 'edit',
            'name' => 'изменить',
            'title' => 'Изменение сайта'
        );
        $actions[] = array (
            'action' => 'delete',
            'name' => 'удалить<br/>',
            'title' => 'Удаление сайта'
        );
        
        $actions[] = array (
            'action' => 'list',
            'name' => 'меню',
            'title' => 'Список пунктов меню',
            'module' => 'Module_Sites_Menu'
        );
        $actions[] = array (
            'action' => 'add',
            'name' => 'добавить пункт меню<br/>',
            'title' => 'Добавление пункта меню',
            'module' => 'Module_Sites_Menu'
        );
        
        if (defined('MULTILANG') && MULTILANG === true) {
            $actions[] = array (
                'action' => 'list',
                'name' => 'языки',
                'title' => 'Список языков',
                'module' => 'Module_Sites_Langs'
            );
            $actions[] = array (
                'action' => 'add',
                'name' => 'добавить язык',
                'title' => 'Добавление языковой версии',
                'module' => 'Module_Sites_Langs'
            );
        }
        return $actions;
    }

    /**
     * (non-PHPdoc)
     * @see Kopolo_Module_Config::getDefaultSQL()
     */
    public function getDefaultSQL($table_name,$site_id=1)
    {
        $sql = array(
            "INSERT INTO ".$table_name." (st_id, st_name, st_domain, st_theme, st_is_active) VALUES(1, 'Административная панель', 'admin', 'Admin', 1);",
            "INSERT INTO ".$table_name." (st_id, st_name, st_domain, st_theme, st_is_active) VALUES(2, 'Сайт компании', 'companyname.ru', 'default', 1);"
        );
        return $sql;
    }
}