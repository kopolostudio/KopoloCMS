<?php
/**
 * Поля формы
 *
 * @author  kopolo.ru
 * @version 1.0 / 15.06.2011
 * @package Forms
 * @subpackage Fields
 */

class Module_Forms_Fields extends Kopolo_Module
{
    /*** Base class properties ***/
    public $__prefix = 'fd_';
    public $__multilang = true;
    public $__multisiting = false;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'belongs_to' => array (
            'Module_Forms' => 'fd_form',
            'Module_Forms_Groups' => 'fd_group'
        ),
        'has_many' => array (
            'Module_Forms_Fields_Variants' => 'fd_id'
        )
    );
    
    /*** Db fields (with specific prefix) ***/
    public $fd_id;
    public $fd_name;
    public $fd_group;
    public $fd_form;
    public $fd_type;
    public $fd_required;
    public $fd_required_text;
    public $fd_position;
}