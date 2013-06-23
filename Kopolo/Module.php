<?php 

/**
 * Базовый класс модуля
 * 
 * наследует от класса базы данных (шаблон ActiveRecord)
 * является родительским для всех классов модулей
 * 
 * @version 1.2 [19.05.2011]
 * @package System
 * @since   PHP 5.2
 */
 
class Kopolo_Module extends Kopolo_DB_DataObject
{
    /**
     * Префикс названия полей в базе данных
     * @var string
     */
    public $__prefix = '';

    /**
     * Название текущего класса в нижнем регистре
     * @var string
     */
    public $__class;

    /**
     * Имя таблицы базы данных для класса
     * @var string
     */
    public $__table;
    
    /**
     * Поддержка модулем мультиязычности
     * @var boolean
     */
    public $__multilang = false;
    
    /**
     * Поддержка модулем мультисайтовости
     * @var boolean
     */
    public $__multisiting = false;
    
    /**
     * Свойство класса, содержащее ID сайта
     * (при его указании сайт устанавливается автоматически при выборках)
     * 
     * @var string
     */
    public $__site_field = false;
    
    
    /**
     * Связи с другими модулями в формате массива с элементами: тип связи, модуль, поле для связи
     * Возможные типы: belongs_to, has_many
     * 
     * @var array
     */
    public $__relations = array();
    
    /**
     * Примеси (классы, доступные из объекта текущего модуля)
     * 
     * @var array
     */
    public $__mixins = array();
    
    /**
     * Connect String для базы данных класса
     * @var string
     * @access public
     */
    public $_database_dsn;
    
    /**
     * ID сайта
     * @var integer
     */
    public $_site_id;
    
    /**
     * Текущий язык (если __multilang == true)
     * @var integer
     */
    public $_lang;

    /**
     * Конструктор класса
     * @param boolean проверять ли таблицу БД класса на соответсвие полей определениям в Config
     */
    function __construct ($check_table=true, $site_id=false)
    {
        //определяем dsn (необходимо для работы PEAR DB_DataObject)
        if (!isset ($this->_database_dsn))
        {
            $this->_database_dsn = KOPOLO_DSN;
        }
        
        //определение ID текущего сайта
        if ($site_id === false) {
            $this->_site_id = @Kopolo_Registry::get('site_id');
        } else {
            $this->_site_id = $site_id;
        }
        
        
        /* определяем таблицу базы данных для класса*/
        //имя класса
        $class_name = get_class ($this);
        if (!isset ($this->__table))
        {
            $default_table = KOPOLO_DB_TABLES_PREFIX . strtolower($class_name);
         
            //если для модуля включена многосайтовость - добавляем в конец ID сайта
            $this->__table = $this->__multisiting === true ? ($default_table . '_' . $this->_site_id) : $default_table;
        }
        $this->__class = $class_name;
        
        //проверка существования таблицы БД для модуля (только в режиме разработки)
        if (KOPOLO_DEVELOP_MODE == true && $this->__class != 'Module_Params' && $check_table==true) { /* TO DO костыль для запрета обработки Module_Params, т.к. модуль вызывается до определения сайта и в режиме MULTILANG_TYPE=='fields' неправильно определяются мультиязычные поля */
            $this->checkTable();
        }
    }
    
    /**
     * Определение структуры таблицы БД 
     * more: http://pear.php.net/manual/en/package.database.db-dataobject.db-dataobject.table.php
     * 
     * @return array название поля => значение
     */
    public function table() 
    {
        $config_class_name = $this->__class . '_Config';
        $config_class = new $config_class_name;
        $fields_definition = $config_class->getFieldsDefinition();
        
        $table_fields = array ();
        if (count($fields_definition)) {
            foreach ($fields_definition as $field_name => $definition) {
                $value = Kopolo_DB_DataObject::getFieldLenghtByType($definition['type']);
                $table_fields[$field_name] = $value;
            }
        }
        return $table_fields;
    }
    
    /**
     * Установка ID сайта 
     * 
     * @param integer ID сайта, по умолчанию берется из регистра
     * @return boolean
     */
    public function setSite($site_id) {
        //если у текущего модуля есть свойство, содержащее ID сайта
        $site_field = $this->__site_field;
        if ($site_field != false && property_exists($this, $site_field) && is_numeric($site_id)) {
            $this->$site_field = $site_id;
            return true;
        }
        return false;
    }
    
