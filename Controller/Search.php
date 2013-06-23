<?php

/**
* Поиск (используется индекс поиска - модуль Search_Index)
*
* @version 1.0 / 16.12.2010
* @author kopolo.ru
*/

mb_internal_encoding("UTF-8");

class Controller_Search extends Kopolo_Controller
{
    /**
     * Шаблон по умолчанию
     * @var string
     */
    public $template = 'search.tpl';
    
    /**
    * Результаты поиска
    * @var array
    */
    private $items = array();
    
    /**
    * Поисковый запрос
    * @var string
    */
    private $search_text = '';
    
    /**
    * Число позиций, выводимых на одной странице
    * @var string
    */
    private $items_on_page = 10;

    /**
    * установка параметров контроллера
    * (метод автоматически вызывается из конструктора)
    */
    protected function setParams()
    {
        if (isset($this->parameters['items_on_page']) && is_numeric($this->parameters['items_on_page']) && $this->parameters['items_on_page'] != 0) {
            $this->items_on_pagee = $this->parameters['items_on_page'];
        }
    }
    
    /**
    * Инициализация действия контроллера 
    * (метод автоматически вызывается из конструктора)
    */
    protected function init()
    {
        Kopolo_Session::initSession();
        if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
            $search_text = htmlspecialchars (strip_tags (trim ($_REQUEST['search'])));
            $_SESSION['search_text'] = $search_text;
        } elseif (isset($_SESSION['search_text'])) {
            $search_text = $_SESSION['search_text'];
        }
            
        if (!empty($search_text)) {
            /* сначала ищем обычным LIKE */
            $searchindex = new Module_Search_Index ();
            $searchindex->whereAdd("si_name LIKE '%" . $search_text . "%' OR si_info LIKE '%" . $search_text . "%'");
            $searchindex->find();
            
            $results = array();
            if ($searchindex->N) {
                while ($searchindex->fetch()) {
                    $searchindex->si_name =$this->markSearchText($searchindex->si_name, $search_text);
                    $searchindex->si_info =$this->markSearchText($searchindex->si_info, $search_text);
                    $results[$searchindex->si_id] = $searchindex->toArray();
                }
            }
            
            /* затем ищем FULLTEXT */
            $searchindex = new Module_Search_Index();
            $searchindex->whereAdd ("MATCH (si_name,si_info) AGAINST ('" . $search_text . "')");
            $searchindex->find();
            
            while ($searchindex->fetch()) {
                if (!isset($results[$searchindex->si_id])) {
                    $searchindex->si_name =$this->markSearchText($searchindex->si_name, $search_text);
                    $searchindex->si_info =$this->markSearchText($searchindex->si_info, $search_text);
                    $results[$searchindex->si_id] = $searchindex->toArray();
                }
            }
            
            /* передача данных в шаблон */
            $this->content->items = $results;
            $this->content->count_items = count($results);
            $this->content->search_text = $search_text;
            
            /* постраничная навигация */
            if (count($this->content->items) > $this->items_on_page) {
                $this->content->pager = $this->getPager($this->content->items, $this->items_on_page);
                $this->content->items = $this->content->pager->getPageData();
            }
        }
    }
    
    /**
    * Выделяет в тексте поисковый запрос тегами и обрезает
    * 
    * @param string текст
    * @param string поисковый запрос
    * 
    * @return string обработанный текст
    */
    private function markSearchText($content, $search_text) {
        $length = 200; /*длина текста в результате*/
        
        $pos = mb_strpos($content, $search_text);
        if ($pos !== false) {
            $len = mb_strlen ($search_text);
            $content = mb_substr ($content, $pos>=10?$pos-10:$pos, $pos+$len+$length); 
            $content = '&hellip;' . str_replace ($search_text, '<span class="search-text">' . $search_text . '</span>', $content) . '&hellip;';
        } else { 
            $content = mb_substr ($content, 0, $length) . '&hellip;';
        }
        return $content;
    }
}
?>