<?php
require_once 'HTML/QuickForm2/Element.php';

/**
 * Класс для добавления Wysiwyg редактора
 *
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     kopolo.ru
 * @developer Andrey Kondratiev [andr@kopolo.ru]
 */
class HTML_QuickForm2_Element_Wysiwyg extends HTML_QuickForm2_Element
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

        return '
            <textarea '.$attributes_string.' >'.$this->getValue().'</textarea>
            <script type="text/javascript">'."
                CKEDITOR.replace( '".$attributes['id']."',{
                    language: 'ru',
                    resize_enabled: false,
                    filebrowserBrowseUrl : '/Lib/Kopolo/FileManager/',
                    filebrowserUploadUrl : '/Lib/Kopolo/FileManager/index.php?action=upload&dir=/" . $_GET['modules'] . "',
                    filebrowserWindowWidth : '640',
                    filebrowserWindowHeight : '480'
                });
            </script>
        ";

    }

}