<?php

/**
* Класс настроек модуля RecycleBin
* 
* @author  kopolo.ru
* @version 1.0 [16.06.2011]
* @package System
* @package RecycleBin
*/

class Module_RecycleBin_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Корзина';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'позиция';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Удаленные и измененные позиции';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'rb_datetime DESC';
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field = 'rb_name';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'rb_module' => array (
                'quicktype' => 'select',
                'title' => 'Модуль',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Modules'
                    )
                ),
                'actions' => array (
                    'list' => true
                )
            ),
            'rb_user' => array (
                'quicktype' => 'select',
                'title' => 'Пользователь',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_Users'
                    )
                ),
                'actions' => array (
                    'list' => true
                )
            ),
            'rb_object' => array (
                'type' => 'clob',
                'title' => 'Позиция'
            ),
            'rb_related_to' => array (
                'quicktype' => 'select',
                'title' => 'Связано с удаленным объектом',
                'form' => array (
                    'options' => false,
                    'getoptions' => array (
                        'class' => 'Module_RecycleBin',
                        'default' => 'нет'
                    )
                )
            ),
            'rb_action' => array (
                'quicktype' => 'select',
                'type' => 'text',
                'length' => 10,
                'title' => 'Действие',
                'form' => array (
                    'options' => array (
                        'edit' => 'изменение',
                        'delete' => 'удаление'
                    )
                ),
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
            'name' => 'просмотр',
            'title' => 'Просмотр позиции'
        );
        $actions[] = array (
            'action' => 'recovery',
            'name'   => 'восстановить',
            'title'  => 'Восстановление позиции',
            'icon'   => 'arrow-circle'
        );
        $actions[] = array (
            'action' => 'delete',
            'name' => 'удалить<br/>',
            'title' => 'Безвозвратное удаление позиции'
        );
        return $actions;
    }
    
    /**
     * Действия модуля (для всех позиций)
     * 
     * @return array
     */
    public function getActions()
    {
        $actions = array (
            0 => array (
                'action' => 'list',
                'name' => 'список позиций'
            ),
            1 => array (
                'action' => 'clear',
                'name' => 'очистить корзину',
                'icon' => 'trash'
            )
        );
        return $actions;
    }
    
    /**
     * Дополнительные условия для выборки для действия list (список)
     * 
     * @return array
     */
    public function getActionConditionsList() {
        $conditions = array ();
        if (!isset($_GET['rb_id'])) {
            $conditions[] = 'rb_related_to=\'0\'';
        }
        return $conditions;
    }
}