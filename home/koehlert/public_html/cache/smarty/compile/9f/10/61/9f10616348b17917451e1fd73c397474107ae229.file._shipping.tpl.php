<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_shipping.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13682197415d5ced922e0106-75224324%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f10616348b17917451e1fd73c397474107ae229' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_shipping.tpl',
      1 => 1499574859,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13682197415d5ced922e0106-75224324',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
    'can_edit' => 0,
    'currency' => 0,
    'wrapping_tax_rate' => 0,
    'line' => 0,
    'carriers' => 0,
    'carrier' => 0,
    'carrier_tax_rate' => 0,
    'carrierModuleCall' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced923ff624_31151513',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced923ff624_31151513')) {function content_5d5ced923ff624_31151513($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/koehlert/public_html/tools/smarty/plugins/modifier.replace.php';
?>
<div class="form-wrapper form-horizontal">
	<div class="form-group ">
		<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Recycled packaging:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
		<div class="col-lg-9">
			<span class="switch prestashop-switch fixed-width-lg">
				<input type="radio" name="recyclable" id="recyclable_on" value="1" <?php if ($_smarty_tpl->tpl_vars['order']->value->recyclable) {?> checked="checked"<?php }?>>
				<label for="recyclable_on" class="radioCheck">
					<?php echo smartyTranslate(array('s'=>'Yes','mod'=>'orderedit'),$_smarty_tpl);?>

				</label>
				<input type="radio" name="recyclable" id="recyclable_off" value="0" <?php if (!$_smarty_tpl->tpl_vars['order']->value->recyclable) {?> checked="checked"<?php }?>>
				<label for="recyclable_off" class="radioCheck">
					<?php echo smartyTranslate(array('s'=>'No','mod'=>'orderedit'),$_smarty_tpl);?>

				</label>
				<a class="slide-button btn"></a>
			</span>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Gift-wrapping:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
		<div class="col-lg-9">
			<span class="switch prestashop-switch fixed-width-lg">
				<input type="radio" name="gift" id="gift_on" value="1" <?php if ($_smarty_tpl->tpl_vars['order']->value->gift) {?> checked="checked"<?php }?>>
				<label for="gift_on" class="radioCheck">
					<?php echo smartyTranslate(array('s'=>'Yes','mod'=>'orderedit'),$_smarty_tpl);?>

				</label>
				<input type="radio" name="gift" id="gift_off" value="0" <?php if (!$_smarty_tpl->tpl_vars['order']->value->gift) {?> checked="checked"<?php }?>>
				<label for="gift_off" class="radioCheck">
					<?php echo smartyTranslate(array('s'=>'No','mod'=>'orderedit'),$_smarty_tpl);?>

				</label>
				<a class="slide-button btn"></a>
			</span>
		</div>
	</div>
</div>
<div class="form-wrapper form-horizontal" id="giftWrapper" <?php if (!$_smarty_tpl->tpl_vars['order']->value->gift) {?>style="display: none;"<?php }?>>
	<div class="form-group">
		<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Wrapping price:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
		<div class="col-lg-9">
			<div id="giftPriceWrapper">
				<div class="editable">
					<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
					<p class="customVal" style="display:none;">
						<span></span>
					</p>
					<?php }?>
					<p class="displayVal">
						<span class="wrapping_price_show"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_incl,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
					</p>
					
					<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
					<p class="realVal" style="display:none;">
						<span class="wrapping_price_edit">
							<?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
							<input type="text" name="wrapping_tax_excl" class="edit_wrapping_price_tax_excl edit_wrapping_price" rel="wrappingPriceEdit" value="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_excl,2), ENT_QUOTES, 'UTF-8', true);?>
" size="5" /> <?php if (!($_smarty_tpl->tpl_vars['currency']->value->sign%2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?> <?php echo smartyTranslate(array('s'=>'tax excl.','mod'=>'orderedit'),$_smarty_tpl);?>
<br />
							<?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
							<input type="text" name="wrapping_tax_incl" class="edit_wrapping_price_tax_incl edit_wrapping_price" rel="wrappingPriceWtEdit" value="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_incl,2), ENT_QUOTES, 'UTF-8', true);?>
" size="5" /> <?php if (!($_smarty_tpl->tpl_vars['currency']->value->sign%2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?> <?php echo smartyTranslate(array('s'=>'tax incl.','mod'=>'orderedit'),$_smarty_tpl);?>

						</span>
					</p>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Wrapping tax:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
		<div class="col-lg-9">
			<div id="giftTaxWrapper">
				<?php if ($_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_incl==0) {?>
				<?php if (isset($_smarty_tpl->tpl_vars['wrapping_tax_rate'])) {$_smarty_tpl->tpl_vars['wrapping_tax_rate'] = clone $_smarty_tpl->tpl_vars['wrapping_tax_rate'];
$_smarty_tpl->tpl_vars['wrapping_tax_rate']->value = 0; $_smarty_tpl->tpl_vars['wrapping_tax_rate']->nocache = null; $_smarty_tpl->tpl_vars['wrapping_tax_rate']->scope = 0;
} else $_smarty_tpl->tpl_vars['wrapping_tax_rate'] = new Smarty_variable(0, null, 0);?>
				<?php } else { ?>
				<?php if (isset($_smarty_tpl->tpl_vars['wrapping_tax_rate'])) {$_smarty_tpl->tpl_vars['wrapping_tax_rate'] = clone $_smarty_tpl->tpl_vars['wrapping_tax_rate'];
$_smarty_tpl->tpl_vars['wrapping_tax_rate']->value = (($_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_incl-$_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_excl)/$_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_excl)*100; $_smarty_tpl->tpl_vars['wrapping_tax_rate']->nocache = null; $_smarty_tpl->tpl_vars['wrapping_tax_rate']->scope = 0;
} else $_smarty_tpl->tpl_vars['wrapping_tax_rate'] = new Smarty_variable((($_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_incl-$_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_excl)/$_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_excl)*100, null, 0);?>
				<?php }?>
				<div class="editable">
					<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
					<p class="customVal" style="display:none;">
						<span></span>
					</p>
					<?php }?>
					<p class="displayVal">
						<span class="wrapping_price_show"><?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['wrapping_tax_rate']->value,2), ENT_QUOTES, 'UTF-8', true);?>
