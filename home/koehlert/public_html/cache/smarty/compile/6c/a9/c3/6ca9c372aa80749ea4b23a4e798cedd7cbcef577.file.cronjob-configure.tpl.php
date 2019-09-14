<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 20:50:48
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/cronjob-configure.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11179118645d603588c1c146-83774029%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6ca9c372aa80749ea4b23a4e798cedd7cbcef577' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/cronjob-configure.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11179118645d603588c1c146-83774029',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cronjobs_installed' => 0,
    'module_cronjobs_url' => 0,
    'admin_module_url' => 0,
    'cron_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d603588c4fed4_75628924',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d603588c4fed4_75628924')) {function content_5d603588c4fed4_75628924($_smarty_tpl) {?>
<div class="panel" id="fieldset_0">
	<div class="panel-heading">
		<i class="flaticon-stopwatch6"></i> <?php echo smartyTranslate(array('s'=>'Automated task','mod'=>'tacartreminder'),$_smarty_tpl);?>

	</div>
	<div class="ta-alert alert-info">
		<?php echo smartyTranslate(array('s'=>'To run autonomously you need to add a cron task.','mod'=>'tacartreminder'),$_smarty_tpl);?>
<br/>
	</div>
	<b><?php echo smartyTranslate(array('s'=>'For this operation, the module provides many possible solutions, so you can choose the most appropriate solution from the ones shown below','mod'=>'tacartreminder'),$_smarty_tpl);?>
 : </b>
	<br/>
	<h4><?php echo smartyTranslate(array('s'=>'Easy Solution / use cronjobs module','mod'=>'tacartreminder'),$_smarty_tpl);?>
</h4>
	<?php if ($_smarty_tpl->tpl_vars['cronjobs_installed']->value) {?>
	<div class="ta-alert alert-success">
		<?php echo smartyTranslate(array('s'=>'"Cronjobs" module is installed and active. You can edit the cron task with this link','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<a href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['module_cronjobs_url']->value);?>
" target="_blank" class="btn btn-default">Edit</a>
	</div>
	
	<?php } else { ?>
	<div class="ta-alert alert-warning">
		<?php echo smartyTranslate(array('s'=>'The "cronjobs" module developped by PrestaShop is not installed or disabled. Search for the module and install it in your back office.','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<a href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['admin_module_url']->value);?>
&module_name=cronjobs" target="_blank" class="btn btn-default">Search</a>
	</div>
	<?php }?>
	<h4><?php echo smartyTranslate(array('s'=>'OR','mod'=>'tacartreminder'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Advanced Solution / edit your server crontab','mod'=>'tacartreminder'),$_smarty_tpl);?>
</h4>
	<?php echo smartyTranslate(array('s'=>'Add the following lines to the crontab of your server :','mod'=>'tacartreminder'),$_smarty_tpl);?>

	<p style="padding:5px;margin-top:10px;border-radius:5px;border:1px solid #CECECE;">
		*/15 * * * * curl "<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['cron_url']->value);?>
"
	</p>
	<p>
	<?php echo smartyTranslate(array('s'=>'In this example, the module will check for reminders to run every 15 minutes.','mod'=>'tacartreminder'),$_smarty_tpl);?>

	</p>
	<br/>
	<h4><?php echo smartyTranslate(array('s'=>'OR','mod'=>'tacartreminder'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Manual Solution / browser URL','mod'=>'tacartreminder'),$_smarty_tpl);?>
</h4>
	<p>
		<?php echo smartyTranslate(array('s'=>'Copy link into your browser or click on the following link','mod'=>'tacartreminder'),$_smarty_tpl);?>
<br/>
		<a href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['cron_url']->value);?>
"><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['cron_url']->value);?>
</a>
	</p>
</div><?php }} ?>
