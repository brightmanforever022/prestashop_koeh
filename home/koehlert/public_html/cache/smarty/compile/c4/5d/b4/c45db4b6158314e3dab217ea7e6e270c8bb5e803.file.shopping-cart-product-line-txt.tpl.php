<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 23:30:02
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/mail_template/shopping-cart-product-line-txt.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20758346805d59c35a6053f0-01321595%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c45db4b6158314e3dab217ea7e6e270c8bb5e803' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/mail_template/shopping-cart-product-line-txt.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20758346805d59c35a6053f0-01321595',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product' => 0,
    'priceDisplay' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59c35a61ba75_02094273',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59c35a61ba75_02094273')) {function content_5d59c35a61ba75_02094273($_smarty_tpl) {?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php if (isset($_smarty_tpl->tpl_vars['product']->value['attributes'])&&$_smarty_tpl->tpl_vars['product']->value['attributes']) {?> - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['attributes'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>  <?php if (!empty($_smarty_tpl->tpl_vars['product']->value['gift'])) {?><?php echo smartyTranslate(array('s'=>'Gift!','mod'=>'tacartreminder'),$_smarty_tpl);?>
<?php } else { ?><?php if (!$_smarty_tpl->tpl_vars['priceDisplay']->value) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price_wt_dp'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php } else { ?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price_dp'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?><?php }?>						
						<?php }} ?>
