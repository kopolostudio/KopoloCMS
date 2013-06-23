<?php

/**
* Класс настроек модуля Modules
* 
* @author  kopolo.ru
* @version 1.0 [19.05.2011]
* @package System
* @subpackage Modules
*/

class Module_Modules_Config extends Kopolo_Module_Config
{
    /**
     * Группы модулей
     * @var array
     */
    public static $groups = array(
        1 => 'Содержимое',
        2 => 'Оформление',
        3 => 'Администрирование',
        4 => 'Разработка',
        5 => 'Безопасность и восстановление данных',
        6 => 'Другое'
    );
    
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Модули';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'модуль';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Управление модулями системы';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'md_group ASC, md_position ASC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'md_name';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        /* получение массива со списком групп иконок, в котором ключи равны значениям (для записи в БД из select) */
        $icons_list = Kopolo_FileSystem::getDirs(KOPOLO_PATH_USER_FILES . 'admin/icons');
        $icons = array_combine($icons_list, $icons_list);
        
        $definition = array (
            'md_group' => array (
                'quicktype' => 'select',
                'default' => 1,
                'title' => 'Группа',
                'actions' => array('list' => array('editable' => true)),
                'form' => array (
                    'options' => self::$groups
                )
            ),
            'md_nick' => array (
                'type' => 'text',
                'length' => 255,
                'default' => null,
                'title' => 'Название класса',
                'form' => array (
                    'type' => 'text',
                    'comment' => 'без Module_',
                    'rules' => array(
                        'required' => 'Заполнение этого поля обязательно',
                        'regex' => array(
                            'message'=>'Недопустимые символы',
                            'options'=>'/^[A-Za-z0-9_-]+$/'
                        ),
                    )
                ),
                'actions' => array (
                    'list' => array (
                        'editable' => true
                    )
                )
            ),
            'md_comment' => array (
                'quicktype' => 'text',
                'title' => 'Назначение'
            ),
            'md_icon_group' => array (
                'quicktype' => 'select',
                'type' => 'text',
                'length' => 255,
                'title' => 'Иконка',
                'form' => array (
                    'comment' => 'название группы иконок',
                    'options' => $icons,
                    'default' => 'folder'
                )
            ),
            'md_is_system' => array (
                'quicktype' => 'checkbox',
                'title' => 'Системный'
            ),
            'md_in_menu' => array (
                'quicktype' => 'checkbox',
                'title' => 'В главном меню',
                'default' => 1
            )
        );
        return $definition;
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
            'title' => 'Изменение модуля'
        );
        $actions[] = array (
            'action' => 'delete',
            'name' => 'удалить<br/>',
            'title' => 'Удаление модуля'
        );
        /*
        $actions[] = array (
            'action' => 'list',
            'name' => 'подразделы',
            'title' => 'Список субмодулей',
            'module' => 'Module_Modules',
            'mode' => 'table',
            'nesting' => $this->nesting
        );
        $actions[] = array (
            'action' => 'add',
            'name' => 'добавить субмодуль<br/>',
            'title' => 'Добавление субмодуля',
            'module' => 'Module_Modules',
            'nesting' => $this->nesting
        );
        */
        
        //действие разрешено только для администраторов
        $content = Kopolo_Registry::get('content');
        if (isset($content->auth['user']) && $content->auth['user']['us_group'] == 1) {
            $actions[] = array (
                'action' => 'list',
                'name' => 'контроллеры',
                'title' => 'Список контроллеров модуля',
                'module' => 'Module_Controllers'
            );
            
            $actions[] = array (
                'action' => 'add',
                'name' => 'добавить контроллер',
                'title' => 'Добавление контроллера к модулю',
                'module' => 'Module_Controllers'
            );
        }
        return $actions;
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
            'name' => 'список',
            'title' => 'Список модулей'
        );
        $actions[] = array (
            'action' => 'add',
            'name' => 'добавить',
            'title' => 'Добавление модуля'
        );
        return $actions;
    }
    
    /**
     * (non-PHPdoc)
     * @see Kopolo_Module_Config::getDefaultSQL()
     */
    public function getDefaultSQL($table_name)
    {
       $sql = array(
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(1, 'Страницы', 'Управление страницами сайта', 'Pages', 1, 1, 1, 'document', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(2, 'Новости', 'Добавление и изменение новостей', 'News', 0, 12, 1, 'bubble', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(3, 'Компоненты', 'Добавление новых компонентов, изменение существующих', 'Components', 1, 2, 3, 'bricks', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(4, 'Контроллеры', 'Добавление, изменение, удаление контроллеров', 'Controllers', 1, 3, 4, 'php', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(5, 'Модули', 'Управление модулями системы', 'Modules', 1, 4, 3, 'gear', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(6, 'Настройки', 'Изменение настроек сайта', 'Params', 1, 5, 3, 'settings', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(7, 'Языковые версии сайта', 'Управление языковыми версиями сайта', 'Sites_Langs', 1, 7, 3, 'folder', 1, 0);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(8, 'Сайты', 'Добавление новых сайтов в систему, изменение существующих', 'Sites', 1, 6, 3, 'globe', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(9, 'Шаблоны', 'Добавление, изменение, удаление шаблонов', 'Templates', 1, 8, 2, 'folder', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(10, 'Группы пользователей', 'Управление группами пользователей', 'Users_Groups', 1, 10, 3, 'folder', 1, 0);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(11, 'Пользователи', 'Добавление, изменение, удаление пользователей', 'Users', 1, 9, 3, 'user', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(13, 'Галерея', 'Управление альбомами галереи изображений', 'Gallery_Albums', 1, 13, 1, 'folder', 1, 0);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(14, 'Изображения', 'Управление галереей изображений', 'Gallery_Images', 1, 14, 1, 'photo', 1, 0);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(15, 'Индекс поиска', 'Управление индексом поиска', 'Search_Index', 1, 11, 1, 'folder', 1, 0);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(16, 'Поля формы', 'Добавление и изменение полей формы', 'Forms_Fields', 0, 15, 1, 'folder', 1, 0);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(17, 'Группы полей формы', 'Добавление и изменение групп полей формы', 'Forms_Groups', 0, 16, 1, 'folder', 1, 0);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(18, 'Формы', 'Добавление и изменение форм отправки данных', 'Forms', 0, 17, 1, 'clipboard', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(19, 'Пользователи, ответившие на форму', 'Просмотр пользователей, которые отправили форму', 'Forms_Senders', 0, 18, 1, 'user', 1, 0);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(20, 'Меню административного интерфейса сайта', 'Управление административного интерфейса сайта', 'Sites_Menu', 0, 19, 1, 'bricks', 1, 0);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(21, 'Корзина', 'Удаленные позиции', 'RecycleBin', 1, 20, 5, 'trash', 1, 0);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(22, 'Разграничение прав', 'Управление правами доступа пользователей', 'Users_Permissions', 1, 21, 3, 'tick', 1, 1);",
            "INSERT INTO ".$table_name." (md_id, md_name, md_comment, md_nick, md_is_system, md_position, md_group, md_icon_group, md_is_active, md_in_menu) VALUES(23, 'Варианты ответа', 'Добавление и изменение вариантов ответа', 'Forms_Fields_Variants', 0, 22, 1, 'folder', 1, 0);"
       );
       return $sql; 
    }
}