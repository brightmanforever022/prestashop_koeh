<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 12:56:56
         compiled from "/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/orders/_documents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17047037595d5a80780450d9-97868600%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc9b8f14b7e8ba7ff530326c8b110d204d863e51' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/orders/_documents.tpl',
      1 => 1562056617,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17047037595d5a80780450d9-97868600',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'orderDocumentsOnlyTable' => 0,
    'can_edit' => 0,
    'order' => 0,
    'document' => 0,
    'link' => 0,
    'current_id_lang' => 0,
    'currency' => 0,
    'current_index' => 0,
    'invoice_management_active' => 0,
    'invoiceTemplates' => 0,
    'invoiceCategory' => 0,
    'template' => 0,
    'suggestedInvoiceTemplates' => 0,
    'optionStyle' => 0,
    'order_packages' => 0,
    'order_package' => 0,
    'invoiceTplId' => 0,
    'invoiceTplName' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a807819de04_82938767',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a807819de04_82938767')) {function content_5d5a807819de04_82938767($_smarty_tpl) {?>
<?php if (!isset($_smarty_tpl->tpl_vars['orderDocumentsOnlyTable']->value)&&$_smarty_tpl->tpl_vars['can_edit']->value) {?>
<div class="table-responsive">
<?php }?>
	<table class="table" id="documents_table">
		<thead>
			<tr>
				<th>
					<span class="title_box "><?php echo smartyTranslate(array('s'=>'Date'),$_smarty_tpl);?>
</span>
				</th>
				<th>
					<span class="title_box "><?php echo smartyTranslate(array('s'=>'Document'),$_smarty_tpl);?>
</span>
				</th>
                                <th>
					<span class="title_box "><?php echo smartyTranslate(array('s'=>'Template'),$_smarty_tpl);?>
</span>
				</th>
				<th>
					<span class="title_box "><?php echo smartyTranslate(array('s'=>'Number'),$_smarty_tpl);?>
</span>
				</th>
				
                                <th>
					<span class="title_box "><?php echo smartyTranslate(array('s'=>'Sum to pay'),$_smarty_tpl);?>
</span>
				</th>
                                <th>
					<span class="title_box "><?php echo smartyTranslate(array('s'=>'Paid'),$_smarty_tpl);?>
</span>
				</th>
                                <th>
					<span class="title_box "><?php echo smartyTranslate(array('s'=>'Shipped only'),$_smarty_tpl);?>
</span>
				</th>
                                <th>
					<span class="title_box "><?php echo smartyTranslate(array('s'=>'Due Date'),$_smarty_tpl);?>
</span>
				</th>
				<th></th>
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
					<tr id="delivery_<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
" documentId="<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
">
					<?php } else { ?>
					<tr id="invoice_<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
" documentId="<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
">
					<?php }?>
				<?php } elseif (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderSlip') {?>
					<tr id="orderslip_<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
" documentId="<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
">
				<?php }?>

						<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['document']->value->date_add),$_smarty_tpl);?>
