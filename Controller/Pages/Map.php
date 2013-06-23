<?php

/**
* Контроллер: карта сайта
*
* @version 1.0 / 25.01.2011
* @author kopolo.ru
*/

class Controller_Pages_Map extends Kopolo_Controller
{
    /**
     * Шаблон по умолчанию
     * @var string
     */
    public $template = 'map.tpl';
    
    function init()
    {
        $page = new Module_Pages();
        $page->selectAdd();
        $page->selectAdd('pg_id, pg_name, pg_nick');
        $page->whereAdd("pg_in_map = '1'");
        $page->orderBy("pg_position ASC");
        $this->content->map = $page->getFullTree();
        
        $page = Kopolo_Page::getInstance();
        $this->content->header = $page->content->page['pg_header'];
        $page->setHeader ('');
    }
}
?>