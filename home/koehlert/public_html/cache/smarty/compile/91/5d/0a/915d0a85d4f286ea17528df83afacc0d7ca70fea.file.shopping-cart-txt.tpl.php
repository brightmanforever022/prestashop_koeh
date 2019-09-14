<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 23:30:02
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/mail_template/shopping-cart-txt.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6895112055d59c35a5d8861-38093133%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '915d0a85d4f286ea17528df83afacc0d7ca70fea' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/mail_template/shopping-cart-txt.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6895112055d59c35a5d8861-38093133',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'product' => 0,
    'productId' => 0,
    'productAttributeId' => 0,
    'customizedDatas' => 0,
    'gift_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59c35a602069_40865044',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59c35a602069_40865044')) {function content_5d59c35a602069_40865044($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['have_non_virtual_products'])) {$_smarty_tpl->tpl_vars['have_non_virtual_products'] = clone $_smarty_tpl->tpl_vars['have_non_virtual_products'];
$_smarty_tpl->tpl_vars['have_non_virtual_products']->value = false; $_smarty_tpl->tpl_vars['have_non_virtual_products']->nocache = null; $_smarty_tpl->tpl_vars['have_non_virtual_products']->scope = 0;
} else $_smarty_tpl->tpl_vars['have_non_virtual_products'] = new Smarty_variable(false, null, 0);?>
<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
 $_smarty_tpl->tpl_vars['product']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->index++;
 $_smarty_tpl->tpl_vars['product']->first = $_smarty_tpl->tpl_vars['product']->index === 0;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
?>
	<?php if ($_smarty_tpl->tpl_vars['product']->value['is_virtual']==0) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['have_non_virtual_products'])) {$_smarty_tpl->tpl_vars['have_non_virtual_products'] = clone $_smarty_tpl->tpl_vars['have_non_virtual_products'];
$_smarty_tpl->tpl_vars['have_non_virtual_products']->value = true; $_smarty_tpl->tpl_vars['have_non_virtual_products']->nocache = null; $_smarty_tpl->tpl_vars['have_non_virtual_products']->scope = 0;
} else $_smarty_tpl->tpl_vars['have_non_virtual_products'] = new Smarty_variable(true, null, 0);?>						
	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['productId'])) {$_smarty_tpl->tpl_vars['productId'] = clone $_smarty_tpl->tpl_vars['productId'];
$_smarty_tpl->tpl_vars['productId']->value = $_smarty_tpl->tpl_vars['product']->value['id_product']; $_smarty_tpl->tpl_vars['productId']->nocache = null; $_smarty_tpl->tpl_vars['productId']->scope = 0;
} else $_smarty_tpl->tpl_vars['productId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product'], null, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['productAttributeId'])) {$_smarty_tpl->tpl_vars['productAttributeId'] = clone $_smarty_tpl->tpl_vars['productAttributeId'];
$_smarty_tpl->tpl_vars['productAttributeId']->value = $_smarty_tpl->tpl_vars['product']->value['id_product_attribute']; $_smarty_tpl->tpl_vars['productAttributeId']->nocache = null; $_smarty_tpl->tpl_vars['productAttributeId']->scope = 0;
} else $_smarty_tpl->tpl_vars['productAttributeId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'], null, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['quantityDisplayed'])) {$_smarty_tpl->tpl_vars['quantityDisplayed'] = clone $_smarty_tpl->tpl_vars['quantityDisplayed'];
$_smarty_tpl->tpl_vars['quantityDisplayed']->value = 0; $_smarty_tpl->tpl_vars['quantityDisplayed']->nocache = null; $_smarty_tpl->tpl_vars['quantityDisplayed']->scope = 0;
} else $_smarty_tpl->tpl_vars['quantityDisplayed'] = new Smarty_variable(0, null, 0);?>
	<?php if (isset($_smarty_tpl->tpl_vars['ignoreProductLast'])) {$_smarty_tpl->tpl_vars['ignoreProductLast'] = clone $_smarty_tpl->tpl_vars['ignoreProductLast'];
$_smarty_tpl->tpl_vars['ignoreProductLast']->value = isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value])||count($_smarty_tpl->tpl_vars['gift_products']->value); $_smarty_tpl->tpl_vars['ignoreProductLast']->nocache = null; $_smarty_tpl->tpl_vars['ignoreProductLast']->scope = 0;
} else $_smarty_tpl->tpl_vars['ignoreProductLast'] = new Smarty_variable(isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value])||count($_smarty_tpl->tpl_vars['gift_products']->value), null, 0);?>
	
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_mt_path']->value)."/shopping-cart-product-line-txt.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	
<?php } ?>
<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gift_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
 $_smarty_tpl->tpl_vars['product']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->index++;
 $_smarty_tpl->tpl_vars['product']->first = $_smarty_tpl->tpl_vars['product']->index === 0;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
