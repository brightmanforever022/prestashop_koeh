<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/task.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1118722605d5a47a8b88360-91861913%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ffe642ead9863e3a9ebe545427361790086093b6' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/task.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1118722605d5a47a8b88360-91861913',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'cron_link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8baceb4_88082077',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8baceb4_88082077')) {function content_5d5a47a8baceb4_88082077($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#task') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">');
	} 
</script>
<?php }?>

	<h4><?php echo smartyTranslate(array('s'=>'Tasks','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>
	<table id="task-list" class="table table-bordered task-list">
		<thead>
			<tr>
				<th class="template" data-field="template"><?php echo smartyTranslate(array('s'=>'Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="date-start" data-field="date_start"><?php echo smartyTranslate(array('s'=>'Start Date','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="smtp-select" data-template="smtp"><?php echo smartyTranslate(array('s'=>'Send Method','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="task-active" data-field="active"><?php echo smartyTranslate(array('s'=>'Active','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="task-status" data-field="status"><?php echo smartyTranslate(array('s'=>'Status','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
	</table>
	<br>
	<div style="display: block; height: auto; background-position: 5px; padding-top: 10px; padding-bottom: 10px;" class="alert alert-info">
		<p style="margin-top: 0;" class="cron-link"><span style="color: black;"><?php echo smartyTranslate(array('s'=>'CRON URL:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span> <span class="icon icon-cron-link"></span><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['cron_link']->value);?>
</p>
		<p style="margin-bottom: 0;"><?php echo smartyTranslate(array('s'=>'To make tasks to run automatically every day set the CRON job from your website control panel (Plesk, cPanel, DirectAdmin, etc.). Run this script every %s minutes.','sprintf'=>array('1'),'mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
		<div id="task-more-info" style="display: none;">
			<div class="clear" style="height: 5px;"></div>
			<p>
				<?php echo smartyTranslate(array('s'=>'Cron jobs allow you to automate certain commands or scripts on your site. You can set a command or script to run at a specific time every day, week, etc.','mod'=>'newsletterpro'),$_smarty_tpl);?>

			</p>
			<p>
				<span style="color: red;"><?php echo smartyTranslate(array('s'=>'Warning:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span> <?php echo smartyTranslate(array('s'=>'A good knowledge of Linux commands may be necessary before you can use cron jobs effectively. Check your script with your hosting administrator before adding a cron job.','mod'=>'newsletterpro'),$_smarty_tpl);?>

			</p>
			<div class="clear" style="height: 5px;"></div>
			<p><?php echo smartyTranslate(array('s'=>'If your server sends you a CRON "ERROR 406: Not Acceptable", add an htaccess file in the module containing the following information:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
			<span>
				&lt;IfModule mod_security.c&gt;<br>SecFilterEngine Off<br>SecFilterScanPOST Off<br>&lt;/IfModule&gt;
			</span>
		</div>
		<a id="task-more-info-button" class="pull-right" href="javascript:{}" style="height: 8px; overflow: visible;"><?php echo smartyTranslate(array('s'=>'more info','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
		<div class="clear"></div>
	</div>
</div><?php }} ?>