<br/>
                                                    <?php echo $_smarty_tpl->tpl_vars['document']->value->employee_name;?>

                                                </td>
						<td>
							<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
								<?php if (isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
									<?php echo smartyTranslate(array('s'=>'Delivery slip'),$_smarty_tpl);?>

								<?php } else { ?>
									<?php echo smartyTranslate(array('s'=>'Invoice'),$_smarty_tpl);?>

								<?php }?>
							<?php } elseif (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderSlip') {?>
								<?php echo smartyTranslate(array('s'=>'Credit Slip'),$_smarty_tpl);?>

							<?php }?>
						</td>
                                                <td>
                                                    <?php if (get_class($_smarty_tpl->tpl_vars['document']->value)!='OrderSlip') {?>
							<?php echo $_smarty_tpl->tpl_vars['document']->value->getTemplateName($_smarty_tpl->tpl_vars['order']->value->id_lang);?>

						    <?php }?>
                                                </td>
						<td>
							<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
                                                                    <?php if (isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
                                                                        <a class="_blank" title="<?php echo smartyTranslate(array('s'=>'See the document'),$_smarty_tpl);?>
" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminPdf'), ENT_QUOTES, 'UTF-8', true);?>
&amp;submitAction=generateDeliverySlipPDF&amp;id_order_invoice=<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
">
                                                                    <?php } else { ?>
                                                                        <a class="_blank" title="<?php echo smartyTranslate(array('s'=>'See the document'),$_smarty_tpl);?>
" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminPdf'), ENT_QUOTES, 'UTF-8', true);?>
&amp;submitAction=generateInvoicePDF&amp;id_order_invoice=<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
">
                                                                    <?php }?>        
							<?php } elseif (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderSlip') {?>
								<a class="_blank" title="<?php echo smartyTranslate(array('s'=>'See the document'),$_smarty_tpl);?>
" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminPdf'), ENT_QUOTES, 'UTF-8', true);?>
&amp;submitAction=generateOrderSlipPDF&amp;id_order_slip=<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
">
							<?php }?>
							<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
								<?php if (isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
									<?php echo Configuration::get('PS_DELIVERY_PREFIX',$_smarty_tpl->tpl_vars['current_id_lang']->value,null,$_smarty_tpl->tpl_vars['order']->value->id_shop);?>
<?php echo sprintf('%06d',$_smarty_tpl->tpl_vars['document']->value->delivery_number);?>

								<?php } else { ?>
									<?php echo $_smarty_tpl->tpl_vars['document']->value->getInvoiceNumberFormatted($_smarty_tpl->tpl_vars['current_id_lang']->value,$_smarty_tpl->tpl_vars['order']->value->id_shop);?>

								<?php }?>
							<?php } elseif (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderSlip') {?>
								<?php echo Configuration::get('PS_CREDIT_SLIP_PREFIX',$_smarty_tpl->tpl_vars['current_id_lang']->value);?>
<?php echo sprintf('%06d',$_smarty_tpl->tpl_vars['document']->value->id);?>

							<?php }?>
							</a>
						</td>
                                               
						<td <?php if (!isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>class="sumToPay"<?php }?>>
							<?php if (isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
								--
							<?php } else { ?>
								<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['document']->value->sum_to_pay,'currency'=>$_smarty_tpl->tpl_vars['currency']->value->id),$_smarty_tpl);?>

							<?php }?>
						</td>
                        <td class="documentPaid">
                        	<a href="#" 
                        		class="<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>documentPaidChangeLink<?php }?> list-action-enable <?php if ($_smarty_tpl->tpl_vars['document']->value->paid) {?>action-enabled<?php } else { ?>action-disabled<?php }?> label-tooltip"
                        		data-toggle="tooltip"
                        		<?php if ($_smarty_tpl->tpl_vars['document']->value->paid) {?>
                        		title="At <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['document']->value->payment_date),$_smarty_tpl);?>
 by <?php echo $_smarty_tpl->tpl_vars['document']->value->paid_employee_name;?>
"
                        		<?php }?>
	                      		>
	                      		<?php if ($_smarty_tpl->tpl_vars['document']->value->paid) {?>
	                      		<i class="icon-check"></i>
	                      		<?php } else { ?>
	                      		<i class="icon-remove"></i>
	                      		<?php }?>
	                      	</a>
                        </td>
                        <td class="documentPaid">
                        	<a href="#" 
                        		class="list-action-enable <?php if ($_smarty_tpl->tpl_vars['document']->value->shipped_products_only) {?>action-enabled<?php } else { ?>action-disabled<?php }?> label-tooltip"
                        		data-toggle="tooltip">
	                      		<?php if ($_smarty_tpl->tpl_vars['document']->value->shipped_products_only) {?>
	                      		<i class="icon-check"></i>
	                      		<?php } else { ?>
	                      		<i class="icon-remove"></i>
	                      		<?php }?>
	                      	</a>
                        </td>
                        <td class="dueDate"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['document']->value->due_date),$_smarty_tpl);?>
