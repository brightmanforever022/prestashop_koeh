<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:57
         compiled from "/home/koehlert/public_html/modules/orderedit/views/templates/admin/_configure/order_edit/helpers/view/view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19632004765d5ced91d9b501-63405405%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '37d93a8d066c7e30bcf45822e4dced83a01350ad' => 
    array (
      0 => '/home/koehlert/public_html/modules/orderedit/views/templates/admin/_configure/order_edit/helpers/view/view.tpl',
      1 => 1499232225,
      2 => 'file',
    ),
    'df39576aae3f7510caed0854c1f7310a951ae39a' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/helpers/view/view.tpl',
      1 => 1440056612,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19632004765d5ced91d9b501-63405405',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name_controller' => 0,
    'hookName' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced92112ae1_23985761',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced92112ae1_23985761')) {function content_5d5ced92112ae1_23985761($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/koehlert/public_html/tools/smarty/plugins/modifier.replace.php';
?>

<div class="leadin"></div>


	<script type="text/javascript">
	var admin_order_tab_link = "<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminOrders'));?>
";
	var id_order = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
;
	var id_lang = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_id_lang']->value, ENT_QUOTES, 'UTF-8', true);?>
;
	var id_currency = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id_currency, ENT_QUOTES, 'UTF-8', true);?>
;
	var id_customer = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id_customer, ENT_QUOTES, 'UTF-8', true);?>
;
	var id_shop = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id_shop, ENT_QUOTES, 'UTF-8', true);?>
;
	<?php if (isset($_smarty_tpl->tpl_vars['PS_TAX_ADDRESS_TYPE'])) {$_smarty_tpl->tpl_vars['PS_TAX_ADDRESS_TYPE'] = clone $_smarty_tpl->tpl_vars['PS_TAX_ADDRESS_TYPE'];
$_smarty_tpl->tpl_vars['PS_TAX_ADDRESS_TYPE']->value = Configuration::get('PS_TAX_ADDRESS_TYPE'); $_smarty_tpl->tpl_vars['PS_TAX_ADDRESS_TYPE']->nocache = null; $_smarty_tpl->tpl_vars['PS_TAX_ADDRESS_TYPE']->scope = 0;
} else $_smarty_tpl->tpl_vars['PS_TAX_ADDRESS_TYPE'] = new Smarty_variable(Configuration::get('PS_TAX_ADDRESS_TYPE'), null, 0);?>
	var id_address = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->{$_smarty_tpl->tpl_vars['PS_TAX_ADDRESS_TYPE']->value}, ENT_QUOTES, 'UTF-8', true);?>
;
	var currency_sign = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
";
	var currency_format = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->format, ENT_QUOTES, 'UTF-8', true);?>
";
	var currency_blank = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->blank, ENT_QUOTES, 'UTF-8', true);?>
";
	var priceDisplayPrecision = 2;
	var use_taxes = <?php if ($_smarty_tpl->tpl_vars['order']->value->getTaxCalculationMethod()==@constant('PS_TAX_INC')) {?>true<?php } else { ?>false<?php }?>;
	<?php if (isset($_smarty_tpl->tpl_vars['stock_management']->value)) {?>
	var stock_management = <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['stock_management']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
;
	<?php }?>
	var token = "<?php echo mb_convert_encoding(htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
	var weightUnit = "<?php echo htmlspecialchars(Configuration::get('PS_WEIGHT_UNIT'), ENT_QUOTES, 'UTF-8', true);?>
";

	var txt_add_product_stock_issue = "<?php echo smartyTranslate(array('s'=>'You want to add more product than are available in stock, are you sure you want to add this quantity?','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
";
	var txt_add_product_new_invoice = "<?php echo smartyTranslate(array('s'=>'Are you sure you want to create a new invoice?','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
";
	var txt_add_product_no_product = "<?php echo smartyTranslate(array('s'=>'Error: No product has been selected','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
";
	var txt_add_product_no_product_quantity = "<?php echo smartyTranslate(array('s'=>'Error: Quantity of product must be set','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
";
	var txt_add_product_no_product_price = "<?php echo smartyTranslate(array('s'=>'Error: Price of product must be set','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
";
	var txt_confirm = "<?php echo smartyTranslate(array('s'=>'Are you sure?','js'=>1,'mod'=>'orderedit'),$_smarty_tpl);?>
";
	var iem = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['iem']->value, ENT_QUOTES, 'UTF-8', true);?>
;
	var iemp = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['iemp']->value, ENT_QUOTES, 'UTF-8', true);?>
";
	var ajaxPath = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ajax_path']->value, ENT_QUOTES, 'UTF-8', true);?>
";
	var emailNotifyLabel = "<?php echo smartyTranslate(array('s'=>'Do you want to notify a customer that his/her order has been changed?','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
";
        var duplicateProductWarning = "<?php echo smartyTranslate(array('s'=>'Selected product is already in order. Please edit existing instance.','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
";
	var labelYes = "<?php echo smartyTranslate(array('s'=>'Yes','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
";
	var labelNo = "<?php echo smartyTranslate(array('s'=>'No','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
";
        var labelOk = "<?php echo smartyTranslate(array('s'=>'Ok','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
