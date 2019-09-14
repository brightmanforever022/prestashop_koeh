<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/forward.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19079193615d5a47a8c5d7a7-49890586%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b06498eb1b642e475a2c155d3237b09115e8f72' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/forward.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19079193615d5a47a8c5d7a7-49890586',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'CONFIGURATION' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8c79b18_97185788',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8c79b18_97185788')) {function content_5d5a47a8c79b18_97185788($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#forward') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">');
	} 
</script>
<?php }?>
	<div class="clear">&nbsp;</div>
	<h4><?php echo smartyTranslate(array('s'=>'Forward','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>

	<?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['FWD_FEATURE_ACTIVE']==0) {?>
	<div style="margin-bottom: 5px;" class="alert alert-warning clearfix">
		<?php echo smartyTranslate(array('s'=>'The forward feature is not activated for you customers. Go to the settings tab to activate it.','mod'=>'newsletterpro'),$_smarty_tpl);?>

		<div class="clear"></div>
	</div>
	<?php }?>

	<div class="form-group clearfix">
		<h4 style="float: left;"><?php echo smartyTranslate(array('s'=>'Active forwarders','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>

		<a href="javascript:{}" id="clear-forwarders" class="btn btn-default" style="float: right;">
			<i class="icon icon-eraser"></i>
			<?php echo smartyTranslate(array('s'=>'Clear Forwarders','mod'=>'newsletterpro'),$_smarty_tpl);?>

		</a>
		<div class="clear"></div>
		<div class="separation"></div>
	</div>

	<table id="forward-list" class="table table-bordered forward-list">
		<thead>
			<tr>
				<th class="count" data-template="count"><?php echo smartyTranslate(array('s'=>'Forwarders','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="from" data-field="from"><?php echo smartyTranslate(array('s'=>'Forwarder Email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="date_add" data-field="date_add"><?php echo smartyTranslate(array('s'=>'Date Added','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
	</table>

</div><?php }} ?>
