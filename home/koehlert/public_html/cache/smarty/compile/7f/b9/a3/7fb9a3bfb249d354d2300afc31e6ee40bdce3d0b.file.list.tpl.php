<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 18:38:05
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/helpers/list/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13624528395d60166d31d6c1-60068079%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7fb9a3bfb249d354d2300afc31e6ee40bdce3d0b' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/helpers/list/list.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13624528395d60166d31d6c1-60068079',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ps_version' => 0,
    'ta_table_list' => 0,
    'header' => 0,
    'content' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d60166d329de8_36298150',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d60166d329de8_36298150')) {function content_5d60166d329de8_36298150($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['ps_version']->value<="1.6") {?>
<div class="panel" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ta_table_list']->value, ENT_QUOTES, 'UTF-8', true);?>
">
<?php }?>
<?php echo $_smarty_tpl->tpl_vars['header']->value;?>

<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php if ($_smarty_tpl->tpl_vars['ps_version']->value<="1.6") {?>
</div>
<?php }?><?php }} ?>
