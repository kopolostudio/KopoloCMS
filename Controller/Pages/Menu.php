<?php

/**
* Вывод меню страниц (дерево)
*
* @version 1.1 / 08.02.2011
* @author kopolo.ru
*/

class Controller_Pages_Menu extends Kopolo_Controller
{
    /**
     * Шаблон по умолчанию
     * @var string
     */
    public $template = 'menu.tpl';
    
    protected function init()
    {
        /* получение списка активных страниц с установленным свойством "Показывать в меню" */
        $pages = new Module_Pages();
        $pages->pg_is_active = 1;
        $pages->pg_in_menu = 1;
        //$pages->selectAdd();
        //$pages->selectAdd('pg_id, pg_name, pg_nick');
        $pages->orderBy('pg_position ASC');
        $menu = $pages->getFullTree();
        
        /*** передача данных в шаблон ***/
        /* массив страниц */
        $this->addContent('menu', $menu);
        Kopolo_Registry::appendTo('content', 'menu', $menu); //var_dump($menu);
        
        /* текущая страница */
        $content = Kopolo_Registry::get('content');
        $this->addContent('page', $content->page); 
    }
}
?>