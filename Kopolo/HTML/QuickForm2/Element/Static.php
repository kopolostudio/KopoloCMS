<?php
require_once 'HTML/QuickForm2/Element.php';

/**
 * Класс для добавления статического HTML в форму
 *
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     kopolo.ru
 * @developer Andrey Kondratiev [andr@kopolo.ru]
 */
class HTML_QuickForm2_Element_Static extends HTML_QuickForm2_Element
{
   /**
    * 'type' attribute should not be changeable
    * @var array
    */
    protected $watchedAttributes = array('id', 'name', 'type');

    protected function onAttributeChange($name, $value = null)
    {
        if ('type' == $name) {
            throw new HTML_QuickForm2_InvalidArgumentException(
                "Attribute 'type' is read-only"
            );
        }
        parent::onAttributeChange($name, $value);
    }
    
    public function getType()
    {
        return $this->attributes['type'];
    }
    
    public function setValue($value)
    {
        $this->setAttribute('value', $value);
        return $this;
    }

    public function getValue()
    {
        return $this->getAttribute('disabled')? null: $this->getAttribute('value');
    }
    
    public function __toString()
    {
        $attributes = $this->getAttributes(false);
        /*Удалим аттрибут со значением из аттрибутов тега*/
        if (isset($attributes['value'])) {
        	unset($attributes['value']);
        }
        $attributes_string = self::getAttributesString($attributes);
        return '<div' . $attributes_string . '>'.$this->getValue().'</div>';
    }    

}
?>