<?php 

/**
 * Базовый класс настроек модуля
 * 
 * @author  kopolo.ru
 * @version 1.2 / 15.06.2011
 * @package System
 */
 
class Kopolo_Module_Config
{
    /**
     * Название модуля
     * @var string
     */
    protected $module_name;
    
    /**
     * Название позиции
     * @var string
     */
    protected $item_name = '';
    
    /**
     * Комментарий о назначении модуля
     * @var string
     */
    protected $module_comment;
    
    /**
     * Подробное описание модуля
     * @var string
     */
    protected $module_description;
    
    /**
    * Дополнительная информация о модуле
    * @var string
    */
    protected $info;
    
    /**
     * Сортировка позиций модуля
     * @var string
     */
    protected $order_by;
    
    /**
     * Поле с названием позиции
     * @var string
     */
    protected $name_field;
    
    /**
     * Число позиций на одной странице по умолчанию
     * @var integer
     */
    protected $items_per_page = 30;
    
    /**
     * Список мультиязыковых свойств модуля
     * @var array
     */
    protected $multilang_fields = array();
    
    /**
     * Название класса модуля, связанного с данным конфигом
     * @var string
     */
    protected $module_class;
    
    
    /**
     * Объект класса модуля, связанного с данным конфигом
     * @var object
     */
    protected $module;
    
    
    /**
     * Получение названия модуля
     *
     * @return string
     */
    public function getModuleName() 
    {
        return $this->module_name;
    }
    
    /**
     * Получение названия позиции
     *
     * @return string
     */
    public function getItemName() 
    {
        return $this->item_name;
    }
    
    /**
     * Получение поля с названием позиции
     *
     * @return string
     */
    public function getNameField() 
    {
        if (!empty($this->name_field)) {
            return $this->name_field;
        } else {
            if (empty($this->module)) {
                $this->getModule();
            }
            
            $name_field = $this->module->__prefix . 'name';
            if (!property_exists($this->module, $name_field)) {
                $name_field = $this->module->__prefix . 'id';
            }
            return $name_field;
        }
    }
    
    /**
     * Получение комментария к модулю
     *
     * @return string
     */
    public function getModuleComment() {
        return $this->module_comment;
    }
    
    /**
     * Получение дополнительной информации о модуле
     *
     * @return string
     */
    public function getInfo() {
        return $this->info;
    }
    
    /**
     * Получение описания модуля
     *
     * @return string
     */
    public function getModuleDescription() {
        return $this->module_description;
    }
    
    /**
     * Получение SQL для сортировки позиций модуля
     *
     * @return string
     */
    public function getOrderBy() {
        return $this->order_by;
    }
    
    /**
     * Получение числа позиций на одной странице по умолчанию
     *
     * @return integer
     */
    public function getItemsPerPage() {
        return $this->items_per_page;
    }
    
