<?php

/**
* Обновление
*
* @version 0.11 / 09.07.2011
* @author kopolo.ru
*/

class Controller_Updates extends Kopolo_Controller
{
    public $template = 'updates.tpl';
    
    /**
     * (non-PHPdoc)
     * @see Kopolo_Controller::init()
     */
    public function init()
    { 
        /*TODO: резервное копирование - чекрыжик, на странице с обновлениями, 
         * чтобы не мучить диалоговыми окнами и не делать резервную копию, тогда, когда не нужно*/
        if (isset($_POST['download-update-version'])) {
            $update_version = $_POST['download-update-version'];//Версия загружаемого обновления
            $updates_downloader = new Kopolo_Updates_Downloader();
            $download_result = $updates_downloader->download($update_version);
            if ($download_result == true) {
                $this->content->download_successful = array(
                    'version'=>$update_version
                );
            } else {
                $messages = $updates_downloader->messages;
                $continuation_is_possible = $updates_downloader->continuation_is_possible;
                if ($continuation_is_possible==true) {
                    /*При загрузке обновления возникли ошибки, но установка вцелом возможна*/
                    $this->content->download_unsuccessful = array(
                        'version'=>$update_version,
                        'messages'=>$updates_downloader->messages,
                        'continuation_is_possible'=>true
                    );
                } else {
                    /*При загрузке обновления возникли ошибки, несовместимые с дальнейшей установкой*/
                    $this->content->download_unsuccessful = array(
                        'version'=>$update_version,
                        'messages'=>$updates_downloader->messages,
                        'continuation_is_possible'=>false
                    );
                }
            }
        } elseif (isset($_POST['install-update-version'])) {
            $update_version = $_POST['install-update-version'];
            $downloaded_updates_info = Kopolo_Updates_Downloader::checkDownloaded();
            $installed_successfully = false;
            foreach ($downloaded_updates_info as $downloaded_update_info) {
                if ($downloaded_update_info['version']==$update_version) {
                    $installing_update_info = $downloaded_update_info;
                }
            }
            if (isset($installing_update_info)) {
                $updates_installer = new Kopolo_Updates_Installer($installing_update_info['update_dir']);
                $all_requirements_are_met = true;
                if (!isset($_POST['install-skip-requirements']) && !$updates_installer->checkVersionCompatibility()) {
                    $all_requirements_are_met = false;
                }
                if (!isset($_POST['install-skip-requirements']) && !$updates_installer->checkDependings()) {
                    $all_requirements_are_met = false;
                }
                if (!isset($_POST['install-skip-requirements']) && !$updates_installer->checkRights()) {
                    $all_requirements_are_met = false;
                }
                if ($all_requirements_are_met == true) {
                    $this->content->installed_successfully = $updates_installer->update();
                    $this->content->new_version = $update_version;
                } else {
                    /*Прерванное обновление*/
                    $this->content->interrupted_update = array(
                        'version'=>$update_version,
                        'messages'=>$updates_installer->messages
                    );
                }
            } else {
                    $this->content->interrupted_update = array(
                        'version'=>$update_version,
                        'messages'=>array('status'=>'error','text'=>'Запрашиваемое вами обновление недоступно для установки, вероятно оно еще не загружено')
                    );
            }
        } else {
            $updates_info = Kopolo_Updates_Downloader::checkAvailable();
            $downloaded_updates_info = Kopolo_Updates_Downloader::checkDownloaded();
            foreach ($downloaded_updates_info as $downloaded_update_info) {
                $downloaded_update_info['ready_to_install'] = true;
                $updates_info[$downloaded_update_info['version']] = $downloaded_update_info;
            }
            $this->content->updates_info = $updates_info;
            $this->content->current_version = KOPOLO_VERSION;
        }
    }
}