";
	var ordereditTranslate = {
		"This order already has an invoice": "<?php echo smartyTranslate(array('s'=>'This order already has an invoice','mod'=>'orderedit','js'=>1),$_smarty_tpl);?>
"
	};

	var statesShipped = new Array();
	<?php  $_smarty_tpl->tpl_vars['state'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['state']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['states']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['state']->key => $_smarty_tpl->tpl_vars['state']->value) {
$_smarty_tpl->tpl_vars['state']->_loop = true;
?>
		<?php if ((!$_smarty_tpl->tpl_vars['currentState']->value->shipped&&$_smarty_tpl->tpl_vars['state']->value['shipped'])) {?>
			statesShipped.push(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['state']->value['id_order_state'], ENT_QUOTES, 'UTF-8', true);?>
);
		<?php }?>
	<?php } ?>
	</script>

	<?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayInvoice",'id_order'=>$_smarty_tpl->tpl_vars['order']->value->id),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php if (isset($_smarty_tpl->tpl_vars["hook_invoice"])) {$_smarty_tpl->tpl_vars["hook_invoice"] = clone $_smarty_tpl->tpl_vars["hook_invoice"];
$_smarty_tpl->tpl_vars["hook_invoice"]->value = $_tmp1; $_smarty_tpl->tpl_vars["hook_invoice"]->nocache = null; $_smarty_tpl->tpl_vars["hook_invoice"]->scope = 0;
} else $_smarty_tpl->tpl_vars["hook_invoice"] = new Smarty_variable($_tmp1, null, 0);?>
	<?php if (($_smarty_tpl->tpl_vars['hook_invoice']->value)) {?>
	<div style="float: right; margin: -40px 40px 10px 0;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['hook_invoice']->value, ENT_QUOTES, 'UTF-8', true);?>
</div><br class="clear" />
	<?php }?>
	
	<style type="text/css">
		.fader {background: #eee;}
	</style>
	
	<div id="global_message_wrapper">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/message_placeholders/_global_message.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
	
	<div class="panel kpi-container">
		<div class="row">
			<div class="col-xs-6 col-sm-3 box-stats color3" >
				<div class="kpi-content">
					<i class="icon-calendar-empty"></i>
					<span class="title"><?php echo smartyTranslate(array('s'=>'Date','mod'=>'orderedit'),$_smarty_tpl);?>
</span>
					
					<div id="orderDateAdd" class="editable">
						<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
							<p class="customVal" style="display:none;">
								<span></span>
							</p>
						<?php }?>
						<p class="displayVal">
							<span class="order_dateadd_show "><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->date_add, ENT_QUOTES, 'UTF-8', true);?>
</span>
						</p>
						<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
							<p class="realVal" style="display:none;">
                                <span class="order_dateadd_edit">
                                    <input type="text" class="datetime_pick" id="order_dateadd" rel="orderDateadd" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->date_add, ENT_QUOTES, 'UTF-8', true);?>
" />
                                </span>
							</p>
						<?php }?>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3 box-stats color4" >
				<div class="kpi-content">
					<i class="icon-money"></i>
					<span class="title"><?php echo smartyTranslate(array('s'=>'Total','mod'=>'orderedit'),$_smarty_tpl);?>
</span>
					<span class="value"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['order']->value->total_paid_tax_incl,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3 box-stats color2" >
				<div class="kpi-content">
					<i class="icon-comments"></i>
					<span class="title"><?php echo smartyTranslate(array('s'=>'Messages','mod'=>'orderedit'),$_smarty_tpl);?>
</span>
					<span class="value"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminCustomerThreads'), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars(sizeof($_smarty_tpl->tpl_vars['customer_thread_message']->value), ENT_QUOTES, 'UTF-8', true);?>
</a></span>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3 box-stats color1" >
				<div class="kpi-content">
					<i class="icon-book"></i>
					<span class="title"><?php echo smartyTranslate(array('s'=>'Products','mod'=>'orderedit'),$_smarty_tpl);?>
</span>
					<span class="value"><?php echo htmlspecialchars(sizeof($_smarty_tpl->tpl_vars['products']->value), ENT_QUOTES, 'UTF-8', true);?>
</span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-7">
			<div class="panel">
				<div class="panel-heading">
					<i class="icon-credit-card"></i>
					<?php echo smartyTranslate(array('s'=>'Order','mod'=>'orderedit'),$_smarty_tpl);?>

					<span class="badge"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->reference, ENT_QUOTES, 'UTF-8', true);?>
</span>
					<span class="badge"><?php echo smartyTranslate(array('s'=>'#','mod'=>'orderedit'),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
</span>
					<div class="panel-heading-action">
						<div class="btn-group">
							<a class="btn btn-default" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminOrders'), ENT_QUOTES, 'UTF-8', true);?>
&vieworder&id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['previousOrder']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if (!$_smarty_tpl->tpl_vars['previousOrder']->value) {?>disabled<?php }?>>
								<i class="icon-backward"></i>
							</a>
							<a class="btn btn-default" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminOrders'), ENT_QUOTES, 'UTF-8', true);?>
&vieworder&id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['nextOrder']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if (!$_smarty_tpl->tpl_vars['nextOrder']->value) {?>disabled<?php }?>>
								<i class="icon-forward"></i>
							</a>
						</div>
					</div>
				</div>
				<ul class="nav nav-tabs" id="tabOrder">
					<li class="active">
						<a href="#status">
							<i class="icon-time"></i>
							<?php echo smartyTranslate(array('s'=>'Status','mod'=>'orderedit'),$_smarty_tpl);?>
 <span class="badge"><?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['history']->value), ENT_QUOTES, 'UTF-8', true);?>
