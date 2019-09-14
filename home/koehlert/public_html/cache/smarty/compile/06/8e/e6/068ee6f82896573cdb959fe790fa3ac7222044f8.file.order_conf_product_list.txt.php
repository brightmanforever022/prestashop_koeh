<?php /* Smarty version Smarty-3.1.19, created on 2019-08-28 13:16:27
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/mails/fr/order_conf_product_list.txt" */ ?>
<?php /*%%SmartyHeaderCode:20460554265d66628bc82548-73153361%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '068ee6f82896573cdb959fe790fa3ac7222044f8' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/mails/fr/order_conf_product_list.txt',
      1 => 1563879817,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20460554265d66628bc82548-73153361',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'product' => 0,
    'customization' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d66628bcb7893_06219415',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d66628bcb7893_06219415')) {function content_5d66628bcb7893_06219415($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
						<?php echo $_smarty_tpl->tpl_vars['product']->value['reference'];?>


						<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>


						<?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>


						<?php echo $_smarty_tpl->tpl_vars['product']->value['quantity'];?>


						<?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>


	<?php  $_smarty_tpl->tpl_vars['customization'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customization']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product']->value['customization']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['customization']->key => $_smarty_tpl->tpl_vars['customization']->value) {
$_smarty_tpl->tpl_vars['customization']->_loop = true;
?>
							<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
 <?php echo $_smarty_tpl->tpl_vars['customization']->value['customization_text'];?>


							<?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>


							<?php echo $_smarty_tpl->tpl_vars['product']->value['customization_quantity'];?>


							<?php echo $_smarty_tpl->tpl_vars['product']->value['quantity'];?>

	<?php } ?>
<?php } ?><?php }} ?>
