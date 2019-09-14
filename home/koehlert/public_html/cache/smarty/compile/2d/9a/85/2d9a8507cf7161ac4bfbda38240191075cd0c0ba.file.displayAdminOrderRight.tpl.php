<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:44:02
         compiled from "/home/koehlert/public_html/modules/khlbasic//views/templates/hook/displayAdminOrderRight.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4864623475d596432166ab8-46605271%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d9a8507cf7161ac4bfbda38240191075cd0c0ba' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlbasic//views/templates/hook/displayAdminOrderRight.tpl',
      1 => 1537282402,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4864623475d596432166ab8-46605271',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_images_download_url' => 0,
    'order_eans_download_url' => 0,
    'link' => 0,
    'id_order' => 0,
    'order_types' => 0,
    'order_type_selected' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596432178b11_47238560',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596432178b11_47238560')) {function content_5d596432178b11_47238560($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/home/koehlert/public_html/tools/smarty/plugins/function.html_options.php';
?><div class="col-lg-12">
	<div class="panel">
    <a href="<?php echo $_smarty_tpl->tpl_vars['order_images_download_url']->value;?>
" class="btn btn-primary" target="_blank">Download order images</a>
    &nbsp;
    <a href="<?php echo $_smarty_tpl->tpl_vars['order_eans_download_url']->value;?>
" class="btn btn-primary" target="_blank">Download order EANs</a>
    </div>
</div>

<div class="col-lg-12">
	<div class="panel">
	<div class="panel-body">
	<form action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminOrders');?>
&id_order=<?php echo $_smarty_tpl->tpl_vars['id_order']->value;?>
" method="post">
		<div class="col-lg-3"><label>Order type</label></div>
		<div class="col-lg-7"><?php echo smarty_function_html_options(array('name'=>'id_order_type','options'=>$_smarty_tpl->tpl_vars['order_types']->value,'selected'=>$_smarty_tpl->tpl_vars['order_type_selected']->value),$_smarty_tpl);?>
</div>
		<div class="col-lg-2">
			<button type="submit" name="submitIdOrderType" class="btn btn-default"><?php echo smartyTranslate(array('s'=>'Save','mod'=>'khlbasic'),$_smarty_tpl);?>
</button>
		</div>
	</form>
	</div>
    </div>
</div><?php }} ?>
