<?php

/**
* Класс настроек модуля Variants
* 
* @author  kopolo.ru
* @version 1.0 [20.06.2011]
* @package Forms
* @subpackage Variants
*/

class Module_Forms_Fields_Variants_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Варианты ответа';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'вариант';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Добавление и изменение вариантов ответа';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'vt_position ASC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'vt_value';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'vt_field' => array (
                'quicktype' => 'select',
                'title' => 'Поле',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Forms_Fields'
                    )
                ),
                'actions' => false
            ),
            'vt_value' => array (
                'quicktype' => 'text',
                'title' => 'Текст',
                'actions' => array (
                    'list' => true
                )
            )
        );
        return $definition;
    }
}