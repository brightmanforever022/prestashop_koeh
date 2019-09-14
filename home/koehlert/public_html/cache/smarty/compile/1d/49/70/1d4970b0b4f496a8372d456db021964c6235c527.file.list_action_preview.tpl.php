<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 12:50:14
         compiled from "/home/koehlert/public_html/admin971jqkmvw/themes/default/template/helpers/list/list_action_preview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5378283925d5a7ee699fa25-08139849%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d4970b0b4f496a8372d456db021964c6235c527' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/helpers/list/list_action_preview.tpl',
      1 => 1440056612,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5378283925d5a7ee699fa25-08139849',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a7ee69a5b75_77527452',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a7ee69a5b75_77527452')) {function content_5d5a7ee69a5b75_77527452($_smarty_tpl) {?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" target="_blank">
	<i class="icon-eye"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a>
<?php }} ?>
