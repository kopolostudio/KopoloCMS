<?php
/**
 * Варианты полей формы (select)
 *
 * @author  kopolo.ru
 * @version 1.0 / 20.06.2011
 * @package Forms
 * @subpackage Variants
 */

class Module_Forms_Fields_Variants extends Kopolo_Module
{
    /*** Base class properties ***/
    public $__prefix = 'vt_';
    public $__multilang = true;
    public $__multisiting = false;
    
    /**
     * Relations with other modules
     * @var array
     */
    public $__relations = array (
        'belongs_to' => array (
            'Module_Forms_Fields' => 'vt_field'
        )
    );
    
    /*** Db fields (with specific prefix) ***/
    public $vt_id;
    public $vt_field;
    public $vt_value;
    public $vt_position;
    
    /**
     * Получение вариантов для поля
     * 
     * @param integer ID поля
     *
     * @return array
     */
    public function getVariants($field_id)
    {
        $this->vt_field = $field_id;
        $this->orderBy('vt_position ASC');
        $variants = $this->getList('vt_id', 'vt_value');
        return $variants;
    }
}