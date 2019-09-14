<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 17:09:20
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14748714925d596a208af6c3-89410559%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0806ebf627f765ca2f9ff9b6b68f66abf2cd8776' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/category.tpl',
      1 => 1468576849,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14748714925d596a208af6c3-89410559',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'subcategories' => 0,
    'display_subcategories' => 0,
    'products' => 0,
    'categoryNameComplement' => 0,
    'page_name' => 0,
    'scenes' => 0,
    'link' => 0,
    'description_short' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596a20912140_55281205',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596a20912140_55281205')) {function content_5d596a20912140_55281205($_smarty_tpl) {?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if (isset($_smarty_tpl->tpl_vars['category']->value)) {?>
	<?php if ($_smarty_tpl->tpl_vars['category']->value->id&&$_smarty_tpl->tpl_vars['category']->value->active) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['subcategories']->value)) {?>
        <?php if ((isset($_smarty_tpl->tpl_vars['display_subcategories']->value)&&$_smarty_tpl->tpl_vars['display_subcategories']->value==1)||!isset($_smarty_tpl->tpl_vars['display_subcategories']->value)) {?>
        <h1 class="page-heading<?php if ((isset($_smarty_tpl->tpl_vars['subcategories']->value)&&!$_smarty_tpl->tpl_vars['products']->value)||(isset($_smarty_tpl->tpl_vars['subcategories']->value)&&$_smarty_tpl->tpl_vars['products']->value)||!isset($_smarty_tpl->tpl_vars['subcategories']->value)&&$_smarty_tpl->tpl_vars['products']->value) {?> product-listing<?php }?>">
            <span class="cat-name">
                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true);?>
<?php if (isset($_smarty_tpl->tpl_vars['categoryNameComplement']->value)) {?>&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryNameComplement']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
            </span>
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./category-count.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </h1>
        			<?php if (in_array($_smarty_tpl->tpl_vars['page_name']->value,array('category'))) {?>	
						<?php if (isset($_smarty_tpl->tpl_vars['category']->value)) {?>
						<?php if ($_smarty_tpl->tpl_vars['category']->value->id&&$_smarty_tpl->tpl_vars['category']->value->active) {?>
					    	<?php if ($_smarty_tpl->tpl_vars['scenes']->value||$_smarty_tpl->tpl_vars['category']->value->description||$_smarty_tpl->tpl_vars['category']->value->id_image) {?>
								<div class="content_scene_cat">
									<?php if ($_smarty_tpl->tpl_vars['scenes']->value) {?>
										<div class="content_scene">
									    <!-- Scenes -->
									    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./scenes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('scenes'=>$_smarty_tpl->tpl_vars['scenes']->value), 0);?>

									</div>
									<?php } else { ?>
									<!-- Category image -->
									<div class="content_scene_cat_bg scene_cat">
										<?php if ($_smarty_tpl->tpl_vars['category']->value->id_image) {?>
										<div class="image">
											<img class="img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCatImageLink($_smarty_tpl->tpl_vars['category']->value->link_rewrite,$_smarty_tpl->tpl_vars['category']->value->id_image,'category_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" id="categoryImage"  /> 
										</div>
										<?php }?>
									 </div>
									<?php }?>
					            </div>
							<?php }?>
						<?php }?>
						<?php }?>
					<?php }?>
        <?php if ($_smarty_tpl->tpl_vars['category']->value->description) {?>
            <div class="cat_desc rte">
            <?php if (Tools::strlen($_smarty_tpl->tpl_vars['category']->value->description)>350) {?>
                <div id="category_description_short"><?php echo $_smarty_tpl->tpl_vars['description_short']->value;?>
</div>
                <div id="category_description_full" class="unvisible"><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</div>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['category']->value->id_category,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="lnk_more"><?php echo smartyTranslate(array('s'=>'More'),$_smarty_tpl);?>
</a>
            <?php } else { ?>
                <div><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</div>
            <?php }?>
            </div>
        <?php }?>
		<!-- Subcategories -->
					
        	
        <?php }?>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['products']->value) {?>
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./sub/product/product-list-form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<?php }?>
	<?php } elseif ($_smarty_tpl->tpl_vars['category']->value->id) {?>
		<p class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'This category is currently unavailable.'),$_smarty_tpl);?>
</p>
	<?php }?>
<?php }?><?php }} ?>
