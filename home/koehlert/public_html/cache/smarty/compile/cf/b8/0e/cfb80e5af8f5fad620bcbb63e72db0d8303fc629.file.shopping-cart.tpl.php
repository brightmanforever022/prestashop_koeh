<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 23:30:02
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/mail_template/shopping-cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9814012875d59c35a4d47c7-76818925%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfb80e5af8f5fad620bcbb63e72db0d8303fc629' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/mail_template/shopping-cart.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9814012875d59c35a4d47c7-76818925',
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
    'customization' => 0,
    'type' => 0,
    'CUSTOMIZE_FILE' => 0,
    'custom_data' => 0,
    'pic_dir' => 0,
    'picture' => 0,
    'CUSTOMIZE_TEXTFIELD' => 0,
    'textField' => 0,
    'quantityDisplayed' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59c35a54cc52_30390439',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59c35a54cc52_30390439')) {function content_5d59c35a54cc52_30390439($_smarty_tpl) {?>
<table class="table table-recap" bgcolor="#ffffff" style="width:100%;border-collapse:collapse"><!-- Title -->
<tbody>
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
	
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_mt_path']->value)."/shopping-cart-product-line.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id_lang'=>((string)$_smarty_tpl->tpl_vars['id_lang']->value)), 0);?>

	
	<?php if (isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value])) {?>
		<?php  $_smarty_tpl->tpl_vars['customization'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customization']->_loop = false;
 $_smarty_tpl->tpl_vars['id_customization'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value][$_smarty_tpl->tpl_vars['product']->value['id_address_delivery']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['customization']->key => $_smarty_tpl->tpl_vars['customization']->value) {
$_smarty_tpl->tpl_vars['customization']->_loop = true;
 $_smarty_tpl->tpl_vars['id_customization']->value = $_smarty_tpl->tpl_vars['customization']->key;
?>
			<tr>
				<td></td>
				<td colspan="3">
					<?php  $_smarty_tpl->tpl_vars['custom_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['custom_data']->_loop = false;
 $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['customization']->value['datas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['custom_data']->key => $_smarty_tpl->tpl_vars['custom_data']->value) {
$_smarty_tpl->tpl_vars['custom_data']->_loop = true;
 $_smarty_tpl->tpl_vars['type']->value = $_smarty_tpl->tpl_vars['custom_data']->key;
?>
						<?php if ($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->tpl_vars['CUSTOMIZE_FILE']->value) {?>
								<ul>
									<?php  $_smarty_tpl->tpl_vars['picture'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['picture']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['custom_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['picture']->key => $_smarty_tpl->tpl_vars['picture']->value) {
$_smarty_tpl->tpl_vars['picture']->_loop = true;
?>
										<li><img src="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['pic_dir']->value);?>
<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['picture']->value['value']);?>
_small" alt="" width="50px" height="auto"/></li>
									<?php } ?>
								</ul>
						<?php } elseif ($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->tpl_vars['CUSTOMIZE_TEXTFIELD']->value) {?>
							<ul>
								<?php  $_smarty_tpl->tpl_vars['textField'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['textField']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['custom_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['textField']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['textField']->key => $_smarty_tpl->tpl_vars['textField']->value) {
$_smarty_tpl->tpl_vars['textField']->_loop = true;
 $_smarty_tpl->tpl_vars['textField']->index++;
?>
									<li>
										<?php if ($_smarty_tpl->tpl_vars['textField']->value['name']) {?>
											<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['textField']->value['name'], ENT_QUOTES, 'UTF-8', true);?>

										<?php } else { ?>
											<?php echo smartyTranslate(array('s'=>'Text #','mod'=>'tacartreminder'),$_smarty_tpl);?>
<?php echo $_smarty_tpl->tpl_vars['textField']->index+htmlspecialchars(1, ENT_QUOTES, 'UTF-8', true);?>

										<?php }?>
										: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['textField']->value['value'], ENT_QUOTES, 'UTF-8', true);?>

									</li>
								<?php } ?>
							</ul>
						<?php }?>
					<?php } ?>
				</td>
				<td>
					<?php if ($_smarty_tpl->tpl_vars['quantityDisplayed']->value==0&&isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value])) {?>
						<?php echo intval(count($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value]));?>

					<?php } else { ?>
						<?php echo intval($_smarty_tpl->tpl_vars['product']->value['cart_quantity'])-intval($_smarty_tpl->tpl_vars['quantityDisplayed']->value);?>

					<?php }?>
				</td>
			</tr>
			<?php if (isset($_smarty_tpl->tpl_vars['quantityDisplayed'])) {$_smarty_tpl->tpl_vars['quantityDisplayed'] = clone $_smarty_tpl->tpl_vars['quantityDisplayed'];
$_smarty_tpl->tpl_vars['quantityDisplayed']->value = $_smarty_tpl->tpl_vars['quantityDisplayed']->value+$_smarty_tpl->tpl_vars['customization']->value['quantity']; $_smarty_tpl->tpl_vars['quantityDisplayed']->nocache = null; $_smarty_tpl->tpl_vars['quantityDisplayed']->scope = 0;
} else $_smarty_tpl->tpl_vars['quantityDisplayed'] = new Smarty_variable($_smarty_tpl->tpl_vars['quantityDisplayed']->value+$_smarty_tpl->tpl_vars['customization']->value['quantity'], null, 0);?>
		<?php } ?>
		
		<?php if ($_smarty_tpl->tpl_vars['product']->value['quantity']-$_smarty_tpl->tpl_vars['quantityDisplayed']->value>0) {?>
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_mt_path']->value)."/shopping-cart-product-line.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<?php }?>
	<?php }?>
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
					
					<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_mt_path']->value)."/shopping-cart-product-line.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('productLast'=>$_smarty_tpl->tpl_vars['product']->last,'productFirst'=>$_smarty_tpl->tpl_vars['product']->first), 0);?>

<?php } ?>
</tbody>
</table><?php }} ?>
