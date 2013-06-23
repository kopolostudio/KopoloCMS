<?php

/**
 * Адаптер шаблонизатора для Smarty
 *
 * @copyright  (c) 2007-2010 Kopolo
 * @license    http://kopolocms.ru/license/
 * @author  Elena Kondrateva <elena@kopolo.ru>
 * @package Template
 * @subpackage Smarty
 * @version    3.0 / 06.02.2011
 */

class Kopolo_Template_Adapter_Smarty extends Kopolo_Template
{
    /**
    * Флаг ошибки при обработке шаблона
    * @var boolean
    */
    public $error = false;
    
    public $template_file;
    public $template_dir;
    protected $config_dir;
    private $compile_dir;
    
    public $template_dir_name;
    
    /**
     * Объект шаблона
     * @var object
    */
    private $template;
    
    /**
     * Название темы оформления текущего сайта
     * @var string
    */
    public $theme;
    
    /**
     * @param string путь к файлу шаблона
     */
    public function __construct($template_file)
    {
        $this->template_dir_name = 'templates';
        
        /* получение темы текущего сайта */
        $this->theme = parent::getTheme();
        
        $this->template_dir = KOPOLO_PATH . 'Themes';
        $this->compile_dir = KOPOLO_PATH . 'Tmp/Smarty';
        $this->config_dir = false;
        
        $this->template_file = $this->load ($template_file);
        if ($this->template_file == false) {
            $this->error = true;
            return false;
        }
    }
    
   
    /**
     * Устанавливает директорию, в которой находятся конфигурационные файлы шаблонов
     * 
     * @param string полный путь к директории с закрывающим слешем
     * @return bool
     */
    public function setConfigDir ($config_dir) {
        $this->config_dir = $config_dir;
        return true; //XXX: добавить обработку
    }

    /**
     * Устанавливает директорию, в которой находятся скомпилированные файлы шаблонов Smarty
     * 
     * @param string $compile_dir - полный путь к директории с закрывающим слешем
     * @return bool
     */
    public function setCompileDir ($compile_dir) {
        $this->compile_dir = $compile_dir;
        return true; //XXX: добавить обработку
    }

    public function assign ($name, $value)
    {
        if (!is_object($this->template)) {
            $backtrace = debug_backtrace();
            echo '<pre>'; print_r ($backtrace); echo '</pre>';
        } else {
            $this->template->assign ($name, $value);
        }
    }

    public function assignByRef ($name, &$value)
    {
        $this->template->assignByRef($name, $value);
    }

    public function getHTML ()
    {
        if (!empty($this->template_file)) {
            $this->html = $this->template->fetch ($this->template_file);
        }
        return $this->html;
    }
    
    /**
     * Загружает файл шаблона
     * 
     * @param string относительный путь к шаблону
     * @return string путь к шаблону or false
     */
    protected function load($template_file)
    {
        /* Попытка получить шаблон из темы */
        $template_dir = $this->template_dir . '/' . $this->theme . '/' . $this->template_dir_name;
        $template_file_full_path = $template_dir . '/' . $template_file;
        
        if (!file_exists($template_file_full_path)) {
            /* Если в теме данного шаблона нет, пробуем получить из папки default */
            $template_dir = $this->template_dir . '/' . KOPOLO_DEFAULT_THEME . '/' . $this->template_dir_name;
            $template_file_full_path = $template_dir . '/' . $template_file;
            
            if (!file_exists($template_file_full_path)) {
                Kopolo_Log::write('Template file not found: ' . $template_file_full_path);
                return false;
            } else {
                $this->theme = KOPOLO_DEFAULT_THEME;
            }
        }
        
        $this->template_dir = $template_dir;
        $this->initSmarty();
        return $template_file;
    }

    /**
    * Создает объект класса Smarty и устанавливает основные его настройки
    */
    private function initSmarty() 
    {
        $template = new Smarty();
        
        //$template->allow_php_templates= true;
        $template->force_compile = false;
        $template->default_template_handler_func = 'smarty_load_default_template';
        
        //уровень сообщений об ошибках
        if (KOPOLO_DEVELOP_MODE == true) {
            $template->error_reporting = E_ALL^E_NOTICE;
        } else {
            $template->error_reporting = 0;
        }
        
        //$template->caching = true;
        //$template->cache_lifetime = 100;
        //$template->debugging = true;
        
        //register plugins
        $template->registerPlugin('function', 'resize', array ('Kopolo_Template_Plugins', 'resize'));
        $template->registerPlugin('function', 'human_date', array ('Kopolo_Template_Plugins', 'human_date'));
        $template->registerPlugin('function', 'word_form', array ('Kopolo_Template_Plugins', 'word_form'));
        
        $template->template_dir = $this->template_dir;
        $template->compile_dir = $this->compile_dir . '/' . $this->theme;
        if (!file_exists($template->compile_dir)) {
            mkdir($template->compile_dir, 0755);
        }
        $template->config_dir = $this->config_dir;
        //$template->config_load ('translate.txt', $lang);
        $this->template = $template;
    }
}

/**
* Функция возвращает полный путь к шаблону, если Smarty шаблон не найден (default_template_handler_func)
* 
* @param string
* @param string название шаблона (include file)
* 
* @return string
*/

function smarty_load_default_template ($resource_type, $resource_name, &$template_source, &$template_timestamp, $template_object) {
    $smarty = new Kopolo_Template_Adapter_Smarty($resource_name);
    if (!empty($smarty->template_file)) {
        $filepath = $smarty->template_dir . '/' . $smarty->template_file;
        return $filepath;
    }
    return false;
}

?>