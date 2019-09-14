<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:40:35
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/sub/product/product-list-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21215759545d5963632ed6f3-12771289%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99fd7a0cd467da162c911eec996430e0082b33e0' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/sub/product/product-list-form.tpl',
      1 => 1556017948,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21215759545d5963632ed6f3-12771289',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'nb_products' => 0,
    'products_per_page' => 0,
    'start' => 0,
    'stop' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5963632ffea2_67722407',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5963632ffea2_67722407')) {function content_5d5963632ffea2_67722407($_smarty_tpl) {?><div class="content_sortPagiBar clearfix" >
    <div class="sortPagiBar clearfix row">
        <div class="col-md-8 col-sm-6 col-xs-12">
          <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./pagination-category.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('no_follow'=>1), 0);?>

        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="sort top_pagi">
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./nbr-product-page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
	
            </div>
        </div>
    </div>
    <div class="sortPagiBar clearfix row" style="margin-top:10px">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-sort.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </div>
        <div class="product-compare col-md-6 col-sm-6 col-xs-12">
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </div>

    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['products']->value), 0);?>


<div class="content_sortPagiBar" <?php if (!($_smarty_tpl->tpl_vars['nb_products']->value>$_smarty_tpl->tpl_vars['products_per_page']->value&&$_smarty_tpl->tpl_vars['start']->value!=$_smarty_tpl->tpl_vars['stop']->value)) {?>style="display:none" <?php }?>>
    <div class="bottom-pagination-content clearfix row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('no_follow'=>1,'paginationId'=>'bottom'), 0);?>

        </div>
        <div class="product-compare col-md-2 col-sm-4 col-xs-6">
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('paginationId'=>'bottom'), 0);?>

        </div>
    </div>
</div>
<?php }} ?>