</span>
						</a>
					</li>
					<li>
						<a href="#documents">
							<i class="icon-file-text"></i>
							<?php echo smartyTranslate(array('s'=>'Documents','mod'=>'orderedit'),$_smarty_tpl);?>
 <span class="badge"><?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['order']->value->getDocuments()), ENT_QUOTES, 'UTF-8', true);?>
</span>
						</a>
					</li>
				</ul>
				<div class="tab-content panel">
					<!-- Tab status -->
					<div class="tab-pane active" id="status">
						<h4 class="visible-print"><?php echo smartyTranslate(array('s'=>'Status','mod'=>'orderedit'),$_smarty_tpl);?>
 <span class="badge">(<?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['history']->value), ENT_QUOTES, 'UTF-8', true);?>
)</span></h4>
						<!-- History of status -->
						<div class="table-responsive">
							<table class="table history-status row-margin-bottom">
								<tbody>
									<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['history']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['row']->key;
?>
										<?php if (($_smarty_tpl->tpl_vars['key']->value==0)) {?>
											<tr>
												<td style="background-color:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['color'], ENT_QUOTES, 'UTF-8', true);?>
"><img src="../img/os/<?php echo intval($_smarty_tpl->tpl_vars['row']->value['id_order_state']);?>
.gif" /></td>
												<td style="background-color:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['color'], ENT_QUOTES, 'UTF-8', true);?>
;color:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['text-color'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo stripslashes($_smarty_tpl->tpl_vars['row']->value['ostate_name']);?>
</td>
												<td style="background-color:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['color'], ENT_QUOTES, 'UTF-8', true);?>
;color:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['text-color'], ENT_QUOTES, 'UTF-8', true);?>
"><?php if ($_smarty_tpl->tpl_vars['row']->value['employee_lastname']) {?><?php echo stripslashes($_smarty_tpl->tpl_vars['row']->value['employee_firstname']);?>
 <?php echo stripslashes($_smarty_tpl->tpl_vars['row']->value['employee_lastname']);?>
<?php }?></td>
												<td style="background-color:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['color'], ENT_QUOTES, 'UTF-8', true);?>
;color:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['text-color'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['row']->value['date_add'],'full'=>true),$_smarty_tpl);?>
</td>
											</tr>
										<?php } else { ?>
											<tr>
												<td><img src="../img/os/<?php echo intval($_smarty_tpl->tpl_vars['row']->value['id_order_state']);?>
.gif" /></td>
												<td><?php echo htmlspecialchars(stripslashes($_smarty_tpl->tpl_vars['row']->value['ostate_name']), ENT_QUOTES, 'UTF-8', true);?>
</td>
												<td><?php if ($_smarty_tpl->tpl_vars['row']->value['employee_lastname']) {?><?php echo htmlspecialchars(stripslashes($_smarty_tpl->tpl_vars['row']->value['employee_firstname']), ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars(stripslashes($_smarty_tpl->tpl_vars['row']->value['employee_lastname']), ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>&nbsp;<?php }?></td>
												<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['row']->value['date_add'],'full'=>true),$_smarty_tpl);?>
</td>
											</tr>
										<?php }?>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<div id="status_wrapper">
							<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_status.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						</div>
					</div>
					<!-- Tab documents -->
					<div class="tab-pane" id="documents">
						<h4 class="visible-print"><?php echo smartyTranslate(array('s'=>'Documents','mod'=>'orderedit'),$_smarty_tpl);?>
 <span class="badge">(<?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['order']->value->getDocuments()), ENT_QUOTES, 'UTF-8', true);?>
)</span></h4>
						<div id="documents_wrapper">
							<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_documents.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						</div>
					</div>
				</div>
				<script>
					$('#tabOrder a').click(function (e) {
						e.preventDefault()
						$(this).tab('show')
					})
				</script>
				<hr>
				<!-- Tab nav -->
				<ul class="nav nav-tabs" id="myTab">
					<li class="active">
						<a href="#shipping">
							<i class="icon-truck "></i>
							<?php echo smartyTranslate(array('s'=>'Shipping','mod'=>'orderedit'),$_smarty_tpl);?>
 <span class="badge"><?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['order']->value->getShipping()), ENT_QUOTES, 'UTF-8', true);?>
</span>
						</a>
					</li>
					<li>
						<a href="#returns">
							<i class="icon-undo"></i>
							<?php echo smartyTranslate(array('s'=>'Merchandise Returns','mod'=>'orderedit'),$_smarty_tpl);?>
 <span class="badge"><?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['order']->value->getReturn()), ENT_QUOTES, 'UTF-8', true);?>
