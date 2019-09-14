<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_product_line.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9731514915d5ced92943314-75153929%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef49fbc46ceabfc12df0731bd8a0a21bc7812c1b' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_product_line.tpl',
      1 => 1554322684,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9731514915d5ced92943314-75153929',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
    'product' => 0,
    'index' => 0,
    'unsaved' => 0,
    'invoices_collection' => 0,
    'can_edit' => 0,
    'product_price' => 0,
    'currency' => 0,
    'taxes' => 0,
    'tax' => 0,
    'productQuantity' => 0,
    'invoice' => 0,
    'current_id_lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced92b224c6_20367681',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced92b224c6_20367681')) {function content_5d5ced92b224c6_20367681($_smarty_tpl) {?>


<?php if (($_smarty_tpl->tpl_vars['order']->value->getTaxCalculationMethod()==@constant('PS_TAX_EXC'))) {?>
	<?php if (isset($_smarty_tpl->tpl_vars['product_price'])) {$_smarty_tpl->tpl_vars['product_price'] = clone $_smarty_tpl->tpl_vars['product_price'];
$_smarty_tpl->tpl_vars['product_price']->value = ($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl']+$_smarty_tpl->tpl_vars['product']->value['ecotax']); $_smarty_tpl->tpl_vars['product_price']->nocache = null; $_smarty_tpl->tpl_vars['product_price']->scope = 0;
} else $_smarty_tpl->tpl_vars['product_price'] = new Smarty_variable(($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl']+$_smarty_tpl->tpl_vars['product']->value['ecotax']), null, 0);?>
<?php } else { ?>
	<?php if (isset($_smarty_tpl->tpl_vars['product_price'])) {$_smarty_tpl->tpl_vars['product_price'] = clone $_smarty_tpl->tpl_vars['product_price'];
$_smarty_tpl->tpl_vars['product_price']->value = $_smarty_tpl->tpl_vars['product']->value['unit_price_tax_incl']; $_smarty_tpl->tpl_vars['product_price']->nocache = null; $_smarty_tpl->tpl_vars['product_price']->scope = 0;
} else $_smarty_tpl->tpl_vars['product_price'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_incl'], null, 0);?>
<?php }?>
<?php if (($_smarty_tpl->tpl_vars['product']->value['product_quantity']>$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal'])) {?>

<tr <?php if (isset($_smarty_tpl->tpl_vars['product']->value['image'])&&$_smarty_tpl->tpl_vars['product']->value['image']->id&&isset($_smarty_tpl->tpl_vars['product']->value['image_size'])) {?> height="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['image_size'][1], ENT_QUOTES, 'UTF-8', true)+7;?>
"<?php }?> id="line_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['index']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="product_line<?php if (isset($_smarty_tpl->tpl_vars['unsaved']->value)&&$_smarty_tpl->tpl_vars['unsaved']->value) {?> unsaved<?php }?>" data-pr="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_id'], ENT_QUOTES, 'UTF-8', true);?>
-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_attribute_id'], ENT_QUOTES, 'UTF-8', true);?>
">
	<td align="center"><?php if (isset($_smarty_tpl->tpl_vars['product']->value['image'])&&$_smarty_tpl->tpl_vars['product']->value['image']->id) {?><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['product']->value['image_tag']);?>
<?php }?></td>
	<td>
		<input type="hidden" name="taxRulesGroupId" rel="taxRulesGroupId" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_tax_rules_group'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<input type="hidden" name="productId" rel="productId" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_id'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<input type="hidden" name="productAttributeId" rel="productAttributeId" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_attribute_id'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<input type="hidden" name="productWarehouseId" rel="productWarehouseId" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_warehouse'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<input type="hidden" name="isDeleted" class="isDeleted" rel="isDeleted" value="0" />
		<input type="hidden" name="productIndex" class="productIndex" rel="productIndex" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['index']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php if (isset($_smarty_tpl->tpl_vars['product']->value['invoice_selected'])&&!sizeof($_smarty_tpl->tpl_vars['invoices_collection']->value)) {?>
		<input type="hidden" name="product_invoice" rel="editProductInvoice" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['invoice_selected'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<?php }?>
		<div class="editable">
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="customVal" style="display:none;">
				<span></span>
			</p>
			<?php }?>
			<p class="displayVal">
				<span class="productName"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_name'], ENT_QUOTES, 'UTF-8', true);?>
</span>
			</p>
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="realVal" style="display:none;">
				<span class="product_name_edit">
					<input type="text" name="product_name" class="edit_product_name" rel="productNameEdit" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_name'], ENT_QUOTES, 'UTF-8', true);?>
" />
				</span>
			</p>
			<?php }?>
		</div>
	</td>
	<td>
		<div class="editable">
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="customVal" style="display:none;">
				<span></span>
			</p>
			<?php }?>
			<p class="displayVal">
				<span class="productRef"><?php if ($_smarty_tpl->tpl_vars['product']->value['product_reference']=='') {?>--<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_reference'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></span>
			</p>
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="realVal" style="display:none;">
				<span class="product_ref_edit">
					<input type="text" name="product_ref" class="edit_ref_name" rel="productReferenceEdit" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_reference'], ENT_QUOTES, 'UTF-8', true);?>
" />
				</span>
			</p>
			<?php }?>
		</div>
	</td>
	<td>
		<div class="editable">
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="customVal" style="display:none;">
				<span></span>
			</p>
			<?php }?>
			<p class="displayVal">
				<span class="product_sup_ref_show"><?php if ($_smarty_tpl->tpl_vars['product']->value['product_supplier_reference']=='') {?>--<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_supplier_reference'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></span>
			</p>
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="realVal" style="display:none;">
				<span class="product_sup_ref_edit">
					<input type="text" name="product_sup_ref" class="edit_sup_ref_name" rel="productSupplierReferenceEdit" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_supplier_reference'], ENT_QUOTES, 'UTF-8', true);?>
" />
				</span>
			</p>
			<?php }?>
		</div>
	</td>
	<td>
		<div class="editable">
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="customVal" style="display:none;">
				<span></span>
			</p>
			<?php }?>
			<p class="displayVal">
				<span class="productWeight"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_weight'], ENT_QUOTES, 'UTF-8', true);?>
</span>
			</p>
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="realVal" style="display:none;">
				<span class="product_weight_edit">
					<input type="text" name="product_weight" class="edit_product_weight" rel="productWeightEdit" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_weight'], ENT_QUOTES, 'UTF-8', true);?>
" />
				</span>
			</p>
			<?php }?>
		</div>
	</td>
	<td align="center">
		<div class="editable">
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="customVal" style="display:none;">
				<span></span>
			</p>
			<?php }?>
			<p class="displayVal">
				<span class="product_reduction_per_show"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['reduction_percent'], ENT_QUOTES, 'UTF-8', true);?>
