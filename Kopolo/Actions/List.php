<?php

/**
* Действие "list" - вывод списка всех позиций модуля
*
* @version 1.5 / 16.07.2011
* @author kopolo.ru
* @developer Elena Kondratieva [elena@kopolo.ru]
*/

//DB_DataObject::debugLevel(1);

class Kopolo_Actions_List extends Kopolo_Actions
{
    /**
    * Шаблон по умолчанию
    * @var string
    */
    public $template = 'actions/list.tpl';
    
    /**
    * Название действия
    * 
    * @var string
    */
    protected $action_name = 'список';
    
    /**
    * Действие
    * 
    * @var string
    */
    protected $action = 'list';
    
    /**
    * Доступные режимы отображения списка
    * 
    * @var array
    */
    protected $registered_modes = array (
        'table',
        'hierarchy'
    );
    
    /**
    * Режим отображения списка по умолчанию
    * 
    * @var string
    */
    protected $mode = 'table';
    
    /**
    * Сортировка списка
    * 
    * @var string
    */
    protected $order_by;
    
    public function init() 
    {
        $object = $this->object;
        
        //сортировка (если указана в настройках)
        if (isset($this->parameters['order_by'])) {
            $order_by = $this->parameters['order_by'];
        } elseif (isset($this->parameters['sort_by']) && isset($definitions[$this->parameters['sort_by']])) {
            $sort_type = strtolower(isset($this->parameters['sort_type']) ? $this->parameters['sort_type'] : '');
            $order_by = $this->parameters['sort_by'] . ' ' . (($sort_type == 'asc' || $sort_type == 'desc') ? $sort_type : 'desc');
        } else {
            $order_by = $object->getOrderBy();
        }
        if (!empty($order_by)) {
            $object->orderby($order_by);
        }
        
        /* добавляем в условия выборки родителя (всех) */
        if (isset($object->relations['belongs_to'])) {
            foreach($object->relations['belongs_to'] as $parent_class => $field) {
                if (isset($this->parameters[$field])) {
                    $object->whereAdd($field . "='" . $this->parameters[$field] . "'");
                } else {
                    /* если не передано, устанавливаем в 0 - только для деревьев */
                    if (is_subclass_of($object, 'Kopolo_Tree')) {
                        $object->whereAdd($field . "='0'");
                    }
                }
            }
        }
        
        /* добавляем в условия выборки связь many_to_many */
        if (isset($this->many_to_many)) {
            $table = Kopolo_Relations::getMMTableName(&$this->object, &$this->many_to_many->parent_object);
            $field = $this->many_to_many->field;
            $related_field = $this->many_to_many->related_field;
            $related_field_value = $this->many_to_many->related_field_value;
            
            if (strlen($table)) {
                $object->_join = 'LEFT JOIN ' . $table . ' ON (' . $table . '.' . $field . ' = ' . $object->__table . '.' . $field . ')';
                $object->whereAdd($table . '.' . $related_field . '=\'' . $related_field_value . '\'');
            }
            
            $object->rel_params_string = $related_field . '=' . $related_field_value;
        } 
        
        /* получение линейного списка позиций */
        $object->find();
        $list = $object->fetchArray();
        
        /*
        //результирующий массив
        $list = array ();
        while ($object->fetch()) {
            $object = $this->forEachItem($object);
            $list[] = $object->toArray();
        }
        */
        
        /* постраничная навигация */
        $items_per_page = $object->getItemsPerPage();
        if ($this->mode=='table' && !empty($items_per_page) && $items_per_page > 0) {
            if (count($list) > $items_per_page) {
                $url = Kopolo_Registry::get('uri');
                $nicks = explode('/',trim($url,'/'));
                $current_page = array_pop($nicks);
                if ($current_page != 'all') {
                    sscanf($current_page, "page%d", $current_page);
                    if (!is_numeric($current_page)) {
                        $current_page = 1;
                    } else {
                        $url = '/' . join('/',$nicks) . '/';
                    }
                }
                if (is_numeric($current_page)) {
                    $pager = $this->getPager($list, $items_per_page, $current_page, $url);
                    $this->addContent('pager', $pager);
                    $list = $pager->getPageData();
                }
            }
        }
        
        //передача данных в шаблон
        $this->addContent('list', $list); 
        $this->addContent('count', $object->N);
        $this->addContent('mode', $this->mode);
        $this->addContent('definitions', $this->action_definitions);
    }
    
    /**
    * Функция, выполняемая для каждой позиции списка
    * 
    * @param object
    * @return object
    */
    protected function forEachItem($object)
    {
        return $object;
    }
    
    /**
    * Режим отображения списка
    * 
    * @return string

    protected function getMode()
    {
        $cookie_name = 'list_mode_' . !empty($this->submodule) ? $this->submodule : $this->module;
        if (isset($this->parameters['mode'])) {
            $mode = $this->parameters['mode'];
        } elseif (isset($_COOKIE[$cookie_name])) {
            $mode = $_COOKIE[$cookie_name];
        }
        
        if (isset($mode)) { 
            if (in_array($mode, $this->registered_modes)) { 
                setcookie ($cookie_name , $mode, time()+(60*60*24*30), '/');
                return $mode;
            } else {
                Kopolo_Messages::warning('Неизвестный режим отображения списка ' . $this->parameters['mode'] . ', допустимы режимы: ' . join(",", $this->registered_modes) . '.');
            }
        }
        return $this->mode;
    }
    */
}