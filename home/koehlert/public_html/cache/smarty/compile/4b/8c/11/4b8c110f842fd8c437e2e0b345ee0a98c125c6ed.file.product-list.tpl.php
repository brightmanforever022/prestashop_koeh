<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:40:35
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/product-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10229759665d5963634e6897-10868756%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4b8c110f842fd8c437e2e0b345ee0a98c125c6ed' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/product-list.tpl',
      1 => 1554976010,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10229759665d5963634e6897-10868756',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'class' => 0,
    'LISTING_PRODUCT_COLUMN_MODULE' => 0,
    'LISTING_PRODUCT_MOBILE' => 0,
    'LISTING_PRODUCT_TABLET' => 0,
    'LISTING_PRODUCT_COLUMN' => 0,
    'nbLi' => 0,
    'nbItemsPerLine' => 0,
    'nbItemsPerLineTablet' => 0,
    'id' => 0,
    'LISTING_GRIG_MODE' => 0,
    'nbItemsPerLineMobile' => 0,
    'totModulo' => 0,
    'totModuloTablet' => 0,
    'totModuloMobile' => 0,
    'colValue' => 0,
    'comparator_max_item' => 0,
    'compared_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59636356b884_51069198',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59636356b884_51069198')) {function content_5d59636356b884_51069198($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/home/koehlert/public_html/tools/smarty/plugins/function.math.php';
