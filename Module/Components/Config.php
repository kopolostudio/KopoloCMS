<?php
/**
 * Класс настроек модуля Components
 * 
 * @version 0.1
 * @package Components
 */

class Module_Components_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Компоненты';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'Компонент';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Добавление новых компонентов, изменение существующих';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'com_position ASC';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array ();
        /*$definition['com_info'] = array (
            'quickfield' => 'info',
            'multilang'=>true
        );*/
        /*$definition['com_name'] = array (
            'quickfield' => 'name',
            'multilang'=>false
        );*/
        $definition['com_nick'] = array (
            'quickfield' => 'nick',
            'default' => 'content',
            'actions' => array('list' => array('editable' => true)),
            'form' => array (
                'comment' => 'название переменной в шаблоне, content - по умолчанию выведется после основного содержимого страницы<br/>возможно использование только латинских букв, цифр и нижнего подчеркивания',
                'rules' => array(
                    'required' => 'Заполнение этого поля обязательно',
                    'regex' => array(
                        'message'=>'Недопустимые символы',
                        'options'=>'/^[a-z0-9_]+$/'
                    ),
                )
            ),
        );
        $definition['com_site'] = array (
            'quicktype' => 'select',
            'default' => 2,
            'title' => 'Сайт',
            'default' => 2,
            'actions' => false
        );
        $definition['com_page'] = array (
            'quicktype' => 'select',
            'title' => 'Страница',
            'form' => array (
                'options' => false,
                'getoptions' => array (
                    'class' => 'Module_Pages',
                    'default' => 'общий'
                )
            ),
            'actions' => false
        );
        $definition['com_controller'] = array (
            'quicktype' => 'select',
            'title' => 'Контроллер',
            'actions' => array('list' => array('editable' => true)),
            'form' => array (
                'options' => false,
                'getoptions' => array (
                    'class' => 'Module_Controllers',
                    'default' => 'нет'
                )
            )
        );
        $definition['com_template'] = array (
            'quicktype' => 'select',
            'title' => 'Шаблон',
            'actions' => false,
            'form' => array (
                'options' => false,
                'getoptions' => array (
                    'class' => 'Module_Templates',
                    'conditions' => array (
                        "tpl_type='component'",
                        ("tpl_site=" . Kopolo_Registry::get('site_id'))
                    ),
                    'default' => 'стандартный'
                )
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
        $actions = parent::getForEachActions();
        $actions[] = array (
            'module' => 'Module_Params',
            'action' => 'list',
            'name' => 'настройки',
            'title' => 'Список настроек компонента',
            'icon' => 'settings'
        );
        $actions[] = array (
            'module' => 'Module_Params',
            'action' => 'add',
            'name' => 'добавить настройку',
            'title' => 'Добавление настройки'
        );
        return $actions;
    }
    
    /**
     * Общие действия
     * 
     * @return array
     */
    public function getActions()
    {
        $actions[] = array (
            'action' => 'list',
            'name' => 'список',
            'title' => 'Список компонентов',
            'icon' => 'bricks'
        );
        
        //действие разрешено только для администраторов
        $content = Kopolo_Registry::get('content');
        if (isset($content->auth['user']) && $content->auth['user']['us_group'] == 1) {
            $actions[] = array (
                'action' => 'add',
                'name' => 'добавить компонент',
                'title' => 'Добавление компонента'
            );
        }
        return $actions;
    }
    

    /**
     * (non-PHPdoc)
     * @see Kopolo_Module_Config::getDefaultSQL()
     */
    function getDefaultSQL($table_name)
    {
        $sql = array(
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(1, 1, 0, 'Авторизация пользователей', 'auth', 1, 0, 1, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(2, 1, 3, 'Стандартный интерфейс работы с модулями', 'content', 2, 0, 3, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(3, 1, 0, 'Выбор сайта', 'site', 3, 2, 8, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(4, 2, 0, 'Основное меню страниц', 'menu', 14, 3, 9, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(14, 2, 0, 'Галерея: список изображений страницы', 'content', 15, 13, 10, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(15, 2, 3, 'Архив новостей', 'content', 16, 0, 7, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(16, 2, 0, 'Последние новости', 'last_news', 17, 0, 11, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(21, 2, 6, 'Карта сайта', 'content', 22, 0, 2, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(22, 1, 6, 'Список модулей', 'content', 2, 0, 5, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(19, 2, 5, 'Поиск', 'content', 20, 0, 6, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(23, 1, 6, 'Проверка новых модулей', 'content', 23, 0, 4, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(24, 2, 0, 'Форма', 'content', 24, 0, 12, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(25, 1, 0, 'Верхнее меню', 'top_menu', 25, 0, 13, 1, 0);",
            "INSERT INTO ".$table_name." (com_id, com_site, com_page, com_name, com_nick, com_controller, com_template, com_position, com_is_active, com_is_system) VALUES(35, 1, 1, 'Меню модулей', 'content', 26, 0, 2, 1, 0);"        
        );
        return $sql;
    }
    
    /**
     * Дополнительные условия для выборки для действия list (список)
     * 
     * @return array
     */
    public function getActionConditionsList() {
        $conditions = array();
        
        //если запрошено не из страниц, то выводим только общие компоненты
        if (!isset($_GET['com_page'])) {
            $conditions[] = 'com_page=0';
        }
        
        return $conditions;
    }
}