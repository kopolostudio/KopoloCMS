<?php

/**
* Галерея
*
* @version 1.0 / 29.01.2011
* @author kopolo.ru
*/

class Controller_Gallery_Images extends Kopolo_Controller
{
    /**
    * Шаблон по умолчанию
    * @var string
    */
    public $template = 'gallery/images.tpl';
    
    
    /**
    * Инициализация основной логики контроллера
    */
    protected function init()
    {
        $content = Kopolo_Registry::get('content');
        $this->content->images = Module_Gallery_Images::getImages($content->page['pg_id']);
    }
}
?>