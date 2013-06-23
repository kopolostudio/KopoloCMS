-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 01, 2011 at 02:41 PM
-- Server version: 5.1.40
-- PHP Version: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `kopolocms`
--

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_components`
--

CREATE TABLE IF NOT EXISTS `kpl_module_components` (
  `com_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `com_site` int(10) unsigned NOT NULL DEFAULT '2',
  `com_page` int(10) unsigned DEFAULT '0',
  `com_name` varchar(255) DEFAULT NULL,
  `com_nick` varchar(255) DEFAULT NULL,
  `com_controller` int(10) unsigned DEFAULT '0',
  `com_template` int(10) unsigned DEFAULT '0',
  `com_position` int(10) unsigned NOT NULL DEFAULT '0',
  `com_is_active` tinyint(1) NOT NULL DEFAULT '1',
  `com_is_system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`com_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Components (Компоненты)' AUTO_INCREMENT=38 ;

--
-- Dumping data for table `kpl_module_components`
--

INSERT INTO `kpl_module_components` (`com_id`, `com_site`, `com_page`, `com_name`, `com_nick`, `com_controller`, `com_template`, `com_position`, `com_is_active`, `com_is_system`) VALUES
(1, 1, 0, 'Авторизация пользователей', 'auth', 1, 0, 1, 1, 0),
(2, 1, 3, 'Стандартный интерфейс работы с модулями', 'content', 2, 0, 3, 1, 0),
(3, 1, 0, 'Выбор сайта', 'site', 3, 0, 2, 1, 0),
(4, 2, 0, 'Основное меню страниц', 'menu', 14, 0, 3, 1, 0),
(14, 2, 0, 'Галерея: список изображений страницы', 'content', 15, 0, 4, 1, 0),
(15, 2, 3, 'Архив новостей', 'content', 16, 0, 7, 1, 0),
(16, 2, 0, 'Последние новости', 'last_news', 17, 0, 5, 1, 0),
(21, 2, 6, 'Карта сайта', 'content', 22, 0, 2, 1, 0),
(22, 1, 6, 'Список модулей', 'content', 2, 0, 5, 1, 0),
(19, 2, 5, 'Поиск', 'content', 20, 0, 6, 1, 0),
(23, 1, 6, 'Проверка новых модулей', 'content', 23, 0, 4, 1, 0),
(24, 2, 0, 'Форма', 'content', 24, 0, 6, 1, 0),
(25, 1, 0, 'Верхнее меню', 'top_menu', 25, 0, 7, 1, 0),
(35, 1, 1, 'Меню модулей', 'content', 26, 0, 2, 1, 0),
(36, 1, 7, 'Выбор темы', 'content', 27, 0, 1, 1, 0),
(37, 2, 0, 'Текстовые блоки', 'content', 28, 0, 8, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_controllers`
--

CREATE TABLE IF NOT EXISTS `kpl_module_controllers` (
  `cr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cr_name` varchar(255) DEFAULT NULL,
  `cr_nick` varchar(255) DEFAULT NULL,
  `cr_module` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Controllers (Контроллеры)' AUTO_INCREMENT=29 ;

--
-- Dumping data for table `kpl_module_controllers`
--

INSERT INTO `kpl_module_controllers` (`cr_id`, `cr_name`, `cr_nick`, `cr_module`) VALUES
(1, 'Авторизация', 'Controller_Users_Auth', 11),
(2, 'Стандартный интерфейс работы с модулями', 'Controller_Action', 5),
(3, 'Выбор сайта', 'Controller_Sites_Select', 8),
(14, 'Основное меню страниц', 'Controller_Pages_Menu', 1),
(15, 'Список изображений страницы', 'Controller_Pages_Gallery', 14),
(16, 'Архив новостей', 'Controller_News_Archive', 2),
(17, 'Последние новости', 'Controller_News_Last', 6),
(23, 'Проверка новых модулей (только в DEV_MODE)', 'Controller_Modules_CheckNew', 5),
(20, 'Поиск', 'Controller_Search', 15),
(22, 'Карта сайта', 'Controller_Pages_Map', 1),
(24, 'Генератор форм', 'Controller_Forms_Generator', 18),
(25, 'Меню админпанели', 'Controller_Sites_Menu', 8),
(26, 'Главное меню модулей', 'Controller_Modules_Menu', 5),
(27, 'Выбор темы', 'Controller_Sites_SelectTheme', 0),
(28, 'Текстовые блоки', 'Controller_TextBlocks', 25);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_forms`
--

CREATE TABLE IF NOT EXISTS `kpl_module_forms` (
  `form_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_page` int(10) unsigned NOT NULL DEFAULT '0',
  `form_name` varchar(255) DEFAULT NULL,
  `form_comment` varchar(255) DEFAULT NULL,
  `form_action` varchar(255) DEFAULT NULL,
  `form_method` varchar(4) DEFAULT NULL,
  `form_submit_text` varchar(255) DEFAULT 'Отправить',
  `form_nick` varchar(255) DEFAULT NULL,
  `form_error_text` varchar(5000) DEFAULT 'Форма заполнена неверно, исправьте пожалуйста ошибки.',
  `form_save_answers` tinyint(1) NOT NULL DEFAULT '0',
  `form_send_to_email` varchar(255) DEFAULT NULL,
  `form_files_dir` varchar(255) DEFAULT ' ',
  `form_success_text` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Forms (Формы)' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kpl_module_forms`
--

INSERT INTO `kpl_module_forms` (`form_id`, `form_page`, `form_name`, `form_comment`, `form_action`, `form_method`, `form_submit_text`, `form_nick`, `form_error_text`, `form_save_answers`, `form_send_to_email`, `form_files_dir`, `form_success_text`) VALUES
(1, 7, 'Обратная связь', 'Форма обратной связи', NULL, 'post', 'Отправить', 'feedback', 'Форма заполнена неверно, исправьте пожалуйста ошибки.', 1, 'admin@site.ru', ' ', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_forms_fields`
--

CREATE TABLE IF NOT EXISTS `kpl_module_forms_fields` (
  `fd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fd_name` varchar(255) DEFAULT NULL,
  `fd_group` int(10) unsigned NOT NULL DEFAULT '0',
  `fd_form` int(10) unsigned NOT NULL DEFAULT '0',
  `fd_required` tinyint(1) NOT NULL DEFAULT '0',
  `fd_position` int(10) unsigned NOT NULL DEFAULT '1',
  `fd_type` varchar(255) NOT NULL DEFAULT '0',
  `fd_required_text` varchar(255) DEFAULT 'Поле обязательно для заполнения',
  PRIMARY KEY (`fd_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Forms_Fields (Поля формы)' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `kpl_module_forms_fields`
--

INSERT INTO `kpl_module_forms_fields` (`fd_id`, `fd_name`, `fd_group`, `fd_form`, `fd_required`, `fd_position`, `fd_type`, `fd_required_text`) VALUES
(1, 'Ваше имя', 0, 1, 0, 1, 'text', 'Поле обязательно для заполнения'),
(2, 'Введите цифры с картинки', 0, 1, 1, 4, 'captcha', 'Поле обязательно для заполнения'),
(3, 'E-mail или телефон для связи', 0, 1, 1, 2, 'text', 'Пожалуйста укажите контакт для связи'),
(4, 'Сообщение', 0, 1, 1, 3, 'textarea', 'Поле обязательно для заполнения'),
(5, 'Выпадающий список', 0, 1, 0, 5, 'select', 'Поле обязательно для заполнения'),
(6, 'Флажок', 0, 1, 0, 6, 'checkbox', 'Поле обязательно для заполнения'),
(7, 'Файл', 0, 1, 0, 7, 'file', 'Поле обязательно для заполнения');

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_forms_fields_variants`
--

CREATE TABLE IF NOT EXISTS `kpl_module_forms_fields_variants` (
  `vt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vt_field` int(10) unsigned NOT NULL DEFAULT '0',
  `vt_value` varchar(255) DEFAULT NULL,
  `vt_position` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`vt_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Forms_Fields_Variants (Варианты ответа' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `kpl_module_forms_fields_variants`
--

INSERT INTO `kpl_module_forms_fields_variants` (`vt_id`, `vt_field`, `vt_value`, `vt_position`) VALUES
(1, 5, 'вариант 1', 1),
(2, 5, 'вариант 2', 2),
(3, 5, 'вариант 3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_forms_groups`
--

CREATE TABLE IF NOT EXISTS `kpl_module_forms_groups` (
  `gr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gr_name` varchar(255) DEFAULT NULL,
  `gr_form` int(10) unsigned NOT NULL DEFAULT '0',
  `gr_position` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`gr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Forms_Groups (Группы полей формы)' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kpl_module_forms_groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_forms_senders`
--

CREATE TABLE IF NOT EXISTS `kpl_module_forms_senders` (
  `sn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sn_form` int(10) unsigned NOT NULL DEFAULT '0',
  `sn_date` int(10) unsigned NOT NULL DEFAULT '0',
  `sn_ip` varchar(255) DEFAULT NULL,
  `sn_answer` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`sn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Forms_Senders (Пользователи, ответивши' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kpl_module_forms_senders`
--


-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_forms_senders_answers`
--

CREATE TABLE IF NOT EXISTS `kpl_module_forms_senders_answers` (
  `an_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `an_sender` int(10) unsigned NOT NULL DEFAULT '0',
  `an_field` int(10) unsigned NOT NULL DEFAULT '0',
  `an_value` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`an_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Forms_Senders_Answers (Ответы)' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kpl_module_forms_senders_answers`
--


-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_gallery_images_2`
--

CREATE TABLE IF NOT EXISTS `kpl_module_gallery_images_2` (
  `img_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img_parent` int(10) unsigned NOT NULL DEFAULT '0',
  `img_album` varchar(255) DEFAULT '0',
  `img_name` varchar(255) DEFAULT NULL,
  `img_picture` varchar(255) DEFAULT NULL,
  `img_is_active` tinyint(1) NOT NULL DEFAULT '1',
  `img_position` int(10) unsigned NOT NULL DEFAULT '1',
  `img_module` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Gallery_Images (Изображения)' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `kpl_module_gallery_images_2`
--

INSERT INTO `kpl_module_gallery_images_2` (`img_id`, `img_parent`, `img_album`, `img_name`, `img_picture`, `img_is_active`, `img_position`, `img_module`) VALUES
(1, 24, '0', 'Пример изображения', '/Files/Gallery/Images/bs-42.jpg', 1, 1, 'Module_Pages'),
(3, 24, '0', NULL, '/Files/Gallery/Images/IMG_7819.jpg', 1, 3, 'Module_Pages'),
(4, 24, '0', 'Длинная длинная длиная подпись', '/Files/Gallery/Images/IMG_7611.jpg', 1, 4, 'Module_Pages'),
(5, 24, '0', NULL, '/Files/Gallery/Images/IMG_8313.jpg', 1, 2, 'Module_Pages');

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_modules`
--

CREATE TABLE IF NOT EXISTS `kpl_module_modules` (
  `md_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `md_name` varchar(255) DEFAULT NULL,
  `md_comment` varchar(255) DEFAULT NULL,
  `md_nick` varchar(255) DEFAULT NULL,
  `md_is_system` tinyint(1) NOT NULL DEFAULT '0',
  `md_position` int(10) unsigned NOT NULL DEFAULT '1',
  `md_group` int(10) unsigned NOT NULL DEFAULT '1',
  `md_icon_group` varchar(255) DEFAULT NULL,
  `md_is_active` tinyint(1) NOT NULL DEFAULT '1',
  `md_in_menu` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`md_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Modules (Модули)' AUTO_INCREMENT=26 ;

--
-- Dumping data for table `kpl_module_modules`
--

INSERT INTO `kpl_module_modules` (`md_id`, `md_name`, `md_comment`, `md_nick`, `md_is_system`, `md_position`, `md_group`, `md_icon_group`, `md_is_active`, `md_in_menu`) VALUES
(1, 'Страницы', 'Управление страницами сайта', 'Pages', 1, 1, 1, 'document', 1, 1),
(2, 'Новости', 'Добавление и изменение новостей', 'News', 0, 12, 1, 'bubble', 1, 1),
(3, 'Компоненты', 'Добавление новых компонентов, изменение существующих', 'Components', 1, 2, 3, 'bricks', 1, 1),
(4, 'Контроллеры', 'Добавление, изменение, удаление контроллеров', 'Controllers', 1, 3, 4, 'php', 1, 1),
(5, 'Модули', 'Управление модулями системы', 'Modules', 1, 4, 3, 'gear', 1, 1),
(6, 'Настройки', 'Изменение настроек сайта', 'Params', 1, 5, 3, 'settings', 1, 1),
(7, 'Языковые версии сайта', 'Управление языковыми версиями сайта', 'Sites_Langs', 1, 7, 3, 'folder', 1, 0),
(8, 'Сайты', 'Добавление новых сайтов в систему, изменение существующих', 'Sites', 1, 6, 3, 'globe', 1, 1),
(9, 'Шаблоны', 'Добавление, изменение, удаление шаблонов', 'Templates', 1, 8, 2, 'folder', 1, 1),
(10, 'Группы пользователей', 'Управление группами пользователей', 'Users_Groups', 1, 10, 3, 'folder', 1, 0),
(11, 'Пользователи', 'Добавление, изменение, удаление пользователей', 'Users', 1, 9, 3, 'user', 1, 1),
(13, 'Галерея', 'Управление альбомами галереи изображений', 'Gallery_Albums', 1, 13, 1, 'folder', 1, 0),
(14, 'Изображения', 'Управление галереей изображений', 'Gallery_Images', 1, 14, 1, 'photo', 1, 0),
(15, 'Индекс поиска', 'Управление индексом поиска', 'Search_Index', 1, 11, 1, 'folder', 1, 0),
(16, 'Поля формы', 'Добавление и изменение полей формы', 'Forms_Fields', 0, 15, 1, 'folder', 1, 0),
(17, 'Группы полей формы', 'Добавление и изменение групп полей формы', 'Forms_Groups', 0, 16, 1, 'folder', 1, 0),
(18, 'Формы', 'Добавление и изменение форм отправки данных', 'Forms', 0, 17, 1, 'clipboard', 1, 1),
(19, 'Пользователи, ответившие на форму', 'Просмотр пользователей, которые отправили форму', 'Forms_Senders', 0, 18, 1, 'user', 1, 0),
(20, 'Меню административного интерфейса сайта', 'Управление административного интерфейса сайта', 'Sites_Menu', 0, 19, 1, 'bricks', 1, 0),
(21, 'Корзина', 'Удаленные позиции', 'RecycleBin', 1, 20, 5, 'trash', 1, 0),
(22, 'Разграничение прав', 'Управление правами доступа пользователей', 'Users_Permissions', 1, 21, 3, 'tick', 1, 1),
(23, 'Варианты ответа', 'Добавление и изменение вариантов ответа', 'Forms_Fields_Variants', 0, 22, 1, 'folder', 1, 0),
(25, 'Текстовые блоки', 'Добавление и изменение текстовых блоков', 'TextBlocks', 0, 23, 1, 'info', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_news_2`
--

CREATE TABLE IF NOT EXISTS `kpl_module_news_2` (
  `ns_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ns_date` int(10) unsigned NOT NULL DEFAULT '0',
  `ns_name` varchar(255) DEFAULT NULL,
  `ns_picture` varchar(255) DEFAULT NULL,
  `ns_info` text,
  `ns_title` varchar(255) DEFAULT NULL,
  `ns_keywords` varchar(255) DEFAULT NULL,
  `ns_description` varchar(255) DEFAULT NULL,
  `ns_is_active` tinyint(1) NOT NULL DEFAULT '1',
  `ns_announce` varchar(2000) DEFAULT NULL,
  `ns_source` varchar(255) DEFAULT NULL,
  `ns_author` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ns_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_News (Новости)' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `kpl_module_news_2`
--

INSERT INTO `kpl_module_news_2` (`ns_id`, `ns_date`, `ns_name`, `ns_picture`, `ns_info`, `ns_title`, `ns_keywords`, `ns_description`, `ns_is_active`, `ns_announce`, `ns_source`, `ns_author`) VALUES
(1, 1304452800, 'Почему нетривиален принцип восприятия?', NULL, '<p>\r\n	Освобождение решительно дискредитирует сенсибельный дедуктивный метод, отрицая&nbsp;очевидное. Априори, гегельянство транспонирует гений, отрицая&nbsp;очевидное. Абстракция, как следует из вышесказанного, осмысляет закон&nbsp;внешнего&nbsp;мира, открывая&nbsp;новые&nbsp;горизонты. Реальность, по определению, подрывает катарсис, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Гедонизм, следовательно, непредвзято понимает&nbsp;под&nbsp;собой закон&nbsp;внешнего&nbsp;мира, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Апостериори, исчисление предикатов индуцирует интеллигибельный структурализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Локаята рефлектирует здравый смысл, не учитывая мнения&nbsp;авторитетов. Освобождение амбивалентно. Созерцание непредвзято принимает&nbsp;во&nbsp;внимание даосизм, отрицая&nbsp;очевидное. Сомнение, как принято считать, порождена&nbsp;временем.</p>\r\n<p>\r\n	Конфликт подчеркивает онтологический язык&nbsp;образов, изменяя&nbsp;привычную&nbsp;реальность. Здравый смысл, как принято считать, реально дискредитирует даосизм, отрицая&nbsp;очевидное. Отношение&nbsp;к&nbsp;современности, следовательно, амбивалентно. Согласно&nbsp;предыдущему, дедуктивный метод принимает&nbsp;во&nbsp;внимание смысл&nbsp;жизни, отрицая&nbsp;очевидное. Сомнение категорически принимает&nbsp;во&nbsp;внимание из ряда вон выходящий здравый смысл, открывая&nbsp;новые&nbsp;горизонты.</p>', NULL, NULL, NULL, 1, 'Дедуктивный метод трансформирует трагический смысл жизни, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения.', 'http://referats.yandex.ru', 'Яндекс.Рефераты'),
(2, 1305748800, 'Из ряда вон выходящий знак в XXI веке', NULL, '<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>', NULL, NULL, NULL, 1, 'Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.', 'http://referats.yandex.ru', 'Яндекс.Рефераты');

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_pages_1`
--

CREATE TABLE IF NOT EXISTS `kpl_module_pages_1` (
  `pg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pg_parent` int(10) unsigned NOT NULL DEFAULT '0',
  `pg_name` varchar(255) DEFAULT NULL,
  `pg_header` varchar(255) DEFAULT NULL,
  `pg_info` text,
  `pg_nick` varchar(255) DEFAULT NULL,
  `pg_in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `pg_title` varchar(255) DEFAULT NULL,
  `pg_keywords` varchar(255) DEFAULT NULL,
  `pg_description` varchar(255) DEFAULT NULL,
  `pg_position` int(10) unsigned NOT NULL DEFAULT '0',
  `pg_is_active` tinyint(1) NOT NULL DEFAULT '1',
  `pg_template` int(10) unsigned NOT NULL DEFAULT '0',
  `pg_last_modified` datetime DEFAULT NULL,
  `pg_in_map` tinyint(1) NOT NULL DEFAULT '1',
  `pg_is_system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Pages (Страницы)' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `kpl_module_pages_1`
--

INSERT INTO `kpl_module_pages_1` (`pg_id`, `pg_parent`, `pg_name`, `pg_header`, `pg_info`, `pg_nick`, `pg_in_menu`, `pg_title`, `pg_keywords`, `pg_description`, `pg_position`, `pg_is_active`, `pg_template`, `pg_last_modified`, `pg_in_map`, `pg_is_system`) VALUES
(1, 0, 'Главная', 'Добро пожаловать в систему управления сайтом', '<p>\r\n	Для управления сайтом используйте меню.<br />\r\n	Справку по работе с системой управления можно посмотреть в разделе &laquo;<a href="/admin/help/">Помощь</a>&raquo;.</p>', 'first', 1, 'Заголовок', 'Ключевые слова', 'Описание', 1, 1, 0, '2011-07-22 21:42:56', 1, 0),
(7, 0, 'Изменение темы', 'Изменение темы оформления сайта', '<p>\r\n	Для изменения темы оформления сайта пожалуйста выберите тему из списка и нажмите кнопку &laquo;Установить&raquo;. Для просмотра увеличенного изображения кликните по миниатюре.</p>\r\n', 'select-theme', 1, NULL, NULL, NULL, 6, 1, 0, '2011-09-28 09:20:38', 1, 0),
(3, 0, 'Модули', '', '', 'module', 1, '', '', NULL, 3, 1, 0, NULL, 1, 0),
(2, 0, 'Ошибка 404', 'Страница не найдена', 'Запрошенная вами страница не найдена на сайте. Возможно, страница была удалена или вы неправильно ввели адрес страницы в браузере. Для поиска нужной информации воспользуйтесь навигацией, поиском или картой сайта.', 'error404', 0, NULL, NULL, NULL, 2, 1, 0, NULL, 1, 0),
(5, 0, 'Помощь', 'Руководство пользователя Kopolo.CMS', '<div class="help">\r\n	<p>\r\n		Перейдите в интересующий вас раздел для получения справки по использованию возможностей системы:</p>\r\n	<ul>\r\n		<li>\r\n			<a href="#pages-short">Управление страницами сайта, кратко</a>\r\n			<ul>\r\n				<li>\r\n					<a href="#pages-short-add">Добавление новой страницы</a></li>\r\n				<li>\r\n					<a href="#pages-short-edit">Редактирование страницы</a></li>\r\n				<li>\r\n					<a href="#pages-short-list">Список страниц</a>\r\n					<ul>\r\n						<li>\r\n							<a href="#pages-short-listactions">Основные действия, доступные в списке страниц</a></li>\r\n					</ul>\r\n				</li>\r\n			</ul>\r\n		</li>\r\n		<li>\r\n			<a href="#pages">Управление страницами сайта, подробно</a>\r\n			<ul>\r\n				<li>\r\n					<a href="#pages-add">Добавление новой страницы</a>\r\n					<ul>\r\n						<li>\r\n							<a href="#pages-add-main">Основные данные страницы</a></li>\r\n						<li>\r\n							<a href="#pages-add-system">Служебные поля</a></li>\r\n					</ul>\r\n				</li>\r\n				<li>\r\n					<a href="#pages-list">Список страниц</a>\r\n					<ul>\r\n						<li>\r\n							<a href="#pages-edit">Редактирование страницы</a></li>\r\n					</ul>\r\n				</li>\r\n			</ul>\r\n		</li>\r\n	</ul>\r\n	<div class="content" style="width: 800px;">\r\n		<h1>\r\n			<a name="pages-short">Управление страницами сайта, кратко</a></h1>\r\n		<h2>\r\n			<a name="pages-short-add">Добавление новой страницы</a></h2>\r\n		<p>\r\n			<img src="/Files/admin/help/pages-short-add.jpg" /><br />\r\n			Поле &laquo;<b>Псевдоним</b>&raquo; является изменяемой частью адреса страницы, например, для страницы о компании можно ввести псевдоним <b>about</b>, соответственно полный адрес этой страницы будет выглядеть следующим образом: http://site.ru/<b>about</b>/</p>\r\n		<p>\r\n			Поле &laquo;<b>Псевдоним</b>&raquo; является обязательным для заполнения &ndash; страница без адреса существовать не может.</p>\r\n		<p>\r\n			Страница появится на сайте только после того, как будет нажата кнопка &laquo;<b>добавить</b>&raquo;.</p>\r\n		<p>\r\n			Для того, чтобы вернуться к списку страниц сайта нажмите<br />\r\n			<img src="/Files/admin/help/pages.jpg" /> или <img src="/Files/admin/help/pages-2.jpg" /></p>\r\n		<h2>\r\n			<a name="pages-short-edit">Редактирование страницы</a></h2>\r\n		<p>\r\n			<img src="/Files/admin/help/pages-short-edit.jpg" /><br />\r\n			Форма редактирования содержит те же самые поля, что и форма добавления.</p>\r\n		<p>\r\n			Все изменения будут сохранены только после того, как вы нажмете кнопку &laquo;<b>Обновить</b>&raquo;</p>\r\n		<h2>\r\n			<a name="pages-short-list">Список страниц</a></h2>\r\n		<p>\r\n			Ссылка на список страниц всегда доступна из главного меню системы:<br />\r\n			<img src="/Files/admin/help/pages.jpg" /></p>\r\n		<p>\r\n			Список страниц представлен в виде таблицы, каждая строка которой содержит информацию о странице и возможные действия.</p>\r\n		<h3>\r\n			<a name="pages-short-listactions">Основные действия, доступные в списке страниц</a></h3>\r\n		<p>\r\n			<img src="/Files/admin/help/edit_button.jpg" /> - Переход к форме редактирования страницы</p>\r\n		<p>\r\n			<img src="/Files/admin/help/delete_button.jpg" /> - Удаление страницы. При попытке удаления страницы будет запрошено подтверждение, во избежание досадных случайностей.</p>\r\n		<p>\r\n			<img src="/Files/admin/help/number.jpg" />(числа в столбце &laquo;позиция&raquo;) &ndash; характеризует положение ссылки на страницу в главном меню сайта. При клике по этому числу появится список, позволяющий изменить позицию страницы. Изменения позиции будут применены после нажатия кнопки <img src="/Files/admin/help/go.jpg" /></p>\r\n		<p>\r\n			<img src="/Files/admin/help/display.jpg" /> / <img src="/Files/admin/help/hidden.jpg" /> - информирует о том, будет ли соответствующая страница отображаться в главном меню сайта или нет. Если кликнуть по этой ссылке, то статус отображения будет изменен на противоположный, после подтверждения</p>\r\n		<p>\r\n			<img src="/Files/admin/help/active.jpg" /> / <img src="/Files/admin/help/inactive.jpg" /> - информирует о том, можно ли попасть на эту страницу. Если у страницы установлен статус &laquo;Не активен&raquo;, то на эту страницу нельзя будет попасть ни кликнув по ссылке, ни набрав адрес этой страницы в адресной строке &ndash; будет выведено сообщение о том, что такая страница не существует. Если кликнуть по этой ссылке, то статус доступности будет изменен на противоположный, после подтверждения.</p>\r\n		<h1>\r\n			<a name="pages">Управление страницами сайта, подробно</a></h1>\r\n		<p>\r\n			Для того чтобы попасть в раздел редактирования страниц сайта необходимо кликнуть по ссылке &laquo;страницы&raquo; в главном меню системы управления, ссылка отмечена оранжевым кружком на рис.1</p>\r\n		<center>\r\n			<img src="/Files/admin/help/menu_pages.jpg" /><br />\r\n			Рис. 1. главное меню сайта</center>\r\n		<h2>\r\n			<a name="pages-add">Добавление новой страницы</a></h2>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src="/Files/admin/help/pages_list.jpg" /><br />\r\n			Рис. 2. раздел &laquo;Страницы&raquo;</center>\r\n		<p>\r\n			Для того, чтобы добавить новую страницу (раздел) необходимо кликнуть по ссылке &laquo;добавить раздел&raquo;( ссылка отмечена оранжевым кружком на рис. 2), в результате откроется форма добавления страницы.</p>\r\n		<p>\r\n			<a name="pages-add-1"></a>Форма добавления страницы состоит из полей с основными данными (см. рис. 3.) и полей со служебными данными (см. рис. 4.)</p>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src="/Files/admin/help/add_page_main.jpg" /><br />\r\n			рис. 3. основные данные страницы</center>\r\n		<h3>\r\n			<a name="pages-add-main">Основные данные страницы</a></h3>\r\n		<ol>\r\n			<li>\r\n				<b>Название (в меню)</b><br />\r\n				В это поле вводится текст, который будет отображен в главном меню сайта в качестве ссылки на соответствующую страницу. Как правило, название для меню дается короткое в одно-два слова, более развернутое название можно указать в заголовке страницы</li>\r\n			<li>\r\n				<b>Заголовок</b><br />\r\n				Текст, который будет отображен в качестве заголовка соответствующей страницы</li>\r\n			<li>\r\n				<b>Информация</b><br />\r\n				Текстовая информация, которая будет представлена на странице (контент).<br />\r\n				Поле редактирования текста страницы реализовано в виде WYSIWYG редактора, который позволяет форматировать текст, подобно текстовому редактору MS Word.</li>\r\n		</ol>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src="/Files/admin/help/add_page_system.jpg" /><br />\r\n			рис. 4. служебные данные страницы</center>\r\n		<h3>\r\n			<a name="pages-add-system">Служебные поля</a></h3>\r\n		<ol>\r\n			<li>\r\n				<b>Псевдоним</b><br />\r\n				Псевдоним страницы &ndash; это часть адреса по которому страница будет доступна в сети Интернет. Например, для страницы о компании можно ввести псевдоним <b>about</b>, соответственно полный адрес этой страницы будет выглядеть следующим образом:<br />\r\n				http://{$smarty.server.SERVER_NAME}/<b>about</b>/<br />\r\n				Это поле является единственным обязательным для страницы, потому что страница не может существовать без адреса.</li>\r\n			<li>\r\n				<b>Показывать в меню</b><br />\r\n				Если этот флаг установлен, то страница будет отображена в главном меню сайта.</li>\r\n			<li>\r\n				<b>title, keywords, description</b><br />\r\n				Специальные поля для SEO-оптимизации.</li>\r\n			<li>\r\n				<b>Позиция</b><br />\r\n				В этом списке можно указать какой по счету будет идти эта страница в меню</li>\r\n			<li>\r\n				<b>Активность</b><br />\r\n				Если этот флаг не установлен, то на эту страницу будет невозможно попасть. Эту опцию полезно использовать когда страница находится в разработке.</li>\r\n		</ol>\r\n		<p>\r\n			Заполнив все вышеперечисленные поля можно нажать кнопку &laquo;добавить&raquo; и страница будет добавлена на сайт.</p>\r\n		<p>\r\n			Если вы все сделали правильно, вы окажетесь на странице редактирования страницы. Заголовок &laquo;Добавление раздела&raquo; изменится на &laquo;Редактирование раздела&raquo;, а кнопка &laquo;добавить&raquo; изменится на кнопку &laquo;обновить&raquo;.</p>\r\n		<p>\r\n			На рис. 5. приведен пример заполнения формы создания новой страницы:</p>\r\n		<center>\r\n			<img src="/Files/admin/help/add_page_full.jpg" /><br />\r\n			рис. 5. пример заполнения формы создания новой страницы</center>\r\n		<h2>\r\n			<a name="pages-list">Список страниц</a></h2>\r\n		<p>\r\n			Для того, чтобы из раздела редактирования или добавления страницы снова попасть в раздел системы со списком страниц сайта необходимо кликнуть по ссылке &laquo;разделы&raquo; отмеченную оранжевым кружком на рис. 6.</p>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src="/Files/admin/help/page_menu.jpg" /><br />\r\n			рис. 6.</center>\r\n		<p>\r\n			Список разделов представлен в виде таблицы (см рис. 7.). Каждая строка таблицы содержит информацию об одной странице (разделе) сайта. Таблица состоит из следующих столбцов:</p>\r\n		<ul>\r\n			<li>\r\n				действия</li>\r\n			<li>\r\n				название (в меню)</li>\r\n			<li>\r\n				псевдоним (элемент адреса)</li>\r\n			<li>\r\n				позиция и вкл./выкл. (управление видимостью страницы)</li>\r\n		</ul>\r\n		все эти свойства были описаны, когда мы рассматривали добавление новой страницы.\r\n		<p>\r\n			<a name="pages-edit"></a>В столбце <b>действия</b> доступны действия, которые можно совершить с этой страницей, наиболее часто используемым действием является действие &laquo;<b>изменить</b>&raquo; отмеченное на рис. 7. оранжевым кружком. Кликнув по этой ссылке, вы попадаете в <i><nobr><b>форму редактирования страницы</b></nobr>, которая полностью аналогична &nbsp;<a href="#pages-add-1">форме добавления страницы</a></i> (см. рис.5), за тем исключением, что вы редактируете данные уже существующей страницы. Изменения вносятся на сайт только после того, как будет нажата кнопка &laquo;Обновить&raquo;</p>\r\n		<p>\r\n			В столбце <b>позиция</b> отображается, какой по счету будет отображаться ссылка на раздел в главном меню. Кликнув по номеру позиции (рис. 7., синий кружок) вы увидите список доступных позиций (рис. 8.). Если выбрать новую позицию и кликнуть по зеленой кнопке рядом со списком, то порядок страниц изменится &ndash; вы сразу увидите результат. Этот метод несколько нагляднее, чем редактирование позиции страницы через форму редактирования.</p>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src="/Files/admin/help/pages_list_2.jpg" /><br />\r\n			рис. 7. Список страниц</center>\r\n		<p>\r\n			&nbsp;</p>\r\n		<center>\r\n			<img src="/Files/admin/help/sort.jpg" /><br />\r\n			рис. 7. Редактирование позиции страницы</center>\r\n		<p>\r\n			В столбце <b>вкл./выкл.</b> (рис. 8., зеленый кружок) выведена информация об отображении страницы. Для ускорения считывания информация продублирована цветом &ndash; если страница не отображается в меню или не активна, то соответствующая ссылка будет красного цвета. Кликнув по ссылке можно сменить параметр отображения на противоположный. Например, если кликнуть по зеленой ссылке &laquo;отображается в меню&raquo; - страница перестанет отображаться в меню, цвет ссылки и текст изменятся на &laquo;Не отображается в меню&raquo;</p>\r\n	</div>\r\n</div>', 'help', 1, NULL, NULL, NULL, 5, 1, 0, NULL, 1, 0),
(6, 0, 'Список модулей', 'Модули сайта', NULL, 'modules', 1, NULL, NULL, NULL, 4, 1, 0, '2011-05-19 22:05:21', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_pages_2`
--

CREATE TABLE IF NOT EXISTS `kpl_module_pages_2` (
  `pg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pg_parent` int(10) unsigned NOT NULL DEFAULT '0',
  `pg_name` varchar(255) DEFAULT NULL,
  `pg_header` varchar(255) DEFAULT NULL,
  `pg_info` text,
  `pg_nick` varchar(255) DEFAULT NULL,
  `pg_in_menu` tinyint(1) DEFAULT '0',
  `pg_title` varchar(255) DEFAULT NULL,
  `pg_keywords` varchar(255) DEFAULT NULL,
  `pg_description` varchar(255) DEFAULT NULL,
  `pg_position` int(10) unsigned NOT NULL DEFAULT '0',
  `pg_is_active` tinyint(1) NOT NULL DEFAULT '1',
  `pg_last_modified` datetime DEFAULT NULL,
  `pg_template` int(10) unsigned NOT NULL DEFAULT '0',
  `pg_in_map` tinyint(1) NOT NULL DEFAULT '1',
  `pg_is_system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Pages (Страницы)' AUTO_INCREMENT=26 ;

--
-- Dumping data for table `kpl_module_pages_2`
--

INSERT INTO `kpl_module_pages_2` (`pg_id`, `pg_parent`, `pg_name`, `pg_header`, `pg_info`, `pg_nick`, `pg_in_menu`, `pg_title`, `pg_keywords`, `pg_description`, `pg_position`, `pg_is_active`, `pg_last_modified`, `pg_template`, `pg_in_map`, `pg_is_system`) VALUES
(1, 0, 'Главная', 'Добро пожаловать!', '<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>', 'first', 1, NULL, NULL, NULL, 1, 1, '2011-11-21 15:47:52', 0, 1, 0),
(2, 0, 'Ошибка 404', 'Страница не найдена', '<p>\r\n	Запрошенная вами страница не найдена на сайте. Возможно, страница была удалена или вы неправильно ввели адрес страницы в браузере. Для поиска нужной информации воспользуйтесь навигацией, поиском или картой сайта.</p>', 'error404', 0, NULL, NULL, NULL, 9, 1, '2011-07-24 20:21:25', 0, 0, 0),
(5, 0, 'Поиск', 'Результаты поиска', NULL, 'search', 0, NULL, NULL, NULL, 7, 1, NULL, 0, 1, 0),
(4, 0, 'Контакты', 'Контактная информация', '<p>\r\n	На этой странице вы можете разместить контактную информацию &mdash; адрес, телефоны, схему проезда.</p>', 'contacts', 1, NULL, NULL, NULL, 6, 1, '2011-07-26 15:20:12', 0, 1, 0),
(3, 0, 'Новости', 'Новости', NULL, 'news', 0, NULL, NULL, NULL, 4, 1, '2011-10-09 08:58:23', 0, 1, 0),
(6, 0, 'Карта сайта', 'Карта сайта', NULL, 'map', 0, NULL, NULL, NULL, 8, 1, '2011-05-19 14:37:06', 0, 0, 0),
(7, 0, 'Напишите нам', 'Обратная связь', '<p>\r\n	Для связи с представителем компании заполните пожалуйста форму.</p>', 'feedback', 1, NULL, NULL, NULL, 5, 1, '2011-06-15 13:36:31', 0, 1, 0),
(19, 0, 'Услуги', 'Наши услуги', '<p>\r\n	На этой странице вы можете разместить описание услуг, предоставляемых вашей компанией.</p>', 'services', 1, NULL, NULL, NULL, 2, 1, '2011-10-21 11:07:32', 0, 1, 0),
(20, 19, 'Продажа слонов', 'Продажа слонов', '<p>\r\n	На этой странице вы можете разместить информацию об одном из направлений деятельности или услуг вашей компании, а также добавить изображения.</p>\r\n', 'sale', 1, NULL, NULL, NULL, 1, 1, '2011-07-25 18:34:08', 0, 1, 0),
(21, 19, 'Доставка слонов', 'Доставка слонов', '<p>\r\n	На этой странице вы можете разместить информацию об одном из направлений деятельности или услуг вашей компании, а также добавить изображения.</p>\r\n', 'delivery', 1, NULL, NULL, NULL, 2, 1, '2011-07-25 18:34:40', 0, 1, 0),
(22, 19, 'Разведение слонов', 'Разведение слонов', '<p>\r\n	На этой странице вы можете разместить информацию об одном из направлений деятельности или услуг вашей компании, а также добавить изображения.</p>\r\n', 'breeding', 1, NULL, NULL, NULL, 3, 1, '2011-07-25 18:34:56', 0, 1, 0),
(23, 19, 'Корм для слонов', 'Корм для слонов', '<p>\r\n	На этой странице вы можете разместить информацию об одном из направлений деятельности или услуг вашей компании, а также добавить изображения.</p>\r\n', 'food', 1, NULL, NULL, NULL, 4, 1, '2011-07-25 18:35:07', 0, 1, 0),
(24, 0, 'Галерея', 'Галерея', '<p>\r\n	На этой странице показан пример, как можно использовать галерею изображений (которые можно прикрепить не только к этой странице, но и к любой другой при помощи пунктов меню &laquo;Изображения&raquo; и &laquo;добавить изображение&raquo; напротив каждой страницы в административной панели). Чтобы вставить изображения непосредственно в текст, пользуйтесь визуальным редактором.</p>', 'gallery', 1, NULL, NULL, NULL, 3, 1, '2011-07-26 15:32:14', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_params`
--

CREATE TABLE IF NOT EXISTS `kpl_module_params` (
  `pm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pm_name` varchar(255) DEFAULT NULL,
  `pm_nick` varchar(255) DEFAULT NULL,
  `pm_value` varchar(5000) DEFAULT NULL,
  `pm_site` int(10) unsigned NOT NULL DEFAULT '2',
  `pm_component` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Params (Настройки)' AUTO_INCREMENT=25 ;

--
-- Dumping data for table `kpl_module_params`
--

INSERT INTO `kpl_module_params` (`pm_id`, `pm_name`, `pm_nick`, `pm_value`, `pm_site`, `pm_component`) VALUES
(1, 'Заголовок страниц (title) по умолчанию', 'html_title', '%pagename% - Заголовок по умолчанию', 2, 0),
(2, 'Ключевые слова (keywords) по умолчанию', 'html_keywords', 'Ключевые слова', 2, 0),
(3, 'Описание сайта (description) по умолчанию', 'html_description', 'Описание сайта', 2, 0),
(4, 'E-mail администратора сайта', 'admin_email', 'admin@site.ru', 2, 0),
(5, 'Заголовок страниц (title) по умолчанию', 'html_title', 'Система управления сайтом', 1, 0),
(6, 'Ключевые слова (keywords) по умолчанию', 'html_keywords', 'Ключевые слова', 1, 0),
(7, 'Описание сайта (description) по умолчанию', 'html_description', 'Описание сайта', 1, 0),
(8, 'E-mail администратора сайта', 'admin_email', 'name@site.ru', 1, 0),
(9, 'Таблица пользователей', 'table', 'kpl_module_users_1', 1, 1),
(19, 'Название компании', 'company_name', 'Companyname', 2, 0),
(20, 'Контактная информация (в подвале сайта)', 'contacts', 'Тел. (495) 777-77-77', 2, 0),
(21, 'Модуль', 'modules', 'Modules', 1, 22),
(22, 'Логотип', 'logo', NULL, 2, 0),
(23, 'Текст под логотипом', 'slogan', 'Слоган вашей компании', 2, 0),
(24, 'Тип навигации (hierarchy, line)', 'navi_type', 'line', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_recyclebin`
--

CREATE TABLE IF NOT EXISTS `kpl_module_recyclebin` (
  `rb_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rb_name` varchar(255) DEFAULT NULL,
  `rb_user` int(10) unsigned NOT NULL DEFAULT '0',
  `rb_datetime` int(10) unsigned NOT NULL DEFAULT '0',
  `rb_module` int(10) unsigned NOT NULL DEFAULT '0',
  `rb_object` longtext,
  `rb_related_to` int(10) unsigned NOT NULL DEFAULT '0',
  `rb_action` varchar(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_RecycleBin (Корзина)' AUTO_INCREMENT=52 ;

--
-- Dumping data for table `kpl_module_recyclebin`
--

INSERT INTO `kpl_module_recyclebin` (`rb_id`, `rb_name`, `rb_user`, `rb_datetime`, `rb_module`, `rb_object`, `rb_related_to`, `rb_action`) VALUES
(1, 'Из ряда вон выходящий знак в XXI веке', 1, 1317379807, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:0:"";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(2, 'Из ряда вон выходящий знак в XXI веке', 1, 1317380852, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:0:"";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(3, 'Из ряда вон выходящий знак в XXI веке', 1, 1317381717, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:0:"";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(4, 'Из ряда вон выходящий знак в XXI веке', 1, 1317382363, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:5:"Array";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(5, 'Из ряда вон выходящий знак в XXI веке', 1, 1317382397, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:5:"Array";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(6, 'Из ряда вон выходящий знак в XXI веке', 1, 1317382428, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:5:"Array";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(7, 'Из ряда вон выходящий знак в XXI веке', 1, 1317382516, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:5:"Array";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(8, 'Из ряда вон выходящий знак в XXI веке', 1, 1317382543, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:5:"Array";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(9, 'Из ряда вон выходящий знак в XXI веке', 1, 1317382618, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:5:"Array";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(10, 'Из ряда вон выходящий знак в XXI веке', 1, 1317382789, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:5:"Array";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(11, 'Из ряда вон выходящий знак в XXI веке', 1, 1317382855, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:5:"Array";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(12, 'Из ряда вон выходящий знак в XXI веке', 1, 1317386071, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:34:"/Files/Gallery/Images/IMG_7602.jpg";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(15, 'Сайты', 1, 1317800220, 20, 'a:7:{s:5:"mn_id";s:2:"15";s:7:"mn_site";s:1:"2";s:7:"mn_name";s:10:"Сайты";s:10:"mn_picture";s:27:"/Files/Sites/Menu/globe.png";s:12:"mn_is_active";s:1:"1";s:11:"mn_position";s:1:"9";s:7:"mn_link";s:20:"/admin/module/Sites/";}', 0, 'delete');
INSERT INTO `kpl_module_recyclebin` (`rb_id`, `rb_name`, `rb_user`, `rb_datetime`, `rb_module`, `rb_object`, `rb_related_to`, `rb_action`) VALUES
(16, 'Контроллеры', 1, 1317800230, 20, 'a:7:{s:5:"mn_id";s:2:"14";s:7:"mn_site";s:1:"2";s:7:"mn_name";s:22:"Контроллеры";s:10:"mn_picture";s:25:"/Files/Sites/Menu/php.png";s:12:"mn_is_active";s:1:"1";s:11:"mn_position";s:1:"8";s:7:"mn_link";s:26:"/admin/module/Controllers/";}', 0, 'delete'),
(17, 'Текстовые блоки', 1, 1317800415, 5, 'a:10:{s:5:"md_id";s:2:"25";s:7:"md_name";s:29:"Текстовые блоки";s:10:"md_comment";s:74:"Добавление и изменение текстовых блоков";s:7:"md_nick";s:10:"TextBlocks";s:12:"md_is_system";s:1:"0";s:11:"md_position";s:2:"23";s:8:"md_group";s:1:"1";s:13:"md_icon_group";s:0:"";s:12:"md_is_active";s:1:"1";s:10:"md_in_menu";s:1:"0";}', 0, 'edit'),
(18, 'Текстовый блок', 1, 1318126849, 25, 'a:4:{s:5:"tb_id";s:1:"1";s:7:"tb_name";s:27:"Текстовый блок";s:7:"tb_nick";s:3:"dgf";s:7:"tb_info";s:184:"<p>\r\n	Пример произвольного текстового блока. Вы можете удалить его или изменить в админпанели сайта.</p>";}', 0, 'edit'),
(19, 'Текстовый блок', 1, 1318126915, 25, 'a:4:{s:5:"tb_id";s:1:"1";s:7:"tb_name";s:27:"Текстовый блок";s:7:"tb_nick";s:7:"sidebar";s:7:"tb_info";s:184:"<p>\r\n	Пример произвольного текстового блока. Вы можете удалить его или изменить в админпанели сайта.</p>";}', 0, 'edit'),
(20, 'Текстовый блок', 1, 1318128892, 25, 'a:4:{s:5:"tb_id";s:1:"1";s:7:"tb_name";s:27:"Текстовый блок";s:7:"tb_nick";s:7:"sidebar";s:7:"tb_info";s:242:"<p>\r\n	Пример произвольного текстового блока. Вы можете удалить его или изменить в админпанели сайта, модуль &laquo;Текстовые блоки&raquo;.</p>";}', 0, 'edit'),
(21, 'Текстовый блок', 1, 1318128922, 25, 'a:4:{s:5:"tb_id";s:1:"1";s:7:"tb_name";s:27:"Текстовый блок";s:7:"tb_nick";s:7:"content";s:7:"tb_info";s:242:"<p>\r\n	Пример произвольного текстового блока. Вы можете удалить его или изменить в админпанели сайта, модуль &laquo;Текстовые блоки&raquo;.</p>";}', 0, 'edit'),
(22, 'Сайт компании', 1, 1318132014, 8, 'a:5:{s:5:"st_id";s:1:"2";s:7:"st_name";s:25:"Сайт компании";s:9:"st_domain";s:14:"companyname.ru";s:8:"st_theme";s:7:"default";s:12:"st_is_active";s:1:"1";}', 0, 'edit'),
(23, 'Текстовый блок', 1, 1318133055, 25, 'a:4:{s:5:"tb_id";s:1:"1";s:7:"tb_name";s:27:"Текстовый блок";s:7:"tb_nick";s:7:"sidebar";s:7:"tb_info";s:242:"<p>\r\n	Пример произвольного текстового блока. Вы можете удалить его или изменить в админпанели сайта, модуль &laquo;Текстовые блоки&raquo;.</p>";}', 0, 'edit'),
(24, 'Текстовый блок', 1, 1318133119, 25, 'a:4:{s:5:"tb_id";s:1:"1";s:7:"tb_name";s:27:"Текстовый блок";s:7:"tb_nick";s:7:"content";s:7:"tb_info";s:242:"<p>\r\n	Пример произвольного текстового блока. Вы можете удалить его или изменить в админпанели сайта, модуль &laquo;Текстовые блоки&raquo;.</p>";}', 0, 'edit'),
(25, 'Сайт компании', 1, 1318135290, 8, 'a:5:{s:5:"st_id";s:1:"2";s:7:"st_name";s:25:"Сайт компании";s:9:"st_domain";s:14:"companyname.ru";s:8:"st_theme";s:12:"Undiscovered";s:12:"st_is_active";s:1:"1";}', 0, 'edit'),
(26, 'Новости', 1, 1318136303, 1, 'a:16:{s:5:"pg_id";s:1:"3";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Новости";s:9:"pg_header";s:14:"Новости";s:7:"pg_info";s:0:"";s:7:"pg_nick";s:4:"news";s:10:"pg_in_menu";s:1:"1";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"3";s:12:"pg_is_active";s:1:"1";s:16:"pg_last_modified";s:19:"2011-05-19 14:11:04";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"1";s:12:"pg_is_system";s:1:"0";}', 0, 'edit'),
(14, 'Из ряда вон выходящий знак в XXI веке', 1, 1317613345, 2, 'a:12:{s:5:"ns_id";s:1:"2";s:7:"ns_date";s:10:"1305748800";s:7:"ns_name";s:64:"Из ряда вон выходящий знак в XXI веке";s:10:"ns_picture";s:34:"/Files/Gallery/Images/IMG_7819.jpg";s:7:"ns_info";s:3275:"<p>\r\n	Наряду&nbsp;с&nbsp;этим сомнение транспонирует напряженный дедуктивный метод, ломая&nbsp;рамки&nbsp;привычных&nbsp;представлений. Согласно&nbsp;мнению&nbsp;известных&nbsp;философов, искусство трансформирует знак, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Созерцание принимает&nbsp;во&nbsp;внимание здравый смысл, tertium nоn datur. Гегельянство, как принято считать, транспонирует гедонизм, открывая&nbsp;новые&nbsp;горизонты.</p>\r\n<p>\r\n	Структурализм решительно рефлектирует катарсис, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Платоновская академия, следовательно, амбивалентно творит конфликт, открывая&nbsp;новые&nbsp;горизонты. Гегельянство транспонирует структурализм, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения. Искусство, как принято считать, оспособляет дедуктивный метод, при этом буквы А, В, I, О символизируют соответственно общеутвердительное, общеотрицательное, частноутвердительное и частноотрицательное суждения.</p>\r\n<p>\r\n	Сомнение осмысленно оспособляет трагический дедуктивный метод, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Согласно&nbsp;предыдущему, гений представляет собой субъективный дуализм, учитывая опасность, которую представляли собой писания Дюринга для не окрепшего еще немецкого рабочего движения. Знак, как следует из вышесказанного, понимает&nbsp;под&nbsp;собой структурализм, хотя&nbsp;в&nbsp;официозе&nbsp;принято&nbsp;обратное. Суждение, конечно, естественно выводит непредвиденный конфликт, однако Зигварт считал критерием истинности необходимость и общезначимость, для которых нет никакой опоры в объективном мире. Сомнение рефлектирует трагический даосизм, изменяя&nbsp;привычную&nbsp;реальность.</p>";s:8:"ns_title";s:0:"";s:11:"ns_keywords";s:0:"";s:14:"ns_description";s:0:"";s:12:"ns_is_active";s:1:"1";s:11:"ns_announce";s:306:"Герменевтика дискредитирует непредвиденный гедонизм, изменяя привычную реальность. Отсюда естественно следует, что суждение понимает под собой интеллект tertium nоn datur.";s:9:"ns_source";s:25:"http://referats.yandex.ru";s:9:"ns_author";s:29:"Яндекс.Рефераты";}', 0, 'edit'),
(27, 'Сайт компании', 1, 1318140196, 8, 'a:5:{s:5:"st_id";s:1:"2";s:7:"st_name";s:25:"Сайт компании";s:9:"st_domain";s:14:"companyname.ru";s:8:"st_theme";s:11:"Combination";s:12:"st_is_active";s:1:"1";}', 0, 'edit'),
(28, 'Сайт компании', 1, 1318140312, 8, 'a:5:{s:5:"st_id";s:1:"2";s:7:"st_name";s:25:"Сайт компании";s:9:"st_domain";s:14:"companyname.ru";s:8:"st_theme";s:7:"Default";s:12:"st_is_active";s:1:"1";}', 0, 'edit'),
(29, 'Сайт компании', 1, 1318141417, 8, 'a:5:{s:5:"st_id";s:1:"2";s:7:"st_name";s:25:"Сайт компании";s:9:"st_domain";s:14:"companyname.ru";s:8:"st_theme";s:11:"Combination";s:12:"st_is_active";s:1:"1";}', 0, 'edit'),
(30, 'Сайт компании', 1, 1318141483, 8, 'a:5:{s:5:"st_id";s:1:"2";s:7:"st_name";s:25:"Сайт компании";s:9:"st_domain";s:14:"companyname.ru";s:8:"st_theme";s:7:"Default";s:12:"st_is_active";s:1:"1";}', 0, 'edit'),
(31, 'Сайт компании', 1, 1318145026, 8, 'a:5:{s:5:"st_id";s:1:"2";s:7:"st_name";s:25:"Сайт компании";s:9:"st_domain";s:14:"companyname.ru";s:8:"st_theme";s:12:"Undiscovered";s:12:"st_is_active";s:1:"1";}', 0, 'edit'),
(32, 'Сайт компании', 1, 1318319596, 8, 'a:5:{s:5:"st_id";s:1:"2";s:7:"st_name";s:25:"Сайт компании";s:9:"st_domain";s:14:"companyname.ru";s:8:"st_theme";s:7:"Default";s:12:"st_is_active";s:1:"1";}', 0, 'edit'),
(33, 'Сайт компании', 1, 1319170231, 8, 'a:5:{s:5:"st_id";s:1:"2";s:7:"st_name";s:25:"Сайт компании";s:9:"st_domain";s:14:"companyname.ru";s:8:"st_theme";s:11:"Combination";s:12:"st_is_active";s:1:"1";}', 0, 'edit'),
(34, 'Главная', 1, 1319180201, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"1";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"1";s:16:"pg_last_modified";s:19:"2011-07-26 15:31:14";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"1";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(35, 'Главная1', 1, 1319180496, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:15:"Главная1";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"0";s:16:"pg_last_modified";s:19:"2011-10-21 10:56:41";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(36, 'Главная2', 1, 1319180586, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:15:"Главная2";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"0";s:16:"pg_last_modified";s:19:"2011-10-21 11:01:36";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(37, 'Главная2', 1, 1319180594, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:15:"Главная2";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"0";s:16:"pg_last_modified";s:19:"2011-10-21 11:01:36";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(38, 'Главная3', 1, 1319180825, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:15:"Главная3";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"0";s:16:"pg_last_modified";s:19:"2011-10-21 11:03:14";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(39, 'Главная', 1, 1319180840, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"0";s:16:"pg_last_modified";s:19:"2011-10-21 11:07:05";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(40, 'Услуги', 1, 1319180852, 1, 'a:16:{s:5:"pg_id";s:2:"19";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:12:"Услуги";s:9:"pg_header";s:21:"Наши услуги";s:7:"pg_info";s:170:"<p>\r\n	На этой странице вы можете разместить описание услуг, предоставляемых вашей компанией.</p>";s:7:"pg_nick";s:8:"services";s:10:"pg_in_menu";s:1:"1";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"1";s:16:"pg_last_modified";s:19:"2011-07-24 20:21:05";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"1";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(41, 'Главная', 1, 1319182479, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"0";s:16:"pg_last_modified";s:19:"2011-10-21 11:07:20";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(42, 'Главная1', 1, 1319182495, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:15:"Главная1";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"0";s:16:"pg_last_modified";s:19:"2011-10-21 11:34:39";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(43, 'Главная', 1, 1319182522, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"0";s:16:"pg_last_modified";s:19:"2011-10-21 11:34:55";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(44, 'Главная', 1, 1319182532, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"1";s:16:"pg_last_modified";s:19:"2011-10-21 11:35:22";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(45, 'Главная', 1, 1319182541, 1, 'a:16:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"1";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"1";s:16:"pg_last_modified";s:19:"2011-10-21 11:35:32";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";}', 0, 'editfield'),
(46, 'Главная', 1, 1321879197, 1, 'a:17:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"1";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"1";s:16:"pg_last_modified";s:19:"2011-10-21 11:35:41";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"1";s:12:"pg_is_system";s:1:"0";s:16:"pg_test_checkbox";s:1:"0";}', 0, 'editfield'),
(47, 'Главная', 1, 1321879650, 1, 'a:17:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"0";s:16:"pg_last_modified";s:19:"2011-11-21 15:39:57";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";s:16:"pg_test_checkbox";s:1:"1";}', 0, 'editfield'),
(48, 'Главная', 1, 1321879655, 1, 'a:17:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"0";s:16:"pg_last_modified";s:19:"2011-11-21 15:47:30";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";s:16:"pg_test_checkbox";s:1:"0";}', 0, 'editfield');
INSERT INTO `kpl_module_recyclebin` (`rb_id`, `rb_name`, `rb_user`, `rb_datetime`, `rb_module`, `rb_object`, `rb_related_to`, `rb_action`) VALUES
(49, 'Главная', 1, 1321879660, 1, 'a:17:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"0";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"1";s:16:"pg_last_modified";s:19:"2011-11-21 15:47:35";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";s:16:"pg_test_checkbox";s:1:"0";}', 0, 'editfield'),
(50, 'Главная', 1, 1321879666, 1, 'a:17:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"1";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"1";s:16:"pg_last_modified";s:19:"2011-11-21 15:47:40";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"0";s:12:"pg_is_system";s:1:"0";s:16:"pg_test_checkbox";s:1:"0";}', 0, 'editfield'),
(51, 'Главная', 1, 1321879672, 1, 'a:17:{s:5:"pg_id";s:1:"1";s:9:"pg_parent";s:1:"0";s:7:"pg_name";s:14:"Главная";s:9:"pg_header";s:32:"Добро пожаловать!";s:7:"pg_info";s:2210:"<p>\r\n	Добро пожаловать на сайт, созданный при помощи <a href="http://kopolocms.ru">KopoloCMS</a>. Для управления сайтом войдите в административную панель. Справка по использованию системы управления &mdash;&nbsp; <a href="http://docs.kopolocms.ru/wiki/">http://docs.kopolocms.ru/wiki/</a>.</p>\r\n<p>\r\n	Редакция вашего сайта &mdash; &laquo;Визитка&raquo;, это значит, что вы можете создать неограниченное число разделов сайта и подразделов к ним, использовать галерею изображений и новости. Если со временем вам станет мало этой функциональности, вы сможете установить дополнительные модули, например &laquo;Каталог&raquo;.</p>\r\n<p>\r\n	Кроме того, система управления позволит вам при необходимости заниматься оптимизацией сайта &mdash; проставлять заголовки и другие meta-данные, а также изменять адреса страниц.</p>\r\n<p>\r\n	Вы всегда можете сменить дизайн сайта, выбрав другую тему оформления, а также скачать другие темы с сайта <a href="http://kopolocms.ru/">kopolocms.ru</a>.</p>\r\n<p>\r\n	Содержимое каждой страницы можно изменять в визуальном редакторе, вставлять текст, таблицы или изображения. Кроме того, вы можете прикрепить к любой странице неограниченное число изображений, которые будут выводиться под текстом и увеличиваться при клике. Пример того, как это может выглядеть, представлен на странице <a href="/gallery/">Галерея</a>.</p>";s:7:"pg_nick";s:5:"first";s:10:"pg_in_menu";s:1:"1";s:8:"pg_title";s:0:"";s:11:"pg_keywords";s:0:"";s:14:"pg_description";s:0:"";s:11:"pg_position";s:1:"1";s:12:"pg_is_active";s:1:"1";s:16:"pg_last_modified";s:19:"2011-11-21 15:47:46";s:11:"pg_template";s:1:"0";s:9:"pg_in_map";s:1:"1";s:12:"pg_is_system";s:1:"0";s:16:"pg_test_checkbox";s:1:"0";}', 0, 'editfield');

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_search_index_2`
--

CREATE TABLE IF NOT EXISTS `kpl_module_search_index_2` (
  `si_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `si_name` varchar(255) DEFAULT NULL,
  `si_info` varchar(5000) DEFAULT NULL,
  `si_uri` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`si_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Search_Index (Индекс поиска)' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kpl_module_search_index_2`
--


-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_sites`
--

CREATE TABLE IF NOT EXISTS `kpl_module_sites` (
  `st_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `st_name` varchar(255) DEFAULT NULL,
  `st_domain` varchar(255) DEFAULT NULL,
  `st_theme` varchar(100) DEFAULT NULL,
  `st_is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`st_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Sites (Сайты)' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kpl_module_sites`
--

INSERT INTO `kpl_module_sites` (`st_id`, `st_name`, `st_domain`, `st_theme`, `st_is_active`) VALUES
(1, 'Административная панель', 'admin', 'Admin', 1),
(2, 'Сайт компании', 'companyname.ru', 'Default', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_sites_langs`
--

CREATE TABLE IF NOT EXISTS `kpl_module_sites_langs` (
  `lang_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang_site` int(10) unsigned NOT NULL DEFAULT '0',
  `lang_name` varchar(255) DEFAULT NULL,
  `lang_nick` varchar(255) DEFAULT NULL,
  `lang_picture` varchar(255) DEFAULT NULL,
  `lang_is_active` tinyint(1) NOT NULL DEFAULT '1',
  `lang_position` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`lang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Sites_Langs (Языковые версии сайта)' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `kpl_module_sites_langs`
--


-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_sites_menu`
--

CREATE TABLE IF NOT EXISTS `kpl_module_sites_menu` (
  `mn_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mn_site` int(10) unsigned NOT NULL DEFAULT '0',
  `mn_name` varchar(255) DEFAULT NULL,
  `mn_picture` varchar(255) DEFAULT NULL,
  `mn_is_active` tinyint(1) NOT NULL DEFAULT '1',
  `mn_position` int(10) unsigned NOT NULL DEFAULT '1',
  `mn_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Sites_Menu (Меню административного инт' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `kpl_module_sites_menu`
--

INSERT INTO `kpl_module_sites_menu` (`mn_id`, `mn_site`, `mn_name`, `mn_picture`, `mn_is_active`, `mn_position`, `mn_link`) VALUES
(1, 1, 'Страницы', '/Files/Sites/Menu/document.png', 1, 1, '/admin/module/Pages/'),
(2, 1, 'Настройки', '/Files/Sites/Menu/settings.png', 1, 2, '/admin/module/Params/'),
(3, 1, 'Пользователи', '/Files/Sites/Menu/admin.png', 1, 3, '/admin/module/Users/'),
(4, 1, 'Общие компоненты', '/Files/Sites/Menu/bricks.png', 1, 4, '/admin/module/Components/'),
(5, 1, 'Модули', '/Files/Sites/Menu/gear.png', 1, 5, '/admin/modules/'),
(6, 1, 'Контроллеры', '/Files/Sites/Menu/php.png', 1, 6, '/admin/module/Controllers/'),
(7, 1, 'Сайты', '/Files/Sites/Menu/globe.png', 1, 7, '/admin/module/Sites/'),
(8, 2, 'Страницы', '/Files/Sites/Menu/document.png', 1, 1, '/admin/module/Pages/'),
(9, 2, 'Новости', '/Files/Sites/Menu/bubble.png', 1, 2, '/admin/module/News/'),
(10, 2, 'Настройки', '/Files/Sites/Menu/settings.png', 1, 4, '/admin/module/Params/'),
(11, 2, 'Пользователи', '/Files/Sites/Menu/admin.png', 1, 5, '/admin/module/Users/'),
(12, 2, 'Общие компоненты', '/Files/Sites/Menu/bricks.png', 1, 6, '/admin/module/Components/'),
(13, 2, 'Модули', '/Files/Sites/Menu/gear.png', 1, 7, '/admin/modules/'),
(16, 2, 'Сообщения с формы', '/Files/Sites/Menu/letter.png', 1, 3, '/admin/module/Pages/Forms/Forms_Senders/?action=list&sn_form=1');

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_templates`
--

CREATE TABLE IF NOT EXISTS `kpl_module_templates` (
  `tpl_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tpl_site` int(10) unsigned NOT NULL DEFAULT '2',
  `tpl_type` varchar(10) DEFAULT 'component',
  `tpl_name` varchar(255) DEFAULT NULL,
  `tpl_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tpl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Templates (Шаблоны)' AUTO_INCREMENT=14 ;

--
-- Dumping data for table `kpl_module_templates`
--

INSERT INTO `kpl_module_templates` (`tpl_id`, `tpl_site`, `tpl_type`, `tpl_name`, `tpl_path`) VALUES
(2, 1, 'component', 'Выбор сайта', 'sites/select.tpl'),
(3, 2, 'component', 'Основное меню страниц', 'menu.tpl'),
(13, 2, 'component', 'Галерея страниц', 'images.tpl');

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_textblocks_2`
--

CREATE TABLE IF NOT EXISTS `kpl_module_textblocks_2` (
  `tb_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_name` varchar(255) DEFAULT NULL,
  `tb_nick` varchar(255) DEFAULT NULL,
  `tb_info` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`tb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_TextBlocks (Текстовые блоки)' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kpl_module_textblocks_2`
--

INSERT INTO `kpl_module_textblocks_2` (`tb_id`, `tb_name`, `tb_nick`, `tb_info`) VALUES
(1, 'Текстовый блок', 'sidebar', '<p>\r\n	Пример произвольного текстового блока. Вы можете удалить его или изменить в админпанели сайта, модуль &laquo;Текстовые блоки&raquo;.</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_users_1`
--

CREATE TABLE IF NOT EXISTS `kpl_module_users_1` (
  `us_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `us_name` varchar(255) DEFAULT NULL,
  `us_login` varchar(50) DEFAULT NULL,
  `us_password` varchar(50) DEFAULT NULL,
  `us_is_active` tinyint(1) NOT NULL DEFAULT '1',
  `us_group` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`us_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Users (Пользователи)' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kpl_module_users_1`
--

INSERT INTO `kpl_module_users_1` (`us_id`, `us_name`, `us_login`, `us_password`, `us_is_active`, `us_group`) VALUES
(1, 'Администратор', 'admin', 'admin', 1, 1),
(2, 'Менеджер', 'manager', 'manager', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_users_groups_1`
--

CREATE TABLE IF NOT EXISTS `kpl_module_users_groups_1` (
  `gr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gr_name` varchar(255) DEFAULT NULL,
  `gr_is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`gr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Users_Groups (Группы пользователей)' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kpl_module_users_groups_1`
--

INSERT INTO `kpl_module_users_groups_1` (`gr_id`, `gr_name`, `gr_is_active`) VALUES
(1, 'Администраторы', 1),
(2, 'Контент-менеджеры', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kpl_module_users_permissions_1`
--

CREATE TABLE IF NOT EXISTS `kpl_module_users_permissions_1` (
  `ps_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ps_module` int(10) unsigned NOT NULL DEFAULT '0',
  `ps_item` int(10) unsigned NOT NULL DEFAULT '0',
  `ps_group` int(10) unsigned NOT NULL DEFAULT '0',
  `ps_user` int(10) unsigned NOT NULL DEFAULT '0',
  `ps_action_view` tinyint(1) NOT NULL DEFAULT '0',
  `ps_action_addition` tinyint(1) NOT NULL DEFAULT '0',
  `ps_action_change` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ps_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица модуля Module_Users_Permissions (Права)' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `kpl_module_users_permissions_1`
--

INSERT INTO `kpl_module_users_permissions_1` (`ps_id`, `ps_module`, `ps_item`, `ps_group`, `ps_user`, `ps_action_view`, `ps_action_addition`, `ps_action_change`) VALUES
(1, 20, 8, 0, 0, 1, 0, 0),
(2, 20, 9, 0, 0, 1, 0, 0),
(3, 20, 10, 0, 0, 1, 0, 0),
(4, 20, 11, 1, 0, 1, 0, 0),
(5, 20, 12, 1, 0, 1, 0, 0),
(6, 20, 13, 1, 0, 1, 0, 0),
(7, 20, 14, 1, 0, 1, 0, 0),
(8, 20, 15, 1, 0, 1, 0, 0),
(9, 20, 16, 0, 0, 1, 0, 0),
(10, 20, 1, 1, 0, 1, 1, 1),
(11, 20, 2, 1, 0, 1, 1, 1),
(12, 20, 3, 1, 0, 1, 1, 1),
(13, 20, 4, 1, 0, 1, 1, 1),
(14, 20, 5, 1, 0, 1, 1, 1),
(15, 20, 6, 1, 0, 1, 1, 1),
(16, 20, 7, 1, 0, 1, 1, 1);
