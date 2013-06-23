<?php
/**
 * Класс настроек модуля Sites_Langs
 * 
 * @version 0.1
 * @package Sites
 */

class Module_Sites_Langs_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Языковые версии сайта';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'сайт';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Управление языковыми версиями сайта';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'lang_position ASC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'lang_name';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition()
    {
        $definition = array (
            'lang_site' => array (
                'quickfield' => 'parent'
            ),
            'lang_picture' => array (
                'quickfield' => 'picture',
                'actions' => array (
                    'list' => true
                )
            )
        );
        return $definition;
    }
}