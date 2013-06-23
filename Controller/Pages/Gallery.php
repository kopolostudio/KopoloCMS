<?php

/**
* Галерея страниц
*
* @version 1.1 / 16.07.2011
* @author kopolo.ru
*/

class Controller_Pages_Gallery extends Kopolo_Controller
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
        $this->content->images = Module_Gallery_Images::getImages($content->page['pg_id'], 'Module_Pages');
    }
}
?>