?>
					<?php if (isset($_smarty_tpl->tpl_vars['productId'])) {$_smarty_tpl->tpl_vars['productId'] = clone $_smarty_tpl->tpl_vars['productId'];
$_smarty_tpl->tpl_vars['productId']->value = $_smarty_tpl->tpl_vars['product']->value['id_product']; $_smarty_tpl->tpl_vars['productId']->nocache = null; $_smarty_tpl->tpl_vars['productId']->scope = 0;
} else $_smarty_tpl->tpl_vars['productId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product'], null, 0);?>
					<?php if (isset($_smarty_tpl->tpl_vars['productAttributeId'])) {$_smarty_tpl->tpl_vars['productAttributeId'] = clone $_smarty_tpl->tpl_vars['productAttributeId'];
$_smarty_tpl->tpl_vars['productAttributeId']->value = $_smarty_tpl->tpl_vars['product']->value['id_product_attribute']; $_smarty_tpl->tpl_vars['productAttributeId']->nocache = null; $_smarty_tpl->tpl_vars['productAttributeId']->scope = 0;
} else $_smarty_tpl->tpl_vars['productAttributeId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'], null, 0);?>
					<?php if (isset($_smarty_tpl->tpl_vars['quantityDisplayed'])) {$_smarty_tpl->tpl_vars['quantityDisplayed'] = clone $_smarty_tpl->tpl_vars['quantityDisplayed'];
$_smarty_tpl->tpl_vars['quantityDisplayed']->value = 0; $_smarty_tpl->tpl_vars['quantityDisplayed']->nocache = null; $_smarty_tpl->tpl_vars['quantityDisplayed']->scope = 0;
} else $_smarty_tpl->tpl_vars['quantityDisplayed'] = new Smarty_variable(0, null, 0);?>
					<?php if (isset($_smarty_tpl->tpl_vars['ignoreProductLast'])) {$_smarty_tpl->tpl_vars['ignoreProductLast'] = clone $_smarty_tpl->tpl_vars['ignoreProductLast'];
$_smarty_tpl->tpl_vars['ignoreProductLast']->value = isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value]); $_smarty_tpl->tpl_vars['ignoreProductLast']->nocache = null; $_smarty_tpl->tpl_vars['ignoreProductLast']->scope = 0;
} else $_smarty_tpl->tpl_vars['ignoreProductLast'] = new Smarty_variable(isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value]), null, 0);?>
					<?php if (isset($_smarty_tpl->tpl_vars['cannotModify'])) {$_smarty_tpl->tpl_vars['cannotModify'] = clone $_smarty_tpl->tpl_vars['cannotModify'];
$_smarty_tpl->tpl_vars['cannotModify']->value = 1; $_smarty_tpl->tpl_vars['cannotModify']->nocache = null; $_smarty_tpl->tpl_vars['cannotModify']->scope = 0;
} else $_smarty_tpl->tpl_vars['cannotModify'] = new Smarty_variable(1, null, 0);?>
					
					<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_mt_path']->value)."/shopping-cart-product-line-txt.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('productLast'=>$_smarty_tpl->tpl_vars['product']->last,'productFirst'=>$_smarty_tpl->tpl_vars['product']->first), 0);?>

<?php } ?>
<?php }} ?>