</span>
			</p>
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="realVal" style="display:none;">
				<span class="realVal product__reduction_per_edit" style="display:none;">
					<input type="text" name="product_reduction_per" class="edit_product_reduction_per" rel="productReductionPerEdit" data-opp="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl'],6), ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars(htmlentities($_smarty_tpl->tpl_vars['product']->value['reduction_percent']), ENT_QUOTES, 'UTF-8', true);?>
" size="2" />
				</span>
			</p>
			<?php }?>
		</div>
	</td>
	<td align="center">
		<div class="editable">
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="customVal" style="display:none;">
				<span></span>
			</p>
			<?php }?>
			<p class="displayVal">
				<span class="displayVal product_price_show"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['product_price']->value,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
			</p>
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="realVal" style="display:none;">
				<span class="product_price_edit">
					<input type="hidden" name="product_id_order_detail" class="edit_product_id_order_detail" rel="idOrderDetail" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
" />
					<?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
					<input type="text" name="product_price_tax_excl" class="edit_product_price_tax_excl edit_product_price" rel="productPriceEdit" value="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl'],6), ENT_QUOTES, 'UTF-8', true);?>
" size="5" /> <?php if (!($_smarty_tpl->tpl_vars['currency']->value->sign%2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?> <?php echo smartyTranslate(array('s'=>'tax excl.','mod'=>'orderedit'),$_smarty_tpl);?>
<br />
					<?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
					<input type="text" name="product_price_tax_incl" class="edit_product_price_tax_incl edit_product_price" rel="productPriceWtEdit" pwt="<?php echo htmlspecialchars(Product::getPriceStatic($_smarty_tpl->tpl_vars['product']->value['product_id'],true,$_smarty_tpl->tpl_vars['product']->value['product_attribute_id']), ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_incl'],2), ENT_QUOTES, 'UTF-8', true);?>
