<?php

/**
* Базовый контроллер для действий
*
* @version 2.0 / 24.02.2011
* @author kopolo.ru
* @developer Elena Kondratieva [elena@kopolo.ru]
*/

class Kopolo_Actions extends Kopolo_Controller
{
    /**
    * Название текущего запрошенного модуля (класс)
    * 
    * @var string
    */
    protected $module;
    
    /**
     * Массив запрошенных модулей
     * 
     * @var array
     */
    protected $modules;
    
    /**
     * Строка адреса со всеми запрошенными модулями
     * 
     * @var string
     */
    protected $module_uri;
    
    /**
    * Предки модуля (все модули, имеющие связь с текущим по восходящей)
    * 
    * @var array
    */
    protected $ancestors;
    
    /**
    * Объект текущего запрошенного класса модуля (либо субмодуля, если он есть)
    * 
    * @var object
    */
    protected $object;
    
    /**
    * Конкретная запись (если в параметрах передан ID)
    * 
    * @var array
    */
    protected $item;
    
    /**
    * Действие
    * 
    * @var string
    */
    protected $action;
    
    /**
    * Название действия XXX возможно лучше добавить массив $action_data
    * 
    * @var string
    */
    protected $action_name;
    
    /**
    * Определения полей модуля
    * 
    * @var array
    */
    protected $definitions;
    
    /**
    * Разрешен ли в действии по умолчанию показ полей
    * 
    * @var boolean
    */
    protected $allow = false;
    
    /**
     * Конструктор
     * 
     * @param array параметры: название переменной => значение
     */
    public function __construct(array $parameters)
    {
        if (count($_GET)) {
            $parameters = array_merge($_GET, $parameters);
        }
        $this->parameters = $parameters;
        $this->setParams();
        $this->prepare();
        $this->init();
        $this->initContent();
    }
    
    /**
    * Установка параметров контроллера
    */
    protected function setParams()
    {
        $this->module = $this->parameters['module'];
        $this->modules = $this->parameters['modules'];
        $this->module_uri = $this->parameters['module_uri'];
    }
    
    /**
    * Подготовка данных - определение класса модуля и пр.
    */
    protected function prepare() 
    {
        /*** создание объекта класса модуля ***/
        
        //TO DO проверка, разрешено ли данное действие для модуля и обладает ли пользователь достаточными правами
        
        //объект класса
        $this->object = new $this->module;
        $this->object->module_uri = $this->module_uri;
        $this->object = $this->getModuleData($this->object);
        
        //получение основных настроек
        $this->definitions = $this->object->getFieldsDefinition();
        
        //выборка свойств с разрешенным показом в данном действии
        $this->action_definitions = $this->getDefinitions($this->definitions, $this->allow);
        
        //формирование SQL-запроса
        $this->initSQLSelect();
        $this->initSQLWhere();
        
        //если передан ID, то выбираем конкретную запись
        $this->item = $this->getItem();
        
        //получение всех модулей-предков
        $this->ancestors = $this->getAncestorsModules($this->parameters['modules']);
        
        //определение ID текущего сайта
        $this->object->setSite($this->object->_site_id);
        
        /* если тип связи - many_to_many, то сохраняем данные о связи в переменную */
        if (isset($this->object->relations['many_to_many'])) {
            foreach($this->object->relations['many_to_many'] as $parent_class => $field) {
                $parent_object = new $parent_class;
                $parent_relations = $parent_object->getRelations();
                if (isset($parent_relations['many_to_many'][$this->object->__class])) {
                    $rel_field = $parent_relations['many_to_many'][$this->object->__class];
                    if (isset($this->parameters[$rel_field])) {
                        $this->many_to_many->parent_object = $parent_object;
                        $this->many_to_many->field = $field;
                        $this->many_to_many->related_field = $rel_field;
                        $this->many_to_many->related_field_value = $this->parameters[$rel_field];
                        
                        if (isset($this->parameters[$field])) {
                            $this->many_to_many->field_value = $this->parameters[$field];
                        }
                    }
                }
            }
        }
    }
    
