<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/module_info.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17286833395d5a47a86444c7-14429866%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2eedc6ef780a3546cbfe2cf4003bd36dbabf4f82' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/module_info.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17286833395d5a47a86444c7-14429866',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'update' => 0,
    'CONFIGURATION' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8650306_60849532',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8650306_60849532')) {function content_5d5a47a8650306_60849532($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['update']->value['needs_update']==true) {?>
<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/module_update.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php } elseif ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['SHOW_CLEAR_CACHE']==true) {?>
<div id="clear-cache-box" class="form-group clearfix">
	<div class="col-sm-12">
		<div class="alert alert-danger error clearfix">
			<div class="clearfix">
				<?php echo smartyTranslate(array('s'=>'The module has been updated. It\'s required to clear the prestashop cache from "Advanced Parameters" > "Performance", and also the web browser cache.','mod'=>'newsletterpro'),$_smarty_tpl);?>

			</div>
			<div class="clearfix">
				<?php echo smartyTranslate(array('s'=>'Click on the "I Agree" button for hiding this message in the future.','mod'=>'newsletterpro'),$_smarty_tpl);?>

			</div>
			<a href="javascript:{}" class="btn btn-default" onclick="NewsletterProControllers.ClearCacheController.clear($(this));">
				<i class="icon icon-check-circle"></i>
				<?php echo smartyTranslate(array('s'=>'I Agree','mod'=>'newsletterpro'),$_smarty_tpl);?>

			</a>
		</div>
	</div>
</div>
<?php }?><?php }} ?>
