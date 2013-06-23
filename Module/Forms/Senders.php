<?php
/**
 * Пользователи, отправившие формы
 *
 * В базу данных сохраняются ответы пользователя на вопросы формы (если в действиях указано сохранение)
 *
 * @author  kopolo.ru
 * @version 1.0 / 15.06.2011
 * @package Forms
 * @subpackage Senders
 */

class Module_Forms_Senders extends Kopolo_Module
{
    /*** Base class properties ***/
    public $__prefix = 'sn_';
    public $__multilang = true;
    public $__multisiting = false;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'belongs_to' => array (
            'Module_Forms' => 'sn_form'
        ),
        'has_many' => array (
            'Module_Forms_Senders_Answers' => 'sn_id',
        )
    );
    
    /*** Db fields (with specific prefix) ***/
    public $sn_id;
    //public $sn_user;
    public $sn_form;
    public $sn_date;
    public $sn_ip;
    public $sn_answer; //упрощенный способ хранения ответов - в одном поле (либо в key-value хранилище)
}