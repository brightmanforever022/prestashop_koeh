<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_customized_data.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19678456385d5ced926f4128-15270359%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '02967cb932a6cb6b98cbc6903afdbad61d6c4924' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_customized_data.tpl',
      1 => 1546002164,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19678456385d5ced926f4128-15270359',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product' => 0,
    'order' => 0,
    'index' => 0,
    'invoices_collection' => 0,
    'can_edit' => 0,
    'product_price' => 0,
    'currency' => 0,
    'taxes' => 0,
    'tax' => 0,
    'productQuantity' => 0,
    'invoice' => 0,
    'current_id_lang' => 0,
    'customizationPerAddress' => 0,
    'customization' => 0,
    'type' => 0,
    'datas' => 0,
    'data' => 0,
    'customizationId' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced9293ce06_36282881',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced9293ce06_36282881')) {function content_5d5ced9293ce06_36282881($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['product']->value['customizedDatas']) {?>

<?php if (($_smarty_tpl->tpl_vars['order']->value->getTaxCalculationMethod()==@constant('PS_TAX_EXC'))) {?>
	<?php if (isset($_smarty_tpl->tpl_vars['product_price'])) {$_smarty_tpl->tpl_vars['product_price'] = clone $_smarty_tpl->tpl_vars['product_price'];
$_smarty_tpl->tpl_vars['product_price']->value = ($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl']+$_smarty_tpl->tpl_vars['product']->value['ecotax']); $_smarty_tpl->tpl_vars['product_price']->nocache = null; $_smarty_tpl->tpl_vars['product_price']->scope = 0;
} else $_smarty_tpl->tpl_vars['product_price'] = new Smarty_variable(($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl']+$_smarty_tpl->tpl_vars['product']->value['ecotax']), null, 0);?>
<?php } else { ?>
	<?php if (isset($_smarty_tpl->tpl_vars['product_price'])) {$_smarty_tpl->tpl_vars['product_price'] = clone $_smarty_tpl->tpl_vars['product_price'];
$_smarty_tpl->tpl_vars['product_price']->value = $_smarty_tpl->tpl_vars['product']->value['unit_price_tax_incl']; $_smarty_tpl->tpl_vars['product_price']->nocache = null; $_smarty_tpl->tpl_vars['product_price']->scope = 0;
} else $_smarty_tpl->tpl_vars['product_price'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_incl'], null, 0);?>
<?php }?>

	<tr class="customized customized-<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
 product-line-row product_line customized-main" id="line_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['index']->value, ENT_QUOTES, 'UTF-8', true);?>
" data-custom-main="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
"  data-pr="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_id'], ENT_QUOTES, 'UTF-8', true);?>
-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_attribute_id'], ENT_QUOTES, 'UTF-8', true);?>
">
		<td>
			<input type="hidden" class="edit_product_id_order_detail" value="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
" />
			<?php if (isset($_smarty_tpl->tpl_vars['product']->value['image'])&&intval($_smarty_tpl->tpl_vars['product']->value['image']->id)) {?><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['product']->value['image_tag']);?>
<?php } else { ?>--<?php }?>
		</td>
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
					<span class="displayVal product_price_show" wt="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_incl'],2), ENT_QUOTES, 'UTF-8', true);?>
" pwt="<?php echo htmlspecialchars(Product::getPriceStatic($_smarty_tpl->tpl_vars['product']->value['product_id'],true,$_smarty_tpl->tpl_vars['product']->value['product_attribute_id']), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['product_price']->value,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
				</p>
				<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
				<p class="realVal" style="display:none;">
					<span class="product_price_edit">
						<input type="hidden" name="product_id_order_detail" class="edit_product_id_order_detail" rel="idOrderDetail" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_order_detail'], ENT_QUOTES, 'UTF-8', true);?>
" />
						<?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
						<input type="text" name="product_price_tax_excl" class="edit_product_price_tax_excl edit_product_price" rel="productPriceEdit" value="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl'],2), ENT_QUOTES, 'UTF-8', true);?>
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
					<span class="product_tax_rate_show"><?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['tax_rate'],2), ENT_QUOTES, 'UTF-8', true);?>
%</span>
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
	                            <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tax']->value['id_tax'], ENT_QUOTES, 'UTF-8', true);?>
:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tax']->value['rate'], ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['tax']->value['id_tax']==$_smarty_tpl->tpl_vars['product']->value['id_tax']) {?>selected<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tax']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
	                        <?php } ?>
	                    </select>
					</span>
				</p>
				<?php }?>
			</div>
		</td>
		<td align="center" class="productQuantity">
				<p class="displayVal" style="margin: 0;">
					<span class="product_quantity_show customQ"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal'], ENT_QUOTES, 'UTF-8', true);?>
