<?php

/**
 * Модуль сайтов, реализует хранение информации о сайтах для поддержки многосайтовости
 *
 * @author  kopolo.ru
 * @version 0.1 [16.11.2010]
 * @package Sites
 */

class Module_Sites extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'st_';
    public $__multilang = false;
    
    /*Db fields*/
    public $st_id;
    public $st_name;
    //public $st_nick;
    public $st_domain;
    public $st_theme;
    public $st_is_active;
    
    /**
     * Получение связей с другими модулями в формате массива с элементами: тип связи, модуль, поле для связи
     * Возможные типы: belongs_to, has_one, has_many, many_to_many
     * 
     * @example array('has_many', 'Module_Images', 'pg_id')
     * @return array
    */
    public function getRelations()
    {
        $relations = array();
        
        $relations['has_many']['Module_Sites_Langs'] = 'st_id';
        $relations['has_many']['Module_Sites_Menu']  = 'st_id';
        
        return $relations;
    }
    
    /**
     * Получение ID сайта по названию домена
     *
     * @param string домен
     * @return integer or false
     */
    public function getSite($domain) 
    {
        $this->whereAdd("st_domain = '" . $domain . "'");
        $this->find(true);
        if ($this->N == 1) {
            return $this;
        }
        return false;
    }
}