<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 15:39:49
         compiled from "/home/koehlert/public_html/admin971jqkmvw/themes/default/template/helpers/modules_list/modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15193632125d59633553e037-55826484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '12f6345bd6ca3fceae1d7e78477672496bf95b0f' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/helpers/modules_list/modal.tpl',
      1 => 1440056610,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15193632125d59633553e037-55826484',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59633553ff78_22565720',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59633553ff78_22565720')) {function content_5d59633553ff78_22565720($_smarty_tpl) {?><div class="modal fade" id="modules_list_container">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><?php echo smartyTranslate(array('s'=>'Recommended Modules and Services'),$_smarty_tpl);?>
</h3>
			</div>
			<div class="modal-body">
				<div id="modules_list_container_tab_modal" style="display:none;"></div>
				<div id="modules_list_loader"><i class="icon-refresh icon-spin"></i></div>
			</div>
		</div>
	</div>
</div>
<?php }} ?>
