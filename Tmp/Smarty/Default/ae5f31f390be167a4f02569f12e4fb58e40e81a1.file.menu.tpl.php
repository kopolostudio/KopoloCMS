<?php /* Smarty version Smarty-3.0.6, created on 2013-06-23 07:28:59
         compiled from "W:/home/kopolocms/www/Themes/Default/templates\menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2923451c66b7b1ae102-95485407%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae5f31f390be167a4f02569f12e4fb58e40e81a1' => 
    array (
      0 => 'W:/home/kopolocms/www/Themes/Default/templates\\menu.tpl',
      1 => 1318141366,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2923451c66b7b1ae102-95485407',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (count($_smarty_tpl->getVariable('menu')->value)){?><ul><?php  $_smarty_tpl->tpl_vars["pg"] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('menu')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars["pg"]->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars["pg"]->iteration=0;
 $_smarty_tpl->tpl_vars["pg"]->index=-1;
if ($_smarty_tpl->tpl_vars["pg"]->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars["pg"]->key => $_smarty_tpl->tpl_vars["pg"]->value){
 $_smarty_tpl->tpl_vars["pg"]->iteration++;
 $_smarty_tpl->tpl_vars["pg"]->index++;
 $_smarty_tpl->tpl_vars["pg"]->first = $_smarty_tpl->tpl_vars["pg"]->index === 0;
 $_smarty_tpl->tpl_vars["pg"]->last = $_smarty_tpl->tpl_vars["pg"]->iteration === $_smarty_tpl->tpl_vars["pg"]->total;
?><li class="<?php if ($_smarty_tpl->getVariable('pg')->value['pg_id']==$_smarty_tpl->getVariable('page')->value['pg_id']){?>active<?php }?><?php if ($_smarty_tpl->getVariable('pg')->first){?> first<?php }elseif($_smarty_tpl->getVariable('pg')->last){?> last<?php }?><?php if (count($_smarty_tpl->getVariable('pg')->value['children'])){?> parent<?php }?>"><a href="<?php echo $_smarty_tpl->getVariable('lang_link')->value;?>
/<?php if ($_smarty_tpl->getVariable('pg')->value['pg_nick']!='first'){?><?php echo $_smarty_tpl->getVariable('pg')->value['pg_nick'];?>
/<?php }?>"><span><?php echo $_smarty_tpl->getVariable('pg')->value['pg_name'];?>
</span></a><?php if (count($_smarty_tpl->getVariable('pg')->value['children'])){?><ul class="submenu"><?php  $_smarty_tpl->tpl_vars['subpg'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pg')->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['subpg']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['subpg']->iteration=0;
 $_smarty_tpl->tpl_vars['subpg']->index=-1;
if ($_smarty_tpl->tpl_vars['subpg']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['subpg']->key => $_smarty_tpl->tpl_vars['subpg']->value){
 $_smarty_tpl->tpl_vars['subpg']->iteration++;
 $_smarty_tpl->tpl_vars['subpg']->index++;
 $_smarty_tpl->tpl_vars['subpg']->first = $_smarty_tpl->tpl_vars['subpg']->index === 0;
 $_smarty_tpl->tpl_vars['subpg']->last = $_smarty_tpl->tpl_vars['subpg']->iteration === $_smarty_tpl->tpl_vars['subpg']->total;
?><li class="<?php if ($_smarty_tpl->tpl_vars['subpg']->value['pg_id']==$_smarty_tpl->getVariable('page')->value['pg_id']){?>active<?php }?><?php if ($_smarty_tpl->tpl_vars['subpg']->first){?> first<?php }elseif($_smarty_tpl->tpl_vars['subpg']->last){?> last<?php }?>"><a href="<?php echo $_smarty_tpl->getVariable('lang_link')->value;?>
/<?php if ($_smarty_tpl->getVariable('pg')->value['pg_nick']!='first'){?><?php echo $_smarty_tpl->getVariable('pg')->value['pg_nick'];?>
/<?php }?><?php echo $_smarty_tpl->tpl_vars['subpg']->value['pg_nick'];?>
/"><span><?php echo $_smarty_tpl->tpl_vars['subpg']->value['pg_name'];?>
</span></a></li><?php }} ?></ul><?php }?></li><?php }} ?></ul><?php }?>