<?php

/**
* Модуль новостей
* 
* @version 1.1 / 15.06.2011
* @package News
* 
* Kopolo CMS [http://kopolocms.ru]
*/

class Module_News extends Kopolo_Module
{    
    /*** Base class properties ***/
    public $__prefix = 'ns_';
    public $__multilang = true;
    public $__multisiting = true;
    
    /*** Db fields ***/
    public $ns_id;

    public $ns_date;
    public $ns_name;
    public $ns_picture;
    public $ns_announce;
    public $ns_info;
    public $ns_author;
    public $ns_source;

    public $ns_title;
    public $ns_keywords;
    public $ns_description;

    public $ns_is_active;
}