" size="5" /> <?php if (!($_smarty_tpl->tpl_vars['currency']->value->sign%2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?> <?php echo smartyTranslate(array('s'=>'tax incl.','mod'=>'orderedit'),$_smarty_tpl);?>

				</span>
			</p>
			<?php }?>
		</div>
	</td>
	<td align="center">
		<div class="editable">
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="customVal" style="display:none;">
				<span></span>
			</p>
			<?php }?>
			<p class="displayVal">
				<span class="product_tax_rate_show"><?php echo $_smarty_tpl->tpl_vars['product']->value['tax_rule_group_name'];?>
</span>
			</p>
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="realVal" style="display:none;">
			
				<span class="product_tax_rate_edit">
					
                    <select name="product_tax_rate" class="edit_product_tax_rate edit_product_price" rel="productTaxEdit">
                        <option value="0:0">0 %</option>
                        <?php  $_smarty_tpl->tpl_vars['tax'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tax']->_loop = false;
 $_smarty_tpl->tpl_vars['tax_key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['taxes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tax']->key => $_smarty_tpl->tpl_vars['tax']->value) {
$_smarty_tpl->tpl_vars['tax']->_loop = true;
 $_smarty_tpl->tpl_vars['tax_key']->value = $_smarty_tpl->tpl_vars['tax']->key;
?>
                            <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tax']->value['id_tax_rules_group'], ENT_QUOTES, 'UTF-8', true);?>
:19"<?php if ($_smarty_tpl->tpl_vars['tax']->value['id_tax_rules_group']==$_smarty_tpl->tpl_vars['product']->value['id_tax_rules_group']) {?>selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tax']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                        <?php } ?>
                    </select>
				</span>
			</p>
			<?php }?>
		</div>
	</td>
	<td align="center" class="productQuantity">
		<div class="editable">
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="customVal" style="display:none;">
				<span></span>
			</p>
			<?php }?>
			<p class="displayVal">
				<span class="product_quantity_show"><?php if (array_key_exists('customized_product_quantity',$_smarty_tpl->tpl_vars['product']->value)) {?><?php echo htmlspecialchars(((int)$_smarty_tpl->tpl_vars['product']->value['product_quantity']-(int)$_smarty_tpl->tpl_vars['product']->value['customized_product_quantity']), ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo (int)htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_quantity'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></span>
			</p>
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
			<p class="realVal" style="display:none;">
				<span class="realVal product_quantity_edit" style="display:none;">
					<input type="text" name="product_quantity" class="edit_product_quantity" rel="productQtyEdit" value="<?php if (array_key_exists('customized_product_quantity',$_smarty_tpl->tpl_vars['product']->value)) {?><?php echo htmlspecialchars(((int)$_smarty_tpl->tpl_vars['product']->value['product_quantity']-(int)$_smarty_tpl->tpl_vars['product']->value['customized_product_quantity']), ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo (int)htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_quantity'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" size="2"  autocomplete="off" />
				</span>
			</p>
			<?php }?>
		</div>
	</td>
	<td align="center" class="total_product">
		<?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice((Tools::ps_round($_smarty_tpl->tpl_vars['product_price']->value,2)*($_smarty_tpl->tpl_vars['product']->value['product_quantity']-$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal'])),(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

	</td>
	<td colspan="2" style="display: none;" class="add_product_fields">&nbsp;</td>
	<td align="center" class="cancelCheck standard_refund_fields current-edit" style="display:none">
		<input type="hidden" name="totalQtyReturn" id="totalQtyReturn" rel="totalQtyReturn" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_quantity_return'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<input type="hidden" name="totalQty" id="totalQty" rel="totalQty" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_quantity'], ENT_QUOTES, 'UTF-8', true);?>
" />
		<input type="hidden" name="productName" id="productName" rel="productName" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_name'], ENT_QUOTES, 'UTF-8', true);?>
" />
	<?php if (((!$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()||Configuration::get('PS_ORDER_RETURN'))&&(int)($_smarty_tpl->tpl_vars['product']->value['product_quantity_return'])<(int)($_smarty_tpl->tpl_vars['product']->value['product_quantity'])&&isset($_smarty_tpl->tpl_vars['product']->value['product_quantity_in_stock'])&&isset($_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal'])&&isset($_smarty_tpl->tpl_vars['product']->value['product_quantity_reinjected']))) {?>
		<input type="checkbox" rel="id_order_detail" name="id_order_detail[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
]" id="id_order_detail[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
" onchange="setCancelQuantity(this, <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
, <?php echo htmlspecialchars(($_smarty_tpl->tpl_vars['product']->value['product_quantity_in_stock']-$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']-$_smarty_tpl->tpl_vars['product']->value['product_quantity_reinjected']), ENT_QUOTES, 'UTF-8', true);?>
)" <?php if (($_smarty_tpl->tpl_vars['product']->value['product_quantity_return']+$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded']>=$_smarty_tpl->tpl_vars['product']->value['product_quantity'])) {?>disabled="disabled" <?php }?>/>
	<?php } else { ?>
		--
	<?php }?>
	</td>
	<td class="cancelQuantity standard_refund_fields current-edit" style="display:none">
	<?php if (($_smarty_tpl->tpl_vars['product']->value['product_quantity_return']+$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded']>=$_smarty_tpl->tpl_vars['product']->value['product_quantity'])) {?>
		<input type="hidden" rel="cancelQuantity" name="cancelQuantity[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
]" value="0" />
	<?php } elseif ((!$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()||Configuration::get('PS_ORDER_RETURN'))) {?>
		<input type="text" id="cancelQuantity_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
" rel="cancelQuantity" name="cancelQuantity[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
]" size="2" onclick="selectCheckbox(this);" value="" />
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['productQuantity'])) {$_smarty_tpl->tpl_vars['productQuantity'] = clone $_smarty_tpl->tpl_vars['productQuantity'];
$_smarty_tpl->tpl_vars['productQuantity']->value = ($_smarty_tpl->tpl_vars['product']->value['product_quantity']-$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']); $_smarty_tpl->tpl_vars['productQuantity']->nocache = null; $_smarty_tpl->tpl_vars['productQuantity']->scope = 0;
} else $_smarty_tpl->tpl_vars['productQuantity'] = new Smarty_variable(($_smarty_tpl->tpl_vars['product']->value['product_quantity']-$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']), null, 0);?>
	<?php } else { ?>
		<?php if (isset($_smarty_tpl->tpl_vars['productQuantity'])) {$_smarty_tpl->tpl_vars['productQuantity'] = clone $_smarty_tpl->tpl_vars['productQuantity'];
$_smarty_tpl->tpl_vars['productQuantity']->value = $_smarty_tpl->tpl_vars['product']->value['product_quantity']; $_smarty_tpl->tpl_vars['productQuantity']->nocache = null; $_smarty_tpl->tpl_vars['productQuantity']->scope = 0;
} else $_smarty_tpl->tpl_vars['productQuantity'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['product_quantity'], null, 0);?>
	<?php }?>

	<?php if (($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered())) {?>
		<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded'], ENT_QUOTES, 'UTF-8', true);?>
/<?php echo $_smarty_tpl->tpl_vars['productQuantity']->value-htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded'], ENT_QUOTES, 'UTF-8', true);?>

	<?php } elseif (($_smarty_tpl->tpl_vars['order']->value->hasBeenPaid())) {?>
		<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_quantity_return'], ENT_QUOTES, 'UTF-8', true);?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productQuantity']->value, ENT_QUOTES, 'UTF-8', true);?>

	<?php } else { ?>
		0/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productQuantity']->value, ENT_QUOTES, 'UTF-8', true);?>

	<?php }?>
	</td>
	<td class="partial_refund_fields current-edit" style="text-align:left;display:none">
		<div style="width:40%;margin-top:5px;float:left"><?php echo smartyTranslate(array('s'=>'Quantity:','mod'=>'orderedit'),$_smarty_tpl);?>
</div> <div style="width:60%;margin-top:2px;float:left"><input onchange="checkPartialRefundProductQuantity(this)" type="text" size="3" name="partialRefundProductQuantity[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
]" value="0" /> 0/<?php echo $_smarty_tpl->tpl_vars['productQuantity']->value-htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded'], ENT_QUOTES, 'UTF-8', true);?>
</div>
		<div style="width:40%;margin-top:5px;float:left"><?php echo smartyTranslate(array('s'=>'Amount:','mod'=>'orderedit'),$_smarty_tpl);?>
</div> <div style="width:60%;margin-top:2px;float:left"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->prefix, ENT_QUOTES, 'UTF-8', true);?>
<input onchange="checkPartialRefundProductAmount(this)" type="text" size="3" name="partialRefundProduct[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
]" /> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->suffix, ENT_QUOTES, 'UTF-8', true);?>
</div> <?php if (!empty($_smarty_tpl->tpl_vars['product']->value['amount_refund'])&&$_smarty_tpl->tpl_vars['product']->value['amount_refund']>0) {?>(<?php echo smartyTranslate(array('s'=>'%s refund','sprintf'=>$_smarty_tpl->tpl_vars['product']->value['amount_refund'],'mod'=>'orderedit'),$_smarty_tpl);?>
)<?php }?>
		<input type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['quantity_refundable'], ENT_QUOTES, 'UTF-8', true);?>
" rel="quantity_refundable" class="partialRefundProductQuantity" />
		<input type="hidden" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['amount_refundable'], ENT_QUOTES, 'UTF-8', true);?>
