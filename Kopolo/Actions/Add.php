<?php

/**
* Действие "add" - добавление новой позиции модуля
*
* @version 0.2 / 24.02.2011
* @author kopolo.ru
* @developer Elena Kondratieva [elena@kopolo.ru]
*/

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Renderer.php';

class Kopolo_Actions_Add extends Kopolo_Actions_Edit
{
    /**
    * Название действия
    * 
    * @var string
    */
    protected $action_name = 'добавление';
    
    /**
    * Действие
    * 
    * @var string
    */
    protected $action = 'add';
    
    /**
    * Разрешен ли в действии по умолчанию показ полей
    * 
    * @var boolean
    */
    protected $allow = true;
    
    /**
    * Шаблон по умолчанию
    * @var string
    */
    public $template = 'actions/add.tpl';
    
    public function init() 
    {
        $form = $this->initForm($this->action_definitions);
        
        //добавление кнопки отправки данных в форму
        $form->addElement('button', 'submit', array('type' => 'submit'),array('content' => 'Добавить'));
        
        //Валидация формы
        if ($form->validate()) {
            $values = $form->getValue();
            
            //дополнительные параметры из GET
            foreach ($this->definitions as $field => $def) {
                if (isset($this->parameters[$field])) {
                    $values[$field] = $this->parameters[$field];
                }
            }
            
            $item_id = $this->addItem($values);
            if (is_int($item_id)) {
                Kopolo_Messages::success('Позиция успешно добавлена.');
                
                /* обновление позиции, если есть такое поле */
                $position_field = $this->object->__prefix . 'position';
                if (isset($values[$position_field])) {
                    $res = $this->updatePositions($item_id, $values[$position_field]);
                    if (!$res) {
                        Kopolo_Messages::error('Не удалось обновить значения поля "' . $position_field . '" у других записей.');
                    }
                }
                
                /* обновление индекса поиска */
                $this->updateSearchIndex($this->module);
                
                $this->redirect();
            } else {
                Kopolo_Messages::error('Произошла ошибка, позиция не добавлена.');
            }
        }
        
        //передача данных в шаблон
        $this->addContent('form', $form->html());
        
        //костыль - установка страницы, откуда пользователь пришел для правильной переадресации после
        $_SESSION[$this->action . '_referer'] = $_SERVER['HTTP_REFERER'];
    }
    
    /**
    * Добавление позиции
    * 
    * @param array  значения полей
    * @return integer ID вставленной записи или false
    */
    protected function addItem($values)
    {
        if (isset($this->many_to_many)) {
            $result = $this->addMMItem($values);
            return $result;
        }
        
        $object =  $this->object;
        
        //установка значений
        foreach ($values as $field_name => $value) {
            
                 if (!is_array($value)) {
                     $object->$field_name = $value;
                 } else {
                    /*Загружаемый файл*/
                    if (isset($value['tmp_name']) && !empty($value['tmp_name'])) {
                        $value = Kopolo_File::moveUploadedFile($value,$this->module);
                        $object->$field_name = $value;
                    } else {
                        /*Если информации о файле не пришло, то не обновляем поле*/
                    }
                } 
        }
        
        //установка родителя
        if (isset($object->relations['belongs_to'])) {
            foreach($object->relations['belongs_to'] as $parent_class => $parent_field) {
                if (isset($this->parameters[$parent_field])) {
                    $object->$parent_field = $this->parameters[$parent_field];
                    continue;
                }
            }
        }

//DB_DataObject::debugLevel(2);
        $result = $object->insert();
        return $result;
    }
    
    /**
    * Добавление позиции в сводную таблицу для связи many_to_many
    * 
    * @param array  значения полей
    * @return 1 or false
    */
    protected function addMMItem($values)
    {
        $table = Kopolo_Relations::getMMTableName(&$this->object, &$this->many_to_many->parent_object);
        if (strlen($table) && isset($values[$this->many_to_many->field])) {
            /* проверка на уникальность нового значения */
            $sql = "SELECT COUNT(*) AS count 
                    FROM " . $table . "
                    WHERE 
                        " . $this->many_to_many->field . " = '" . $values[$this->many_to_many->field] . "'
                    AND
                        " . $this->many_to_many->related_field . " = '" . $this->many_to_many->related_field_value . "'
            
            ";
            $this->object->query($sql);
            $this->object->fetch();
            
            /* если нет такого сочетания - добавляем */
            if ($this->object->count == 0) {
                $sql = "INSERT INTO " . $table . "
                        SET 
                            " . $this->many_to_many->field . " = '" . $values[$this->many_to_many->field] . "',
                            " . $this->many_to_many->related_field . " = '" . $this->parameters[$this->many_to_many->related_field] . "'
                ";
                $res = $this->object->query($sql);
                return $res;
            }
        }
        return false;
    }
    
    /**
     * Переадресация после добавления позиции
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