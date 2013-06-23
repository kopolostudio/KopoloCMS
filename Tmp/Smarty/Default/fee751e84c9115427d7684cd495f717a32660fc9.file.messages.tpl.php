<?php /* Smarty version Smarty-3.0.6, created on 2013-06-23 07:28:59
         compiled from "W:/home/kopolocms/www/Themes/Default/templates\messages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2377551c66b7bcb20b4-47124016%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fee751e84c9115427d7684cd495f717a32660fc9' => 
    array (
      0 => 'W:/home/kopolocms/www/Themes/Default/templates\\messages.tpl',
      1 => 1318141366,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2377551c66b7bcb20b4-47124016',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (count($_smarty_tpl->getVariable('messages')->value)){?><div class="messages-box"><?php  $_smarty_tpl->tpl_vars['array'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('messages')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['array']->key => $_smarty_tpl->tpl_vars['array']->value){
 $_smarty_tpl->tpl_vars['type']->value = $_smarty_tpl->tpl_vars['array']->key;
?><?php if (count($_smarty_tpl->tpl_vars['array']->value)){?><div class="messages <?php echo $_smarty_tpl->tpl_vars['type']->value;?>
"><?php  $_smarty_tpl->tpl_vars['message'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['message']->key => $_smarty_tpl->tpl_vars['message']->value){
?><span><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</span><?php }} ?></div><?php }?><?php }} ?></div><?php }?>