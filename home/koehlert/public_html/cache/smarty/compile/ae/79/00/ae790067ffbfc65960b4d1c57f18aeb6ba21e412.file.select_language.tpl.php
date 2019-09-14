<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 10:44:07
         compiled from "/home/koehlert/public_html/modules//ba_prestashop_invoice/views/templates/admin/select_language.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7542976585d5fa757a96a76-94259302%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae790067ffbfc65960b4d1c57f18aeb6ba21e412' => 
    array (
      0 => '/home/koehlert/public_html/modules//ba_prestashop_invoice/views/templates/admin/select_language.tpl',
      1 => 1481620488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7542976585d5fa757a96a76-94259302',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'languages_select' => 0,
    'language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5fa757a9f797_82376178',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5fa757a9f797_82376178')) {function content_5d5fa757a9f797_82376178($_smarty_tpl) {?>
<select name="sel_language">
	<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages_select']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
	<option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
	<?php } ?>
</select><?php }} ?>