    /**
    * Добавление в запрос полей для выборки
    */
    protected function initSQLSelect()
    {
        //добавление в запрос полей для выборки
        $this->object->selectAdd();
        
        //добавление в запрос ключевого поля (ID)
        $this->object->selectAdd($this->object->__table . '.' . $this->object->id_field);
        
        //добавление в запрос поля с названием позиции
        $this->object->selectAdd($this->object->name_field);
        
        //добавление в запрос поля с флагом системной (неудаляемой) позиции
        if (property_exists($this->object, $this->object->is_system_field)) {
            $this->object->selectAdd($this->object->is_system_field);
        }
        
        //добавление всех полей, разрешенных к показу в данном действии
        if (count($this->action_definitions)) {
            $this->object->selectAdd(join(',', array_keys($this->action_definitions)));
        }
        
        //добавление в запрос всех полей для связи с родительствими модулями
        if (isset($this->object->relations['belongs_to'])) {
            foreach($this->object->relations['belongs_to'] as $parent_class => $field) {
                $this->object->selectAdd($field);
            }
        }
    }
    
    /**
    * Добавление в запрос условий для выборки
    */
    protected function initSQLWhere()
    {
        //добавление условий выборки, если они переданы в параметрах
        
        //получение условий, определенных в конфиге
        $conditions_method = 'getActionConditions' . ucwords($this->action);
        $conditions = @$this->object->$conditions_method();
        if (isset($this->parameters['conditions']) && is_array($this->parameters['conditions'])) {
            $conditions = array_merge($conditions, $this->parameters['conditions']);
        }
        
        if (count($conditions)) {
            foreach ($conditions as $condition) {
                $this->object->whereAdd($condition);
            }
        }
    }
    