    /**
     * Получение определений свойств класса (типов полей БД и пр.)
     * 
     * @return array
     */
    public function getFieldsDefinition() 
    {   
        if (isset($_GET['clear'])) {
            Kopolo_Cache::clearSessionCashe();
        }
        $class = $this->getModuleClass();
        
/* XXX костыль для сайта с мультиязычностью - принудительная установка ID сайта для модуля Module_Components*/
if ($class=='Module_Components') {$cache_key = $class . '_FieldsDefinition_' . 2;} else 
/*конец костыля*/

        $cache_key = $class . '_FieldsDefinition_' . Kopolo_Registry::get('site_id');
        
        $properties = array(); //результирующие определения
        
        $properties = Kopolo_Cache::getSessionCashe($cache_key, 1);
        if ($properties != false) {
            return $properties;
        }
        
        $quickproperties = $this->getQuickFieldsDefinition();
        
        //перебираем все свойства класса и даем им полные определения
        $class_vars = get_class_vars($class);
        
        //получение массива $quickfields
        include('quickfields.php');
        
        //получение массива $quicktypes
        include('quicktypes.php');
        
        $prefix = $class_vars['__prefix']; //префикс свойств класса
        foreach ($class_vars as $name => $value) {
            $field = null;
            
            /* если есть префикс, обрабатываем свойства класса только с префиксом 
             * если нет префикса, то свойства без подчеркивания в начале */
            if (strlen($prefix) > 0 && strstr($name, $prefix)) {
                $field = substr($name, strlen($prefix)); //название поля без префикса
            } elseif ($prefix == '' && substr($prefix, 0, 1) != '_') {
                $field = $name;
            }
            
            if (!empty($field)) {
                //проверяем, есть ли у поля определение
                if (isset($quickproperties[$name])) {
                    if (isset($quickproperties[$name]['quickfield'])) { //если установлен какой-либо quickfield, сливаем
                        $quickfield = $quickproperties[$name]['quickfield'];
                        if (!isset($quickfields[$quickfield])) {
                            Kopolo_Messages::error('Неизвестный тип поля ' . $quickfield . ' в определении поля ' . $name . '.', 1);
                        } else {
                            $properties[$name] = $this->mergeProperties($quickfields[$quickfield], $quickproperties[$name]); 
                        }
                    } elseif (isset($quickproperties[$name]['quicktype'])) { //если установлен какой-либо quicktype, сливаем
                        $quicktype = $quickproperties[$name]['quicktype'];
                        if (!isset($quicktypes[$quicktype])) {
                            Kopolo_Messages::error('Неизвестный тип данных ' . $quicktype . ' в определении поля ' . $name . '.', 1);
                        } else {
                            $properties[$name] = $this->mergeProperties($quicktypes[$quicktype], $quickproperties[$name]);
                        }
                    } elseif ($quickproperties[$name] === false) { //не добавлять поле в БД
                        continue;
                    } else {
                        $properties[$name] = $quickproperties[$name];
                    }
                } else {
                    /*добавление определений поля из соответствующего quickfield*/
                    if (isset($quickfields[$field])) {
                        $properties[$name] = $quickfields[$field];
                        $properties[$name]['quickfield'] = $field;
                    }
                }
                
                /* обработка языковых версий полей */
                if (MULTILANG==true && MULTILANG_TYPE=='fields' && $class_vars['__multilang']==true && isset($properties[$name]['multilang']) && $properties[$name]['multilang']==true) {
                    /* получение списка языков сайта */
                    $lang = new Module_Sites_Langs();
                    $langs = $lang->getLangs(Kopolo_Registry::get('site_id'));
                    if (count($langs)) {
                        $i = 0;
                        foreach($langs as $lang_nick => $lang_info) {
                            /* пропускаем первый элемент массива (для языка по умолчанию не изменяем название полей) */
                            if ($i > 0) {
                                $properties[$name . '_' . $lang_nick] = $properties[$name];
                                $properties[$name . '_' . $lang_nick]['title'] = $properties[$name . '_' . $lang_nick]['title'] . ' (' . $lang_nick . ')';
                                
                                //XXX убрать это отсюда в Kopolo_Action_List и сделать для каждого дейсвия обработку
                                $properties[$name . '_' . $lang_nick]['actions']['list'] = false;
                            }
                            $i++;
                        }
                    }
                    $this->multilang_fields[] = $name;
                }
            }
        }
        Kopolo_Cache::sessionCashe($cache_key, $properties, 1);
        
        $cache_key = $class . '_MultilangFields_' . Kopolo_Registry::get('site_id');
        Kopolo_Cache::sessionCashe($cache_key, $this->multilang_fields, 1);
        
        return $properties;
    }
    
    /**
     * Получение списка мультиязыковых свойств модуля
     * 
     * @return array
     */
    public function getMultilangFields() 
    {
        /* список определяется в методе getFieldsDefinition(),
         * здесь только возвращаем результат
         */
        if (count($this->multilang_fields)) {
            return $this->multilang_fields;
        } else {
            if (isset($_GET['clear'])) {
                Kopolo_Cache::clearSessionCashe();
            }
            $class = $this->getModuleClass();
            $cache_key = $class . '_MultilangFields_' . Kopolo_Registry::get('site_id');
            $multilang_fields = Kopolo_Cache::getSessionCashe($cache_key, 1);
            if ($multilang_fields != false) {
                return $multilang_fields;
            }
            
            $this->getFieldsDefinition();
            Kopolo_Cache::sessionCashe($cache_key, $this->multilang_fields, 1);
            return $this->multilang_fields;
        }
    }
    
    /**
     * Рекурсивно сливает два массива с параметрами
     * В отличие от array_merge_recursive переопределяет значения массива с совпадающими ключами
     * На PHP 5.2.6 работает всего в 2.5 раза медленнее метода array_merge_recursive
     * @param array $basic - исходный массив
     * @param array $overdefined - массив, который переопределит значения исходного массива
     * @return array - результирующий массив
     */
    protected function mergeProperties (array $basic, array $overdefined)
    {
        $result = $basic;
        foreach ($overdefined as $key=>$value) {
            if ( !is_array($value) || !isset($basic[$key]) ) {
                /*Не массив, либо такого массива не было в исходных данных*/
                $result[$key] = $value;
            } else {
                /*Если массив - вызывает себя рекурсивно*/
                $result[$key] = $this->mergeProperties($basic[$key], $value);
            }
        }
        
        return $result;
    }
    
