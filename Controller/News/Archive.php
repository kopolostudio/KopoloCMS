<?php

/**
* Новости - главный контроллер
*
* @version 1.0 / 20.01.2011
* @package News
* 
* Kopolo CMS [http://kopolocms.ru]
*/

class Controller_News_Archive extends Kopolo_Controller
{
    /**
     * Шаблон по умолчанию
     * @var string
     */
    public $template = 'news/archive.tpl';
    
    /**
     * Новости
     * @var array
     */
    protected $items;
    
    /**
     * Новость
     * @var object
     */
    protected $item;
    
    /**
     * Число новостей на одной странице архива
     * @var integer
     */
    protected $items_on_page = 10;
    
    /**
    * Установка параметров контроллера
    */
    protected function setParams()
    {
        if (isset($this->parameters['items_on_page']) && is_numeric($this->parameters['items_on_page']) && $this->parameters['items_on_page'] != 0) {
            $this->items_on_page = $this->parameters['items_on_page'];
        }
    }
    
    protected function init()
    {
        $page = Kopolo_Page::getInstance();
        
        $news = new Module_News();
        
        if (isset($_GET['item_id']) && is_numeric($_GET['item_id'])) /* Вывод конретной новости (по ID) */
        {
            $news->get($_GET['item_id']);
            
            if ($news->N == 0 || $news->ns_is_active != 1)
            {
                $this->error404 = true;
            } else
            {
                /* установка meta-тегов для страницы */
                $page->setTitle (!empty($news->ns_title)?$news->ns_title:$news->ns_name);
                
                if (!empty($news->ns_name)) {
                    $page->setHeader($news->ns_name);
                }
                if (!empty($news->ns_description)) {
                    $page->setDescription($news->ns_description);
                }
                if (!empty($news->ns_keywords)) {
                    $page->setKeywords($news->ns_keywords);
                }
                
                /* передача данных в шаблон */
                $this->content->item = $news->toArray();
            }
        } else { /* Вывод архива */
            $news->ns_is_active = 1;
            $news->whereAdd('ns_date <=' . time());
            $news->orderBy('ns_date DESC');
            $news->find();
            
            /* передача данных в шаблон */
            $this->content->items = $news->fetchArray();
            
            /* постраничная навигация */
            if (count($this->content->items) > $this->items_on_page) {
                $this->content->pager = $this->getPager($this->content->items, $this->items_on_page);
                $this->content->items = $this->content->pager->getPageData();
            }
        }
    }
}
?>