</td>
						<td class="text-right document_action">
                        <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
						<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
							<?php if (!isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>

								<?php if ($_smarty_tpl->tpl_vars['document']->value->getRestPaid()) {?>
									<a href="#formAddPaymentPanel" class="js-set-payment btn btn-default anchor" data-amount="<?php echo $_smarty_tpl->tpl_vars['document']->value->getRestPaid();?>
" data-id-invoice="<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
" title="<?php echo smartyTranslate(array('s'=>'Set payment form'),$_smarty_tpl);?>
">
										<i class="icon-money"></i>
										<?php echo smartyTranslate(array('s'=>'Enter payment'),$_smarty_tpl);?>

									</a>
								<?php }?>

								<a href="#" class="btn btn-default" onclick="$('#invoiceNote<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
').show(); return false;" title="<?php if ($_smarty_tpl->tpl_vars['document']->value->note=='') {?><?php echo smartyTranslate(array('s'=>'Add note'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Edit note'),$_smarty_tpl);?>
<?php }?>">
									<?php if ($_smarty_tpl->tpl_vars['document']->value->note=='') {?>
										<i class="icon-plus-sign-alt"></i>
										<?php echo smartyTranslate(array('s'=>'Add note'),$_smarty_tpl);?>

									<?php } else { ?>
										<i class="icon-pencil"></i>
										<?php echo smartyTranslate(array('s'=>'Edit note'),$_smarty_tpl);?>

									<?php }?>
								</a>

							<?php }?>
						<?php }?>
						<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderSlip') {?>
						<a href="<?php echo $_smarty_tpl->tpl_vars['current_index']->value;?>
