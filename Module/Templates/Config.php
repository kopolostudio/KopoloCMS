<?php
/**
 * Класс настроек модуля Templates
 * 
 * @version 0.1
 * @package Templates
 */

class Module_Templates_Config extends Kopolo_Module_Config
{
    private $types = array (
        'component' => 'Компонент',
        'page' => 'Страница'
    );
    
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Шаблоны';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Добавление, изменение, удаление шаблонов';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'tpl_site' => array (
                'quicktype' => 'select',
                'default' => 2,
                'title' => 'Сайт',
                'default' => 2,
                'actions' => false
            ),
            'tpl_type' => array (
                'type' => 'text',
                'length' => 10,
                'title' => 'Тип',
                'default' => 'component',
                'form' => array (
                    'type' => 'select',
                    'options' => $this->types
                )
            ),
            'tpl_path' => array (
                'quicktype' => 'text',
                'title' => 'Путь'
            )
        );
        return $definition;
    }
    
    /**
     * (non-PHPdoc)
     * @see Kopolo_Module_Config::getDefaultSQL()
     */
    public function getDefaultSQL($table_name)
    {
        $sql = array(
            "INSERT INTO ".$table_name." (tpl_id, tpl_site, tpl_type, tpl_name, tpl_path) VALUES(2, 1, 'component', 'Выбор сайта', 'sites/select.tpl');",
            "INSERT INTO ".$table_name." (tpl_id, tpl_site, tpl_type, tpl_name, tpl_path) VALUES(3, 2, 'component', 'Основное меню страниц', 'menu.tpl');",
            "INSERT INTO ".$table_name." (tpl_id, tpl_site, tpl_type, tpl_name, tpl_path) VALUES(13, 2, 'component', 'Галерея страниц', 'images.tpl');"
        );
        return $sql;
    }
}