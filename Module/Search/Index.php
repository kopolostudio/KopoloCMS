<?php

/**
* Модуль индекса поиска
* 
* @varsion 1.0 [15.12.2010]
* @package Search
*/

class Module_Search_Index extends Kopolo_Module
{
    /*** Base module properties ***/
    
    /**
    * Префикс полей класса
    * @var string
    */
    public $__prefix = 'si_';
    
    /**
    * Мультиязычность
    * @var boolean
    */
    public $__multilang = true;
    
    /**
    * Мультисайтовость
    * @var boolean
    */
    public $__multisiting = true;
    
    /*** Db fields ***/
    public $si_id;

    public $si_name;
    public $si_info;
    public $si_uri;
}