<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 12:54:25
         compiled from "/home/koehlert/public_html/modules/storecommander/views/templates/admin/store_commander/helpers/view/view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5062967095d5a7fe1ab4709-97120230%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '882692f4e5f435781cff242e77703daeb83468b7' => 
    array (
      0 => '/home/koehlert/public_html/modules/storecommander/views/templates/admin/store_commander/helpers/view/view.tpl',
      1 => 1468066777,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5062967095d5a7fe1ab4709-97120230',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'html' => 0,
    'sc_url' => 0,
    'sc_title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a7fe1ac2310_52398033',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a7fe1ac2310_52398033')) {function content_5d5a7fe1ac2310_52398033($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/home/koehlert/public_html/tools/smarty/plugins/modifier.escape.php';
?><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['html']->value, 'UTF-8');?>

<?php if (!empty($_smarty_tpl->tpl_vars['sc_url']->value)) {?>
<fieldset><legend>Store Commander</legend>
    <label><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sc_title']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</label>
    <div class="margin-form">
        <script>
            document.location="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['sc_url']->value, 'UTF-8');?>
";
        </script>
    </div>
</fieldset>
<?php }?><?php }} ?>
