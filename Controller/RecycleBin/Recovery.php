<?php

/**
* Действие "item" для модуля RecycleBin - удаленной позиции модуля
*
* @version 1.1 / 20.06.2011
* @author Elena Kondratieva [elena@kopolo.ru]
*/

class Controller_RecycleBin_Recovery extends Kopolo_Actions_Add
{
    public function init() 
    {
        if (!empty($this->item)) {
            $this->recoveryItem($this->item);
            
            if ($recyclebin['rb_action'] == 'delete') {
                /* получение связанных элементов */
                $recyclebin = new Module_RecycleBin();
                $recyclebin->rb_related_to = $this->item['rb_id'];
                $recyclebin->find();
                if ($recyclebin->N > 0) {
                    while($recyclebin->fetch()) {
                        $this->recoveryItem($recyclebin->toArray());
                    }
                }
            }
            
            $redirect_url = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/admin/module/RecycleBin/';
            HTTP::redirect($redirect_url);
        } else {
            Kopolo_Messages::error('Произошла ошибка, позиция не может быть удалена.');
        }
    }
    
    /**
     * Восстановление позиции
     * 
     * @param array массив с объектом корзины
     */
    public function recoveryItem($recyclebin)
    {
        /* преобразование сериализованного объекта в массив */
        $deleted_item = unserialize($recyclebin['rb_object']);
        
        //инициализация модуля
        $modules = new Module_Modules();
        $modules->get($recyclebin['rb_module']);
        
        $module_class = 'Module_' . $modules->md_nick;
        $module = new $module_class;
        
        $id_field = $module->__prefix . 'id';
        foreach($deleted_item as $field => $value) {
            $module->$field = $value;
            
            if ($field == $id_field) {
                $old_id = $value;
            }
        }
        
        $result = false;
        if ($recyclebin['rb_action'] == 'edit') {
            /* сохранение текущей версии в корзину */
            $content = Kopolo_Registry::get('content');
            $user_id = $content->auth['user']['us_id'];
            $this->recyclebin_id = Module_RecycleBin::addObject('edit', $module_class, $old_id, $user_id);
            
            /* обновление (восстановление сохраненной версии) */
            $result = $module->update();
        } elseif ($recyclebin['rb_action'] == 'delete') {
            $new_id = $module->insert();
            
            /* обновление ID записи до старого значения */
            $result = $module->query("UPDATE " . $module->__table . " SET " . $id_field ."='" . $old_id . "' WHERE " . $id_field ."='" . $new_id . "'");
        }
        
        if($result) {
            /* удаление из корзины */
            $recyclebin_m = new Module_RecycleBin();
            $recyclebin_m->rb_id = $recyclebin['rb_id'];
            $recyclebin_m->delete();
            
            /* обновление позиции, если есть такое поле */
            $position_field = $module->__prefix . 'position';
            if (isset($deleted_item[$position_field])) {
                $this->updatePositions($result, $deleted_item[$position_field]);
            }
            
            /* обновление индекса поиска */
            $this->updateSearchIndex($recyclebin['rb_module']);
            
            Kopolo_Messages::success('Позиция &laquo;' . $recyclebin['rb_name'] . '&raquo; (модуль &laquo;' . $modules->md_name . '&raquo;) восстановлена.');
        }
    }
}
?>