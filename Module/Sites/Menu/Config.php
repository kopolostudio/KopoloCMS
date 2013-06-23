<?php
/**
 * Класс настроек модуля Sites_Menu
 * 
 * @version 1.0
 * @package Sites
 * @subpackage Menu
 */

class Module_Sites_Menu_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Меню административного интерфейса сайта';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'пункт меню';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Управление административного интерфейса сайта';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'mn_position ASC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'mn_name';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition()
    {
        $definition = array (
            'mn_site' => array (
                'quickfield' => 'parent'
            ),
            'mn_picture' => array (
                'quickfield' => 'picture',
                'title' => 'Иконка',
                'actions' => array (
                    'list' => true
                )
            ),
            'mn_link' => array (
                'quicktype' => 'text',
                'title' => 'Ссылка',
                'form' => array (
                    'type' => 'text',
                    'rules' => array(
                        'required' => 'Заполнение этого поля обязательно'
                    )
                ),
                'actions' => array (
                    'list' => true
                )
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
        $sql = array(
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(1, 1, 'Страницы', '/Files/Sites/Menu/document.png', 1, 1, '/admin/module/Pages/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(2, 1, 'Настройки', '/Files/Sites/Menu/settings.png', 1, 2, '/admin/module/Params/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(3, 1, 'Пользователи', '/Files/Sites/Menu/admin.png', 1, 3, '/admin/module/Users/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(4, 1, 'Общие компоненты', '/Files/Sites/Menu/bricks.png', 1, 4, '/admin/module/Components/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(5, 1, 'Модули', '/Files/Sites/Menu/gear.png', 1, 5, '/admin/modules/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(6, 1, 'Контроллеры', '/Files/Sites/Menu/php.png', 1, 6, '/admin/module/Controllers/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(7, 1, 'Сайты', '/Files/Sites/Menu/globe.png', 1, 7, '/admin/module/Sites/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(8, 2, 'Страницы', '/Files/Sites/Menu/document.png', 1, 1, '/admin/module/Pages/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(9, 2, 'Новости', '/Files/Sites/Menu/bubble.png', 1, 2, '/admin/module/News/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(10, 2, 'Настройки', '/Files/Sites/Menu/settings.png', 1, 4, '/admin/module/Params/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(11, 2, 'Пользователи', '/Files/Sites/Menu/admin.png', 1, 5, '/admin/module/Users/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(12, 2, 'Общие компоненты', '/Files/Sites/Menu/bricks.png', 1, 6, '/admin/module/Components/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(13, 2, 'Модули', '/Files/Sites/Menu/gear.png', 1, 7, '/admin/modules/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(14, 2, 'Контроллеры', '/Files/Sites/Menu/php.png', 1, 8, '/admin/module/Controllers/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(15, 2, 'Сайты', '/Files/Sites/Menu/globe.png', 1, 9, '/admin/module/Sites/');",
            "INSERT INTO ".$table_name." (mn_id, mn_site, mn_name, mn_picture, mn_is_active, mn_position, mn_link) VALUES(16, 2, 'Сообщения с формы', '/Files/Sites/Menu/letter.png', 1, 3, '/admin/module/Pages/Forms/Forms_Senders/?action=list&sn_form=1');"
        );
        return $sql;
    }
}