<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 09:01:02
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/task/task_history_detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5825252215d5a492ea6d090-43888373%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '34f9424ae9c4881799c9251d816a1ee00b0f90e4' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/task/task_history_detail.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5825252215d5a492ea6d090-43888373',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'step' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a492eaaf3b3_67703126',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a492eaaf3b3_67703126')) {function content_5d5a492eaaf3b3_67703126($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['step']->value) {?>
<div class="thd-step">
	<div style="width: 50%; float: left;">
		<h4 style="margin-bottom: 5px; margin-left: 8px;"><?php echo smartyTranslate(array('s'=>'Remaining email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
		<div class="clear">&nbsp;</div>
		<ul class="first_item">
		<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['step']->value['emails_to_send']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
			<li> <span class="email_text"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value['email'], ENT_QUOTES, 'UTF-8', true);?>
</span> </li>
		<?php } ?>
		</ul>
	</div>
	<div style="width: 50%; float: left;">
		<h4 style="margin-bottom: 5px; margin-left: 8px;"><?php echo smartyTranslate(array('s'=>'Sent emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
		<div class="clear">&nbsp;</div>
		<ul class="last_item">
		<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['step']->value['emails_sent']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
			<?php if (isset($_smarty_tpl->tpl_vars['value']->value['status'])&&isset($_smarty_tpl->tpl_vars['value']->value['email'])) {?>

				<?php if ($_smarty_tpl->tpl_vars['value']->value['status']==true) {?>
					<li>
						<span class="email_text" style="margin-top: 3px; display: inline-block;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value['email'], ENT_QUOTES, 'UTF-8', true);?>
</span>
						<span class="status pull-left">
							<span class="list-action-enable action-enabled"><i class="icon icon-check"></i></span>
						</span>
					</li>
				<?php } else { ?>
					<li>
						<span class="email_text" style="margin-top: 3px; display: inline-block;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value['email'], ENT_QUOTES, 'UTF-8', true);?>
</span>
						<span class="status pull-left">
							<span class="list-action-enable action-disabled"><i class="icon icon-remove"></i></span>
						</span>
					</li>
				<?php }?>
				
			<?php }?>
		<?php } ?>
		</ul>
	</div>
	<div class="clear">&nbsp;</div>
</div>
<?php }?><?php }} ?>
