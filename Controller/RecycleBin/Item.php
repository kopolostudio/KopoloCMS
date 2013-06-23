<?php

/**
* Действие "item" для модуля RecycleBin - удаленной позиции модуля
*
* @version 1.0 / 16.06.2011
* @author Elena Kondratieva [elena@kopolo.ru]
*/

class Controller_RecycleBin_Item extends Kopolo_Actions_Item
{
    public function init() 
    {
        if (!empty($this->item)) {
            /* преобразование сериализованного объекта в HTML для просмотра */
            $deleted_item = unserialize($this->item['rb_object']);
            
            //получение определений полей для модуля
            $modules = new Module_Modules();
            $modules->get($this->item['rb_module']);
            
            $module_class = 'Module_' . $modules->md_nick;
            $module = new $module_class;
            $config_class = $module->getConfigClass();
            $config = new $config_class;
            
            //получение основных настроек
            $definitions = $config->getFieldsDefinition();
            
            //выборка свойств с разрешенным показом в данном действии
            $action_definitions = $this->getDefinitions($definitions, $this->allow);
            
            $template = Kopolo_Template::factory('actions/item.tpl');
            $template->assign('item', $deleted_item);
            $template->assign('definitions', $action_definitions);
            $deleted_item_html = $template->getHTML();
            
            $this->item['rb_object'] = $deleted_item_html;
            parent::init();
        }
    }
}
?>