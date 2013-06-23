<?php /* Smarty version Smarty-3.0.6, created on 2013-06-23 07:28:59
         compiled from "W:/home/kopolocms/www/Themes/Default/templates\textblocks/sidebar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1156451c66b7bd45ba8-23190556%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30d8654f217556df6971d5a5d3f290c328594985' => 
    array (
      0 => 'W:/home/kopolocms/www/Themes/Default/templates\\textblocks/sidebar.tpl',
      1 => 1318141366,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1156451c66b7bd45ba8-23190556',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('textblocks')->value['sidebar']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?><div class="block"><h2><?php echo $_smarty_tpl->tpl_vars['item']->value['tb_name'];?>
</h2><?php echo $_smarty_tpl->tpl_vars['item']->value['tb_info'];?>
</div><?php }} ?>