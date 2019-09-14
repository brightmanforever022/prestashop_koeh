<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 18:37:50
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/live_cart_reminder/journal-message-summary.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20282578515d60165e4f97d6-67236627%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0980da2711a95691b3db84c7bad11f15fb54386b' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/live_cart_reminder/journal-message-summary.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20282578515d60165e4f97d6-67236627',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id_journal' => 0,
    'nb_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d60165e507441_32464213',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d60165e507441_32464213')) {function content_5d60165e507441_32464213($_smarty_tpl) {?>
<div class="ta-icon-summary">
<a href="javascript:;" class="messages-summary" data-id-journal="<?php echo intval($_smarty_tpl->tpl_vars['id_journal']->value);?>
">
	<i class="flaticon-comment3"></i>
	<span class="ta-badge nb_messages"><?php echo intval($_smarty_tpl->tpl_vars['nb_message']->value);?>
</span>
</a>
</div><?php }} ?>
