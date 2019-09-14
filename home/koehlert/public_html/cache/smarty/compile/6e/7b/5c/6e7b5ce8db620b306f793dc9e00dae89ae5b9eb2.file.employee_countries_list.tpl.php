<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 17:03:17
         compiled from "/home/koehlert/public_html/override/controllers/admin/templates/employees/employee_countries_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12661297115d5968b5b32f85-34349760%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6e7b5ce8db620b306f793dc9e00dae89ae5b9eb2' => 
    array (
      0 => '/home/koehlert/public_html/override/controllers/admin/templates/employees/employee_countries_list.tpl',
      1 => 1561467264,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12661297115d5968b5b32f85-34349760',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'employee_countries_list' => 0,
    'employee_country' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5968b5b61468_13125254',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5968b5b61468_13125254')) {function content_5d5968b5b61468_13125254($_smarty_tpl) {?><table class="table">
  <tr>
    <th><?php echo smartyTranslate(array('s'=>'ID'),$_smarty_tpl);?>
</th>
    <th><?php echo smartyTranslate(array('s'=>'Country'),$_smarty_tpl);?>
</th>
    <th><?php echo smartyTranslate(array('s'=>'Postcodes'),$_smarty_tpl);?>
</th>
    <th><?php echo smartyTranslate(array('s'=>'Action'),$_smarty_tpl);?>
</th>
  </tr>
  <?php  $_smarty_tpl->tpl_vars['employee_country'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['employee_country']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['employee_countries_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['employee_country']->key => $_smarty_tpl->tpl_vars['employee_country']->value) {
$_smarty_tpl->tpl_vars['employee_country']->_loop = true;
?>
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['employee_country']->value['id_employee_country'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['employee_country']->value['country_name'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['employee_country']->value['postcodes'];?>
</td>
    <td>
      <button class="btn btn-warning btn-xs employee-country-edit" data-id="<?php echo $_smarty_tpl->tpl_vars['employee_country']->value['id_employee_country'];?>
"><?php echo smartyTranslate(array('s'=>'Edit'),$_smarty_tpl);?>
</button>
      <button class="btn btn-danger btn-xs employee-country-remove" data-id="<?php echo $_smarty_tpl->tpl_vars['employee_country']->value['id_employee_country'];?>
"><?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
</button>
    </td>
  </tr>
  <?php } ?>
</table>
<?php }} ?>