</span>
				</p>
				<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
				<p class="realVal" style="display:none;">
					<span class="realVal product_quantity_edit" style="display:none;">
						<input type="text" rel="productCustomAllQtyEdit" class="edit_product_quantity" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal'], ENT_QUOTES, 'UTF-8', true);?>
" size="2"  autocomplete="off" />
					</span>
				</p>
				<?php }?>
		</td>

		<td align="center" class="total_product">
			<?php if (($_smarty_tpl->tpl_vars['order']->value->getTaxCalculationMethod()==@constant('PS_TAX_EXC'))) {?>
				<?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice(Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['product_price']*$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal'],2),(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

			<?php } else { ?>
				<?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice(Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['product_price_wt']*$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal'],2),(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

			<?php }?>
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
		<td class="product_action" style="text-align:right" q>
			<a href="#" class="cancel_product_change_link" style="display: none;"><img src="../img/admin/disabled.gif" alt="<?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'orderedit'),$_smarty_tpl);?>
" /></a>
		</td>

	</tr>

	<?php  $_smarty_tpl->tpl_vars['customizationPerAddress'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customizationPerAddress']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product']->value['customizedDatas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['customizationPerAddress']->key => $_smarty_tpl->tpl_vars['customizationPerAddress']->value) {
$_smarty_tpl->tpl_vars['customizationPerAddress']->_loop = true;
?>
		<?php  $_smarty_tpl->tpl_vars['customization'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customization']->_loop = false;
 $_smarty_tpl->tpl_vars['customizationId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['customizationPerAddress']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['customization']->key => $_smarty_tpl->tpl_vars['customization']->value) {
$_smarty_tpl->tpl_vars['customization']->_loop = true;
 $_smarty_tpl->tpl_vars['customizationId']->value = $_smarty_tpl->tpl_vars['customization']->key;
?>
			<tr class="customized customized-<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
 customized-prop" id="customline_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['index']->value, ENT_QUOTES, 'UTF-8', true);?>
" data-custom-prop="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
">
				<td colspan="2">
				<input type="hidden" class="edit_product_id_order_detail" value="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
" />
					<div class="form-horizontal">
						<?php  $_smarty_tpl->tpl_vars['datas'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['datas']->_loop = false;
 $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['customization']->value['datas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['datas']->key => $_smarty_tpl->tpl_vars['datas']->value) {
$_smarty_tpl->tpl_vars['datas']->_loop = true;
 $_smarty_tpl->tpl_vars['type']->value = $_smarty_tpl->tpl_vars['datas']->key;
?>
							<?php if (($_smarty_tpl->tpl_vars['type']->value==Product::CUSTOMIZE_FILE)) {?>
								<?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['data']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['data']->iteration++;
?>
									<div class="form-group">
										<span class="col-lg-4 control-label"><strong><?php if ($_smarty_tpl->tpl_vars['data']->value['name']) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Picture #','mod'=>'orderedit'),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->iteration, ENT_QUOTES, 'UTF-8', true);?>
<?php }?></strong></span>
										<div class="col-lg-8">
											<a href="displayImage.php?img=<?php echo intval($_smarty_tpl->tpl_vars['data']->value['value']);?>
&amp;name=<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['order']->value->id);?>
-file<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->iteration, ENT_QUOTES, 'UTF-8', true);?>
" class="_blank">
												<img class="img-thumbnail" src="<?php echo preg_replace("%(?<!\\\\)'%", "\'",@constant('_THEME_PROD_PIC_DIR_'));?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
_small" alt=""/>
											</a>
										</div>
									</div>
								<?php } ?>
							<?php } elseif (($_smarty_tpl->tpl_vars['type']->value==Product::CUSTOMIZE_TEXTFIELD)) {?>
								<?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['datas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['data']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['data']->iteration++;
?>
									<div class="form-group">
										<span class="col-lg-4 control-label"><strong><?php if ($_smarty_tpl->tpl_vars['data']->value['name']) {?><?php echo smartyTranslate(array('s'=>'%s','sprintf'=>$_smarty_tpl->tpl_vars['data']->value['name'],'mod'=>'orderedit'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Text #%s','sprintf'=>$_smarty_tpl->tpl_vars['data']->iteration,'mod'=>'orderedit'),$_smarty_tpl);?>
<?php }?></strong></span>
										<div class="col-lg-8">

											<div class="editable">
												<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
												<p class="customVal" style="display:none;">
													<span></span>
												</p>
												<?php }?>
												<p class="displayVal">
													<span class="customdata_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['id_customization'], ENT_QUOTES, 'UTF-8', true);?>
-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['index'], ENT_QUOTES, 'UTF-8', true);?>
_show"><?php if ($_smarty_tpl->tpl_vars['data']->value['value']=='') {?>--<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></span>
												</p>
												<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
												<p class="realVal" style="display:none;">
													<span class="customdata_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['id_customization'], ENT_QUOTES, 'UTF-8', true);?>
-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['index'], ENT_QUOTES, 'UTF-8', true);?>
_edit">
														<input type="text" name="customdata_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['id_customization'], ENT_QUOTES, 'UTF-8', true);?>
-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['index'], ENT_QUOTES, 'UTF-8', true);?>
" class="edit_customdata edit_customdata_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['id_customization'], ENT_QUOTES, 'UTF-8', true);?>
-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['index'], ENT_QUOTES, 'UTF-8', true);?>
" rel="customdataEdit" id-cus="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['id_customization'], ENT_QUOTES, 'UTF-8', true);?>
" id-index="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['index'], ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
" />
													</span>
												</p>
												<?php }?>
											</div>

											<!-- <p class="form-control-static"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
