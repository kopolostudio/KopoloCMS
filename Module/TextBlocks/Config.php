<?php

/**
* Класс настроек модуля TextBlocks
*/

class Module_TextBlocks_Config extends Kopolo_Module_Config
{
    /**
    * Название модуля
    * @var string
    */
    protected $module_name = 'Текстовые блоки';
    
    /**
    * Название позиции
    * @var string
    */
    protected $item_name = 'текстовый блок';
    
    /**
    * Комментарий о назначении модуля
    * @var string
    */
    protected $module_comment = 'Добавление и изменение текстовых блоков';
    
    /**
    * Дополнительная информация о модуле
    * @var string
    */
    protected $info = 'Добавленные текстовые блоки показываются на всех страницах сайта.';
    
    /**
    * Сортировка позиций модуля
    * @var string
    */
    protected $order_by = 'tb_name ASC';
    
    /**
    * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
    * 
    * @return array
    */
    public function getQuickFieldsDefinition() 
    {
        $definition = array ();
        
        //действие разрешено только для администраторов
        $content = Kopolo_Registry::get('content');
        if (isset($content->auth['user']) && $content->auth['user']['us_group'] == 1) {
            $definition['tb_nick'] = array (
                'quickfield' => 'nick',
                'default' => 'sidebar',
                'title' => 'Расположение',
                'form' => array(
                    'type' => 'select',
                    'options' => array(
                        'sidebar' => 'боковая колонка',
                        'content' => 'основная колонка'
                    )
                )
            );
        }
        return $definition;
    }
}
?>