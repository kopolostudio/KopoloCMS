<?php

class Kopolo_DB_DataObject extends DB_DataObject
{
    /**
     * Получение длины поля таблицы БД по типу этого поля
     * Example: Kopolo_DB_DataObject::getFieldLenghtByType('integer')
     * 
     * @param string тип поля
     * 
     * @return int длина поля
     */
    public static function getFieldLenghtByType($type) 
    {
        switch($type) {
            case 'integer':
                $value = DB_DATAOBJECT_INT;
                break;
            case 'text':
                $value = DB_DATAOBJECT_STR;
                break;
            case 'boolean':
                $value = DB_DATAOBJECT_INT + DB_DATAOBJECT_BOOL;
                break;
            case 'timestamp':
                $value = DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME;
                break;
            default:
                $value = DB_DATAOBJECT_STR;
        }
        return $value;
    }

    /**
     * Record to array
     *
     * @param   string  sprintf format for array
     * @param   bool    empty only return elemnts that have a value set.
     * 
     * @return Array
     */
    public function fetchArray($format = '%s', $hideEmpty = false)
    {
        $result = array ();
        while ($this->fetch ()) {
            $res = $this->toArray($format, $hideEmpty);
            $result[] = $res;
        }
        return $result;
    }
    
    /**
     * Возвращает объект текущего класса, преобразованный в ассоциативный массив
     * если включена поддержка мультиязычности, заменяет значения соответствующих свойств значениями на текущем языке
     *
     * @param   string  sprintf format for array
     * @param   bool    empty only return elemnts that have a value set.
     *
     * @access   public
     * @return   array of key => value for row
     */
    public function toArray($format = '%s', $hideEmpty = false) {
        $values = parent::toArray($format, $hideEmpty);
        
        /* если тип мультиязычности - fields, то для всех сайтов, кроме админпанели, 
         * автоматически подставляем в свойства соответствующие значения на текущем выбранном языке 
         */
        if (MULTILANG == true && MULTILANG_TYPE == 'fields' && $this->__multilang == true && $this->site_id != ADMIN_PANEL_SITE_ID) {
            $values = $this->replaceLangValues($values);
        }
        return $values;
    }
    
    /**
     * Заменяет значения общих свойств класса на соответствующие значения на текущем выбранном языке 
     * (значение pg_name заменится на pg_name_en, если текущий язык en)
     * TO DO: кешировать результаты
     *
     * @param array значения для преобразования
     * @return array
     */
    private function replaceLangValues($values) {
        $lang = Kopolo_Registry::get('lang');
        $default_lang = Kopolo_Registry::get('default_lang');
        
        if ($default_lang != true) {
            $config_class = $this->getConfigClass();
            $config_object = new $config_class;
            $mulilang_fields = $config_object->getMultilangFields();
            foreach($mulilang_fields as $num => $field_name) {
                $lang_field_name = $field_name . '_' . $lang;
                if (isset($values[$field_name]) && isset($values[$lang_field_name])) {
                    $values[$field_name] = $values[$lang_field_name];
                    unset($values[$lang_field_name]);
                }
            }
        }
        $this->lang = $lang;
        return $values;
    }
}
?>