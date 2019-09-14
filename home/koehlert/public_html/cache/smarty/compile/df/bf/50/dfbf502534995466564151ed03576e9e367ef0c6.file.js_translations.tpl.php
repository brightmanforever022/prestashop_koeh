<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/javascript/js_translations.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1569698215d5a47a8d60f70-15198939%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dfbf502534995466564151ed03576e9e367ef0c6' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/javascript/js_translations.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1569698215d5a47a8d60f70-15198939',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8eeba21_59706919',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8eeba21_59706919')) {function content_5d5a47a8eeba21_59706919($_smarty_tpl) {?>

<script type="text/javascript">
	NewsletterPro.namespace('translations');
	NewsletterPro.translations = ({
		init: function(box) {
			var self = this;
			return self;
		},
		l: function(namespace) {
			return function(value) {
				if (namespace.hasOwnProperty(value))
					return namespace[value];

				console.log('Translation not found! ('+value+')');
				return value;
			}
		},
		global: {
			'add': "<?php echo smartyTranslate(array('s'=>'add','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			'remove': "<?php echo smartyTranslate(array('s'=>'remove','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
		},
		modules: {
			task: {
				'template not found': "<?php echo smartyTranslate(array('s'=>'Template was not updated!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'send method not update': "<?php echo smartyTranslate(array('s'=>'Send method was not updated!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'smtp not update': "<?php echo smartyTranslate(array('s'=>'SMTP was not updated!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'date not changed': "<?php echo smartyTranslate(array('s'=>'The date cannot be changed','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'email sent': "<?php echo smartyTranslate(array('s'=>'Email sent successfully!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'View': "<?php echo smartyTranslate(array('s'=>'View','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'new task': "<?php echo smartyTranslate(array('s'=>'New Task','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'errors': "<?php echo smartyTranslate(array('s'=>'Errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'step': "<?php echo smartyTranslate(array('s'=>'step','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'close': "<?php echo smartyTranslate(array('s'=>'close','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete': "<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'send': "<?php echo smartyTranslate(array('s'=>'Send','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'pause': "<?php echo smartyTranslate(array('s'=>'Pause','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'continue': "<?php echo smartyTranslate(array('s'=>'Continue','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'test': "<?php echo smartyTranslate(array('s'=>'Test','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete task': "<?php echo smartyTranslate(array('s'=>'The task cannot be deleted!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete send history': "<?php echo smartyTranslate(array('s'=>'The record cannot be deleted!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'less info': "<?php echo smartyTranslate(array('s'=>'less info','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'more info': "<?php echo smartyTranslate(array('s'=>'more info','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'details': "<?php echo smartyTranslate(array('s'=>'Details','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'view': "<?php echo smartyTranslate(array('s'=>'View','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'view template': "<?php echo smartyTranslate(array('s'=>'View Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'veiw in a new window': "<?php echo smartyTranslate(array('s'=>'View in a new window','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'page': "<?php echo smartyTranslate(array('s'=>'Page','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'of': "<?php echo smartyTranslate(array('s'=>'of','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'items': "<?php echo smartyTranslate(array('s'=>'items','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'selected': "<?php echo smartyTranslate(array('s'=>'selected','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'check all': "<?php echo smartyTranslate(array('s'=>'check all','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'unsubscribed': "<?php echo smartyTranslate(array('s'=>'Unsubscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete record': "<?php echo smartyTranslate(array('s'=>'Do you want to delete this record?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'resend': "<?php echo smartyTranslate(array('s'=>'Resend','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'The newsletter is in progress. Do you want to stop the sending process before to proceed?': "<?php echo smartyTranslate(array('s'=>'The newsletter is in progress. Do you want to stop the sending process before to proceed?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",

				'Now': "<?php echo smartyTranslate(array('s'=>'Now','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Done': "<?php echo smartyTranslate(array('s'=>'Done','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Choose Time': "<?php echo smartyTranslate(array('s'=>'Choose Time','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Time': "<?php echo smartyTranslate(array('s'=>'Time','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Hour': "<?php echo smartyTranslate(array('s'=>'Hour','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				
				'CSV Separator': "<?php echo smartyTranslate(array('s'=>'CSV Separator','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Invalid CSV separator.': "<?php echo smartyTranslate(array('s'=>'Invalid CSV separator.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},

			createCustomField: {
				'Create Custom Fields': "<?php echo smartyTranslate(array('s'=>'Create Custom Fields','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'List Columns': "<?php echo smartyTranslate(array('s'=>'List Columns','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Variable Name': "<?php echo smartyTranslate(array('s'=>'Variable Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Add New Variable': "<?php echo smartyTranslate(array('s'=>'Add New Variable','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Type': "<?php echo smartyTranslate(array('s'=>'Type','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Display a new column for the created fields on the list Visitors Subscribed (at the Newsletter Pro module).': "<?php echo smartyTranslate(array('s'=>'Display a new column for the created fields on the list Visitors Subscribed (at the Newsletter Pro module).','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Value': "<?php echo smartyTranslate(array('s'=>'Value','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Add': "<?php echo smartyTranslate(array('s'=>'Add','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Actions': "<?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Value': "<?php echo smartyTranslate(array('s'=>'Value','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Required': "<?php echo smartyTranslate(array('s'=>'Required','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Save Variable': "<?php echo smartyTranslate(array('s'=>'Save Variable','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Variable Name': "<?php echo smartyTranslate(array('s'=>'Variable Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Type': "<?php echo smartyTranslate(array('s'=>'Type','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'none': "<?php echo smartyTranslate(array('s'=>'none','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete': "<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Edit Variable': "<?php echo smartyTranslate(array('s'=>'Edit Variable','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'An error occurred.': "<?php echo smartyTranslate(array('s'=>'An error occurred.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Are you sure you want to do this action? You will lose all the data collected with this field.': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to do this action? You will lose all the data collected with this field.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Edit': "<?php echo smartyTranslate(array('s'=>'Edit','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Update': "<?php echo smartyTranslate(array('s'=>'Update','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Required': "<?php echo smartyTranslate(array('s'=>'Required','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Yes': "<?php echo smartyTranslate(array('s'=>'Yes','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'No': "<?php echo smartyTranslate(array('s'=>'No','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Display Custom Columns': "<?php echo smartyTranslate(array('s'=>'Display Custom Columns','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},

			forward: {
				'delete': "<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete record': "<?php echo smartyTranslate(array('s'=>'The record cannot be deleted!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete added confirm': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to delete the email address?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'details': "<?php echo smartyTranslate(array('s'=>'Details','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'forward to emails': "<?php echo smartyTranslate(array('s'=>'Forward to emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete forwards records error': "<?php echo smartyTranslate(array('s'=>'The records cannot be deleted.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'search': "<?php echo smartyTranslate(array('s'=>'Search','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'clear filters': "<?php echo smartyTranslate(array('s'=>'Clear Filters','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},
			sendManager: {
				'Error': "<?php echo smartyTranslate(array('s'=>'Error','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},
			sendNewsletters: {
				'You must select at least an email address.': "<?php echo smartyTranslate(array('s'=>'You must select at least an email address.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Invalid CSV separator.': "<?php echo smartyTranslate(array('s'=>'Invalid CSV separator.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Export Selection': "<?php echo smartyTranslate(array('s'=>'Export Selection','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'CSV Separator': "<?php echo smartyTranslate(array('s'=>'CSV Separator','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Clear Selection': "<?php echo smartyTranslate(array('s'=>'Clear Selection','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Search': "<?php echo smartyTranslate(array('s'=>'Search','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Country Name': "<?php echo smartyTranslate(array('s'=>'Country Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'ISO Code': "<?php echo smartyTranslate(array('s'=>'ISO Code','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Active': "<?php echo smartyTranslate(array('s'=>'Active','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Filter customers by country': "<?php echo smartyTranslate(array('s'=>'Filter customers by country','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Total spent': "<?php echo smartyTranslate(array('s'=>'Total spent','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Display Custom Columns': "<?php echo smartyTranslate(array('s'=>'Display Custom Columns','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Show Columns': "<?php echo smartyTranslate(array('s'=>'Show Columns','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'none': "<?php echo smartyTranslate(array('s'=>'none','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Details': "<?php echo smartyTranslate(array('s'=>'Details','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'all fields': "<?php echo smartyTranslate(array('s'=>'all fields','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Save': "<?php echo smartyTranslate(array('s'=>'Save','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'An error occured.': "<?php echo smartyTranslate(array('s'=>'An error occured.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'File': "<?php echo smartyTranslate(array('s'=>'File','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Separator': "<?php echo smartyTranslate(array('s'=>'Separator','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'subscribe': "<?php echo smartyTranslate(array('s'=>'Subscribe','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'unsubscribe': "<?php echo smartyTranslate(array('s'=>'Unsubscribe','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'error on subscribe or unsubscribe': "<?php echo smartyTranslate(array('s'=>'There was an error on unsubscribe/subscribe the email addresses from newsletter!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'check all': "<?php echo smartyTranslate(array('s'=>'Check All','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'uncheck all': "<?php echo smartyTranslate(array('s'=>'Uncheck All','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'search': "<?php echo smartyTranslate(array('s'=>'Search','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'groups': "<?php echo smartyTranslate(array('s'=>'Groups','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'languages': "<?php echo smartyTranslate(array('s'=>'Languages','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'shops': "<?php echo smartyTranslate(array('s'=>'Shops','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'CSV Name': "<?php echo smartyTranslate(array('s'=>'CSV Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'gender': "<?php echo smartyTranslate(array('s'=>'Gender','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'subscribed': "<?php echo smartyTranslate(array('s'=>'Subscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'by list of interest': "<?php echo smartyTranslate(array('s'=>'By List Of Interest','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'filters': "<?php echo smartyTranslate(array('s'=>'Filters:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'clear filters': "<?php echo smartyTranslate(array('s'=>'Clear Filters','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'categories': "<?php echo smartyTranslate(array('s'=>'By Categories','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete': "<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete customer': "<?php echo smartyTranslate(array('s'=>'The customer cannot be deleted!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete customer confirm': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to delete the customer?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete visitor': "<?php echo smartyTranslate(array('s'=>'The visitor cannot be deleted!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete visitor confirm': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to delete the visitor email address?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete record': "<?php echo smartyTranslate(array('s'=>'The record cannot be deleted!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'add to exclusion': "<?php echo smartyTranslate(array('s'=>'Add to Exclusion','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete added confirm': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to delete the email address?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'add': "<?php echo smartyTranslate(array('s'=>'Add','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'exclusion emails': "<?php echo smartyTranslate(array('s'=>'Exclusion emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'select emails from history': "<?php echo smartyTranslate(array('s'=>'Select emails from history','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'template name': "<?php echo smartyTranslate(array('s'=>'Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'template date': "<?php echo smartyTranslate(array('s'=>'Date','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'total emails': "<?php echo smartyTranslate(array('s'=>'Total emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'sent success': "<?php echo smartyTranslate(array('s'=>'Sent successes','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'sent errors': "<?php echo smartyTranslate(array('s'=>'Sent errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'template clicks': "<?php echo smartyTranslate(array('s'=>'Clicks','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'template read': "<?php echo smartyTranslate(array('s'=>'Read','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'template actions': "<?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'type': "<?php echo smartyTranslate(array('s'=>'Type','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'remaining email': "<?php echo smartyTranslate(array('s'=>'Remaining email','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'sent email': "<?php echo smartyTranslate(array('s'=>'Sent email','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'add title': "<?php echo smartyTranslate(array('s'=>'Add a new email address','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'category filter title': "<?php echo smartyTranslate(array('s'=>'Filter by category of interest','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'empty list': "<?php echo smartyTranslate(array('s'=>'Empty List','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'empty list error': "<?php echo smartyTranslate(array('s'=>'The list has not been cleared!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'empty list confirm': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to clear the list!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'by purchase': "<?php echo smartyTranslate(array('s'=>'By Purchase','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'by birthday': "<?php echo smartyTranslate(array('s'=>'By Birthday','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'filter by purchase': "<?php echo smartyTranslate(array('s'=>'Filter by purchase','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'filter by birthday': "<?php echo smartyTranslate(array('s'=>'Filter by birthday','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'remove': "<?php echo smartyTranslate(array('s'=>'remove','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'range selection': "<?php echo smartyTranslate(array('s'=>'Range Selection','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'yes': "<?php echo smartyTranslate(array('s'=>'yes','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'no': "<?php echo smartyTranslate(array('s'=>'no','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'bounced emails': "<?php echo smartyTranslate(array('s'=>'Manage bounced emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'remove bounced': "<?php echo smartyTranslate(array('s'=>'Remove Bounced','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete bounced emails': "<?php echo smartyTranslate(array('s'=>'delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'unsubscribe bounced emails': "<?php echo smartyTranslate(array('s'=>'unsubscribe','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'bounced emails method': "<?php echo smartyTranslate(array('s'=>'Bounced emails method','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'apply on the lists': "<?php echo smartyTranslate(array('s'=>'Apply on the lists','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'customers list': "<?php echo smartyTranslate(array('s'=>'Customers list','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'added list': "<?php echo smartyTranslate(array('s'=>'Added list','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'import from csv file': "<?php echo smartyTranslate(array('s'=>'Import emails from a .csv file','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'visitors subscribed at module newsletter pro': "<?php echo smartyTranslate(array('s'=>'Visitors subscribed at module Newsletter Pro','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'visitors subscribed at module block newsletter': "<?php echo smartyTranslate(array('s'=>'Visitors subscribed at module Block Newsletter','mod'=>'newsletterpro'),$_smarty_tpl);?>
",				
				'select the csv file': "<?php echo smartyTranslate(array('s'=>'Select the .CSV file','mod'=>'newsletterpro'),$_smarty_tpl);?>
",				
				'bounced emails info': "<?php echo smartyTranslate(array('s'=>'If you choose the delete method, and the bounced customers will be deleted.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",				
				'confirm delete bounced': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to delete the bounced emails?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",				
				'webhook url': "<?php echo smartyTranslate(array('s'=>'WEBHOOK URL:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",				
				'webhook info': "<?php echo smartyTranslate(array('s'=>'The action argument can have the values \"%s\" or \"%s\".','sprintf'=>array('delete','unsubscribe'),'mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Performances & Limits': "<?php echo smartyTranslate(array('s'=>'Performances & Limits','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Define the sending performances and limits.': "<?php echo smartyTranslate(array('s'=>'Define the sending performances and limits.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Send one newsletter at': "<?php echo smartyTranslate(array('s'=>'Send one newsletter at','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'seconds': "<?php echo smartyTranslate(array('s'=>'seconds','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Antiflood & Speed limits': "<?php echo smartyTranslate(array('s'=>'Antiflood & Speed limits','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Reconnect after': "<?php echo smartyTranslate(array('s'=>'Reconnect after','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'emails sent, and pause': "<?php echo smartyTranslate(array('s'=>'emails sent, and pause','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'seconds': "<?php echo smartyTranslate(array('s'=>'seconds','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Limit': "<?php echo smartyTranslate(array('s'=>'Limit','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'per minute': "<?php echo smartyTranslate(array('s'=>'per minute','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'change limit to MB': "<?php echo smartyTranslate(array('s'=>'change limit to MB','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'change limit to emails': "<?php echo smartyTranslate(array('s'=>'change limit to emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'emails': "<?php echo smartyTranslate(array('s'=>'emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'At least one antiflood option needs to be activated. If you want to activate the other antiflood option select it first.': "<?php echo smartyTranslate(array('s'=>'At least one antiflood option needs to be activated. If you want to activate the other antiflood option select it first.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'(Antiflood) Send #s emails, and pause #s seconds.': "<?php echo smartyTranslate(array('s'=>'(Antiflood) Send #s emails, and pause #s seconds.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'(Speed limits) Limit  #s emails per minute.': "<?php echo smartyTranslate(array('s'=>'(Speed limits) Limit  #s emails per minute.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'(Speed limits) Limit  #s MB per minute.': "<?php echo smartyTranslate(array('s'=>'(Speed limits) Limit  #s MB per minute.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Send one newsletter at #s seconds - (for all connections).': "<?php echo smartyTranslate(array('s'=>'Send one newsletter at #s seconds - (for all connections).','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'No send method was selected.': "<?php echo smartyTranslate(array('s'=>'No send method was selected.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Connection Name': "<?php echo smartyTranslate(array('s'=>'Connection Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Backend limit': "<?php echo smartyTranslate(array('s'=>'Backend limit','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Decrease this number if the newsletter stops from the sending process, and it\'s not continue.': "<?php echo smartyTranslate(array('s'=>'Decrease this number if the newsletter stops from the sending process, and it\'s not continue.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Connection Type': "<?php echo smartyTranslate(array('s'=>'Connection Type','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Actions': "<?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Add or remove connections': "<?php echo smartyTranslate(array('s'=>'Add or remove connections','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Leave the table empty if you want to have a single connection with the default configuration': "<?php echo smartyTranslate(array('s'=>'Leave the table empty if you want to have a single connection with the default configuration','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Add Connection': "<?php echo smartyTranslate(array('s'=>'Add Connection','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'You smtp value has been selected.': "<?php echo smartyTranslate(array('s'=>'You smtp value has been selected.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'The connection cannot be deleted.': "<?php echo smartyTranslate(array('s'=>'The connection cannot be deleted.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Don\'t add to many connections from the same server. You will risk to be banned.': "<?php echo smartyTranslate(array('s'=>'Don\'t add to many connections from the same server. You will risk to be banned.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Test Connection': "<?php echo smartyTranslate(array('s'=>'Test Connection','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Test': "<?php echo smartyTranslate(array('s'=>'Test','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'#s connections': "<?php echo smartyTranslate(array('s'=>'#s connections','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'for all connections': "<?php echo smartyTranslate(array('s'=>'for all connections','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'for each connection': "<?php echo smartyTranslate(array('s'=>'for each connection','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'With #s connections send #s emails, and pause #s seconds.': "<?php echo smartyTranslate(array('s'=>'With #s connections send #s emails, and pause #s seconds.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'With #s connections limit #s emails per minute.': "<?php echo smartyTranslate(array('s'=>'With #s connections limit #s emails per minute.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Are you sure you want to add a new connection? If you don\'t setup the connections properly you risk to be banned.': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to add a new connection? If you don\'t setup the connections properly you risk to be banned.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Total spent filter': "<?php echo smartyTranslate(array('s'=>'Total spent filter','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},

			frontSubscription: {
				'manage list of interest': "<?php echo smartyTranslate(array('s'=>'Manage List of Interest','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'add': "<?php echo smartyTranslate(array('s'=>'Add','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'create backup': "<?php echo smartyTranslate(array('s'=>'Create Backup','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'load backup': "<?php echo smartyTranslate(array('s'=>'Restore','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'update': "<?php echo smartyTranslate(array('s'=>'Update','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete': "<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete record confirm': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to delete this record?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete record error': "<?php echo smartyTranslate(array('s'=>'An error occurred when deleting the record.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'update': "<?php echo smartyTranslate(array('s'=>'Update','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'error when updateing the record': "<?php echo smartyTranslate(array('s'=>'An error occurred when updateing the record.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'default lang empty': "<?php echo smartyTranslate(array('s'=>'The default language field cannot be empty.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'unsubscribe': "<?php echo smartyTranslate(array('s'=>'Unsubscribe','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'subscribe': "<?php echo smartyTranslate(array('s'=>'Subscribe','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'the default template cannot be deleted': "<?php echo smartyTranslate(array('s'=>'The default template cannot be deleted.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'view available variables': "<?php echo smartyTranslate(array('s'=>'Available variables for the subscription template','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'backup name': "<?php echo smartyTranslate(array('s'=>'Insert the name of the backup.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'load subscription template backup': "<?php echo smartyTranslate(array('s'=>'Load subscription template backup','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'load': "<?php echo smartyTranslate(array('s'=>'Load','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'load backup confirm': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to load the backup. All the current data will be lost.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},

			settings: {
				'backup name': "<?php echo smartyTranslate(array('s'=>'Insert the name of the backup.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'load backup': "<?php echo smartyTranslate(array('s'=>'Restore','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete': "<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'load': "<?php echo smartyTranslate(array('s'=>'Load','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'load backup confirm': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to restore the backup. All the current data will be lost.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete record error': "<?php echo smartyTranslate(array('s'=>'An error occurred when deleting the record.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete record confirm': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to delete this record?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Left Menu': "<?php echo smartyTranslate(array('s'=>'Left Menu','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Top Menu': "<?php echo smartyTranslate(array('s'=>'Top Menu','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Log': "<?php echo smartyTranslate(array('s'=>'Log','mod'=>'newsletterpro'),$_smarty_tpl);?>
"
			},

			createTemplate: {
				'delete template': "<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'confirm delete template': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to delete the template?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete template error': "<?php echo smartyTranslate(array('s'=>'The template cannot be deleted!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'save failure' : "<?php echo smartyTranslate(array('s'=>'Save failure!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'save as template' : "<?php echo smartyTranslate(array('s'=>'Insert the new template name:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				
			},

			selectProducts: {
				'auto': "<?php echo smartyTranslate(array('s'=>'auto','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete template': "<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'confirm delete template': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to delete the template?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete template error': "<?php echo smartyTranslate(array('s'=>'The template cannot be deleted!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'image size': "<?php echo smartyTranslate(array('s'=>'Image Size:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'language': "<?php echo smartyTranslate(array('s'=>'Language:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'currency': "<?php echo smartyTranslate(array('s'=>'Currency:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'products per row': "<?php echo smartyTranslate(array('s'=>'Products per row:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'add image size': "<?php echo smartyTranslate(array('s'=>'Add Image Size','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'customer groups': "<?php echo smartyTranslate(array('s'=>'Customer Default Group','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'default': "<?php echo smartyTranslate(array('s'=>'default','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},

			mailChimp: {
				'Language': "<?php echo smartyTranslate(array('s'=>'Language','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Display first #s errors:': "<?php echo smartyTranslate(array('s'=>'Display first #s errors:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Export': "<?php echo smartyTranslate(array('s'=>'Export','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'MailChimp Name': "<?php echo smartyTranslate(array('s'=>'MailChimp Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
",

				'confirm uninstall chimp': "<?php echo smartyTranslate(array('s'=>'Are you sure you want to uninstall the mail chimp extension?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'import template from chimp': "<?php echo smartyTranslate(array('s'=>'Import template from Mail Chimp','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'actions': "<?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Export Template To MailChimp': "<?php echo smartyTranslate(array('s'=>'Export Template To MailChimp','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'name': "<?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Template Name': "<?php echo smartyTranslate(array('s'=>'Template Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'layout': "<?php echo smartyTranslate(array('s'=>'Layout','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'category': "<?php echo smartyTranslate(array('s'=>'Category','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'preview image': "<?php echo smartyTranslate(array('s'=>'Preview Image','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'date created': "<?php echo smartyTranslate(array('s'=>'Date Created','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'active': "<?php echo smartyTranslate(array('s'=>'Active','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'preview': "<?php echo smartyTranslate(array('s'=>'Preview','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'import': "<?php echo smartyTranslate(array('s'=>'Import','mod'=>'newsletterpro'),$_smarty_tpl);?>
",

				'user template': "<?php echo smartyTranslate(array('s'=>'User Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'base template': "<?php echo smartyTranslate(array('s'=>'Base Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'gallery template': "<?php echo smartyTranslate(array('s'=>'Gallery Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'template name': "<?php echo smartyTranslate(array('s'=>'Template name:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'import failure': "<?php echo smartyTranslate(array('s'=>'The template cannot be imported.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'an error occurred when updating the configuration': "<?php echo smartyTranslate(array('s'=>'An error occurred when updating the configuration.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},

			manageImages: {
				'view image': "<?php echo smartyTranslate(array('s'=>'View','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete image': "<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'delete image error': "<?php echo smartyTranslate(array('s'=>'The image cannot be deleted.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},

			gkProductList: {
				'add': "<?php echo smartyTranslate(array('s'=>'add','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'remove': "<?php echo smartyTranslate(array('s'=>'remove','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},

		},
		components: {
			ProductSelection: {
				'Edit': "<?php echo smartyTranslate(array('s'=>'Edit','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'ID': "<?php echo smartyTranslate(array('s'=>'ID','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Image': "<?php echo smartyTranslate(array('s'=>'Image','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Group': "<?php echo smartyTranslate(array('s'=>'Group','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Name': "<?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Color': "<?php echo smartyTranslate(array('s'=>'Color','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Reference': "<?php echo smartyTranslate(array('s'=>'Reference','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Price': "<?php echo smartyTranslate(array('s'=>'Price','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Availalbe Date': "<?php echo smartyTranslate(array('s'=>'Availalbe Date','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Actions': "<?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},
			NewsletterTemplate: {
				'Enter the template name.': "<?php echo smartyTranslate(array('s'=>'Enter the template name.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Do you want to render the template variables?': "<?php echo smartyTranslate(array('s'=>'Do you want to render the template variables?','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},
			SubscriptionTemplate: {
				'error on set tiny content': "<?php echo smartyTranslate(array('s'=>'An error occurred when setting the tinymce content.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'insert the template name': "<?php echo smartyTranslate(array('s'=>'Insert the template name.','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},
			EmailsToSend: {
				'Emails to send:': "<?php echo smartyTranslate(array('s'=>'Emails to send:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'remaining': "<?php echo smartyTranslate(array('s'=>'remaining','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},
			EmailsSent: {
				'Emails sent:': "<?php echo smartyTranslate(array('s'=>'Emails sent:','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'sent': "<?php echo smartyTranslate(array('s'=>'sent','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'errors': "<?php echo smartyTranslate(array('s'=>'errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'forwarders': "<?php echo smartyTranslate(array('s'=>'forwarders','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'Sent errors': "<?php echo smartyTranslate(array('s'=>'Sent errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			},
			SyncNewsletters: {
				'Error ocurred at newsletter synchronisation': "<?php echo smartyTranslate(array('s'=>'Error ocurred at newsletter synchronisation','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				'The login session has expired. You must refresh the browser and login again. The next time when you are login check the button \"Stay logged in\".': "<?php echo smartyTranslate(array('s'=>'The login session has expired. You must refresh the browser and login again. The next time when you are login check the button \"Stay logged in\".','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			}
		},

		constrollers: {
			'no email selected': "<?php echo smartyTranslate(array('s'=>'You have to select the email addresses to send newsletters!','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			'view available variables': "<?php echo smartyTranslate(array('s'=>'Available variables for the newsletter template','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			'view available variables product': "<?php echo smartyTranslate(array('s'=>'Available variables for product template','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			'forwards': "<?php echo smartyTranslate(array('s'=>'forwards','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			'forward': "<?php echo smartyTranslate(array('s'=>'forward','mod'=>'newsletterpro'),$_smarty_tpl);?>
",			
		},
	}.init(NewsletterPro));
</script><?php }} ?>
