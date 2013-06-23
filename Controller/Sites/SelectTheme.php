<?php

/**
* Контроллер: выбор темы сайта
*
* @version 1.0 / 26.07.2011
*/

class Controller_Sites_SelectTheme extends Kopolo_Controller
{
    /**
     * Шаблон по умолчанию
     * @var string
     */
    public $template = 'sites/select_theme.tpl';
    
    protected function init()
    {
        $site_id = Kopolo_Registry::get('site_id');
        
        if (is_numeric($site_id)) {
            /* если пришла информация из формы - устанавливаем новую тему */
            if (isset($_REQUEST['theme'])) {
                /* добавление в корзину информации об изменении темы */
                $content = Kopolo_Registry::get('content');
                $user_id = isset($content->auth['user']['us_id']) ? $content->auth['user']['us_id'] : false;
                if (is_numeric($user_id)) {
                    $this->recyclebin_id = Module_RecycleBin::addObject('edit', 'Module_Sites', $site_id, $user_id);
                } else {
                    Kopolo_Messages::warning('Невозможно добавить информацию об изменении темы в корзину — неизвестен авторизованный пользователь.', 1);
                }
                
                /* обновление сайта */
                $sites = new Module_Sites();
                $sites->st_id = $site_id;
                $sites->st_theme = $_REQUEST['theme'];
                $res = $sites->update();
                if ($res) {
                    Kopolo_Messages::success('Тема оформления успешно изменена на &laquo;' . Kopolo_String::escape4HTML($_REQUEST['theme']) . '&raquo;.');
                } else {
                    Kopolo_Messages::error('Не удалось изменить тему оформления.', 1);
                }
            }
            
            /* список доступных тем */
            $themes = $this->getThemes($site_id);
            
            /* текущая тема */
            $sites = new Module_Sites();
            $current_site = $sites->get($site_id);
            if ($sites->N == 1) {
                $current_theme = $sites->st_theme;
            } else {
                Kopolo_Messages::warning('Невозможно определить текущую выбранную тему.', 1);
            }
            
            /* передача данных в шаблон */
            $this->content->themes = $themes;
            $this->content->current_theme = @$current_theme;
        } else {
            Kopolo_Messages::error('Невозможно определить текущий выбранный сайт.', 1);
        }
    }
    
    /**
    * Получение списка тем для сайта (для админки свои темы)
    * 
    * @param integer ID сайта
    * @return array
    */
    protected function getThemes($site_id) {
        $themes = array();
        
        $themes_path = KOPOLO_PATH . '/Themes/';
        $themes_list = Kopolo_FileSystem::getDirs($themes_path);
        if (!empty($themes_list)) {
            foreach ($themes_list as $num => $theme_name) {
                if (substr($theme_name, 0, 5) == 'Admin') {
                    if ($site_id != 1) {
                        continue;
                    }
                } else {
                    if ($site_id == 1) {
                        continue;
                    }
                }
                $themes[$num]['name'] = $theme_name;
                
                $preview_path = $themes_path . $theme_name . '/preview.jpg';
                if (file_exists($preview_path)) {
                    $themes[$num]['preview'] = '/Themes/' . $theme_name . '/preview.jpg';
                }
            }
        }
        return $themes;
    }
}
?>