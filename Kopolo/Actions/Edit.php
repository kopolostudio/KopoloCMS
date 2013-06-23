<?php

/**
* Действие "edit" - изменение позиции модуля
*
* @version 0.3 / 24.02.2011
* @author kopolo.ru
* @developer Elena Kondratieva [elena@kopolo.ru]
*/

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Renderer.php';

class Kopolo_Actions_Edit extends Kopolo_Actions
{
    /**
    * Название действия
    *
    * @var string
    */
    protected $action_name = 'изменение';
    
    /**
    * Действие
    *
    * @var string
    */
    protected $action = 'edit';
    
    /**
    * Разрешен ли в действии по умолчанию показ полей
    *
    * @var boolean
    */
    protected $allow = true;
    
    /**
     * Форма редактирования
     *
     * @var object
     */
    protected $form;
    
    /**
    * ID удаленного объекта в корзине (Module_RecycleBin)
    *
    * @var integer
    */
    protected $recyclebin_id;
    
    
    public function init()
    {
        if (!empty($this->item)) {
            $this->redirect = Kopolo_Registry::get('full_uri');
            
            $default_values = $this->item;
            $this->form = $this->initForm($this->action_definitions, $default_values);
    
            //добавление кнопки отправки данных в форму
            $this->form->addElement('button', 'submit', array('type' => 'submit'),array('content' => 'Сохранить изменения'));
            
            $this->validate();
            
            //передача данных в шаблон
            $this->addContent('form', $this->form->html());
            $this->addContent('item', $this->item);
            
            return true;
        } else {
            return false; //XXX установка ошибки 404?
        }
    }
    
    /**
    * Валидация формы
    */
    protected function validate()
    {
        if (!empty($_POST)) {
            if ($this->form->validate()) {
                $values = $this->form->getValue();
                
                $id_field = $this->object->id_field;
                
                /* добавление в корзину */
                $content = Kopolo_Registry::get('content');
                $user_id = $content->auth['user']['us_id'];
                $this->recyclebin_id = Module_RecycleBin::addObject($this->action, $this->object->__class, $this->item[$id_field], $user_id);
                
                $this->updateItem($this->item[$id_field], $values, $this->action_definitions);
            } else {
                Kopolo_Messages::error('Форма заполнена неверно, позиция не обновлена.');
            }
        }
    }
    
