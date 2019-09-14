<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/mailchimp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9061955755d5a47a8bdf5e4-54956958%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '74a6277f30e62ef1a081381d056f746892d89a13' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/mailchimp.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9061955755d5a47a8bdf5e4-54956958',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'CONFIGURATION' => 0,
    'last_date_chimp_sync' => 0,
    'chimp_last_date_sync_orders' => 0,
    'sync_chimp_link' => 0,
    'webhook_chimp_link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8c58803_03547939',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8c58803_03547939')) {function content_5d5a47a8c58803_03547939($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-mailchimp" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#mailchimp') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-mailchimp" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-mailchimp" style="display: none;">');
	} 
</script>
<?php }?>
	<h4><?php echo smartyTranslate(array('s'=>'Mail Chimp','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>

	<form id="chimp-settings">

		<div class="form-group clearfix">
			<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Api Key','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
			<div class="col-sm-9">
				<div class="clearfix">
					<input class="form-control fixed-width-xxl" type="text" size="30" id="chimp-api-key" name="chimp_api_key" value="<?php if (isset($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CHIMP']['API_KYE'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CHIMP']['API_KYE'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"> 
				</div>
				<p class="help-block"><?php echo smartyTranslate(array('s'=>'Insert your Mail Chimp Api Key. Log-in into your Mail Chimp account and go to the section "My Account" > "Extras" > "Api Key" and then copy the Api Key.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>										
			</div>
		</div>

		<div class="form-group clearfix">
			<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'List ID','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
			<div class="col-sm-9">
				<div class="clearfix">
					<input class="form-control fixed-width-xxl" type="text" size="30" id="chimp-list-id" name="chimp_list_id" value="<?php if (isset($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CHIMP']['ID_LIST'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CHIMP']['ID_LIST'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"> 
				</div>
				<p class="help-block"><?php echo smartyTranslate(array('s'=>'Insert your Mail Chimp List ID. Log-in into your Mail Chimp account and go to the "Lists" section. Create a new list with the name "Newsletter Pro". After the list was created, go to the section "Settings" > "List name & defaults" and then copy List ID.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
			</div>
		</div>

		<div class="clearfix">

			<div class="form-group clearfix">
				<div class="col-sm-9 col-sm-offset-3">
					<a id="install-chimp" href="javascript:{}" class="btn btn-default btn-margin" style="display: none;">
						<span id="install-chimp-loading"></span>
						<i class="icon icon-plug"></i>
						<?php echo smartyTranslate(array('s'=>'Install Mail Chimp','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</a>

					<a id="uninstall-chimp" href="javascript:{}" class="btn btn-default btn-margin" style="display: none;">
						<span id="uninstall-chimp-loading"></span>
						<i class="icon icon-remove"></i>
						<?php echo smartyTranslate(array('s'=>'Uninstall Mail Chimp','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</a>

					<a id="ping-chimp" href="javascript:{}" class="btn btn-default btn-margin ping-chimp">
						<i class="icon icon-refresh"></i>
						<?php echo smartyTranslate(array('s'=>'Ping','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</a>
				</div>
			</div>

			<div id="chimp-menu" class="form-group clearfix chimp-menu" style="display: none;">
				<h4><?php echo smartyTranslate(array('s'=>'Synchronization','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
				<div class="separation"></div>
				
				<div class="clearfix">
					<div class="col-sm-9 col-sm-offset-3">
						<span style="font-weight: normal;"><span id="last-sync-lists"><?php if (isset($_smarty_tpl->tpl_vars['last_date_chimp_sync']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['last_date_chimp_sync']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?></span> - <?php echo smartyTranslate(array('s'=>'last lists synchronization date','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</div>
				</div>				

				<div class="form-group clearfix">
					<label class="control-label col-sm-3" style="padding-top: 13px;"><?php echo smartyTranslate(array('s'=>'Select Lists','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
					<div class="col-sm-9">
						<div class="checkbox">
							<label for="sync-customers" class="in-win control-label chimp-label">
								<input type="checkbox" id="sync-customers" name="sync_customers">
								<?php echo smartyTranslate(array('s'=>'Sync Customers List','mod'=>'newsletterpro'),$_smarty_tpl);?>

							</label>
						</div>
						<div class="checkbox">
							<label for="sync-visitors" class="in-win control-label chimp-label">
								<input type="checkbox" id="sync-visitors" name="sync_visitors">
								<?php echo smartyTranslate(array('s'=>'Sync Visitors List','mod'=>'newsletterpro'),$_smarty_tpl);?>

								<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['SUBSCRIPTION_ACTIVE']==true) {?>
									<?php echo smartyTranslate(array('s'=>'(subscribed at the Newsletter Pro module)','mod'=>'newsletterpro'),$_smarty_tpl);?>

								<?php } else { ?>
									<?php echo smartyTranslate(array('s'=>'(subscribed at the Block Newsletter module)','mod'=>'newsletterpro'),$_smarty_tpl);?>
 
								<?php }?>
							</label>
						</div>
						<div class="checkbox">
							<label for="sync-added" class="in-win control-label chimp-label">
								<input type="checkbox" id="sync-added" name="sync_added">
								<?php echo smartyTranslate(array('s'=>'Sync Added List','mod'=>'newsletterpro'),$_smarty_tpl);?>

							</label>
						</div>
					</div>
				</div>

				<div class="clearfix">
					<div class="col-sm-9 col-sm-offset-3">
						<span style="font-weight: normal;"><span id="last-sync-orders"><?php if (isset($_smarty_tpl->tpl_vars['chimp_last_date_sync_orders']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['chimp_last_date_sync_orders']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?></span> - <?php echo smartyTranslate(array('s'=>'last orders synchronization date','mod'=>'newsletterpro'),$_smarty_tpl);?>
 (<a id="reset-sync-order-date" href="javascript:{}" style="color: #49B2FF;"><?php echo smartyTranslate(array('s'=>'reset date','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>)</span>
					</div>
				</div>	
				
				<div class="form-group clearfix">
					<div class="col-sm-9 col-sm-offset-3">
						<div class="checkbox">
							<label for="sync-orders" class="in-win control-label chimp-label">
								<input type="checkbox" id="sync-orders" name="sync_added">
								<?php echo smartyTranslate(array('s'=>'Sync Orders','mod'=>'newsletterpro'),$_smarty_tpl);?>

							</label>
						</div>
					</div>
				</div>

				<div class="form-group clearfix">
					<div class="col-sm-9 col-sm-offset-3">
						<a id="sync-lists" href="javascript:{}" class="btn btn-default sync-lists" style="display: none;">
							<span class="ajax-loader" style="display: none; float: left; margin-right: 6px; margin-top: 0px; margin-left: 0;"></span>
							<i class="icon icon-refresh"></i>
							<span><?php echo smartyTranslate(array('s'=>'Sync Lists','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
							<span id="sync-orders-button-text">& <?php echo smartyTranslate(array('s'=>'Sync Orders','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						</a>

						<a id="stop-sync-lists" href="javascript:{}" class="btn btn-default stop-sync-lists" style="display: none;">
							<i class="icon icon-remove"></i>
							<?php echo smartyTranslate(array('s'=>'Stop Sync Lists','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</a>
						<a id="delete-chimp-orders" href="javascript:{}" class="btn btn-default delete-chimp-orders" style="display: none;">
							<span class="ajax-loader" style="display: none; float: left; margin-right: 6px; margin-top: 0px; margin-left: 0;"></span>
							<i class="icon icon-trash-o"></i>
							<span><?php echo smartyTranslate(array('s'=>'Delete Orders from MailChimp','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						</a>
					</div>
				</div>
			
				<div class="form-group clearfix">
					<div class="col-sm-9 col-sm-offset-3">
						<div id="sync-lists-progress-box" class="sync-lists-progress-box" style="display: none;">
							<div id="sync-error-message-box" style="display: none;">
								<span class="sync-error-message" style="color: red;"></span>
							</div>
							<div id="sync-added-progress" class="sync-added-progress" style="display: none;">
								<h4><?php echo smartyTranslate(array('s'=>'Added List','mod'=>'newsletterpro'),$_smarty_tpl);?>
 ( <span class="sync-emails-total">0</span> ) <span class="ajax-loader" style="display: none;"></span></h4>
								<p>( <span class="sync-emails-created">0</span> ) <?php echo smartyTranslate(array('s'=>'emails created','mod'=>'newsletterpro'),$_smarty_tpl);?>
,  ( <span class="sync-emails-updated">0</span> ) <?php echo smartyTranslate(array('s'=>'emails updated','mod'=>'newsletterpro'),$_smarty_tpl);?>
, ( <span class="sync-emails-errors">0</span> ) <?php echo smartyTranslate(array('s'=>'emails errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
								<div class="clear"></div>
							</div>
							<div id="sync-visitors-progress" class="sync-visitors-progress" style="display: none;">
								<h4><?php echo smartyTranslate(array('s'=>'Visitors List','mod'=>'newsletterpro'),$_smarty_tpl);?>
  ( <span class="sync-emails-total">0</span> )  <span class="ajax-loader" style="display: none;"></span></h4>
								<p>( <span class="sync-emails-created">0</span> ) <?php echo smartyTranslate(array('s'=>'emails created','mod'=>'newsletterpro'),$_smarty_tpl);?>
,  ( <span class="sync-emails-updated">0</span> ) <?php echo smartyTranslate(array('s'=>'emails updated','mod'=>'newsletterpro'),$_smarty_tpl);?>
, ( <span class="sync-emails-errors">0</span> ) <?php echo smartyTranslate(array('s'=>'emails errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
								<div class="clear"></div>
							</div>
							<div id="sync-customers-progress" class="sync-customers-progress" style="display: none;">
								<h4><?php echo smartyTranslate(array('s'=>'Customers List','mod'=>'newsletterpro'),$_smarty_tpl);?>
  ( <span class="sync-emails-total">0</span> )  <span class="ajax-loader" style="display: none;"></span></h4>
								<p>( <span class="sync-emails-created">0</span> ) <?php echo smartyTranslate(array('s'=>'emails created','mod'=>'newsletterpro'),$_smarty_tpl);?>
,  ( <span class="sync-emails-updated">0</span> ) <?php echo smartyTranslate(array('s'=>'emails updated','mod'=>'newsletterpro'),$_smarty_tpl);?>
, ( <span class="sync-emails-errors">0</span> ) <?php echo smartyTranslate(array('s'=>'emails errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
								<div class="clear"></div>
							</div>

							<div id="sync-orders-progress" class="sync-orders-progress" style="display: none;">
								<h4><?php echo smartyTranslate(array('s'=>'Orders','mod'=>'newsletterpro'),$_smarty_tpl);?>
  ( <span class="sync-emails-total">0</span> )  <span class="ajax-loader" style="display: none;"></span></h4>
								<p>( <span class="sync-emails-created">0</span> ) <?php echo smartyTranslate(array('s'=>'orders created','mod'=>'newsletterpro'),$_smarty_tpl);?>
,  <span style="display: none;">( <span class="sync-emails-updated">0</span> ) <?php echo smartyTranslate(array('s'=>'orders updated','mod'=>'newsletterpro'),$_smarty_tpl);?>
,</span> ( <span class="sync-emails-errors">0</span> ) <?php echo smartyTranslate(array('s'=>'orders errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="font-weight: normal;">(<?php echo smartyTranslate(array('s'=>'The orders already exists in MailChimp','mod'=>'newsletterpro'),$_smarty_tpl);?>
)</span></p>
								<div class="clear"></div>
							</div>
						</div>
						<div id="sync-chimp-errors-message" class="alert alert-danger" style="display: none;">
						</div>
					</div>
				</div>
			</div>

			<div id="sync-back-chimp-content" class="form-group clearfix" style="display: none;">
				<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Import emails from MailChimp','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-9">
					<a id="sync-chimp-lists-back" href="javascript:{}" class="btn btn-default">
						<span class="btn-ajax-loader"></span>
						<i class="icon icon-refresh"></i>
						<span><?php echo smartyTranslate(array('s'=>'Sync Back','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</a>
				</div>
			</div>

			<div class="form-group clearfix">
				<div class="col-sm-9 col-sm-offset-3">
					<div id="sync-lists-back-progress-box" class="sync-lists-progress-box" style="display: none;">
						<div id="sync-list-back-error-message-box" style="display: none;">
							<span class="sync-error-message" style="color: red;"></span>
						</div>
						<div id="sync-list-back-progress" class="sync-added-progress" style="display: none;">
							<h4><?php echo smartyTranslate(array('s'=>'Import emails from MailChimp','mod'=>'newsletterpro'),$_smarty_tpl);?>
 ( <span class="sync-emails-total">0</span> ) <span class="ajax-loader" style="display: none;"></span></h4>
							<p>( <span class="sync-emails-created">0</span> ) <?php echo smartyTranslate(array('s'=>'emails created','mod'=>'newsletterpro'),$_smarty_tpl);?>
,  ( <span class="sync-emails-updated">0</span> ) <?php echo smartyTranslate(array('s'=>'emails updated','mod'=>'newsletterpro'),$_smarty_tpl);?>
, ( <span class="sync-emails-errors">0</span> ) <?php echo smartyTranslate(array('s'=>'emails errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="from-group clearfix">
				<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Synchronize unsubscribed users','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp47=ob_get_clean();?><?php ob_start();?><?php echo smartyTranslate(array('s'=>'Synchronize the unsubscribed users to MailChimp.','mod'=>'newsletterpro'),$_smarty_tpl);?>
<?php $_tmp48=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/settings_option.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title_name'=>$_tmp47,'description'=>$_tmp48,'label_id'=>'mailchimp_synchronize_users','label_name'=>'','input_onchange'=>'NewsletterProControllers.SettingsController.chimpSyncUnsubscribed($(this));','is_checked'=>$_smarty_tpl->tpl_vars['CONFIGURATION']->value['CHIMP_SYNC_UNSUBSCRIBED']), 0);?>

			</div>

			<div class="alert alert-info clearfix chimp-cron-job">
				<p style="margin-top: 0;" class="cron-link"><span style="color: black;">CRON URL:</span> <span class="icon-cron-link"></span><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['sync_chimp_link']->value);?>
</p>
				<p style="margin-top: 0;"><?php echo smartyTranslate(array('s'=>'To make the Mail Chimp synchronization to run automatically every day set the CRON job from your website control panel (Plesk, cPanel, DirectAdmin, etc.). Run this script every day.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
				<p style="margin-top: 0;"><?php echo smartyTranslate(array('s'=>'Synchronize all the users list before to setup the CRON job.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
			</div>

			<div class="alert alert-info clearfix chimp-cron-job">
				<p style="margin-top: 0;" class="cron-link"><span style="color: black;">WEBHOOK URL:</span> <span class="icon-cron-link"></span><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['webhook_chimp_link']->value);?>
</p>
				<p style="margin-top: 0;"><?php echo smartyTranslate(array('s'=>'With this link you can create webhooks in MailChimp account.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
				<p style="margin-top: 0;"><?php echo smartyTranslate(array('s'=>'The webhook features supported by the module are: \"Subscribe\", \"Unsubscribes\" and \"Cleaned Emails\".','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
				<p style="margin-top: 0;"><?php echo smartyTranslate(array('s'=>'For unexpected behavior the \"Cleaned Emails\" feature is deactivated by default. The webhook features \"Unsubscribes\" and \"Cleaned Emails\" can be configured in the file \"%s\".','sprintf'=>"config.ini",'mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
			</div>

		</div>
	</form>
</div><?php }} ?>
