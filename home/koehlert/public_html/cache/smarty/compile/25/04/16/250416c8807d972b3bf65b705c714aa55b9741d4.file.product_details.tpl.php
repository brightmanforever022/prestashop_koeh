<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:27:49
         compiled from "/home/koehlert/public_html/modules/sameproductvariant/product_details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3232409315d5960654be2e3-49765906%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '250416c8807d972b3bf65b705c714aa55b9741d4' => 
    array (
      0 => '/home/koehlert/public_html/modules/sameproductvariant/product_details.tpl',
      1 => 1449475136,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3232409315d5960654be2e3-49765906',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'productVariants' => 0,
    'productVariant' => 0,
    'currentProductId' => 0,
    'link' => 0,
    'preselectedSizeAdd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5960654de528_76260323',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5960654de528_76260323')) {function content_5d5960654de528_76260323($_smarty_tpl) {?>    <h3 class="spvTitle"><?php echo smartyTranslate(array('s'=>'Farbe','mod'=>'sameproductvariant'),$_smarty_tpl);?>
</h3>
    <ul class="productDetailVariantsList">
      <?php  $_smarty_tpl->tpl_vars['productVariant'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['productVariant']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['productVariants']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['productVariant']->key => $_smarty_tpl->tpl_vars['productVariant']->value) {
$_smarty_tpl->tpl_vars['productVariant']->_loop = true;
?>
      <li <?php if ($_smarty_tpl->tpl_vars['productVariant']->value['product_id']==$_smarty_tpl->tpl_vars['currentProductId']->value) {?>class="currentProduct"<?php }?>>
	<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['productVariant']->value['product_id'],$_smarty_tpl->tpl_vars['productVariant']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productVariant']->value['category_link']);?>
<?php echo $_smarty_tpl->tpl_vars['preselectedSizeAdd']->value;?>
">
	<img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['productVariant']->value['link_rewrite'],$_smarty_tpl->tpl_vars['productVariant']->value['id_image'],'cart_default');?>
"   alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productVariant']->value['name']);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productVariant']->value['name']);?>
" />
	</a>
      </li>
      <?php } ?>
    </ul>
    <br/>
<?php }} ?>
