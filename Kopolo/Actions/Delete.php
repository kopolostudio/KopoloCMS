<?php

/**
* Действие "delete" - удаление позиции модуля
*
* @version 2.1 / 20.06.2011
* @author  Elena Kondratieva [elena@kopolo.ru]
* @package System
* @subpackage Actions
*/

class Kopolo_Actions_Delete extends Kopolo_Actions
{
    /**
    * Шаблон по умолчанию
    * @var string
    */
    public $template = 'actions/delete.tpl';
    
    /**
    * Название действия
    * 
    * @var string
    */
    protected $action_name = 'удаление';
    
    /**
    * Действие
    * 
    * @var string
    */
    protected $action = 'delete';
    
    /**
    * ID удаленного объекта в корзине (Module_RecycleBin)
    * 
    * @var integer
    */
    protected $recyclebin_id;
    
    /**
    * ID пользователя, совершившего действие
    * 
    * @var integer
    */
    protected $user_id;
    
    public function init() 
    {
        $is_system_field = $this->object->is_system_field;
        if (isset($this->item[$is_system_field]) && $this->item[$is_system_field] == 1) {
            Kopolo_Messages::error('Позиция не может быть удалена, т.к. необходима для корректной работы системы.');
        } else {
            $id_field = $this->object->id_field;
            $name_field = $this->object->name_field;
            
            $id_item = $this->item[$id_field];
            if (!empty($this->item) && isset($this->parameters['delete'])) {
                if (isset($this->many_to_many)) {
                    $this->deleteMMItem();
                } else {
                    $this->updatePositions($this->item[$id_field], 0); //XXX ???
                    
                    /* добавление в корзину */
                    $content = Kopolo_Registry::get('content');
                    $this->user_id = $content->auth['user']['us_id'];
                    $this->recyclebin_id = Module_RecycleBin::addObject($this->action, $this->object->__class, $this->item[$id_field], $this->user_id);
                    
                    $res = $this->object->delete();
                    if ($res) {
                        $related_data = Kopolo_Relations::getRelatedData($id_item, $this->module, $this->object->relations, 0);
                        if(!$this->deleteRelatedData($related_data)) {
                            Kopolo_Messages::warning('Ошибка удаления связанных данных.');
                        }
                        
                        $recyclebin_link = '/admin/module/RecycleBin/';
                        $recovery_link = $recyclebin_link . '?action=recovery&rb_id=' . $this->recyclebin_id;
                        Kopolo_Messages::success(
                            'Позиция ' . (!empty($this->item[$name_field]) ? ('&laquo;' . $this->item[$name_field] . '&raquo;') : '')
                            . (!empty($this->recyclebin_id)?' помещена в <a href="' . $recyclebin_link . '">корзину</a>.<br /><a href="' . $recovery_link . '">Отменить удаление</a>':' удалена.')
                        );
                        
                        /* обновление индекса поиска */
                        $this->updateSearchIndex($this->module);
                        
                        /* переадресация */
                        $this->redirect();
                    } else {
                        Kopolo_Messages::error('Произошла ошибка1, позиция не удалена.');
                    }
                }
            } elseif(!empty($this->item)) {
                //передача данных в шаблон
                $this->addContent('itemname', $this->object->getItemName());
                $this->addContent('item', $this->item);
                
                $related_data = Kopolo_Relations::getRelatedData($id_item, $this->module, $this->object->relations);
                $this->addContent('related_data', $related_data);
                
                //XXX костыль - установка страницы, откуда пользователь пришел для правильной переадресации после
                $_SESSION[$this->action . '_referer'] = @$_SERVER['HTTP_REFERER'];
            } else {
                Kopolo_Messages::error('Произошла ошибка, позиция не может быть удалена.');
            }
        }
    }
    
    /**
     * Удаление связанных с удаленным объектом данных
     * 
     * @param array связанные данные
     * @param boolean результат прошлого цикла (для рекурсии)
     * 
     * @return boolean
     */
    protected function deleteRelatedData($related_data, $result = true) {
        if (count($related_data)) {
            foreach($related_data as $modulename => $data) {
                $module    = $data['class'];
                $key_field = $data['field'];
                $value     = $data['value'];
                
                $object = new $module;
                $object->$key_field = $value;
                
                /* для модулей, у которых установлено __site_field */
                if (!empty($object->__site_field)) {
                    $site_id = Kopolo_Registry::get('site_id'); 
                    $object->{$object->__site_field} = $site_id;
                }
                
                /* перебираем, чтобы положить в корзину */
                if (count($data['items'])) {
                    foreach ($data['items'] as $id => $item) {
                        Module_RecycleBin::addObject($this->action, $module, $id, $this->user_id, $this->recyclebin_id);
                    }
                }
                
                /* удаляем по общему родителю */
                if (!is_int($object->delete())) {
                    $result = false;
                }
                
                /* перебираем, чтобы удалить связанные данные (рекурсия) */
                if (count($data['items'])) {
                    foreach ($data['items'] as $id => $item) {
                        $result = $this->deleteRelatedData($item['related_data'], $result);
                    }
                }
            }
        }
        return $result;
    }
    
    /**
    * Удаление позиции из сводной таблицы для связи many_to_many
    * 
    * @param integer 
    */
    protected function deleteMMItem()
    {
        $table = Kopolo_Relations::getMMTableName(&$this->object, &$this->many_to_many->parent_object);
        if (strlen($table)) {
            /* удаляем текущий элемент */
            $sql = "DELETE FROM " . $table . "
                    WHERE 
                        " . $this->many_to_many->field . " = '" . $this->many_to_many->field_value . "'
                    AND
                        " . $this->many_to_many->related_field . " = '" . $this->many_to_many->related_field_value . "'
            ";
            $res = $this->object->query($sql);
            if (is_int($res)) {
                Kopolo_Messages::success('Позиция ' . (!empty($this->item[$this->object->name_field]) ? ('&laquo;' . $this->item[$this->object->name_field] . '&raquo;') : '') . ' успешно удалена.');
                $this->redirect();
            } else {
                Kopolo_Messages::error('Произошла ошибка, позиция не может быть удалена.');
            }
        }
    }
    
    /**
    * Переадресация
    */
    protected function redirect()
    {
        if (!empty($_SESSION[$this->action . '_referer'])) {
            $redirect_url = $_SESSION[$this->action . '_referer'];
            $_SESSION[$this->action . '_referer'] = null;
        } else {
            $redirect_url = '/admin/';
        }
        
        HTTP::redirect($redirect_url);
    }
}
?>