" rel="amount_refundable" class="partialRefundProductAmount" />
	</td>
	<td class="product_invoice" colspan="2" style="display: none;text-align:center;">
		<?php if (sizeof($_smarty_tpl->tpl_vars['invoices_collection']->value)) {?>
		<select name="product_invoice" class="edit_product_invoice" rel="editProductInvoice">
			<?php  $_smarty_tpl->tpl_vars['invoice'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invoice']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['invoices_collection']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['invoice']->key => $_smarty_tpl->tpl_vars['invoice']->value) {
$_smarty_tpl->tpl_vars['invoice']->_loop = true;
?>
			<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['invoice']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['invoice']->value->id==$_smarty_tpl->tpl_vars['product']->value['id_order_invoice']) {?>selected="selected"<?php }?>>#<?php echo htmlspecialchars(Configuration::get('PS_INVOICE_PREFIX',$_smarty_tpl->tpl_vars['current_id_lang']->value), ENT_QUOTES, 'UTF-8', true);?>
<?php echo sprintf('%06d',$_smarty_tpl->tpl_vars['invoice']->value->number);?>
</option>
			<?php } ?>
		</select>
		<?php } else { ?>
		&nbsp;
		<?php }?>
	</td>
	<td class="product_action" style="text-align:right">
		<a href="#" class="cancel_product_change_link" style="display: none;"><img src="../img/admin/disabled.gif" alt="<?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'orderedit'),$_smarty_tpl);?>
" /></a>
		<a href="#" class="delete_product_line btn btn-default"><i class="icon-trash"></i> <?php echo smartyTranslate(array('s'=>'Delete','mod'=>'orderedit'),$_smarty_tpl);?>
</a>
	</td>
</tr>
<?php }?>
<?php }} ?>
