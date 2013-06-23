<?php

/**
* Класс настроек модуля Stations
* 
* @package Search
*/

class Module_Search_Index_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Индекс поиска';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Управление индексом поиска';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'si_name ASC';
    
   /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'si_uri' => array (
                'quicktype' => 'text',
                'title' => 'Адрес'
            )
        );
        return $definition;
    }
}