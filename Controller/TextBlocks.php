<?php

/**
* Текстовые блоки
*
* @version 1.0 / 05.10.2011
*/

class Controller_TextBlocks extends Kopolo_Controller
{
    function __construct($params)
    {
        $tb = new Module_TextBlocks();
        $tb->find();
        
        $textblocks = array();
        if ($tb->N > 0) {
            while($tb->fetch()) {
                $textblocks[$tb->tb_nick][] = $tb->toArray();
            }
        }
        Kopolo_Registry::appendTo('content', 'textblocks', $textblocks);
    }
}
?>