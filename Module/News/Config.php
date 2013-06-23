<?php

/**
* Класс настроек модуля News
* 
* @version 1.1 / 15.06.2011
* @package News
* 
* Kopolo CMS [http://kopolocms.ru]
*/

class Module_News_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Новости';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'Новость';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Добавление и изменение новостей';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'ns_date DESC';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'ns_announce' => array (
                'quicktype' => 'textarea',
                'title' => 'Анонс (краткое содержание)',
                'actions' => array (
                    'list' => true
                )
            ),
            'ns_info' => array (
                'type' => 'clob',
                'length' => 30000,
                'title' => 'Текст новости',
                'form' => array (
                    'type' => 'wysiwyg',
                    'rules' => array(
                        'required' => 'Заполнение этого поля обязательно'
                    )
                )
            ),
            'ns_author' => array (
                'quicktype' => 'text',
                'title' => 'Автор'
            ),
            'ns_source' => array (
                'quicktype' => 'text',
                'title' => 'Источник'
            )
        );
        return $definition;
    }
}