&amp;viewOrder&amp;submitDeleteSlip&amp;order_slip_id=<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
&amp;id_order=<?php echo $_smarty_tpl->tpl_vars['order']->value->id;?>
<?php if (isset($_GET['token'])) {?>&amp;token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"><?php echo smartyTranslate(array('s'=>'delete'),$_smarty_tpl);?>
</a>
						<?php } else { ?>
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['current_index']->value;?>
&amp;viewOrder&amp;submitDeleteInvoice&amp;order_invoice_id=<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
&amp;id_order=<?php echo $_smarty_tpl->tpl_vars['order']->value->id;?>
<?php if (isset($_GET['token'])) {?>&amp;token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"><?php echo smartyTranslate(array('s'=>'delete'),$_smarty_tpl);?>
</a>
                                                <?php }?>
						<?php }?>
                        </td>
					</tr>
				<?php if (get_class($_smarty_tpl->tpl_vars['document']->value)=='OrderInvoice') {?>
					<?php if (!isset($_smarty_tpl->tpl_vars['document']->value->is_delivery)) {?>
					<tr id="invoiceNote<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
" style="display:none">
						<td colspan="5">
							<form action="<?php echo $_smarty_tpl->tpl_vars['current_index']->value;?>
&amp;viewOrder&amp;id_order=<?php echo $_smarty_tpl->tpl_vars['order']->value->id;?>
<?php if (isset($_GET['token'])) {?>&amp;token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" method="post">
								<p>
									<label for="editNote<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
" class="t"><?php echo smartyTranslate(array('s'=>'Note'),$_smarty_tpl);?>
</label>
									<input type="hidden" name="id_order_invoice" value="<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
" />
									<textarea name="note" id="editNote<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
" class="edit-note textarea-autosize"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['document']->value->note, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
								</p>
								<p>
									<button type="submit" name="submitEditNote" class="btn btn-default">
										<i class="icon-save"></i>
										<?php echo smartyTranslate(array('s'=>'Save'),$_smarty_tpl);?>

									</button>
									<a class="btn btn-default" href="#" id="cancelNote" onclick="$('#invoiceNote<?php echo $_smarty_tpl->tpl_vars['document']->value->id;?>
').hide();return false;">
										<i class="icon-remove"></i>
										<?php echo smartyTranslate(array('s'=>'Cancel'),$_smarty_tpl);?>

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
							<?php echo smartyTranslate(array('s'=>'There is no available document'),$_smarty_tpl);?>

						</div>
						<?php if (isset($_smarty_tpl->tpl_vars['invoice_management_active']->value)&&$_smarty_tpl->tpl_vars['invoice_management_active']->value&&$_smarty_tpl->tpl_vars['can_edit']->value) {?>
							<a class="btn btn-default" href="<?php echo $_smarty_tpl->tpl_vars['current_index']->value;?>
&amp;viewOrder&amp;submitGenerateInvoice&amp;id_order=<?php echo $_smarty_tpl->tpl_vars['order']->value->id;?>
<?php if (isset($_GET['token'])) {?>&amp;token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
								<i class="icon-repeat"></i>
								<?php echo smartyTranslate(array('s'=>'Generate invoice'),$_smarty_tpl);?>

							</a>
						<?php }?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php if (!isset($_smarty_tpl->tpl_vars['orderDocumentsOnlyTable']->value)&&$_smarty_tpl->tpl_vars['can_edit']->value) {?>
        <h2><?php echo smartyTranslate(array('s'=>'Add new invoice'),$_smarty_tpl);?>
</h2>
        <form method="post" id="addInoiceForm" action="<?php echo $_smarty_tpl->tpl_vars['current_index']->value;?>
&amp;vieworder&amp;submitAddInvoice&amp;id_order=<?php echo $_smarty_tpl->tpl_vars['order']->value->id;?>
<?php if (isset($_GET['token'])) {?>&amp;token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
            <input type="hidden" name="product_ids" value="" id="addInvoiceProductIds" />
            <input type="hidden" name="print_now" value="0" id="addInvoicePrintNow" />
            <button type="button" id="submitAddInvoice" class="btn btn-primary pull-right" name="submitAddInvoice" ><?php echo smartyTranslate(array('s'=>'Add'),$_smarty_tpl);?>
</button>
            <div style="overflow:auto">
                <div class="pull-right">
                <a href="#" class="btn btn-primary" id="cancelOrderPackageBtn"><?php echo smartyTranslate(array('s'=>'Cancel picking list'),$_smarty_tpl);?>
</a>&nbsp;
                <a href="#" class="btn btn-primary" id="showOrderPackageBtn"><?php echo smartyTranslate(array('s'=>'Show picking list'),$_smarty_tpl);?>
</a>&nbsp;&nbsp;
                </div>
            <select name="template_type" id="addInvoiceTypeSelector" autocomplete="off" style="width:auto; float:left;">
                <option value="1"><?php echo smartyTranslate(array('s'=>'Invoice'),$_smarty_tpl);?>
</option>
                <option value="2"><?php echo smartyTranslate(array('s'=>'Delivery'),$_smarty_tpl);?>
</option>
            </select>
            <select name="shipped_products_only" id="addInvoiceShippedProductsOnly" autocomplete="off" style="width:auto; float:left;">
                <option value="1"><?php echo smartyTranslate(array('s'=>'Shipped products only'),$_smarty_tpl);?>
</option>
                <option value="0"><?php echo smartyTranslate(array('s'=>'All products'),$_smarty_tpl);?>
</option>
            </select>
            <select name="invoice_template_id" id="addInvoiceInvoiceTemplateSel" style="width:auto; float:left;" autocomplete="off">
                <?php  $_smarty_tpl->tpl_vars['invoiceCategory'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invoiceCategory']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['invoiceTemplates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['invoiceCategory']->key => $_smarty_tpl->tpl_vars['invoiceCategory']->value) {
$_smarty_tpl->tpl_vars['invoiceCategory']->_loop = true;
?>
                    <optgroup label="<?php echo $_smarty_tpl->tpl_vars['invoiceCategory']->value['categoryName'];?>
">
                    <?php  $_smarty_tpl->tpl_vars['template'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['template']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['invoiceCategory']->value['templates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['template']->key => $_smarty_tpl->tpl_vars['template']->value) {
$_smarty_tpl->tpl_vars['template']->_loop = true;
?>
                    
                    <?php if (isset($_smarty_tpl->tpl_vars['optionStyle'])) {$_smarty_tpl->tpl_vars['optionStyle'] = clone $_smarty_tpl->tpl_vars['optionStyle'];
$_smarty_tpl->tpl_vars['optionStyle']->value = ''; $_smarty_tpl->tpl_vars['optionStyle']->nocache = null; $_smarty_tpl->tpl_vars['optionStyle']->scope = 0;
} else $_smarty_tpl->tpl_vars['optionStyle'] = new Smarty_variable('', null, 0);?>
                    <?php if (in_array($_smarty_tpl->tpl_vars['template']->value['id'],$_smarty_tpl->tpl_vars['suggestedInvoiceTemplates']->value)) {?>
                    <?php if (isset($_smarty_tpl->tpl_vars['optionStyle'])) {$_smarty_tpl->tpl_vars['optionStyle'] = clone $_smarty_tpl->tpl_vars['optionStyle'];
$_smarty_tpl->tpl_vars['optionStyle']->value = 'color:#00CC00'; $_smarty_tpl->tpl_vars['optionStyle']->nocache = null; $_smarty_tpl->tpl_vars['optionStyle']->scope = 0;
} else $_smarty_tpl->tpl_vars['optionStyle'] = new Smarty_variable('color:#00CC00', null, 0);?>
                    <?php }?>
                        <option style="<?php echo $_smarty_tpl->tpl_vars['optionStyle']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['template']->value['id'];?>
" data-require_vat="<?php echo $_smarty_tpl->tpl_vars['template']->value['require_vat'];?>
"
                          ><?php echo $_smarty_tpl->tpl_vars['template']->value['name'];?>
 (<?php echo $_smarty_tpl->tpl_vars['template']->value['id'];?>
)</option>
                    <?php } ?>
                    </optgroup>
                <?php } ?>
            </select>&nbsp;
             
            <select name="id_order_package" id="addInvoiceOrderPackageId">
            	<option value="0"><?php echo smartyTranslate(array('s'=>'No picking list, products selected manualy'),$_smarty_tpl);?>
</option>
            <?php  $_smarty_tpl->tpl_vars['order_package'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order_package']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order_packages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order_package']->key => $_smarty_tpl->tpl_vars['order_package']->value) {
$_smarty_tpl->tpl_vars['order_package']->_loop = true;
?>
            	<option value="<?php echo $_smarty_tpl->tpl_vars['order_package']->value['id_order_package'];?>
"
            	   >By <?php echo $_smarty_tpl->tpl_vars['order_package']->value['employee_name'];?>
 at <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['order_package']->value['date_add'],'full'=>true),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['order_package']->value['cancelled']) {?> (<?php echo smartyTranslate(array('s'=>'cancelled'),$_smarty_tpl);?>
)<?php }?></option>
            <?php } ?>
            </select>
            

            <select name="delivery_template_id" id="addInvoiceDeliveryTemplateSel" style="display:none;width:auto; float:left;"  autocomplete="off">
                <?php  $_smarty_tpl->tpl_vars['invoiceTplName'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invoiceTplName']->_loop = false;
 $_smarty_tpl->tpl_vars['invoiceTplId'] = new Smarty_Variable;
 $_from = OrderInvoice::getDeliveryTemplateNames(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['invoiceTplName']->key => $_smarty_tpl->tpl_vars['invoiceTplName']->value) {
$_smarty_tpl->tpl_vars['invoiceTplName']->_loop = true;
 $_smarty_tpl->tpl_vars['invoiceTplId']->value = $_smarty_tpl->tpl_vars['invoiceTplName']->key;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['invoiceTplId']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['invoiceTplName']->value;?>
</option>
                <?php } ?>
            </select>
            </div>
        </form>
            
       <h4><?php echo smartyTranslate(array('s'=>'Invoice text. Will be put in [orderInvoiceTxt] variable in invoice template'),$_smarty_tpl);?>
</h4>
        <form method="post" id="setInoiceTextForm" action="<?php echo $_smarty_tpl->tpl_vars['current_index']->value;?>
&amp;viewOrder&amp;submitSetInvoiceText&amp;id_order=<?php echo $_smarty_tpl->tpl_vars['order']->value->id;?>
<?php if (isset($_GET['token'])) {?>&amp;token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
            <textarea name="invoice_txt"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->invoice_txt, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
            <br/>
            <button id="submitSetInvoiceText" class="btn btn-primary pull-right" name="submitSetInvoiceText"><?php echo smartyTranslate(array('s'=>'Save'),$_smarty_tpl);?>
</button>
            <div class="clear"></div>
        </form>
        <form method="post" id="cancelOrderPackageForm" action="<?php echo $_smarty_tpl->tpl_vars['current_index']->value;?>
&amp;viewOrder&amp;submitCancelOrderPackage&amp;id_order=<?php echo $_smarty_tpl->tpl_vars['order']->value->id;?>
<?php if (isset($_GET['token'])) {?>&amp;token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
            <input type="hidden" name="order_package_id" />
            <input type="hidden" name="just_mark" value="0" />
        </form>
</div>

<script type="text/javascript">    
//<![CDATA[
    var textSave = '<?php echo smartyTranslate(array('s'=>'Save','js'=>'1'),$_smarty_tpl);?>
';
    var textCancel = '<?php echo smartyTranslate(array('s'=>'Cancel','js'=>'1'),$_smarty_tpl);?>
';
    var cancelOrderPackageText = '<?php echo smartyTranslate(array('s'=>'Should shipped marker be removed and stock corrected?','js'=>'1'),$_smarty_tpl);?>
';
//]]>
</script>
<?php }?><?php }} ?>
