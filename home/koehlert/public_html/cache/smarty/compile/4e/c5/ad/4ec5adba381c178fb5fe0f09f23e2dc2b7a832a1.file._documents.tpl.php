<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_documents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20712293305d5ced921890b8-91660867%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ec5adba381c178fb5fe0f09f23e2dc2b7a832a1' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_documents.tpl',
      1 => 1481621681,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20712293305d5ced921890b8-91660867',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
    'document' => 0,
    'can_edit' => 0,
    'link' => 0,
    'current_id_lang' => 0,
    'currency' => 0,
    'current_index' => 0,
    'invoice_management_active' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced92292141_09896305',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced92292141_09896305')) {function content_5d5ced92292141_09896305($_smarty_tpl) {?>
<table class="table" width="100%;" cellspacing="0" cellpadding="0" id="documents_table">
	<thead>
		<tr>
			<th style="width:10%"><?php echo smartyTranslate(array('s'=>'Date','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
			<th style=""><?php echo smartyTranslate(array('s'=>'Document','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
			<th style="width:20%"><?php echo smartyTranslate(array('s'=>'Number','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
			<th style="width:10%"><?php echo smartyTranslate(array('s'=>'Amount','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
			<th style="width:1%"></th>
		</tr>
	</thead>
	<tbody>
	<?php  $_smarty_tpl->tpl_vars['document'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['document']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order']->value->getDocuments(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['document']->key => $_smarty_tpl->tpl_vars['document']->value) {
$_smarty_tpl->tpl_vars['document']->_loop = true;
?>

		<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
			<?php if (isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
			<tr class="invoice_line" id="delivery_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
			<?php } else { ?>
			<tr class="invoice_line" id="invoice_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
			<?php }?>
		<?php } elseif (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderSlip') {?>
			<tr class="invoice_line" id="orderslip_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
		<?php }?>

		<td class="document_date">
			<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
				<?php if (isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
			<input type="hidden" name="documentId" rel="documentId" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
			<div class="editable">
				<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
					<p class="customVal" style="display:none;">
						<span></span>
					</p>
				<?php }?>
				<p class="displayVal">
					<span class="document_datedelivery_show "><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->date_add, ENT_QUOTES, 'UTF-8', true);?>
</span>
				</p>
				<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
					<p class="realVal" style="display:none;">
                        <span class="document_datedelivery_edit">
                            <input type="text" class="datetime_pick" rel="documentDatedelivery" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->date_add, ENT_QUOTES, 'UTF-8', true);?>
" />
                        </span>
					</p>
				<?php }?>
			</div>
				<?php } else { ?>
			<input type="hidden" name="documentId" rel="documentId" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
			<div class="editable">
				<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
					<p class="customVal" style="display:none;">
						<span></span>
					</p>
				<?php }?>
				<p class="displayVal">
					<span class="document_dateadd_show "><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->date_add, ENT_QUOTES, 'UTF-8', true);?>
</span>
				</p>
				<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
					<p class="realVal" style="display:none;">
                        <span class="document_dateadd_edit">
                            <input type="text" class="datetime_pick" rel="documentDateadd" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->date_add, ENT_QUOTES, 'UTF-8', true);?>
" />
                        </span>
					</p>
				<?php }?>
			</div>
				<?php }?>
			<?php } else { ?>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['document']->value->date_add),$_smarty_tpl);?>

			<?php }?>
		</td>
		<td class="document_type">
			<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
				<?php if (isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
					<?php echo smartyTranslate(array('s'=>'Delivery slip','mod'=>'orderedit'),$_smarty_tpl);?>

				<?php } else { ?>
					<?php echo smartyTranslate(array('s'=>'Invoice','mod'=>'orderedit'),$_smarty_tpl);?>

				<?php }?>
			<?php } elseif (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderSlip') {?>
				<?php echo smartyTranslate(array('s'=>'Credit Slip','mod'=>'orderedit'),$_smarty_tpl);?>

			<?php }?></td>
		<td class="document_number">
			<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
				<?php if (isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
					<a target="_blank" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminPdf'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&submitAction=generateDeliverySlipPDF&id_order_invoice=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
			   	<?php } else { ?>
					<a target="_blank" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminPdf'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&submitAction=generateInvoicePDF&id_order_invoice=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
			   <?php }?>
			<?php } elseif (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderSlip') {?>
				<a target="_blank" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminPdf'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&submitAction=generateOrderSlipPDF&id_order_slip=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
			<?php }?>
			<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
				<?php if (isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
					#<?php echo htmlspecialchars(Configuration::get('PS_DELIVERY_PREFIX',$_smarty_tpl->tpl_vars['current_id_lang']->value,null,$_smarty_tpl->tpl_vars['order']->value->id_shop), ENT_QUOTES, 'UTF-8', true);?>
<?php echo sprintf('%06d',$_smarty_tpl->tpl_vars['document']->value->delivery_number);?>

				<?php } else { ?>
					<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->getInvoiceNumberFormatted($_smarty_tpl->tpl_vars['current_id_lang']->value,$_smarty_tpl->tpl_vars['order']->value->id_shop), ENT_QUOTES, 'UTF-8', true);?>

				<?php }?>
			<?php } elseif (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderSlip') {?>
				#<?php echo htmlspecialchars(Configuration::get('PS_CREDIT_SLIP_PREFIX',$_smarty_tpl->tpl_vars['current_id_lang']->value), ENT_QUOTES, 'UTF-8', true);?>
<?php echo sprintf('%06d',$_smarty_tpl->tpl_vars['document']->value->id);?>

			<?php }?></a></td>
		<td class="document_amount">
		<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
			<?php if (isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
				--
			<?php } else { ?>
				<?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['document']->value->total_paid_tax_incl,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&nbsp;
				<?php if ($_smarty_tpl->tpl_vars['document']->value->getTotalPaid()) {?>
					<span style="color:red;font-weight:bold;">
					<?php if ($_smarty_tpl->tpl_vars['document']->value->getRestPaid()>0) {?>
						<?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['document']->value->getRestPaid(),(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo smartyTranslate(array('s'=>'not paid','mod'=>'orderedit'),$_smarty_tpl);?>
)
					<?php } elseif ($_smarty_tpl->tpl_vars['document']->value->getRestPaid()<0) {?>
						<?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['document']->value->getRestPaid(),(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo smartyTranslate(array('s'=>'overpaid','mod'=>'orderedit'),$_smarty_tpl);?>
)
					<?php }?>
					</span>
				<?php }?>
			<?php }?>
		<?php } elseif (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderSlip') {?>
			<?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['document']->value->amount,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

		<?php }?>
		</td>
		<td class="text-right document_action">
			<div class="btn-group btn-group-nowrap" role="group">
				<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
					<?php if (!isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
						<?php if ($_smarty_tpl->tpl_vars['document']->value->getRestPaid()) {?>
							<a href="#" class="js-set-payment btn btn-default" data-amount="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->getRestPaid(), ENT_QUOTES, 'UTF-8', true);?>
" data-id-invoice="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Set payment form','mod'=>'orderedit'),$_smarty_tpl);?>
"><i class="icon-money" title="<?php echo smartyTranslate(array('s'=>'Enter payment','mod'=>'orderedit'),$_smarty_tpl);?>
"></i></a>
						<?php }?>
						<a href="#" class="btn btn-default" onclick="$('#invoiceNote<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
').show(); return false;" title="<?php if ($_smarty_tpl->tpl_vars['document']->value->note=='') {?><?php echo smartyTranslate(array('s'=>'Add note','mod'=>'orderedit'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Edit note','mod'=>'orderedit'),$_smarty_tpl);?>
<?php }?>">
							<?php if ($_smarty_tpl->tpl_vars['document']->value->note=='') {?>
								<i class="icon-plus-sign-alt" title="<?php echo smartyTranslate(array('s'=>'Add note','mod'=>'orderedit'),$_smarty_tpl);?>
"></i>
							<?php } else { ?>
								<i class="icon-pencil" title="<?php echo smartyTranslate(array('s'=>'Edit note','mod'=>'orderedit'),$_smarty_tpl);?>
"></i>
							<?php }?>
						</a>
					<?php }?>
				<?php }?>
				<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)!='OrderInvoice'||!isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
				<a href="#" class="deleteDocument btn btn-default" rel="<?php echo htmlspecialchars(get_class($_smarty_tpl->tpl_vars['document']->value), ENT_QUOTES, 'UTF-8', true);?>
