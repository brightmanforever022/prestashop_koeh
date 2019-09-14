<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 15:39:49
         compiled from "/home/koehlert/public_html/admin971jqkmvw/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20733520515d596335449399-73070760%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d1fb330893266d3d4ade0750d53af602d86740c' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/content.tpl',
      1 => 1440056612,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20733520515d596335449399-73070760',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59633544ed82_87104365',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59633544ed82_87104365')) {function content_5d59633544ed82_87104365($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div><?php }} ?>