?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./layout/setting.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if (isset($_smarty_tpl->tpl_vars['products']->value)&&$_smarty_tpl->tpl_vars['products']->value) {?>
	
        <?php if (isset($_smarty_tpl->tpl_vars['class']->value)) {?>
            
            <?php if (isset($_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"])) {$_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"] = clone $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"];
$_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"]->value = "grid"; $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"]->nocache = null; $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"]->scope = 3;
} else $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"] = new Smarty_variable("grid", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["LISTING_GRIG_MODE"] = clone $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["LISTING_GRIG_MODE"] = clone $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"];?>
            <?php if (isset($_smarty_tpl->tpl_vars['nbItemsPerLine'])) {$_smarty_tpl->tpl_vars['nbItemsPerLine'] = clone $_smarty_tpl->tpl_vars['nbItemsPerLine'];
$_smarty_tpl->tpl_vars['nbItemsPerLine']->value = $_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN_MODULE']->value; $_smarty_tpl->tpl_vars['nbItemsPerLine']->nocache = null; $_smarty_tpl->tpl_vars['nbItemsPerLine']->scope = 0;
} else $_smarty_tpl->tpl_vars['nbItemsPerLine'] = new Smarty_variable($_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN_MODULE']->value, null, 0);?>
            <?php if ($_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN_MODULE']->value=="5") {?>
                <?php if (isset($_smarty_tpl->tpl_vars["colValue"])) {$_smarty_tpl->tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"];
$_smarty_tpl->tpl_vars["colValue"]->value = "col-xs-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value))." col-sm-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value))." col-md-2-4 col-sp-12"; $_smarty_tpl->tpl_vars["colValue"]->nocache = null; $_smarty_tpl->tpl_vars["colValue"]->scope = 3;
} else $_smarty_tpl->tpl_vars["colValue"] = new Smarty_variable("col-xs-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value))." col-sm-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value))." col-md-2-4 col-sp-12", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"];?>
            <?php } else { ?>
                <?php if (isset($_smarty_tpl->tpl_vars["colValue"])) {$_smarty_tpl->tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"];
$_smarty_tpl->tpl_vars["colValue"]->value = "col-sp-12 col-xs-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value))." col-sm-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value))." col-md-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN_MODULE']->value)); $_smarty_tpl->tpl_vars["colValue"]->nocache = null; $_smarty_tpl->tpl_vars["colValue"]->scope = 3;
} else $_smarty_tpl->tpl_vars["colValue"] = new Smarty_variable("col-sp-12 col-xs-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value))." col-sm-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value))." col-md-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN_MODULE']->value)), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"];?>
            <?php }?>
        <?php } else { ?>
            <?php if (isset($_smarty_tpl->tpl_vars['nbItemsPerLine'])) {$_smarty_tpl->tpl_vars['nbItemsPerLine'] = clone $_smarty_tpl->tpl_vars['nbItemsPerLine'];
$_smarty_tpl->tpl_vars['nbItemsPerLine']->value = $_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN']->value; $_smarty_tpl->tpl_vars['nbItemsPerLine']->nocache = null; $_smarty_tpl->tpl_vars['nbItemsPerLine']->scope = 0;
} else $_smarty_tpl->tpl_vars['nbItemsPerLine'] = new Smarty_variable($_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN']->value, null, 0);?>
	<?php }?>
        <?php if (isset($_smarty_tpl->tpl_vars['nbItemsPerLineTablet'])) {$_smarty_tpl->tpl_vars['nbItemsPerLineTablet'] = clone $_smarty_tpl->tpl_vars['nbItemsPerLineTablet'];
$_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value = $_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value; $_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->nocache = null; $_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->scope = 0;
} else $_smarty_tpl->tpl_vars['nbItemsPerLineTablet'] = new Smarty_variable($_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value, null, 0);?>
        <?php if (isset($_smarty_tpl->tpl_vars['nbItemsPerLineMobile'])) {$_smarty_tpl->tpl_vars['nbItemsPerLineMobile'] = clone $_smarty_tpl->tpl_vars['nbItemsPerLineMobile'];
$_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->value = $_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value; $_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->nocache = null; $_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->scope = 0;
} else $_smarty_tpl->tpl_vars['nbItemsPerLineMobile'] = new Smarty_variable($_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value, null, 0);?>
	
	<?php if (isset($_smarty_tpl->tpl_vars['nbLi'])) {$_smarty_tpl->tpl_vars['nbLi'] = clone $_smarty_tpl->tpl_vars['nbLi'];
$_smarty_tpl->tpl_vars['nbLi']->value = count($_smarty_tpl->tpl_vars['products']->value); $_smarty_tpl->tpl_vars['nbLi']->nocache = null; $_smarty_tpl->tpl_vars['nbLi']->scope = 0;
} else $_smarty_tpl->tpl_vars['nbLi'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['products']->value), null, 0);?>
	<?php echo smarty_function_math(array('equation'=>"nbLi/nbItemsPerLine",'nbLi'=>$_smarty_tpl->tpl_vars['nbLi']->value,'nbItemsPerLine'=>$_smarty_tpl->tpl_vars['nbItemsPerLine']->value,'assign'=>'nbLines'),$_smarty_tpl);?>

	<?php echo smarty_function_math(array('equation'=>"nbLi/nbItemsPerLineTablet",'nbLi'=>$_smarty_tpl->tpl_vars['nbLi']->value,'nbItemsPerLineTablet'=>$_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value,'assign'=>'nbLinesTablet'),$_smarty_tpl);?>

	<!-- Products list -->
	<div <?php if (isset($_smarty_tpl->tpl_vars['id']->value)&&$_smarty_tpl->tpl_vars['id']->value) {?> id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"<?php }?> class="product_list <?php echo $_smarty_tpl->tpl_vars['LISTING_GRIG_MODE']->value;?>
 row <?php if (isset($_smarty_tpl->tpl_vars['class']->value)&&$_smarty_tpl->tpl_vars['class']->value) {?> <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
<?php }?>">
	<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['total'] = $_smarty_tpl->tpl_vars['product']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['iteration']++;
?>
		<?php echo smarty_function_math(array('equation'=>"(total%perLine)",'total'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['total'],'perLine'=>$_smarty_tpl->tpl_vars['nbItemsPerLine']->value,'assign'=>'totModulo'),$_smarty_tpl);?>

		<?php echo smarty_function_math(array('equation'=>"(total%perLineT)",'total'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['total'],'perLineT'=>$_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value,'assign'=>'totModuloTablet'),$_smarty_tpl);?>

		<?php echo smarty_function_math(array('equation'=>"(total%perLineT)",'total'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['total'],'perLineT'=>$_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->value,'assign'=>'totModuloMobile'),$_smarty_tpl);?>

		<?php if ($_smarty_tpl->tpl_vars['totModulo']->value==0) {?><?php if (isset($_smarty_tpl->tpl_vars['totModulo'])) {$_smarty_tpl->tpl_vars['totModulo'] = clone $_smarty_tpl->tpl_vars['totModulo'];
$_smarty_tpl->tpl_vars['totModulo']->value = $_smarty_tpl->tpl_vars['nbItemsPerLine']->value; $_smarty_tpl->tpl_vars['totModulo']->nocache = null; $_smarty_tpl->tpl_vars['totModulo']->scope = 0;
} else $_smarty_tpl->tpl_vars['totModulo'] = new Smarty_variable($_smarty_tpl->tpl_vars['nbItemsPerLine']->value, null, 0);?><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['totModuloTablet']->value==0) {?><?php if (isset($_smarty_tpl->tpl_vars['totModuloTablet'])) {$_smarty_tpl->tpl_vars['totModuloTablet'] = clone $_smarty_tpl->tpl_vars['totModuloTablet'];
$_smarty_tpl->tpl_vars['totModuloTablet']->value = $_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value; $_smarty_tpl->tpl_vars['totModuloTablet']->nocache = null; $_smarty_tpl->tpl_vars['totModuloTablet']->scope = 0;
} else $_smarty_tpl->tpl_vars['totModuloTablet'] = new Smarty_variable($_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value, null, 0);?><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['totModuloMobile']->value==0) {?><?php if (isset($_smarty_tpl->tpl_vars['totModuloMobile'])) {$_smarty_tpl->tpl_vars['totModuloMobile'] = clone $_smarty_tpl->tpl_vars['totModuloMobile'];
$_smarty_tpl->tpl_vars['totModuloMobile']->value = $_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->value; $_smarty_tpl->tpl_vars['totModuloMobile']->nocache = null; $_smarty_tpl->tpl_vars['totModuloMobile']->scope = 0;
} else $_smarty_tpl->tpl_vars['totModuloMobile'] = new Smarty_variable($_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->value, null, 0);?><?php }?>	
		<div class="ajax_block_product col-sp-12 <?php echo $_smarty_tpl->tpl_vars['colValue']->value;?>
<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLine']->value==0) {?> last-in-line
		<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLine']->value==1) {?> first-in-line<?php }?>
		<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']>($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['total']-$_smarty_tpl->tpl_vars['totModulo']->value)) {?> last-line<?php }?>
		<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value==0) {?> last-item-of-tablet-line
		<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value==1) {?> first-item-of-tablet-line<?php }?>
		<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->value==0) {?> last-item-of-mobile-line
		<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->value==1) {?> first-item-of-mobile-line<?php }?>
		<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']>($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['total']-$_smarty_tpl->tpl_vars['totModuloMobile']->value)) {?> last-mobile-line<?php }?>">
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./sub/product-item/product-item.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('callFromModule'=>isset($_smarty_tpl->tpl_vars['class']->value)), 0);?>

		</div>

	<?php } ?>
	</div>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'min_item')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'min_item'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'Please select at least one product','js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'min_item'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'max_item')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'max_item'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'You cannot add more than %d product(s) to the product comparison','sprintf'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value,'js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'max_item'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('comparator_max_item'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('comparedProductsIds'=>$_smarty_tpl->tpl_vars['compared_products']->value),$_smarty_tpl);?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'hidePricesSwitchLabel')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'hidePricesSwitchLabel'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'Hide prices','js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'hidePricesSwitchLabel'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }?><?php }} ?>