^<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Delete document','mod'=>'orderedit'),$_smarty_tpl);?>
">
					<i class="icon-trash" alt="<?php echo smartyTranslate(array('s'=>'Delete document','mod'=>'orderedit'),$_smarty_tpl);?>
"></i>
				</a>
				<?php }?>
			</div>
		</td>
	</tr>
	<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
		<?php if (!isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
	<tr id="invoiceNote<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" style="display:none" class="current-edit">
		<td colspan="5">
			<form action="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['current_index']->value);?>
&viewOrder&id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" method="post">
				<p>
					<label for="editNote<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" class="t"><?php echo smartyTranslate(array('s'=>'Note','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
					<input type="hidden" name="id_order_invoice" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" />
					<textarea name="note" id="editNote<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" class="edit-note textarea-autosize"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->note, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
				</p>
				<p class="right">
					<button type="submit" name="submitEditNote" class="btn btn-default">
						<i class="icon-save"></i>
						<?php echo smartyTranslate(array('s'=>'Save','mod'=>'orderedit'),$_smarty_tpl);?>

					</button>
					<a href="#" class="btn btn-default" id="cancelNote" onclick="$('#invoiceNote<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->id, ENT_QUOTES, 'UTF-8', true);?>
').hide();return false;"><i class="icon-remove"></i> <?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'orderedit'),$_smarty_tpl);?>
</a>
				</p>
			</form>
		</td>
	</tr>
		<?php }?>
	<?php }?>
	<?php }
if (!$_smarty_tpl->tpl_vars['document']->_loop) {
?>
	<tr>
		<td colspan="5" class="list-empty">
			<div class="list-empty-msg">
				<i class="icon-warning-sign list-empty-icon"></i>
				<?php echo smartyTranslate(array('s'=>'There is no available document','mod'=>'orderedit'),$_smarty_tpl);?>

			</div>
			<?php if (isset($_smarty_tpl->tpl_vars['invoice_management_active']->value)&&$_smarty_tpl->tpl_vars['invoice_management_active']->value) {?>
				<a id="generateInvoiceBtn" class="btn btn-default" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_index']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;viewOrder&amp;submitGenerateInvoice&amp;id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
<?php if (isset($_GET['token'])) {?>&amp;token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
					<i class="icon-repeat"></i>
					<?php echo smartyTranslate(array('s'=>'Generate invoice','mod'=>'orderedit'),$_smarty_tpl);?>

				</a>
			<?php }?>
		</td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<?php }} ?>
