<?php /* Smarty version Smarty-3.0.6, created on 2013-06-23 07:28:59
         compiled from "W:/home/kopolocms/www/Themes/Default/templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:748151c66b7ba1c108-01468121%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '51555c550d295821ac30e6c256432e9cd090f9c8' => 
    array (
      0 => 'W:/home/kopolocms/www/Themes/Default/templates\\index.tpl',
      1 => 1318141366,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '748151c66b7ba1c108-01468121',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include 'W:/home/kopolocms/www/Lib/Smarty/plugins\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><?php $_template = new Smarty_Internal_Template("head.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?></head><body><div class="wrapper"><div class="header"><div class="logo"><?php if (!empty($_smarty_tpl->getVariable('params',null,true,false)->value['logo'])){?><div class="picture"><?php echo Kopolo_Template_Plugins::resize(array('file'=>$_smarty_tpl->getVariable('params')->value['logo'],'height'=>50,'width'=>220),$_smarty_tpl);?>
</div><?php }?><a href="/"><?php echo $_smarty_tpl->getVariable('params')->value['company_name'];?>
</a><?php if (!empty($_smarty_tpl->getVariable('params',null,true,false)->value['slogan'])){?><div class="slogan"><?php echo $_smarty_tpl->getVariable('params')->value['slogan'];?>
</div><?php }?></div><div class="search"><form action="/search/" method="post"><input type="text" name="search" value="" /><button type="submit">Найти</button></form></div><div class="menu"><?php echo $_smarty_tpl->getVariable('components')->value['menu'];?>
</div></div><div class="page"><div class="content"><?php if (!empty($_smarty_tpl->getVariable('page',null,true,false)->value['pg_header'])){?><h1><?php echo $_smarty_tpl->getVariable('page')->value['pg_header'];?>
</h1><?php }?><?php $_template = new Smarty_Internal_Template("messages.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?><?php echo $_smarty_tpl->getVariable('page')->value['pg_info'];?>
<?php echo $_smarty_tpl->getVariable('components')->value['content'];?>
<?php if (count($_smarty_tpl->getVariable('textblocks')->value['content'])){?><?php $_template = new Smarty_Internal_Template("textblocks/content.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?><?php }?></div><div class="right"><?php if (count($_smarty_tpl->getVariable('textblocks')->value['sidebar'])){?><?php $_template = new Smarty_Internal_Template("textblocks/sidebar.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?><?php }?><?php echo $_smarty_tpl->getVariable('components')->value['last_news'];?>
</div></div><div class="footer"><div class="copyright">&copy; <?php if (!empty($_smarty_tpl->getVariable('params',null,true,false)->value['company_name'])){?><?php echo $_smarty_tpl->getVariable('params')->value['company_name'];?>
<?php }else{ ?><?php echo $_SERVER['SERVER_NAME'];?>
<?php }?> 2011<?php if (smarty_modifier_date_format(time(),"%Y")>2011){?>&ndash;<?php echo smarty_modifier_date_format(time(),"%Y");?>
<?php }?></div><div class="contacts"><?php echo $_smarty_tpl->getVariable('params')->value['contacts'];?>
</div><div class="cms">Сайт работает на <a href="http://kopolocms.ru">KopoloCMS</a></div></div></div></body></html>