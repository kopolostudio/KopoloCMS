<?php

/**
* Работа с логами
*/
 
class Kopolo_Log
{
    /**
    * Записывает текст в файл лога
    */
    static function write ($text) {
        
        //при включенном режиме разработки логи выводятся в браузер
        if (KOPOLO_DEVELOP_MODE == 1) {
            echo '<b>' .  __METHOD__ . '</b>: ' . $text . '<br />';
        }
        $log_file = KOPOLO_PATH_LOG . date('Y-m-d') . '.txt';
        $log_text = date("H:i:s") . "\n\r" . $text . "\n\r\n\r";
        error_log($log_text, 3, $log_file);
    }
}
 
?>