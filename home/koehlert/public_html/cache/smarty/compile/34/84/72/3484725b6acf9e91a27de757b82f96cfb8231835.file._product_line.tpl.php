<?php /* Smarty version Smarty-3.1.19, created on 2019-08-20 00:10:13
         compiled from "/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/orders/_product_line.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1242363035d5a56570779b4-94449328%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3484725b6acf9e91a27de757b82f96cfb8231835' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/orders/_product_line.tpl',
      1 => 1566250842,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1242363035d5a56570779b4-94449328',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a5657245632_18037350',
  'variables' => 
  array (
    'order' => 0,
    'product' => 0,
    'link' => 0,
    'so' => 0,
    'product_price' => 0,
    'currency' => 0,
    'can_edit' => 0,
    'display_warehouse' => 0,
    'refund' => 0,
    'return' => 0,
    'stock_management' => 0,
    'productQuantity' => 0,
    'amount_refundable' => 0,
    'invoices_collection' => 0,
    'invoice' => 0,
    'current_id_lang' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a5657245632_18037350')) {function content_5d5a5657245632_18037350($_smarty_tpl) {?>


<?php if (($_smarty_tpl->tpl_vars['order']->value->getTaxCalculationMethod()==@constant('PS_TAX_EXC'))) {?>
	<?php if (isset($_smarty_tpl->tpl_vars['product_price'])) {$_smarty_tpl->tpl_vars['product_price'] = clone $_smarty_tpl->tpl_vars['product_price'];
$_smarty_tpl->tpl_vars['product_price']->value = ($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl']+$_smarty_tpl->tpl_vars['product']->value['ecotax']); $_smarty_tpl->tpl_vars['product_price']->nocache = null; $_smarty_tpl->tpl_vars['product_price']->scope = 0;
} else $_smarty_tpl->tpl_vars['product_price'] = new Smarty_variable(($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl']+$_smarty_tpl->tpl_vars['product']->value['ecotax']), null, 0);?>
<?php } else { ?>
	<?php if (isset($_smarty_tpl->tpl_vars['product_price'])) {$_smarty_tpl->tpl_vars['product_price'] = clone $_smarty_tpl->tpl_vars['product_price'];
$_smarty_tpl->tpl_vars['product_price']->value = $_smarty_tpl->tpl_vars['product']->value['unit_price_tax_incl']; $_smarty_tpl->tpl_vars['product_price']->nocache = null; $_smarty_tpl->tpl_vars['product_price']->scope = 0;
} else $_smarty_tpl->tpl_vars['product_price'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_incl'], null, 0);?>
<?php }?>


<tr class="product-line-row" id="orderDetailRow_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
" data-prod_spl_ref="<?php echo $_smarty_tpl->tpl_vars['product']->value['product_supplier_reference'];?>
">
    <td><input class="productIdCheckBox" type="checkbox" name="productId[]" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
" data-ref="<?php echo $_smarty_tpl->tpl_vars['product']->value['product_supplier_reference'];?>
"></td>
	<td><?php if (isset($_smarty_tpl->tpl_vars['product']->value['image'])&&$_smarty_tpl->tpl_vars['product']->value['image']->id) {?><?php echo $_smarty_tpl->tpl_vars['product']->value['image_tag'];?>
<?php }?></td>
	<td>
		<a class="<?php if (($_smarty_tpl->tpl_vars['product']->value['product_quantity_return']>0)||($_smarty_tpl->tpl_vars['product']->value['product_quantity']==0)) {?>text-red<?php }?>" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminProducts'), ENT_QUOTES, 'UTF-8', true);?>
&amp;id_product=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['product_id']);?>
&amp;updateproduct&amp;token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminProducts'),$_smarty_tpl);?>
">
			<span class="productName"><?php echo $_smarty_tpl->tpl_vars['product']->value['product_name'];?>
</span><br />
			<?php if ($_smarty_tpl->tpl_vars['product']->value['product_reference']) {?><?php echo smartyTranslate(array('s'=>'Reference number:'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['product']->value['product_reference'];?>
<br /><?php }?>
			<?php if ($_smarty_tpl->tpl_vars['product']->value['product_supplier_reference']) {?><?php echo smartyTranslate(array('s'=>'Supplier reference:'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['product']->value['product_supplier_reference'];?>
<?php }?>
		</a>
		<div class="row-editing-warning" style="display:none;">
			<div class="alert alert-warning">
				<strong><?php echo smartyTranslate(array('s'=>'Editing this product line will remove the reduction and base price.'),$_smarty_tpl);?>
</strong>
			</div>
		</div>
	</td>
        <td>
            <?php if (isset($_smarty_tpl->tpl_vars['product']->value['avForCur'])) {?>
                <?php echo smartyTranslate(array('s'=>"avail for ship:"),$_smarty_tpl);?>

                <?php echo $_smarty_tpl->tpl_vars['product']->value['avForCur'];?>

                <br/>
                <?php if ($_smarty_tpl->tpl_vars['product']->value['avForCur']>0) {?>
                    <?php if ($_smarty_tpl->tpl_vars['product']->value['avForCur']>$_smarty_tpl->tpl_vars['product']->value['dbkShopsQty']) {?>
                        <span class="list-action-enable action-enabled"><i class="icon-check"></i></span>
                    <?php } else { ?>
                        <span class="list-action-enable action-enabled colorOrange"><i class="icon-check"></i></span>
                    <?php }?>
                <?php } else { ?>
                    <span class="list-action-enable action-disabled stockStatusExpDelivery" rel="#expDelivery<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
"><i class="icon-remove"></i></span>
                    
                    <div class="bootstrap hidden" id="expDelivery<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
">
                    <?php if (!empty($_smarty_tpl->tpl_vars['product']->value['expDelivery'])) {?>
                    <table class="table" style="width:100%">
                        <tr>
                            <th><?php echo smartyTranslate(array('s'=>'Sup Order id'),$_smarty_tpl);?>
</th>
                            <th><?php echo smartyTranslate(array('s'=>'Exp. Date'),$_smarty_tpl);?>
</th>
                        </tr>
                        <?php  $_smarty_tpl->tpl_vars['so'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['so']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product']->value['expDelivery']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['so']->key => $_smarty_tpl->tpl_vars['so']->value) {
$_smarty_tpl->tpl_vars['so']->_loop = true;
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['so']->value['id'];?>
 / <?php echo $_smarty_tpl->tpl_vars['so']->value['order_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['so']->value['exp_arrive_date'],'full'=>false),$_smarty_tpl);?>
</td>
                        </tr>
                        <?php } ?>
                    </table>
                    <?php } else { ?>
                        <p>&nbsp;<?php echo smartyTranslate(array('s'=>'No delivery expected'),$_smarty_tpl);?>
&nbsp;</p>
                    <?php }?>
                    </div>
                    
                <?php }?>
                <i class="icon-info-circle fa-2x stockStatusHelpIcon" rel="#stockStatusHelp"></i>
            <?php } else { ?>    
            
            <?php echo smartyTranslate(array('s'=>'No stock status info available'),$_smarty_tpl);?>

            <?php }?>
        </td>
        <td class="text-center shippedCol">
            <?php if (!empty($_smarty_tpl->tpl_vars['product']->value['who_shipped'])) {?>
            <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo $_smarty_tpl->tpl_vars['product']->value['who_shipped'];?>
" data-html="true" data-placement="top">
            <?php }?>
            
            
            <span class="list-action-enable <?php if (($_smarty_tpl->tpl_vars['product']->value['product_quantity']-$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded']-$_smarty_tpl->tpl_vars['product']->value['product_quantity_return']-$_smarty_tpl->tpl_vars['product']->value['shipped']<=0&&$_smarty_tpl->tpl_vars['product']->value['shipped']>0)) {?>action-enabled<?php } else { ?>action-disabled<?php }?>" ><?php if (($_smarty_tpl->tpl_vars['product']->value['product_quantity']-$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded']-$_smarty_tpl->tpl_vars['product']->value['product_quantity_return']-$_smarty_tpl->tpl_vars['product']->value['shipped']<=0&&$_smarty_tpl->tpl_vars['product']->value['shipped']>0)) {?><i class="icon-check"></i><?php } else { ?><i class="icon-remove"></i><?php }?></span>
            <br/>
            <span class="shippedNum"><?php echo $_smarty_tpl->tpl_vars['product']->value['shipped'];?>
</span>/<span class="needToBeShippedNum"><?php echo $_smarty_tpl->tpl_vars['product']->value['product_quantity']-$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded']-$_smarty_tpl->tpl_vars['product']->value['product_quantity_return'];?>
</span>
            <?php if (!empty($_smarty_tpl->tpl_vars['product']->value['who_shipped'])) {?>
            </span>
            <?php }?>
        </td>
	<td>
		<span class="product_price_show"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product_price']->value,'currency'=>$_smarty_tpl->tpl_vars['currency']->value->id),$_smarty_tpl);?>
</span>
		<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
		<div class="product_price_edit" style="display:none;">
			<input type="hidden" name="product_id_order_detail" class="edit_product_id_order_detail" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
" />
			<div class="form-group">
				<div class="fixed-width-xl">
					<div class="input-group">
						<?php if ($_smarty_tpl->tpl_vars['currency']->value->format%2) {?><div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
 <?php echo smartyTranslate(array('s'=>'tax excl.'),$_smarty_tpl);?>
</div><?php }?>
						<input type="text" name="product_price_tax_excl" class="edit_product_price_tax_excl edit_product_price" value="<?php echo Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_excl'],2);?>
"/>
						<?php if (!($_smarty_tpl->tpl_vars['currency']->value->format%2)) {?><div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
 <?php echo smartyTranslate(array('s'=>'tax excl.'),$_smarty_tpl);?>
</div><?php }?>
					</div>
				</div>
				<br/>
				<div class="fixed-width-xl">
					<div class="input-group">
						<?php if ($_smarty_tpl->tpl_vars['currency']->value->format%2) {?><div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
 <?php echo smartyTranslate(array('s'=>'tax incl.'),$_smarty_tpl);?>
</div><?php }?>
						<input type="text" name="product_price_tax_incl" class="edit_product_price_tax_incl edit_product_price" value="<?php echo Tools::ps_round($_smarty_tpl->tpl_vars['product']->value['unit_price_tax_incl'],2);?>
"/>
						<?php if (!($_smarty_tpl->tpl_vars['currency']->value->format%2)) {?><div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
 <?php echo smartyTranslate(array('s'=>'tax incl.'),$_smarty_tpl);?>
</div><?php }?>
					</div>
				</div>
			</div>
		</div>
		<?php }?>
	</td>
	<td class="productQuantity text-center">
		<span class="product_quantity_show<?php if ((int)$_smarty_tpl->tpl_vars['product']->value['product_quantity']-(int)$_smarty_tpl->tpl_vars['product']->value['customized_product_quantity']>1) {?> badge<?php }?>"><?php echo (int)$_smarty_tpl->tpl_vars['product']->value['product_quantity']-(int)$_smarty_tpl->tpl_vars['product']->value['customized_product_quantity'];?>
</span>
		<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
		<span class="product_quantity_edit" style="display:none;">
			<input type="text" name="product_quantity" class="edit_product_quantity" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['product']->value['product_quantity']);?>
" autocomplete="off" />
		</span>
		<?php }?>
	</td>
	<?php if ($_smarty_tpl->tpl_vars['display_warehouse']->value) {?>
		<td>
			<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['warehouse_name'], ENT_QUOTES, 'UTF-8', true);?>

			<?php if ($_smarty_tpl->tpl_vars['product']->value['warehouse_location']) {?>
				<br><?php echo smartyTranslate(array('s'=>'Location'),$_smarty_tpl);?>
: <strong><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['warehouse_location'], ENT_QUOTES, 'UTF-8', true);?>
</strong>
			<?php }?>
		</td>
	<?php }?>
	<?php if (($_smarty_tpl->tpl_vars['order']->value->hasBeenPaid())) {?>
		<td class="productQuantity text-center">
			<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['amount_refund'])) {?>
				<?php echo smartyTranslate(array('s'=>'%s (%s refund)','sprintf'=>array($_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded'],$_smarty_tpl->tpl_vars['product']->value['amount_refund'])),$_smarty_tpl);?>

			<?php }?>
			<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['quantity_refundable'];?>
" class="partialRefundProductQuantity" />
			<input type="hidden" value="<?php echo (Tools::ps_round($_smarty_tpl->tpl_vars['product_price']->value,2)*($_smarty_tpl->tpl_vars['product']->value['product_quantity']-$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']));?>
" class="partialRefundProductAmount" />
			<?php if (count($_smarty_tpl->tpl_vars['product']->value['refund_history'])) {?>
				<span class="tooltip">
					<span class="tooltip_label tooltip_button">+</span>
					<span class="tooltip_content">
					<span class="title"><?php echo smartyTranslate(array('s'=>'Refund history'),$_smarty_tpl);?>
</span>
					<?php  $_smarty_tpl->tpl_vars['refund'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['refund']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product']->value['refund_history']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['refund']->key => $_smarty_tpl->tpl_vars['refund']->value) {
$_smarty_tpl->tpl_vars['refund']->_loop = true;
?>
						<?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['refund']->value['date_add']),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['refund']->value['amount_tax_incl']),$_smarty_tpl);?>
<?php $_tmp2=ob_get_clean();?><?php echo smartyTranslate(array('s'=>'%1s - %2s','sprintf'=>array($_tmp1,$_tmp2)),$_smarty_tpl);?>
<br />
					<?php } ?>
					</span>
				</span>
			<?php }?>
		</td>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()||$_smarty_tpl->tpl_vars['order']->value->hasProductReturned()) {?>
		<td class="productQuantity text-center">
			<span class="<?php if ($_smarty_tpl->tpl_vars['product']->value['product_quantity_return']>0) {?>label label-danger<?php }?>"><?php echo $_smarty_tpl->tpl_vars['product']->value['product_quantity_return'];?>
</span>
			<?php if (count($_smarty_tpl->tpl_vars['product']->value['return_history'])) {?>
				<span class="tooltip">
					<span class="tooltip_label tooltip_button">+</span>
					<span class="tooltip_content">
					<span class="title"><?php echo smartyTranslate(array('s'=>'Return history'),$_smarty_tpl);?>
</span>
					<?php  $_smarty_tpl->tpl_vars['return'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['return']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product']->value['return_history']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['return']->key => $_smarty_tpl->tpl_vars['return']->value) {
$_smarty_tpl->tpl_vars['return']->_loop = true;
?>
						<?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['return']->value['date_add']),$_smarty_tpl);?>
<?php $_tmp3=ob_get_clean();?><?php echo smartyTranslate(array('s'=>'%1s - %2s - %3s','sprintf'=>array($_tmp3,$_smarty_tpl->tpl_vars['return']->value['product_quantity'],$_smarty_tpl->tpl_vars['return']->value['state'])),$_smarty_tpl);?>
<br />
					<?php } ?>
					</span>
				</span>
			<?php }?>
		</td>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['stock_management']->value) {?><td class="productQuantity product_stock text-center" rel="" data-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['product_supplier_reference'];?>
"><?php echo $_smarty_tpl->tpl_vars['product']->value['current_stock'];?>
</td><?php }?>
	<?php if ($_smarty_tpl->tpl_vars['stock_management']->value) {?><td class="text-center product_stock_physical" rel="" data-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['product_supplier_reference'];?>
"><?php echo $_smarty_tpl->tpl_vars['product']->value['physical_stock'];?>
</td><?php }?>
	<td class="total_product">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>(Tools::ps_round($_smarty_tpl->tpl_vars['product_price']->value,2)*($_smarty_tpl->tpl_vars['product']->value['product_quantity']-$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal'])),'currency'=>$_smarty_tpl->tpl_vars['currency']->value->id),$_smarty_tpl);?>

	</td>
	<td colspan="2" style="display: none;" class="add_product_fields">&nbsp;</td>
	<td class="cancelCheck standard_refund_fields current-edit" style="display:none">
		<input type="hidden" name="totalQtyReturn" id="totalQtyReturn" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['product_quantity_return'];?>
" />
		<input type="hidden" name="totalQty" id="totalQty" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['product_quantity'];?>
" />
		<input type="hidden" name="productName" id="productName" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['product_name'];?>
" />
	
	<?php if ((Configuration::get('PS_ORDER_RETURN')&&($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()||$_smarty_tpl->tpl_vars['product']->value['shipped']>0)&&($_smarty_tpl->tpl_vars['product']->value['product_quantity_return']+$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded']<$_smarty_tpl->tpl_vars['product']->value['product_quantity']))) {?>
		<input type="checkbox" class="returnOrderDetailCheckBox" name="id_order_detail[<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
]" id="id_order_detail[<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
" onchange="setCancelQuantity(this, <?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
, <?php echo $_smarty_tpl->tpl_vars['product']->value['product_quantity']-$_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']-$_smarty_tpl->tpl_vars['product']->value['product_quantity_return']-$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded'];?>
)" <?php if (($_smarty_tpl->tpl_vars['product']->value['product_quantity_return']+$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded']>=$_smarty_tpl->tpl_vars['product']->value['product_quantity'])) {?>disabled="disabled" <?php }?>/>
	<?php } else { ?>
		--
	<?php }?>
	</td>
	<td class="cancelQuantity standard_refund_fields current-edit" style="display:none">
	<?php if (($_smarty_tpl->tpl_vars['product']->value['product_quantity_return']+$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded']>=$_smarty_tpl->tpl_vars['product']->value['product_quantity'])) {?>
		<input type="hidden" name="cancelQuantity[<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
]" value="0" />
	<?php } elseif ((Configuration::get('PS_ORDER_RETURN')&&($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()||$_smarty_tpl->tpl_vars['product']->value['shipped']>0))) {?>
		<input type="text" id="cancelQuantity_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
" name="cancelQuantity[<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
]" onchange="checkTotalRefundProductQuantity(this)" value="" />
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
		<?php echo $_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded'];?>
/<?php echo $_smarty_tpl->tpl_vars['productQuantity']->value-$_smarty_tpl->tpl_vars['product']->value['product_quantity_refunded'];?>

	<?php } elseif (($_smarty_tpl->tpl_vars['order']->value->hasBeenPaid())) {?>
		<?php echo $_smarty_tpl->tpl_vars['product']->value['product_quantity_return'];?>
/<?php echo $_smarty_tpl->tpl_vars['productQuantity']->value;?>

	<?php } else { ?>
		0/<?php echo $_smarty_tpl->tpl_vars['productQuantity']->value;?>

	<?php }?>
	</td>
	<td class="partial_refund_fields current-edit" colspan="2" style="display:none; width: 250px;">
		<?php if ($_smarty_tpl->tpl_vars['product']->value['quantity_refundable']>0) {?>
		<?php if (($_smarty_tpl->tpl_vars['order']->value->getTaxCalculationMethod()==@constant('PS_TAX_EXC'))) {?>
			<?php if (isset($_smarty_tpl->tpl_vars['amount_refundable'])) {$_smarty_tpl->tpl_vars['amount_refundable'] = clone $_smarty_tpl->tpl_vars['amount_refundable'];
$_smarty_tpl->tpl_vars['amount_refundable']->value = $_smarty_tpl->tpl_vars['product']->value['amount_refundable']; $_smarty_tpl->tpl_vars['amount_refundable']->nocache = null; $_smarty_tpl->tpl_vars['amount_refundable']->scope = 0;
} else $_smarty_tpl->tpl_vars['amount_refundable'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['amount_refundable'], null, 0);?>
		<?php } else { ?>
			<?php if (isset($_smarty_tpl->tpl_vars['amount_refundable'])) {$_smarty_tpl->tpl_vars['amount_refundable'] = clone $_smarty_tpl->tpl_vars['amount_refundable'];
$_smarty_tpl->tpl_vars['amount_refundable']->value = $_smarty_tpl->tpl_vars['product']->value['amount_refundable_tax_incl']; $_smarty_tpl->tpl_vars['amount_refundable']->nocache = null; $_smarty_tpl->tpl_vars['amount_refundable']->scope = 0;
} else $_smarty_tpl->tpl_vars['amount_refundable'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['amount_refundable_tax_incl'], null, 0);?>
		<?php }?>
		<div class="form-group">
			<div class="<?php if ($_smarty_tpl->tpl_vars['product']->value['amount_refundable']>0) {?>col-lg-4<?php } else { ?>col-lg-12<?php }?>">
				<label class="control-label">
					<?php echo smartyTranslate(array('s'=>'Quantity:'),$_smarty_tpl);?>

				</label>
				<div class="input-group">
					<input onchange="checkPartialRefundProductQuantity(this)" type="text" name="partialRefundProductQuantity[<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
]" value="0" />
					<div class="input-group-addon">/ <?php echo $_smarty_tpl->tpl_vars['product']->value['quantity_refundable'];?>
</div>
				</div>
			</div>
			<div class="<?php if ($_smarty_tpl->tpl_vars['product']->value['quantity_refundable']>0) {?>col-lg-8<?php } else { ?>col-lg-12<?php }?>">
				<label class="control-label">
					<span class="title_box "><?php echo smartyTranslate(array('s'=>'Amount:'),$_smarty_tpl);?>
</span>
					<small class="text-muted">(<?php echo Smarty::$_smarty_vars['capture']['TaxMethod'];?>
)</small>
				</label>
				<div class="input-group">
					<?php if ($_smarty_tpl->tpl_vars['currency']->value->format%2) {?><div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
</div><?php }?>
					<input onchange="checkPartialRefundProductAmount(this)" type="text" name="partialRefundProduct[<?php echo $_smarty_tpl->tpl_vars['product']->value['id_order_detail'];?>
]" />
					<?php if (!($_smarty_tpl->tpl_vars['currency']->value->format%2)) {?><div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['currency']->value->sign;?>
</div><?php }?>
				</div>
				<p class="help-block"><i class="icon-warning-sign"></i> <?php echo smartyTranslate(array('s'=>'(Max %s %s)','sprintf'=>array(Tools::displayPrice(Tools::ps_round($_smarty_tpl->tpl_vars['amount_refundable']->value,2),$_smarty_tpl->tpl_vars['currency']->value->id),Smarty::$_smarty_vars['capture']['TaxMethod'])),$_smarty_tpl);?>
</p>
			</div>
		</div>
		<?php }?>
	</td>
	<td class="productDetailNote">
		<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['note'])&&!empty($_smarty_tpl->tpl_vars['product']->value['note_employee_n_date'])) {?>
		<span data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo $_smarty_tpl->tpl_vars['product']->value['note_employee_n_date'];?>
" data-html="true" data-placement="top">
		<?php }?>

		<?php if (empty($_smarty_tpl->tpl_vars['product']->value['note'])) {?>--<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['product']->value['note'];?>
<?php }?>

		<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['note'])&&!empty($_smarty_tpl->tpl_vars['product']->value['note_employee_n_date'])) {?></span><?php }?>

	</td>
	<td class="productDetailNotePrivate">
		<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['note_private'])&&!empty($_smarty_tpl->tpl_vars['product']->value['note_employee_n_date'])) {?>
		<span data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo $_smarty_tpl->tpl_vars['product']->value['note_employee_n_date'];?>
" data-html="true" data-placement="top">
		<?php }?>

		<?php if (empty($_smarty_tpl->tpl_vars['product']->value['note_private'])) {?>--<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['product']->value['note_private'];?>
<?php }?>
	
		<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['note_private'])&&!empty($_smarty_tpl->tpl_vars['product']->value['note_employee_n_date'])) {?></span><?php }?>
	</td>
	
	<?php if (($_smarty_tpl->tpl_vars['can_edit']->value&&!$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()&&$_smarty_tpl->tpl_vars['product']->value['shipped']<$_smarty_tpl->tpl_vars['product']->value['product_quantity'])) {?>
	<td class="product_invoice" style="display: none;">
		<?php if (sizeof($_smarty_tpl->tpl_vars['invoices_collection']->value)) {?>
		<select name="product_invoice" class="edit_product_invoice">
			<?php  $_smarty_tpl->tpl_vars['invoice'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invoice']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['invoices_collection']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['invoice']->key => $_smarty_tpl->tpl_vars['invoice']->value) {
$_smarty_tpl->tpl_vars['invoice']->_loop = true;
?>
			<option value="<?php echo $_smarty_tpl->tpl_vars['invoice']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['invoice']->value->id==$_smarty_tpl->tpl_vars['product']->value['id_order_invoice']) {?>selected="selected"<?php }?>>
				#<?php echo Configuration::get('PS_INVOICE_PREFIX',$_smarty_tpl->tpl_vars['current_id_lang']->value,null,$_smarty_tpl->tpl_vars['order']->value->id_shop);?>
<?php echo sprintf('%06d',$_smarty_tpl->tpl_vars['invoice']->value->number);?>

			</option>
			<?php } ?>
		</select>
		<?php } else { ?>
		&nbsp;
		<?php }?>
	</td>
	<td class="product_action text-right">
		
		<div class="btn-group">
			<button type="button" class="btn btn-default edit_product_change_link">
				<i class="icon-pencil"></i>
				<?php echo smartyTranslate(array('s'=>'Edit'),$_smarty_tpl);?>

			</button>
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li>
					<a href="#" class="delete_product_line">
						<i class="icon-trash"></i>
						<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>

					</a>
				</li>
			</ul>
		</div>
		
		<button type="button" class="btn btn-default submitProductChange" style="display: none;">
			<i class="icon-ok"></i>
			<?php echo smartyTranslate(array('s'=>'Update'),$_smarty_tpl);?>

		</button>
		<button type="button" class="btn btn-default cancel_product_change_link" style="display: none;">
			<i class="icon-remove"></i>
			<?php echo smartyTranslate(array('s'=>'Cancel'),$_smarty_tpl);?>

		</button>
	</td>
	<?php }?>
</tr>

<?php }} ?>
