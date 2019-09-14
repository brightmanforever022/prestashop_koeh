<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/newsletter.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5038374005d5a47a85ca8f1-61562256%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '42932a4eefc08da658be0a734b2ceb5461d72e8b' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/newsletter.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5038374005d5a47a85ca8f1-61562256',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'np_errors' => 0,
    'error' => 0,
    'CONFIGURATION' => 0,
    'isPS16' => 0,
    'CONTROLLER_FRONT_SUBSCRIPTION' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8641a29_02754945',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8641a29_02754945')) {function content_5d5a47a8641a29_02754945($_smarty_tpl) {?>

<div id="newsletterpro" class="row">
	<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/module_info.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	
	<?php if (isset($_smarty_tpl->tpl_vars['np_errors']->value)&&!empty($_smarty_tpl->tpl_vars['np_errors']->value)) {?>
	<div class="form-group clearfix">
		<div class="alert alert-danger" style="margin-bottom: 0;">
			<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['np_errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value) {
$_smarty_tpl->tpl_vars['error']->_loop = true;
?>
				<div class="clearfix"><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['error']->value);?>
</div>
			<?php } ?>
		</div>
	</div>
	<?php }?>

	<div id="np-left-side" class="np-left-side <?php if (isset($_smarty_tpl->tpl_vars['CONFIGURATION']->value['LEFT_MENU_ACTIVE'])&&$_smarty_tpl->tpl_vars['CONFIGURATION']->value['LEFT_MENU_ACTIVE']==0) {?>col-sm-12<?php } else { ?>col-sm-2<?php }?> clearfix">
		<div id="tab" class="newsletter <?php if (isset($_smarty_tpl->tpl_vars['CONFIGURATION']->value['LEFT_MENU_ACTIVE'])&&$_smarty_tpl->tpl_vars['CONFIGURATION']->value['LEFT_MENU_ACTIVE']==0) {?>np-menu-top<?php }?>">
				<?php if ($_smarty_tpl->tpl_vars['isPS16']->value) {?>
				<div class="menu-type">
					<span id="menu-toggle" class="menu-toggle"><i class="icon icon-bars" style="font-size: 18px;"></i> <span class="toggle-menu-text"><?php if (isset($_smarty_tpl->tpl_vars['CONFIGURATION']->value['LEFT_MENU_ACTIVE'])&&$_smarty_tpl->tpl_vars['CONFIGURATION']->value['LEFT_MENU_ACTIVE']==0) {?><?php echo smartyTranslate(array('s'=>'Left Menu','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Top Menu','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php }?></span></span>
				</div>
				<?php }?>
				<a id="tab_newsletter_0" href="#csv" class="first_item"><span class="icon-import-csv"></span><?php echo smartyTranslate(array('s'=>'Import & Export','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_1" href="#manageImages" class="item"><span class="icon-manage-iamges"></span><?php echo smartyTranslate(array('s'=>'Manage Images','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_3" href="#selectProducts" class="item"><span class="icon-select-products"></span><span class="menu-text"><?php echo smartyTranslate(array('s'=>'Select Products','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span> <span class="step">1</span></a>
				<a id="tab_newsletter_4" href="#createTemplate" class="item"><span class="icon-create-template"></span><span class="menu-text"><?php echo smartyTranslate(array('s'=>'Create Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span> <span class="step">2</span></a>
				<a id="tab_newsletter_5" href="#sendNewsletters" class="item"><span class="icon-send-newsletters"></span><span class="menu-text"><?php echo smartyTranslate(array('s'=>'Send Newsletters','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span> <span id="np-step-3" class="step">3</span></a>
				<a id="tab_newsletter_10" href="#task" class="item"><span class="icon-task"></span><?php echo smartyTranslate(array('s'=>'Tasks','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_6" href="#history" class="item"><span class="icon-history-span"></span><?php echo smartyTranslate(array('s'=>'History','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_11" href="#statistics" class="item"><span class="icon-statistics"></span><?php echo smartyTranslate(array('s'=>'Statistics','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_8" href="#campaign" class="item"><span class="icon-campaign"></span><?php echo smartyTranslate(array('s'=>'Campaign Statistics','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_9" href="#smtp" class="item"><span class="icon-smtp"></span><?php echo smartyTranslate(array('s'=>'E-mail Configuration','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_13" href="#mailchimp" class="item"><span class="icon-mailchimp"></span><?php echo smartyTranslate(array('s'=>'Mail Chimp','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_14" href="#forward" class="item"><span class="icon-fwd"></span><?php echo smartyTranslate(array('s'=>'Forwarders','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_15" href="#frontSubscription" class="item"><span class="icon-f-subscription"></span><?php echo smartyTranslate(array('s'=>'Front Subscription','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span id="fs-vouchers-alert" class="vouchers-alert"></span></a>
				<a id="tab_newsletter_7" href="#settings" class="item"><span class="icon-settings"></span><?php echo smartyTranslate(array('s'=>'Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_2" href="#tutorials" class="item"><span class="icon-tutorials"></span><?php echo smartyTranslate(array('s'=>'Tutorials','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
				<a id="tab_newsletter_12" href="#ourModules" class="last_item count-new-parent"><span class="icon-puzzle"></span><span class="np-menu-text-ourmodules"><?php echo smartyTranslate(array('s'=>'Our Modules','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></a>
		</div>
	</div> <!-- end of col-log-2  -->

 	<div id="np-right-side" class="np-right-side <?php if (isset($_smarty_tpl->tpl_vars['CONFIGURATION']->value['LEFT_MENU_ACTIVE'])&&$_smarty_tpl->tpl_vars['CONFIGURATION']->value['LEFT_MENU_ACTIVE']==0) {?>col-sm-12<?php } else { ?>col-sm-10<?php }?>">
		<div id="tab_content" class="newsletter clearfix <?php if (isset($_smarty_tpl->tpl_vars['CONFIGURATION']->value['LEFT_MENU_ACTIVE'])&&$_smarty_tpl->tpl_vars['CONFIGURATION']->value['LEFT_MENU_ACTIVE']==0) {?>np-menu-top-content<?php }?>" style="position: relative;">
			<div id="tab_content_loading" class="tab-content-loading">
				<div class="tab-content-loading-content">
					<i class="icon icon-refresh icon-spin"></i> <?php echo smartyTranslate(array('s'=>'loading...','mod'=>'newsletterpro'),$_smarty_tpl);?>

				</div>
				<div class="tab-content-loading-bg"></div>
			</div>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/csv.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_0"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/manage_images.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_1"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/select_products.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_3"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/create_template.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_4"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/send_newsletters.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_5"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/history.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_6"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/statistics.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_11"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/settings.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_7"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/campaign.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_8"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/smtp.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_9"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/task.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_10"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/tutorials.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_2"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/mailchimp.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_13"), 0);?>

			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/forward.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_14"), 0);?>

			
			
			<?php echo strval($_smarty_tpl->tpl_vars['CONTROLLER_FRONT_SUBSCRIPTION']->value);?>


			<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tabs/our_modules.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('tab_id'=>"tab_newsletter_content_12"), 0);?>

		</div>
		<div class="clear" style="clear: both;"></div>
	</div>

	<div class="clear" style="clear: both;"></div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/javascript/js_settings.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/task/template.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/tiny_init.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/javascript/js_translations.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
