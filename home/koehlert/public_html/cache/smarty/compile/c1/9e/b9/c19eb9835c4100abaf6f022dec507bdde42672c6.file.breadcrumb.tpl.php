<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:27:49
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/breadcrumb.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5150611735d596065796974-45159094%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c19eb9835c4100abaf6f022dec507bdde42672c6' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/breadcrumb.tpl',
      1 => 1481185475,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5150611735d596065796974-45159094',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'force_ssl' => 0,
    'base_dir_ssl' => 0,
    'base_dir' => 0,
    'path' => 0,
    'category' => 0,
    'navigationPipe' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5960657c1037_69841495',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5960657c1037_69841495')) {function content_5d5960657c1037_69841495($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/koehlert/public_html/tools/smarty/plugins/modifier.replace.php';
?>

<!-- Breadcrumb -->
<?php if (isset(Smarty::$_smarty_vars['capture']['path'])) {?><?php if (isset($_smarty_tpl->tpl_vars['path'])) {$_smarty_tpl->tpl_vars['path'] = clone $_smarty_tpl->tpl_vars['path'];
$_smarty_tpl->tpl_vars['path']->value = Smarty::$_smarty_vars['capture']['path']; $_smarty_tpl->tpl_vars['path']->nocache = null; $_smarty_tpl->tpl_vars['path']->scope = 0;
} else $_smarty_tpl->tpl_vars['path'] = new Smarty_variable(Smarty::$_smarty_vars['capture']['path'], null, 0);?><?php }?>
<div class="breadcrumb clearfix">
	<a class="home" href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>" title="<?php echo smartyTranslate(array('s'=>'Return to Home'),$_smarty_tpl);?>
"><i class="fa fa-home"></i></a>
	<?php if (isset($_smarty_tpl->tpl_vars['path']->value)&&$_smarty_tpl->tpl_vars['path']->value) {?>
		<span class="navigation-pipe"<?php if (isset($_smarty_tpl->tpl_vars['category']->value)&&isset($_smarty_tpl->tpl_vars['category']->value->id_category)&&$_smarty_tpl->tpl_vars['category']->value->id_category==(int)Configuration::get('PS_ROOT_CATEGORY')) {?> style="display:none;"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['navigationPipe']->value, ENT_QUOTES, 'UTF-8', true);?>
</span>
		<?php if (strpos($_smarty_tpl->tpl_vars['path']->value,'span')!==false) {?>
			<span class="navigation_page"><?php echo smarty_modifier_replace(smarty_modifier_replace(smarty_modifier_replace($_smarty_tpl->tpl_vars['path']->value,'<a ','<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" '),'data-gg="">','><span itemprop="title">'),'</a>','</span></a></span>');?>
</span>
		<?php } else { ?>
			<?php echo $_smarty_tpl->tpl_vars['path']->value;?>

		<?php }?>
	<?php }?>
</div>

<!-- /Breadcrumb -->
<?php }} ?>
