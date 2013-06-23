<?php

/**
 * Модуль шаблонов
 *
 * @author  kopolo.ru
 * @version 0.1 [16.11.2010]
 * @package Templates
 */

class Module_Templates extends Kopolo_Module
{
    /*Base class properties*/
    public $__prefix = 'tpl_';
    public $__multilang = false;
    public $__site_field = 'tpl_site';
    
    /*Db fields*/
    public $tpl_id;
    public $tpl_site;
    public $tpl_type;
    public $tpl_name;
    public $tpl_path;
}