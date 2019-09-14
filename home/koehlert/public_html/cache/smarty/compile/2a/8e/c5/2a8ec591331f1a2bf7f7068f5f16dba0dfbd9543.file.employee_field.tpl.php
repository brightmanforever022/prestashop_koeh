<?php /* Smarty version Smarty-3.1.19, created on 2019-08-22 11:00:21
         compiled from "/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/logs/employee_field.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16649294955d5e59a572d309-51438695%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a8ec591331f1a2bf7f7068f5f16dba0dfbd9543' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/logs/employee_field.tpl',
      1 => 1440056612,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16649294955d5e59a572d309-51438695',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'employee_image' => 0,
    'employee_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5e59a5734f65_10319398',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5e59a5734f65_10319398')) {function content_5d5e59a5734f65_10319398($_smarty_tpl) {?>
<span class="employee_avatar_small">
	<img class="imgm img-thumbnail" alt="" src="<?php echo $_smarty_tpl->tpl_vars['employee_image']->value;?>
" width="32" height="32" />
</span>
<?php echo $_smarty_tpl->tpl_vars['employee_name']->value;?>
<?php }} ?>
