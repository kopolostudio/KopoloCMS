<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker */

/**
 * This is a driver file contains the Image_Tools_Thumbnail class
 *
 * PHP versions 4 and 5
 *
 * LICENSE:
 *
 * Copyright (c) 2006 Ildar N. Shaimordanov <ildar-sh@mail.ru>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted under the terms of the BSD License.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category    Images
 * @package     Image_Tools
 * @author      Ildar N. Shaimordanov <ildar-sh@mail.ru>
 * @copyright   Copyright (c) 2006 Ildar N. Shaimordanov <ildar-sh@mail.ru>
 * @license     http://www.opensource.org/licenses/bsd-license.php
 *              BSD License
 * @version     CVS: $Id: Thumbnail.php,v 1.3 2006/11/23 22:17:31 firman Exp $
 */

require_once 'Image/Tools.php';

// {{{ Constants

/**
* Maximal scaling
*/
define('IMAGE_TOOLS_THUMBNAIL_METHOD_SCALE_MAX', 0);

/**
* Minimal scaling
*/
define('IMAGE_TOOLS_THUMBNAIL_METHOD_SCALE_MIN', 1);

/**
* Cropping of fragment
*/
define('IMAGE_TOOLS_THUMBNAIL_METHOD_CROP',      2);

/**
* Align constants
*/
define('IMAGE_TOOLS_THUMBNAIL_ALIGN_CENTER', 0);
define('IMAGE_TOOLS_THUMBNAIL_ALIGN_LEFT',   -1);
define('IMAGE_TOOLS_THUMBNAIL_ALIGN_RIGHT',  +1);
define('IMAGE_TOOLS_THUMBNAIL_ALIGN_TOP',    -1);
define('IMAGE_TOOLS_THUMBNAIL_ALIGN_BOTTOM', +1);

// }}}
// {{{ Class: Image_Tools_Thumbnail

/**
 * This class provide thumbnail creating tool for manipulating an image
 *
 * @category    Images
 * @package     Image_Tools
 * @author      Ildar N. Shaimordanov <ildar-sh@mail.ru>
 * @copyright   Copyright (c) 2006 Ildar N. Shaimordanov <ildar-sh@mail.ru>
 * @license     http://www.opensource.org/licenses/bsd-license.php
 *              BSD License
 * @version     Release: 0.4.2
*/
class Image_Tools_Thumbnail extends Image_Tools
{
    // {{{ Properties

    /**
     * Thumbnail options:
     * <pre>
     * image   mixed  Destination image, a filename or an image string data or a GD image resource
     * width   int    Width of thumbnail
     * height  int    Height of thumbnail
     * percent number Size of thumbnail per size of original image
     * method  int    Method of thumbnail creating
     * halign  int    Horizontal align
     * valign  int    Vertical align
     * </pre>
     *
     * @var     array
     * @access  protected
     */
    var $options = array(
        'image'   => null,
        'width'   => 100,
        'height'  => 100,
        'percent' => 0,
        'method'  => IMAGE_TOOLS_THUMBNAIL_METHOD_SCALE_MAX,
        'halign'  => IMAGE_TOOLS_THUMBNAIL_ALIGN_CENTER,
        'valign'  => IMAGE_TOOLS_THUMBNAIL_ALIGN_CENTER,
    );

    /**
     * Available options for Image_Tools_Thumbnail
     *
     * @var     array
     * @access  protected
     */
    var $availableOptions = array(
        'image'   => 'mixed',
        'width'   => 'int',
        'height'  => 'int',
        'percent' => 'number',
        'method'  => 'int',
        'halign'  => 'int',
        'valign'  => 'int',
    );

    /**
     * Image_Tools_Thumbnail API version.
     *
     * @var     string
     * @access  protected
     */
    var $version = '0.1';

    /**
     * Image info.
     *
     * @var     resource
     * @access  protected
     */
    var $imageInfo = null;

    // }}}
    // {{{ render()

