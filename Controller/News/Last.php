<?php

/**
* Последние новости
*
* @version 1.0 / 20.01.2011
* @package News
* 
* Kopolo CMS [http://kopolocms.ru]
*/

class Controller_News_Last extends Kopolo_Controller
{
    /**
     * Шаблон по умолчанию
     * @var string
     */
    public $template = 'news/last.tpl';
    
    /**
     * Новости
     * @var array
     */
    protected $items;
    
    /**
     * Лимит
     * @var integer
     */
    protected $limit = 3;
    
    /**
    * Установка параметров контроллера
    */
    protected function setParams()
    {
        if (isset($this->parameters['limit']) && is_numeric($this->parameters['limit'])) {
            $this->limit = $this->parameters['limit'];
        }
    }
    
    protected function init()
    {
        $news = new Module_News();
        $news->limit($this->limit);
        $news->ns_is_active = 1;
        $news->whereAdd('ns_date <=' . time());
        $news->orderBy('ns_date DESC');
        $news->find();
        
        /* передача данных в шаблон */
        $this->content->items = $news->fetchArray();
    }
}
?>