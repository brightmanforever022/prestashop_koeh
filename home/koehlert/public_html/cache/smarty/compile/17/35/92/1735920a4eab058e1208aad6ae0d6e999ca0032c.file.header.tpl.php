<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:27:46
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/layout/default/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8792437825d59606225f5b6-53155538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1735920a4eab058e1208aad6ae0d6e999ca0032c' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/layout/default/header.tpl',
      1 => 1442250768,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8792437825d59606225f5b6-53155538',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'left_column_size' => 0,
    'HOOK_LEFT_COLUMN' => 0,
    'right_column_size' => 0,
    'cols' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59606227a9e4_33465558',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59606227a9e4_33465558')) {function content_5d59606227a9e4_33465558($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['left_column_size']->value)&&!empty($_smarty_tpl->tpl_vars['left_column_size']->value)) {?>
<!-- Left -->
	<section id="left_column" class="column sidebar col-md-<?php echo intval($_smarty_tpl->tpl_vars['left_column_size']->value);?>
" role="navigation">
		<?php echo $_smarty_tpl->tpl_vars['HOOK_LEFT_COLUMN']->value;?>

	</section>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['left_column_size']->value)&&isset($_smarty_tpl->tpl_vars['right_column_size']->value)) {?><?php if (isset($_smarty_tpl->tpl_vars['cols'])) {$_smarty_tpl->tpl_vars['cols'] = clone $_smarty_tpl->tpl_vars['cols'];
$_smarty_tpl->tpl_vars['cols']->value = (12-$_smarty_tpl->tpl_vars['left_column_size']->value-$_smarty_tpl->tpl_vars['right_column_size']->value); $_smarty_tpl->tpl_vars['cols']->nocache = null; $_smarty_tpl->tpl_vars['cols']->scope = 0;
} else $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable((12-$_smarty_tpl->tpl_vars['left_column_size']->value-$_smarty_tpl->tpl_vars['right_column_size']->value), null, 0);?><?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['cols'])) {$_smarty_tpl->tpl_vars['cols'] = clone $_smarty_tpl->tpl_vars['cols'];
$_smarty_tpl->tpl_vars['cols']->value = 12; $_smarty_tpl->tpl_vars['cols']->nocache = null; $_smarty_tpl->tpl_vars['cols']->scope = 0;
} else $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable(12, null, 0);?><?php }?>
<!-- Center -->
<section id="center_column" <?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['cols']->value);?>
<?php $_tmp8=ob_get_clean();?><?php if ($_tmp8!=12) {?>class="col-md-<?php echo intval($_smarty_tpl->tpl_vars['cols']->value);?>
"<?php }?>>
	

<?php }} ?>
