<?php

/**
* Класс настроек модуля Forms
* 
* @author  kopolo.ru
* @version 1.0 [15.06.2011]
* @package System
* @subpackage Forms
*/

class Module_Forms_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Формы';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'форма';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Добавление и изменение форм отправки данных';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'form_id ASC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'form_name';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'form_page' => array (
                'quicktype' => 'select',
                'title' => 'Страница',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Pages',
                        'default' => 'общая'
                    )
                )
            ),
            'form_comment' => array (
                'quicktype' => 'text',
                'title' => 'Описание'
            ),
            'form_method' => array (
                'type' => 'text',
                'length' => 4,
                'title' => 'Метод отправки',
                'form' => array (
                    'type' => 'select',
                    'options' => array (
                        'post' => 'POST',
                        'get'  => 'GET'
                    )
                )
            ),
            'form_action' => array (
                'quicktype' => 'text',
                'title' => 'Адрес назначения'
            ),
            'form_submit_text' => array (
                'quicktype' => 'text',
                'title' => 'Текст на кнопке отправки',
                'default' => 'Отправить'
            ),
            'form_success_text' => array (
                'quickfield' => 'info',
                'title' => 'Текст после успешной отправки формы',
                'form' => array (
                    'required' => 'Заполнение этого поля обязательно'
                )
            ),
            'form_error_text' => array (
                'quicktype' => 'text',
                'title' => 'Текст после отправки формы с ошибками',
                'default' => 'Форма заполнена неверно, исправьте пожалуйста ошибки.',
                'form' => array (
                    'required' => 'Заполнение этого поля обязательно'
                )
            ),
            'form_files_dir' => array (
                'quicktype' => 'text',
                'title' => 'Директория для сохрания файлов',
                'form' => array (
                    'comment' => 'без открывающего и закрывающего слешей, по умолчанию - псевдоним формы'
                )
            ),
            'form_save_answers' => array (
                'quicktype' => 'checkbox',
                'title' => 'Сохранять ответы'
            ),
            'form_send_to_email' => array (
                'quickfield' => 'email',
                'title' => 'Отправлять ответы на email'
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
        
        /* не реализовано
        $actions[] = array (
            'action' => 'list',
            'name' => 'группы полей',
            'title' => 'Список групп полей формы',
            'module' => 'Module_Forms_Groups'
        );
        $actions[] = array (
            'action' => 'add',
            'name' => 'добавить группу<br/>',
            'title' => 'Добавление группы полей',
            'module' => 'Module_Forms_Groups'
        );
        */
        
        $actions[] = array (
            'action' => 'list',
            'name' => 'поля',
            'title' => 'Список полей формы',
            'module' => 'Module_Forms_Fields'
        );
        $actions[] = array (
            'action' => 'add',
            'name' => 'добавить поле<br/>',
            'title' => 'Добавление поля в форму',
            'module' => 'Module_Forms_Fields'
        );
        
        $actions[] = array (
            'action' => 'list',
            'name' => 'ответы',
            'title' => 'Список пользователей',
            'module' => 'Module_Forms_Senders',
            'icon' => 'user'
        );
 
        return $actions;
    }
}