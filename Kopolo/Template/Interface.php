<?php

/**
 * Интерфейс шаблонизатора
 *
 * @license    http://kopolocms.ru/license/
 * @author  Elena Kondrateva <elena@kopolo.ru>
 * @package Kopolo
 * @subpackage Template
 * @version 1.0 / 03.06.2011
 */

interface Kopolo_Template_Interface
{
   /**
    * Название файла с шаблоном
    * @var string
    * @example index.tpl
    */
    public $template_file;
    
    /**
     * Название темы оформления текущего сайта
     * @var string
    */
    public $theme;
    
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
     * Добавляет переменную в общий массив данных для передачи в шаблон
     * 
     * @param string имя переменной в шаблоне
     * @param void   значение
     */
    public function assign($name, $value);

    /**
     * Добавляет переменную по ссылке в общий массив данных для передачи в шаблон
     * 
     * @param string имя переменной в шаблоне
     * @param void   значение
     */
    public function assignByRef($name, &$value);

    /**
     * Загружает файл шаблона
     * 
     * @param string относительный путь к шаблону
     * @return string путь к шаблону
     */
    protected function load($template_file);

    /**
     * Возвращает HTML после обработки данных шаблоном
     * 
     * @return string
     */
    public function getHTML();
}

?>