    /**
    * Получение конкретной позиции, если передан ID
    * 
    * @return array or false
    */
    protected function getItem() {
        $id_field = $this->object->id_field;
        if (isset($this->parameters[$id_field]) && is_numeric($this->parameters[$id_field])) {
            $item_id = $this->parameters[$id_field];
            $this->object->$id_field = $item_id;
            $this->object->find(true);
            if ($this->object->N == 1) {
                $item = $this->object->toArray();
                return $item;
            }
        }
        return false;
    }
    
/*** Ancestors ***/
    /**
    * Получение модулей-предков текущего модуля
    * 
    * @param string массив названий модулей
    * @return array
    */
    protected function getAncestorsModules($ancestors_modules) 
    {
        $ancestors = array(); //массив для хранения объектов классов-предков
        if(count($ancestors_modules)) {
            $full_module_uri = $this->module_uri;
            
            /* переворачиваем массив, чтобы обрабатывать с конца для получения родителей */
            $ancestors_modules = array_reverse($ancestors_modules);
            foreach($ancestors_modules as $num => $module_name) {
                $module_class = 'Module_' . $module_name;
                if (class_exists($module_class)) {
                    $module_object = new $module_class;
                    $module_object = $this->getModuleData(&$module_object);
                    
                    /* ссылка модуля */
                    if (!isset($module_uri)) {
                        $module_uri = $full_module_uri;
                    }
                    $module_object->module_uri = $module_uri;
                    
                    //если класс принадлежит к деревьям, получаем всех предков и добавляем в массив
                    if (is_subclass_of($module_object, 'Kopolo_Tree')) {
                        if (isset($module_object->relations['belongs_to'][$module_class])) {
                            $parent_field = $module_object->relations['belongs_to'][$module_class];
                            $id_field = $module_object->id_field;
                            if (!isset($parent_value)) {
                                if (isset($parent_object->$id_field)) { //$parent_object от предыдущей итерации
                                    $parent_value = $parent_object->$id_field;
                                } elseif (isset($parent_object->$parent_field)) {
                                    $parent_value = $parent_object->$parent_field;
                                } elseif (isset($this->parameters[$id_field])) {
                                    $parent_value =  $this->parameters[$id_field];
                                } elseif (isset($this->parameters[$parent_field])) {
                                    $parent_value =  $this->parameters[$parent_field];
                                } else {
                                    $parent_value = null;
                                }
                            }
                        } else {
                            Kopolo_Messages::warning('Невозможно получить поле для связи модуля ' . $module_name . ' с модулем ' . $module_name . '.', 1);
                        }
                        if (!empty($parent_value)) {
                                $ancestors = $this->getTreeAncestors($module_class, $parent_field, $id_field, $parent_value, $module_object->module_uri, $ancestors);
                        }
                    }
                    //добавляем в массив общий объект
                    $ancestors[] = $module_object;
                    
                    /* получение конкретного объекта */
                    //попытка получения родительского класса
                    if (isset($ancestors_modules[$num+1])) {
                        $parent_module = $ancestors_modules[$num+1];
                        $parent_class = 'Module_' . $parent_module;
                        
                        /* ссылка модуля
                         * поскольку перебираем реверсивно, то отрезаем от полной ссылки название модуля родителя + 1 символ (слеш)
                         */
                        $module_uri = substr($module_uri, 0, (strlen($module_uri)-(strlen($module_name)+1)));
                        
                        if (class_exists($parent_class)) {
                            //родительское поле для данного класса (например, pm_component для параметров)
                            if (isset($module_object->relations['belongs_to'][$parent_class])) {
                                $parent_field = $module_object->relations['belongs_to'][$parent_class];
                                $parent_value = null;
                                if (isset($parent_object)) { //$parent_object от предыдущей итерации
                                    if (isset($parent_object->$parent_field)) {
                                        $parent_value = $parent_object->$parent_field;
                                    } 
                                } else {
                                    if (isset($this->parameters[$parent_field])) {
                                        $parent_value = $this->parameters[$parent_field];
                                    } elseif (isset($this->item[$parent_field])) {
                                        $parent_value = $this->item[$parent_field];
                                    }
                                }
                                
                                if (!empty($parent_value) && !is_subclass_of($parent_class, 'Kopolo_Tree')) {
                                    //получение родительского объекта
                                    $parent_object = new $parent_class;
                                    $parent_object->module_uri = $module_uri;
                                    $parent_object = $this->getModuleData(&$parent_object);
                                    if (isset($parent_object->relations['has_many'][$module_class])) {
                                        $parent_key_field = $parent_object->relations['has_many'][$module_class];
                                        $parent_object->$parent_key_field = $parent_value;
                                        $parent_object->find(true);
                                        if ($parent_object->N == 1) {
                                            /* добавление к модулю параметров о связи с родительским модулем (для использования в URL действий) */
                                            $ancestors[count($ancestors)-1]->rel_params_string = $parent_field . '=' . $parent_value;
                                            $ancestors[] = $parent_object;
                                            $parent_value = null;
                                        }
                                    } else {
                                        Kopolo_Messages::warning('Невозможно получить поле для связи модуля ' . $parent_module . ' с модулем ' . $module_name . '.', 1);
                                    }
                                }
                            } elseif(isset($module_object->relations['many_to_many'][$parent_class])) {
                                $parent_object = new $parent_class;
                                $parent_object->module_uri = $module_uri;
                                $parent_object = $this->getModuleData(&$parent_object);
                                
                                if (isset($parent_object->relations['many_to_many'][$module_class])) {
                                    $parent_field = $parent_key_field = $parent_object->relations['many_to_many'][$module_class];
                                    
                                    $parent_value = null;
                                    if (isset($this->parameters[$parent_field])) {
                                        $parent_value = $this->parameters[$parent_field];
                                    } elseif (isset($this->item[$parent_field])) {
                                        $parent_value = $this->item[$parent_field];
                                    }
                                    
                                    if (!empty($parent_value)) {
                                        $parent_object->$parent_key_field = $parent_value;
                                        $parent_object->find(true);
                                        if ($parent_object->N == 1) {
                                            /* добавление к модулю параметров о связи с родительским модулем (для использования в URL действий) */
                                            $ancestors[count($ancestors)-1]->rel_params_string = $parent_field . '=' . $parent_value;
                                            $ancestors[] = $parent_object;
                                            $parent_value = null;
                                        }
                                    }
                                } else {
                                    Kopolo_Messages::warning('Невозможно получить поле для связи модуля ' . $parent_module . ' с модулем ' . $module_name . '.', 1);
                                }
                            } else {
                                Kopolo_Messages::warning('Невозможно получить поле для связи модуля ' . $parent_module . ' с модулем ' . $module_name . '.', 1);
                            }
                        }
                    }
                }
            }
        }
        //снова переворачиваем массив для правильного порядка
        $ancestors = array_reverse($ancestors, true);
        
        //если есть $this->item, то добавляем его
        if (!empty($this->item) && !is_subclass_of($this->object, 'Kopolo_Tree')) { //проверка во избежание двойного получения объекта
            $ancestor = clone $this->object;
            $ancestor->module_uri = $full_module_uri;
            $ancestors[] = $ancestor;
        }
        
        return $ancestors;
    }
    
