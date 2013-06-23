<?php /* Smarty version Smarty-3.0.6, created on 2013-06-23 07:28:59
         compiled from "W:/home/kopolocms/www/Themes/Default/templates\news/last.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25651c66b7b7d8215-63062782%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e60f4926b20f9d1dcac345ed45b6dafbd556c430' => 
    array (
      0 => 'W:/home/kopolocms/www/Themes/Default/templates\\news/last.tpl',
      1 => 1318141366,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25651c66b7b7d8215-63062782',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('items')->value){?><div class="block news"><h2><a href="/news/">Новости</a></h2><ul class="info-list"><?php  $_smarty_tpl->tpl_vars["item"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('items')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["item"]->key => $_smarty_tpl->tpl_vars["item"]->value){
?><li><div class="date"><?php echo Kopolo_Template_Plugins::human_date(array('timestamp'=>$_smarty_tpl->getVariable('item')->value['ns_date']),$_smarty_tpl);?>
</div><a href="/news/<?php echo $_smarty_tpl->getVariable('item')->value['ns_id'];?>
/"><?php echo $_smarty_tpl->getVariable('item')->value['ns_name'];?>
</a></li><?php }} ?></ul></div><?php }?>