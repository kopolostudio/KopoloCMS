<?php

/**
* Класс настроек модуля Gallery_Images
* 
* @version 0.1
* @package Gallery
*/

class Module_Gallery_Images_Config extends Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name = 'Изображения';
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = 'Изображение';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment = 'Управление галереей изображений';
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by = 'img_position ASC';
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $definition = array (
            'img_name' => array (
                'type' => 'text',
                'length' => 255,
                'title' => 'Название',
                'form' => array (
                    'type' => 'text',
                ),
                'actions' => array(
                    'list' => true
                )
            ),
            'img_album' => array (
                'type' => 'text',
                'length' => 255,
                'title' => 'Альбом',
                'default' => 0,
                'form' => array (
                    'type' => 'select',
                    'options' => array()
                ),
                'actions' => false
            ),
            'img_picture' => array (
                'quickfield' => 'picture',
                'form' => array (
                    'rules' => array (
                        'required' => 'Загрузка изображения обязательна'
                    )
                ),
                'actions' => array (
                    'list' => true
                )
            ),
            'img_module' => array (
                'quicktype' => 'text',
                'title' => 'Родительский класс',
                'actions' => false
            )
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
                'name' => 'список изображений',
                'title' => 'Список изображений'
            ),
            1 => array (
                'action' => 'add',
                'name' => 'добавить изображение',
                'title' => 'Добавление изображения'
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
            'title' => 'Изменение изображения'
        );
        $actions[] = array (
            'action' => 'delete',
            'name' => 'удалить',
            'title' => 'Удаление изображения'
        );
        return $actions;
    }
}