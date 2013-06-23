<?php

/**
* Действиу "item" - просмотр конкретной позиции модуля
*
* @version 0.3 / 24.02.2011
* @author kopolo.ru
* @developer Elena Kondratieva [elena@kopolo.ru]
*/

class Kopolo_Actions_Item extends Kopolo_Actions
{
    /**
    * Шаблон по умолчанию
    * @var string
    */
    public $template = 'actions/item.tpl';
    
    /**
    * Название действия
    * 
    * @var string
    */
    protected $action_name = 'просмотр';
    
    /**
    * Действие
    * 
    * @var string
    */
    protected $action = 'item';
    
    /**
    * Разрешен ли в действии по умолчанию показ полей
    * 
    * @var boolean
    */
    protected $allow = true;
    
    public function init() 
    {
        if (!empty($this->item)) {
            //передача данных в шаблон
            $this->addContent('item', $this->item);
            $this->addContent('definitions', $this->action_definitions);
                
            return true;
        } else {
            return false; //XXX установка ошибки 404?
        }
    }
}
?>