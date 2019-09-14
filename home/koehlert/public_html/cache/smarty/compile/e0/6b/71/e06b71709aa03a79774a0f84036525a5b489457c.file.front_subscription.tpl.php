<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/front_subscription.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14029150685d5a47a83eb078-35289689%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e06b71709aa03a79774a0f84036525a5b489457c' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/front_subscription.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14029150685d5a47a83eb078-35289689',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'subscription_template' => 0,
    'fix_document_write' => 0,
    'tab_id' => 0,
    'CONFIGURATION' => 0,
    'load_subscription_hook_header' => 0,
    'subscription_template_view_in_front_lang' => 0,
    'result' => 0,
    'show_on_pages' => 0,
    'value' => 0,
    'title' => 0,
    'front_pages' => 0,
    'page' => 0,
    'when_to_show' => 0,
    'key' => 0,
    'subscription_template_view_in_front' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8536fc5_18531662',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8536fc5_18531662')) {function content_5d5a47a8536fc5_18531662($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/home/koehlert/public_html/tools/smarty/plugins/function.math.php';
?>

<?php $_smarty_tpl->_capture_stack[0][] = array("voucher", null, null); ob_start(); ?>
<input id="subscription-template-voucher" class="form-control form-control fixed-width-xxl subscription-template-voucher" type="text" value="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['subscription_template']->value['voucher']);?>
" name="subscriptionVoucher">
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php $_smarty_tpl->_capture_stack[0][] = array("voucher_description", null, null); ob_start(); ?>
<?php echo smartyTranslate(array('s'=>'Leave this empty if there is not voucher. If it\'s empty the voucher message will not be displayed.','mod'=>'newsletterpro'),$_smarty_tpl);?>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;" class="front-subscription">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#frontSubscription') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;" class="front-subscription">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;" class="front-subscription">');
	} 
</script>
<?php }?>

	<div class="clear">&nbsp;</div>

	<div class="title-box clearfix">
		<h4 class="title pull-left"><?php echo smartyTranslate(array('s'=>'Front Subscription Configuration','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
		<a href="javascript:{}" id="np-create-custom-field" class="btn btn-default pull-right">
			<i class="icon icon-plus-square"></i>
			<?php echo smartyTranslate(array('s'=>'Create Custom Fields','mod'=>'newsletterpro'),$_smarty_tpl);?>

		</a>
		<div class="separation"></div>
	</div>

	<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['SUBSCRIPTION_ACTIVE']==0) {?>
	<div style="margin-bottom: 5px;" class="alert alert-warning clearfix">
		<?php echo smartyTranslate(array('s'=>'The front subscription feature is not activated. Go to the settings tab to activate it.','mod'=>'newsletterpro'),$_smarty_tpl);?>

		<div class="clear"></div>
	</div>
	<?php }?>

	<div class="form-group clearfix content-box">
		<div class="form-group clearfix">
			<div class="form-inline">
				<div class="clearfix">
					<h4 class="pull-left"><?php echo smartyTranslate(array('s'=>'Templates List','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
					<a id="subscription_template_help" href="javascript:{}" class="btn btn-default pull-right  btn-margin subscription-template-help" onclick="NewsletterPro.modules.frontSubscription.showSubscriptionHelp();"><i class="icon icon-eye"></i> <?php echo smartyTranslate(array('s'=>'View available variables','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
					<a id="load-subscription-template-backup" href="javascript:{}"  class="btn btn-default pull-right btn-margin"><i class="icon icon-database"></i> <?php echo smartyTranslate(array('s'=>'Restore','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
					<a id="create-subscription-template-backup" href="javascript:{}" class="btn btn-default pull-right btn-margin"><span class="btn-ajax-loader"></span> <i class="icon icon-database"></i> <?php echo smartyTranslate(array('s'=>'Create backup','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				</div>
				<div class="separation"></div>
			</div>
		</div>

		<table id="subscription-templates-table" class="table table-bordered subscription-templates-table">
			<thead>
				<tr>
					<th class="name" data-field="name"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="date_add" data-field="date_add"><?php echo smartyTranslate(array('s'=>'Date Add','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="display_gender" data-field="display_gender"><?php echo smartyTranslate(array('s'=>'Gender','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="display_firstname" data-field="display_firstname"><?php echo smartyTranslate(array('s'=>'First Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="display_lastname" data-field="display_lastname"><?php echo smartyTranslate(array('s'=>'Last Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="display_language" data-field="display_language"><?php echo smartyTranslate(array('s'=>'Language','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="display_birthday" data-field="display_birthday"><?php echo smartyTranslate(array('s'=>'Birthday','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="display_list_of_interest" data-field="display_list_of_interest"><?php echo smartyTranslate(array('s'=>'List Of Interest','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="list_of_interest_type" data-field="list_of_interest_type"><?php echo smartyTranslate(array('s'=>'List Type Checkbox','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="np-active" data-field="active"><?php echo smartyTranslate(array('s'=>'Active','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
		</table>
	</div>

	<div class="form-group clearfix content-box">
		<div class="form-group clearfix content-box">
			<h4><?php echo smartyTranslate(array('s'=>'Subscription Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
			<div class="separation"></div>
		</div>

		<div id="subscription-template-box" class="subscription-template-box">
			<div>
				<div id="tab_subscription_template" class="tab-subacription-template" style="float: left;">
					<a id="tab_subscription_template-template_0" class="btn btn-default first_item">
						<i class="icon icon-edit"></i> <?php echo smartyTranslate(array('s'=>'Edit Template','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</a>
					<a id="tab_subscription_template-template_6" class="btn btn-default item">
						<i class="icon icon-edit"></i> <?php echo smartyTranslate(array('s'=>'Edit Messages','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</a>

					<?php if ($_smarty_tpl->tpl_vars['load_subscription_hook_header']->value==true) {?>
						<a id="tab_subscription_template-template_1" class="btn btn-default item">
							<i class="icon icon-eye"></i> <?php echo smartyTranslate(array('s'=>'View','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</a>
					<?php }?>

					<a id="tab_subscription_template-template_2" class="btn btn-default item">
						<i class="icon icon-code"></i> <?php echo smartyTranslate(array('s'=>'CSS Style','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</a>
					<a id="tab_subscription_template-template_4" class="btn btn-default item">
						<i class="icon icon-code"></i> <?php echo smartyTranslate(array('s'=>'CSS Style (Global)','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</a>
					<a id="tab_subscription_template-template_3" class="btn btn-default item">
						<i class="icon icon-gear"></i> <?php echo smartyTranslate(array('s'=>'Template Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</a>
					<a id="tab_subscription_template-template_7" class="btn btn-default item">
						<i class="icon icon-gear"></i> <?php echo smartyTranslate(array('s'=>'Popup Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</a>
					<a id="tab_subscription_template-template_5" class="btn btn-default item">
						<i class="icon icon-info-circle"></i> <?php echo smartyTranslate(array('s'=>'Info','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</a>
				</div>

				<div class="language-box" style="float: right;">
					<div id="subscription-template-language" class="gk_lang_select"></div>
				</div>
				<div class="clear">&nbsp;</div>
			</div>
			<div id="tab_subscription_template_content" class="tab-subacription-template-content">
				<div id="tab_subscription_template_content-template_0">
					<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['textarea_tpl_multilang']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('class_name'=>'subscription_rte','content_name'=>'subscription_content','input_name'=>"subscription_template",'input_value'=>$_smarty_tpl->tpl_vars['subscription_template']->value['content'],'content_css'=>$_smarty_tpl->tpl_vars['subscription_template']->value['css_links'],'init_callback'=>'NewsletterPro.modules.frontSubscription.initTinyCallback'), 0);?>

				</div>
	
				<?php if ($_smarty_tpl->tpl_vars['load_subscription_hook_header']->value==true) {?>
					<div id="tab_subscription_template_content-template_1" style="display: none;">
						<div class="view-content">
						 	<iframe id="subscription-template-view" style="display: block; vertical-align: top;" scrolling="no" src="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['subscription_template']->value['view']);?>
" class="view-newsletter-template-content"> </iframe>
							<div class="clear"></div>
						</div>
					</div>
				<?php }?>

				<div id="tab_subscription_template_content-template_2" style="display: none;">
					<div class="settings-tab">
						<div class="clearfix">
							<h4><?php echo smartyTranslate(array('s'=>'Setup the CSS for this template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
							<div class="alert alert-info">
								<?php echo smartyTranslate(array('s'=>'Use the class ".np-front-subscription" in front of the selection. If you don\'t respect this, the global style of the website will be affected.','mod'=>'newsletterpro'),$_smarty_tpl);?>

							</div>
						</div>
						<textarea id="subscription-template-css" class="template-css" style="box-sizing: border-box; width: 100%;" wrap="off" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subscription_template']->value['css_style'], ENT_QUOTES, 'UTF-8', true);?>
</textarea>
					</div>
				</div>

				<div id="tab_subscription_template_content-template_4" style="display: none;">
					<div class="settings-tab clearfix">
						<div class="clearfix">
							<h4><?php echo smartyTranslate(array('s'=>'Setup the global CSS for all the templates','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
							<div class="alert alert-info">
								<?php echo smartyTranslate(array('s'=>'This style is applied to all the templates.','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Use the class ".np-front-subscription" in front of the selection. If you don\'t respect this, the global style of the website will be affected.','mod'=>'newsletterpro'),$_smarty_tpl);?>

							</div>
						</div>
						<textarea id="subscription-template-css-global" class="template-css" style="box-sizing: border-box; width: 100%;" wrap="off" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subscription_template']->value['css_style_global'], ENT_QUOTES, 'UTF-8', true);?>
</textarea>
					</div>
				</div>

				<div id="tab_subscription_template_content-template_3" style="display: none;">
					<div class="settings-tab clearfix">
						<div class="clearfix">
							<h4><?php echo smartyTranslate(array('s'=>'Template Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
						</div>

						<div class="slider-box clearfix">
							<label class="control-label col-sm-3" style="padding-top: 27px;"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Template Width','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
							<div class="col-sm-9">
								<div class="col-sm-9">
									<div id="slider-fs-template-width"></div>
								</div>
								<div class="col-sm-3">
									<div class="radio">
										<label for="radio-fs-percent" class="in-win control-label">
											<input id="radio-fs-percent" type="radio" value="0" name="sliderFsTemplateWidth">
											<?php echo smartyTranslate(array('s'=>'percent','mod'=>'newsletterpro'),$_smarty_tpl);?>

										</label>
									</div>
									
									<div class="radio">
										<label for="radio-fs-pixels" class="in-win control-label">
											<input id="radio-fs-pixels" type="radio" value="1" name="sliderFsTemplateWidth">
											<?php echo smartyTranslate(array('s'=>'pixels','mod'=>'newsletterpro'),$_smarty_tpl);?>

										</label>
									</div>
								</div>
							</div>

						</div>

						<div class="slider-box clearfix">
							<label class="control-label col-sm-3" style="padding-top: 27px;"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Template Max-Min Width','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
							<div class="col-sm-9">
								<div class="col-sm-9">
									<div id="slider-fs-template-maxmin-width"></div>
								</div>
								<div class="col-sm-3">
									<label class="in-win control-label" style="padding-top: 25px;"><?php echo smartyTranslate(array('s'=>'pixels','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
								</div>
							</div>

						</div>

						<div class="slider-box clearfix">
							<label class="control-label col-sm-3" style="padding-top: 27px;"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Template Top','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
							<div class="col-sm-9">
								<div class="col-sm-9">
									<div id="slider-fs-template-top"></div>
								</div>

								<div class="col-sm-3">
									<label class="in-win control-label" style="padding-top: 25px;"><?php echo smartyTranslate(array('s'=>'pixels','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
								</div>
							</div>

						</div>

						<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Show Message After Subscribe','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Show a message after a visitor has subscribed to the newsletter in a new windows. If this option is \"No\" the message will be also displayed but in the same window. Empty the message if you want to display the standard message.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp2=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp1,'description'=>$_tmp2,'label_id'=>'display_subscribe_message','label_name'=>'displaySubscribeMessage','input_onchange'=>'','is_checked'=>$_smarty_tpl->tpl_vars['subscription_template']->value['display_subscribe_message']), 0);?>


						<div class="form-group clearfix">
							<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Voucher','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
							<div class="col-sm-9">
								<div class="clearfix">
									<?php echo preg_replace("%(?<!\\\\)'%", "\'",Smarty::$_smarty_vars['capture']['voucher']);?>

								</div>
								<p class="help-block"><?php echo htmlspecialchars(Smarty::$_smarty_vars['capture']['voucher_description'], ENT_QUOTES, 'UTF-8', true);?>
</p>
							</div>
						</div>

						<div class="form-group clearfix">
							<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Terms and conditions url','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
							<div class="col-sm-9">
								<div class="clearfix">
									<input type="text" id="np-terms-and-conditions" name="np_terms_and_conditions" class="form-control fixed-width-xxl" value="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['subscription_template']->value['terms_and_conditions_url']);?>
">
								</div>
								<p class="help-block"><?php echo smartyTranslate(array('s'=>'Insert the terms and conditions url.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
							</div>
						</div>

						<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display Gender','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display gender options in the front office subscription.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp4=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp3,'description'=>$_tmp4,'label_id'=>'display_gender','label_name'=>'displayGender','input_onchange'=>'','is_checked'=>$_smarty_tpl->tpl_vars['subscription_template']->value['display_gender']), 0);?>

						<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display First Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display the First Name input field in the front office subscription.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp6=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp5,'description'=>$_tmp6,'label_id'=>'display_firstname','label_name'=>'displayFirstName','input_onchange'=>'','is_checked'=>$_smarty_tpl->tpl_vars['subscription_template']->value['display_firstname']), 0);?>

						<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display Last Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp7=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display the Last Name input field in the front office subscription.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp8=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp7,'description'=>$_tmp8,'label_id'=>'display_lastname','label_name'=>'displayLastName','input_onchange'=>'','is_checked'=>$_smarty_tpl->tpl_vars['subscription_template']->value['display_lastname']), 0);?>

						<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display Language','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp9=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display language options in the front office subscription.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp10=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp9,'description'=>$_tmp10,'label_id'=>'display_language','label_name'=>'displayLanguage','input_onchange'=>'','is_checked'=>$_smarty_tpl->tpl_vars['subscription_template']->value['display_language']), 0);?>

						<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display Birthday','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp11=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display birthday options in the front office subscription.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp12=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp11,'description'=>$_tmp12,'label_id'=>'display_birthday','label_name'=>'displayBirthday','input_onchange'=>'','is_checked'=>$_smarty_tpl->tpl_vars['subscription_template']->value['display_birthday']), 0);?>

						<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display List Of Interest','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp13=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display list of interest options in the front office subscription.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp14=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp13,'description'=>$_tmp14,'label_id'=>'display_list_of_interest','label_name'=>'displayListOfInterest','input_onchange'=>'','is_checked'=>$_smarty_tpl->tpl_vars['subscription_template']->value['display_list_of_interest']), 0);?>

						<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display List Of Interest Type Checkbox','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp15=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Display the list of interest as a checkbox type or as a selected option type.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp16=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp15,'description'=>$_tmp16,'label_id'=>'list_of_interest_type','label_name'=>'listOfInterestType','input_onchange'=>'','is_checked'=>$_smarty_tpl->tpl_vars['subscription_template']->value['list_of_interest_type']), 0);?>

						<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Multiple time subscription','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp17=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Allow the users to subscribe multiple times at the newsletter with the save email address.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp18=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp17,'description'=>$_tmp18,'label_id'=>'allow_multiple_time_subscription','label_name'=>'allowMultipleTimeSubscription','input_onchange'=>'','is_checked'=>$_smarty_tpl->tpl_vars['subscription_template']->value['allow_multiple_time_subscription']), 0);?>

						<div id="activate-template-box" class="activate-template-box" style="<?php if ($_smarty_tpl->tpl_vars['subscription_template']->value['active']) {?>display: none;<?php } else { ?>display: block;<?php }?>">
							<a href="javascript:{}" id="activate-template" class="btn btn-default"><span class="icon incon-power-off"></span><?php echo smartyTranslate(array('s'=>'Activate Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
						</div>
						
						<div class="form-group clearfix">
							<label class="control-label col-sm-3" style="padding-top: 13px;"><?php echo smartyTranslate(array('s'=>'Mandatory Fields','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
							<div class="col-sm-9">
								<div class="checkbox">
									<label class="control-label in-win">
										<input type="checkbox" name="newsletter_pro_subscription_mandatory_firstname">
										<?php echo smartyTranslate(array('s'=>'First Name','mod'=>'newsletterpro'),$_smarty_tpl);?>

									</label>
								</div>

								<div class="checkbox">
									<label class="control-label in-win">
										<input type="checkbox" name="newsletter_pro_subscription_mandatory_lastname">
										<?php echo smartyTranslate(array('s'=>'Last Name','mod'=>'newsletterpro'),$_smarty_tpl);?>

									</label>
								</div>
							</div>
						</div>
						
						<div class="col-sm-9 col-sm-offset-3">
							<div class="clearfix">
								<h4><?php echo smartyTranslate(array('s'=>'Global Configuration','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
							</div>
						</div>

						<div class="form-group clearfix">
							<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Cross Type','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
							<div class="col-sm-9">
								<div class="np-subscription-cross clearfix">
									<span id="np-cross" class="np-icon-cross"></span>
									<span id="np-cross1" class="np-icon-cross_1"></span>
									<span id="np-cross2" class="np-icon-cross_2"></span>
									<span id="np-cross3" class="np-icon-cross_3"></span>
									<span id="np-cross4" class="np-icon-cross_4"></span>
									<span id="np-cross5" class="np-icon-cross_5"></span>
								</div>
								<p class="help-block"><?php echo smartyTranslate(array('s'=>'Choose the popup corss type.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
							</div>
						</div>
						
					</div>
				</div>

				<div id="tab_subscription_template_content-template_5" style="display: none;">
					<div class="settings-tab">
						<div class="clearfix">
							<h4><?php echo smartyTranslate(array('s'=>'Informations','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
						</div>

						<div class="clearfix">
							<div class="alert alert-info">
								<p><?php echo smartyTranslate(array('s'=>'For the "email confirmation on subscribe option" or if you want to import emails addresses from the default prestashop subscription module visit the settings tab.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
								<p><?php echo smartyTranslate(array('s'=>'The template input attribute class and name are very important, don\'t change them in order the subscription to work properly.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
								<p><?php echo smartyTranslate(array('s'=>'View the available variabes by clicking ','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <a id="subscription_template_help" href="javascript:{}" style="color: #49B2FF;" onclick="NewsletterPro.modules.frontSubscription.showSubscriptionHelp();"><?php echo smartyTranslate(array('s'=>'here','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>. </p>
							</div>

							<div class="form-group clearfix">
								<div>
									<h4 style="margin-bottom: 0; border: none;"><?php echo smartyTranslate(array('s'=>'Front Subscription Popup Links by Language','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
								</div>
								<table class="table front-view-links">
									<thead>
										<tr>
											<th><?php echo smartyTranslate(array('s'=>'Language Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
											<th><?php echo smartyTranslate(array('s'=>'Link','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
										</tr>
									</thead>
									<tbody>
									<?php  $_smarty_tpl->tpl_vars['result'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['result']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['subscription_template_view_in_front_lang']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['result']->key => $_smarty_tpl->tpl_vars['result']->value) {
$_smarty_tpl->tpl_vars['result']->_loop = true;
?>			
										<tr>
											<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['result']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</td> 
											<td><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['result']->value['link']);?>
</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>

							<div class="alert alert-info">
								<?php echo smartyTranslate(array('s'=>'The subscription link can is available in the newsletter template by using the variable %s or %s.','sprintf'=>array('{front_subscription}','{front_subscription_link}'),'mod'=>'newsletterpro'),$_smarty_tpl);?>

							</div>
						</div>
					</div>
				</div>

				<div id="tab_subscription_template_content-template_6" style="display: none;">
					<div class="settings-tab">
						<div class="clearfix">
							<h4><?php echo smartyTranslate(array('s'=>'After Subscribe Success Message','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
						</div>
						<div class="alert alert-info">
							<?php echo smartyTranslate(array('s'=>'Don\'t forget to check if you want to display this message in a new window or not from "Template Settings" tab. Empty the message if you want to display a standard message.','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</div>

						<div class="form-group clearfix">
							<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['textarea_tpl_multilang']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('class_name'=>'subscription_rte_sm','content_name'=>'content_name_s_subscribe_message','input_name'=>"s_subscribe_message",'input_value'=>$_smarty_tpl->tpl_vars['subscription_template']->value['subscribe_message'],'content_css'=>$_smarty_tpl->tpl_vars['subscription_template']->value['css_links'],'init_callback'=>'NewsletterPro.modules.frontSubscription.initTinyCallback'), 0);?>

						</div>

						<div class="clearfix">
							<h4><?php echo smartyTranslate(array('s'=>'Email Subscribe Voucher Message','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
						</div>

						<div class="form-group clearfix">
							<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Voucher','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label> 
							<div class="col-sm-9">
								<?php echo preg_replace("%(?<!\\\\)'%", "\'",Smarty::$_smarty_vars['capture']['voucher']);?>


							</div>
						</div>		

						<div class="alert alert-info clearfix">
							<?php echo htmlspecialchars(Smarty::$_smarty_vars['capture']['voucher_description'], ENT_QUOTES, 'UTF-8', true);?>

							<?php echo smartyTranslate(array('s'=>'The content style is important to be setup as inline style, because this template will be shown in the the subscriber email account.','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</div>

						<div class="form-group clearfix">
							<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['textarea_tpl_multilang']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('class_name'=>'subscription_rte_esvm','content_name'=>'content_name_s_email_subscribe_voucher_message','input_name'=>"s_email_subscribe_voucher_message",'input_value'=>$_smarty_tpl->tpl_vars['subscription_template']->value['email_subscribe_voucher_message'],'init_callback'=>'NewsletterPro.modules.frontSubscription.initTinyCallback','plugins'=>"fullpage"), 0);?>

						</div>

						<div class="clearfix">
							<h4><?php echo smartyTranslate(array('s'=>'Email Subscribe Confirmation Message','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
						</div>

						<div class="alert alert-info">
							<p><?php echo smartyTranslate(array('s'=>'The email subscribe confirmation message option is global for all the templates and only the template messages are different. The option can be changes from the settings tab.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
							<p><?php echo smartyTranslate(array('s'=>'The content style is important to be setup as inline style, because this template will be shown in the the subscriber email account.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
							<p><?php echo smartyTranslate(array('s'=>'Additional variables on this templates are: %s and %s.','sprintf'=>array('{email_confirmation}','{email_confirmation_link}'),'mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
						</div>

						<div class="form-group clearfix">
							<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['textarea_tpl_multilang']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('class_name'=>'subscription_rte_escm','content_name'=>'content_name_s_email_subscribe_confirmation_message','input_name'=>"s_email_subscribe_confirmation_message",'input_value'=>$_smarty_tpl->tpl_vars['subscription_template']->value['email_subscribe_confirmation_message'],'init_callback'=>'NewsletterPro.modules.frontSubscription.initTinyCallback','plugins'=>"fullpage"), 0);?>

						</div>
					</div>
				</div>

				<div id="tab_subscription_template_content-template_7" style="display: none;">
					<div class="clearfix settings-tab">
						<div class="clearfix">
							<h4><?php echo smartyTranslate(array('s'=>'Auto popup settings','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
						</div>

						<div class="form-group clearfix">
							<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Show on Pages','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
							<div class="col-sm-9">
								<div class="clearfix">
									<select id="show-on-pages" name="show_on_pages" class="fixed-width-xxl gk-select">
										<?php  $_smarty_tpl->tpl_vars['title'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['title']->_loop = false;
 $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['show_on_pages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['title']->key => $_smarty_tpl->tpl_vars['title']->value) {
$_smarty_tpl->tpl_vars['title']->_loop = true;
 $_smarty_tpl->tpl_vars['value']->value = $_smarty_tpl->tpl_vars['title']->key;
?>
											<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['subscription_template']->value['show_on_pages']==$_smarty_tpl->tpl_vars['value']->value) {?>selected="selected"<?php }?>> - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8', true);?>
 - </option>
										<?php } ?>
										<?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['page']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['front_pages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->_loop = true;
?>
											<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['subscription_template']->value['show_on_pages']==$_smarty_tpl->tpl_vars['page']->value['value']) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
</option>
										<?php } ?>
									</select>
								</div>
								<p class="help-block"><?php echo smartyTranslate(array('s'=>'Set none if you want to disable the auto popup. The popup will be availabe when the user will click on the subscription button.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
							</div>
						</div>

						<div class="form-group clearfix">
							<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'When to show popup to user','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
							<div class="col-sm-9">
								<div class="clearfix">
									<select id="when-shop-popup" name="when_shop_popup" class="fixed-width-xxl gk-select">
										<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['when_to_show']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
										<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if (intval($_smarty_tpl->tpl_vars['subscription_template']->value['when_to_show'])==$_smarty_tpl->tpl_vars['key']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group clearfix">
							<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Start Timer','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
							<div class="col-sm-9">
								<div class="clearfix">
									<input id="start-timer" type="text" name="start_timer" class="fixed-width-xxl gk-input" value="<?php echo intval($_smarty_tpl->tpl_vars['subscription_template']->value['start_timer']);?>
">
								</div>
								<p class="help-block"><?php echo smartyTranslate(array('s'=>'After how many seconds the popup will be shown. Set 0 to start immediately.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>								
							</div>
						</div>

						<div class="form-group clearfix">
							<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Cookie Lifetime (in days)','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
							<div class="col-sm-9">
								<div class="clearfix">
									<input id="cookie-lifetime" type="text" name="cookie_lifetime" class="fixed-width-xxl gk-input" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subscription_template']->value['cookie_lifetime'], ENT_QUOTES, 'UTF-8', true);?>
" style="float: left;"> 
									<label class="control-label in-win pull-left seconds-text" style="margin-left: 10px;">
										<span id="cookie-lifetime-seconds"> <?php echo smarty_function_math(array('equation'=>"round(time * 60 * 60 * 24)",'time'=>$_smarty_tpl->tpl_vars['subscription_template']->value['cookie_lifetime']),$_smarty_tpl);?>
</span> <?php echo smartyTranslate(array('s'=>'seconds','mod'=>'newsletterpro'),$_smarty_tpl);?>

									</label>
								</div>
								<p class="help-block"><?php echo smartyTranslate(array('s'=>'How long should be cookie started (in days). (0 = when your browser closes). This field also accept math if you want a cookie that is less at one day. (1/24/60/60 * 5 = 5 seconds)','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>								
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>
		<div class="clear"></div>
	</div>

	<div class="form-group clearfix content-box">
		<div class="form-inline">
			<div class="col-sm-4">
				<div id="save-subscription-template-message" class="save-subscription-template-message" style="display: none; float: left;">&nbsp;</div>
			</div>
			<div class="col-sm-8">
				<a id="save-subscription-template" href="javascript:{}" class="btn btn-default btn-margin pull-right">
					<i class="icon icon-save"></i> <span><?php echo smartyTranslate(array('s'=>'Save','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
				</a>
				<a id="save-as-subscription-template" href="javascript:{}" class="btn btn-default btn-margin pull-right">
					<i class="icon icon-save"></i> <span><?php echo smartyTranslate(array('s'=>'Save As','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
				</a>
				<?php if ($_smarty_tpl->tpl_vars['load_subscription_hook_header']->value==true) {?>
					<a id="subscription-view-in-a-new-window" href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['subscription_template']->value['view']);?>
" target="_blank" class="btn btn-default btn-margin pull-right">
						<i class="icon icon-eye"></i> <span><?php echo smartyTranslate(array('s'=>'View in a New Window','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</a>
				<?php }?>
				<a href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['subscription_template_view_in_front']->value);?>
" target="_blank" class="btn btn-default btn-margin pull-right">
					<i class="icon icon-eye"></i> <span><?php echo smartyTranslate(array('s'=>'View in Front','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
				</a>
			</div>
		</div>
	</div>

	<div class="from-group clearfix content-box"> 
		<div class="form-group clearfix">
			<div class="clearfix">
				<h4 class="pull-left"><?php echo smartyTranslate(array('s'=>'Manage List of Interest','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
				<div class="language-box">
					<div id="front-subscription-lang" class="front-subscription-lang"> </div>
				</div>
			</div>
			<div class="separation"></div>
		</div>

		<table id="list-of-interest-table" class="table table-bordered list-of-interest-table">
			<thead>
				<tr>
					<th class="name" data-field="name"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="np-active" data-field="active"><?php echo smartyTranslate(array('s'=>'Active','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="position" data-field="position"><?php echo smartyTranslate(array('s'=>'Position','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<?php }} ?>
