<?php
/**
 * Группы полей формы
 *
 * @author  kopolo.ru
 * @version 1.0 / 15.06.2011
 * @package Forms
 * @subpackage Groups
 */

class Module_Forms_Groups extends Kopolo_Module
{
    /*** Base class properties ***/
    public $__prefix = 'gr_';
    public $__multilang = true;
    public $__multisiting = false;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'belongs_to' => array (
            'Module_Forms' => 'gr_form'
        )
    );
    
    /*** Db fields (with specific prefix) ***/
    public $gr_id;
    public $gr_name;
    public $gr_form;
    public $gr_position;
}