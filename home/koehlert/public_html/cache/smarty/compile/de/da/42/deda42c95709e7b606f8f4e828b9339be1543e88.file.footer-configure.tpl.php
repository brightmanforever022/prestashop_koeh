<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 18:38:05
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/footer-configure.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11635632435d60166d32ba79-23984770%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'deda42c95709e7b606f8f4e828b9339be1543e88' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/footer-configure.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11635632435d60166d32ba79-23984770',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tab_configure' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d60166d32fc37_66201003',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d60166d32fc37_66201003')) {function content_5d60166d32fc37_66201003($_smarty_tpl) {?>

</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
	var tab_configure = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_configure']->value, ENT_QUOTES, 'UTF-8', true);?>
';
	if(tab_configure=='mail')
		$('#ta_cartreminder_mail_template').show();
	if(tab_configure=='rule')
		$('#ta_cartreminder_rule').show();
	if(tab_configure=='configuration')
		$('#tacartreminder_form').show();
});
</script><?php }} ?>
