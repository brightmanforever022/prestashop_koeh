<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 17:12:39
         compiled from "/home/koehlert/public_html/modules/khlexclcstm//views/templates/admin/customers_excluded_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:211099635d596ae71dcfe6-58708096%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'caac2fd4ddb3ff20b9650d19c646cfe344d897cd' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlexclcstm//views/templates/admin/customers_excluded_list.tpl',
      1 => 1560853443,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211099635d596ae71dcfe6-58708096',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'customers_excluded' => 0,
    'customer_excluded' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596ae71fd571_50996035',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596ae71fd571_50996035')) {function content_5d596ae71fd571_50996035($_smarty_tpl) {?><table class="table">
  <tr>
    <th><?php echo smartyTranslate(array('s'=>'ID','mod'=>'khlexclcstm'),$_smarty_tpl);?>
</th>
    <th><?php echo smartyTranslate(array('s'=>'Company','mod'=>'khlexclcstm'),$_smarty_tpl);?>
</th>
    <th><?php echo smartyTranslate(array('s'=>'Name','mod'=>'khlexclcstm'),$_smarty_tpl);?>
</th>
    <th><?php echo smartyTranslate(array('s'=>'Action','mod'=>'khlexclcstm'),$_smarty_tpl);?>
</th>
  </tr>
  <?php  $_smarty_tpl->tpl_vars['customer_excluded'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customer_excluded']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['customers_excluded']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['customer_excluded']->key => $_smarty_tpl->tpl_vars['customer_excluded']->value) {
$_smarty_tpl->tpl_vars['customer_excluded']->_loop = true;
?>
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['customer_excluded']->value['id_excluded'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['customer_excluded']->value['company'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['customer_excluded']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['customer_excluded']->value['lastname'];?>
</td>
    <td>
      <button class="btn btn-danger btn-xs excluded-customer-remove" data-id_main_to_excl="<?php echo $_smarty_tpl->tpl_vars['customer_excluded']->value['id_customer_main_to_excl'];?>
"><?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
</button>
    </td>
  </tr>
  <?php } ?>
</table>
<?php }} ?>
