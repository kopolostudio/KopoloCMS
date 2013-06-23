<?php

/**
* Класс настроек модуля Gallery_Albums
* 
* @version 1.0
* @package Gallery
*/

class Module_Gallery_Albums_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Галерея';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'Коллекция';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Управление альбомами галереи изображений';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'al_position ASC';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
        );
        return $definition;
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
                'name' => 'список коллекций',
                'title' => 'Список коллекций'
            ),
            1 => array (
                'action' => 'add',
                'name' => 'добавить коллекцию',
                'title' => 'Добавление коллекции'
            )
        );
        return $actions;
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
            'title' => 'Изменение коллекции'
        );
        $actions[] = array (
            'action' => 'delete',
            'name' => 'удалить',
            'title' => 'Удаление коллекции'
        );
        $actions[] = array (
            'action' => 'list',
            'name' => 'изображения',
            'title' => 'Список изображений',
            'module' => 'Module_Gallery_Images'
        );
        $actions[] = array (
            'action' => 'add',
            'name' => 'добавить изображение',
            'title' => 'Добавление изображения',
            'module' => 'Module_Gallery_Images'
        );
        return $actions;
    }
}