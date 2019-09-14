<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_new_product.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20102663645d5ced926b0fb6-34890953%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc1a42dd1ae362557dd1dd53494ce56d857ae5e6' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_new_product.tpl',
      1 => 1509705939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20102663645d5ced926b0fb6-34890953',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'currency' => 0,
    'order' => 0,
    'carrier' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced926ed7a7_43452734',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced926ed7a7_43452734')) {function content_5d5ced926ed7a7_43452734($_smarty_tpl) {?>
<div id="new_product" style="display:none;">
	<div id="new_product_wrapper" class="panel">
		<input type="hidden" id="add_product_product_id" name="add_product[product_id]" value="0" />
		<input type="hidden" id="add_product_product_tax_rate" name="add_product_product_tax_rate" value="0" />
		<input type="hidden" id="add_product_name_nc" />
		<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Product:','mod'=>'orderedit'),$_smarty_tpl);?>
</div>
		<input type="text" id="add_product_product_name" value="" size="42" />
		<div id="add_product_product_attribute_area" style="margin-top: 5px;display: none;">
			<label><?php echo smartyTranslate(array('s'=>'Combinations:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
			<table width="100%" cellpadding="0" cellspacing="0" class="table" id="new_product_combinations_table">
				<thead>
					<th></th>
					<th><?php echo smartyTranslate(array('s'=>'Combination','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Quantity in stock','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Price (tax excl.)','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Price (tax incl.)','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<div id="add_product_product_warehouse_area" style="margin-top: 5px; display: none;">
            <label><?php echo smartyTranslate(array('s'=>'Warehouse:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
			<select  id="add_product_warehouse" name="add_product_warehouse">
			</select>
		</div>
		<div id="add_product_price_block" class="show_on_product_select" style="margin-top: 5px; display: none;">
            <label><?php echo smartyTranslate(array('s'=>'Price:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
			<span class="form-inline">
				<?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><input class="fixed-width-xl" type="text" name="add_product[product_price_tax_excl]" id="add_product_product_price_tax_excl" value="" size="4" disabled="disabled" /> <?php if (!($_smarty_tpl->tpl_vars['currency']->value->sign%2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?> <?php echo smartyTranslate(array('s'=>'tax excl.','mod'=>'orderedit'),$_smarty_tpl);?>

			</span>
			<span class="form-inline">
			<?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><input class="fixed-width-xl" type="text" name="add_product[product_price_tax_incl]" id="add_product_product_price_tax_incl" value="" size="4" disabled="disabled" /> <?php if (!($_smarty_tpl->tpl_vars['currency']->value->sign%2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?> <?php echo smartyTranslate(array('s'=>'tax incl.','mod'=>'orderedit'),$_smarty_tpl);?>

			</span>
		</div>
		<div id="product_quantity_block" class="productQuantity show_on_product_select" style="margin-top: 5px; display: none;">
            <label><?php echo smartyTranslate(array('s'=>'Quantity:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
            <span class="form-inline">
			    <input class="fixed-width-xl" type="text" name="add_product[product_quantity]" id="add_product_product_quantity" value="1" size="3" disabled="disabled" />
            </span>
		</div>
		<?php if (($_smarty_tpl->tpl_vars['order']->value->hasBeenPaid())) {?>
		<div style="display:none;" class="productQuantity">&nbsp;</div>
		<?php }?>
		<?php if (($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered())) {?>
		<div style="display:none;" class="productQuantity">&nbsp;</div>
		<?php }?>
		<div id="add_product_stock_wrapper" class="show_on_product_select" style="margin-top: 5px; display: none;">
            <label><?php echo smartyTranslate(array('s'=>'Amount in stock:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
			<div class="productQuantity" id="add_product_product_stock">0</div>
		</div>
		<div id="add_product_product_total_wrapper" class="show_on_product_select" style="margin-top: 5px; display: none;">
            <label><?php echo smartyTranslate(array('s'=>'Final retail price:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
			<div id="add_product_product_total"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice(0,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</div>
		</div>
		<div id="addProductWrapper" class="show_on_product_select" style="margin-top: 5px; display: none;">
			<input type="button" class="btn btn-success" id="submitAddProduct" value="<?php echo smartyTranslate(array('s'=>'Add product','mod'=>'orderedit'),$_smarty_tpl);?>
" disabled="disabled" />

            <input type="button" class="btn btn-default" id="cancelAddProduct" value="<?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'orderedit'),$_smarty_tpl);?>
" disabled="disabled" />
		</div>
	</div>
	<div id="new_invoice" style="display:none;background-color:#e9f1f6;">
        <label><?php echo smartyTranslate(array('s'=>'New invoice information','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
		<label><?php echo smartyTranslate(array('s'=>'Carrier:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
		<div class="margin-form">
			<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value->name, ENT_QUOTES, 'UTF-8', true);?>

		</div>
		<div class="margin-form">
			<input type="checkbox" name="add_invoice[free_shipping]" value="1" />
			<label class="t"><?php echo smartyTranslate(array('s'=>'Free shipping','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
			<p><?php echo smartyTranslate(array('s'=>'If you don\'t select "Free shipping," the normal shipping cost will be applied','mod'=>'orderedit'),$_smarty_tpl);?>
</p>
		</div>
	</div>
</div><?php }} ?>
