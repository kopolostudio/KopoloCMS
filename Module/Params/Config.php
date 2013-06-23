<?php
/**
 * Класс настроек модуля Params
 * 
 * @version 0.1
 * @package Params
 */

class Module_Params_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Настройки';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Изменение настроек сайта';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'pm_name' => array (
                'quickfield' => 'name',
                'multilang' => false,
                'actions' => array (
                    'list' => array (
                        'editable' => false
                    )
                )
            ),
            'pm_nick' => array (
                'quickfield' => 'nick',
                'actions' => array (
                    'list' => array (
                        'editable' => false
                    )
                )
            ),
            'pm_site' => array (
                'quicktype' => 'integer',
                'default' => 2,
                'actions' => false
            ),
            'pm_component' => array (
                'quicktype' => 'integer',
                'actions' => false
            ),
            'pm_value' => array (
                'quicktype' => 'text',
                'length' => 1000,
                'title' => 'Значение',
                'actions' => array (
                    'list' => array (
                        'editable' => true
                    )
                )
            ),
        );
        return $definition;
    }
    
    
    /**
     * Получение связей текущего модуля с родительскими модулями
     *
     * @return array название родительского модуля => поле текущего модуля (с префиксом)
     * например: 'catalog' => 'it_category'
     */
    public function getParents() {
        return array('Components' => 'pm_component');
    }
    
    /**
     * (non-PHPdoc)
     * @see Kopolo_Module_Config::getDefaultSQL()
     */
    function getDefaultSQL($table_name)
    {
        $sql = array(
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(1, 'Заголовок страниц (title) по умолчанию', 'html_title', '%pagename% - Заголовок по умолчанию', 2, 0);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(2, 'Ключевые слова (keywords) по умолчанию', 'html_keywords', 'Ключевые слова', 2, 0);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(3, 'Описание сайта (description) по умолчанию', 'html_description', 'Описание сайта', 2, 0);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(4, 'E-mail администратора сайта', 'admin_email', 'admin@site.ru', 2, 0);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(5, 'Заголовок страниц (title) по умолчанию', 'html_title', 'Система управления сайтом', 1, 0);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(6, 'Ключевые слова (keywords) по умолчанию', 'html_keywords', 'Ключевые слова', 1, 0);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(7, 'Описание сайта (description) по умолчанию', 'html_description', 'Описание сайта', 1, 0);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(8, 'E-mail администратора сайта', 'admin_email', 'name@site.ru', 1, 0);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(9, 'Таблица пользователей', 'table', 'kpl_module_users_1', 1, 1);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(19, 'Название компании', 'company_name', 'Companyname', 2, 0);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(20, 'Контакты (в подвале сайта)', 'contacts', 'Контакты', 2, 0);",
            "INSERT INTO ".$table_name." (pm_id, pm_name, pm_nick, pm_value, pm_site, pm_component) VALUES(21, 'Модуль', 'modules', 'Modules', 1, 22);"
        );
        return $sql;
    }
}