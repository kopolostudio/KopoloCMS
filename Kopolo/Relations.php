<?php

/**
 * Класс, включающий методы для работы со связями
 *
 * @version 0.1 / 18.12.2010
 * @link http://docs.kopolocms.ru/wiki/Relations/
 */
final class Kopolo_Relations
{
    /**
    * Получение данных о связанных модулях (для many_to_many)
    * 
    * @param object
    * @return array
    */
    public static function getMMRelatedModules(&$module1)
    {
        $data = array();
        
        $class1 = $module1->__class;
        $all_relations = $module1->getRelations();
        $MM_relations = $all_relations['many_to_many'];
        foreach($MM_relations as $class2 => $field) {
            $module2 = new $class2(false);
            $relations = $module2->getRelations();
            
            /* получение данных для сводной таблицы */
            if (isset($relations['many_to_many'][$class1])) {
                $related_field = $relations['many_to_many'][$class1];
                
                /* название сводной таблицы */
                $table_name = self::getMMTableName(&$module1, &$module2);
                
                $data[] = array (
                    'class' => $class2,
                    'key1' => $field,
                    'key2' => $related_field,
                    'table' => $table_name
                );
            }
        }
        
        return $data;
    }
    
    /**
    * Получение названия сводной таблицы для связи many_to_many (kpl_aaa2bbb_2)
    * 
    * @param string название класса модуля 1 без 'Module_'
    * @param string название класса модуля 2 без 'Module_'
    * @return string
    */
    public static function getMMTableName(&$module1, &$module2)
    {
        $table = KOPOLO_DB_TABLES_PREFIX; //глобальный префикс
        
        $modules_names = array ($module1->getModuleNick(), $module2->getModuleNick());
        sort($modules_names); //сортировка по алфавиту
        
        $table .= strtolower($modules_names[0]) . '2' . strtolower($modules_names[1]); //основная часть вида 'aaa2bbb'
        
        //добавление постфикса с ID сайта, если один из модулей мультисайтовый
        if ($module1->__multisiting === true) {
            $site_id = $module1->_site_id;
        } elseif ($module2->__multisiting === true) {
            $site_id = $module2->_site_id;
        }
        
        if (isset($site_id)) {
            $table .= '_' . $site_id;
        }
        
        return $table;
    }
    
    /**
     * Получение списка связанных с удаляемым объектом данных (рекурсивно)
     * 
     * @param integer  ID позиции
     * @param string   класс модуля
     * @param array    данные о связях с другими модулями
     * @param integer  число позиций
     * @return array
     */
    public static function getRelatedData($id, $module, $module_relations, $number=10) {
        $related_data = array();
        if (isset($module_relations['has_many'])) {
            foreach($module_relations['has_many'] as $class => $classfield) {
                $object = new $class;
                $relations = $object->getRelations();
                if (isset($relations['belongs_to'][$module])) {
                    $field = $relations['belongs_to'][$module];
                    
                    /* проверка, не связаны ли другие модули по этому же полю (двойная связь) - например, Gallery_Images */
                    foreach($relations['belongs_to'] as $class1 => $classfield1) {
                        if ($class != $class1 && $classfield1 == $field) {
                            $module_field = $object->__prefix . 'module';
                            /* если у класса есть доп. поле для указания связи с модулем */
                            if (property_exists($object, $module_field)) {
                                /* добавление в условия выборки */
                                $object->$module_field = $module;
                            }
                        }
                    }
                    $object->$field = $id;
                    
                    /* для модулей, у которых установлено __site_field */
                    if (!empty($object->__site_field)) {
                        $site_id = Kopolo_Registry::get('site_id'); 
                        $object->{$object->__site_field} = $site_id;
                    }
                    
                    $object->find();
                    
                    if ($object->N > 0) {
                        $object_config_class = $object->getConfigClass();
                        $object_config = new $object_config_class;
                        $object_module_name = $object_config->getModuleName();
                        $object_name_field = $object_config->getNameField();
                        $object_id_field = $object->getIdField();
                        
                        $related_data[$object_module_name]['class'] = $class;
                        $related_data[$object_module_name]['field'] = $field;
                        $related_data[$object_module_name]['value'] = $id;
                        $related_data[$object_module_name]['count'] = $object->N;
                        $related_data[$object_module_name]['items'] = array();
                        
                        //помещаем в массив первые $number элементов
                        while($object->fetch()) {
                            if ($number == 0 || count($related_data[$object_module_name]['items']) < $number) {
                                $object_id = $object->$object_id_field;
                                
                                $related_data[$object_module_name]['items'][$object_id]['name'] = $object->$object_name_field;
                                $related_data[$object_module_name]['items'][$object_id]['related_data'] = self::getRelatedData($object_id, $class, $relations);
                            } else {
                                continue;
                            }
                        }
                    }
                }
            }
        }
        return $related_data;
    }
    
    function __construct()
    {}
    
    function __clone()
    {}
}