    /**
     * Draw thumbnail result to resource.
     *
     * @return  bool|PEAR_Error TRUE on success or PEAR_Error on failure.
     * @access  public
     */
    function render()
    {
        // Create the source image
        $source = Image_Tools::createImage($this->options['image']);
        if ( PEAR::isError($source) ) {
            return $source;
        }
        if ( ! Image_Tools::isGDImageResource($source) ) {
            return PEAR::raiseError('Invalid image resource');
        }
        $this->_init($source);

        // Estimate a rectangular portion of the source image and a size of the target image
        if ( $this->options['method'] == IMAGE_TOOLS_THUMBNAIL_METHOD_CROP ) {
            if ( $this->options['percent'] ) {
                $W = floor($this->options['percent'] * $this->imageInfo['width']);
                $H = floor($this->options['percent'] * $this->imageInfo['height']);
            } else {
                $W = $this->options['width'];
                $H = $this->options['height'];
            }

            $width = $W;
            $height = $H;

            $Y = $this->_coord('valign', 'height', $H);
            $X = $this->_coord('halign', 'width', $W);
        } else {
            $W = $this->imageInfo['width'];
            $H = $this->imageInfo['height'];

            if ( $this->options['percent'] ) {
                $width = floor($this->options['percent'] * $W);
                $height = floor($this->options['percent'] * $H);
            } else {
                $width = $this->options['width'];
                $height = $this->options['height'];

                if ( $this->options['method'] == IMAGE_TOOLS_THUMBNAIL_METHOD_SCALE_MIN ) {
                    $Ww = $W / $width;
                    $Hh = $H / $height;
                    if ( $Ww > $Hh ) {
                        $W = floor($width * $Hh);
                        $X = $this->_coord('halign', 'width', $W);
                    } else {
                        $H = floor($height * $Ww);
                        $Y = $this->_coord('valign', 'height', $H);
                    }
                } else {
                    if ( $H > $W ) {
                        $width = floor($height / $H * $W);
                    } else {
                        $height = floor($width / $W * $H);
                    }
                }
            }

            $X = 0;
            $Y = 0;
        }

        // Create the target image
        if ( function_exists('imagecreatetruecolor') ) {
            $target = imagecreatetruecolor($width, $height);
        } else {
            $target = imagecreate($width, $height);
        }
        if ( ! Image_Tools::isGDImageResource($target) ) {
            return PEAR::raiseError('Cannot initialize new GD image stream');
        }

        // Copy the source image to the target image
        if ( $this->options['method'] == IMAGE_TOOLS_THUMBNAIL_METHOD_CROP ) {
            $result = imagecopy($target, $this->resultImage, 0, 0, $X, $Y, $W, $H);
        } elseif ( function_exists('imagecopyresampled') ) {
            $result = imagecopyresampled($target, $this->resultImage, 0, 0, $X, $Y, $width, $height, $W, $H);
        } else {
            $result = imagecopyresized($target, $this->resultImage, 0, 0, $X, $Y, $width, $height, $W, $H);
        }
        if ( ! $result ) {
            return PEAR::raiseError('Cannot resize image');
        }

        // Free a memory from the source image and save the resulting thumbnail
        imagedestroy($this->resultImage);
        $this->_init($target);

        return true;
    }

    // }}}
    // {{{ _init()

    function _init($res)
    {
        $this->resultImage = $res;
        $this->imageInfo = array(
            'width'  => imagesx($this->resultImage),
            'height' => imagesy($this->resultImage),
        );
    }

    // }}}
    // {{{ _coord()

    function _coord($align, $param, $src)
    {
        if ( $this->options[$align] < IMAGE_TOOLS_THUMBNAIL_ALIGN_CENTER ) {
            $result = 0;
        } elseif ( $this->options[$align] > IMAGE_TOOLS_THUMBNAIL_ALIGN_CENTER ) {
            $result = $this->imageInfo[$param] - $src;
        } else {
            $result = ($this->imageInfo[$param] - $src) >> 1;
        }
        return $result;
    }

    // }}}

}

// }}}

/*
 * Local variables:
 * mode: php
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>