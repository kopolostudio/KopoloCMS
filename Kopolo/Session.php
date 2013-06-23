<?php

/**
 * Класс включающий методы для работы с сессиями
 *
 * @version 0.1 / 18.12.2010
 * @author kopolo.ru
 * @developer Elena Kondrateva [elena@kopolo.ru]
 */
final class Kopolo_Session
{
    /**
    * Инициализирует сессию, если она ещё не создана
    */
    public static function initSession() {
        if (session_id() == '') {
            session_start();
        }
    }
    
    function __construct()
    {}
    
    function __clone()
    {}
}