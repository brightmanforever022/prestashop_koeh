<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/send_newsletters.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9877708135d5a47a888b323-72639930%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '135943cf87f75db641fc032c5710c4a8d357c4dd' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/send_newsletters.tpl',
      1 => 1556884089,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9877708135d5a47a888b323-72639930',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'filters_selection' => 0,
    'filter' => 0,
    'CONFIGURATION' => 0,
    'users_lists_shop_count_message' => 0,
    'show_custom_columns_format' => 0,
    'column' => 0,
    'name' => 0,
    'exclusion_emails_count' => 0,
    'shop_email' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a892edd0_15290619',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a892edd0_15290619')) {function content_5d5a47a892edd0_15290619($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#sendNewsletters') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">');
	} 
</script>
<?php }?>
	<div style="0px 0px 15px -5px;">
		<h4 style="float: left;"><?php echo smartyTranslate(array('s'=>'Select Customers & Send newsletters','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
		<a id="btn-bounced-emails" class="btn btn-default btn-bounced-emails" href="javascript:{}"><i class="icon icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Manage Bounced Emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
		<div class="clear" style="clear: both;"></div>
		<div class="separation"></div>
	</div>
	<div class="clear" style="clear: both;"></div>

	<div class="form-group clearfix">
		<div class="clearfix">
			<label class="control-label col-sm-2"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Filter Selection','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
			<div class="col-sm-10">
				<div class="form-inline">
					<div class="form-group">
						<select id="np-filter-selection" class="fixed-width-xxl gk-select">
							<option value="0">- <?php echo smartyTranslate(array('s'=>'none','mod'=>'newsletterpro'),$_smarty_tpl);?>
 -</option>
							<?php  $_smarty_tpl->tpl_vars['filter'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['filter']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['filters_selection']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['filter']->key => $_smarty_tpl->tpl_vars['filter']->value) {
$_smarty_tpl->tpl_vars['filter']->_loop = true;
?>
								<option value="<?php echo intval($_smarty_tpl->tpl_vars['filter']->value['id_newsletter_pro_filters_selection']);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['filter']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<a id="np-delete-filter-selection" href="javascript:{}" class="btn btn-default btn-margin" style="display: none;">
							<i class="icon icon-trash-o"></i>
							<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</a>
					</div>
					<div class="form-group pull-right">
						<label class="control-label"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Filter Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
						<input id="np-name-filter-selection" class="form-control fixed-width-xxl" type="text">
						<a id="np-add-filter-selection" href="javascript:{}" class="btn btn-default btn-margin">
							<i class="icon icon-plus-square"></i>
							<?php echo smartyTranslate(array('s'=>'Add','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-10 col-sm-offset-2">
			<p class="help-block"><?php echo smartyTranslate(array('s'=>'Select you users with your predefined filters. The filter selection can be applied only to the drop down filters.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
		</div>
	</div>

	<div class="label-on-row">
		<h4>
			<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['VIEW_ACTIVE_ONLY']==true) {?>
				<?php echo smartyTranslate(array('s'=>'Users subscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>

			<?php } else { ?>
				<?php echo smartyTranslate(array('s'=>'Users','mod'=>'newsletterpro'),$_smarty_tpl);?>

			<?php }?>
			: <span id="customers-count">0</span> <span id="customers_filtered"></span>
			<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PS_MULTISHOP_FEATURE_ACTIVE']==true) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['users_lists_shop_count_message']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
		</h4>
		<span id="users-ajax-loader" class="ajax-loader" style="display: none; margin: 0; margin-left: 6px;"></span>
		<div class="clear">&nbsp;</div>
		<div class="separation"></div>
	</div>

	<div class="data-grid-div customers-list-box">
		<table id="customers-list" class="table table-bordered customers-list">
			<thead>
				<tr>
					<th class="chackbox" data-template="chackbox">&nbsp;</th>
					<th class="image" data-field="img_path">&nbsp;</th>
					<th class="company" data-field="company"><?php echo smartyTranslate(array('s'=>'Company','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="firstname" data-field="firstname"><?php echo smartyTranslate(array('s'=>'First Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="lastname" data-field="lastname"><?php echo smartyTranslate(array('s'=>'Last Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="email" data-field="email"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="shop_name" data-field="shop_name"><?php echo smartyTranslate(array('s'=>'Shop Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="newsletter" data-field="newsletter"><?php echo smartyTranslate(array('s'=>'Subscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
		</table>
	</div>

	<div id="visitors-list-display" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['SUBSCRIPTION_ACTIVE']==false) {?>style="display:block;"<?php } else { ?>style="display:none;"<?php }?>>
		<br>
		<div class="label-on-row">
			<h4>
				<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['VIEW_ACTIVE_ONLY']==true) {?>
					<?php echo smartyTranslate(array('s'=>'Visitors subscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="font-weight: normal;"><?php echo smartyTranslate(array('s'=>'(at the Block Newsletter module)','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span> 
				<?php } else { ?>
					<?php echo smartyTranslate(array('s'=>'Visitors','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="font-weight: normal;"><?php echo smartyTranslate(array('s'=>'(at the Block Newsletter module)','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span> 
				<?php }?>
				: <span id="visitors-count">0</span>
				<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PS_MULTISHOP_FEATURE_ACTIVE']==true) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['users_lists_shop_count_message']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
			</h4>
			<span id="visitors-ajax-loader" class="ajax-loader" style="display: none; margin: 0; margin-left: 6px;"></span>
			<div class="clear"></div>
			<div class="separation"></div>
		</div>

		<div class="data-grid-div visitors-list-box">
			<table id="visitors-list" class="table table-bordered visitors-list">
				<thead>
					<tr>
						<th class="chackbox" data-template="chackbox">&nbsp;</th>
						<th class="image" data-field="img_path">&nbsp;</th>
						<th class="email" data-field="email"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
						<th class="shop_name" data-field="shop_name"><?php echo smartyTranslate(array('s'=>'Shop Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
						<th class="ip" data-field="ip_registration_newsletter"><?php echo smartyTranslate(array('s'=>'IP','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
						<th class="np-active" data-field="active"><?php echo smartyTranslate(array('s'=>'Subscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
						<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<div id="visitors-np-list-display" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['SUBSCRIPTION_ACTIVE']==true) {?>style="display:block;"<?php } else { ?>style="display:none;"<?php }?>>
		<br>
		<div class="label-on-row">
			<h4>
				<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['VIEW_ACTIVE_ONLY']==true) {?>
					<?php echo smartyTranslate(array('s'=>'Visitors subscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="font-weight: normal;"><?php echo smartyTranslate(array('s'=>'(at the Newsletter Pro module)','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
				<?php } else { ?>
					<?php echo smartyTranslate(array('s'=>'Visitors','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="font-weight: normal;"><?php echo smartyTranslate(array('s'=>'(at the Newsletter Pro module)','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
				<?php }?>
				 : <span id="visitors-np-count">0</span>
				<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PS_MULTISHOP_FEATURE_ACTIVE']==true) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['users_lists_shop_count_message']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
			</h4>
			<span id="visitors-np-ajax-loader" class="ajax-loader" style="display: none; margin: 0; margin-left: 6px;"></span>
			<div class="clear"></div>
			<div class="separation"></div>
		</div>

		<div class="data-grid-div visitors-np-list-box">
			<table id="visitors-np-list" class="table table-bordered visitors-np-list">
				<thead>
					<tr>
						<th class="chackbox" data-template="chackbox">&nbsp;</th>
						<th class="image" data-field="img_path">&nbsp;</th>
						<th class="firstname" data-field="firstname"><?php echo smartyTranslate(array('s'=>'First Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
						<th class="lastname" data-field="lastname"><?php echo smartyTranslate(array('s'=>'Last Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
						<th class="email" data-field="email"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
						<th class="shop_name" data-field="shop_name"><?php echo smartyTranslate(array('s'=>'Shop Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
						<th class="np-active" data-field="active"><?php echo smartyTranslate(array('s'=>'Subscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
						<?php if (isset($_smarty_tpl->tpl_vars['show_custom_columns_format']->value)&&!empty($_smarty_tpl->tpl_vars['show_custom_columns_format']->value)) {?>
							<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['name']->_loop = false;
 $_smarty_tpl->tpl_vars['column'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['show_custom_columns_format']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
 $_smarty_tpl->tpl_vars['column']->value = $_smarty_tpl->tpl_vars['name']->key;
?>
								<th class="head_custom_column_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['column']->value, ENT_QUOTES, 'UTF-8', true);?>
" data-field="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['column']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</th>
							<?php } ?>
						<?php }?>
						<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<br>
	<div class="label-on-row">
		<h4> 
			<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['VIEW_ACTIVE_ONLY']==true) {?>
				<?php echo smartyTranslate(array('s'=>'Added users subscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>

			<?php } else { ?>
				<?php echo smartyTranslate(array('s'=>'Added users','mod'=>'newsletterpro'),$_smarty_tpl);?>

			<?php }?>
			: <span id="added-count">0</span>
			<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['PS_MULTISHOP_FEATURE_ACTIVE']==true) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['users_lists_shop_count_message']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
		</h4>
		<span id="added-ajax-loader" class="ajax-loader" style="display: none; margin: 0; margin-left: 6px;"></span>
		<div class="clear"></div>
		<div class="separation"></div>
	</div>

	<div class="data-grid-div added-list-box">
		<table id="added-list" class="table table-bordered added-list">
			<thead>
				<tr>
					<th class="chackbox" data-template="chackbox">&nbsp;</th>
					<th class="image" data-field="img_path">&nbsp;</th>
					<th class="firstname" data-field="firstname"><?php echo smartyTranslate(array('s'=>'First Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="lastname" data-field="lastname"><?php echo smartyTranslate(array('s'=>'Last Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="email" data-field="email"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="shop_name" data-field="shop_name"><?php echo smartyTranslate(array('s'=>'Shop Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="np-active" data-field="active"><?php echo smartyTranslate(array('s'=>'Subscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
		</table>
	</div>
	
	<br>

	<div class="add-exclusion-box">
		<div class="form-group clearfix">
			<span><?php echo smartyTranslate(array('s'=>'There are','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="color: red;" id="exclusion-emails-count"><?php echo intval($_smarty_tpl->tpl_vars['exclusion_emails_count']->value);?>
</span> <?php echo smartyTranslate(array('s'=>'excluded emails from the process of sending newsletters.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
		</div>
		<div>
			<a id="btn-add-exclusion" href="javascript:{}" class="btn btn-default btn-add-exclusion"><i class="icon icon-plus-square"></i> <?php echo smartyTranslate(array('s'=>'Add Exclusion Emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
            <a id="btn-view-exclusion" href="javascript:{}" class="btn btn-default btn-view-exclusion"><i class="icon icon-list"></i> <?php echo smartyTranslate(array('s'=>'View Exclusion Emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
			<a id="btn-clear-exclusion" href="javascript:{}" class="btn btn-danger btn-add-exclusion"><span class="btn-ajax-loader"></span><i class="icon icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Clear Exclusion Emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
		</div>
	</div>

	<br>
	
	<h4><?php echo smartyTranslate(array('s'=>'Send newsletters','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>

	<div class="div_userlist">

		<div id="emails-to-send"></div>

		<div id="emails-sent" class="div_userlist"></div>

		<div class="clear">&nbsp;</div>
		
		<div class="form-group clearfix">
			<div class="send-progressbar-box">
				<div id="send-progressbar"></div>
			</div>
		</div>

		<div class="form-group clearfix">
			<div id="last-send-error-div" class="last-send-error-div" style="display: none;">
				<div class="col-sm-12 clearfix">
					<span class="waring-icon pull-left"></span>
					<label class="control-label" style="padding-top: 0; margin-left: 10px;"><?php echo smartyTranslate(array('s'=>'Last error message:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
				</div>
				<div class="col-sm-12 clearfix row">
					<div id="last-send-error" class="alert alert-danger" style="display: none;"></div>
				</div>
			</div>
		</div>

		<div class="form-group clearfix">
			<div id="test-email" class="test-email br-space">
				<div class="form-group clearfix">
					<div class="col-sm-8">
						<div class="col-sm-4">
							<input id="test-email-checkbox" type="checkbox"/>
							<label class="control-label" style="width: auto;" for="test-email-checkbox"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Send a test email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
						</div>
						<div class="col-sm-8">
							<input id="test-email-input" class="form-control fixed-width-xxl" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_email']->value, ENT_QUOTES, 'UTF-8', true);?>
"/>
							<span id="test-email-success-message" class="test-email-success-message" style="display: none;"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<div id="test-send-email-box" class="form-inline" style="display: none;">
							<div class="form-group pull-right btn-margin-left">
								<a id="test-email-button" class="btn btn-default pull-right" href="javascript:{}" onclick="NewsletterProControllers.SendController.sendTestEmail($(this))">
									<span class="btn-ajax-loader"></span>
									<i class="icon icon-envelope"></i> <?php echo smartyTranslate(array('s'=>'Send test','mod'=>'newsletterpro'),$_smarty_tpl);?>

								</a>
							</div>
							<div class="form-group pull-right btn-margin-right">
								<div id="send-test-email-language-switcher"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 clearfix">
					<span id="test-email-message" class="test-email-message">&nbsp;</span>
				</div>
			</div>
		</div>

		<div class="br-space np-send-method-box-">
			<div class="np-send-method-box-left">
				<div id="np-send-method-display" class="np-send-method-display"></div>
				<span id="email-sleep-message">&nbsp;</span>
			</div>
			<div class="np-send-method-box-right">
				<a id="np-btn-performances" href="javascript:{}" class="btn btn-warning pull-right np-btn-performances">
				<i class="icon icon-bolt"></i> <span class="np-button-text"><?php echo smartyTranslate(array('s'=>'Performances & Limits','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></a>
			</div>
			<div class="clear">&nbsp;</div>
		</div>

		<div class="clear" height="0;">&nbsp;</div>
		<br />

		<a id="previous-send-newsletters" href="#createTemplate" class="btn btn-primary pull-left np-send-previous-step" onclick="NewsletterProControllers.NavigationController.goToStep( 4 );">
			&laquo; <?php echo smartyTranslate(array('s'=>'Previous Step','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
		</a>

		<a id="send-newsletters" href="javascript:{}" class="btn btn-success pull-right btn-margin np-send-newsletters" style="display: none;">
			<i class="icon icon-send"></i> <?php echo smartyTranslate(array('s'=>'Send','mod'=>'newsletterpro'),$_smarty_tpl);?>

		</a>

		<a id="new-task" href="javascript:{}" class="btn btn-success pull-right task-button btn-margin np-send-new-task" data-trans-noemail="<?php echo smartyTranslate(array('s'=>'You have not select any email for this task!','mod'=>'newsletterpro'),$_smarty_tpl);?>
" style="display: none;">
			<i class="icon icon-clock-o"></i> <?php echo smartyTranslate(array('s'=>'New Task','mod'=>'newsletterpro'),$_smarty_tpl);?>

		</a>

		<a id="stop-send-newsletters" href="javascript:{}" class="btn btn-danger pull-left btn-margin np-send-stop-newsletters" style="display: none;">
			<i class="icon icon-remove"></i> <?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'newsletterpro'),$_smarty_tpl);?>

		</a>

		<a id="continue-send-newsletters" href="javascript:{}" class="btn btn-success pull-right btn-margin np-send-continue-newsletters" style="display: none;">
			<i class="icon icon-refresh"></i> <?php echo smartyTranslate(array('s'=>'Continue','mod'=>'newsletterpro'),$_smarty_tpl);?>

		</a>

		<a id="pause-send-newsletters" href="javascript:{}" class="btn btn-primary pull-right btn-margin np-send-pause-newsletter" style="display: none; text-transform: capitalize;">
			<i class="icon icon-pause"></i> <?php echo smartyTranslate(array('s'=>'Pause','mod'=>'newsletterpro'),$_smarty_tpl);?>

		</a>
		<div class="clear">&nbsp;</div>
	</div>
</div><?php }} ?>
