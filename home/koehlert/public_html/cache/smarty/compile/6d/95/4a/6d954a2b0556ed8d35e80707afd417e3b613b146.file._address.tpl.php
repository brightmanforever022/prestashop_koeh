<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_address.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20570179765d5ced92594d29-04950763%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d954a2b0556ed8d35e80707afd417e3b613b146' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_address.tpl',
      1 => 1481621681,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20570179765d5ced92594d29-04950763',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
    'can_edit' => 0,
    'current_index' => 0,
    'token' => 0,
    'customer_addresses' => 0,
    'address' => 0,
    'addresses' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced9261d698_41393995',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced9261d698_41393995')) {function content_5d5ced9261d698_41393995($_smarty_tpl) {?>
<div class="row">
	<ul class="nav nav-tabs" id="tabAddresses">
		<li class="active">
			<a href="#addressShipping">
				<i class="icon-truck"></i>
				<?php echo smartyTranslate(array('s'=>'Shipping address','mod'=>'orderedit'),$_smarty_tpl);?>

			</a>
		</li>
		<li>
			<a href="#addressInvoice">
				<i class="icon-file-text"></i>
				<?php echo smartyTranslate(array('s'=>'Invoice address','mod'=>'orderedit'),$_smarty_tpl);?>

			</a>
		</li>
	</ul>
	<div class="tab-content panel">
		<!-- Tab status -->
		<div class="tab-pane  in active" id="addressShipping">
			<!-- Addresses -->
			<h4 class="visible-print"><?php echo smartyTranslate(array('s'=>'Shipping address','mod'=>'orderedit'),$_smarty_tpl);?>
</h4>
			<?php if (!$_smarty_tpl->tpl_vars['order']->value->isVirtual()) {?>
			<!-- Shipping address -->
				<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
					<form class="form-horizontal hidden-print" method="post" id="addressShippingSubmitForm" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_index']->value, ENT_QUOTES, 'UTF-8', true);?>
&vieworder&token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
&id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
						<div class="form-group">
							<div class="col-lg-9">
								<select name="id_address" id="id_address_shipping">
									<?php  $_smarty_tpl->tpl_vars['address'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['address']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['customer_addresses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['address']->key => $_smarty_tpl->tpl_vars['address']->value) {
$_smarty_tpl->tpl_vars['address']->_loop = true;
?>
									<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['id_address'], ENT_QUOTES, 'UTF-8', true);?>
"
										<?php if ($_smarty_tpl->tpl_vars['address']->value['id_address']==$_smarty_tpl->tpl_vars['order']->value->id_address_delivery) {?>
											selected="selected"
										<?php }?>>
										<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['alias'], ENT_QUOTES, 'UTF-8', true);?>
 -
										<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['address1'], ENT_QUOTES, 'UTF-8', true);?>

										<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['postcode'], ENT_QUOTES, 'UTF-8', true);?>

										<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['city'], ENT_QUOTES, 'UTF-8', true);?>

										<?php if (!empty($_smarty_tpl->tpl_vars['address']->value['state'])) {?>
											<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['state'], ENT_QUOTES, 'UTF-8', true);?>

										<?php }?>,
										<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['country'], ENT_QUOTES, 'UTF-8', true);?>

									</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-lg-3">
								<button class="btn btn-default" type="submit" name="submitAddressShipping"><i class="icon-refresh"></i> <?php echo smartyTranslate(array('s'=>'Change','mod'=>'orderedit'),$_smarty_tpl);?>
</button>
							</div>
						</div>
					</form>
				<?php }?>
				<div class="well">
					<div class="row">
						<div class="col-sm-6">
							<a class="btn btn-default pull-right" href="?tab=AdminAddresses&amp;id_address=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['addresses']->value['delivery']->id, ENT_QUOTES, 'UTF-8', true);?>
&amp;addaddress&realedit=1&amp;id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
<?php if (($_smarty_tpl->tpl_vars['addresses']->value['delivery']->id==$_smarty_tpl->tpl_vars['addresses']->value['invoice']->id)) {?>&amp;address_type=1<?php }?>&amp;token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminAddresses'),$_smarty_tpl);?>
&back=<?php echo urlencode($_SERVER['REQUEST_URI']);?>
">
								<i class="icon-pencil"></i>
								<?php echo smartyTranslate(array('s'=>'Edit','mod'=>'orderedit'),$_smarty_tpl);?>

							</a>
							<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayAddressDetail'][0][0]->generateAddressSmarty(array('address'=>$_smarty_tpl->tpl_vars['addresses']->value['delivery'],'newLine'=>'<br />'),$_smarty_tpl);?>

							<?php if ($_smarty_tpl->tpl_vars['addresses']->value['delivery']->other) {?>
								<hr /><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['addresses']->value['delivery']->other, ENT_QUOTES, 'UTF-8', true);?>
