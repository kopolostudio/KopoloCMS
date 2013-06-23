<?php

/**
 * Класс включающий методы для работы со строками
 *
 * @version 0.1 / 28.01.2011
 * @author kopolo.ru
 * @developers Elena Kondratieva [elena@kopolo.ru]
 */
final class Kopolo_String
{
    /**
     * Возвращает транслитерированное имя файла
     * 
     * @param string
     * @return string
     */
    static function transliterate($string)
    {
        $replace_pairs = array(
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'j',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ь' => "",
            'ы' => 'y',
            'ъ' => "",
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'E',
            'Ж' => 'Zh',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'J',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'C',
            'Ч' => 'Ch',
            'Ш' => 'Sh',
            'Щ' => 'Sch',
            'Ь' => "",
            'Ы' => 'Y',
            'Ъ' => "",
            'Э' => 'E',
            'Ю' => 'Yu',
            'Я' => 'Ya',
            '№' => 'No'
        );
        $string = strtr($string, $replace_pairs);
        return $string;
    }
    
    /**
     * Возвращает транслитерированную для использования в URL строку
     * 
     * @param string
     * @return string or false
     */
    static function transliterate4url($string)
    {
        if (!preg_match('/^[a-z0-9-.]+$/i', $string)) {
            $string = Kopolo_String::transliterate($string);
            
            /* Находим все вкрапления кракозябл и заменяем на - */
            $matches = array();
            preg_match_all('/[^a-z0-9-.]/i', $string, &$matches);
            if (count($matches[0])) {
                foreach($matches[0] as $num => $match) {
                    $string = str_replace($match, '-', $string);
                }
            }
            
            /* Если не удалось получить корректное имя - возвращаем false */
            if (!preg_match('/^[a-z0-9-.]+$/i', $string)) {
                return false;
            }
        }
        return $string;
    }
    
    /**
     * Возвращает транслитерированную для использования в названии файла строку
     * 
     * @param string
     * @return string or false
     */
    static function transliterate4filename($string)
    {
        if (!preg_match('/^[a-z0-9-_.]+$/i', $string)) {
            $string = Kopolo_String::transliterate($string);
            
            /* Находим все вкрапления кракозябл и заменяем на _ */
            $matches = array();
            preg_match_all('/[^a-z0-9-_.]/i', $string, &$matches);
            if (count($matches[0])) {
                foreach($matches[0] as $num => $match) {
                    $string = str_replace($match, '_', $string);
                }
            }
            
            /* Если не удалось получить корректное имя - возвращаем false */
            if (!preg_match('/^[a-z0-9-_.]+$/i', $string)) {
                return false;
            }
        }
        return $string;
    }
    
    /**
     * Очищает строку от ненужных/небезопасных символов для вывода в HTML
     * 
     * @param string
     * @return string or false
     */
    static function escape4HTML($string) {
        $string = str_replace('"', '\'', strip_tags($string));
        return $string;
    }
    
    function __construct()
    {}
    
    function __clone()
    {}
}