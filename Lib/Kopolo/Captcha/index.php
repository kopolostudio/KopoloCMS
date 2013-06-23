<?php

/**
 * Генерация картинки для каптчи
 * записывает в сессию переменную kopolo_captcha с кодом каптчи
 * 
 * @version 1.0 / 18.02.2011
*/
ini_set ('display_errors', 'off');
error_reporting (E_ERROR);

header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header ('Last-Modified: '.gmdate ("D, d M Y H:i:s").' GMT');
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header ('Content-type: image/png');

session_start ();

$baseurl = dirname (__FILE__).'/';

$heightim = 20;
$height = 49;
$width = 90;

$im = imagecreatefrompng ($baseurl . 'background.png');

$c1 = ImageColorAllocate ($im, 0x46, 0x46, 0x46);
$c2 = ImageColorAllocate ($im, 0x33, 0x66, 0x00);
$c3 = ImageColorAllocate ($im, 0xB4, 0x61, 0x47);
$c4 = ImageColorAllocate ($im, 0x47, 0x4C, 0xB4);
$c5 = ImageColorAllocate ($im, 0xD8, 0x74, 0xC6);
$c6 = ImageColorAllocate ($im, 0x10, 0xAE, 0xD6);
$c7 = ImageColorAllocate ($im, 0xD6, 0xA6, 0x00);

$colors = array ($c1, $c2, $c3, $c4, $c5, $c6, $c7);

//	$letters = array ('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

//	$letters = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

$letters = array ('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

shuffle ($letters);

$n = '';
$k = 0;
do
{
    $let = $letters[rand (0, count($letters) - 1)];
    if (strpos ($n, $let) === false)
    {
        $n .= $let;
        $k++;
    }
} while ($k < 5);

$_SESSION['kopolo_captcha'] = strtolower ($n);

$i = 0;
foreach (preg_split ("//", $n) as $a)
{
    $c = rand (0, 60) - 30;
    $h = 16;
    if ($c < -10)
        $h -= 3;
    if ($c > 10)
        $h += 3;
    ImageTTFText ($im, 14, $c,  $i - 12, $h, $colors[rand (0, sizeOf ($colors))], $baseurl.'ARIAL.TTF', $a);
    $i += 17;
}

session_register ('KopoloCaptcha');
$KopoloCaptcha = $n + 125;

ImagePng ($im);
ImageDestroy ($im);
?>