</span>
						</a>
					</li>
				</ul>
				<!-- Tab content -->
				<div class="tab-content panel">
					<!-- Tab shipping -->
					<div class="tab-pane active" id="shipping">
						<h4 class="visible-print"><?php echo smartyTranslate(array('s'=>'Shipping','mod'=>'orderedit'),$_smarty_tpl);?>
 <span class="badge">(<?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['order']->value->getShipping()), ENT_QUOTES, 'UTF-8', true);?>
)</span></h4>
						<!-- Shipping block -->
						<?php if (!$_smarty_tpl->tpl_vars['order']->value->isVirtual()) {?>
						<div class="form-horizontal">
							<?php if ($_smarty_tpl->tpl_vars['order']->value->gift_message) {?>
							<div class="form-group">
								<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Message','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
								<div class="col-lg-9">
									<p class="form-control-static"><?php echo htmlspecialchars(nl2br($_smarty_tpl->tpl_vars['order']->value->gift_message), ENT_QUOTES, 'UTF-8', true);?>
</p>
								</div>
							</div>
							<?php }?>
							<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_shipping.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

							<?php if ($_smarty_tpl->tpl_vars['carrierModuleCall']->value) {?>
								<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['carrierModuleCall']->value, ENT_QUOTES, 'UTF-8', true);?>

							<?php }?>
						</div>
						<?php }?>
					</div>
					<!-- Tab returns -->
					<div class="tab-pane" id="returns">
						<h4 class="visible-print"><?php echo smartyTranslate(array('s'=>'Merchandise Returns','mod'=>'orderedit'),$_smarty_tpl);?>
 <span class="badge">(<?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['order']->value->getReturn()), ENT_QUOTES, 'UTF-8', true);?>
)</span></h4>
						<?php if (!$_smarty_tpl->tpl_vars['order']->value->isVirtual()) {?>
						<!-- Return block -->
							<?php if (count($_smarty_tpl->tpl_vars['order']->value->getReturn())>0) {?>
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th><span class="title_box ">Date</span></th>
											<th><span class="title_box ">Type</span></th>
											<th><span class="title_box ">Carrier</span></th>
											<th><span class="title_box ">Tracking number</span></th>
										</tr>
									</thead>
									<tbody>
										<?php  $_smarty_tpl->tpl_vars['line'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['line']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order']->value->getReturn(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['line']->key => $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
?>
										<tr>
											<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['date_add'], ENT_QUOTES, 'UTF-8', true);?>
</td>
											<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['type'], ENT_QUOTES, 'UTF-8', true);?>
</td>
											<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['state_name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
											<td class="actions">
												<span id="shipping_number_show"><?php if (isset($_smarty_tpl->tpl_vars['line']->value['url'])&&isset($_smarty_tpl->tpl_vars['line']->value['tracking_number'])) {?><a href="<?php echo htmlspecialchars(smarty_modifier_replace($_smarty_tpl->tpl_vars['line']->value['url'],'@',$_smarty_tpl->tpl_vars['line']->value['tracking_number']), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['tracking_number'], ENT_QUOTES, 'UTF-8', true);?>
</a><?php } elseif (isset($_smarty_tpl->tpl_vars['line']->value['tracking_number'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['tracking_number'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></span>
												<?php if ($_smarty_tpl->tpl_vars['line']->value['can_edit']) {?>
												<form method="post" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminOrders'), ENT_QUOTES, 'UTF-8', true);?>
&vieworder&id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
&id_order_invoice=<?php if ($_smarty_tpl->tpl_vars['line']->value['id_order_invoice']) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['id_order_invoice'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>0<?php }?>&id_carrier=<?php if ($_smarty_tpl->tpl_vars['line']->value['id_carrier']) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value['id_carrier'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>0<?php }?>">
													<span class="shipping_number_edit" style="display:none;">
														<button type="button" name="tracking_number">
															<?php echo htmlspecialchars(htmlentities($_smarty_tpl->tpl_vars['line']->value['tracking_number']), ENT_QUOTES, 'UTF-8', true);?>

														</button>
														<button type="submit" class="btn btn-default" name="submitShippingNumber">
															<?php echo smartyTranslate(array('s'=>'Update','mod'=>'orderedit'),$_smarty_tpl);?>

														</button>
													</span>
													<button href="#" class="edit_shipping_number_link">
														<i class="icon-pencil"></i>
														<?php echo smartyTranslate(array('s'=>'Edit','mod'=>'orderedit'),$_smarty_tpl);?>

													</button>
													<button href="#" class="cancel_shipping_number_link" style="display: none;">
														<i class="icon-remove"></i>
														<?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'orderedit'),$_smarty_tpl);?>

													</button>
												</form>
												<?php }?>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<?php } else { ?>
							<div class="list-empty hidden-print">
								<div class="list-empty-msg">
									<i class="icon-warning-sign list-empty-icon"></i>
									<?php echo smartyTranslate(array('s'=>'No merchandise returned yet','mod'=>'orderedit'),$_smarty_tpl);?>

								</div>
							</div>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['carrierModuleCall']->value) {?>
								<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['carrierModuleCall']->value, ENT_QUOTES, 'UTF-8', true);?>

							<?php }?>
						<?php }?>
					</div>
				</div>
				<script>
					$('#myTab a').click(function (e) {
						e.preventDefault()
						$(this).tab('show')
					})
				</script>
			</div>
			<div id="payment_wrapper">
				<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_payment.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
			<?php if (isset($_smarty_tpl->tpl_vars["or_cur"])) {$_smarty_tpl->tpl_vars["or_cur"] = clone $_smarty_tpl->tpl_vars["or_cur"];
$_smarty_tpl->tpl_vars["or_cur"]->value = Currency::getCurrency($_smarty_tpl->tpl_vars['order']->value->id_currency); $_smarty_tpl->tpl_vars["or_cur"]->nocache = null; $_smarty_tpl->tpl_vars["or_cur"]->scope = 0;
} else $_smarty_tpl->tpl_vars["or_cur"] = new Smarty_variable(Currency::getCurrency($_smarty_tpl->tpl_vars['order']->value->id_currency), null, 0);?>
			<?php if (isset($_smarty_tpl->tpl_vars["or_lang"])) {$_smarty_tpl->tpl_vars["or_lang"] = clone $_smarty_tpl->tpl_vars["or_lang"];
$_smarty_tpl->tpl_vars["or_lang"]->value = Language::getLanguage($_smarty_tpl->tpl_vars['order']->value->id_lang); $_smarty_tpl->tpl_vars["or_lang"]->nocache = null; $_smarty_tpl->tpl_vars["or_lang"]->scope = 0;
} else $_smarty_tpl->tpl_vars["or_lang"] = new Smarty_variable(Language::getLanguage($_smarty_tpl->tpl_vars['order']->value->id_lang), null, 0);?>

			<div>
				<div class="panel">
        			<div class="panel-heading">
                		<i class="icon-money"></i>
                		<?php echo smartyTranslate(array('s'=>'Order settings','mod'=>'orderedit'),$_smarty_tpl);?>

                	</div>

                	<div class="form-horizontal">
		                <div class="form-group">
							<label class="control-label col-lg-2" for="id_tax_rules_group">
								<?php echo smartyTranslate(array('s'=>'Order currency','mod'=>'orderedit'),$_smarty_tpl);?>

							</label>
							<div class="col-lg-8">
							<div class="row">
								<div class="editable">
									<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
									<p class="customVal" style="display:none;">
										<span></span>
									</p>
									<?php }?>
									<p class="displayVal">
										<span class="order_currency_show"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['or_cur']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
 <?php if (array_key_exists('sign',$_smarty_tpl->tpl_vars['or_cur']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['or_cur']->value['sign'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></span>
									</p>
									<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
									<p class="realVal" style="display:none;">
										<span class="order_currency_edit">
											<select name="order_currency" class="edit_order_currency payment_currency form-control fixed-width-xs pull-left" rel="productCurrencyEdit">
                                            <?php  $_smarty_tpl->tpl_vars['current_currency'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['current_currency']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['current_currency']->key => $_smarty_tpl->tpl_vars['current_currency']->value) {
$_smarty_tpl->tpl_vars['current_currency']->_loop = true;
?>
                                                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_currency']->value['id_currency'], ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['current_currency']->value['id_currency']==$_smarty_tpl->tpl_vars['currency']->value->id) {?> selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_currency']->value['sign'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                                            <?php } ?>
                                    		</select>
										</span>
									</p>
									<?php }?>
								</div>
							</div>
							</div>
						</div>
					</div>

					<div class="form-horizontal">
		                <div class="form-group">
							<label class="control-label col-lg-2" for="id_tax_rules_group">
								<?php echo smartyTranslate(array('s'=>'Order language','mod'=>'orderedit'),$_smarty_tpl);?>

							</label>
							<div class="col-lg-8">
							<div class="row">
								<div class="editable">
									<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
									<p class="customVal" style="display:none;">
										<span></span>
									</p>
									<?php }?>
									<p class="displayVal">
										<span class="order_language_show"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['or_lang']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</span>
									</p>
									<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
									<p class="realVal" style="display:none;">
										<span class="order_language_edit">
											<select name="order_language" class="edit_order_language form-control fixed-width-lg pull-left" rel="productLanguageEdit">
                                            <?php  $_smarty_tpl->tpl_vars['current_language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['current_language']->_loop = false;
 $_from = Language::getLanguages(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['current_language']->key => $_smarty_tpl->tpl_vars['current_language']->value) {
$_smarty_tpl->tpl_vars['current_language']->_loop = true;
?>
                                                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['current_language']->value['id_lang']==$_smarty_tpl->tpl_vars['order']->value->id_lang) {?> selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_language']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                                            <?php } ?>
                                    		</select>
										</span>
									</p>
									<?php }?>
								</div>
							</div>
							</div>
						</div>
					</div>

        		</div>
        	</div>

		</div>
		<div class="col-lg-5">
			<!-- Customer informations -->
			<div class="panel">
				<?php if ($_smarty_tpl->tpl_vars['customer']->value->id) {?>
					<div class="panel-heading">
						<i class="icon-user"></i>
						<?php echo smartyTranslate(array('s'=>'Customer','mod'=>'orderedit'),$_smarty_tpl);?>

						<span class="badge">
							<a href="?tab=AdminCustomers&amp;id_customer=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->id, ENT_QUOTES, 'UTF-8', true);?>
&amp;viewcustomer&amp;token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminCustomers'),$_smarty_tpl);?>
">
								<?php if (Configuration::get('PS_B2B_ENABLE')) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->company, ENT_QUOTES, 'UTF-8', true);?>
 - <?php }?>
								<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['gender']->value->name, ENT_QUOTES, 'UTF-8', true);?>

								<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>

								<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>

							</a>
						</span>
						<span class="badge">
							<?php echo smartyTranslate(array('s'=>'#','mod'=>'orderedit'),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->id, ENT_QUOTES, 'UTF-8', true);?>

						</span>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<?php if (($_smarty_tpl->tpl_vars['customer']->value->isGuest())) {?>
								<?php echo smartyTranslate(array('s'=>'This order has been placed by a guest.','mod'=>'orderedit'),$_smarty_tpl);?>

								<?php if ((!Customer::customerExists($_smarty_tpl->tpl_vars['customer']->value->email))) {?>
									<form method="post" action="index.php?tab=AdminCustomers&amp;id_customer=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->id, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminCustomers'),$_smarty_tpl);?>
">
										<input type="hidden" name="id_lang" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id_lang, ENT_QUOTES, 'UTF-8', true);?>
" />
										<input class="btn btn-default" type="submit" name="submitGuestToCustomer" value="<?php echo smartyTranslate(array('s'=>'Transform a guest into a customer','mod'=>'orderedit'),$_smarty_tpl);?>
" />
										<p class="help-block"><?php echo smartyTranslate(array('s'=>'This feature will generate a random password and send an email to the customer.','mod'=>'orderedit'),$_smarty_tpl);?>
</p>
									</form>
								<?php } else { ?>
									<div class="alert alert-warning">
										<?php echo smartyTranslate(array('s'=>'A registered customer account has already claimed this email address','mod'=>'orderedit'),$_smarty_tpl);?>

									</div>
								<?php }?>
							<?php } else { ?>
								<dl class="well list-detail">
									<dt><?php echo smartyTranslate(array('s'=>'Email','mod'=>'orderedit'),$_smarty_tpl);?>
</dt>
										<dd><a href="mailto:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->email, ENT_QUOTES, 'UTF-8', true);?>
"><i class="icon-envelope-o"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->email, ENT_QUOTES, 'UTF-8', true);?>
</a></dd>
									<dt><?php echo smartyTranslate(array('s'=>'Account registered','mod'=>'orderedit'),$_smarty_tpl);?>
</dt>
										<dd class="text-muted"><i class="icon-calendar-o"></i> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['customer']->value->date_add,'full'=>true),$_smarty_tpl);?>
