<?php /* Smarty version Smarty-3.0.6, created on 2013-06-23 07:28:59
         compiled from "W:/home/kopolocms/www/Themes/Default/templates\gallery/images.tpl" */ ?>
<?php /*%%SmartyHeaderCode:294751c66b7b5ff096-17113003%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05b2a20468e07e164a19e2642a3e2e0957cf7f92' => 
    array (
      0 => 'W:/home/kopolocms/www/Themes/Default/templates\\gallery/images.tpl',
      1 => 1318141366,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '294751c66b7b5ff096-17113003',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include 'W:/home/kopolocms/www/Lib/Smarty/plugins\modifier.replace.php';
?><?php if ($_smarty_tpl->getVariable('images')->value){?><link href="/Themes/default/css/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css" /><script src="/Themes/default/js/jquery.fancybox-1.3.1.js" type="text/javascript" language="javascript"></script><script type="text/javascript">
        $(document).ready( function(){
            $(".photo-gallery a[rel=fb]").fancybox({
                'titleShow'    : true,
                'transitionIn' : 'none',
                'transitionOut': 'none',
                'titlePosition': 'over'
            });
        });
    </script><div class="photo-gallery"><?php  $_smarty_tpl->tpl_vars['pic'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('images')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pic']->key => $_smarty_tpl->tpl_vars['pic']->value){
?><div class="image"><a href="<?php echo Kopolo_Template_Plugins::resize(array('file'=>$_smarty_tpl->tpl_vars['pic']->value['img_picture'],'width'=>1200,'height'=>1200,'path_only'=>1),$_smarty_tpl);?>
" rel="fb"<?php if ($_smarty_tpl->tpl_vars['pic']->value['img_name']){?> title="<?php echo smarty_modifier_replace(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['pic']->value['img_name']),'"',"'");?>
"<?php }?>><?php echo Kopolo_Template_Plugins::resize(array('file'=>$_smarty_tpl->tpl_vars['pic']->value['img_picture'],'width'=>150,'height'=>150,'crop'=>1),$_smarty_tpl);?>
</a><span><?php echo $_smarty_tpl->tpl_vars['pic']->value['img_name'];?>
</span></div><?php }} ?></div><?php }?>