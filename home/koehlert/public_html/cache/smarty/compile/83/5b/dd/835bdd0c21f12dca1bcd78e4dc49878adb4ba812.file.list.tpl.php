<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 15:25:08
         compiled from "/home/koehlert/public_html/modules/shopcomments/views/templates/admin/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9800508435d5d4634a2a634-39188272%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '835bdd0c21f12dca1bcd78e4dc49878adb4ba812' => 
    array (
      0 => '/home/koehlert/public_html/modules/shopcomments/views/templates/admin/list.tpl',
      1 => 1558370655,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9800508435d5d4634a2a634-39188272',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'comments_status_text' => 0,
    'reference_id' => 0,
    'reference_type' => 0,
    'comments' => 0,
    'comment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5d4634a62db0_43753731',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5d4634a62db0_43753731')) {function content_5d5d4634a62db0_43753731($_smarty_tpl) {?><table class="table table-condensed shop-comments-table comments-status-<?php echo $_smarty_tpl->tpl_vars['comments_status_text']->value;?>
" 
  data-reference_id="<?php echo $_smarty_tpl->tpl_vars['reference_id']->value;?>
" data-reference_type="<?php echo $_smarty_tpl->tpl_vars['reference_type']->value;?>
">
	<tr>
		<th><?php echo smartyTranslate(array('s'=>'Employee','mod'=>'shopcomments'),$_smarty_tpl);?>
</th>
		<th><?php echo smartyTranslate(array('s'=>'Date','mod'=>'shopcomments'),$_smarty_tpl);?>
</th>
		<th><?php echo smartyTranslate(array('s'=>'Comment','mod'=>'shopcomments'),$_smarty_tpl);?>
</th>
	</tr>
	<?php  $_smarty_tpl->tpl_vars['comment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['comment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['comment']->key => $_smarty_tpl->tpl_vars['comment']->value) {
$_smarty_tpl->tpl_vars['comment']->_loop = true;
?>
	<tr data-comment_id="<?php echo $_smarty_tpl->tpl_vars['comment']->value['id'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['comment']->value['status']==0) {?>warning status-archived<?php } else { ?>status-active<?php }?>">
		<td><?php echo $_smarty_tpl->tpl_vars['comment']->value['employee_name'];?>
</td>
		<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['comment']->value['date_created'],'full'=>true),$_smarty_tpl);?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['comment']->value['message'];?>
</td>
	</tr>
	<?php } ?>
</table><?php }} ?>
