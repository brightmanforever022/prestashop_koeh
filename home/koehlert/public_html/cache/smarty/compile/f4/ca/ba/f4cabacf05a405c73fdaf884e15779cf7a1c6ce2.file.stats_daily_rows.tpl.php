<?php /* Smarty version Smarty-3.1.19, created on 2019-08-20 10:31:24
         compiled from "/home/koehlert/public_html/modules/khlbasic/views/templates/admin/salesstats/stats_daily_rows.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9561238765d5bafdc8233d5-86764159%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f4cabacf05a405c73fdaf884e15779cf7a1c6ce2' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlbasic/views/templates/admin/salesstats/stats_daily_rows.tpl',
      1 => 1545819385,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9561238765d5bafdc8233d5-86764159',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'stats_daily' => 0,
    'stats_item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5bafdc835739_80090988',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5bafdc835739_80090988')) {function content_5d5bafdc835739_80090988($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['stats_daily']->value)) {?>
	<?php  $_smarty_tpl->tpl_vars['stats_item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['stats_item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['stats_daily']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['stats_item']->key => $_smarty_tpl->tpl_vars['stats_item']->value) {
$_smarty_tpl->tpl_vars['stats_item']->_loop = true;
?>
		<tr>
		<?php if (isset($_smarty_tpl->tpl_vars['stats_item']->value['period_name'])) {?>
			<td colspan="10"> <strong><?php echo $_smarty_tpl->tpl_vars['stats_item']->value['period_name'];?>
</strong> </td>
		<?php } elseif (isset($_smarty_tpl->tpl_vars['stats_item']->value['no_records'])) {?>
			<td colspan="10"><?php echo smartyTranslate(array('s'=>'No records found'),$_smarty_tpl);?>
</td>
		<?php } else { ?>
			<td><?php echo $_smarty_tpl->tpl_vars['stats_item']->value['report_date_formatted'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['stats_item']->value['sold_quantity'];?>
</td>
			<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['stats_item']->value['sale_revenue']),$_smarty_tpl);?>
</td>
		
		<?php }?>
		</tr>
	<?php } ?>
<?php }?><?php }} ?>
