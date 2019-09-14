<?php /* Smarty version Smarty-3.1.19, created on 2019-08-20 10:46:04
         compiled from "/home/koehlert/public_html/modules/khlbasic/views/templates/admin/salesstats/stats_monthly_rows.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17599907085d5bb34c095007-51797327%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd64fcb3992f93a9bafdf25f63b2f5880b2638573' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlbasic/views/templates/admin/salesstats/stats_monthly_rows.tpl',
      1 => 1545825775,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17599907085d5bb34c095007-51797327',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'stats_monthly' => 0,
    'stats_item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5bb34c0b7fe8_53026965',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5bb34c0b7fe8_53026965')) {function content_5d5bb34c0b7fe8_53026965($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['stats_monthly']->value)) {?>
	<?php  $_smarty_tpl->tpl_vars['stats_item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['stats_item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['stats_monthly']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['stats_item']->key => $_smarty_tpl->tpl_vars['stats_item']->value) {
$_smarty_tpl->tpl_vars['stats_item']->_loop = true;
?>
		<tr>
		<?php if (isset($_smarty_tpl->tpl_vars['stats_item']->value['period_name'])) {?>
			<td> <strong><?php echo $_smarty_tpl->tpl_vars['stats_item']->value['period_name'];?>
</strong> </td>
			<td> <strong><?php echo $_smarty_tpl->tpl_vars['stats_item']->value['sold_quantity_total'];?>
</strong> </td>
			<td> <strong><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['stats_item']->value['sale_revenue_total']),$_smarty_tpl);?>
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
