<?php

/**
* Контроллер: главное меню модулей
*
* @version 1.0 / 22.07.2011
* @author kopolo.ru
*/

class Controller_Modules_Menu extends Kopolo_Controller
{
    /**
     * Шаблон по умолчанию
     * @var string
     */
    public $template = 'modules/menu.tpl';
    
    /**
    * Основной код контроллера
    * установка данныx в $this->content для вывода в шаблон
    */
    public function init()
    {
        /* выводить меню только админам */
        $content = Kopolo_Registry::get('content');
        if (isset($content->auth['user']) && $content->auth['user']['us_group'] == 1) {
            $modules = new Module_Modules();
            $modules->md_is_active = 1;
            $modules->md_in_menu = 1;
            $modules->orderBy('md_group ASC, md_position ASC');
            $modules->find();

            $this->content->groups = Module_Modules_Config::$groups;
            $this->content->modules = $modules->fetchArray();
        }
    }
}
?>