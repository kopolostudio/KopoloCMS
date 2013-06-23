<?php

/**
 * Модуль параметров (настроек) для сайтов/компонентов/контроллеров
 *
 * @author  kopolo.ru
 * @version 0.1 [19.09.2010]
 * @package Params
 */

class Module_Params extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'pm_';
    public $__multilang = true;
    public $__site_field = 'pm_site';
    
    /*Db fields*/
    public $pm_id;
    public $pm_site;
    public $pm_component;
    public $pm_name;
    public $pm_nick;
    public $pm_value;
    
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
        
        $relations['belongs_to']['Module_Sites'] = 'pm_site';
        $relations['belongs_to']['Module_Components'] = 'pm_component';
        
        return $relations;
    }
    
    /**
     * Получение списка параметров сайта
     *
     * @param integer ID сайта
     * @param integer ID компонента
     * @return array название переменной => значение
     */
    public function getParams($site_id, $component_id = 0) {
        $params = array();
        
        $this->pm_site = $site_id;
        $this->pm_component = $component_id;
        $this->find();
        if ($this->N > 0) {
            $value_field_name = 'pm_value';
            $value_field_name_lang = 'pm_value';
            if (MULTILANG==true && MULTILANG_TYPE=='fields') { 
                $lang = Kopolo_Registry::get('lang');
                $value_field_name_lang = 'pm_value' . '_' . $lang;
            }
            while ($this->fetch()) {
                $params[$this->pm_nick] = !empty($this->$value_field_name_lang)?$this->$value_field_name_lang:$this->$value_field_name;
            }
        }
        return $params;
    }
}