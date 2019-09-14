<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/history.tpl" */ ?>
<?php /*%%SmartyHeaderCode:627124325d5a47a8934764-14658118%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3dd97d687d3e0442c7d2f3260f51a03a9d0afabd' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/history.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '627124325d5a47a8934764-14658118',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a896a2c8_08936574',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a896a2c8_08936574')) {function content_5d5a47a896a2c8_08936574($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#history') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">');
	} 
</script>
<?php }?>

	<div class="clear">&nbsp;</div>
	<h4><?php echo smartyTranslate(array('s'=>'History','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>
	<div style="margin-bottom: 5px;">
		<h4 style="float: left;"><?php echo smartyTranslate(array('s'=>'Send history','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
		<a  href="javascript:{}" id="clear-send-history" class="btn btn-default pull-right btn-margin"><i class="icon icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Clear Send History','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
		<a  href="javascript:{}" id="clear-send-details" class="btn btn-default pull-right btn-margin"><span class="btn-ajax-loader" style="display: none;"></span><i class="icon icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Clear Details','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
		<div class="clear"></div>
		<div class="separation"></div>
	</div>

	<table id="send-history" class="table table-bordered send-history">
		<thead>
			<tr>
				<th class="template" data-field="template"><?php echo smartyTranslate(array('s'=>'Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="date" data-field="date"><?php echo smartyTranslate(array('s'=>'Date','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="emails-count" data-field="emails_count"><?php echo smartyTranslate(array('s'=>'Total emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="emails-success" data-field="emails_success"><?php echo smartyTranslate(array('s'=>'Succeed','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="emails-error" data-field="emails_error"><?php echo smartyTranslate(array('s'=>'Errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="clicks" data-field="clicks"><?php echo smartyTranslate(array('s'=>'Clicks','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="opened" data-field="opened"><?php echo smartyTranslate(array('s'=>'Read','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="unsubscribed" data-field="unsubscribed"><?php echo smartyTranslate(array('s'=>'Unsubscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="fwd_unsubscribed" data-field="fwd_unsubscribed"><?php echo smartyTranslate(array('s'=>'Forward Uns','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="emails-msg" data-field="error_msg"><?php echo smartyTranslate(array('s'=>'Messages','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
	</table>
	<br>
	<div style="margin-bottom: 5px;">
		<h4 style="float: left;"><?php echo smartyTranslate(array('s'=>'Task history','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>

		<a  href="javascript:{}" id="clear-task-history" class="btn btn-default pull-right btn-margin"><i class="icon icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Clear Task History','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
		<a  href="javascript:{}" id="clear-task-details" class="btn btn-default pull-right btn-margin"><span class="btn-ajax-loader" style="display: none;"></span><i class="icon icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Clear Details','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
		<div class="clear"></div>
		<div class="separation"></div>
	</div>
	<table id="task-history" class="table table-bordered task-history">
		<thead>
			<tr>
				<th class="template" data-field="template"><?php echo smartyTranslate(array('s'=>'Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="date-start" data-field="date_start"><?php echo smartyTranslate(array('s'=>'Start Date','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="emails-count" data-field="emails_count"><?php echo smartyTranslate(array('s'=>'Total emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="emails-success" data-field="emails_success"><?php echo smartyTranslate(array('s'=>'Succeed','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="emails-error" data-field="emails_error"><?php echo smartyTranslate(array('s'=>'Errors','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="clicks" data-field="clicks"><?php echo smartyTranslate(array('s'=>'Clicks','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="opened" data-field="opened"><?php echo smartyTranslate(array('s'=>'Read','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="unsubscribed" data-field="unsubscribed"><?php echo smartyTranslate(array('s'=>'Unsubscribed','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="fwd_unsubscribed" data-field="fwd_unsubscribed"><?php echo smartyTranslate(array('s'=>'Forward Uns.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="emails-msg" data-field="error_msg"><?php echo smartyTranslate(array('s'=>'Messages','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
	</table>
</div><?php }} ?>
