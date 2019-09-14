<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 12:42:10
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/task/unsubscribed_detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2008925055d5a7d02bba0f5-32384137%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c0542220838af1bd978cf0152b5ab28439f75f2' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/task/unsubscribed_detail.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2008925055d5a7d02bba0f5-32384137',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'result' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a7d02bd1959_62292315',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a7d02bd1959_62292315')) {function content_5d5a7d02bd1959_62292315($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['result']->value) {?>
<div class="thd-step">
	<div style="width: 100%; float: left;">
		<table class="table table-unsubscribed" style="width: 100%;">
			<thead>
				<tr>
					<th class="x-icon">&nbsp;</th>
					<th class="email"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="last-item"><?php echo smartyTranslate(array('s'=>'Unsubscribed Date','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
			<tbody>
			<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['result']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
				<tr>
					<td class="x-icon">
						<span class="status"> 
							<span class="list-action-enable action-disabled"><i class="icon icon-remove"></i></span>
						</span>
					</td>
					<td>
						<span class="email_text"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['email'], ENT_QUOTES, 'UTF-8', true);?>
</span>
					</td>
					<td class="last-item">
						<span> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['date_add'], ENT_QUOTES, 'UTF-8', true);?>
 </span>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="clear">&nbsp;</div>
</div>
<?php }?><?php }} ?>