    /**
    * Инициализация формы редактирования
    *
    * @param array  определения полей для изменения
    * @param array значения по умолчанию
    * @return string HTML формы
    */
    protected function initForm(array $definitions, array $default_values = array())
    {
        $form = new Kopolo_Form('form');
        
        //если значения по умолчению не переданы, то получаем их из определений полей
        if (count($default_values) == 0) {
            $default_values_def =  array();
        }
        
        if (!isset($this->many_to_many)) {
            /* стандартный способ инициализации формы (все поля) */
            foreach ($definitions as $field_name => $def) {
                
                //проверка, указан ли тип поля формы в определении поля, если не указан - ставим тип 'text'
                if (!isset($def['form']['type'])) {
                    Kopolo_Messages::warning('Не указан тип поля формы в определении ' . $field_name . ', установлен тип text.');
                    $def['form']['type'] = 'text';
                }
                
                //проверка указанного типа поля формы на соответствие зарегистрированным типам
                if (HTML_QuickForm2_Factory::isElementRegistered($def['form']['type']) == false) {
                    Kopolo_Messages::warning('Неизвестный тип поля формы ' . $def['form']['type'] . ' в определении ' . $field_name . '.');
                    continue;
                }
                
                /*** обработка position ***/
                if (strstr($field_name, 'position') && $def['form']['type'] == 'select') {
                    /* Временно захардкодим XXX */
                    $selected_text = 'текущая позиция';
                    $before_text = 'перед';
                    $after_text = 'после';
                    $new_text = 'в конец списка';
                    
                    /* Префикс полей объекта */
                    $prefix = $this->object->__prefix;
                    
                    /*Редактируемый объект*/
                    $item = $this->item;
                    
                    /* Родственники объекта */
                    $object_siblings = new $this->module;
                    if (isset($this->object->relations['belongs_to'])) {
                        if (isset($this->parameters['parent_module']) && count($this->object->relations['belongs_to']) > 1) {
                            /* XXX может быть несколько belongs_to */
                            if (isset($this->object->relations['belongs_to'][$this->parameters['parent_module']])) {
                                if (isset($this->object->relations['belongs_to'][$this->parameters['parent_module']])) {
                                    $parent_field = $this->object->relations['belongs_to'][$this->parameters['parent_module']];
                                }
                            }
                        } else {
                            foreach($this->object->relations['belongs_to'] as $module => $field) {
                                $parent_field = $field;
                            }
                        }
                    }
                    
                    if (isset($parent_field)) {
                        if (isset($item[$parent_field])) {
                            $object_siblings->$parent_field = $item[$parent_field];
                        } elseif (isset($this->parameters[$parent_field])) {
                            $object_siblings->$parent_field = $this->parameters[$parent_field];
                        } else {
                            $object_siblings->$parent_field = 0;
                        }
                    }
                    
                    $object_siblings->orderBy($prefix . 'position ASC');
                    $object_siblings->find();
                    
                    if ($object_siblings->N > 0 && $object_siblings->N <= 1000) {
                        $def['form']['options'] = array();
                        $pos_counter = 1;
                        $name_field = $this->object->name_field;
                        while ($object_siblings->fetch()) {
                            if ($object_siblings->{$prefix.'position'}<$item[$prefix.'position'] || empty($item[$prefix.'position'])) {
                                $def['form']['options'][$pos_counter] = !empty($object_siblings->$name_field)?($pos_counter.' - ' . $before_text . ' ' . '"' .  $object_siblings->$name_field . '"') : $pos_counter;
                            } elseif ($object_siblings->{$prefix.'position'}>$item[$prefix.'position']) {
                                $def['form']['options'][$pos_counter] = !empty($object_siblings->$name_field)?($pos_counter.' - ' . $after_text . ' ' . '"' .  $object_siblings->$name_field . '"') : $pos_counter;
                            } else {
                                $def['form']['options'][$pos_counter] = $pos_counter
                                    . ' - ' . $selected_text;
                            }
                            $pos_counter++;
                        }
                        if (empty($item[$prefix.'id'])) {
                            /*Если это добавление нового элемента, то добавим еще один пункт*/
                            $def['form']['options'][$pos_counter] = $pos_counter . ' - ' . $new_text;
                            $def['default'] = $pos_counter;
                        }
                    } elseif ($object_siblings->N > 1000) {
                        $def['form']['type'] = 'text';
                    } elseif ($object_siblings->N == 0) { /* Если это первая добавляемая запись */
                        $def['form']['options'] = array(1, 1);
                    }
                }

                
                //проверка остальных select'ов на наличие вариантов (options)
                if ($def['form']['type'] == 'select' && (!isset($def['form']['options']) || count($def['form']['options']) == 0)) {
                    Kopolo_Messages::warning('Не переданы варианты (options) для типа поля формы ' . $def['form']['type'] . ' в определении ' . $field_name . '.');
                    continue;
                }
                
                //проверка наличия специального метода для обработки поля
                $method = 'getStatic_' . $field_name;
                if (method_exists($this->object, $method)) {
                    if (call_user_func_array (array($this->object_class, $method), array(&$form, $def, isset($default_values[$field_name])?$default_values[$field_name]:null))) {
                        continue;
                    }
                }
                //стандартное добавление элемента в форму
                $data = isset($def['data']['options']) ? $def['form']['data'] : array();
                $data['label'] = $def['title'];
                $data['options'] = isset($def['form']['options']) ? $def['form']['options'] : array(); //опции для SELECT и прочих
                $element = $form->addElement(
                    $def['form']['type'],
                    $field_name,
                    (isset($def['attributes']) ? $def['attributes'] : array()),
                    $data
                );
                
                //Добавим специальный класс к чекбоксам
                if ($def['form']['type'] == 'checkbox') {
                    $element->addClass('checkbox');
                }
                
                //Добавление правил к добавленному элементу
                if (isset($def['form']['rules']) && is_array($def['form']['rules'])) {
                    foreach ($def['form']['rules'] as $rule_name=>$rule_array) {
                        if (is_array($rule_array)) {
                            $rule_message = $rule_array['message'];
                            $rule_options = $rule_array['options'];
                        } else {
                            $rule_message = $rule_array;
                            $rule_options = NULL;
                        }
                        $element->addRule($rule_name, $rule_message, $rule_options);
                    }
                }
                
                //Добавление комментария, если он есть
                if (isset($def['form']['comment']) && !empty($def['form']['comment'])) {
                    $form->addElement(
                        'static',
                        $field_name.'-comment',
                        array('class'=>'comment')
                    )->setValue($def['form']['comment']);
                }
                
                //значение по умолчанию (если указано)
                if (isset($default_values_def) && isset($def['default'])) {
                    $default_values_def[$field_name] = $def['default'];
                }
            }
        } else {
            /* если тип связи - many_to_many, то выводим в форме только список объектов для связи */
            $object = new $this->object->__class;
            $options = $object->getList();
            $form->addElement('select', $this->many_to_many->field, array(), array('options' => $options));
        }
        
        //значения по умолчанию
        $form->addDataSource(new HTML_QuickForm2_DataSource_Array(isset($default_values_def) ? $default_values_def : $default_values));
        
        return $form;
    }
    
