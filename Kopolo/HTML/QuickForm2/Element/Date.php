<?php
require_once 'HTML/QuickForm2/Element.php';

/**
 * Клас для добавления поля выбора даты
 * @version 1.01 [15.05.2011]
 * @category     HTML
 * @package      HTML_QuickForm2
 * @author       kopolo.ru
 * @developers   Elena Kondratieva [elena@kopolo.ru]
 *               Andrey Kondratev  [andr@kopolo.ru]
 * 
 * TO DO: JS-calendar
 */

class HTML_QuickForm2_Element_Date extends HTML_QuickForm2_Element
{
    /**
     * (non-PHPdoc)
     * @see www/Lib/PEAR/HTML/QuickForm2/Element/HTML_QuickForm2_Element_InputFile#setValue($value)
     */
    public function setValue($value) 
    {
        $this->value = $value;
        return $this;
    }
    
    public function getType()
    {
        return $this->attributes['type'];
    }
    
    public function getValue()
    {
        $name = $this->getName();
        $current_value = $this->getValueStatic();
        if (isset($_REQUEST[$name . '-day']) && isset($_REQUEST[$name . '-month']) && isset($_REQUEST[$name . '-year'])) {
            $day = $_REQUEST[$name . '-day'];
            $month = $_REQUEST[$name . '-month'];
            $year = $_REQUEST[$name . '-year'];
            if (@checkdate($month, $day, $year)) {
                $value = mktime (0, 0, 0, $month, $day, $year);
            } else {
                $value = $current_value;
                $this->setError('Неизвестная дата.');
            }
        } elseif ($current_value != false) {
            $value = $current_value;
        } else {
            $value = time();
        }
        $this->setValue($value);
        return $value;
    }
    
    /**
     * Возвращает значение элемента
     * @return string
     */
    protected function getValueStatic() {
        $name = $this->getName();
        foreach ($this->getDataSources() as $ds) {
            if (null !== ($value = $ds->getValue($name))) {
                return $value;
            }
        }
        return false;
    }
    
    /**
     * (non-PHPdoc)
     * @see www/Lib/PEAR/HTML/QuickForm2/Element/HTML_QuickForm2_Element_Input#__toString()
     */
    public function __toString()
    { 
        $value = $this->getValue();
        $name = $this->getName();
        $id = $this->getId();
        
        $string_html = '<div class="date">';
        $string_html .= '<select name="' . $name . '-day" id="' . $id . '-day" class="day">' . $this->getDays(date('j', $value)) . '</select>';
        $string_html .= '<select name="' . $name . '-month" id="' . $id . '-month" class="month">' . $this->getMonths(date('n', $value)) . '</select>';
        $string_html .= '<select name="' . $name . '-year" id="' . $id . '-year" class="year">' . $this->getYears(date('Y', $value)) . '</select>';
        $string_html .= '</div>';
        
        return $string_html;
    }
    
   /**
    * Получение списка дней месяца
    *
    * @param  integer выбранный день
    * @return string HTML
    */
    private function getDays($day) 
    {
        $options = '';
        for ($i=1;$i<=31;$i++) {
            $options .= '<option value="' . $i . '"' . ($i==$day?'selected="selected"':'') . '>' . $i . '</option>';
        }
        return $options;
    }
    
    private function getMonths($month) 
    {
        $months = array(
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10=> 'октября',
            11=> 'ноября',
            12=> 'декабря'
        );
        
        $options = '';
        for ($i=1;$i<=12;$i++) {
            $options .= '<option value="' . $i . '"' . ($i==$month?'selected="selected"':'') . '>' . $months[$i] . '</option>';
        }
        return $options;
    }
    
    private function getYears($year) 
    {
        $start = $year-5;
        $stop = $year+5;
        
        $options = '';
        for ($i=$start;$i<=$stop;$i++) {
            $options .= '<option value="' . $i . '"' . ($i==$year?'selected="selected"':'') . '>' . $i . '</option>';
        }
        return $options;
    }
}
?>