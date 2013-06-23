<?php

/**
* Контроллер: проверка наличия новых модулей
*
* @version 1.0 / 19.05.2011
* @author kopolo.ru
*/

class Controller_Modules_CheckNew extends Kopolo_Controller
{
    /**
     * Шаблон по умолчанию
     * @var string
     */
    public $template = 'modules/new_modules.tpl';
    
    /**
    * Основной код контроллера
    * установка данныx в $this->content для вывода в шаблон
    */
    protected function init()
    {
        if (KOPOLO_DEVELOP_MODE == true) {
            if (isset($_POST['add_modules']) && count($_POST['modules'])) {
                $count_registered_modules = $this->registerModules($_POST['modules']);
                if ($count_registered_modules > 0) {
                    Kopolo_Messages::success('Зарегистрировано модулей: ' . $count_registered_modules . '.');
                } else {
                    Kopolo_Messages::error('Модули не зарегистрированы.');
                }
            }
            
            /* получение линейного списка зарегистрированных модулей системы */
            $modules = new Module_Modules();
            $modules->find();
            
            $modules_list = array();
            while ($modules->fetch()) {
                $modules_list[$modules->md_id] = $modules->md_nick;
            }
            
            /* получение иерархического списка всех модулей системы */
            $modules_tree = Kopolo_FileSystem::getFilesArray(KOPOLO_PATH . 'Module');
            
            $unregistered_modules = $this->getUnregModules($modules_list, $modules_tree);
            
            /* передача данных в шаблон */
            $this->content->unregistered_modules = $unregistered_modules;
        }
    }
    
    /**
    * Регистрация новых модулей
    * 
    * @param array   названия классов модулей в массиве
    * 
    * @return integer число зарегистрированных модулей
    */
    private function registerModules($modules)
    {
        if (count($modules)) {
            $counter = 0;
            foreach ($modules as $classname => $flag) {
                if (class_exists('Module_' . $classname)) {
                    //получаем информацию о модуле из конфига
                    $configclassname = 'Module_' . $classname . '_Config';
                    if (class_exists($configclassname)) {
                        $config = new $configclassname;
                        
                        /* регистрация модуля */
                        //получение родительского модуля
                        
                        $module = new Module_Modules();
                        $module->md_name = $config->getModuleName();
                        $module->md_comment = $config->getModuleComment();
                        $module->md_nick = $classname;
                        $module->md_is_active = 1;
                        $module->md_in_menu = 0;
                        $module->md_is_system = 0;
                        $module->md_position = $module->getNextPosition();
                        $res = $module->insert();
                        if ($res) {
                            $counter++;
                        }
                    }
                }
            }
            return $counter;
        }
        return 0;
    }
    
    /**
    * Получение списка модулей, незарегистрированных в системе
    * 
    * @param array   зарегистрированные модули в массиве id => nick
    * @param array   все модули из директории 'Module'
    * @param string  префикс названия модуля (для рекурсии)
    * @param array   незарегистрированные модули (для рекурсии)
    * 
    * @return array
    */
    private function getUnregModules($reg_modules_list, $modules_tree, $module_prefix=false, $unreg_modules=array()) 
    {
        foreach ($modules_tree as $module) {
            if ($module['is_file'] == true && $module['name'] != 'Config.php') {
                $module_name = (!empty($module_prefix) ? ($module_prefix . '_') : '' ) . substr($module['name'], 0, strlen($module['name'])-4);
                if (!in_array($module_name, $reg_modules_list)) {
                    $unreg_modules[] = $module_name;
                }
            } elseif ($module['is_file'] == false) { //is directory
                $prefix = $module['level']==0 ? $module['name'] : ($module_prefix . '_' . $module['name']);
                $unreg_modules = $this->getUnregModules($reg_modules_list, $module['dirs'], $prefix, $unreg_modules);
            }
        }
        return $unreg_modules;
    }
}
?>