    /**
    * Обновление позиции
    *
    * @param integer ID позиции
    * @param array значения полей для изменения
    * @param array Список свойств модуля допустимых в этом действии
    * @return boolean
    */
    protected function updateItem($item_id, $values, $action_definitions)
    {
        if (isset($this->many_to_many)) {
            $result = $this->updateMMItem($values);
            return;
        }
        
        $object =  $this->object;
        $object->get($item_id);
        
        //проверка, внесены ли изменения
        $is_edit = false;
        foreach ($action_definitions as $field_name=>$action_def) {
            //Установка значения чекбоксов, от которых не пришли данные (значит они не установлены)
            if ($action_def['form']['type']=='checkbox' && !isset($values[$field_name])) {
                $values[$field_name] = '0';
            }
            
            if (isset($values[$field_name]) && property_exists($object, $field_name)) {
                //если измененное поле - это "Позиция", ставим флаг обновления позиции
                if (strstr($field_name, 'position') && $object->$field_name != $values[$field_name]) {
                    $update_positions = true;
                }
                
                //Проверим наличие изменений
                if (is_array($values[$field_name]) && isset($action_def['quickfield']) && $action_def['quickfield'] == 'picture') {
                    //изменена картинка
                    $is_edit = true;
                } elseif (!$is_edit && isset($values[$field_name]) && $object->$field_name != trim($values[$field_name]) ) {
                    $is_edit = true;
                }
            }
        }
        
        
        //Помечаем файлы на удаление
        if (isset($_POST['delete_file'])) {
            foreach ($_POST['delete_file'] as $field_name=>$value) {
                if (property_exists($object, $field_name)) {
                    $is_edit = true;
                    $values[$field_name] = '';
                    /*Подменим значение для этого элемента, чтобы отобразилась правильная миниатюра*/
                    $elements = $this->form->getElementsByName($field_name);
                    $elements[0]->setValue('');
                }
            }
        }
        
        //если изменения внесены - обновляем
        if ($is_edit == true) {
            //установка значений
            foreach ($values as $field_name => $value) {
                $update_this_field = true; //Обновлять это поле
                if (is_array($value)) {/*Загружаемый файл*/
                    if (isset($value['tmp_name']) && !empty($value['tmp_name'])) {
                        $value = Kopolo_File::moveUploadedFile($value,$this->module);
                        /*Подменим значение для этого элемента, чтобы отобразилась правильная миниатюра*/
                        $elements = $this->form->getElementsByName($field_name);
                        $elements[0]->setValue($value);
                    } elseif (!empty($_POST[$field_name . '_from-server'])) { /*добавление файла с сервера через файловый менеджер*/
                        $file_path = $_POST[$field_name . '_from-server'];
                        $abs_file_path = rtrim(KOPOLO_PATH, '/') . $file_path;
                        /*проверка, существует ли файл*/
                        if (file_exists($abs_file_path)) {
                            /*установка значения*/
                            $values[$field_name] = $value = $file_path;
                        } else {
                            Kopolo_Messages::error('Файла &laquo;' . $file_path . '&raquo; нет на сервере.');
                        }
                    } else {
                        /*Если информации о файле не пришло, то не обновляем поле*/
                        $update_this_field = false;
                    }
                }
                if ($update_this_field == true) {
                    $object->$field_name = $value;
                }
            }
            
            //Добавляем дату последнего изменения
            $last_modified_field = $object->__prefix . 'last_modified';
            if (property_exists($object, $last_modified_field)) {
                $object->$last_modified_field = date('Y-m-d H:i:s');
            }
//DB_DataObject::debugLevel(2);
            $result = $object->update();

            if ($result == true) {
                if (isset($update_positions)) {
                    //обновление позиций других записей
                    $position_field = $object->__prefix . 'position';
                    $res = $this->updatePositions($item_id, $values[$position_field]);
                    if (!$res) {
                        Kopolo_Messages::error('Не удалось обновить значения поля "' . $position_field . '" у других записей.');
                    }
                }
                
                /* сообщение об успешном обновлении */
                $recyclebin_link = '/admin/module/RecycleBin/';
                $recovery_link = $recyclebin_link . '?action=recovery&rb_id=' . $this->recyclebin_id;
                $name_field = $object->name_field;
                Kopolo_Messages::success(
                    'Позиция ' . (!empty($this->item[$name_field]) ? ('&laquo;' . $this->item[$name_field] . '&raquo;') : '') . ' успешно обновлена.'
                    . (!empty($this->recyclebin_id)?('<br /><a href="' . $recovery_link . '">Отменить изменения</a>'):'')
                );
                
                /* обновление индекса поиска */
                $this->updateSearchIndex($this->module);
                
                HTTP::redirect($this->redirect);
            } else {
                Kopolo_Messages::error('Произошла ошибка, позиция не обновлена.');
            }
        } else {
            Kopolo_Messages::error('Изменений не произведено.');
        }
        return false;
    }

