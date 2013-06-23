<?php

/**
 * Base class for HTML_QuickForm2 rules
 */
require_once 'HTML/QuickForm2/Rule.php';

require_once 'Image/Transform.php';
require_once 'Image/Transform/Driver/GD.php';

/**
 * Правило проверяющее ширину и высоту картинки
 * 
 * Параметры передаваемые в массиве options
 * maxwidth integer - максимальная ширина изображения
 * maxheight integer - максимальная высота изображения
 * reversible boolean - если указываем размеры изображения без привязки к формату
 * шириной считаем большую сторону
 *
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     kopolo.ru
 * @developer Andrey Kondratiev [andr@kopolo.ru]
 */
class HTML_QuickForm2_Rule_MaxImageSize extends HTML_QuickForm2_Rule
{
   /**
    * Validates the owner element
    *
    * @return   bool    whether uploaded file's size is within given limit
    */
    protected function validateOwner()
    {
        $value = $this->owner->getValue();
        $image = Image_Transform::factory('GD');
        $image->load($value['tmp_name']);
		$width = $image->getImageWidth();
		$height = $image->getImageHeight();
		if ($width <= $this->config['maxwidth'] && $height <= $this->config['maxheight']) {
			return true;	
		} elseif( $this->config['reversible'] == true && $height <= $this->config['maxwidth'] && $width <= $this->config['maxheight']) {  
			return true;
		} else {
			return false;
		}
    }

   /**
    * Sets maximum width and height
    *
    * @param    int     Maximum allowed size
    * @return   HTML_QuickForm2_Rule
    * @throws   HTML_QuickForm2_InvalidArgumentException    if a bogus size limit was provided 
    */
    public function setConfig($config)
    {    
    	$maxwidth = (int) $config['maxwidth'];
    	$maxheight = (int) $config['maxheight'];
    	/*Картинка может быть как горизонтальной, так и вертикальной*/
    	if (isset($config['reversible']) && $config['reversible']==true) {
    		$reversible = true;
    	} else {
    		$reversible = false;
    	}
        if (0 >= $maxwidth) {
            throw new HTML_QuickForm2_InvalidArgumentException(
                'MaxImageArea Rule requires a array with positive size limits,' .
                preg_replace('/\s+/', ' ', var_export($config, true)) . ' given'
            );
        }
        if (0 >= $maxheight) {
            throw new HTML_QuickForm2_InvalidArgumentException(
                'MaxImageArea Rule requires a array with positive size limits,' .
                preg_replace('/\s+/', ' ', var_export($config, true)) . ' given'
            );
        }
        $config = array('maxwidth'=>$maxwidth, 'maxheight'=>$maxheight, 'reversible'=>$reversible);
        return parent::setConfig($config);
    }

   /**
    * Sets the element that will be validated by this rule
    *
    * @param    HTML_QuickForm2_Element_InputFile   File upload field to validate
    * @throws   HTML_QuickForm2_InvalidArgumentException    if trying to use
    *           this Rule on something that isn't a file upload field
    */
    public function setOwner(HTML_QuickForm2_Node $owner)
    {
        if (!$owner instanceof HTML_QuickForm2_Element_InputFile) {
            throw new HTML_QuickForm2_InvalidArgumentException(
                'MaxImageArea Rule can only validate file upload fields, '.
                get_class($owner) . ' given'
            );
        }
        parent::setOwner($owner);
    }
}
?>
