<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Renderer.php';

class Kopolo_Form extends HTML_QuickForm2
{
    function __construct($formname, $method = 'post', $attributes = null, $trackSubmit = true)
    {
        parent::__construct($formname, $method, $attributes, $trackSubmit);
        
        /*регистрация дополнительных элементов и правил*/
        HTML_QuickForm2_Factory::registerElement('static','HTML_QuickForm2_Element_Static', KOPOLO_PATH.'Kopolo/HTML/QuickForm2/Element/Static.php');
        HTML_QuickForm2_Factory::registerElement('wysiwyg','HTML_QuickForm2_Element_Wysiwyg', KOPOLO_PATH.'Kopolo/HTML/QuickForm2/Element/Wysiwyg.php');
        HTML_QuickForm2_Factory::registerElement('picture','HTML_QuickForm2_Element_Picture', KOPOLO_PATH.'Kopolo/HTML/QuickForm2/Element/Picture.php');
        HTML_QuickForm2_Factory::registerElement('picturefm','HTML_QuickForm2_Element_Picture', KOPOLO_PATH.'Kopolo/HTML/QuickForm2/Element/PictureFM.php');
        HTML_QuickForm2_Factory::registerRule('maximagesize','HTML_QuickForm2_Rule_MaxImageSize',KOPOLO_PATH.'Kopolo/HTML/QuickForm2/Rule/MaxImageSize.php');
        HTML_QuickForm2_Factory::registerElement('date','HTML_QuickForm2_Element_Date', KOPOLO_PATH.'Kopolo/HTML/QuickForm2/Element/Date.php');
        HTML_QuickForm2_Factory::registerElement('captcha','HTML_QuickForm2_Element_Captcha', KOPOLO_PATH.'Kopolo/HTML/QuickForm2/Element/Captcha.php');
        
        $this->setAttribute('action', '');
        $this->setAttribute('enctype', 'multipart/form-data');
    }
    
    public function html() {
        $renderer = HTML_QuickForm2_Renderer::factory('default')->setOption(array(
            'group_hiddens' => true,
            'group_errors'  => false,
            'required_note' => '<span class="required">* </span> звездочкой отмечены поля, обязательные для заполнения'
        ));
        $html = parent::render($renderer);
        return $html;
    }
    
    /**
     * Получает массив name => label всех элеметов
     * 
     * @return array
     */
    public function getElementsNames() {
        $elements = array();
        foreach ($this->elements as $num => $object) {
            $label = $object->getLabel();
            $name = $object->getName();
            if (!empty($label) && $name != 'imnotbot') {
                $elements[$name] = $label;
            }
        }
        return $elements;
    }
}
?>