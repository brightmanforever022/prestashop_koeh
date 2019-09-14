<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20476592005d5a47a89888a3-26644837%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21fb44067430f18c417eb52616e12c4126f52036' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/settings.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20476592005d5a47a89888a3-26644837',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'CONFIGURATION' => 0,
    'fwd_limit' => 0,
    'subscribe_hooks' => 0,
    'hook' => 0,
    'blocknewsletter_info' => 0,
    'sync_newsletter_block' => 0,
    'isPS16' => 0,
    'clear_cache' => 0,
    'controller_path' => 0,
    'log_files' => 0,
    'log' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8a90216_21534381',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8a90216_21534381')) {function content_5d5a47a8a90216_21534381($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-settings" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#settings') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-settings" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-settings" style="display: none;">');
	} 
</script>
<?php }?>
	<div class="settings">
		<h4><?php echo smartyTranslate(array('s'=>'Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
		<div class="separation"></div>

		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display only subscribed emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp19=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'If this option is "yes", only users has subscribed at newsletter will be visible in "Send newsletters" tab, else all users will be visible.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp20=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp19,'description'=>$_tmp20,'label_id'=>'view_active_only','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.viewActiveOnly( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['VIEW_ACTIVE_ONLY']), 0);?>


		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Convert CSS to Inline Style','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp21=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'If this option is activated, the header style from the newsletter templates will be converted to inline style when you send a newsletter. This help the newsletter to be displayed properly into the client email.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp22=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp21,'description'=>$_tmp22,'label_id'=>'convert_css_to_inline_style','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.convertCssToInlineStyle( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['CONVERT_CSS_TO_INLINE_STYLE']), 0);?>


		<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PS_REWRITING_SETTINGS']==1) {?>
			<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Product Friendly URL','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp23=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Enable only if your server allows URL rewriting. In some cases this option do not works properly ( disable is recommended ).','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp24=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp23,'description'=>$_tmp24,'label_id'=>'product_friendly_url','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.productFriendlyURL( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['PRODUCT_LINK_REWRITE']), 0);?>

		<?php }?>

		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display only active products','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp25=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'If the option is "yes" you will display only products that are active in the search list.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp26=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp25,'description'=>$_tmp26,'label_id'=>'display_only_active_products','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.displayOnliActiveProducts( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['ONLY_ACTIVE_PRODUCTS']), 0);?>


		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Customer Account Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp27=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Enable or disable the customer account newsletter pro settings.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp28=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp27,'description'=>$_tmp28,'label_id'=>'displya_my_account_np_settings','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.displayCustomerAccountSettings( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['DISPLYA_MY_ACCOUNT_NP_SETTINGS']), 0);?>


		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Subscribe by category','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp29=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Allow each customer to subscribe by a category of interest. Then the employee can filter the customers by their categories of interests.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp30=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp29,'description'=>$_tmp30,'label_id'=>'subscribe_by_category','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.subscribeByCategory( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['SUBSCRIBE_BY_CATEGORY']), 0);?>
 

		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Subscribe by List Of Interest','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp31=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Allow each customer to subscribe by a category of interest. Then the employee can filter the customers by their list of interests.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp32=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp31,'description'=>$_tmp32,'label_id'=>'subscribe_by_c_list_of_interest','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.subscribeByCListOfInterest( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['CUSTOMER_SUBSCRIBE_BY_LOI']), 0);?>
 

		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Send the last newsletter on subscribe','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp33=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Send the last newsletter when a customer create a new account. If a newsletter is send more then 10 people then it becomes the last newsletter send.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp34=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp33,'description'=>$_tmp34,'label_id'=>'sendnewsletter_on_subscribe','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.sendNewsletterOnSubscribe( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['SEND_NEWSLETTER_ON_SUBSCRIBE']), 0);?>
 

		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Forwarding Feature Active','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp35=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'This feature allow your customers to forward the newsletter to this friends. The friends can also forward the newsletter to other friends. Each recipient has a forward limit of %s friends. This option is available in the templates only with of use of the {forward} or {forward_link} variables.','sprintf'=>$_smarty_tpl->tpl_vars['fwd_limit']->value,'mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp36=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp35,'description'=>$_tmp36,'label_id'=>'forwaring_on_subscribe','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.forwardingFeatureActive( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['FWD_FEATURE_ACTIVE']), 0);?>
 

		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Embed Newsletter Images','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp37=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Embed images in your newsletter. You can embed files from a URL if allow_url_fopen is on in php.ini.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp38=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp37,'description'=>$_tmp38,'label_id'=>'send_embeded_images','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.sendEmbededImagesActive( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['SEND_EMBEDED_IMAGES']), 0);?>


		<div class="form-group clearfix">
			<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Front Subscribe Feature Options','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
			
			<div class="col-sm-9 table-bordered" style="border-left: none; border-right: none;">
				<div class="form-group clearfix">

					<div class="alert alert-info" style="margin-bottom: 0;">
						<?php echo smartyTranslate(array('s'=>'Here you can setup the subscription at the newsletter in the front office. This option allow you to collect more informations about your customers (first name, last name, language, birthday, gender).','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</div>

					<div class="form-group clearfix">
						<label class="control-label col-sm-3" style="padding-top: 14px;"><?php echo smartyTranslate(array('s'=>'Subscription by the module','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
						<div class="col-sm-9">
							<div class="radio">
								<label for="newsletter-pro-subscribe-settings" class="control-label in-win">
									<input id="newsletter-pro-subscribe-settings" type="radio" name="newsletterproSubscriptionActive" onchange="NewsletterPro.modules.settings.newsletterproSubscriptionOption($(this));" value="1" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['SUBSCRIPTION_ACTIVE']==1) {?> checked <?php }?>> 
									<?php echo smartyTranslate(array('s'=>'Newsletter Pro','mod'=>'newsletterpro'),$_smarty_tpl);?>

								</label>
							</div>
							<div class="radio">
							 	<label for="block-newsletter-subscribe-settings" class="control-label in-win">
							 		<input id="block-newsletter-subscribe-settings" type="radio" name="newsletterproSubscriptionActive" onchange="NewsletterPro.modules.settings.newsletterproSubscriptionOption($(this));" value="0"  <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['SUBSCRIPTION_ACTIVE']==0) {?> checked <?php }?>>
							 		<?php echo smartyTranslate(array('s'=>'Block Newsletter (Prestashop Default)','mod'=>'newsletterpro'),$_smarty_tpl);?>

							 	</label>
							</div>
						</div>
					</div>

					<div class="form-group clearfix">
						<div id="newsletter-pro-subscribe-options" style="<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['SUBSCRIPTION_ACTIVE']==0) {?> display:none; <?php }?>">
							<?php if (count($_smarty_tpl->tpl_vars['subscribe_hooks']->value)>0) {?>
								<div class="input-group clearfix">
									<p class="help-block"><?php echo smartyTranslate(array('s'=>'Check the hooks from the list in which you want to install the newsletter subscription option.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
								</div>
								<?php  $_smarty_tpl->tpl_vars['hook'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hook']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['subscribe_hooks']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['hook']->key => $_smarty_tpl->tpl_vars['hook']->value) {
$_smarty_tpl->tpl_vars['hook']->_loop = true;
?>
									<div class="clearfix">
										<div class="checkbox" style="margin-top: 0;">
											<label for="hook_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['hook']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" class="control-label in-row radio-label">
												<input id="hook_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['hook']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" class="checkbox-input" type="checkbox" name="hook_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['hook']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['hook']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['hook']->value['isRegistred']==1) {?> checked <?php }?>> 
												<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['hook']->value['name'], ENT_QUOTES, 'UTF-8', true);?>

											</label>
										</div>
									</div>
								<?php } ?>
							<?php }?>
							<div class="clearfix">
								<p class="help-block"><?php echo smartyTranslate(array('s'=>'Don\'t forget to check, add and update the module front hooks position after you activate this option.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
							</div>
							<?php if ($_smarty_tpl->tpl_vars['blocknewsletter_info']->value['isInstalled']) {?>
								<a href="javascript:{}" class="btn btn-default" onclick="NewsletterPro.modules.settings.importEmailsFromBlockNewsletter($(this));"><span class="btn-ajax-loader"></span><i class="icon icon-upload"></i> <?php echo smartyTranslate(array('s'=>'Import Email Addresses','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
								<div class="clearfix">
									<p class="help-block"><?php echo smartyTranslate(array('s'=>'Import the email addresses from the Block Newsletter module to the Newsletter Pro Subscription feature.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
								</div>

								<div class="alert alert-info clearfix">
									<p style="margin-top: 0;" class="cron-link"><span style="color: black;">CRON URL:</span> <span class="icon-cron-link"></span><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['sync_newsletter_block']->value);?>
</p>
									<p style="margin-top: 0;"><?php echo smartyTranslate(array('s'=>'Synchronize all the users list before to setup the CRON job.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
								</div>
							<?php }?>

							<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Email Confirmation on Subscribe (Secure Subscribe)','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp39=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'This option will send a confirmation email at, where the visitor will confirm the subscription.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp40=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp39,'description'=>$_tmp40,'label_id'=>'subscription_secure_subscribe','label_name'=>'','input_onchange'=>'NewsletterPro.modules.settings.subscriptionSecureSubscribe($(this));','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['SUBSCRIPTION_SECURE_SUBSCRIBE']), 0);?>
 
								
							<div class="clearfix">
								<a href="javascript:{}" class="btn btn-default" onclick="NewsletterPro.modules.settings.clearSubscribersTemp($(this));"><span class="btn-ajax-loader"></span><i class="icon icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Clear Emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
							</div>
							<div class="clearfix">
								<p class="help-block"><?php echo smartyTranslate(array('s'=>'Clear the older emails that did not confirm the subscription at the newsletter.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
							</div>
						</div>

						<div class="clearfix">
							<div class="clearfix">
								<p class="help-block"><?php echo smartyTranslate(array('s'=>'You can\'t use the both methods. If you choose the option Newsletter Pro the Block Newsletter module will be disabled.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
							</div>
							<a href="javascript:{}" class="btn btn-success" onclick="NewsletterPro.modules.settings.newsletterproSubscriptionActive();"><span class="btn-ajax-loader"></span> <i class="icon icon-save"></i> <?php echo smartyTranslate(array('s'=>'Save Subscription Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
							<div class="clearfix">
								<p class="help-block" style="margin-top: 5px;"><?php echo smartyTranslate(array('s'=>'Save the subscription settings. Press this button only if you change the subscription module option, or if you want to register the newsletterpro module to a new hook.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		
		<?php if ($_smarty_tpl->tpl_vars['isPS16']->value) {?>
		<div id="np-top-shortcuts" class="form-group">
			<label class="control-label col-sm-3" style="padding-top: 13px;"><?php echo smartyTranslate(array('s'=>'Top Shortcuts','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
			<div class="col-sm-9">
				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="CSV" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['CSV']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Import & Export','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="MANAGE_IMAGES" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['MANAGE_IMAGES']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Manage Images','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="SELECT_PRODUCTS" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['SELECT_PRODUCTS']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Select Products','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="CREATE_TEMPLATE" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['CREATE_TEMPLATE']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Create Template','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="SEND_NEWSLETTERS" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['SEND_NEWSLETTERS']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Send Newsletters','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="TASK" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['TASK']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Tasks','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="HISTORY" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['HISTORY']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'History','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="STATISTICS" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['STATISTICS']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Statistics','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="CAMPAIGN" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['CAMPAIGN']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Campaign Statistics','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="SMTP" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['SMTP']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'E-mail Configuration','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="MAILCHIMP" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['MAILCHIMP']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Mail Chimp','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="FORWARD" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['FORWARD']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Forwarders','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="FRONT_SUBSCRIPTION" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['FRONT_SUBSCRIPTION']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Front Subscription','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="SETTINGS" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['SETTINGS']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

				<div class="checkbox">
					<label class="control-label in-win">
						<input type="checkbox" value="TUTORIALS" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PAGE_HEADER_TOOLBAR']['TUTORIALS']) {?>checked<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Tutorials','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>

			</div>
		</div>
		<?php }?>

		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Debug Mode','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp41=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'This option should be "No" in a production website. This option will enable/disable the smarty force compilation that can cause errors to the compilation process. This option will override the default force compilation option, only for the module pages.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp42=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp41,'description'=>$_tmp42,'label_id'=>'debug_mode','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.debugMode( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['DEBUG_MODE']), 0);?>
 

		<?php if (isset($_smarty_tpl->tpl_vars['clear_cache']->value)&&$_smarty_tpl->tpl_vars['clear_cache']->value==true) {?>
			<div class="form-group clearfix">
				<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Smarty','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-9">
					<div class="clearfix">
						<a class="btn btn-default" href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['controller_path']->value);?>
&recompileTemplates#settings"><span class="icon icon-eraser"></span> <?php echo smartyTranslate(array('s'=>'Clear Cache','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
					</div>
					<p class="help-block"><?php echo smartyTranslate(array('s'=>'Press this button after you made an update to the module. This button will clear the shop cache.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
				</div>
			</div>
		<?php }?>

		<?php if (!empty($_smarty_tpl->tpl_vars['log_files']->value)) {?>
			<div class="form-group clearfix">
				<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Logs','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-9">
					<div class="clearfix">
						<?php  $_smarty_tpl->tpl_vars['log'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['log']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['log_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['log']->key => $_smarty_tpl->tpl_vars['log']->value) {
$_smarty_tpl->tpl_vars['log']->_loop = true;
?>
							<a class="btn btn-default np-btn-open-log-file" href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['log']->value['path']);?>
" target="_blank" style="margin-top: 0; margin-right: 5px;">
								<span class="btn-ajax-loader"></span>
								<i class="icon icon-info"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['log']->value['name'], ENT_QUOTES, 'UTF-8', true);?>

							</a>
						<?php } ?>
						<a class="btn btn-default" href="javascript:{}" onclick="NewsletterPro.modules.settings.clearLogFiles($(this));" style="margin-top: 0; float: right;"><span class="btn-ajax-loader"></span> <span class="icon icon-eraser"></span> <?php echo smartyTranslate(array('s'=>'Clear Log','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
					</div>
					<p class="help-block"><?php echo smartyTranslate(array('s'=>'View the log files.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
				</div>
			</div>
		<?php }?>

		<div class="form-group clearfix">
			<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Databse Backup','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
			<div class="col-sm-9">
				<div class="clearfix">
					<a id="module-create-backup-button" class="btn btn-default" href="javascript:{}"><span class="btn-ajax-loader"></span> <span class="icon icon-database"></span> <?php echo smartyTranslate(array('s'=>'Create Backup','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
					<a id="module-load-backup-button" class="btn btn-default" href="javascript:{}"><span class="btn-ajax-loader"></span> <span class="icon icon-database"></span> <?php echo smartyTranslate(array('s'=>'Restore','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				</div>
				<p class="help-block"><?php echo smartyTranslate(array('s'=>'Create a module database backup.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
			</div>
		</div>
	
		<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Use Cache','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp43=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Use Newsletter Pro cache.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp44=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp43,'description'=>$_tmp44,'label_id'=>'use_cache','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.useCache( $(this) );','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['USE_CACHE']), 0);?>


		<div class="form-group clearfix">
			<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Module Cache','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
			<div class="col-sm-9">
				<div class="clearfix">
					<a id="pqnp-clear-module-cache" class="btn btn-default" href="javascript:{}"><span class="icon icon-eraser"></span> <?php echo smartyTranslate(array('s'=>'Clear Cache','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				</div>
				<p class="help-block"><?php echo smartyTranslate(array('s'=>'Clear the newsletter pro cache.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
			</div>
		</div>

	</div>
</div><?php }} ?>
