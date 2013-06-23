<?php

/**
* Вывод пользовательских сообщений
*/
 
class Kopolo_Messages
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
    private $_messages = array(); 
 
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
     * Добавление сообщения о пользовательской ошибке типа error
     * 
     * @param string текст сообщения
     * @param integer уровень приватности (0 - всем, 1 - разработчикам)
     * @return void
     */
    static public function error($message) {
        self::getInstance()->_messages['errors'][] = $message;
    }
    
    /**
     * Добавление сообщения о пользовательской ошибке типа warning
     * 
     * @param string текст сообщения
     * @param integer уровень приватности (0 - всем, 1 - разработчикам)
     * @return void
     */
    static public function warning($message) {
        self::getInstance()->_messages['warnings'][] = $message;
    }
    
    /**
     * Добавление сообщения для пользователя об успешном выполнении какого-либо действия
     * 
     * @param string текст сообщения
     * @param integer уровень приватности (0 - всем, 1 - разработчикам)
     * @return void
     */
    static public function success($message) {
        self::getInstance()->_messages['success'][] = $message;
    }
    
    /**
     * Получение массива с пользовательскими сообщениями
     * 
     * @return array
     */
    static public function getUserMessages() {
        $messages = self::getInstance()->_messages;
        
        $session_messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
        $registered_messages = !empty($messages) ? $messages : array();
        
        //сливаем сообщения, сохраненные в сессии, и добавленные при текущем запросе
        $messeges = array_merge_recursive($session_messages, $registered_messages);
        
        //удаление сообщений
        $_SESSION['messages'] = null;
        self::getInstance()->_messages = null;
        
        return $messeges;
    }
    
    /**
     * Destructor
     * @return void
     */
    public function __destruct() {
        $messages = self::getInstance()->_messages;
        $_SESSION['messages'] = $messages;
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