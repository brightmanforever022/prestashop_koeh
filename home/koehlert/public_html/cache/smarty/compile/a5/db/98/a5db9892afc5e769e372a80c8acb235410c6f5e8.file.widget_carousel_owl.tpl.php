<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:29:36
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/modules/leomanagewidgets/views/widgets/widget_carousel_owl.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9505565785d5960d073fc28-32960561%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5db9892afc5e769e372a80c8acb235410c6f5e8' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/modules/leomanagewidgets/views/widgets/widget_carousel_owl.tpl',
      1 => 1442250768,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9505565785d5960d073fc28-32960561',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tab' => 0,
    'widget_heading' => 0,
    'products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5960d0768cc0_87799809',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5960d0768cc0_87799809')) {function content_5d5960d0768cc0_87799809($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['tabname'])) {$_smarty_tpl->tpl_vars['tabname'] = clone $_smarty_tpl->tpl_vars['tabname'];
$_smarty_tpl->tpl_vars['tabname']->value = ((string)$_smarty_tpl->tpl_vars['tab']->value); $_smarty_tpl->tpl_vars['tabname']->nocache = null; $_smarty_tpl->tpl_vars['tabname']->scope = 0;
} else $_smarty_tpl->tpl_vars['tabname'] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['tab']->value), null, 0);?>
<div class="block products_block exclusive leomanagerwidgets">
	<?php if (isset($_smarty_tpl->tpl_vars['widget_heading']->value)&&!empty($_smarty_tpl->tpl_vars['widget_heading']->value)) {?>
    <h4 class="page-subheading">
		<?php echo $_smarty_tpl->tpl_vars['widget_heading']->value;?>

	</h4>
	<?php }?>
	<div class="block_content">	
		<?php if (!empty($_smarty_tpl->tpl_vars['products']->value)) {?>
			<div class="row">
        	    <div id="<?php echo $_smarty_tpl->tpl_vars['tab']->value;?>
" class="owl-carousel owl-theme">
					<?php echo $_smarty_tpl->getSubTemplate ('./products_owl.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            	</div>
        	</div>
		<?php } else { ?>
   			<p class="alert alert-info"><?php echo smartyTranslate(array('s'=>'No products at this time.','mod'=>'leomanagewidgets'),$_smarty_tpl);?>
</p>	
		<?php }?>
	</div>
</div>

<?php if (isset($_smarty_tpl->tpl_vars["call_owl_carousel"])) {$_smarty_tpl->tpl_vars["call_owl_carousel"] = clone $_smarty_tpl->tpl_vars["call_owl_carousel"];
$_smarty_tpl->tpl_vars["call_owl_carousel"]->value = "#".((string)$_smarty_tpl->tpl_vars['tab']->value); $_smarty_tpl->tpl_vars["call_owl_carousel"]->nocache = null; $_smarty_tpl->tpl_vars["call_owl_carousel"]->scope = 0;
} else $_smarty_tpl->tpl_vars["call_owl_carousel"] = new Smarty_variable("#".((string)$_smarty_tpl->tpl_vars['tab']->value), null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate ('./owl_carousel_config.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