    /**
     * Получение названия класса модуля (без "_Config")
     * 
     * @return string
     */
    protected function getModuleClass() {
        $class = get_class($this); 
        if (strstr($class, '_Config')) {
            $class = substr($class, 0, (strlen($class)-7)); //без "_Config"
        }
        return $class;
    }
    
    /**
     * Получение объекта связанного класса модуля
     * 
     * @return boolean
     */
    protected function getModule() {
        $class = !empty($this->module_class) ? $this->module_class : $this->getModuleClass();
        if (class_exists($class)) {
            $this->module = new $class;
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Действия для каждой позиции
     * 
     * @return array
     */
    public function getForEachActions()
    {
        $actions = array (
            0 => array (
                'action' => 'edit',
                'name' => 'изменить'
            ),
            1 => array (
                'action' => 'delete',
                'name' => 'удалить'
            )
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
                'name' => 'список'
            ),
            1 => array (
                'action' => 'add',
                'name' => 'добавить'
            )
        );
        return $actions;
    }
    
    /**
     * "Быстрое" определений свойств класса с использованием $quicktypes и $quickfields
     * 
     * @return array
     */
    public function getQuickFieldsDefinition() 
    {
        $properties = array (
        );
        
        return $properties;
    }
    
    /**
     * Получение SQL по умолчанию
     * @param string $table_name - имя таблицы
     * @param integer $site_id - id сайта
     * @return string|array - один или несколько запросов для выполнения
     */
    public function getDefaultSQL($table_name,$site_id=1)
    {
        /*Для модуля с общей таблицей - просто вернем SQL*/
        return '';
        /*Мертвый код, просто болванка для метода многосайтового модуля:*/
        if ($site_id == 1) {
            /*Админка*/
            $sql = array("","");
            return $sql;
        } else {
            /*Обычные сайты*/
            $sql = "";
            return $sql;
        }
    }
    
    /**
     * Получение вариантов для поля формы select исходя из переданных параметров
     *
     * Возможные параметры:
     *  class (string) - название класса
     *  method (string) - название метода, из которого следует получить массив вариантов
     *  value (string) - название свойства класса, значения которого будут ключами (<option value="VALUE"/>)
     *                   (по умолчанию id с соответствующим префиксом)
     *  text (string) - название свойства класса, значения которого будут значениями (<option>TEXT</option>)
     *                 (по умолчанию name с соответствующим префиксом)
     *  default (string) - значение для ключа 0 (по умолчанию - нет)
     *  conditions (array) - массив дополнительных условий для выборки
     *
     * @param array массив параметров
     * @return string
     */
    public function getSelectOptions($params)
    {
        if (empty($params)) {
            $options = array (0 => 'нет');
        } else {
            $options = array ();
            if (!empty($params['default'])) {
                $options[0] = $params['default'];
            }
            
            if (!empty($params['class'])) {
                $class = new $params['class'];
                
                if (!empty($params['method'])) {
                    $method = $params['method'];
                    $add_options = $class->$method;
                    $options = array_merge($options, $add_options);
                } else {
                    //по умолчению value выбирается из ключевого поля ID
                    $value_field = $class->__prefix . 'id';
                    if (!empty($params['value'])) {
                        $value_field = $params['value'];
                    }
                    $class->selectAdd($value_field);
                    
                    //по умолчению text выбирается из поля name
                    $text_field = $class->__prefix . 'name';
                    if (!empty($params['text'])) {
                        $text_field = $params['text'];
                    }
                    $class->selectAdd($text_field);
                    
                    $class->orderBy($text_field . ' ASC');
                    
                    //добавление дополнительных условий для выборки
                    if (isset($params['conditions']) && is_array($params['conditions'])) {
                        foreach ($params['conditions'] as $condition) {
                            $class->whereAdd($condition);
                        }
                    }
                    
                    $class->find();
                    if ($class->N > 0) {
                        while ($class->fetch()) {
                            $options[$class->$value_field] = $class->$text_field;
                        }
                    }
                }
            }
        }
        return $options;
    }
    
    /**
     * Дополнительные условия для выборки для действия list (список)
     * 
     * @return array
     */
    public function getActionConditionsList() {
        return array();
    }
}
?>