</dd>
									<dt><?php echo smartyTranslate(array('s'=>'Valid orders placed','mod'=>'orderedit'),$_smarty_tpl);?>
</dt>
										<dd><span class="badge"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customerStats']->value['nb_orders'], ENT_QUOTES, 'UTF-8', true);?>
</span></dd>
									<dt><?php echo smartyTranslate(array('s'=>'Total spent since registration','mod'=>'orderedit'),$_smarty_tpl);?>
</dt>
										<dd><span class="badge badge-success"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice(Tools::ps_round(Tools::convertPrice($_smarty_tpl->tpl_vars['customerStats']->value['total_orders'],$_smarty_tpl->tpl_vars['currency']->value)),(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span></dd>
									<?php if (Configuration::get('PS_B2B_ENABLE')) {?>
										<dt><?php echo smartyTranslate(array('s'=>'Siret','mod'=>'orderedit'),$_smarty_tpl);?>
</dt>
											<dd><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->siret, ENT_QUOTES, 'UTF-8', true);?>
</dd>
										<dt><?php echo smartyTranslate(array('s'=>'APE','mod'=>'orderedit'),$_smarty_tpl);?>
</dt>
											<dd><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->ape, ENT_QUOTES, 'UTF-8', true);?>
</dd>
									<?php }?>
								</dl>
							<?php }?>
						</div>

						<div class="col-xs-6">
							<div class="form-group hidden-print">
								<a href="?tab=AdminCustomers&amp;id_customer=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->id, ENT_QUOTES, 'UTF-8', true);?>
