<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:29:36
         compiled from "/home/koehlert/public_html/modules/sameproductvariant/category_product.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2865983715d5960d08a9e21-50577716%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '01707994086123e8ed17afe7c53eb6b1dfe98c97' => 
    array (
      0 => '/home/koehlert/public_html/modules/sameproductvariant/category_product.tpl',
      1 => 1447303260,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2865983715d5960d08a9e21-50577716',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'productVariants' => 0,
    'productVariant' => 0,
    'link' => 0,
    'preselectedSizeAdd' => 0,
    'variantImageSize' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5960d08ca241_60377098',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5960d08ca241_60377098')) {function content_5d5960d08ca241_60377098($_smarty_tpl) {?><div class="productVariants">
	     <ul class="productVariantsList">
	     <?php  $_smarty_tpl->tpl_vars['productVariant'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['productVariant']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['productVariants']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['productVariant']->key => $_smarty_tpl->tpl_vars['productVariant']->value) {
$_smarty_tpl->tpl_vars['productVariant']->_loop = true;
?>
	      <li bigImage="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['productVariant']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productVariant']->value['id_image'],'home_default');?>
" id="variant_<?php echo $_smarty_tpl->tpl_vars['productVariant']->value['product_id'];?>
">
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['productVariant']->value['product_id'],$_smarty_tpl->tpl_vars['productVariant']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productVariant']->value['category_link']);?>
<?php echo $_smarty_tpl->tpl_vars['preselectedSizeAdd']->value;?>
">
		  <img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['productVariant']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productVariant']->value['id_image'],'pr_details_thumb');?>
"  height="<?php echo $_smarty_tpl->tpl_vars['variantImageSize']->value['height'];?>
" width="<?php echo $_smarty_tpl->tpl_vars['variantImageSize']->value['width'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productVariant']->value['name']);?>
" />
		</a>
	      </li>
	     <?php } ?>
	     </ul>
	  </div>
	  <div class="spvCatOtherBigImage"><img class="img-responsive" itemprop="image" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productVariant']->value['name']);?>
" src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['productVariants']->value[0]['link_rewrite'],$_smarty_tpl->tpl_vars['productVariants']->value[0]['id_image'],'home_default');?>
"></div><?php }} ?>
