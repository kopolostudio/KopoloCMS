<?php

/**
* Обновление индекса поиска
* 
* @varsion 1.0 [15.12.2010]
* @package Search
*/

ini_set('memory_limit', '100M');
set_time_limit (0);
ini_set ('display_errors', 'on');
error_reporting (E_ALL^E_NOTICE); 

class Controller_Search_Updater
{
    /**
    * Список модулей для индекса
    * @var array
    */
    public static $modules = array (
        'Module_Pages',
        'Module_News'
    );
    
    /**
    * Добавлено записей
    * @var integer
    */
    private $added = 0;
    
    /**
    * Число ошибок
    * @var integer
    */
    private $errors = 0;

    /**
    * Конструктор класса
    */
    public function __construct()
    {
        $this->index();
        //$this->addFulltext();
    }
    
    /**
    * Получение числа добавленных позиций
    * 
    * @return integer
    */
    public function getAddedCount()
    {
        return $this->added;
    }
    
    /**
    * Получение числа ошибок
    * 
    * @return integer
    */
    public function getErrorsCount()
    {
        return $this->errors;
    }
    
    /**
    * Добавляет в индекс позиции всех необходимых модулей
    */
    private function index() 
    {
        //очищаем таблицу с индексом
        $searchindex = new Module_Search_Index();
        $searchindex->query ("TRUNCATE " . $searchindex->__table);
        
        /*** индексируем статьи ***/
        //$this->quickModuleIndex('articles');
        
        /*** индексируем новости ***/
        $this->quickModuleIndex('news');
        
        /*** индексируем страницы ***/
        $this->indexTree('pages');
        
        /*** индексируем категории каталога **
        $catalogsimple = new Module_CatalogSimple();
        $catalogsimple->ct_is_active = 1;
        $catalogsimple->find();
        while ($catalogsimple->fetch()) {
            $uri = '/catalog/' . $catalogsimple->ct_nick  . '/';
            $this->addIndex ($catalogsimple->ct_name, $catalogsimple->ct_info, $uri);
        }
        */
        
        /*** индексируем товары **
        $item = new Module_CatalogSimple_Items();
        $item->it_is_active = 1;
        
        //добавление к запросу таблицы категорий
        $catalogsimple = new Module_CatalogSimple();
        $item->joinAdd ($catalogsimple);
        $item->ct_is_active = 1;
        
        //добавление к запросу таблицы метро
        $stations = new Module_Stations();
        $item->joinAdd ($stations, 'LEFT');
        
        //добавление к запросу таблицы районов
        $districts = new Module_Districts();
        $item->joinAdd ($districts, 'LEFT');
        
        $item->find();
        while ($item->fetch()) {
            $content = $item->it_info . ' ' . $item->it_address . ' ' . $item->it_building_type . ' ' . $item->st_name . ' ' . $item->dt_name;
            $uri = '/catalog/' . $item->ct_nick  . '/' . $item->it_id . '/';
            $this->addIndex ($item->it_name, $content, $uri);
        }
        unset($item);
        */
    }

    /**
    * Добавляет 1 запись в индекс поиска
    * 
    * @param string название записи
    * @param string значение записи
    * @param string URI записи (относительный адрес страницы)
    * 
    * @return boolean
    */
    private function addIndex($name, $content, $uri)
    {
        if (!empty($content)) {
            $searchindex = new Module_Search_Index();
            $searchindex->si_name = $name;
            $searchindex->si_info = strip_tags($content);
            $searchindex->si_uri = $uri;
            $res = $searchindex->insert();
            if ($res !== false) {
                $this->added++;
                return true;
            } else {
                $this->errors++;
                return false;
            }
        }
    }
    
    /**
    * Стандартная индексация модуля
    * используется для модулей со стандартными полями (name, info)
    * формирует адрес страницы в формате /module_name/item_id/
    * 
    * @param string название модуля (без Module_)
    * 
    * @return boolean
    */
    private function quickModuleIndex($module_name)
    {
        $class = 'Module_' . ucwords($module_name);
        $module = new $class;
        
        $id_field = $module->__prefix . 'id';
        $name_field = $module->__prefix . 'name';
        $info_field = $module->__prefix . 'info';
        $active_field = $module->__prefix . 'is_active';
        
        if (property_exists($module, $active_field)) {
            $module->$active_field = 1;
        }
        $module->find();
        while ($module->fetch()) {
            $this->addIndex ($module->$name_field, $module->$info_field, '/'.strtolower($module_name).'/' . $module->$id_field . '/');
        }
        return true;
    }
    
    /**
    * Индексация древовидного модуля
    * 
    * @param string название модуля (без Module_)
    * 
    * @return boolean
    */
    private function indexTree($module_name)
    {
        $class = 'Module_' . ucwords($module_name);
        $module = new $class;
        
        $active_field = $module->__prefix . 'is_active';
        if (property_exists($module, $active_field)) {
            $module->$active_field = 1;
        }
        $tree = $module->getFullTree();
        $this->addTreeRecursively($tree, '', $module->__prefix);
    }
    
    /**
    * Добавляет рекурсивно дерево в индекс поиска
    * 
    * @param array
    * @param integer
    * @param string
    * @param string
    * 
    * @return boolean
    */
    private function addTreeRecursively($tree, $parents='', $prefix)
    {
        if (count($tree)) {
            $id_field = $prefix . 'id';
            $name_field = $prefix . 'name';
            $info_field = $prefix . 'info';
            $nick_field = $prefix . 'nick';
            foreach($tree as $parent_id => $child) {
                $uri = (!empty($parents)?$parents:'/') . ($child[$nick_field]!='first'?($child[$nick_field].'/'):'');
                $this->addIndex ($child[$name_field], $child[$info_field], $uri);
                if (count($child['children'])) {
                    $this->addTreeRecursively($child['children'], $uri, $prefix);
                }
            }
        }
    }

    /**
    * Добавляет FULLTEXT-индекс в таблицу
    * 
    * @return boolean
    */
    private function addFulltext()
    {
        if ($this->added > 0) {
            $searchindex = new Module_Search_Index();
            $res = $searchindex->query("ALTER TABLE `" . $searchindex->__table . "` ADD FULLTEXT (`si_name`,`si_info`)");
            if ($res == true) {
                return true;
            }
        }
        return false;
    }
}