    /**
    * Получение предков объекта-дерева (Achtung! Recursion!)
    * 
    * @param string название класса данного модуля
    * @param string название поля для связи
    * @param string название ключевого поля
    * @param void   значение ключевого поля
    * @param string ссылка на модуль (для действий модуля)
    * @param array  уже полученные предки (массив для добавления)
    * 
    * @return array
    */
    protected function getTreeAncestors($module_class, $parent_field, $key_field, $parent_value, $module_uri, $ancestors)
    {
        while($parent_value != 0) {
            $tree_object = new $module_class;
            $tree_object->$key_field = $parent_value;
            $tree_object->find(true);
            if ($tree_object->N == 1) {
                $tree_object->module_uri = $module_uri;
                $ancestors[] = $this->getModuleData(&$tree_object);
                $parent_value = $tree_object->$parent_field;
            } else {
                continue;
            }
        }
        return $ancestors;
    }
/*** //Ancestors ***/
    
    /* формирование данных для передачи в шаблон */
    protected function initContent() {
        $this->addContent('object', $this->object);
        $this->addContent('module', $this->module);
        $this->addContent('ancestors', $this->ancestors);
        $this->addContent('action', $this->action);
        $this->addContent('action_name', $this->action_name);
        $this->addContent('uri', Kopolo_Registry::get('uri'));
        $this->addContent('full_uri', Kopolo_Registry::get('full_uri'));
        $this->addContent('module_uri', $this->module_uri);
        
        //получение полных данных о данном действии для данного объекта
        if (count($this->object->actions)) {
            foreach($this->object->actions as $num => $action_data) {
                if (isset($action_data['action']) && $action_data['action'] == $this->action && !isset($action_data['module'])) {
                    $this->addContent('action_data', $action_data);
                    continue;
                }
            }
        }
        if (!isset($this->content->action_data) && count($this->object->for_each_actions)) {
            foreach($this->object->for_each_actions as $num => $action_data) {
                if ($action_data['action'] == $this->action) {
                    $this->addContent('action_data', $action_data);
                    continue;
                }
            }
        }
        
        //передача настроек (интерфейса)
        $content = Kopolo_Registry::get('content');
        $this->content->params = $content->params;
    }
    
    /**
     * получение данных из конфига модуля для передачи в шаблон
     * 
     * @param object объект модуля
     * @return object
    */
    protected function getModuleData(&$module) {
        $module->mix($module->getConfigClass());
        $module->relations = $module->getRelations();
        
        $module->module_name = $module->getModuleName();
        $module->module_info = $module->getInfo();
        $module->module_comment = $module->getModuleComment();
        $module->item_name = $module->getItemName();
        
        $actions = $module->getActions();
        $module->actions = $this->addRelFields($module->__class, $actions, $module->relations);
        
        $for_each_actions = $module->getForEachActions();
        $module->for_each_actions = $this->addRelFields($module->__class, $for_each_actions, $module->relations);
        
        $module->id_field = $module->__prefix . 'id';
        $module->name_field = $module->getNameField();
        $module->is_system_field = $module->__prefix . 'is_system';
        $module->parent_field = $module->__prefix . 'parent';
        $module->is_active_field = $module->__prefix . 'is_active';
        
        $position_field = $module->__prefix . 'position';
        $module->position_field = property_exists($module, $position_field)?$position_field:false;
        
        return $module;
    }
    
