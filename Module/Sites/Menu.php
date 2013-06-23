<?php

/**
 * Модуль языков, реализует хранение информации о языковых версиях сайтов для поддержки мультиязычности
 *
 * @author  kopolo.ru
 * @version 0.1 [27.02.2011]
 * @package Sites
 */

class Module_Sites_Menu extends Kopolo_Module
{
    /*** Base class properties ***/
    public $__prefix = 'mn_';
    public $__multilang = false;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'belongs_to' => array (
            'Module_Sites' => 'mn_site'
        )
    );
    
    /*** Db fields (with specific prefix) ***/
    public $mn_id;
    public $mn_site;
    public $mn_name;
    public $mn_link;
    public $mn_picture;
    public $mn_is_active;
    public $mn_position;
    
    /**
     * Получение списка пунктов меню для сайта
     * 
     * @param integer ID сайта
     * @return array
    */
    public function getMenu($site_id) {
        $menu = array();
        
        $this->mn_site = $site_id;
        $this->mn_is_active = 1;
        $this->orderBy('mn_position ASC');
        $this->find();
        if ($this->N > 0) {
            $permissions = new Module_Users_Permissions();
            
            $content = Kopolo_Registry::get('content');
            if (isset($content->auth['user'])) {
                $items = $permissions->getPermissibleItems('view', $this->__class, $content->auth['user']);
                
                if (count($items)) {
                    while($this->fetch()) {
                        if (in_array($this->mn_id, $items)) {
                            $menu[] = $this->toArray();
                        }
                    }
                }
            }
        }
        return $menu;
    }
}
?>