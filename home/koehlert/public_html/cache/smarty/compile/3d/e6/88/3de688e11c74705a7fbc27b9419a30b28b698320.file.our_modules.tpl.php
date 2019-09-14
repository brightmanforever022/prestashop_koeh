<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/our_modules.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21335749915d5a47a8c7bba3-96311194%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3de688e11c74705a7fbc27b9419a30b28b698320' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/our_modules.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21335749915d5a47a8c7bba3-96311194',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'lang_iso_code' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8c90b73_72708585',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8c90b73_72708585')) {function content_5d5a47a8c90b73_72708585($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#ourModules') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">');
	} 
</script>
<?php }?>
	<h4><?php echo smartyTranslate(array('s'=>'Modules developed by us','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>

	<p><?php echo smartyTranslate(array('s'=>'The modules are available on the prestashop official website.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
	<a href="http://addons.prestashop.com/<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['lang_iso_code']->value);?>
/93_proquality" target="_blank" class="btn btn-success">
		<i class="icon icon-puzzle-piece"></i>
		<?php echo smartyTranslate(array('s'=>'View Catalog','mod'=>'newsletterpro'),$_smarty_tpl);?>

	</a>
</div><?php }} ?>