    /**
     * Получение массива со списком элементов id => name
     * 
     * @param string название поля ключа
     * @param string название поля значения
     * 
     * @return array
     */
    public function getList($key_field = '', $value_field = '')
    {
        $key_field = !empty($key_field) ? $key_field : $this->__prefix . 'id';
        $value_field = !empty($value_field) ? $value_field : $this->__prefix . 'name';
        
        $list = array();
        if (property_exists($this, $key_field) && property_exists($this, $value_field)) {
            $this->orderBy($value_field . ' ASC');
            $this->find();
            
            while ($this->fetch()) {
                $list[$this->$key_field] = $this->$value_field;
            }
        }
        return $list;
    }
    
    /**
     * Получение связей с другими модулями в формате массива с элеменами: тип связи, модуль, поле для связи
     * Возможные типы: belongs_to, has_one, has_many, many_to_many
     * 
     * @example array('has_many', 'Module_Gallery', 'pg_id')
     * @return array
    */
    public function getRelations()
    {
        return $this->__relations;
    }
    
    /**
     * Возвращает поля для связи с другими таблицами (для join в DB_DataObject)
     * формат: 'поле_для_связи_текущей_таблицы' => 'название_связанной_таблицы:поле_для_связи_связанной_таблицы'
     * @example: array('image_album'=>'albums:album_id')
     * @return array
    */
    public function links()
    {
        $links = array();
        
        $relations = $this->getRelations();
        if (isset($relations['belongs_to'])) {
            foreach($relations['belongs_to'] as $module => $field) {
                $module_object = new $module;
                
                /* По умолчанию полем для связи является поле "id" */
                $rel_field = $module_object->__prefix . 'id';
                $module_relations = $module_object->getRelations();
                
                /* Если в модуле указано поле для связи - переопределяем */
                if (count($module_relations) && isset($module_relations['has_many'][$this->__class])) {
                    $rel_field = $module_relations['has_many'][$this->__class];
                }
                
                /* Помещаем данные в массив в требуемом формате */
                $links[$field] = $module_object->__table . ':' . $rel_field;
            }
        }
        return $links;
    }
    
    // define the keys 
    //TO DO: определять ключи динамически исходя из настроек
    public function keys() {
        return array($this->getIdField());
    }
    
     /**
     * Получение названия поля с идентификатором позиции
     * 
     * @return srring
    */
    public function getIdField() {
      return $this->__prefix . 'id';
    }
    
    public function sequenceKey ()
    {
        return array ($this->__prefix . 'id', true);
    }
    
    
    /**
    * Примешивает класс к данному модулю
    */
    public function mix($class_name)
    {
        if (strlen($class_name)) {
            $this->__mixins[] = new $class_name;
        }
    }
    
   /**
    * Реализует доступ к методам классов-примесей
    */
    public function __call($method, $params) 
    {
        $result = null;
        for($q = 0; $q < count($this->__mixins); $q++) {
            if(method_exists($this->__mixins[$q], $method)) {
                 //находим первого делегата, отдаем ему полномочия и завершаем выполнение метода
                 $result = call_user_func_array(array($this->__mixins[$q], $method), $params);
                 break;
            } else {
                trigger_error('method ' . $method . ' not exists');
            }
        }
        return $result;
    }
    
   /**
    * Возвращает название класса настроек для текущего модуля
    * 
    * @return string
    */
    public function getConfigClass() 
    {
        $config_class = $this->__class . '_Config';
        return $config_class;
    }
    
   /** TO DO заменить на getModuleShortName()
    * Возвращает название класса без 'Module_'
    * 
    * @return string
    */
    public function getModuleNick() 
    {
        $module_nick = substr($this->__class, 7);
        return $module_nick;
    }
    
    public function getNextPosition() {
        $this->query('SELECT MAX(' . $this->__prefix . 'position) AS last_position FROM ' . $this->__table);
        $this->fetch();
        $next_position = $this->last_position+1;
        
        return $next_position;
    }
    
    /**
     * Проверяет, существует ли таблица в БД для класса, и при необходимости создает
     * (с учетом определений полей в Config модуля, метод getFieldsDefinition()
     */
    private function checkTable() {
        $generator = new Kopolo_DB_Generator($this->_site_id);
        
        /* проверка основной таблицы */
        if ($generator->tableExists($this->__table) === false) {
            $generator->createTable($this->__class, $this->__table);
        } else {
            $generator->updateTable($this->__class, $this->__table);
        }
        
        /* если существует связь many_to_many, то необходимо дополнительно проверять таблицы для связи */
        $relations = $this->getRelations();
        if (isset($relations['many_to_many'])) {
            $MM_modules = Kopolo_Relations::getMMRelatedModules(&$this);
            
            foreach($MM_modules as $data) {
                if ($generator->tableExists($data['table']) === false) {
                    $generator->createMMTable($this->__class, $data);
                }
            }
        }
    }

}
?>