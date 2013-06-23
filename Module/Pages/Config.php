<?php

/**
* Класс настроек модуля Pages
*
* @version 0.1
* @package Pages
*/

class Module_Pages_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Страницы';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'Страница';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Управление разделами и страницами сайта';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'pg_position ASC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'pg_name';
    
    /**
     * Вложенность
     * @var integer
     */
    protected $nesting = 2;
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     *
     * @return array
     */
    public function getQuickFieldsDefinition()
    {
        $definition = array (
            'pg_header' => array (
                'quicktype' => 'text',
                'title' => 'Заголовок'
            ),
            'pg_template' => array (
                'quicktype' => 'select',
                'title' => 'Шаблон',
                'actions' => array (
                    'list' => false
                ),
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Templates',
                        'value' => 'tpl_id',
                        'text'  => 'tpl_name',
                        'conditions' => array (
                            "tpl_type='page'",
                            ("tpl_site=" . Kopolo_Registry::get('site_id'))
                        ),
                        'default' => 'стандартный'
                    )
                )
            ),
            'pg_in_menu' => array (
                'quicktype' => 'checkbox',
                'title' => 'В меню'
            ),
            'pg_in_map' => array (
                'quicktype' => 'checkbox',
                'title' => 'В карте сайта',
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
            'title' => 'Изменение страницы'
        );
        $actions[] = array (
            'action' => 'delete',
            'name' => 'удалить<br/>',
            'title' => 'Удаление страницы'
        );
        
        if ($this->nesting > 1) {
            $actions[] = array (
                'action' => 'list',
                'name' => 'подразделы',
                'title' => 'Список подразделов',
                'module' => 'Module_Pages',
                'mode' => 'table',
                'nesting' => $this->nesting
            );
            $actions[] = array (
                'action' => 'add',
                'name' => 'добавить подраздел<br/>',
                'title' => 'Добавление подраздела',
                'module' => 'Module_Pages',
                'nesting' => $this->nesting
            );
        }
        
        $actions[] = array (
            'action' => 'list',
            'name' => 'изображения',
            'title' => 'Список изображений',
            'module' => 'Module_Gallery_Images',
            'params' => array ('img_parent_class' =>  $this->getModuleClass()),
            'icon' => 'photo'
        );
        $actions[] = array (
            'action' => 'add',
            'name' => 'добавить изображение<br/>',
            'title' => 'Добавление изображения',
            'module' => 'Module_Gallery_Images',
            'params' => array ('img_parent_class' =>  $this->getModuleClass())
        );
        
        $actions[] = array (
            'action' => 'list',
            'name' => 'компоненты',
            'title' => 'Список компонентов страницы',
            'module' => 'Module_Components',
            'icon' => 'bricks'
        );
        
        //действие разрешено только для администраторов
        $content = Kopolo_Registry::get('content');
        if (isset($content->auth['user']) && $content->auth['user']['us_group'] == 1) {
            $actions[] = array (
                'action' => 'add',
                'name' => 'добавить компонент<br/>',
                'title' => 'Добавление компонента на страницу',
                'module' => 'Module_Components'
            );
            /*
            $actions[] = array (
                'action' => 'list',
                'name' => 'формы',
                'title' => 'Список форм страницы',
                'module' => 'Module_Forms',
                'icon' => 'clipboard'
            );
            $actions[] = array (
                'action' => 'add',
                'name' => 'добавить форму',
                'title' => 'Добавление формы на страницу',
                'module' => 'Module_Forms'
            );
            */
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
            'title' => 'Список разделов'
        );
        $actions[] = array (
            'action' => 'add',
            'name' => 'добавить',
            'title' => 'Добавление страницы'
        );
        return $actions;
    }

    /**
     * (non-PHPdoc)
     * @see Kopolo_Module_Config::getDefaultSQL()
     */
    function getDefaultSQL($table_name,$site_id)
    {
        if ($site_id == 1) {
            /*Админка*/
            $sql = array(
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_template, pg_last_modified, pg_in_map, pg_is_system) VALUES (1, 0, 'Главная', 'Добро пожаловать в систему управления сайтом', '<p>\r\n	Для управления сайтом используйте меню.<br />\r\n	Справку по работе с системой управления можно посмотреть в разделе &laquo;<a href=\"/admin/help/\">Помощь</a>&raquo;.</p>\r\n', 'first', 1, 'Заголовок', 'Ключевые слова', 'Описание', 1, 1, 0, '2011-07-22 21:42:56', 1, 0);",
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_template, pg_last_modified, pg_in_map, pg_is_system) VALUES (3, 0, 'Модули', '', '', 'module', 1, '', '', NULL, 3, 1, 0, NULL, 1, 0);",
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_template, pg_last_modified, pg_in_map, pg_is_system) VALUES (2, 0, 'Ошибка 404', 'Страница не найдена', 'Запрошенная вами страница не найдена на сайте. Возможно, страница была удалена или вы неправильно ввели адрес страницы в браузере. Для поиска нужной информации воспользуйтесь навигацией, поиском или картой сайта.', 'error404', 0, NULL, NULL, NULL, 2, 1, 0, NULL, 1, 0);",
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_template, pg_last_modified, pg_in_map, pg_is_system) VALUES (5, 0, 'Помощь', 'Руководство пользователя Kopolo.CMS', '<div class=\"help\">\r\n	<p>\r\n		Перейдите в интересующий вас раздел для получения справки по использованию возможностей системы:</p>\r\n	<ul>\r\n		<li>\r\n			<a href=\"#pages-short\">Управление страницами сайта, кратко</a>\r\n			<ul>\r\n				<li>\r\n					<a href=\"#pages-short-add\">Добавление новой страницы</a></li>\r\n				<li>\r\n					<a href=\"#pages-short-edit\">Редактирование страницы</a></li>\r\n				<li>\r\n					<a href=\"#pages-short-list\">Список страниц</a>\r\n					<ul>\r\n						<li>\r\n							<a href=\"#pages-short-listactions\">Основные действия, доступные в списке страниц</a></li>\r\n					</ul>\r\n				</li>\r\n			</ul>\r\n		</li>\r\n		<li>\r\n			<a href=\"#pages\">Управление страницами сайта, подробно</a>\r\n			<ul>\r\n				<li>\r\n					<a href=\"#pages-add\">Добавление новой страницы</a>\r\n					<ul>\r\n						<li>\r\n							<a href=\"#pages-add-main\">Основные данные страницы</a></li>\r\n						<li>\r\n							<a href=\"#pages-add-system\">Служебные поля</a></li>\r\n					</ul>\r\n				</li>\r\n				<li>\r\n					<a href=\"#pages-list\">Список страниц</a>\r\n					<ul>\r\n						<li>\r\n							<a href=\"#pages-edit\">Редактирование страницы</a></li>\r\n					</ul>\r\n				</li>\r\n			</ul>\r\n		</li>\r\n	</ul>\r\n	<div class=\"content\" style=\"width: 800px;\">\r\n		<h1>\r\n			<a name=\"pages-short\">Управление страницами сайта, кратко</a></h1>\r\n		<h2>\r\n			<a name=\"pages-short-add\">Добавление новой страницы</a></h2>\r\n		<p>\r\n			<img src=\"/Files/admin/help/pages-short-add.jpg\" /><br />\r\n			Поле &laquo;<b>Псевдоним</b>&raquo; является изменяемой частью адреса страницы, например, для страницы о компании можно ввести псевдоним <b>about</b>, соответственно полный адрес этой страницы будет выглядеть следующим образом: http://site.ru/<b>about</b>/</p>\r\n		<p>\r\n			Поле &laquo;<b>Псевдоним</b>&raquo; является обязательным для заполнения &ndash; страница без адреса существовать не может.</p>\r\n		<p>\r\n			Страница появится на сайте только после того, как будет нажата кнопка &laquo;<b>добавить</b>&raquo;.</p>\r\n		<p>\r\n			Для того, чтобы вернуться к списку страниц сайта нажмите<br />\r\n			<img src=\"/Files/admin/help/pages.jpg\" /> или <img src=\"/Files/admin/help/pages-2.jpg\" /></p>\r\n		<h2>\r\n			<a name=\"pages-short-edit\">Редактирование страницы</a></h2>\r\n		<p>\r\n			<img src=\"/Files/admin/help/pages-short-edit.jpg\" /><br />\r\n			Форма редактирования содержит те же самые поля, что и форма добавления.</p>\r\n		<p>\r\n			Все изменения будут сохранены только после того, как вы нажмете кнопку &laquo;<b>Обновить</b>&raquo;</p>\r\n		<h2>\r\n			<a name=\"pages-short-list\">Список страниц</a></h2>\r\n		<p>\r\n			Ссылка на список страниц всегда доступна из главного меню системы:<br />\r\n			<img src=\"/Files/admin/help/pages.jpg\" /></p>\r\n		<p>\r\n			Список страниц представлен в виде таблицы, каждая строка которой содержит информацию о странице и возможные действия.</p>\r\n		<h3>\r\n			<a name=\"pages-short-listactions\">Основные действия, доступные в списке страниц</a></h3>\r\n		<p>\r\n			<img src=\"/Files/admin/help/edit_button.jpg\" /> - Переход к форме редактирования страницы</p>\r\n		<p>\r\n			<img src=\"/Files/admin/help/delete_button.jpg\" /> - Удаление страницы. При попытке удаления страницы будет запрошено подтверждение, во избежание досадных случайностей.</p>\r\n		<p>\r\n			<img src=\"/Files/admin/help/number.jpg\" />(числа в столбце &laquo;позиция&raquo;) &ndash; характеризует положение ссылки на страницу в главном меню сайта. При клике по этому числу появится список, позволяющий изменить позицию страницы. Изменения позиции будут применены после нажатия кнопки <img src=\"/Files/admin/help/go.jpg\" /></p>\r\n		<p>\r\n			<img src=\"/Files/admin/help/display.jpg\" /> / <img src=\"/Files/admin/help/hidden.jpg\" /> - информирует о том, будет ли соответствующая страница отображаться в главном меню сайта или нет. Если кликнуть по этой ссылке, то статус отображения будет изменен на противоположный, после подтверждения</p>\r\n		<p>\r\n			<img src=\"/Files/admin/help/active.jpg\" /> / <img src=\"/Files/admin/help/inactive.jpg\" /> - информирует о том, можно ли попасть на эту страницу. Если у страницы установлен статус &laquo;Не активен&raquo;, то на эту страницу нельзя будет попасть ни кликнув по ссылке, ни набрав адрес этой страницы в адресной строке &ndash; будет выведено сообщение о том, что такая страница не существует. Если кликнуть по этой ссылке, то статус доступности будет изменен на противоположный, после подтверждения.</p>\r\n		<h1>\r\n			<a name=\"pages\">Управление страницами сайта, подробно</a></h1>\r\n		<p>\r\n			Для того чтобы попасть в раздел редактирования страниц сайта необходимо кликнуть по ссылке &laquo;страницы&raquo; в главном меню системы управления, ссылка отмечена оранжевым кружком на рис.1</p>\r\n		<center>\r\n			<img src=\"/Files/admin/help/menu_pages.jpg\" /><br />\r\n			Рис. 1. главное меню сайта</center>\r\n		<h2>\r\n			<a name=\"pages-add\">Добавление новой страницы</a></h2>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src=\"/Files/admin/help/pages_list.jpg\" /><br />\r\n			Рис. 2. раздел &laquo;Страницы&raquo;</center>\r\n		<p>\r\n			Для того, чтобы добавить новую страницу (раздел) необходимо кликнуть по ссылке &laquo;добавить раздел&raquo;( ссылка отмечена оранжевым кружком на рис. 2), в результате откроется форма добавления страницы.</p>\r\n		<p>\r\n			<a name=\"pages-add-1\"></a>Форма добавления страницы состоит из полей с основными данными (см. рис. 3.) и полей со служебными данными (см. рис. 4.)</p>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src=\"/Files/admin/help/add_page_main.jpg\" /><br />\r\n			рис. 3. основные данные страницы</center>\r\n		<h3>\r\n			<a name=\"pages-add-main\">Основные данные страницы</a></h3>\r\n		<ol>\r\n			<li>\r\n				<b>Название (в меню)</b><br />\r\n				В это поле вводится текст, который будет отображен в главном меню сайта в качестве ссылки на соответствующую страницу. Как правило, название для меню дается короткое в одно-два слова, более развернутое название можно указать в заголовке страницы</li>\r\n			<li>\r\n				<b>Заголовок</b><br />\r\n				Текст, который будет отображен в качестве заголовка соответствующей страницы</li>\r\n			<li>\r\n				<b>Информация</b><br />\r\n				Текстовая информация, которая будет представлена на странице (контент).<br />\r\n				Поле редактирования текста страницы реализовано в виде WYSIWYG редактора, который позволяет форматировать текст, подобно текстовому редактору MS Word.</li>\r\n		</ol>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src=\"/Files/admin/help/add_page_system.jpg\" /><br />\r\n			рис. 4. служебные данные страницы</center>\r\n		<h3>\r\n			<a name=\"pages-add-system\">Служебные поля</a></h3>\r\n		<ol>\r\n			<li>\r\n				<b>Псевдоним</b><br />\r\n				Псевдоним страницы &ndash; это часть адреса по которому страница будет доступна в сети Интернет. Например, для страницы о компании можно ввести псевдоним <b>about</b>, соответственно полный адрес этой страницы будет выглядеть следующим образом:<br />\r\n				http://{\$smarty.server.SERVER_NAME}/<b>about</b>/<br />\r\n				Это поле является единственным обязательным для страницы, потому что страница не может существовать без адреса.</li>\r\n			<li>\r\n				<b>Показывать в меню</b><br />\r\n				Если этот флаг установлен, то страница будет отображена в главном меню сайта.</li>\r\n			<li>\r\n				<b>title, keywords, description</b><br />\r\n				Специальные поля для SEO-оптимизации.</li>\r\n			<li>\r\n				<b>Позиция</b><br />\r\n				В этом списке можно указать какой по счету будет идти эта страница в меню</li>\r\n			<li>\r\n				<b>Активность</b><br />\r\n				Если этот флаг не установлен, то на эту страницу будет невозможно попасть. Эту опцию полезно использовать когда страница находится в разработке.</li>\r\n		</ol>\r\n		<p>\r\n			Заполнив все вышеперечисленные поля можно нажать кнопку &laquo;добавить&raquo; и страница будет добавлена на сайт.</p>\r\n		<p>\r\n			Если вы все сделали правильно, вы окажетесь на странице редактирования страницы. Заголовок &laquo;Добавление раздела&raquo; изменится на &laquo;Редактирование раздела&raquo;, а кнопка &laquo;добавить&raquo; изменится на кнопку &laquo;обновить&raquo;.</p>\r\n		<p>\r\n			На рис. 5. приведен пример заполнения формы создания новой страницы:</p>\r\n		<center>\r\n			<img src=\"/Files/admin/help/add_page_full.jpg\" /><br />\r\n			рис. 5. пример заполнения формы создания новой страницы</center>\r\n		<h2>\r\n			<a name=\"pages-list\">Список страниц</a></h2>\r\n		<p>\r\n			Для того, чтобы из раздела редактирования или добавления страницы снова попасть в раздел системы со списком страниц сайта необходимо кликнуть по ссылке &laquo;разделы&raquo; отмеченную оранжевым кружком на рис. 6.</p>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src=\"/Files/admin/help/page_menu.jpg\" /><br />\r\n			рис. 6.</center>\r\n		<p>\r\n			Список разделов представлен в виде таблицы (см рис. 7.). Каждая строка таблицы содержит информацию об одной странице (разделе) сайта. Таблица состоит из следующих столбцов:</p>\r\n		<ul>\r\n			<li>\r\n				действия</li>\r\n			<li>\r\n				название (в меню)</li>\r\n			<li>\r\n				псевдоним (элемент адреса)</li>\r\n			<li>\r\n				позиция и вкл./выкл. (управление видимостью страницы)</li>\r\n		</ul>\r\n		все эти свойства были описаны, когда мы рассматривали добавление новой страницы.\r\n		<p>\r\n			<a name=\"pages-edit\"></a>В столбце <b>действия</b> доступны действия, которые можно совершить с этой страницей, наиболее часто используемым действием является действие &laquo;<b>изменить</b>&raquo; отмеченное на рис. 7. оранжевым кружком. Кликнув по этой ссылке, вы попадаете в <i><nobr><b>форму редактирования страницы</b></nobr>, которая полностью аналогична &nbsp;<a href=\"#pages-add-1\">форме добавления страницы</a></i> (см. рис.5), за тем исключением, что вы редактируете данные уже существующей страницы. Изменения вносятся на сайт только после того, как будет нажата кнопка &laquo;Обновить&raquo;</p>\r\n		<p>\r\n			В столбце <b>позиция</b> отображается, какой по счету будет отображаться ссылка на раздел в главном меню. Кликнув по номеру позиции (рис. 7., синий кружок) вы увидите список доступных позиций (рис. 8.). Если выбрать новую позицию и кликнуть по зеленой кнопке рядом со списком, то порядок страниц изменится &ndash; вы сразу увидите результат. Этот метод несколько нагляднее, чем редактирование позиции страницы через форму редактирования.</p>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src=\"/Files/admin/help/pages_list_2.jpg\" /><br />\r\n			рис. 7. Список страниц</center>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src=\"/Files/admin/help/sort.jpg\" /><br />\r\n			рис. 7. Редактирование позиции страницы</center>\r\n		<p>\r\n			В столбце <b>вкл./выкл.</b> (рис. 8., зеленый кружок) выведена информация об отображении страницы. Для ускорения считывания информация продублирована цветом &ndash; если страница не отображается в меню или не активна, то соответствующая ссылка будет красного цвета. Кликнув по ссылке можно сменить параметр отображения на противоположный. Например, если кликнуть по зеленой ссылке &laquo;отображается в меню&raquo; - страница перестанет отображаться в меню, цвет ссылки и текст изменятся на &laquo;Не отображается в меню&raquo;</p>\r\n	</div>\r\n</div>', 'help', 1, NULL, NULL, NULL, 5, 1, 0, NULL, 1, 0);",
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_template, pg_last_modified, pg_in_map, pg_is_system) VALUES (6, 0, 'Список модулей', 'Модули сайта', NULL, 'modules', 1, NULL, NULL, NULL, 4, 1, 0, '2011-05-19 22:05:21', 1, 0);"
            );
            return $sql;
        } else {
            /*Обычные сайты*/
            $sql = array(
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_last_modified, pg_template, pg_in_map, pg_is_system) VALUES(1, 0, 'Главная', 'Добро пожаловать!', '<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href=\"http://kopolocms.ru\">KopoloCMS</a>. Для управления сайтом войдите в административную панель.</p>', 'first', 1, NULL, NULL, NULL, 1, 1, '2011-06-20 14:13:13', 0, 1, 0);",
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_last_modified, pg_template, pg_in_map, pg_is_system) VALUES(2, 0, 'Ошибка 404', 'Страница не найдена', '<p>\r\n	Запрошенная вами страница не найдена на сайте. Возможно, страница была удалена или вы неправильно ввели адрес страницы в браузере. Для поиска нужной информации воспользуйтесь навигацией, поиском или картой сайта.</p>', 'error404', 0, NULL, NULL, NULL, 2, 1, '2011-05-19 14:37:28', 0, 0, 0);",
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_last_modified, pg_template, pg_in_map, pg_is_system) VALUES(5, 0, 'Поиск', 'Результаты поиска', NULL, 'search', 0, NULL, NULL, NULL, 6, 1, NULL, 0, 1, 0);",
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_last_modified, pg_template, pg_in_map, pg_is_system) VALUES(4, 0, 'Контакты', 'Контактная информация', '', 'contacts', 1, NULL, NULL, NULL, 5, 1, '2011-05-19 14:11:04', 0, 1, 0);",
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_last_modified, pg_template, pg_in_map, pg_is_system) VALUES(3, 0, 'Новости', 'Новости', NULL, 'news', 1, NULL, NULL, NULL, 3, 1, '2011-05-19 14:11:04', 0, 1, 0);",
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_last_modified, pg_template, pg_in_map, pg_is_system) VALUES(6, 0, 'Карта сайта', 'Карта сайта', NULL, 'map', 0, NULL, NULL, NULL, 7, 1, '2011-05-19 14:37:06', 0, 0, 0);",
            "INSERT INTO ".$table_name." (pg_id, pg_parent, pg_name, pg_header, pg_info, pg_nick, pg_in_menu, pg_title, pg_keywords, pg_description, pg_position, pg_is_active, pg_last_modified, pg_template, pg_in_map, pg_is_system) VALUES(7, 0, 'Напишите нам', 'Обратная связь', '<p>\r\n	Для связи с представителем компании заполните пожалуйста форму.</p>', 'feedback', 1, NULL, NULL, NULL, 4, 1, '2011-06-15 13:36:31', 0, 1, 0);"
            );
            return $sql;
        }
    }
}