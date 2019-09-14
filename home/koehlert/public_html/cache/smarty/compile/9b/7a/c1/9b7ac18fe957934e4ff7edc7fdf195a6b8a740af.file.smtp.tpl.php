<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/smtp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10235855415d5a47a8b35bd0-35250204%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9b7ac18fe957934e4ff7edc7fdf195a6b8a740af' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/smtp.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10235855415d5a47a8b35bd0-35250204',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'CONFIGURATION' => 0,
    'shop_email' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8b84117_01669710',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8b84117_01669710')) {function content_5d5a47a8b84117_01669710($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-smtp" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#smtp') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-smtp" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-smtp" style="display: none;">');
	} 
</script>
<?php }?>
	<h4><?php echo smartyTranslate(array('s'=>'SMTP Configuration','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>

	<div class="clearfix">

		<div class="form-group clearfix">
			<div class="col-sm-9 col-sm-offset-3">
				<div class="checkbox">
					<label for="smtp-active" class="in-win control-label">
						<input class="smtp-checkbox" type="checkbox" id="smtp-active" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['SMTP_ACTIVE']==1) {?>checked="checked"<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Activate Connection','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>
			</div>
		</div>

		<div class="form-group clearfix">
			<div class="col-sm-9 col-sm-offset-3">
				<div class="clearfix">
					<select id="select-smtp" class="fixed-width-xxl pull-left select-smtp" style="display: none;" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['SMTP_ACTIVE']==0) {?>disabled="disabled"<?php }?>></select>
				</div>
				<p class="help-block" style="margin-top: 10px;"><?php echo smartyTranslate(array('s'=>'Don\'t activate this option if you want to send newsletter with the default shop email configuration. By activating this option you will have to configure a new SMTP email.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
				<div class="clearfix">
					<span id="change-smtp-message"></span>
				</div>
			</div>
		</div>

		<div id="smpt-config-box" class="clearfix smpt-config-box" style="display: none;">

			<form id="smtpForm" method="POST">
				<input type="hidden" id="smpt-id" name="id_newsletter_pro_smtp" value="0">
				
				<div class="form-group clearfix" style="margin-bottom: 0;">
					<label class="required control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
					<div class="col-sm-9">
						<div class="clearfix">
							<input class="form-control fixed-width-xxl" type="text" size="30" id="smtp-name" name="name"> 
						</div>
						<p class="help-block"><?php echo smartyTranslate(array('s'=>'Alias name.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-sm-3" style="padding-top: 14px;"><?php echo smartyTranslate(array('s'=>'Method','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
					<div class="col-sm-9">
						<div class="clearfix">
							<div class="radio">
								<label for="method-smtp" class="in-win control-label">
									<input id="method-smtp" type="radio" name="method" value="2" checked>
									<?php echo smartyTranslate(array('s'=>'SMTP','mod'=>'newsletterpro'),$_smarty_tpl);?>

								</label>
							</div>
							<div class="radio">
								<label for="method-mail" class="in-win control-label">
									<input id="method-mail" type="radio" name="method" value="1">
									<?php echo smartyTranslate(array('s'=>'PHP mail() function','mod'=>'newsletterpro'),$_smarty_tpl);?>

								</label>
							</div>
						</div>
						<p class="help-block"><?php echo smartyTranslate(array('s'=>'Send method.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
					</div>
				</div>

				<?php ob_start();?><?php echo smartyTranslate(array('s'=>'List-Unsubscribe','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp45=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Add the list unsubscribe header.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp46=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp45,'description'=>$_tmp46,'label_id'=>'list_unsubscribe_active','label_name'=>'list_unsubscribe_active','input_onchange'=>'','is_checked'=>0), 0);?>


				<div id="smtp-list-unsubscribe-email-box" class="form-group clearfix" style="display: none;">
					<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'List-Unsubscribe Email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
					<div class="col-sm-9">
						<div class="clearfix">
							<input class="form-control fixed-width-xxl" type="text" size="30" id="smtp-list-unsubscribe-email" name="list_unsubscribe_email"> 
						</div>
						<p class="help-block"><?php echo smartyTranslate(array('s'=>'Email address.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'From name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
					<div class="col-sm-9">
						<div class="clearfix">
							<input class="form-control fixed-width-xxl" type="text" size="30" id="smtp-from-name" name="from_name"> 
						</div>
						<p class="help-block"><?php echo smartyTranslate(array('s'=>'Email from name. If it is empty the email from name will take the value of the current shop name.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="required control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'From email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
					<div class="col-sm-9">
						<div class="clearfix">
							<input class="form-control fixed-width-xxl" type="text" size="30" id="smtp-from-email" name="from_email"> 
						</div>
						<p class="help-block"><?php echo smartyTranslate(array('s'=>'From email address.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Reply to email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
					<div class="col-sm-9">
						<div class="clearfix">
							<input class="form-control fixed-width-xxl" type="text" size="30" id="smtp-reply-to" name="reply_to"> 
						</div>
						<p class="help-block"><?php echo smartyTranslate(array('s'=>'The customer can reply to your newsletter at the this email address.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
					</div>
				</div>

				<div id="smtp-only">

					<div class="form-group clearfix">
						<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Mail domain name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
						<div class="col-sm-9">
							<div class="clearfix">
								<input class="form-control fixed-width-xxl" type="text" size="30" id="smtp-domain" name="domain"> 
							</div>
							<p class="help-block"><?php echo smartyTranslate(array('s'=>'Fully qualified domain name (keep this field empty if you don\'t know).','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
						</div>
					</div>

					<div class="form-group clearfix">
						<label class="required control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'SMTP server','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
						<div class="col-sm-9">
							<div class="clearfix">
								<input class="form-control fixed-width-xxl" type="text" size="30" id="smtp-server" name="server"> 
							</div>
							<p class="help-block"><?php echo smartyTranslate(array('s'=>'IP address or server name (e.g. smtp.mydomain.com)','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
						</div>
					</div>

					<div class="form-group clearfix">
						<label class="required control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'SMTP user','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
						<div class="col-sm-9">
							<div class="clearfix">
								<input class="form-control fixed-width-xxl" type="text" size="30" id="smtp-user" name="user"> 
							</div>
							<p class="help-block"><?php echo smartyTranslate(array('s'=>'Put your email here (office@mywebsite.com).','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
						</div>
					</div>

					<div class="form-group clearfix">
						<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'SMTP password','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
						<div class="col-sm-9">
							<div class="clearfix">
								<input class="form-control fixed-width-xxl" type="password" size="30" id="smtp-passwd" name="passwd" value="" autocomplete="off"> 
							</div>
							<p class="help-block"><?php echo smartyTranslate(array('s'=>'Leave blank if not applicable.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
						</div>
					</div>

					<div class="form-group clearfix">
						<label class="required control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Encryption','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
						<div class="col-sm-9">
							<div class="clearfix">
								<select id="smtp-encryption" class="fixed-width-xxl gk-select" style="width: 45%" name="encryption" autocomplete="off"> 
									<option value="off">None</option> 
									<option value="tls">TLS</option> 
									<option value="ssl">SSL</option>
								</select>
							</div>
							<p class="help-block"><?php echo smartyTranslate(array('s'=>'Use an encrypt protocol','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
						</div>
					</div>

					<div class="form-group clearfix">
						<label class="required control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Port','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
						<div class="col-sm-9">
							<div class="clearfix">
								<input class="form-control fixed-width-xxl" type="text" size="5" id="smtp-port" name="port">
							</div>
							<p class="help-block"><?php echo smartyTranslate(array('s'=>'Port number to use','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
						</div>
					</div>

				</div>
	
				<div class="form-group clearfix">
					<div class="col-sm-9 col-sm-offset-3">
						<div class="form-group clearfix">
							<a id="save-smtp" href="javascript:{}" class="btn btn-default btn-margin pull-left">
								<i class="icon icon-save"></i> <?php echo smartyTranslate(array('s'=>'Save','mod'=>'newsletterpro'),$_smarty_tpl);?>

							</a>
							<a id="add-smtp" href="javascript:{}" class="btn btn-default btn-margin pull-left">
								<i class="icon icon-plus-square"></i> <?php echo smartyTranslate(array('s'=>'Add','mod'=>'newsletterpro'),$_smarty_tpl);?>

							</a>
							<a id="delete-smtp" href="javascript:{}" class="btn btn-default btn-margin pull-left">
								<i class="icon icon-remove"></i> <?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>

							</a>
							<span id="save-smtp-success" style="margin-left: 0;"></span>
						</div>
						<div class="clearfix">
							<div class="alert alert-danger" id="save-smtp-message" style="display: none;"></div>
						</div>
					</div>
				</div>

			</form>
		</div>

		<h4><?php echo smartyTranslate(array('s'=>'Test Connection','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
		<div class="separation"></div>

		<div class="form-group clearfix">
			<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Send a test email to','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
			<div class="col-sm-9">
				<div class="form-group form-inline">
					<div class="clearfix">
						<div class="form-group">
							<input class="form-control fixed-width-xxl" type="text" id="smtp-test-email" size="40" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_email']->value, ENT_QUOTES, 'UTF-8', true);?>
">
						</div>
						<div class="form-group">
							<a id="smtp-test-email-button" class="btn btn-default pull-left" href="javascript:{}">
								<span class="btn-ajax-loader"></span>
								<i class="icon icon-envelope"></i>
								<?php echo smartyTranslate(array('s'=>'Send an email test','mod'=>'newsletterpro'),$_smarty_tpl);?>

							</a>
						</div>
					</div>
					<div class="clearix">
						<p class="help-block">
							<?php echo smartyTranslate(array('s'=>'Send a test with the current connection. When you send the newsletter don\'t forget the verify the used connection by clicking on the button \"Performances & Limits\".','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</p>
					</div>
					<span id="smtp-test-email-success" style="display: none;"></span>
				</div>
				<div class="clearfix">
					<span id="smtp-test-email-message"></span>
				</div>
			</div>
		</div>

	</div>
</div><?php }} ?>
