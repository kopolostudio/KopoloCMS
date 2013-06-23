<?php

/**
* Главный контроллер действий, загружает какой-либо из модулей для просмотра или редактирования позиций
*
* @version 1.1 / 19.05.2011
* @author kopolo.ru
* @developer Elena Kondrateva [elena@kopolo.ru]
*/

class Controller_Action extends Kopolo_Controller
{
    /**
     * Шаблон по умолчанию
     * @var string
     */
    public $template = 'actions.tpl';
    
    /**
     * Массив запрошенных модулей
     * 
     * @var array
     */
    protected $modules;
    
    /**
     * Текущий запрошенный модуль
     * 
     * @var string
     */
    protected $module;
    
    /**
    * Текущий запрошенное действие (по умолчанию "список")
    * 
    * @var string
    */
    protected $action = "list";
    
    /**
    * установка параметров контроллера
    */
    protected function setParams()
    {
        if (isset($_GET['modules'])) {
            $modules_string = $_GET['modules'];
        } elseif (isset($this->parameters['modules']) && strlen($this->parameters['modules'])) {
            $modules_string = $this->parameters['modules'];
        }
        $this->module_uri = $modules_string;
        $this->modules = explode('/', $modules_string);
        $this->module = 'Module_' . end($this->modules);
        
        if (isset($_GET['action'])) {
            $this->action = $_GET['action'];
        } elseif (isset($this->parameters['action']) && strlen($this->parameters['action'])) {
            $this->action = $this->parameters['action'];
        }
    }
    
    protected function init()
    {
        //определение модуля
        if (!empty($this->module)) {
            $module = $class = $this->module;
            if (class_exists($class)) {
                /* определение действия */
                $action = $this->action;
                
                /* выполнение действия */
                //специальный класс действия для модуля
                $special_class = 'Controller_' . substr($module, 7) . '_' . ucwords($action);
                $special_class_path = KOPOLO_PATH . str_replace("_", "/", $special_class) . '.php';
                
                //класс действия по умолчанию
                $default_class = 'Kopolo_Actions_' . ucwords($action);
                $default_class_path = KOPOLO_PATH . str_replace("_", "/", $default_class) . '.php';

                if (file_exists($special_class_path)) {
                    $class = $special_class;
                } elseif (file_exists($default_class_path)) {
                    $class = $default_class;
                } else {
                    Kopolo_Messages::error('Класс для действия  -' . $action . '- модуля -' . $module . '- не существует.');
                    //$this->error404 = true;
                    return;
                }
                
                //передаем название модуля через параметры
                $parameters = array('module' => $module, 'modules' => $this->modules, 'module_uri' => $this->module_uri);
                $class = new $class($parameters);
                
                $this->content = $class->getContent();
                $this->content->action = $action;
                
                //установка title страницы
                $page = Kopolo_Page::getInstance();
                if (empty($this->content->object->module_name)) {
                    $this->content->object->module_name = $this->content->module;
                }
                $page->setTitle($this->content->object->module_name);
            } else {
                Kopolo_Messages::error('Модуль -' . $this->module . '- не существует');
            }
        } else {
            Kopolo_Messages::error('Не передано название модуля');
        }
    }
}
?>