<?php

/**
* Модуль изображений галереи
* 
* @version 1.2 [17.02.2011]
*/

class Module_Gallery_Images extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'img_';
    public $__multisiting = true;
    
    /*Db fields*/
    public $img_id;
    public $img_parent;
    public $img_module;
    public $img_album;

    public $img_name;
    public $img_picture;

    public $img_is_active;
    public $img_position;
    
    /**
     * Получение связей с другими модулями в формате массива с элеменами: тип связи, модуль, поле для связи
     * Возможные типы: belongs_to, has_one, has_many, many_to_many
     * 
     * @example array('has_many', 'Module_Gallery', 'pg_id')
     * @return array
    */
    public function getRelations()
    {
        $relations = array();
        
        $relations['belongs_to']['Module_Gallery_Albums'] = 'img_album';
        $relations['belongs_to']['Module_Pages'] = 'img_parent';
        $relations['belongs_to']['Module_CatalogSimple_Items'] = 'img_parent';
        
        return $relations;
    }
    
    /**
    * Получение изображений для позиции
    * 
    * @param integer ID позиции (родителя)
    * @param string тип галереи (привязка к модулю)
    * @return array
    */
    public static function getImages($parent, $module=false)
    {
        $images = new Module_Gallery_Images();
        $images->img_is_active = 1;
        $images->img_parent = $parent;
        if ($module != false) {
            $images->img_module = $module;
        }
        $images->orderBy('img_position ASC');
        $images->find();
        return $images->fetchArray();
    }
}