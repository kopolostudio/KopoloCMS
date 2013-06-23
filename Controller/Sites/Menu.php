<?php

/**
* Вывод меню сайта
*
* @version 1.0 / 27.05.2011
* @author kopolo.ru
* @developer Elena Kondrateva [elena@kopolo.ru]
*/

class Controller_Sites_Menu extends Kopolo_Controller
{
    /**
    * Шаблон по умолчанию
    * @var string
    */
    public $template = 'sites/menu.tpl';
    
    protected function init()
    {
        $menu = new Module_Sites_Menu();
        $this->content->menu = $menu->getMenu(Kopolo_Registry::get('site_id'));
    }
}
?>