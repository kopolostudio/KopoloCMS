<?php

/**
* Реестр глобальных переменных
*/
 
class Kopolo_Registry
{
    /**
     * Singleton registry instance
     * @var Singleton registry instance
     */
    static private $_instance = null;
 
    /**
     * Hash table
     * @var array
     */
    private $_registry = array(); 
 
    /**
     * Get Registry instanse
     * 
     * @return Singleton registry instance
     */
    static public function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }
 
        return self::$_instance;
    }
 
    /**
     * Save an object by key into registry
     * 
     * @param integer|string $key
     * @param object $object
     * @return void
     */
    static public function set($key, $object) {
        self::getInstance()->_registry[$key] = $object;
    }
    
    /**
     * Добавление к существующему объекту реестра какой-либо переменной
     * 
     * @param integer|string $key_to
     * @param integer|string $key
     * @param object $object
     * @return void
     */
    static public function appendTo($key_to, $key, $object) {
        self::getInstance()->_registry[$key_to]->$key = $object;
    }
 
    /**
     * Get an object by key from registry
     * 
     * @param integer|string $key
     * @return object
     */
    static public function get($key) {
        $registry = self::getInstance()->_registry;
        if (isset($registry[$key])) {
            return $registry[$key];
        }
        return false;
    }
    
    /**
     * Возвращает массив реестра
     * Только в KOPOLO_DEVELOP_MODE
     * @return Array
     */
    static function getDump()
    {
        if (KOPOLO_DEVELOP_MODE == 1) {
            return $instance = self::getInstance()->_registry;
        } else {
            return false;
        }
    }
    
    /**
     * Private constructor
     * @return void
     */
    private function __construct() {
    }
 
    /**
     * Disallow cloning
     * @return void
     */
    private function __clone() {
    }
}
 
?>