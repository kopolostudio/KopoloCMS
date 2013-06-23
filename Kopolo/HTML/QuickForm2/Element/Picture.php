<?php
require_once 'HTML/QuickForm2/Element/InputFile.php';

/**
 * Клас для добавления поля загрузки изображения
 *
 * @version 1.0 / 01.12.2010
 * @category   HTML
 * @package    HTML_QuickForm2
 * 
 * Kopolo CMS [http://kopolocms.ru]
 */

class HTML_QuickForm2_Element_Picture extends HTML_QuickForm2_Element_InputFile
{
    /**
     * Возвращает значение элемента, для прочих нужд
     * (значение, установленное ранее)
     * @return string
     */
    protected function getValueStatic() {
        $name = $this->getName();
        foreach ($this->getDataSources() as $ds) {
            if (null !== ($value = $ds->getValue($name))) {
                return $value;
            }
        }
    }
    
    /**
     * (non-PHPdoc)
     * @see www/Lib/PEAR/HTML/QuickForm2/Element/HTML_QuickForm2_Element_InputFile#setValue($value)
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see HTML_QuickForm2_Element_InputFile::validate()
     */
    public function validate() {
        $static_value = $this->getValueStatic();
        $value = $this->getValue();
        if (UPLOAD_ERR_NO_FILE == $value['error'] && !empty($static_value)) {
            /*Если картинка уже загружена и ничего не загружается в замен - то и нечего её проверять*/
            return true;
        }
        return parent::validate();
    }
    
    /**
     * (non-PHPdoc)
     * @see www/Lib/PEAR/HTML/QuickForm2/Element/HTML_QuickForm2_Element_Input#__toString()
     */
    public function __toString()
    {
        $value = $this->getValue();
        if (isset($value) && !is_array($value)) {
            $value_static = $value;
        } else {
            $value_static = $this->getValueStatic();
        }
        $name = $this->getName();
        $id = $this->getId();
        
        $string_html = '<div class="picture_upload">';
        if (!empty($value_static)) {
            $preview = Kopolo_Template_Plugins::resize(array(
                'file'=>$value_static,
                'width'=>100,
                'height'=>67
            ));
            $string_html .= '
                    <div class="full_file">
                        <a href="'.$value_static.'" target="_blank">'.$value_static.'</a>
                    </div>
                    <div class="preview">
                        '.$preview.'
                        <input type="checkbox" class="checkbox" id="'.$id.'-delete" name="delete_file['.$name.']" value="1"/>                    
                        <label for="'.$id.'-delete">удалить</label>
                    </div>';
        }
        $string_html .= '
                    <div class="upload">
                        <div class="from_server">
                            <span class="title">Выбрать на сервере:</span>
                            <input type="text" id="kfm_server_file" name="'.$name.'_from-server" />
                            <button type="button" id="filemanger">Обзор</button>
                        </div>
                        <div class="from_computer">
                            <span class="title">Загрузить с компьютера:</span>
                            <input type="file" id="'.$id.'" name="'.$name.'" />
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>';
        return $string_html;
    }
}
?>