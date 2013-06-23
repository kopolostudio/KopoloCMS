<?php

/**
* Действие "editfield" - изменение поля у позиции модуля
*
* @version 1.1 / 21.11.2011
*/

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Renderer.php';

class Kopolo_Actions_Editfield extends Kopolo_Actions_Edit
{
    /**
    * Название действия
    *
    * @var string
    */
    protected $action_name = 'изменение поля';
    
    /**
    * Действие
    *
    * @var string
    */
    protected $action = 'editfield';
    
    /**
    * Шаблон по умолчанию
    * @var string
    */
    public $template = 'actions/edit.tpl';
    
    public function init()
    {
        if (!empty($this->item) && isset($_REQUEST['field'])) {
            $this->redirect = $_SERVER['HTTP_REFERER'];
            
            /* убираем из $this->action_definitions и $default_values все поля, кроме изменяемого */
            $default_values[$_REQUEST['field']] = $this->item[$_REQUEST['field']];
            $action_definitions[$_REQUEST['field']] = $this->action_definitions[$_REQUEST['field']];
            $this->action_definitions = $action_definitions;
            
            $this->form = $this->initForm($action_definitions, $default_values);
    
            /* добавление кнопки отправки данных в форму */
            $this->form->addElement('button', 'submit', array('type' => 'submit'), array('content' => 'Сохранить изменения'));
            
            $this->validate();
            
            /* передача данных в шаблон */
            $this->addContent('form', $this->form->html());
            $this->addContent('item', $this->item);
            
            return true;
        } else {
            return false; //XXX установка ошибки 404?
        }
    }
}
?>