&amp;viewcustomer&amp;token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminCustomers'),$_smarty_tpl);?>
" class="btn btn-default btn-block"><?php echo smartyTranslate(array('s'=>'View full details...','mod'=>'orderedit'),$_smarty_tpl);?>
</a>
							</div>
							<div class="panel panel-sm">
								<div class="panel-heading">
									<i class="icon-eye-slash"></i>
									<?php echo smartyTranslate(array('s'=>'Private note','mod'=>'orderedit'),$_smarty_tpl);?>

								</div>
								<form id="customer_note" class="form-horizontal" action="ajax.php" method="post" onsubmit="saveCustomerNote(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->id, ENT_QUOTES, 'UTF-8', true);?>
);return false;" >
									<div class="form-group">
										<div class="col-lg-12">
											<textarea name="note" id="noteContent" class="textarea-autosize" onkeyup="$(this).val().length > 0 ? $('#submitCustomerNote').removeAttr('disabled') : $('#submitCustomerNote').attr('disabled', 'disabled')"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customer']->value->note, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<button type="submit" id="submitCustomerNote" class="btn btn-default pull-right" disabled="disabled" />
												<i class="icon-save"></i>
												<?php echo smartyTranslate(array('s'=>'Save','mod'=>'orderedit'),$_smarty_tpl);?>

											</button>
										</div>
									</div>
									<span id="note_feedback"></span>
								</form>
							</div>
						</div>
					</div>
				<?php }?>
				<!-- Tab nav -->
				<div id="address_wrapper">
				
					<!-- Tab content -->
					
					<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_address.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


				</div>
			</div>
			<div class="panel">
				<div class="panel-heading">
					<i class="icon-envelope"></i> <?php echo smartyTranslate(array('s'=>'Messages','mod'=>'orderedit'),$_smarty_tpl);?>
 <span class="badge"><?php echo htmlspecialchars(sizeof($_smarty_tpl->tpl_vars['customer_thread_message']->value), ENT_QUOTES, 'UTF-8', true);?>
