<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/textarea.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7320736575d5a47a8769cf4-29301106%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9d91021848c06eb1f935fcadcca4fd0887cd6859' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/textarea.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7320736575d5a47a8769cf4-29301106',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_name' => 0,
    'input_name' => 0,
    'class_name' => 0,
    'input_value' => 0,
    'max' => 0,
    'config' => 0,
    'content_css' => 0,
    'init_callback' => 0,
    'plugins' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a87a4958_16611490',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a87a4958_16611490')) {function content_5d5a47a87a4958_16611490($_smarty_tpl) {?>

<div <?php if (isset($_smarty_tpl->tpl_vars['content_name']->value)) {?>id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['content_name']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> style="display:none;">
	<textarea cols="100" rows="10" type="text" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="<?php if (isset($_smarty_tpl->tpl_vars['class_name']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['class_name']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>autoload_rte<?php }?>" style="width: 950px; height: 500px;"><?php echo smarty_modifier_htmlentitiesUTF8($_smarty_tpl->tpl_vars['input_value']->value);?>
</textarea>
	<span class="counter" max="<?php if (isset($_smarty_tpl->tpl_vars['max']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['max']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>none<?php }?>"></span>
</div>

<script type="text/javascript">
	NewsletterPro.dataStorage.append('tiny_init', {
		'content_name': '<?php if (isset($_smarty_tpl->tpl_vars['content_name']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['content_name']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>',
		'input_name': '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_name']->value, ENT_QUOTES, 'UTF-8', true);?>
',
		'class_name': '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['class_name']->value, ENT_QUOTES, 'UTF-8', true);?>
',
		'config': '<?php if (isset($_smarty_tpl->tpl_vars['config']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['config']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>default_config<?php }?>',
		'content_css': <?php if (isset($_smarty_tpl->tpl_vars['content_css']->value)&&is_array($_smarty_tpl->tpl_vars['content_css']->value)) {?>$.parseJSON('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['json_encode'][0][0]->jsonEncode($_smarty_tpl->tpl_vars['content_css']->value);?>
')<?php } elseif (!empty($_smarty_tpl->tpl_vars['content_css']->value)) {?>'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['content_css']->value);?>
'<?php } else { ?>null<?php }?>,
		'multilang': false,
		'id_lang': 0,
		'init_callback': <?php if (isset($_smarty_tpl->tpl_vars['init_callback']->value)) {?>'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['init_callback']->value);?>
'<?php } else { ?>null<?php }?>,
		'plugins': <?php if (isset($_smarty_tpl->tpl_vars['plugins']->value)) {?>'<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['plugins']->value);?>
'<?php } else { ?>null<?php }?>,
	});
</script><?php }} ?>
