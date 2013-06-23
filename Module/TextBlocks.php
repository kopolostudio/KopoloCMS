<?php

/**
* Модуль текстовых блоков
* 
* @version 1.0 / 05.10.2011
* @package TextBlocks
* 
* Kopolo CMS [http://kopolocms.ru]
*/

class Module_TextBlocks extends Kopolo_Module
{    
    /*** Base class properties ***/
    public $__prefix = 'tb_';
    public $__multilang = true;
    public $__multisiting = true;
    
    /*** Db fields ***/
    public $tb_id;

    public $tb_name;
    public $tb_nick;
    public $tb_info;
    
    //public $tb_is_active;
    //public $tb_position;
}
?>