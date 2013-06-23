<?php/** !!!- * Этот файл изменять нельзя - он является образцом конфигурационного файла * При необходимости создания конфигурационного файла вручную * сделайте копию этого файла с именем config.php *  -!!! * Основной конфигурационный файл Kopolo CMS * объявление базовых констант *  * @version 1.13 [25.05.2011] * @author kopolo.ru */ /* Параметры вывода ошибок */ini_set ('display_errors', 'on');error_reporting (E_ALL); /** * Включение/отключение режима разработки * @var boolean */define ('KOPOLO_DEVELOP_MODE', true);/*********   Параметры базы данных  *********//** * Префикс таблиц базы данных * @var string */define ('KOPOLO_DB_TABLES_PREFIX', 'kpl_');/** * Кодировка соединения с базой данных * @var string */define ('KOPOLO_DB_CHARSET', 'utf8');define ('KOPOLO_DB_COLLATE', 'utf8_general_ci');/** * Использовать кириллические (и прочие, отличные от латиницы) адреса страниц * @var boolean */define ('KOPOLO_USE_ENCODED_URLS', false);/** * DSN: данные для соединения с базой данных * @var string * @example: mysql://username:password@host/databasename * @example: sqlite:////full/unix/path/to/file.db?mode=0666 * @example: sqlite:///c:/full/windows/path/to/file.db?mode=0666 * Параметр ?mode=0666 обязателен для sqlite */define ('KOPOLO_DSN', 'mysqli://db_username:db_password@localhost/db_name?charset=' . KOPOLO_DB_CHARSET);/** * Для пакета DB_DataObject (необходимо для хостингов с установленным Zend Optimizer) * @var boolean */define ('DB_DATAOBJECT_NO_OVERLOAD', true); /** * Абсолютный путь к корневой директории CMS (c закрывающим слешем) * @var string */define ('KOPOLO_PATH', str_replace("\\", "/", realpath (dirname (__FILE__))) . "/");/** * Абсолютный путь к директории библиотек (c закрывающим слешем) * @var string */define ('KOPOLO_PATH_LIB', KOPOLO_PATH . 'Lib/');/** * Абсолютный путь к директории логов (c закрывающим слешем) * @var string */define ('KOPOLO_PATH_LOG', KOPOLO_PATH . 'Tmp/Logs/');/** * Абсолютный путь к файлам, доступным пользователям через файл-менеджер (c закрывающим слешем) * @var string */define ('KOPOLO_PATH_USER_FILES', KOPOLO_PATH . 'Files/');/*********   Пути к базовым библиотекам   *********/$include_path  = '.';$include_path .= PATH_SEPARATOR . KOPOLO_PATH . 'Lib/';$include_path .= PATH_SEPARATOR . KOPOLO_PATH . 'Lib/PEAR';ini_set ('include_path', $include_path);unset($include_path);define('SMARTY_DIR', KOPOLO_PATH_LIB . 'Smarty/');/** * Версия ядра системы * @var string */define ('KOPOLO_VERSION', '0.2.8&beta;'); //http://docs.kopolocms.ru/wiki/Версия_0.2.8//** * ID сайта административной панели * @var integer */define ('ADMIN_PANEL_SITE_ID', 1);/** * Поддержка многосайтовости * @var boolean */define ('MULTISITING', false);/** * Поддержка многоязычности * @var boolean */define ('MULTILANG', false);/** * Тип многоязычности (fields, tables) * @var string */define ('MULTILANG_TYPE', 'fields');/** * ID сайта (константа объявляется только когда MULTISITING установлен в false) * @var integer */define ('SITE_ID', 2);/** * Название темы оформления по умолчанию * @var string */define ('KOPOLO_DEFAULT_THEME', 'Default');/*** Настройки для хостингов с ограничением потребляемой скриптом памяти ***//** * Максимальный вес изображения, байт * @var integer */define ('KOPOLO_MAX_IMAGE_SIZE', '500000');/** * Максимальная ширина изображения, px * @var integer */define ('KOPOLO_MAX_IMAGE_WIDTH', '1000');/** * Максимальная высота изображения, px * @var integer */define ('KOPOLO_MAX_IMAGE_HEIGHT', '1000');/*** Настройки почты (используется SMTP) ***/define ('USE_SMTP', false);define ('SMTP_HOST', 'smtp.site.ru');define ('SMTP_AUTH', true);define ('SMTP_USERNAME', 'site.ru+no-reply');define ('SMTP_PASSWORD', 'secret-password');define ('SMTP_FROM_MAIL', 'no-reply@site.ru');?>