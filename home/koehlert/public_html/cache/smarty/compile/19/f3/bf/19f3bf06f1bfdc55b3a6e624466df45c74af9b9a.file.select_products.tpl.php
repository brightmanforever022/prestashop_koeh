<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/select_products.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2859095575d5a47a870f550-03661135%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '19f3bf06f1bfdc55b3a6e624466df45c74af9b9a' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/select_products.tpl',
      1 => 1535703290,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2859095575d5a47a870f550-03661135',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'product_tpl_content' => 0,
    'display_product_image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a87671f5_96420502',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a87671f5_96420502')) {function content_5d5a47a87671f5_96420502($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#selectProducts') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">');
	} 
</script>
<?php }?>

	<h4 style="float: left;"><?php echo smartyTranslate(array('s'=>'Select products to insert into template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>

	<a id="product_help" href="javascript:{}" class="btn btn-default product-help" onclick="NewsletterProControllers.TemplateController.showProductHelp();"><i class="icon icon-eye"></i> <?php echo smartyTranslate(array('s'=>'View available variables','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
	<div class="clear"></div>
	<div class="separation" style="clear: both;"></div>

	<div class="data-grid-div">
		<table id="product-template-list" class="table table-bordered product-template-list">
			<thead>
				<tr>
					<th class="name" data-field="name"><?php echo smartyTranslate(array('s'=>'Template Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="date" data-field="date"><?php echo smartyTranslate(array('s'=>'Date Modified','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="np-info" data-template="info"><?php echo smartyTranslate(array('s'=>'For Newsletter Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
		</table>
	</div>
	<br>
	<div>
		<a href="javascript:{}" class="btn btn-default pull-left" onclick="NewsletterProControllers.TemplateController.toggleShowProductTpl( $(this) )" data-name='{"show":"<?php echo smartyTranslate(array('s'=>'Show product template','mod'=>'newsletterpro'),$_smarty_tpl);?>
","hide":"<?php echo smartyTranslate(array('s'=>'Hide product template','mod'=>'newsletterpro'),$_smarty_tpl);?>
"}'>
			<i class="icon icon-eye"></i>
			<span><?php echo smartyTranslate(array('s'=>'Show product template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
		</a>
		<a href="javascript:{}" class="button" style="margin-left: 15px; display: none;" onclick="NewsletterProControllers.TemplateController.loadProductTemplate()"><?php echo smartyTranslate(array('s'=>'Load product template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
		<div class="clear" style="height: 0;"></div>

		<div id="product-template" style="display: none;">
			<div>
				<div class="br">&nbsp;</div>
				<p class="help-block"><?php echo smartyTranslate(array('s'=>'Press the help button in the upper right corner to see full list of available variables.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
				<div id="product-template-content">
					<textarea style="display: none;" id="product-template-content-textarea" class="template-css"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product_tpl_content']->value, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
					<div id="product-content-box">
						<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['textarea_tpl']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('class_name'=>'product_rte','content_name'=>'product_content','config'=>'product_config','input_name'=>'product_template_text','input_value'=>$_smarty_tpl->tpl_vars['product_tpl_content']->value), 0);?>

					</div>
				</div>
			</div>

			<div class="view-content">
				<div id="view-product-template-content" style="display: none;">&nbsp;</div>
				<div class="clear"></div>
			</div>
			<br />
			<div class="form-group">
				<div class="col-sm-8">
					<div id="save-product-template-message" style="display: none;">&nbsp;</div>
				</div>
				<div class="col-sm-4">
					<a id="save-product-template" href="javascript:{}" class="btn btn-default pull-right" onclick="NewsletterProControllers.TemplateController.saveToggleProductTemplate( $(this) )" data-name='{"view":"<?php echo smartyTranslate(array('s'=>'Save and View','mod'=>'newsletterpro'),$_smarty_tpl);?>
","edit":"<?php echo smartyTranslate(array('s'=>'Edit','mod'=>'newsletterpro'),$_smarty_tpl);?>
"}'>
						<i class="icon icon-edit"></i>
						<span><?php echo smartyTranslate(array('s'=>'Save and view','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</a>
					<a href="javascript:{}" class="btn btn-default pull-right btn-margin-right" onclick="NewsletterProControllers.TemplateController.saveAsProductTemplate( $(this) );"  data-message="<?php echo smartyTranslate(array('s'=>'Please insert the name of the new product template:','mod'=>'newsletterpro'),$_smarty_tpl);?>
">
						<i class="icon icon-save"></i>
						<span><?php echo smartyTranslate(array('s'=>'Save as','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</a>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<br>
	<div class="clear">&nbsp;</div>

	<div style="position: relative;">
		<div id="categories-list" class="div_userlist categories-list">
			<h4><?php echo smartyTranslate(array('s'=>'Categories','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
			<div class="separation"></div>

			<div class="clear">&nbsp;</div>
		<ul class="userlist"></ul>
		<div class="clear">&nbsp;</div>
		</div>
		<div id="product-list" class="div_userlist products-list">
			<h4 style="margin-left: 10px;"><?php echo smartyTranslate(array('s'=>'Products','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
			<div class="separation"></div>

			<div class="clear">&nbsp;</div>
			<div class="poduct-search-container">
				<span class="product-search-span ajax-loader" style="display: none;">&nbsp;</span>
				<input id="poduct-search" class="search-bar empty" type="text" value="<?php echo smartyTranslate(array('s'=>'search products by:','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'name, reference, category or type:','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'new products','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'or','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'price drop','mod'=>'newsletterpro'),$_smarty_tpl);?>
">
				<select id="product-sort">
					<option value="reference">Reference</option>
					<option value="quantity">Quantity</option>
				</select>
			</div>
			<div class="clear">&nbsp;</div>
			<a id="toggle-categories" href="javascript:{}" class="slide-toggle" onclick="NewsletterProControllers.NavigationController.toggleCategories( $(this) )">&nbsp;</a>
			<div class="userlist">
			<table>
				<tbody>
				</tbody>
			</table>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
		<div class="clear">&nbsp;</div>
		<div id="display-product-image-container" class="display-product-image-container">
			<label for="display-product-image" class="control-label">
				<input id="display-product-image" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['display_product_image']->value==true) {?> checked <?php }?> onclick="NewsletterProControllers.NavigationController.displayProductImage( $(this) )"> <?php echo smartyTranslate(array('s'=>'Display product image','mod'=>'newsletterpro'),$_smarty_tpl);?>

			</label>
			<span id="display-product-image-message">&nbsp;</span>
			<div class="clear">&nbsp;</div>
		</div>
		<div class="margin-top" style="float: right;">
			<a href="javascript:{}" style="float: right;" onclick="NewsletterPro.components.Product.removeAllProducts();" class="btn btn-default">
				<i class="icon icon-minus-circle"></i> <?php echo smartyTranslate(array('s'=>'remove all','mod'=>'newsletterpro'),$_smarty_tpl);?>

			</a> 
			<div class="clear">&nbsp;</div>
		</div>
	</div>

	<div class="clear">&nbsp;</div>
	<br>

	<div id="products-adjustments-div">
		<h4><?php echo smartyTranslate(array('s'=>'Products adjustments','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
		<div class="separation"></div>

		<p class="help-block" style="width: auto;"><?php echo smartyTranslate(array('s'=>'The responsive templates are not adjustable, because the responsive layout can be damaged by the adjustments. You can adjust them by changing the CSS and HTML.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
		<div id="products-adjustments" class="products-adjustments" style="background: #FFF; border: solid thin #d0d0d0; padding: 10px; display: block; margin: 0 auto;">

			<table>
				<tr>
					<td class="first-item">
						<div class="slider-container">
							<label><?php echo smartyTranslate(array('s'=>'Products per row:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
							<div id="slider-products-per-row"></div>
						</div>
					</td>
					<td>
						<div class="slider-container" style="display: none;">
							<label><?php echo smartyTranslate(array('s'=>'Image size:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
							<div id="slider-image-size"></div>
						</div>
					</td>
					<td>
						<div class="slider-container" style="display: none;">
							<label><?php echo smartyTranslate(array('s'=>'Products width:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
							<div id="slider-product-width"></div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="first-item">
						<div class="slider-container" style="display: none;">
							<label><?php echo smartyTranslate(array('s'=>'Trim product name:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
							<div id="slider-name"></div>
						</div>
					</td>
					<td class="item">
						<div class="slider-container" style="display: none;">
							<label><?php echo smartyTranslate(array('s'=>'Trim product short description:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
							<div id="slider-description-short"></div>
						</div>
					</td>
					<td class="last-item">
						<div class="slider-container" style="display: none;">
							<label><?php echo smartyTranslate(array('s'=>'Trim product description:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
							<div id="slider-description"></div>
						</div>
					</td>
				</tr>
			</table>

			<div class="clear"></div>
		</div>
	</div>

	<div class="clear">&nbsp;</div>
	<br>

	<div id="np-view-products-box" class="clearfix" style="display: block;">
		<div class="form-group clearfix">
			<div class="form-inline">
				<div class="form-group pull-left">
					<h4><?php echo smartyTranslate(array('s'=>'View selected products','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <i id="slider-ppr-loading" class="icon icon-refresh icon-spin slider-ppr-loading" style="display: none;"></i><span style="font-size: 12px; color: #3586AE;margin-left: 10px;"><?php echo smartyTranslate(array('s'=>'width','mod'=>'newsletterpro'),$_smarty_tpl);?>
: <span id="sp-width">0</span>px</span></h4>
				</div>
				<div class="form-group pull-right">
					<label class="control-label np-margin-5"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Language','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
					<div id="np-change-view-template-lang" class="gk_lang_select pull-right np-margin-5-left"></div>
				</div>
				<div class="form-group pull-right">
					<label class="control-label np-margin-5"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Currency for this language','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
					<div id="products-currency-change" class="gk_currency_select pull-right np-margin-5"></div>
				</div>
				<div class="form-group pull-right np-margin-5">
					<select id="np-selected-products-sort-order" class="gk-select form-control" style="margin: 0;">
						<option value="1"><?php echo smartyTranslate(array('s'=>'asc','mod'=>'newsletterpro'),$_smarty_tpl);?>
</option>
						<option value="0"><?php echo smartyTranslate(array('s'=>'desc','mod'=>'newsletterpro'),$_smarty_tpl);?>
</option>
					</select>
				</div>
				<div class="form-group pull-right np-margin-5">
					<label class="control-label np-margin-5"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Sort by','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
					<select id="np-selected-products-sort" class="gk-select form-control" style="margin: 0;">
						<option value="0">- <?php echo smartyTranslate(array('s'=>'none','mod'=>'newsletterpro'),$_smarty_tpl);?>
 -</option>
						<option value="name"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</option>
						<option value="price"><?php echo smartyTranslate(array('s'=>'Price','mod'=>'newsletterpro'),$_smarty_tpl);?>
</option>
						<option value="reduction"><?php echo smartyTranslate(array('s'=>'Reduction','mod'=>'newsletterpro'),$_smarty_tpl);?>
</option>
						<option value="discount"><?php echo smartyTranslate(array('s'=>'Discount','mod'=>'newsletterpro'),$_smarty_tpl);?>
</option>
					</select>
				</div>
			</div>
			<div class="separation" style="clear: both;"></div>
		</div>

		<div style="background: #FFF; border: solid thin #d0d0d0; padding: 10px; display: block; margin: 0 auto;" class="view-selected-products">
			<div id="selected-products" class="clearfix" style="margin: 0 auto; display: block; position: relative; width: 100%;"></div>
		</div>
	</div>

	<div class="clear">&nbsp;</div>
	<br>

	<a id="setp1" href="#createTemplate" class="btn btn-primary pull-right" onclick="NewsletterProControllers.NavigationController.goToStep( 4 );" >
	<span><?php echo smartyTranslate(array('s'=>'Next Step','mod'=>'newsletterpro'),$_smarty_tpl);?>
 &raquo;</span></a>
</div><?php }} ?>
