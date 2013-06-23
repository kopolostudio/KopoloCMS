<?php

/**
* Класс настроек модуля Forms
* 
* @author  kopolo.ru
* @version 1.0 [15.06.2011]
* @package System
* @subpackage Forms
*/

class Module_Forms_Senders_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Пользователи, ответившие на форму';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'пользователь';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Просмотр пользователей, которые отправили форму';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'sn_date DESC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'sn_ip';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'sn_form' => array (
                'quicktype' => 'select',
                'title' => 'Форма',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Forms'
                    )
                ),
                'actions' => false
            ),
            'sn_ip' => array (
                'quicktype' => 'text',
                'title' => 'IP пользователя',
                'actions' => array (
                    'list' => true
                )
            ),
            'sn_answer' => array (
                'quickfield' => 'info',
                'title' => 'Данные',
                'actions' => array (
                    'list' => true
                )
            )
        );
        return $definition;
    }
    
    /**
     * Действия для каждой позиции
     * 
     * @return array
     */
    public function getForEachActions()
    {
        $actions[] = array (
            'action' => 'item',
            'name' => 'смотреть',
            'title' => 'Просмотр данных ответа'
        );
        return $actions;
    }
    
    /**
     * Действия для каждой позиции
     * 
     * @return array
     */
    public function getActions()
    {
        $actions[] = array (
            'action' => 'list',
            'name' => 'список',
            'title' => 'Список ответивших на форму'
        );
        return $actions;
    }
}