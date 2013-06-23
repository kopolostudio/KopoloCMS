<?php

/**
* Выбор сайта из зарегистрированных в системе
*
* @version 0.1 / 23.11.2010
* @author kopolo.ru
* @developer Elena Kondrateva [elena@kopolo.ru]
*/

class Controller_Sites_Select extends Kopolo_Controller
{
    /**
    * Шаблон по умолчанию
    * @var string
    */
    public $template = 'sites/select.tpl';
    
    protected function init()
    {
        if (defined('MULTISITING') && MULTISITING==false && defined('SITE_ID') && KOPOLO_DEVELOP_MODE != 1) {
            $site_id = SITE_ID;
            $sites = new Module_Sites();
            $sites->get($site_id);
            $this->content->sites[0] = $sites->toArray();
            
            Kopolo_Registry::set('site_id', $site_id);
        } else {
            /* получение списка сайтов */
            $sites = new Module_Sites();
            $sites->st_is_active = 1;
            
            //сайт админпанели можно редактировать только в режиме разработки
            if (KOPOLO_DEVELOP_MODE != 1) {
                $sites->whereAdd('st_id != ' . ADMIN_PANEL_SITE_ID);
            }
            
            $sites->find();
            $this->content->sites = $sites->fetchArray();
            
            /* установка ID сайта */
            if (isset($_REQUEST['site']) && is_numeric($_REQUEST['site'])) {
                $current_site_id = $_REQUEST['site'];
            } elseif (isset($_COOKIE['site_id'])) {
                $current_site_id = $_COOKIE['site_id'];
            } else {
                $current_site_id = SITE_ID;
            }
            
            if (isset($current_site_id) && $this->siteExists($current_site_id) == true) {
                Kopolo_Registry::set('site_id', $current_site_id);
                setcookie ('site_id', $current_site_id, time()+(60*60*24*30), '/');
            } else {
                $current_site_id = SITE_ID;
                Kopolo_Messages::error('Ошибка определения ID выбранного сайта.');
            }
            $this->content->current_site_id = $current_site_id;
        }
    }
    
    /**
    * Проверяет, существует ли сайт с таким ID
    * 
    * @param integer ID сайта
    * @return boolean
    */
    private function siteExists($site_id) {
        $sites = new Module_Sites();
        $sites->whereAdd("st_is_active='1'");
        $count_rows = $sites->get($site_id);
        if ($count_rows == 1) {
            return true;
        }
        return false;
    }
}
?>