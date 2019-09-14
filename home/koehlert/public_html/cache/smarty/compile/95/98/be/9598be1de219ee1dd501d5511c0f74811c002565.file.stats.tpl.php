<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 10:36:20
         compiled from "/home/koehlert/public_html/modules/agentsales/views/templates/admin/stats.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14401383565d5a5f84eae023-00122979%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9598be1de219ee1dd501d5511c0f74811c002565' => 
    array (
      0 => '/home/koehlert/public_html/modules/agentsales/views/templates/admin/stats.tpl',
      1 => 1555664230,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14401383565d5a5f84eae023-00122979',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'agents_stats' => 0,
    'pending_commissions_list' => 0,
    'pending_commission_data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a5f84ecafe8_44531274',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a5f84ecafe8_44531274')) {function content_5d5a5f84ecafe8_44531274($_smarty_tpl) {?><div class="panel">
	<div class="panel-heading">
		<?php echo smartyTranslate(array('s'=>'Totals','mod'=>'agentcomm'),$_smarty_tpl);?>

	</div>
	<div class="panel-content">
	<?php if (isset($_smarty_tpl->tpl_vars['agents_stats']->value)) {?>
		<h4><?php echo smartyTranslate(array('s'=>'Invoices total'),$_smarty_tpl);?>
: <?php echo $_smarty_tpl->tpl_vars['agents_stats']->value['total'];?>
</h4>
		<h4><?php echo smartyTranslate(array('s'=>'Commissions for paid invoices'),$_smarty_tpl);?>
: <?php echo $_smarty_tpl->tpl_vars['agents_stats']->value['commision_invoice_paid'];?>
</h4>
        <h4><?php echo smartyTranslate(array('s'=>'Commissions for unpaid invoices'),$_smarty_tpl);?>
: <?php echo $_smarty_tpl->tpl_vars['agents_stats']->value['commision_invoice_unpaid'];?>
</h4>
		<h4><?php echo smartyTranslate(array('s'=>'Commissions for orders where are no invoices created yet'),$_smarty_tpl);?>
: <?php echo $_smarty_tpl->tpl_vars['agents_stats']->value['pending_commissions'];?>
 <a role="button" data-toggle="collapse" href="#pendingCommissionsList">Show</a></h4>
		
		<div class="collapse" id="pendingCommissionsList">
			<table class="table table-bordered">
				<tr>
					<th>Order</th>
					<th>Base</th>
					<th>Comm.</th>
					<th>Agent</th>
				</tr>
			<?php  $_smarty_tpl->tpl_vars['pending_commission_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pending_commission_data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pending_commissions_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pending_commission_data']->key => $_smarty_tpl->tpl_vars['pending_commission_data']->value) {
$_smarty_tpl->tpl_vars['pending_commission_data']->_loop = true;
?>
				<tr>
					<td><?php echo $_smarty_tpl->tpl_vars['pending_commission_data']->value['id_order'];?>
</td>
					<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['pending_commission_data']->value['commission_base']),$_smarty_tpl);?>
</td>
					<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['pending_commission_data']->value['commission_value']),$_smarty_tpl);?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['pending_commission_data']->value['agent_name'];?>
</td>
				</tr>
			<?php } ?>
			</table>
		</div>
	<?php }?>
	</div>
</div>
<?php }} ?>
