<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/csv.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19299868895d5a47a8652730-16822954%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87b5d26495259b9215c572b917a7fcf818f87934' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/csv.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19299868895d5a47a8652730-16822954',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'page_link' => 0,
    'style' => 0,
    'csv_import_files' => 0,
    'file' => 0,
    'export_email_addresses_errors' => 0,
    'error' => 0,
    'LIST_CUSTOMERS' => 0,
    'newsletter_table_exists' => 0,
    'LIST_VISITORS' => 0,
    'LIST_VISITORS_NP' => 0,
    'LIST_ADDED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a86b3609_94214976',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a86b3609_94214976')) {function content_5d5a47a86b3609_94214976($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-csv" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#csv') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-csv" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-csv" style="display: none;">');
	} 
</script>
<?php }?>
	<h4><?php echo smartyTranslate(array('s'=>'Import and export emails addresses from CSV files','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>

	<div id="import-export-container" class="form-group">
		<div class="col-lg-6">
			<h4><?php echo smartyTranslate(array('s'=>'Import','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
			<div class="separation"></div>
			<div class="clear">&nbsp;</div>

			<div class="form-group clearfix">
				<form id="upload-csv-form" class="defaultForm" action="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['page_link']->value);?>
#csv" method="post" enctype="multipart/form-data" <?php if (isset($_smarty_tpl->tpl_vars['style']->value)) {?>style="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['style']->value);?>
"<?php }?>>
					<label class="control-label col-sm-4">
						<span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'CSV file','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</label>
					<div class="col-sm-8 clearfix">
						<input id="upload-csv" class="form-control" type="file" name="upload_csv"/>
					</div>
					<div class="clear">&nbsp;</div>
					<div class="file-msg" id="upload-csv-message"><br></div>
				</form>

				<div class="clear">&nbsp;</div>
				
				<div class="form-group">
					<table id="upload-csv-files" class="table table-bordered upload-csv-files">
						<thead>
							<tr>
								<th class="name"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
								<th class="actions center"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
							</tr>
						</thead>
						<tbody>
						<?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['csv_import_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value) {
$_smarty_tpl->tpl_vars['file']->_loop = true;
?>
							<tr data-name="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['file']->value);?>
">
								<td class="name"> <?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['file']->value);?>
 </td>
								<td class="actions center" style="text-align: center !important;"> 
									<a class="delete-added" href="javascript:{}" style="text-align: center;" onclick="NewsletterProComponents.objs.uploadCSV.deleteItemByName('<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['file']->value);?>
');">
										<i class="icon icon-remove cross-white"></i>
									</a> 
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
		
				<div class="form-group clearfix">
					<div class="input-group">
						<span class="input-group-addon"><?php echo smartyTranslate(array('s'=>'CSV separator','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						<input class="form-control text-center" id="import-separator" type="text" name="separator_csv" maxlength="1" value=";"/>
						<span class="input-group-addon"><?php echo smartyTranslate(array('s'=>'From line','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						<input class="form-control text-center" id="from-linenumber" type="text" name="from_linenumber" value="2"/>
						<span class="input-group-addon"><?php echo smartyTranslate(array('s'=>'To line','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						<input class="form-control text-center" id="to-linenumber" type="text" name="to_linenumber" value="0"/>
					</div>
					<p class="help-block" style="margin-top: 5px;">
						<?php echo smartyTranslate(array('s'=>'Fill a value below %s or %s into the "to line" input field if you want to import all the emails from the .csv file.','sprintf'=>array('2','0'),'mod'=>'newsletterpro'),$_smarty_tpl);?>

					</p>
				</div>
				
				<div class="form-group clearfix">
					<a class="btn btn-default" href="javascript:{}" onclick="NewsletterProComponents.objs.uploadCSV.nextStep( $(this) );" data-bad-separator="<?php echo smartyTranslate(array('s'=>'Bad CSV separator.','mod'=>'newsletterpro'),$_smarty_tpl);?>
" data-no-file="<?php echo smartyTranslate(array('s'=>'You don\'t choose a CSV file.','mod'=>'newsletterpro'),$_smarty_tpl);?>
">
						<span><?php echo smartyTranslate(array('s'=>'Next Step','mod'=>'newsletterpro'),$_smarty_tpl);?>
 
							<i class="icon icon-chevron-right on-right" style="font-size: 11px;"></i>
						</span>
					</a>
				</div>

				<div class="form-group clearfix">
					<div class="alert alert-info">
						<a href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['page_link']->value);?>
&downloadImportSample#csv"><?php echo smartyTranslate(array('s'=>'Download Import Sample','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
						<p><?php echo smartyTranslate(array('s'=>'Use ; or , for separator.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
						<p><?php echo smartyTranslate(array('s'=>'All email are imported in the tab "Send newsletters" on column','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <a href="#sendNewsletters" onclick="NewsletterProControllers.NavigationController.goToStep( 5, $('#added-list') );"><?php echo smartyTranslate(array('s'=>'"Added users"','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>.</p>
						<p><?php echo smartyTranslate(array('s'=>'Available field to import','mod'=>'newsletterpro'),$_smarty_tpl);?>
: <?php echo smartyTranslate(array('s'=>'\"Email\", \"First Name\", \"Last Name\", \"Language ID\", \"Shop ID\", \"Shop Group ID\", \"Registration IP Address\", \"Active\"','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<h4><?php echo smartyTranslate(array('s'=>'Export','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
			<div class="separation"></div>

			<?php if (isset($_smarty_tpl->tpl_vars['export_email_addresses_errors']->value)&&count($_smarty_tpl->tpl_vars['export_email_addresses_errors']->value)) {?>
				<div class="alert alert-danger">
				<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['export_email_addresses_errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value) {
$_smarty_tpl->tpl_vars['error']->_loop = true;
?>
					<div class="clearfix"><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['error']->value);?>
</div>
				<?php } ?>
				</div>
			<?php }?>

			<?php if (isset($_smarty_tpl->tpl_vars['LIST_CUSTOMERS'])) {$_smarty_tpl->tpl_vars['LIST_CUSTOMERS'] = clone $_smarty_tpl->tpl_vars['LIST_CUSTOMERS'];
$_smarty_tpl->tpl_vars['LIST_CUSTOMERS']->value = NewsletterPro::LIST_CUSTOMERS; $_smarty_tpl->tpl_vars['LIST_CUSTOMERS']->nocache = null; $_smarty_tpl->tpl_vars['LIST_CUSTOMERS']->scope = 0;
} else $_smarty_tpl->tpl_vars['LIST_CUSTOMERS'] = new Smarty_variable(NewsletterPro::LIST_CUSTOMERS, null, 0);?>
			<?php if (isset($_smarty_tpl->tpl_vars['LIST_VISITORS'])) {$_smarty_tpl->tpl_vars['LIST_VISITORS'] = clone $_smarty_tpl->tpl_vars['LIST_VISITORS'];
$_smarty_tpl->tpl_vars['LIST_VISITORS']->value = NewsletterPro::LIST_VISITORS; $_smarty_tpl->tpl_vars['LIST_VISITORS']->nocache = null; $_smarty_tpl->tpl_vars['LIST_VISITORS']->scope = 0;
} else $_smarty_tpl->tpl_vars['LIST_VISITORS'] = new Smarty_variable(NewsletterPro::LIST_VISITORS, null, 0);?>
			<?php if (isset($_smarty_tpl->tpl_vars['LIST_VISITORS_NP'])) {$_smarty_tpl->tpl_vars['LIST_VISITORS_NP'] = clone $_smarty_tpl->tpl_vars['LIST_VISITORS_NP'];
$_smarty_tpl->tpl_vars['LIST_VISITORS_NP']->value = NewsletterPro::LIST_VISITORS_NP; $_smarty_tpl->tpl_vars['LIST_VISITORS_NP']->nocache = null; $_smarty_tpl->tpl_vars['LIST_VISITORS_NP']->scope = 0;
} else $_smarty_tpl->tpl_vars['LIST_VISITORS_NP'] = new Smarty_variable(NewsletterPro::LIST_VISITORS_NP, null, 0);?>
			<?php if (isset($_smarty_tpl->tpl_vars['LIST_ADDED'])) {$_smarty_tpl->tpl_vars['LIST_ADDED'] = clone $_smarty_tpl->tpl_vars['LIST_ADDED'];
$_smarty_tpl->tpl_vars['LIST_ADDED']->value = NewsletterPro::LIST_ADDED; $_smarty_tpl->tpl_vars['LIST_ADDED']->nocache = null; $_smarty_tpl->tpl_vars['LIST_ADDED']->scope = 0;
} else $_smarty_tpl->tpl_vars['LIST_ADDED'] = new Smarty_variable(NewsletterPro::LIST_ADDED, null, 0);?>

			<div class="form-group clearfix">
				<label class="control-label col-sm-4 np-control-lable-radio"><?php echo smartyTranslate(array('s'=>'Select List','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
				<div class="col-sm-8">
					<div class="radio">
						<label class="control-label in-win">
							<input class="form-group" type="radio" name="exportEmailAddresses" value="<?php echo intval($_smarty_tpl->tpl_vars['LIST_CUSTOMERS']->value);?>
" checked>
							<?php echo smartyTranslate(array('s'=>'Customers','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</label>
					</div>
					
					<?php if ($_smarty_tpl->tpl_vars['newsletter_table_exists']->value) {?>
					<div class="radio">
						<label class="control-label in-win">
							<input class="form-group" type="radio" name="exportEmailAddresses" value="<?php echo intval($_smarty_tpl->tpl_vars['LIST_VISITORS']->value);?>
">
							<?php echo smartyTranslate(array('s'=>'Visitors (Block Newsletter)','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</label>
					</div>
					<?php }?>

					<div class="radio">
						<label class="control-label in-win">
							<input class="form-group" type="radio" name="exportEmailAddresses" value="<?php echo intval($_smarty_tpl->tpl_vars['LIST_VISITORS_NP']->value);?>
">
							<?php echo smartyTranslate(array('s'=>'Visitors (Newsletter Pro)','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</label>
					</div>

					<div class="radio">
						<label class="control-label in-win">
							<input class="form-group" type="radio" name="exportEmailAddresses" value="<?php echo intval($_smarty_tpl->tpl_vars['LIST_ADDED']->value);?>
">
							<?php echo smartyTranslate(array('s'=>'Added','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</label>
					</div>
				</div>
			</div>

			<div class="form-group clearfix">
				<div class="col-sm-8 col-sm-offset-4">
					<a id="btn-export-email-addresses" href="#csv" class="btn btn-default">
						<?php echo smartyTranslate(array('s'=>'Next Step','mod'=>'newsletterpro'),$_smarty_tpl);?>

						<i class="icon icon-chevron-right on-right"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="clear">&nbsp;</div>
	</div>

	<div id="import-details" class="import-details" style="display: none;">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['import_details_tpl']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
	
	<div id="export-details" class="export-details" style="display: none;">
		<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/export_details.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
</div><?php }} ?>