</span>
				</div>
				<?php if ((sizeof($_smarty_tpl->tpl_vars['messages']->value))) {?>
					<div class="panel panel-highlighted">
						<div class="message-item">
							<?php  $_smarty_tpl->tpl_vars['message'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['message']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['messages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['message']->key => $_smarty_tpl->tpl_vars['message']->value) {
$_smarty_tpl->tpl_vars['message']->_loop = true;
?>
								<div class="message-avatar">
									<div class="avatar-md">
										<i class="icon-user icon-2x"></i>
									</div>
								</div>
								<div class="message-body">
									
									<span class="message-date">&nbsp;<i class="icon-calendar"></i>
										<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['message']->value['date_add']),$_smarty_tpl);?>
 - 
									</span>
									<h4 class="message-item-heading">
										<?php if ((htmlspecialchars($_smarty_tpl->tpl_vars['message']->value['elastname'], ENT_QUOTES, 'UTF-8', true))) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['message']->value['efirstname'], ENT_QUOTES, 'UTF-8', true);?>

											<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['message']->value['elastname'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['message']->value['cfirstname'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['message']->value['clastname'], ENT_QUOTES, 'UTF-8', true);?>

										<?php }?>
										<?php if (($_smarty_tpl->tpl_vars['message']->value['private']==1)) {?>
											<span class="badge badge-info"><?php echo smartyTranslate(array('s'=>'Private','mod'=>'orderedit'),$_smarty_tpl);?>
</span>
										<?php }?>
									</h4>
									<p class="message-item-text">
										<?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['message']->value['message'], ENT_QUOTES, 'UTF-8', true));?>

									</p>
								</div>
								
							<?php } ?>
						</div>
					</div>
				<?php }?>
				<div id="messages" class="well hidden-print">
					<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
