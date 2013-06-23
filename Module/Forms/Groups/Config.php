<?php

/**
* Класс настроек модуля Groups
* 
* @author  kopolo.ru
* @version 1.0 / 15.06.2011
* @package System
* @subpackage Forms
*/

class Module_Forms_Groups_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Группы полей формы';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'группа';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Добавление и изменение групп полей формы';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'gr_position ASC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'gr_name';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'gr_form' => array (
                'quicktype' => 'select',
                'title' => 'Форма',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Forms'
                    )
                ),
                'actions' => false
            )
        );
        return $definition;
    }
}