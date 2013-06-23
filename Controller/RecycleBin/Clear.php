<?php

/**
* Действие "clear" для модуля RecycleBin - очищение корзины
*
* @version 1.0 / 20.06.2011
* @author Elena Kondratieva [elena@kopolo.ru]
*/

class Controller_RecycleBin_Clear extends Kopolo_Actions
{
    /**
    * Название действия
    * 
    * @var string
    */
    protected $action_name = 'очистка корзины';
    
    /**
    * Действие
    * 
    * @var string
    */
    protected $action = 'clear';
    
    public function init() 
    {
        /* получение общего числа объектов в корзине */
        $recyclebin = new Module_RecycleBin();
        $count = $recyclebin->getTotalCount();
        if ($count == 0) {
            Kopolo_Messages::error('Корзину невозможно очистить, т.к. она пуста.');
            HTTP::redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->content->count = $count;
            if (isset($this->parameters['clear'])) { /* при подтверждении действия пользователем */
                if ($recyclebin->clear()) {
                    Kopolo_Messages::success('Корзина успешно очищена.');
                    HTTP::redirect('/admin/module/RecycleBin/');
                }
            }
        }
    }
}
?>