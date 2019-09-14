<?php /* Smarty version Smarty-3.1.19, created on 2019-08-28 21:58:02
         compiled from "/home/koehlert/public_html/modules/khlphotogallery/views/templates/admin/gallery_images.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12703879495d66dcca89cc09-67319937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '93feadf536ae6c5f5b75d4eb802cec2993f7f213' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlphotogallery/views/templates/admin/gallery_images.tpl',
      1 => 1564690170,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12703879495d66dcca89cc09-67319937',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gallery_images' => 0,
    'images_base_url' => 0,
    'gallery_image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d66dcca8a69f9_28122305',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d66dcca8a69f9_28122305')) {function content_5d66dcca8a69f9_28122305($_smarty_tpl) {?><ul style="list-style-type:none; margin:0;">
<?php  $_smarty_tpl->tpl_vars['gallery_image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['gallery_image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gallery_images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['gallery_image']->key => $_smarty_tpl->tpl_vars['gallery_image']->value) {
$_smarty_tpl->tpl_vars['gallery_image']->_loop = true;
?>
<li style="width:207px; height:207px;float:left; margin: 3px; border: 1px solid gray; text-align: center; padding: 3px;">
<img src="<?php echo $_smarty_tpl->tpl_vars['images_base_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['gallery_image']->value['filename'];?>
" style="max-height: 200px; max-width: 200px;" >
</li>
<?php } ?>
</ul><?php }} ?>
