<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 08:27:47
         compiled from "/home/koehlert/public_html/modules/ba_prestashop_invoice/views/templates/admin/taskbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1744738495d5f8763c4d7a2-24273377%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a39ad8e73bebf9208dd03ddcf94682629e8f59af' => 
    array (
      0 => '/home/koehlert/public_html/modules/ba_prestashop_invoice/views/templates/admin/taskbar.tpl',
      1 => 1564484235,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1744738495d5f8763c4d7a2-24273377',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'demoMode' => 0,
    'taskbar' => 0,
    'bamodule' => 0,
    'token' => 0,
    'configure' => 0,
    'ba_lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5f8763c78d95_57919402',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5f8763c78d95_57919402')) {function content_5d5f8763c78d95_57919402($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['demoMode']->value=="1") {?>
<div class="bootstrap ba_error">
	<div class="module_error alert alert-danger">
		<?php echo smartyTranslate(array('s'=>'You are use ','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

		<strong><?php echo smartyTranslate(array('s'=>'Demo Mode ','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</strong>
		<?php echo smartyTranslate(array('s'=>', so some buttons, functions will be disabled because of security. ','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

		<?php echo smartyTranslate(array('s'=>'You can use them in Live mode after you puchase our module. ','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

		<?php echo smartyTranslate(array('s'=>'Thanks !','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>

	</div>
</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['taskbar']->value=="orderinvoice") {?>
<div class="alert alert-info">
    To edit invoice rules click Details on the template
</div>
<?php }?>

<ul class="nav nav-tabs">
    <li class="<?php if ($_smarty_tpl->tpl_vars['taskbar']->value=="orderinvoice") {?>active<?php }?>">
		<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['bamodule']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&token=<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&configure=<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['configure']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ba_lang=<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['ba_lang']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&task=orderinvoice"><?php echo smartyTranslate(array('s'=>'Invoice','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</a>
	</li>
    <li class="<?php if ($_smarty_tpl->tpl_vars['taskbar']->value=="deliveryslip") {?>active<?php }?>">
		<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['bamodule']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&token=<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&configure=<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['configure']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&ba_lang=<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['ba_lang']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&task=deliveryslip"><?php echo smartyTranslate(array('s'=>'Delivery Slips','mod'=>'ba_prestashop_invoice'),$_smarty_tpl);?>
</a>
	</li>
</ul><?php }} ?>
