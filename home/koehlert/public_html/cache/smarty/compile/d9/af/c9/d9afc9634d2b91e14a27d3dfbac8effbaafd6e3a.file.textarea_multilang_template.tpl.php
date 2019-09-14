<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/textarea_multilang_template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1578134485d5a47a8826e25-63363074%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd9afc9634d2b91e14a27d3dfbac8effbaafd6e3a' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/textarea_multilang_template.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1578134485d5a47a8826e25-63363074',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'input_value' => 0,
    'id_lang' => 0,
    'content_name' => 0,
    'input_name' => 0,
    'class_name' => 0,
    'content_lang' => 0,
    'max' => 0,
    'config' => 0,
    'content_css' => 0,
    'init_callback' => 0,
    'plugins' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8881b97_20512687',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8881b97_20512687')) {function content_5d5a47a8881b97_20512687($_smarty_tpl) {?>

<?php  $_smarty_tpl->tpl_vars['content_lang'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['content_lang']->_loop = false;
 $_smarty_tpl->tpl_vars['id_lang'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['input_value']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['content_lang']->key => $_smarty_tpl->tpl_vars['content_lang']->value) {
$_smarty_tpl->tpl_vars['content_lang']->_loop = true;
 $_smarty_tpl->tpl_vars['id_lang']->value = $_smarty_tpl->tpl_vars['content_lang']->key;
?>
<div data-lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id_lang']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if (isset($_smarty_tpl->tpl_vars['content_name']->value)) {?>id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['content_name']->value, ENT_QUOTES, 'UTF-8', true);?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id_lang']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> style="display:none;">
	<textarea cols="100" rows="10" type="text" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_name']->value, ENT_QUOTES, 'UTF-8', true);?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id_lang']->value, ENT_QUOTES, 'UTF-8', true);?>
" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_name']->value, ENT_QUOTES, 'UTF-8', true);?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id_lang']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="<?php if (isset($_smarty_tpl->tpl_vars['class_name']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['class_name']->value, ENT_QUOTES, 'UTF-8', true);?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id_lang']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>autoload_rte<?php }?>" style="width: 950px; height: 500px;"><?php echo smarty_modifier_htmlentitiesUTF8($_smarty_tpl->tpl_vars['content_lang']->value);?>
</textarea>
	<span class="counter" max="<?php if (isset($_smarty_tpl->tpl_vars['max']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['max']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>none<?php }?>"></span>
</div>

<script type="text/javascript">
	;(function(){

		var obj = {
			'content_name': '<?php if (isset($_smarty_tpl->tpl_vars['content_name']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['content_name']->value, ENT_QUOTES, 'UTF-8', true);?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id_lang']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>',
			'input_name': '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_name']->value, ENT_QUOTES, 'UTF-8', true);?>
_<?php echo intval($_smarty_tpl->tpl_vars['id_lang']->value);?>
',
			'class_name': '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['class_name']->value, ENT_QUOTES, 'UTF-8', true);?>
_<?php echo intval($_smarty_tpl->tpl_vars['id_lang']->value);?>
',
			'config': '<?php if (isset($_smarty_tpl->tpl_vars['config']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['config']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>default_config<?php }?>',
			'multilang': true,
			'content_css': <?php if (isset($_smarty_tpl->tpl_vars['content_css']->value)&&isset($_smarty_tpl->tpl_vars['content_css']->value[$_smarty_tpl->tpl_vars['id_lang']->value])&&is_array($_smarty_tpl->tpl_vars['content_css']->value[$_smarty_tpl->tpl_vars['id_lang']->value])) {?>$.parseJSON('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['json_encode'][0][0]->jsonEncode($_smarty_tpl->tpl_vars['content_css']->value[$_smarty_tpl->tpl_vars['id_lang']->value]);?>
')<?php } elseif (isset($_smarty_tpl->tpl_vars['content_css']->value)&&isset($_smarty_tpl->tpl_vars['content_css']->value[$_smarty_tpl->tpl_vars['id_lang']->value])&&!empty($_smarty_tpl->tpl_vars['content_css']->value[$_smarty_tpl->tpl_vars['id_lang']->value])) {?>'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['content_css']->value[$_smarty_tpl->tpl_vars['id_lang']->value]);?>
'<?php } else { ?>null<?php }?>,
			'id_lang': parseInt('<?php echo intval($_smarty_tpl->tpl_vars['id_lang']->value);?>
'),
			'init_callback': <?php if (isset($_smarty_tpl->tpl_vars['init_callback']->value)) {?>'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['init_callback']->value);?>
'<?php } else { ?>null<?php }?>,
			'plugins': <?php if (isset($_smarty_tpl->tpl_vars['plugins']->value)) {?>'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['plugins']->value);?>
'<?php } else { ?>null<?php }?>,
		};

		NewsletterPro.dataStorage.append('tiny_init', obj);
	}());
</script>
<?php } ?><?php }} ?>
