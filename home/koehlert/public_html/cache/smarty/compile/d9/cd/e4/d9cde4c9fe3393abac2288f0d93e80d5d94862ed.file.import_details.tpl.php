<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/import_details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2755639065d5a47a86b71d5-38142655%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd9cde4c9fe3393abac2288f0d93e80d5d94862ed' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/import_details.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2755639065d5a47a86b71d5-38142655',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'rows' => 0,
    'count' => 0,
    'valid' => 0,
    'msg' => 0,
    'status' => 0,
    'header' => 0,
    'head' => 0,
    'row' => 0,
    'line' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a86db542_96188012',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a86db542_96188012')) {function content_5d5a47a86db542_96188012($_smarty_tpl) {?>

<div class="form-group clearfix">
	<a class="btn btn-default pull-left" href="javascript:{}" onclick="NewsletterProComponents.objs.uploadCSV.geBack();"><i class="icon icon-chevron-left on-left" style="font-size: 11px;"></i> <span><?php echo smartyTranslate(array('s'=>'Go Back','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></a>

	<?php if (isset($_smarty_tpl->tpl_vars['rows']->value)) {?>
		<span class="import-info"><?php echo smartyTranslate(array('s'=>'There are','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['count']->value, ENT_QUOTES, 'UTF-8', true);?>
 <?php echo smartyTranslate(array('s'=>'rows out of which','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="color: #5C8A2D;"><?php echo strval($_smarty_tpl->tpl_vars['valid']->value);?>
</span> <?php echo smartyTranslate(array('s'=>'has valid emails.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
		<a class="btn btn-default pull-right" href="javascript:{}" onclick="NewsletterProControllers.NavigationController.viewImported();"><i class="icon icon-eye"></i> <?php echo smartyTranslate(array('s'=>'View Imported List','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
	<?php } elseif (isset($_smarty_tpl->tpl_vars['msg']->value)) {?>
		<span class="<?php if ($_smarty_tpl->tpl_vars['status']->value==true) {?>success-msg<?php } else { ?>error-msg<?php }?>"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['msg']->value, ENT_QUOTES, 'UTF-8', true);?>
</span>
	<?php }?>
</div>

<?php if (isset($_smarty_tpl->tpl_vars['rows']->value)) {?>
<table class="table">
	<thead>
		<tr>
			<?php  $_smarty_tpl->tpl_vars['head'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['head']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['header']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['head']->key => $_smarty_tpl->tpl_vars['head']->value) {
$_smarty_tpl->tpl_vars['head']->_loop = true;
?>
				<th><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['head']->value, ENT_QUOTES, 'UTF-8', true);?>
</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>			
		<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rows']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
		<tr>
			<?php  $_smarty_tpl->tpl_vars['line'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['line']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['row']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['line']->key => $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
?>
			<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['line']->value, ENT_QUOTES, 'UTF-8', true);?>
</td>
			<?php } ?>	
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php }?>
<div class="clear"></div><?php }} ?>