<br />
							<?php }?>
						</div>
						<div class="col-sm-6 hidden-print">
							<div id="map-delivery-canvas" style="height: 190px"></div>
						</div>
					</div>
				</div>
			<?php }?>
		</div>
		<div class="tab-pane " id="addressInvoice">
			<!-- Invoice address -->
			<h4 class="visible-print"><?php echo smartyTranslate(array('s'=>'Invoice address','mod'=>'orderedit'),$_smarty_tpl);?>
</h4>
			<?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
				<form class="form-horizontal hidden-print" method="post" id="addressInvoiceSubmitForm" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_index']->value, ENT_QUOTES, 'UTF-8', true);?>
&vieworder&token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
&id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
					<div class="form-group">
						<div class="col-lg-9">
							<select name="id_address" id="id_address_invoice">
								<?php  $_smarty_tpl->tpl_vars['address'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['address']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['customer_addresses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['address']->key => $_smarty_tpl->tpl_vars['address']->value) {
$_smarty_tpl->tpl_vars['address']->_loop = true;
?>
								<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['id_address'], ENT_QUOTES, 'UTF-8', true);?>
"
									<?php if ($_smarty_tpl->tpl_vars['address']->value['id_address']==$_smarty_tpl->tpl_vars['order']->value->id_address_invoice) {?>
									selected="selected"
									<?php }?>>
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['alias'], ENT_QUOTES, 'UTF-8', true);?>
 -
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['address1'], ENT_QUOTES, 'UTF-8', true);?>

									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['postcode'], ENT_QUOTES, 'UTF-8', true);?>

									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['city'], ENT_QUOTES, 'UTF-8', true);?>

									<?php if (!empty($_smarty_tpl->tpl_vars['address']->value['state'])) {?>
										<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['state'], ENT_QUOTES, 'UTF-8', true);?>

									<?php }?>,
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value['country'], ENT_QUOTES, 'UTF-8', true);?>

								</option>
								<?php } ?>
							</select>
						</div>
						<div class="col-lg-3">
							<button class="btn btn-default" type="submit" name="submitAddressInvoice"><i class="icon-refresh"></i> <?php echo smartyTranslate(array('s'=>'Change','mod'=>'orderedit'),$_smarty_tpl);?>
</button>
						</div>
					</div>
				</form>
			<?php }?>
			<div class="well">
				<div class="row">
					<div class="col-sm-6">
						<a class="btn btn-default pull-right" href="?tab=AdminAddresses&amp;id_address=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['addresses']->value['invoice']->id, ENT_QUOTES, 'UTF-8', true);?>
&amp;addaddress&amp;realedit=1&amp;id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
<?php if (($_smarty_tpl->tpl_vars['addresses']->value['delivery']->id==$_smarty_tpl->tpl_vars['addresses']->value['invoice']->id)) {?>&amp;address_type=2<?php }?>&amp;back=<?php echo htmlspecialchars(urlencode($_SERVER['REQUEST_URI']), ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminAddresses'),$_smarty_tpl);?>
">
							<i class="icon-pencil"></i>
							<?php echo smartyTranslate(array('s'=>'Edit','mod'=>'orderedit'),$_smarty_tpl);?>

						</a>
						<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayAddressDetail'][0][0]->generateAddressSmarty(array('address'=>$_smarty_tpl->tpl_vars['addresses']->value['invoice'],'newLine'=>'<br />'),$_smarty_tpl);?>

						<?php if ($_smarty_tpl->tpl_vars['addresses']->value['invoice']->other) {?>
							<hr /><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['addresses']->value['invoice']->other, ENT_QUOTES, 'UTF-8', true);?>
<br />
						<?php }?>
					</div>
					<div class="col-sm-6 hidden-print">
						<div id="map-invoice-canvas" style="height: 190px"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#tabAddresses a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	})
</script>
<?php }} ?>
