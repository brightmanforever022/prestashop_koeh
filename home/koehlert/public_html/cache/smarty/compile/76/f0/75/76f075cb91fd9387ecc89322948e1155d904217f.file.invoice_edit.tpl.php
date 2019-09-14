<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 08:28:26
         compiled from "/home/koehlert/public_html/modules/ba_prestashop_invoice/views/templates/admin/order_invoice/invoice_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2570390875d5f878a696cd3-03654485%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76f075cb91fd9387ecc89322948e1155d904217f' => 
    array (
      0 => '/home/koehlert/public_html/modules/ba_prestashop_invoice/views/templates/admin/order_invoice/invoice_edit.tpl',
      1 => 1535098684,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2570390875d5f878a696cd3-03654485',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'invoiceTemplateArr' => 0,
    'invoiceTemplate' => 0,
    'toolBarBtn' => 0,
    'table' => 0,
    'btn' => 0,
    'k' => 0,
    'languages_select' => 0,
    'language' => 0,
    'templateCatsList' => 0,
    'categoryId' => 0,
    'templateCatIds' => 0,
    'categoryName' => 0,
    'payment_type_options' => 0,
    'payment_type_id' => 0,
    'payment_type_name' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5f878a8641a3_86475590',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5f878a8641a3_86475590')) {function content_5d5f878a8641a3_86475590($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/koehlert/public_html/tools/smarty/plugins/modifier.replace.php';
?>
<div class="panel">
	<div class="panel" style="float:left;width:100%;padding:0;">
		<div class="row"  id="sample_product_template" style="display:none;">
			<div class='product_template col-sm-12'>
				<div class="product_template_head"><i class="icon-th"></i> <span class="header_text"></span></div>
				<div class='form-group col-sm-6'>
					<label class='col-sm-3 control-label' style='text-align:right;'>Name column</label>
					<div class='col-sm-9'>
						<input type='text' name="colums_title[]"/>
					</div>
				</div>
				<div class='form-group col-sm-6'>
					<label class='col-sm-3 control-label' style='text-align:right;'>Content column</label>
					<div class='col-sm-9'>
						<select name="colums_content[]">
							<option value="1"><?php echo smartyTranslate(array('s'=>'Product name','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="13"><?php echo smartyTranslate(array('s'=>'Product Name with Customization','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
                                                        <option value="-1"><?php echo smartyTranslate(array('s'=>'Stock state (in stock)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="2"><?php echo smartyTranslate(array('s'=>'SKU','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="3"><?php echo smartyTranslate(array('s'=>'Unit Price(Tax Excl)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="4"><?php echo smartyTranslate(array('s'=>'Unit Price(Tax Incl) - Without Old Price','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="11"><?php echo smartyTranslate(array('s'=>'Unit Price(Tax Incl) - With Old Price','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="5"><?php echo smartyTranslate(array('s'=>'Product Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="6"><?php echo smartyTranslate(array('s'=>'Discounted','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="7"><?php echo smartyTranslate(array('s'=>'Qty','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="14"><?php echo smartyTranslate(array('s'=>'Total(Tax excl)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="8"><?php echo smartyTranslate(array('s'=>'Total(Tax Incl)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="9"><?php echo smartyTranslate(array('s'=>'Product Image','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="10"><?php echo smartyTranslate(array('s'=>'Tax Rate','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="12"><?php echo smartyTranslate(array('s'=>'Product Reference','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="15"><?php echo smartyTranslate(array('s'=>'Tax Name','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="16"><?php echo smartyTranslate(array('s'=>'Unit Price(Tax Excl) not Discount','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="17"><?php echo smartyTranslate(array('s'=>'Total(Tax Excl) not Discount','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
							<option value="18"><?php echo smartyTranslate(array('s'=>'Product Warehouse Location','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
						</select>
					</div>
				</div>
				<div class='form-group col-sm-6'>
					<label class='col-sm-3 control-label' style='text-align:right;'>Color title column</label>
					<div class='col-sm-2'>
						<input type='text' class='color' name="colums_color[]"/>
					</div>
				</div>
				<div class='form-group col-sm-6'>
					<label class='col-sm-3 control-label' style='text-align:right;'>Color background title column</label>
					<div class='col-sm-2'>
						<input type='text' class='color' name="colums_bgcolor[]"/>
					</div>
				</div>
			</div>
		</div>
		
		<form class="form-horizontal"  method="POST" id="form_template">
			<?php  $_smarty_tpl->tpl_vars['invoiceTemplate'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invoiceTemplate']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['invoiceTemplateArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['invoiceTemplate']->key => $_smarty_tpl->tpl_vars['invoiceTemplate']->value) {
$_smarty_tpl->tpl_vars['invoiceTemplate']->_loop = true;
?>
			<input type="hidden" name="id" id="id_invoice" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['id'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
			<div class="" style="padding:0 10px;width:100%;float:left;">
				<h3 class="col-sm-12" style="margin:0 !important;">
					<i class="icon-wrench"></i> <?php echo smartyTranslate(array('s'=>'General','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

					<span class="panel-heading-action">
						<?php  $_smarty_tpl->tpl_vars['btn'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['btn']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['toolBarBtn']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['btn']->key => $_smarty_tpl->tpl_vars['btn']->value) {
$_smarty_tpl->tpl_vars['btn']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['btn']->key;
?>
							<a id="desc-<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['table']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
-<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['imgclass'])) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['btn']->value['imgclass'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php } else { ?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>" class="list-toolbar-btn" <?php if (isset($_smarty_tpl->tpl_vars['btn']->value['href'])) {?>href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['btn']->value['href'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['btn']->value['target'])&&$_smarty_tpl->tpl_vars['btn']->value['target']) {?>target="_blank"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['btn']->value['js'])&&$_smarty_tpl->tpl_vars['btn']->value['js']) {?>onclick="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['btn']->value['js'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>
								<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo smartyTranslate(array('s'=>$_smarty_tpl->tpl_vars['btn']->value['desc'],'mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
" data-html="true">
									<i class="process-icon-<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['imgclass'])) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['btn']->value['imgclass'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php } else { ?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['btn']->value['class'])) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['btn']->value['class'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>" ></i>
								</span>
							</a>
						<?php } ?>
					</span>
				</h3>
				<div class="col-sm-12" style="margin-top:7px;">
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Invoice Name','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-3"><input type="text" name="nameInvoice" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"></div>
					</div>
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Invoice Description','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-3"><textarea name="descriptionInvoice"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['description'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</textarea></div>
					</div>
                                        <div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Sum to pay percent','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-3"><input type="text" name="sum_to_pay_percent" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['sum_to_pay_percent'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" size="6" style="width: auto; display: inline;" > %
                                                    <div class="help-block"><?php echo smartyTranslate(array('s'=>'Initial sum to pay in invoice document will be set based on this percent: invoiceAmount*sumToPayPercent','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</div>
                                                </div>
					</div>
                                        <div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Due date +','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-3"><input type="text" name="due_date_plus" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['due_date_plus'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" size="6" style="width: auto; display: inline;" >
                                                    <div class="help-block"><?php echo smartyTranslate(array('s'=>'Number of days to add to current date to get due date','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</div>
                                                </div>
					</div>
                                        <div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Auto set paid','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-5"><input type="checkbox" name="auto_set_paid" value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['auto_set_paid']==1) {?>checked=checked<?php }?>  autocomplete="off" /></div>
					</div>
                                        <div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Disable tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-5"><input type="checkbox" name="no_tax" value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['no_tax']==1) {?>checked=checked<?php }?>  autocomplete="off" /></div>
					</div>
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Show shipping in product list','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-5"><input type="checkbox" name="showShippingInProductList" value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['showShippingInProductList']=="Y") {?>checked=checked<?php }?>/></div>
					</div>
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Show discount in product list','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-5"><input type="checkbox" name="showDiscountInProductList" value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['showDiscountInProductList']=="Y") {?>checked=checked<?php }?>/></div>
					</div>
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Enable Landscape PDF','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-5"><input type="checkbox" name="baInvoiceEnableLandscape" value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['baInvoiceEnableLandscape']=="Y") {?>checked=checked<?php }?>/></div>
					</div>
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Show Pagination','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-5"><input type="checkbox" name="showPagination" value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['showPagination']=="Y") {?>checked=checked<?php }?>/></div>
					</div>
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Requires VAT ID','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-5"><input type="checkbox" name="require_vat" value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['require_vat']==1) {?>checked=checked<?php }?>/></div>
					</div>
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Ignore in agent commisions','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-5"><input type="checkbox" name="agentsales_ignore" value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['agentsales_ignore']==1) {?>checked=checked<?php }?>/></div>
					</div>
					
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Use for Admin or Client','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-8">
							<div class="col-sm-12"><input style="float:left;" type="radio" name="useAdminOrClient" value="0" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['useAdminOrClient']=="0") {?>checked=checked<?php }?>/><span style="margin-top:2px;display:block;"><?php echo smartyTranslate(array('s'=>'Admin and Client','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</span></div>
							<div class="col-sm-12"><input style="float:left;" type="radio" name="useAdminOrClient" value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['useAdminOrClient']=="1") {?>checked=checked<?php }?>/><span style="margin-top:2px;display:block;"><?php echo smartyTranslate(array('s'=>'Admin','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</span></div>
							<div class="col-sm-12"><input style="float:left;" type="radio" name="useAdminOrClient" value="2" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['useAdminOrClient']=="2") {?>checked=checked<?php }?>/><span style="margin-top:2px;display:block;"><?php echo smartyTranslate(array('s'=>'Client','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</span></div>
						</div>
					</div>
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Language','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-2">
							<select name="sel_language" id="sel_language">
								<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages_select']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
								<option <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['id_lang']==$_smarty_tpl->tpl_vars['language']->value['id_lang']) {?>selected<?php }?> value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Default','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-5">
							<span class="switch prestashop-switch fixed-width-lg">
								<input onclick="toggleDraftWarning(false);showOptions(true);showRedirectProductOptions(false);" type="radio" name="status" id="active_on" value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['status']==1) {?>checked<?php }?>>
								<label for="active_on" class="radioCheck">
									<?php echo smartyTranslate(array('s'=>'Yes','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

								</label>
								<input onclick="toggleDraftWarning(true);showOptions(false);showRedirectProductOptions(true);" type="radio" name="status" id="active_off" value="0" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['status']==0) {?>checked<?php }?>>
								<label for="active_off" class="radioCheck">
									<?php echo smartyTranslate(array('s'=>'No','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

								</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
					</div>
                                        <div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Category','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-5">
                                                    <?php  $_smarty_tpl->tpl_vars['categoryName'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categoryName']->_loop = false;
 $_smarty_tpl->tpl_vars['categoryId'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['templateCatsList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['categoryName']->key => $_smarty_tpl->tpl_vars['categoryName']->value) {
$_smarty_tpl->tpl_vars['categoryName']->_loop = true;
 $_smarty_tpl->tpl_vars['categoryId']->value = $_smarty_tpl->tpl_vars['categoryName']->key;
?>
                                                        <label class="text-nowrap"><input type="checkbox" name="tpl_cat_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['categoryId']->value;?>
" autocomplete="off" <?php if (in_array($_smarty_tpl->tpl_vars['categoryId']->value,$_smarty_tpl->tpl_vars['templateCatIds']->value)) {?>checked="checked" <?php }?>>&nbsp;<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['categoryName']->value,' ','&nbsp;');?>
&nbsp;&nbsp;</label>
                                                    <?php } ?>
						</div>
					</div>
					<div class="col-sm-12" style="margin-bottom: 10px;">
						<div class="col-sm-4 control-label" style="padding:0;font-size: 13px;"><?php echo smartyTranslate(array('s'=>'Invoice type','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
: </div>
						<div class="col-sm-2">
							<select name="payment_type" id="payment_type">
								<?php  $_smarty_tpl->tpl_vars['payment_type_name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['payment_type_name']->_loop = false;
 $_smarty_tpl->tpl_vars['payment_type_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['payment_type_options']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['payment_type_name']->key => $_smarty_tpl->tpl_vars['payment_type_name']->value) {
$_smarty_tpl->tpl_vars['payment_type_name']->_loop = true;
 $_smarty_tpl->tpl_vars['payment_type_id']->value = $_smarty_tpl->tpl_vars['payment_type_name']->key;
?>
								<option <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['payment_type']==$_smarty_tpl->tpl_vars['payment_type_id']->value) {?>selected<?php }?> value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['payment_type_id']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['payment_type_name']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
								<?php } ?>
							</select>
						</div>
					</div>
					
				</div>
				<h3 class="col-sm-12" style="margin:0;"><i class="icon-code"></i><?php echo smartyTranslate(array('s'=>'Tokens','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</h3>
				<div class="row list_token col-sm-12" rev="close" style="height:100px;overflow:hidden;margin-bottom: 20px;">
					<div class="ba_invoice_token_wrapper">
						<label>[customerDiscount]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Customer discount','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>

                                        <div class="ba_invoice_token_wrapper">
						<label>[customerId]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'id of customer (account number)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
                                        <div class="ba_invoice_token_wrapper">
						<label>[orderTotal_XX_te]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'XX% of order total with tax excluded. XX should be 2 digits.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
                                        <div class="ba_invoice_token_wrapper">
						<label>[orderTotal_XX_ti]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'XX% of order total with tax included.  XX should be 2 digits.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
                                        <div class="ba_invoice_token_wrapper">
						<label>[orderTotal_XX_VAT]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'VAT included in XX% of order total with tax included. XX should be 2 digits.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
                                        <div class="ba_invoice_token_wrapper">
						<label>[today+10]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Date 10 days in future from today','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
                                        <div class="ba_invoice_token_wrapper">
						<label>[orderInvoiceTxt]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Text from order details page','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[displayPDFInvoice]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'load Data from displayPDFInvoice HOOK','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[displayPDFDeliverySlip]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'load Data from displayPDFDeliverySlip HOOK','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[invoice_date]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'the date for create Invoice','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[invoice_number]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Invoice Number, ex: 000001','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[barcode_invoice_number]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'invoice number barcode','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[payment_transaction_id]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Transaction ID of invoice','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[gift_message]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Gift message of Order','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[gift_wrapping_cost]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Gift Wrapping of Order','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[cart_id]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Cart ID of Order','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<br/>
					
					<div class="ba_invoice_token_wrapper">
						<label>[order_number]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'The number of Order, ex: #OHSATSERP','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_date]</label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'The date for checkout','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_payment_method]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Name of Payment method for this Order','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_carrier]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Name of Carrier','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_subtotal]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Subtotal of Order include currency, ex:&nbsp;$73.90','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_shipping_cost]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Shipping Cost of Order, ex:&nbsp;$2.00','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_tax]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Tax of Order, ex: $1.50','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_discounted]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'The number of discounted Price','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_total]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Order total (include Tax, Shipping Cost, Discounted)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_total_not_discount_excl]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Order total (exclude Tax, Shipping Cost, No Discounted)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_total_not_discount_incl]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Order total (include Tax, Shipping Cost, No Discounted)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_notes]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'The notes of Order, ex: Lorem ipsum','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[order_message]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'The message of Order','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					
					<!--<div class="ba_invoice_token_wrapper">
						<label>[barcode_order_number]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'order number barcode','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>-->
					<br/>
					
					<div class="ba_invoice_token_wrapper">
						<label>[customer_email]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Email of Customer.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[customer_outstanding_amount]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Allowed outstanding amount of Customer.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[customer_max_payment_days]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Maximum number of payment days of Customer.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[customer_risk_rating]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Risk rating of Customer.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[customer_company]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Customer Company field.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[customer_siret]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Customer SIRET field.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[customer_ape]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Customer APE field.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[customer_website]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Customer Website field.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<br/>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_due_date]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Due Date of Invoice.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_firstname]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Firstname of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_lastname]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Lastname of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_company]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Company of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_address]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Address of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_address_line_2]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Address 2 of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_zipcode]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Postcode/zipcode of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_city]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'City of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_state]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'State of billing address.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_country]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Country of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_homephone]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Homephone of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_mobile_phone]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Mobile phone of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_additional_infomation]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Additional Infomation of Billing Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_vat_number]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'VAT Number of Billing Address','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[billing_dni]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE of Billing Address','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<br/>
					
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_firstname]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Firstname of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_lastname]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Lastname of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_company]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Company of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_address]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Address of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_address_line_2]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Address_2 of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_zipcode]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Zipcode/postcode of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_city]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'City of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_state]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'State of delivery address.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_country]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Country of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_homephone]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Homephone of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_mobile_phone]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Mobile of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_additional_infomation]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Additional Infomation of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_vat_number]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'VAT Number of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_dni]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE of Delivery (Shipping) Address when checkout.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[delivery_date]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Delivery (Shipping) date.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<br/>
					<div class="ba_invoice_token_wrapper">
						<label>[products_list]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'This token will be automatic replaced with products table which you can change columns, title,color... in Product Template section of our module.','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<br/>
					<div class="ba_invoice_token_wrapper">
						<label>[total_product_excl_tax]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total products in Order exclude Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[total_product_tax_rate]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Tax Rate of an Order','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[total_product_tax_amount]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total Tax Amount of an Order','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[total_product_incl_tax]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total products in Order include Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[shipping_cost_excl_tax]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total Shipping Cost exclude Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[shipping_cost_tax_rate]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Tax Rate of Shipping Cost','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[shipping_cost_tax_amount]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total Tax Amount of Shipping Cost','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[shipping_cost_incl_tax]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total Shipping Cost include Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[total_order_excl_tax]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total Order (amount) exclude Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[total_order_tax_amount]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total Tax (amount) = Products\'s Tax = Shipping\'s Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[total_order_incl_tax]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total Order (amount) include Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<br/>
					<div class="ba_invoice_token_wrapper">
						<label>[COD_fees_include]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total Order (amount) include Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[COD_fees_exclude]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total Order (amount) include Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[COD_tax]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total Order (amount) include Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[tax_table]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Show Tax Table','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[individual_tax_table]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Show Individual Tax Table','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[newsletter_table]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'display Table Yes/No if newsletter is enabled','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[discount_table]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Display Table all Discount in order','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[total_voucher_amount_tax_incl]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total all amount of Coupon/Voucher include TAX','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="ba_invoice_token_wrapper">
						<label>[total_voucher_amount_tax_excl]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Total all amount of Coupon/Voucher exclude TAX','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="payment_fee_incl">
						<label>[payment_fee_incl]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Payment Fees include Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="payment_fee_incl">
						<label>[payment_fee_excl]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Payment Fees exclude Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
					<div class="payment_fee_incl">
						<label>[payment_fee_tax_amount]: </label>
						<label class="control-label"><?php echo smartyTranslate(array('s'=>'Tax Amount applied to Payment Fees','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
					</div>
				</div>
				<div style="" id="show_list_token">
					More<br/>
					<i class="icon-double-angle-down"></i>
				</div>
				<h3 class="col-sm-12" style="margin:0 0 20px;"><?php echo smartyTranslate(array('s'=>'Template','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</h3>
				<div class="row" style="margin-bottom:10px">
					<div>
						<label class="col-sm-1 control-label" style="padding:0;"><?php echo smartyTranslate(array('s'=>'Header Template','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
						<div class="col-sm-10">
							<textarea id="header_invoice_template" class="rte" name="header_invoice_template"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['header_invoice_template'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</textarea>
						</div>
					</div>
				</div>
				<div class="row" style="margin-bottom:10px">
					<div>
						<label class="col-sm-1 control-label"><?php echo smartyTranslate(array('s'=>'Invoice Content','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
						<div class="col-sm-10">
							<textarea class="rte" name="invoice_template" id="invoice_template"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['invoice_template'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div>
						<label class="col-sm-1 control-label"><?php echo smartyTranslate(array('s'=>'Footer Template','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
						<div class="col-sm-10">
							<textarea class="rte" name="footer_invoice_template" id="footer_invoice_template"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['footer_invoice_template'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</textarea>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div>
						<label class="col-sm-1 control-label"><?php echo smartyTranslate(array('s'=>'Customize CSS','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
						<div class="col-sm-10">
							<textarea style="height:155px;" name="customize_css"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['customize_css'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</textarea>
						</div>
					</div>
				</div>
				<div class="product_template">
					<h3 style="float:left;width:100%;margin:0 0 10px;margin: 10px 0 15px;"><i class="icon-table"></i> Products list template</h3>
					<div class="number_column">
						<div class="form-group">
							<label class="col-sm-1 control-label"><?php echo smartyTranslate(array('s'=>'Numbber of table','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
							<div class="col-sm-10">
								<input type="text" id="numberColumnOfTableTemplaterPro" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['numberColumnOfTableTemplaterPro'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" name="numberColumnOfTableTemplaterPro" onchange="addColumn()">
							</div>
						</div>
					</div>
					
					<div id="product_list_columns">
						<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['invoiceTemplate']->value['numberColumnOfTableTemplaterPro'];?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_tmp1-1+1 - (0) : 0-($_tmp1-1)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
						<div class='product_template product_template_<?php echo $_smarty_tpl->tpl_vars['i']->value+mb_convert_encoding(htmlspecialchars(1, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 col-sm-12'>
							<div class="product_template_head"><i class="icon-th"></i> <span class="header_text">Column <?php echo $_smarty_tpl->tpl_vars['i']->value+mb_convert_encoding(htmlspecialchars(1, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span></div>
							<div class='form-group col-sm-6'>
								<label class='col-sm-3 control-label' style='text-align:right;'><?php echo smartyTranslate(array('s'=>'Name column','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
								<div class='col-sm-9'>
									<input type='text' name="colums_title[]" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsTitleJson'][$_smarty_tpl->tpl_vars['i']->value], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
								</div>
							</div>
							<div class='form-group col-sm-6'>
								<label class='col-sm-3 control-label' style='text-align:right;'><?php echo smartyTranslate(array('s'=>'Content column','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</label>
								<div class='col-sm-9'>
									<select name="colums_content[]">
										<option value="1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="1") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Product name','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="13" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="13") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Product Name with Customization','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
                                                                                <option value="-1" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="-1") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Stock state (in stock)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="2" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="2") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'SKU','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="3" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="3") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Unit Price(Tax Excl)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="4" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="4") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Unit Price(Tax Incl) - Without Old Price','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="11" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="11") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Unit Price(Tax Incl) - With Old Price','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="5" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="5") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Product Tax','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="6" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="6") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Discounted','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="7" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="7") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Qty','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="14" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="14") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Total(Tax Excl)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="8" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="8") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Total(Tax Incl)','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="9" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="9") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Product Image','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="10" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="10") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Tax Rate','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="12" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="12") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Product Reference','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="15" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="15") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Tax Name','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="16" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="16") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Unit Price(Tax Excl) not Discount','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="17" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="17") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Total(Tax Excl) not Discount','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
										<option value="18" <?php if ($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsContentJson'][$_smarty_tpl->tpl_vars['i']->value]=="18") {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Product Warehouse Location','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</option>
									</select>
								</div>
							</div>
							<div class='form-group col-sm-6'>
								<label class='col-sm-3 control-label' style='text-align:right;'>Color title column</label>
								<div class='col-sm-2'>
									<input type='text' class='color' name="colums_color[]" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsColorJson'][$_smarty_tpl->tpl_vars['i']->value], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
								</div>
							</div>
							<div class='form-group col-sm-6'>
								<label class='col-sm-3 control-label' style='text-align:right;'>Color background title column</label>
								<div class='col-sm-2'>
									<input type='text' class='color' name="colums_bgcolor[]" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['columsColorBgJson'][$_smarty_tpl->tpl_vars['i']->value], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
								</div>
							</div>
						</div>
						<?php }} ?>
					</div>
					<script>
						var sample_product;
						var init_table_colums=<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['invoiceTemplate']->value['numberColumnOfTableTemplaterPro'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
;
						function addColumn(){
							var numberColumn = parseInt(jQuery("#numberColumnOfTableTemplaterPro").val());	
							if(numberColumn>init_table_colums){
								//console.log(numberColumn);
								for(var i=init_table_colums+1; i<=numberColumn; i++){
									sample_product=$("#sample_product_template").clone();
									sample_product.find(".product_template").addClass("product_template_"+i);
									sample_product.find(".header_text").text("Columns "+i);
									$("#product_list_columns").append(sample_product.html());	
								}
								jscolor.bind();
							}else{
								for(var i=numberColumn+1; i<=init_table_colums; i++){
									$(".product_template_"+i).remove();
								}
							}
							////////////
							init_table_colums=numberColumn;
						}
						
						//Open and close token
						
						
					</script>
				</div>
				
			</div>
			<?php } ?>
			<div class="panel-footer">
				<button type="submit" value="1" name="submitBaCancel" class="btn btn-default pull-left">
					<i class="process-icon-cancel"></i> <?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

				</button>
				<button type="submit" value="1" name="submitBaSave" class="btn btn-default pull-right">
					<i class="process-icon-save"></i> <?php echo smartyTranslate(array('s'=>'Save','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

				</button>
				<button type="submit" value="1" name="submitBaSaveAndStay" class="btn btn-default pull-right">
					<i class="process-icon-save"></i> <?php echo smartyTranslate(array('s'=>'Save And Stay','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

				</button>
				<a id="preview_invoice" class="btn btn-default pull-right">
					<i class="process-icon-preview"></i> <?php echo smartyTranslate(array('s'=>'Preview','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

				</a>
			</div>
		</form>
	</div>
</div><?php }} ?>