" method="post" onsubmit="if (getE('visibility').checked == true) return confirm('<?php echo smartyTranslate(array('s'=>'Do you want to send this message to the customer?','mod'=>'orderedit'),$_smarty_tpl);?>
');">
						<div id="message" class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Choose a standard message','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
								<div class="col-lg-9">
									<select class="chosen form-control" name="order_message" id="order_message" onchange="orderOverwriteMessage(this, '<?php echo smartyTranslate(array('s'=>'Do you want to overwrite your existing message?','mod'=>'orderedit'),$_smarty_tpl);?>
')">
										<option value="0" selected="selected">-</option>
										<?php  $_smarty_tpl->tpl_vars['orderMessage'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['orderMessage']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orderMessages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['orderMessage']->key => $_smarty_tpl->tpl_vars['orderMessage']->value) {
$_smarty_tpl->tpl_vars['orderMessage']->_loop = true;
?>
										<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['orderMessage']->value['message'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['orderMessage']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
										<?php } ?>
									</select>
									<p class="help-block">
										<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminOrderMessage'), ENT_QUOTES, 'UTF-8', true);?>
">
											<?php echo smartyTranslate(array('s'=>'Configure predefined messages','mod'=>'orderedit'),$_smarty_tpl);?>

											<i class="icon-external-link"></i>
										</a>
									</p>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Display to customer?','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
								<div class="col-lg-9">
									<span class="switch prestashop-switch fixed-width-lg">
										<input type="radio" name="visibility" id="visibility_on" value="0" />
										<label for="visibility_on">
											<?php echo smartyTranslate(array('s'=>'Yes','mod'=>'orderedit'),$_smarty_tpl);?>

										</label>
										<input type="radio" name="visibility" id="visibility_off" value="1" checked="checked" /> 
										<label for="visibility_off">
											<?php echo smartyTranslate(array('s'=>'No','mod'=>'orderedit'),$_smarty_tpl);?>

										</label>
										<a class="slide-button btn"></a>
									</span>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Message','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
								<div class="col-lg-9">
									<textarea id="txt_msg" class="textarea-autosize" name="message"><?php echo htmlspecialchars(Tools::getValue('message'), ENT_QUOTES, 'UTF-8', true);?>
</textarea>
									<p id="nbchars"></p>
								</div>
							</div>


							<input type="hidden" name="id_order" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" />
							<input type="hidden" name="id_customer" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id_customer, ENT_QUOTES, 'UTF-8', true);?>
" />
							<button type="submit" id="submitMessage" class="btn btn-primary pull-right" name="submitMessage">
								<?php echo smartyTranslate(array('s'=>'Send message','mod'=>'orderedit'),$_smarty_tpl);?>

							</button>
							<a class="btn btn-default" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminCustomerThreads'), ENT_QUOTES, 'UTF-8', true);?>
">
								<?php echo smartyTranslate(array('s'=>'Show all messages','mod'=>'orderedit'),$_smarty_tpl);?>

								<i class="icon-external-link"></i>
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php if (isset($_smarty_tpl->tpl_vars['ORLIQUE_HOOK_TOP']->value)) {?>
	<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ORLIQUE_HOOK_TOP']->value, ENT_QUOTES, 'UTF-8', true);?>

	<?php }?>

	<?php if (isset($_smarty_tpl->tpl_vars['ORLIQUE_HOOK_BEFORE_PRODUCT_LIST']->value)) {?>
	<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ORLIQUE_HOOK_BEFORE_PRODUCT_LIST']->value, ENT_QUOTES, 'UTF-8', true);?>

	<?php }?>
	<input type="hidden" id="notify_email_send" value="1" />
	<form class="container-command-top-spacing" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_index']->value, ENT_QUOTES, 'UTF-8', true);?>
&vieworder&token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
&id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" method="post" onsubmit="return orderDeleteProduct('<?php echo smartyTranslate(array('s'=>'Cannot return this product','mod'=>'orderedit'),$_smarty_tpl);?>
', '<?php echo smartyTranslate(array('s'=>'Quantity to cancel is greater than quantity available','mod'=>'orderedit'),$_smarty_tpl);?>
');">
		<input type="hidden" name="id_order" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" />
		<div class="panel">
			<div class="panel-heading">
				<i class="icon-shopping-cart"></i>
				<?php echo smartyTranslate(array('s'=>'Products','mod'=>'orderedit'),$_smarty_tpl);?>

			</div>
			<div style="display: none">
				<input type="hidden" value="<?php echo htmlspecialchars(implode($_smarty_tpl->tpl_vars['order']->value->getWarehouseList()), ENT_QUOTES, 'UTF-8', true);?>
" id="warehouse_list" />
			</div>
			<div id="product_list_errors_wrapper">
				<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/message_placeholders/_product_list_errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_product_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


			<div style="clear:both; height:15px;">&nbsp;</div>
			<div style="float: right; width: 160px; display: none;" class="standard_refund_fields">
				<?php if (($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()&&Configuration::get('PS_ORDER_RETURN'))) {?>
					<input type="checkbox" name="reinjectQuantities" class="button" />&nbsp;<label for="reinjectQuantities" style="float:none; font-weight:normal;"><?php echo smartyTranslate(array('s'=>'Re-stock products','mod'=>'orderedit'),$_smarty_tpl);?>
</label><br />
				<?php }?>
				<?php if (((!$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()&&$_smarty_tpl->tpl_vars['order']->value->hasBeenPaid())||($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()&&Configuration::get('PS_ORDER_RETURN')))) {?>
					<input type="checkbox" id="generateCreditSlip" name="generateCreditSlip" class="button" onclick="toggleShippingCost(this)" />&nbsp;<label for="generateCreditSlip" style="float:none; font-weight:normal;"><?php echo smartyTranslate(array('s'=>'Generate a credit slip','mod'=>'orderedit'),$_smarty_tpl);?>
</label><br />
					<input type="checkbox" id="generateDiscount" name="generateDiscount" class="button" onclick="toggleShippingCost(this)" />&nbsp;<label for="generateDiscount" style="float:none; font-weight:normal;"><?php echo smartyTranslate(array('s'=>'Generate a voucher','mod'=>'orderedit'),$_smarty_tpl);?>
</label><br />
					<span id="spanShippingBack" style="display:none;"><input type="checkbox" id="shippingBack" name="shippingBack" class="button" />&nbsp;<label for="shippingBack" style="float:none; font-weight:normal;"><?php echo smartyTranslate(array('s'=>'Repay shipping costs','mod'=>'orderedit'),$_smarty_tpl);?>
</label><br /></span>
				<?php }?>
				<?php if ((!$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()||($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()&&Configuration::get('PS_ORDER_RETURN')))) {?>
					<div style="text-align:center; margin-top:5px;">
						<input type="submit" name="cancelProduct" value="<?php if ($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()) {?><?php echo smartyTranslate(array('s'=>'Return products','mod'=>'orderedit'),$_smarty_tpl);?>
<?php } elseif ($_smarty_tpl->tpl_vars['order']->value->hasBeenPaid()) {?><?php echo smartyTranslate(array('s'=>'Refund products','mod'=>'orderedit'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Cancel products','mod'=>'orderedit'),$_smarty_tpl);?>
<?php }?>" class="button" style="margin-top:8px;" />
					</div>
				<?php }?>
			</div>
			<div style="float: right; width: 160px; display:none;" class="partial_refund_fields">
				<input type="checkbox" name="reinjectQuantities" class="button" />&nbsp;<label for="reinjectQuantities" style="float:none; font-weight:normal;"><?php echo smartyTranslate(array('s'=>'Re-stock products','mod'=>'orderedit'),$_smarty_tpl);?>
</label><br />
				<input type="checkbox" id="generateDiscountRefund" name="generateDiscountRefund" class="button" onclick="toggleShippingCost(this)" />&nbsp;<label for="generateDiscount" style="float:none; font-weight:normal;"><?php echo smartyTranslate(array('s'=>'Generate a voucher','mod'=>'orderedit'),$_smarty_tpl);?>
</label><br />
				<input type="submit" name="partialRefund" value="<?php echo smartyTranslate(array('s'=>'Partial refund','mod'=>'orderedit'),$_smarty_tpl);?>
" class="button" style="margin-top:8px;" />
			</div>
			
			<div class="panel-footer">
				<button type="button" class="btn btn-default pull-right" name="ordereditOrderSave">
					<i class="process-icon-save"></i> <?php echo smartyTranslate(array('s'=>'Save','mod'=>'orderedit'),$_smarty_tpl);?>

				</button>
			</div>
		</div>
	</form>


<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayAdminView'),$_smarty_tpl);?>

<?php if (isset($_smarty_tpl->tpl_vars['name_controller']->value)) {?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo ucfirst($_smarty_tpl->tpl_vars['name_controller']->value);?>
View<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php } elseif (isset($_GET['controller'])) {?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo htmlentities(ucfirst($_GET['controller']));?>
View<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
