<?php
require_once 'HTML/QuickForm2/Element/InputText.php';

/**
 * Клас для добавления поля каптчи в форму
 *
 * @version 1.0 [17.02.2011]
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     kopolo.ru
 * @developer  Elena Kondratieva [elena@kopolo.ru]
 */

class HTML_QuickForm2_Element_Captcha extends HTML_QuickForm2_Element_InputText
{
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
    * Performs the server-side validation
    *
    * @return   boolean     Whether the element is valid
    */
    protected function validate() {
        $value = $this->getValueStatic();
        if (strtolower($value) != $_SESSION['kopolo_captcha']) { //XXX: получать не data['error'], а required сообщение
            $this->error = isset($this->data['error']) ? $this->data['error'] : 'Вы неправильно ввели цифры';
            return false;
        }
        return parent::validate();
    }
    
    /**
     * (non-PHPdoc)
     * @see www/Lib/PEAR/HTML/QuickForm2/Element/HTML_QuickForm2_Element_Input#__toString()
     */
    public function __toString()
    { 
        $name = $this->getName();
        $id = $this->getId();
        
        $string_html  = '<div class="captcha">';
        $string_html .=     '<img src="/Files/captcha.png" />';
        $string_html .=     '<input' . $this->getAttributes(true) . ' />';
        $string_html .= '</div>';
        
        return $string_html;
    }
}
?>