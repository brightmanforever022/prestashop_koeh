<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/export_details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21374895035d5a47a86dd3c1-90006866%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '284834c62b17152734824db42b5741427b2625f0' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/export_details.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21374895035d5a47a86dd3c1-90006866',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_link' => 0,
    'style' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a86ecec7_71939481',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a86ecec7_71939481')) {function content_5d5a47a86ecec7_71939481($_smarty_tpl) {?>

<div class="form-group clearfix">
	<a id="np-export-email-addresses-back" class="btn btn-default pull-left" href="javascript:{}">
		<i class="icon icon-chevron-left on-left" style="font-size: 11px;"></i>
		<span><?php echo smartyTranslate(array('s'=>'Go Back','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
	</a>
</div>

<div class="clearfix">
	<form id="export-csv-form" class="defaultForm" action="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['page_link']->value);?>
#csv" method="post" enctype="multipart/form-data" <?php if (isset($_smarty_tpl->tpl_vars['style']->value)) {?>style="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['style']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>>
		<input type="hidden" name="export_email_addresses" value="1">
		<input id="export-csv-list-ref" type="hidden" name="list_ref" value="0">

		<div class="form-group clearfix">
			<label class="control-label col-sm-2">
				<span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'CSV separator','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
			</label>
			<div class="col-sm-3">
				<input class="form-control fixed-width-xs text-center" type="text" name="csv_separator" maxlength="1" value=";"/>
			</div>
			<div class="col-sm-7">
				<a id="btn-export-csv" href="javascript:{}" class="btn btn-default">
					<i class="icon icon-download"></i>
					<?php echo smartyTranslate(array('s'=>'Export','mod'=>'newsletterpro'),$_smarty_tpl);?>

				</a>
			</div>
		</div>

		<div class="form-group clearfix">
			<label class="control-label col-sm-2 np-control-lable-checkbox"><?php echo smartyTranslate(array('s'=>'Columns','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
			<div id="np-export-email-options" class="col-sm-3">
			</div>
			<div class="col-sm-7">
				<a id="btn-export-csv-checkall" href="javascript:{}" class="btn btn-default">
					<i class="icon icon-check-circle"></i>
					<?php echo smartyTranslate(array('s'=>'Check All','mod'=>'newsletterpro'),$_smarty_tpl);?>

				</a>
			</div>
		</div>
	</form>
</div> 
<?php }} ?>
