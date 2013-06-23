<?php

/**
 * Шаблонизатор
 *
 * Класс, реализующий функциональность шаблонизатора
 * Предоставляет доступ к адаптерам: Smarty, PHP (native)
 *
 * @example
 * <code>
 *     $template = Kopolo_Template::factory ('template.tpl');
 *     $template->assign ('variable', $variable);
 *     echo $template->getHTML();
 * </code>
 *
 * @version 1.0
 * @package Kopolo
 * @subpackage Template
 * @author Elena Kondrateva <elena@kopolo.ru>
 */

class Kopolo_Template
{
    /**
    * Название файла с шаблоном
    * @var string
    * @example index.tpl
    */
    public $template_file;
    
    /**
    * Название файла с шаблоном
    * @var string
    * @example index.tpl
    */
    protected $html;
    
    /**
    * Полный путь к директории (с закрывающим слешем), в которой находятся файлы шаблонов
    * @var string
    */
    protected $template_dir;
    
    /**
     * Поддерживаемые форматы шаблонов в массиве: расширение файла с точкой => адаптер
     * Можно ассоциировать к разным расширениям один класс адаптер
     * @var array
     */
    public static $template_extensions = array(
        '.tpl'=>'Smarty'
    ); 

    /**
     * Путь к директории с шаблонами с закрывающим слэшем
     * Относительно директории с темой оформления
     * 
     * @var string
     */
    public static $templates_dir = 'templates/';
    
    /**
     * Возвращает экземпляр класса адаптера для соответствующего типа шаблона
     * 
     * @param string название файла с шаблоном
     * @return object
     */
    public static function factory($template_file)
    {
        if (empty($template_file)) {
            Kopolo_Log::write('Не передано название шаблона — $template_file.');
            return false;
        } else {
            $extension = strrchr($template_file, '.');
            if (!isset(self::$template_extensions[$extension])) {
                Kopolo_Log::write('Неизвестный формат шаблона ' . $template_file . '.');
            }
            
            $adapter = self::$template_extensions[$extension];
            $adapter_class = __CLASS__ . '_Adapter_' . $adapter;
            $adapter_object = new $adapter_class($template_file);
            return $adapter_object;
        }
    }
   
   
    /**
     * Устанавливает директорию, в которой находятся файлы шаблонов
     * 
     * @param string полный путь к директории с закрывающим слешем
     * @return bool
     */
    public function setTemplateDir($template_dir) {
        $this->template_dir = $template_dir;
        return true;
    }
     
    /**
     * Загружает/подготавливает файл с шаблоном
     * 
     * @param string $path - необязательный параметр
     * @return $template
     */
    protected function load($path)
    {
        return $template;
    }
    
    /**
     * Получение текущей выбранной темы
     * 
     * @return string
     */
    protected function getTheme()
    {
        $theme = Kopolo_Registry::get('theme');
        if (strlen($theme)) { //XXX: проверить на существование такой папки с темой?
            return $theme;
        }
        return KOPOLO_DEFAULT_THEME;
    }
    
    /**
     * Добавляет переменную в общий массив данных для передачи в шаблон
     * 
     * @param string имя переменной в шаблоне
     * @param void   значение
     */
    public function assign ($name, $value)
    {
        return;
    }
   
    /**
     * Добавляет переменную по ссылке в общий массив данных для передачи в шаблон
     * 
     * @param string имя переменной в шаблоне
     * @param void   значение
     */
    public function assignByRef ($name, &$value)
    {
        return;
    }
    
    /**
     * Добавляет элементы переменной или массива в общий массив данных для передачи в шаблон.
     * Если переданное значение не массив и не объект - вернет false, иначе true
     * 
     * @param object
     * @return boolean
     */
    public function autoAssign($data)
    {
        if (is_array($data) || is_object($data)) {
            foreach ($data as $name => &$value) {
                if (!empty($name)) {
                    //если значение является объектом, то передаем по ссылке
                    $name = (string)$name;
                    if (is_object($value) == true) {
                        $this->assignByRef($name, $value);
                    } else {
                        $this->assign($name, $value);
                    }
                } else {
                    Kopolo_Log::write('Передано пустое название переменной (шаблон -'. $this->template_file .'-).');
                }
            }
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Возвращает HTML после обработки данных шаблоном
     * 
     * @return string
     */
    public function getHTML()
    {
        return $this->html;
    }
    
    /**
     * Показывает HTML полученный в результате преобразования
     * 
     * @param string
     */
    public function displayHTML($html = false)
    {
        if ($html == false) {
            $html = $this->html;
        }
        echo $html;
    }
    
}
?>