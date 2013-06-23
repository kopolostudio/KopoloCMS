<?php

/**
 * Модуль языков, реализует хранение информации о языковых версиях сайтов для поддержки мультиязычности
 *
 * @author  kopolo.ru
 * @version 0.1 [27.02.2011]
 * @package Sites
 */

class Module_Sites_Langs extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'lang_';
    public $__multilang = false;
    
    /*Db fields*/
    public $lang_id;
    public $lang_site;
    public $lang_name;
    public $lang_nick;
    public $lang_picture;
    public $lang_is_active;
    public $lang_position;
    //public $lang_theme;?
    //public $lang_domain;?
    
    
    /**
     * Получение связей с другими модулями в формате массива с элеменами: тип связи, модуль, поле для связи
     * Возможные типы: belongs_to, has_one, has_many, many_to_many
     * 
     * @example array('has_many', 'Module_Images', 'pg_id')
     * @return array
    */
    public function getRelations()
    {
        $relations = array();
        
        $relations['belongs_to']['Module_Sites'] = 'lang_site';
        
        return $relations;
    }
    
    /**
     * Получение списка языков для сайта
     * 
     * @param integer ID сайта
     * @return array
    */
    public function getLangs($site_id) {
        $this->lang_site = $site_id;
        $this->lang_is_active = 1;
        $this->orderBy('lang_position ASC');
        $this->find();
        
        $langs = array();
        if ($this->N > 0) {
            while($this->fetch()) {
                $langs[$this->lang_nick] = $this->toArray();
            }
        }
        return $langs;
    }
}