%</span>
					</p>
					
					<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
					<p class="realVal" style="display:none;">
						<span class="wrapping_price_edit">
							<input type="text" id="wrappingTaxRate" name="wrappingTaxRate" class="edit_wrapping_tax_rate edit_wrapping_tax" rel="wrappingTaxRateEdit" value="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['wrapping_tax_rate']->value,2), ENT_QUOTES, 'UTF-8', true);?>
" size="5" />
						</span>
					</p>
					<?php }?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-9 col-md-offset-3">
		<a href="#" class="btn btn-default" id="wrappingAutoCalculate" rel="wrappingAutoCalculate">
			<i class="icon-refresh"></i>
			<?php echo smartyTranslate(array('s'=>'Calculate wrapping price automatically','mod'=>'orderedit'),$_smarty_tpl);?>

		</a>
	</div>
	
	<div class="form-group">
		<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Gift message:','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
		<div class="col-lg-9">
			<div class="editable">
				<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
				<p class="customVal" style="display:none;">
					<span></span>
				</p>
				<?php }?>
				<p class="displayVal">
					<span class="gift_message_show"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->gift_message, ENT_QUOTES, 'UTF-8', true);?>
</span>
				</p>
				
				<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
				<p class="realVal" style="display:none;">
					<span class="wrapping_price_edit">
						<textarea name="gift_message" class="gift_message" rel="giftMessageEdit"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->gift_message, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
					</span>
				</p>
				<?php }?>
			</div>
		</div>
	</div>
</div>

<div class="clear" style="margin-bottom: 10px;"></div>
<table class="table" width="100%" cellspacing="0" cellpadding="0" id="shipping_table">
<colgroup>
	<col width="15%">
	<col width="15%">
	<col width="">
	<col width="10%">
	<col width="20%">
