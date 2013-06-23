<?php
/**
 * Генератор структуры таблиц в БД
 * 
 * @version 1.3 [21.07.2011]
 * @package DB
 * @link http://pear.php.net/manual/de/package.database.mdb2.intro-manager-module.php
 */
class Kopolo_DB_Generator
{
    /**
     * Объект класса-драйвера БД
     * @var object
     */
    private $db;
    
    /**
     * ID сайта
     * @var integer
     */
    private $_site_id;
    
    /**
     * Конструктор класса
     * @param integer $site_id
     */
    public function __construct($site_id = false) 
    {
        $mdb2 = MDB2::factory(KOPOLO_DSN);

        //загрузка модуля MDB2 "Manager"
        $mdb2->loadModule('Manager');
        $this->db = $mdb2;
        
        /*Установка site_id*/
        if ($site_id === false) {
            $this->_site_id = @Kopolo_Registry::get('site_id');
        } else {
            $this->_site_id = $site_id;
        }
    }
    
    /**
     * Проверяет, существует ли таблица в БД
     * 
     * @param string название проверяемой таблицы
     * 
     * @return boolean
     */
    public function tableExists($table_name) 
    {
        $tables = $this->db->listTables();
        if (in_array($table_name, $tables)) { 
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Создает таблицу в БД для модуля (согласно определениям полей в Setting-классе модуля)
     * 
     * @param string  - название основного класса модуля
     * @param string  - название таблицы БД модуля
     *
     * @return boolean
     */
    public function createTable($class_name, $table_name)
    {
        $setting_class = $this->getSettingClass($class_name);
        
        $module_name = $setting_class->getModuleName();
        
        //настройки для таблицы
        $table_options = array(
            'comment' => 'Таблица модуля ' . $class_name . ' (' . $module_name . ')',
            'charset' => KOPOLO_DB_CHARSET,
            'collate' => KOPOLO_DB_COLLATE,
            'type'    => 'myisam',
        );
        $definition = $setting_class->getFieldsDefinition();
        $result = $this->db->createTable($table_name, $definition, $table_options);
        
        //загрузка данных по умолчанию для модуля
        $sql = $setting_class->getDefaultSQL($table_name,$this->_site_id);
        if (!empty($sql)) {
            if (is_array($sql)) {
                foreach ($sql as $sql_item) {
                    $this->db->query($sql_item);
                }
            } else {
                $this->db->query($sql);
            }
        }
        
        return $result;
    }
    
    /**
     * Создает таблицу в БД для хранения связи many_to_many для двух модулей
     * 
     * @param string название основного класса модуля
     * @param array данные для создания таблицы:
     *     class - название связываемого класса
     *     key1  - название поля 1
     *     key2  - название поля 2
     *     table - название таблицы
     *
     * @return boolean
     */
    public function createMMTable($class_name, $data)
    {
        //настройки для таблицы
        $table_options = array(
            'comment' => 'Таблица для хранения связей.',
            'charset' => KOPOLO_DB_CHARSET,
            'collate' => KOPOLO_DB_COLLATE,
            'type'    => 'myisam',
        );
        
        //определения полей
        $definition = array (
            $data['key1'] => array (
                'type' => 'integer',
                'unsigned' => 1,
                'notnull' => 1,
                'default' => 0
            ),
            $data['key2'] => array (
                'type' => 'integer',
                'unsigned' => 1,
                'notnull' => 1,
                'default' => 0
            )
        );
        $result = $this->db->createTable($data['table'], $definition, $table_options);
        
        return $result;
    }
    
    /**
     * Проверяет соотвествие структуры таблицы в БД для модуля определениям полей в Setting-классе модуля
     * и обновляет в случае изменений
     * 
     * @param string название основного класса модуля (Module_Pages)
     * @param string название таблицы БД модуля (kpl_module_pages_2)
     * 
     * @return mixed
     * 
     * TO DO: добавить изменение $class_name
     */
    public function updateTable($class_name, $table_name)
    {
        $setting_class = $this->getSettingClass($class_name);
        
        //определения полей класса из настроек
        $class_fields_definition = $setting_class->getFieldsDefinition();
        
        //фактические поля базы данных
        $db_table_fields = $this->db->listTableFields($table_name);
        
        //приводим массивы к общим ключам для дальнейшего сравнения
        $db_table_fields = array_flip($db_table_fields);
        
        $fields_to_add = array_diff_key ($class_fields_definition, $db_table_fields); //поля для добавления
        $fields_to_del = array_diff_key ($db_table_fields, $class_fields_definition); //поля для удаления
        $fields_to_upd = array_intersect_key ($class_fields_definition, $db_table_fields); //поля для изменения
        
        $this->db->loadModule('Manager');
        
        /* внесение необходимых изменений полей в таблицу
         * подробнее - http://pear.php.net/package/MDB2/docs/latest/MDB2/MDB2_Driver_Manager_Common.html#methodalterTable
        */
        
        //формируем массив для передачи в метод alterTable
        
        //поля для изменения в формате для метода alterTable
        $fields_to_change = array(); //поля для изменения в формате для метода alterTable
        foreach ($fields_to_change as $field_name => $field_def) {
            $fields_to_change[$field_name] = array (
                'length' => Kopolo_DB_DataObject::getFieldLenghtByType($field_def['type']),
                'definition' => $field_def
            );
        }
        
        $alter_table = array (
            'add'    => $fields_to_add,
            'remove' => $fields_to_del,
            'change' => $fields_to_change
        );
        
        $result = $this->db->alterTable($table_name, $alter_table, 0);
        return $result;
    }
    
    /**
     * Создание объекта Setting-класса для модуля
     * 
     * @param string название основного класса модуля
     * 
     * @return object
     */
    private function getSettingClass($class_name)
    {
        $setting_class_name = $class_name . "_Config";
        $setting_class = new $setting_class_name;
        return $setting_class;
    }
}
?>