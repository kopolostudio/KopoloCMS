<?php
/**
 * Класс настроек модуля Controllers
 * 
 * @version 1.1 [22.11.2011]
 * @package Controllers
 */

class Module_Controllers_Config extends Kopolo_Module_Config
{
    /**
    * Название модуля
    * @var string
    */
    protected $module_name = 'Контроллеры';
 
    /**
    * Название позиции
    * @var string
    */
    protected $item_name = 'контроллер';
    
    /**
    * Комментарий о назначении модуля
    * @var string
    */
    protected $module_comment = 'Добавление, изменение, удаление контроллеров';
 
    /**
    * Поле с названием позиции
    * @var string
    */
    protected $name_field = 'cr_name';
    
    /**
    * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
    * 
    * @return array
    */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'cr_nick' => array (
                'quicktype' => 'text',
                'title' => 'Название класса',
                'actions' => array (
                    'list' => true
                )
            ),
            'cr_module' => array (
                'quicktype' => 'select',
                'title' => 'Модуль',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Modules',
                        'default' => 'нет'
                    )
                )
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
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(1, 'Авторизация', 'Controller_Users_Auth', 11);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(2, 'Стандартный интерфейс работы с модулями', 'Controller_Action', 5);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(3, 'Выбор сайта', 'Controller_Sites_Select', 8);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(14, 'Основное меню страниц', 'Controller_Pages_Menu', 1);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(15, 'Список изображений страницы', 'Controller_Pages_Gallery', 14);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(16, 'Архив новостей', 'Controller_News_Archive', 2);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(17, 'Последние новости', 'Controller_News_Last', 6);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(23, 'Проверка новых модулей (только в DEV_MODE)', 'Controller_Modules_CheckNew', 5);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(20, 'Поиск', 'Controller_Search', 15);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(22, 'Карта сайта', 'Controller_Pages_Map', 1);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(24, 'Генератор форм', 'Controller_Forms_Generator', 18);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(25, 'Меню админпанели', 'Controller_Sites_Menu', 8);",
            "INSERT INTO ".$table_name." (cr_id, cr_name, cr_nick, cr_module) VALUES(26, 'Главное меню модулей', 'Controller_Modules_Menu', 5);"
        );
        return $sql;
    }
}