</p> -->
										</div>
									</div>
								<?php } ?>
							<?php }?>
						<?php } ?>
					</div>
				</td>
				<td align="center">-</td>
				<td>-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td class="productQuantity text-center">
					<div class="editable">
						<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
						<p class="customVal" style="display:none;">
							<span></span>
						</p>
						<?php }?>
						<p class="displayVal">
							<span class="product_quantity_show<?php if ((int)$_smarty_tpl->tpl_vars['customization']->value['quantity']>1) {?> red bold<?php }?>"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customization']->value['quantity'], ENT_QUOTES, 'UTF-8', true);?>
</span>
						</p>
						<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
						<p class="realVal" style="display:none;">
							<span class="realVal product_quantity_edit" style="display:none;">
								<input type="text" name="product_quantity[<?php echo intval($_smarty_tpl->tpl_vars['customizationId']->value);?>
]" id-cus="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['id_customization'], ENT_QUOTES, 'UTF-8', true);?>
" rel="productCustomQtyEdit" class="edit_product_quantity edit_customdata" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['customization']->value['quantity']);?>
" size="2"  autocomplete="off" />
							</span>
						</p>
						<?php }?>
					</div>
				</td>

				<td class="total_product" align="center">
					<?php if (($_smarty_tpl->tpl_vars['order']->value->getTaxCalculationMethod()==@constant('PS_TAX_EXC'))) {?>
						<?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice(Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['product_price']*$_smarty_tpl->tpl_vars['customization']->value['quantity'],2),(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

					<?php } else { ?>
						<?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice(Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['product_price_wt']*$_smarty_tpl->tpl_vars['customization']->value['quantity'],2),(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

					<?php }?>
				</td>
				<td class="cancelCheck standard_refund_fields current-edit" style="display:none">
					<input type="hidden" name="totalQtyReturn" id="totalQtyReturn" value="<?php echo intval($_smarty_tpl->tpl_vars['customization']->value['quantity_returned']);?>
" />
					<input type="hidden" name="totalQty" id="totalQty" value="<?php echo intval($_smarty_tpl->tpl_vars['customization']->value['quantity']);?>
" />
					<input type="hidden" name="productName" id="productName" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['product_name'], ENT_QUOTES, 'UTF-8', true);?>
" />
					<?php if (((!$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()||Configuration::get('PS_ORDER_RETURN'))&&(int)($_smarty_tpl->tpl_vars['customization']->value['quantity_returned'])<(int)($_smarty_tpl->tpl_vars['customization']->value['quantity']))) {?>
						<input type="checkbox" name="id_customization[<?php echo intval($_smarty_tpl->tpl_vars['customizationId']->value);?>
]" id="id_customization[<?php echo intval($_smarty_tpl->tpl_vars['customizationId']->value);?>
]" value="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_order_detail']);?>
" onchange="setCancelQuantity(this, <?php echo intval($_smarty_tpl->tpl_vars['customizationId']->value);?>
, <?php echo mb_convert_encoding(htmlspecialchars(($_smarty_tpl->tpl_vars['customization']->value['quantity']-$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']-$_smarty_tpl->tpl_vars['product']->value['product_quantity_reinjected']), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
)" <?php if (($_smarty_tpl->tpl_vars['product']->value['product_quantity_return']+$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded']>=$_smarty_tpl->tpl_vars['product']->value['product_quantity'])) {?>disabled="disabled" <?php }?>/>
					<?php } else { ?>
					--
				<?php }?>
				</td>
				<td class="cancelQuantity standard_refund_fields current-edit" style="display:none">
				<?php if (($_smarty_tpl->tpl_vars['customization']->value['quantity_returned']+$_smarty_tpl->tpl_vars['customization']->value['quantity_refunded']>=$_smarty_tpl->tpl_vars['customization']->value['quantity'])) {?>
					<input type="hidden" name="cancelCustomizationQuantity[<?php echo intval($_smarty_tpl->tpl_vars['customizationId']->value);?>
]" value="0" />
				<?php } elseif ((!$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()||Configuration::get('PS_ORDER_RETURN'))) {?>
					<input type="text" id="cancelQuantity_<?php echo intval($_smarty_tpl->tpl_vars['customizationId']->value);?>
" name="cancelCustomizationQuantity[<?php echo intval($_smarty_tpl->tpl_vars['customizationId']->value);?>
]" size="2" onclick="selectCheckbox(this);" value="" />0/<?php echo mb_convert_encoding(htmlspecialchars(($_smarty_tpl->tpl_vars['customization']->value['quantity']-$_smarty_tpl->tpl_vars['customization']->value['quantity_refunded']), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

				<?php }?>
				</td>

				<?php if (($_smarty_tpl->tpl_vars['can_edit']->value&&!$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered())) {?>
					<td class="edit_product_fields" colspan="2" style="display:none"></td>
					<td class="product_action" style="text-align:right" as>
						<a href="#" class="delete_product_line btn btn-default"><i class="icon-trash"></i> <?php echo smartyTranslate(array('s'=>'Delete','mod'=>'orderedit'),$_smarty_tpl);?>
</a>
					</td>
				<?php }?>
			</tr>
		<?php } ?>
	<?php } ?>
<?php }?>
<?php }} ?>
