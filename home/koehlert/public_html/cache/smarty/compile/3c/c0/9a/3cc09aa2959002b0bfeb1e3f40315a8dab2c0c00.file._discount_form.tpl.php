<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_discount_form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9883162555d5ced92c22a53-61596850%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3cc09aa2959002b0bfeb1e3f40315a8dab2c0c00' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_discount_form.tpl',
      1 => 1481621681,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9883162555d5ced92c22a53-61596850',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'currency' => 0,
    'order' => 0,
    'invoices_collection' => 0,
    'invoice' => 0,
    'current_id_lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced92c4ff78_02002809',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced92c4ff78_02002809')) {function content_5d5ced92c4ff78_02002809($_smarty_tpl) {?>

<div class="form-horizontal well">
	<div class="form-group">
		<label class="control-label col-lg-3">
			<?php echo smartyTranslate(array('s'=>'Name','mod'=>'orderedit'),$_smarty_tpl);?>

		</label>
		<div class="col-lg-9">
			<input class="form-control" type="text" name="discount_name" value="" />
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-lg-3">
			<?php echo smartyTranslate(array('s'=>'Type','mod'=>'orderedit'),$_smarty_tpl);?>

		</label>
		<div class="col-lg-9">
			<select class="form-control" name="discount_type" id="discount_type">
				<option value="1"><?php echo smartyTranslate(array('s'=>'Percent','mod'=>'orderedit'),$_smarty_tpl);?>
</option>
				<option value="2"><?php echo smartyTranslate(array('s'=>'Amount','mod'=>'orderedit'),$_smarty_tpl);?>
</option>
				<option value="3"><?php echo smartyTranslate(array('s'=>'Free shipping','mod'=>'orderedit'),$_smarty_tpl);?>
</option>
			</select>
		</div>
	</div>

	<div id="discount_value_field" class="form-group">
		<label class="control-label col-lg-3">
			<?php echo smartyTranslate(array('s'=>'Value','mod'=>'orderedit'),$_smarty_tpl);?>

		</label>
		<div class="col-lg-9">
			<div class="input-group">
				<div class="input-group-addon">
					<span id="discount_currency_sign" style="display: none;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
</span>
					<span id="discount_percent_symbol">%</span>
				</div>
				<input class="form-control" type="text" name="discount_value"/>
			</div>
			<p class="text-muted" id="discount_value_help" style="display: none;">
				<?php echo smartyTranslate(array('s'=>'This value must include taxes.','mod'=>'orderedit'),$_smarty_tpl);?>

			</p>
		</div>
	</div>

	<?php if ($_smarty_tpl->tpl_vars['order']->value->hasInvoice()) {?>
	<div class="form-group">
		<label class="control-label col-lg-3">
			<?php echo smartyTranslate(array('s'=>'Invoice','mod'=>'orderedit'),$_smarty_tpl);?>

		</label>
		<div class="col-lg-9">
			<select name="discount_invoice">
				<?php  $_smarty_tpl->tpl_vars['invoice'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invoice']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['invoices_collection']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['invoice']->key => $_smarty_tpl->tpl_vars['invoice']->value) {
$_smarty_tpl->tpl_vars['invoice']->_loop = true;
?>
				<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['invoice']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" selected="selected">
					<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['invoice']->value->getInvoiceNumberFormatted($_smarty_tpl->tpl_vars['current_id_lang']->value), ENT_QUOTES, 'UTF-8', true);?>
 - <?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['invoice']->value->total_paid_tax_incl,(int)$_smarty_tpl->tpl_vars['order']->value->id_currency), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

				</option>
				<?php } ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<p class="checkbox">
				<label class="control-label" for="discount_all_invoices">
					<input type="checkbox" name="discount_all_invoices" id="discount_all_invoices" value="1" /> 
					<?php echo smartyTranslate(array('s'=>'Apply on all invoices','mod'=>'orderedit'),$_smarty_tpl);?>

				</label>
			</p>
			<p class="help-block">
				<?php echo smartyTranslate(array('s'=>'If you chooses to create this discount for all invoices, only one discount will be created per order invoice.','mod'=>'orderedit'),$_smarty_tpl);?>

			</p>
		</div>
	</div>
	<?php }?>

	<div class="row">
		<div class="col-lg-9 col-lg-offset-3">
			<button class="btn btn-default" type="button" id="cancel_add_voucher">
				<i class="icon-remove text-danger"></i>
				<?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'orderedit'),$_smarty_tpl);?>

			</button>
			<button class="btn btn-default" type="submit" name="submitNewVoucher">
				<i class="icon-ok text-success"></i>
				<?php echo smartyTranslate(array('s'=>'Add','mod'=>'orderedit'),$_smarty_tpl);?>

			</button>
		</div>
	</div>
</div><?php }} ?>