    /**
    * Обновление позиции в сводной таблице для связи many_to_many
    *
    * @param array значения полей
    */
    protected function updateMMItem($values)
    {
        $table = Kopolo_Relations::getMMTableName(&$this->object, &$this->many_to_many->parent_object);
        if (strlen($table) && isset($values[$this->many_to_many->field]) && isset($this->many_to_many->related_field_value)) {
            /* проверка на изменение */
            if ($values[$this->many_to_many->field] == $this->many_to_many->field_value) {
                Kopolo_Messages::error('Изменений не произведено.');
            } else {
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
                    if (!$res) {
                        Kopolo_Messages::error('Произошла ошибка, позиция не обновлена.');
                        return;
                    }
                }
                /* удаляем текущий элемент */
                $sql = "DELETE FROM " . $table . "
                        WHERE
                            " . $this->many_to_many->field . " = '" . $this->many_to_many->field_value . "'
                        AND
                            " . $this->many_to_many->related_field . " = '" . $this->many_to_many->related_field_value . "'
                ";
                $this->object->query($sql);
                
                Kopolo_Messages::success('Позиция ' . (!empty($this->item[$this->object->name_field]) ? ('&laquo;' . $this->item[$this->object->name_field] . '&raquo;') : '') . ' успешно обновлена.');
            }
        }
    }
    
}
?>