</colgroup>
	<thead>
	<tr>
		<th><?php echo smartyTranslate(array('s'=>'Date:','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
		<th><?php echo smartyTranslate(array('s'=>'Type','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
		<th><?php echo smartyTranslate(array('s'=>'Carrier','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
		<th><?php echo smartyTranslate(array('s'=>'Weight','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
		<th><?php echo smartyTranslate(array('s'=>'Shipping cost','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
		<th><?php echo smartyTranslate(array('s'=>'Tax rate','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
		<th><?php echo smartyTranslate(array('s'=>'Tracking number','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
	</tr>
	</thead>
	<tbody>
	<?php  $_smarty_tpl->tpl_vars['line'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['line']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order']->value->getShipping(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['line']->key => $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
?>
	<tr class="shipping_line">
		<td class="sh_date">
			<div class="editable">
			<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
			<p class="customVal" style="display:none;">
				<span></span>
			</p>
			<?php }?>
			<p class="displayVal">
				<span class="shipping_date_show"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['date_add'], ENT_QUOTES, 'UTF-8', true);?>
</span>
			</p>
			<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
			<p class="realVal" style="display:none;">
					<span class="shipping_date_edit">
						<input type="text" class="datetime_pick" id="edit_date_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['id_order_carrier'], ENT_QUOTES, 'UTF-8', true);?>
" rel="shippingDate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['date_add'], ENT_QUOTES, 'UTF-8', true);?>
" />
					</span>
			</p>
			<?php }?>
			</div>
		</td>
		<td class="sh_type"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['type'], ENT_QUOTES, 'UTF-8', true);?>
</td>
		<td class="sh_id">
			<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']&&isset($_smarty_tpl->tpl_vars['carriers']->value)&&count($_smarty_tpl->tpl_vars['carriers']->value)>0) {?>
				<select id="carrier_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['id_order_carrier'], ENT_QUOTES, 'UTF-8', true);?>
" rel="shippingCarrierId" autocomplete="off">
				<option value="0">--</option>
				<?php  $_smarty_tpl->tpl_vars['carrier'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['carrier']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['carriers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['carrier']->key => $_smarty_tpl->tpl_vars['carrier']->value) {
$_smarty_tpl->tpl_vars['carrier']->_loop = true;
?>
				<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['id_carrier'], ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']==$_smarty_tpl->tpl_vars['line']->value['id_carrier']) {?> selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
				<?php } ?>
				</select>
			<?php } else { ?>
			<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['state_name'], ENT_QUOTES, 'UTF-8', true);?>

			<?php }?>
		</td>
		<td class="sh_weight">
			<div class="editable">
				<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
				<p class="customVal" style="display:none;">
					<span></span>
				</p>
				<?php }?>
				<p class="displayVal">
					<span class="shipping_weight">
						<?php if ($_smarty_tpl->tpl_vars['line']->value['weight']) {?><?php echo htmlspecialchars(sprintf("%.3f",$_smarty_tpl->tpl_vars['line']->value['weight']), ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
					</span>
					<span class="weight_unit">
					<?php echo htmlspecialchars(Configuration::get('PS_WEIGHT_UNIT'), ENT_QUOTES, 'UTF-8', true);?>

					</span>
				</p>
				<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
				<p class="realVal" style="display:none;">
					<span class="shipping_weight_edit">
						<input type="text" name="shipping_weight" class="edit_weight" rel="shippingWeightEdit" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['weight'], ENT_QUOTES, 'UTF-8', true);?>
" />
					</span>
				</p>
				<?php }?>
			</div>
		</td>
		<td class="sh_price">
			<div class="editable">
				<input type="hidden" name="id_order_carrier" rel="orderShippingCarrier" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['id_order_carrier'], ENT_QUOTES, 'UTF-8', true);?>
" />
				<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
				<p class="customVal" style="display:none;">
					<span></span>
				</p>
				<?php }?>
				<p class="displayVal">
					<span class="product_price_show"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['line']->value['shipping_cost_tax_incl'],(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
				</p>
				<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
				<p class="realVal" style="display:none;">
					<span class="product_price_edit">
						<?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
						<input type="text" name="shipping_tax_excl" class="edit_shipping_price_tax_excl edit_shipping_price is_price_input" rel="shippingPriceEdit" value="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['line']->value['shipping_cost_tax_excl'],2), ENT_QUOTES, 'UTF-8', true);?>
" size="5" /> <?php if (!($_smarty_tpl->tpl_vars['currency']->value->sign%2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?> <?php echo smartyTranslate(array('s'=>'tax excl.','mod'=>'orderedit'),$_smarty_tpl);?>
<br />
						<?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
						<input type="text" name="shipping_tax_incl" class="edit_shipping_price_tax_incl edit_shipping_price is_price_input" rel="shippingPriceWtEdit" value="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['line']->value['shipping_cost_tax_incl'],2), ENT_QUOTES, 'UTF-8', true);?>
" size="5" /> <?php if (!($_smarty_tpl->tpl_vars['currency']->value->sign%2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?> <?php echo smartyTranslate(array('s'=>'tax incl.','mod'=>'orderedit'),$_smarty_tpl);?>

					</span>
				</p>
				<?php }?>
			</div>
		</td>
		<td class="sh_tax">
			<?php if ($_smarty_tpl->tpl_vars['line']->value['shipping_cost_tax_excl']==0) {?>
			<?php if (isset($_smarty_tpl->tpl_vars['carrier_tax_rate'])) {$_smarty_tpl->tpl_vars['carrier_tax_rate'] = clone $_smarty_tpl->tpl_vars['carrier_tax_rate'];
$_smarty_tpl->tpl_vars['carrier_tax_rate']->value = 0; $_smarty_tpl->tpl_vars['carrier_tax_rate']->nocache = null; $_smarty_tpl->tpl_vars['carrier_tax_rate']->scope = 0;
} else $_smarty_tpl->tpl_vars['carrier_tax_rate'] = new Smarty_variable(0, null, 0);?>
			<?php } else { ?>
			<?php if (isset($_smarty_tpl->tpl_vars['carrier_tax_rate'])) {$_smarty_tpl->tpl_vars['carrier_tax_rate'] = clone $_smarty_tpl->tpl_vars['carrier_tax_rate'];
$_smarty_tpl->tpl_vars['carrier_tax_rate']->value = (($_smarty_tpl->tpl_vars['line']->value['shipping_cost_tax_incl']-$_smarty_tpl->tpl_vars['line']->value['shipping_cost_tax_excl'])/$_smarty_tpl->tpl_vars['line']->value['shipping_cost_tax_excl'])*100; $_smarty_tpl->tpl_vars['carrier_tax_rate']->nocache = null; $_smarty_tpl->tpl_vars['carrier_tax_rate']->scope = 0;
} else $_smarty_tpl->tpl_vars['carrier_tax_rate'] = new Smarty_variable((($_smarty_tpl->tpl_vars['line']->value['shipping_cost_tax_incl']-$_smarty_tpl->tpl_vars['line']->value['shipping_cost_tax_excl'])/$_smarty_tpl->tpl_vars['line']->value['shipping_cost_tax_excl'])*100, null, 0);?>
			<?php }?>
			<div class="editable">
				<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
				<p class="customVal" style="display:none;">
					<span></span>
				</p>
				<?php }?>
				<p class="displayVal">
					<span class="shipping_tax_rate_show">
						<?php echo htmlspecialchars(sprintf("%.2F",$_smarty_tpl->tpl_vars['carrier_tax_rate']->value), ENT_QUOTES, 'UTF-8', true);?>
%
					</span>
				</p>
				<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
				<p class="realVal" style="display:none;">
					<span class="shipping_tax_rate_edit">
						<input type="text" name="shipping_tax_rate" class="edit_shipping_tax_rate is_price_input" rel="shippingTaxRateEdit" value="<?php echo htmlspecialchars(sprintf("%.2F",$_smarty_tpl->tpl_vars['carrier_tax_rate']->value), ENT_QUOTES, 'UTF-8', true);?>
" />
					</span>
				</p>
				<?php }?>
			</div>
		</td>
		<td class="sh_tracking">
			<div class="editable">
				<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
				<p class="customVal" style="display:none;">
					<span></span>
				</p>
				<?php }?>
				<p class="displayVal">
					<span class="shipping_tracking_number_show">
						<?php if ($_smarty_tpl->tpl_vars['line']->value['url']&&$_smarty_tpl->tpl_vars['line']->value['tracking_number']) {?><a href="<?php echo htmlspecialchars(smarty_modifier_replace($_smarty_tpl->tpl_vars['line']->value['url'],'@',$_smarty_tpl->tpl_vars['line']->value['tracking_number']), ENT_QUOTES, 'UTF-8', true);?>
" target="_blank"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['tracking_number'], ENT_QUOTES, 'UTF-8', true);?>
</a><?php } elseif ($_smarty_tpl->tpl_vars['line']->value['tracking_number']) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['tracking_number'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Add tracking number','mod'=>'orderedit'),$_smarty_tpl);?>
<?php }?>
					</span>
				</p>
				<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
				<p class="realVal" style="display:none;">
					<span class="shipping_tracking_number_edit">
						<input type="text" name="shipping_tracking_number" class="edit_tracking_number" rel="shippingTrackingNumberEdit" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['tracking_number'], ENT_QUOTES, 'UTF-8', true);?>
" />
					</span>
				</p>
				<?php }?>
			</div>
		</td>
	</tr>
	<?php } ?>
	</tbody>
</table>

<?php if ($_smarty_tpl->tpl_vars['carrierModuleCall']->value) {?>
	<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['carrierModuleCall']->value, ENT_QUOTES, 'UTF-8', true);?>

<?php }?><?php }} ?>
