<?php

/**
* Кеширование
*/
 
class Kopolo_Cache
{
    /**
     * Кеширует в сессии объект с указанным ключем
     */
    public static function sessionCashe($key, $data, $serialize=false) {
        Kopolo_Session::initSession();
        if ($serialize==true) {
            $data = serialize($data);
        }
        $_SESSION['cache'][$key] = $data;
        return true;
    }
    
    /**
     * Получает из сессии объект с указанным ключом
     */
    public static function getSessionCashe($key, $unserialize=false) {
        Kopolo_Session::initSession();
        if (isset($_SESSION['cache'][$key])) {
            $data = $_SESSION['cache'][$key];
            if ($unserialize==true) {
                $data = unserialize($data);
                return $data;
            }
        }
        return false;
    }
    
    /**
     * Очистка кеша в сессии
     */
    public static function clearSessionCashe() {
        Kopolo_Session::initSession();
        unset($_SESSION['cache']);
    }
}
 
?>