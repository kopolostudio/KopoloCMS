<?php

/**
* Класс настроек модуля Fields
* 
* @author  kopolo.ru
* @version 1.1 [20.06.2011]
* @package Forms
* @subpackage Fields
*/

class Module_Forms_Fields_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Поля формы';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'поле';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Добавление и изменение полей формы';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'fd_group ASC, fd_position ASC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'fd_name';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'fd_form' => array (
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
            'fd_group' => array (
                'quicktype' => 'select',
                'title' => 'Группа',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Forms_Groups',
                        'default' => 'вне групп'
                    )
                )
            ),
            'fd_type' => array (
                'quicktype' => 'select',
                'type' => 'text',
                'length' => 255,
                'title' => 'Тип',
                'form' => array (
                    'options' => array (
                        'text' => 'Текстовое поле',
                        'textarea' => 'Текстовая область',
                        /*'wysiwyg' => 'Визуальный редактор (HTML)',*/
                        'checkbox' => 'Флажок',
                        /*'radio' => 'Переключатель',*/
                        'select' => 'Выпадающий список',
                        'date' => 'Дата',
                        'file' => 'Файл',
                        'captcha' => 'Каптча (защита от спама)',
                    )
                )
            ),
            'fd_required' => array (
                'quicktype' => 'checkbox',
                'title' => 'Обязательно для заполнения',
                'default' => 0
            ),
            'fd_required_text' => array (
                'quicktype' => 'text',
                'title' => 'Текст ошибки при незаполнении обязательного поля',
                'default' => 'Поле обязательно для заполнения',
                'form' => array (
                    'required' => 'Заполнение этого поля обязательно'
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
            'action' => 'edit',
            'name' => 'изменить',
            'title' => 'Изменение формы'
        );
        $actions[] = array (
            'action' => 'delete',
            'name' => 'удалить<br/>',
            'title' => 'Удаление формы'
        );
        
        $actions[] = array (
            'action' => 'list',
            'name' => 'варианты',
            'title' => 'Список вариантов ответа поля',
            'module' => 'Module_Forms_Fields_Variants'
        );
        $actions[] = array (
            'action' => 'add',
            'name' => 'добавить вариант<br/>',
            'title' => 'Добавление варианта ответа',
            'module' => 'Module_Forms_Fields_Variants'
        );
        return $actions;
    }
}