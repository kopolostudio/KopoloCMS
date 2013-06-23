<?php

/**
* Галерея (список альбомов)
*
* @version 1.0 / 17.02.2011
*/

class Controller_Gallery_Albums extends Kopolo_Controller
{
    /**
    * Шаблон по умолчанию
    * @var string
    */
    public $template = 'gallery/albums.tpl';
    
    /**
    * Число альбомов на странице
    * @var integer
    */
    public $items_on_page = 5;
    
    /**
    * установка параметров контроллера
    */
    protected function setParams()
    {
        if (isset($this->parameters['items_on_page']) && strlen($this->parameters['items_on_page'])) {
            $this->items_on_page = $this->parameters['items_on_page'];
        }
    }
    
    protected function init()
    {
        /* получение списка альбомов и изображений в них */
        $albums = new Module_Gallery_Albums();
        $albums->al_is_active = 1;
        $albums->orderBy('al_position ASC');
        $albums->find();
        
        $gallery = array();
        if ($albums->N > 0) {
            while($albums->fetch()) {
                if (count($gallery) <= $this->items_on_page) {
                    $images = new Module_Gallery_Images();
                    $images->img_album = $albums->al_id;
                    $images->img_is_active = 1;
                    $images->orderBy('img_position ASC, img_id ASC');
                    $images->find();
                    $images_list = $images->fetchArray();
                }
                
                $gallery[$albums->al_position] = $albums->toArray();
                $gallery[$albums->al_position]['images'] = $images_list;
            }
        }
        
        /* передача данных в шаблон */
        $this->content->albums = $gallery;
        
        /* постраничная навигация */
        if (count($this->content->albums) > $this->items_on_page) {
            $this->content->pager = $this->getPager($this->content->albums, $this->items_on_page);
            $this->content->albums = $this->content->pager->getPageData();
        }
    }
}
?>