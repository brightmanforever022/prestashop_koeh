<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:30:14
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/modules/productscategory/productscategory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8923066045d5960f68318a5-17195178%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f436ac8dbe85a22256f7be2783ec6358ae96c32' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/modules/productscategory/productscategory.tpl',
      1 => 1442250768,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8923066045d5960f68318a5-17195178',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'categoryProducts' => 0,
    'tabname' => 0,
    'products' => 0,
    'itemsperpage' => 0,
    'mproducts' => 0,
    'columnspage' => 0,
    'comparator_max_item' => 0,
    'compared_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5960f68881e6_28638260',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5960f68881e6_28638260')) {function content_5d5960f68881e6_28638260($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/koehlert/public_html/tools/smarty/plugins/modifier.replace.php';
?>
<?php if (count($_smarty_tpl->tpl_vars['categoryProducts']->value)>0&&$_smarty_tpl->tpl_vars['categoryProducts']->value!==false) {?>

<div class="page-product-box blockproductscategory products_block block">
	<h4 class="page-subheading">
		<span class="line"></span>
		<span class="title"><?php echo smartyTranslate(array('s'=>'Related Products','mod'=>'productscategory'),$_smarty_tpl);?>
</span>
	</h4>
	<div id="productscategory_list" class="clearfix">
		<?php if (isset($_smarty_tpl->tpl_vars['tabname'])) {$_smarty_tpl->tpl_vars['tabname'] = clone $_smarty_tpl->tpl_vars['tabname'];
$_smarty_tpl->tpl_vars['tabname']->value = 'blockproductscategory'; $_smarty_tpl->tpl_vars['tabname']->nocache = null; $_smarty_tpl->tpl_vars['tabname']->scope = 0;
} else $_smarty_tpl->tpl_vars['tabname'] = new Smarty_variable('blockproductscategory', null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['itemsperpage'])) {$_smarty_tpl->tpl_vars['itemsperpage'] = clone $_smarty_tpl->tpl_vars['itemsperpage'];
$_smarty_tpl->tpl_vars['itemsperpage']->value = '4'; $_smarty_tpl->tpl_vars['itemsperpage']->nocache = null; $_smarty_tpl->tpl_vars['itemsperpage']->scope = 0;
} else $_smarty_tpl->tpl_vars['itemsperpage'] = new Smarty_variable('4', null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['columnspage'])) {$_smarty_tpl->tpl_vars['columnspage'] = clone $_smarty_tpl->tpl_vars['columnspage'];
$_smarty_tpl->tpl_vars['columnspage']->value = '4'; $_smarty_tpl->tpl_vars['columnspage']->nocache = null; $_smarty_tpl->tpl_vars['columnspage']->scope = 0;
} else $_smarty_tpl->tpl_vars['columnspage'] = new Smarty_variable('4', null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['products'])) {$_smarty_tpl->tpl_vars['products'] = clone $_smarty_tpl->tpl_vars['products'];
$_smarty_tpl->tpl_vars['products']->value = $_smarty_tpl->tpl_vars['categoryProducts']->value; $_smarty_tpl->tpl_vars['products']->nocache = null; $_smarty_tpl->tpl_vars['products']->scope = 0;
} else $_smarty_tpl->tpl_vars['products'] = new Smarty_variable($_smarty_tpl->tpl_vars['categoryProducts']->value, null, 0);?>
		<div class="block_content">
		<div class=" carousel slide" id="<?php echo $_smarty_tpl->tpl_vars['tabname']->value;?>
">
			<?php if (count($_smarty_tpl->tpl_vars['products']->value)>$_smarty_tpl->tpl_vars['itemsperpage']->value) {?>	
			<a class="carousel-control left" href="#<?php echo $_smarty_tpl->tpl_vars['tabname']->value;?>
" data-slide="prev"></a>
			<a class="carousel-control right" href="#<?php echo $_smarty_tpl->tpl_vars['tabname']->value;?>
" data-slide="next"></a>
			<?php }?>
			<div class="carousel-inner">
			<?php if (isset($_smarty_tpl->tpl_vars['mproducts'])) {$_smarty_tpl->tpl_vars['mproducts'] = clone $_smarty_tpl->tpl_vars['mproducts'];
$_smarty_tpl->tpl_vars['mproducts']->value = array_chunk($_smarty_tpl->tpl_vars['products']->value,$_smarty_tpl->tpl_vars['itemsperpage']->value); $_smarty_tpl->tpl_vars['mproducts']->nocache = null; $_smarty_tpl->tpl_vars['mproducts']->scope = 0;
} else $_smarty_tpl->tpl_vars['mproducts'] = new Smarty_variable(array_chunk($_smarty_tpl->tpl_vars['products']->value,$_smarty_tpl->tpl_vars['itemsperpage']->value), null, 0);?>
			<?php  $_smarty_tpl->tpl_vars['products'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['products']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mproducts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['products']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['products']->key => $_smarty_tpl->tpl_vars['products']->value) {
$_smarty_tpl->tpl_vars['products']->_loop = true;
 $_smarty_tpl->tpl_vars['products']->index++;
 $_smarty_tpl->tpl_vars['products']->first = $_smarty_tpl->tpl_vars['products']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['mypLoop']['first'] = $_smarty_tpl->tpl_vars['products']->first;
?>
				<div class="item <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['mypLoop']['first']) {?>active<?php }?>">
					<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['last'] = $_smarty_tpl->tpl_vars['product']->last;
?>
						<?php if ($_smarty_tpl->tpl_vars['product']->iteration%$_smarty_tpl->tpl_vars['columnspage']->value==1&&$_smarty_tpl->tpl_vars['columnspage']->value>1) {?>
						  <div class="row clearfix no-margin">
						<?php }?>
							<div class="col-sm-<?php echo smarty_modifier_replace((12/$_smarty_tpl->tpl_vars['columnspage']->value),".","-");?>
 col-md-<?php echo 12/$_smarty_tpl->tpl_vars['columnspage']->value;?>
 col-xs-12 product_block ajax_block_product">
								<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./sub/product-item/product-item.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('moduleCalling'=>"productcategory"), 0);?>

							</div>
						<?php if (($_smarty_tpl->tpl_vars['product']->iteration%$_smarty_tpl->tpl_vars['columnspage']->value==0||$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['last'])&&$_smarty_tpl->tpl_vars['columnspage']->value>1) {?>
							</div>
						<?php }?>
					<?php } ?>
				</div>
			<?php } ?>
			</div>
		</div>
		</div>
	</div>
</div>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'min_item')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'min_item'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'Please select at least one product','js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'min_item'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'max_item')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'max_item'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'You cannot add more than %d product(s) to the product comparison','sprintf'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value,'js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'max_item'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('comparator_max_item'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('comparedProductsIds'=>$_smarty_tpl->tpl_vars['compared_products']->value),$_smarty_tpl);?>

<?php }?><?php }} ?>