    /**
     * получение полей для связи в связанных модулей у действий
     * 
     * @param string класс модуля
     * @param array действия модуля
     * @param array связи модуля
     * @return array прибавляет к каждому действию field => поле для связи
    */
    protected function addRelFields($module, $actions, $relations) {
        foreach ($actions as $num => $action) {
            if (isset($action['module'])) {
                $actions[$num]['module_nick'] = substr($action['module'], 7);
                if (isset($relations['has_many'][$action['module']])) {
                    $actions[$num]['parent'] = $relations['has_many'][$action['module']];
                    
                    $class = $action['module'];
                    $object = new $class;
                    $object_relations = $object->getRelations();
                    if (isset($object_relations['belongs_to'][$module])) {
                        $actions[$num]['field'] = $object_relations['belongs_to'][$module];
                    }
                } elseif (isset($relations['many_to_many'][$action['module']])) {
                    $actions[$num]['parent'] = $actions[$num]['field'] = $relations['many_to_many'][$action['module']];
                }
            }
            $actions[$num]['parent_module'] = isset($this->parameters['parent_module']) ? $this->parameters['parent_module'] : $module;
        }
        return $actions;
    }
    
    /**
    * Выборка свойств с разрешенным показом в данном действии
    * 
    * @param array все определения полей для данного модуля
    * @param bool разрешено действие по умолчанию или нет
    * @return array определения разрешенных к показу полей для данного действия
    */
    protected function getDefinitions($all_definitions, $default = false) {
        $action = $this->action;
        $current_definitions = array ();
        foreach ($all_definitions as $field => $definition) {
            if (@$definition['actions'] !== false
                &&
                (
                    (
                        $default == false 
                        && 
                        isset($definition['actions'][$action]) 
                        && 
                        $definition['actions'][$action] !== false
                    ) 
                    || 
                    (
                        $default == true 
                        && 
                        (!isset($definition['actions'][$action]) 
                        || 
                        $definition['actions'][$action] == true)
                    )
                )
            ) {
                $form = @$definition['form'];
                
                //для типа поля 'select' получаем варианты
                if ($form !== false && $form['type'] == 'select' && empty($form['options'])) {
                    if (!empty($form['getoptions'])) {
                        $definition['form']['options'] = $this->object->getSelectOptions($form['getoptions']);
                    } 
                }
                
                //если не указан title, заменяем его на имя поля
                if (!isset($definition['title'])) {
                    $definition['title'] = $field;
                }
                
                $current_definitions[$field] = $definition;
            }
        }
        return $current_definitions;
    }
    
    /**
    * Обновление поля 'position' в таблице
    * 
    * @param integer ID записи, которая обновлена
    * @param integer новое значение 'position'
    * @return boolean
    */
    protected function updatePositions($item_id, $new_pos)
    {
        /* Проверка, есть ли у объекта поле с позицией */
        $prefix = $this->object->__prefix;
        if (property_exists($this->object, $prefix . 'position')) {
            $item = $this->item;            
            
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
            
            $object_siblings->orderBy($prefix.'position ASC');
            $object_siblings->find();
            $pos_counter = 1;
            /*Обновляет все записи, что позволяет исправить ошибки возникающие при ручном удалении из БД*/
            while ($object_siblings->fetch()) {
                if ($object_siblings->{$prefix.'id'}!=$item_id) {
                    if ($pos_counter==$new_pos) {
                        $pos_counter++;
                    }
                    $position_item = new $this->module;
                    $position_item->get($object_siblings->{$prefix.'id'});
                    $position_item->{$prefix.'position'} = $pos_counter;
                    $position_item->update();
                    $pos_counter++;
                } else {
                    /*Уже обновлен ранее*/
                }
            }
            return true;
        }
        return false;
    }
    
    
    /**
     * Обновление индекса поиска
     * 
     * @param string название текущего модуля
    */
    protected function updateSearchIndex($modulename) {
        $search_index_modules = Controller_Search_Updater::$modules;
        if (in_array($modulename, $search_index_modules)) {
            $updater = new Controller_Search_Updater();
            if ($updater->getErrorsCount() > 0) {
                Kopolo_Registry::warning('Обновление индекса поиска произошло с ошибками, поиск может работать некорректно.');
            }
        }
    }
}
?>