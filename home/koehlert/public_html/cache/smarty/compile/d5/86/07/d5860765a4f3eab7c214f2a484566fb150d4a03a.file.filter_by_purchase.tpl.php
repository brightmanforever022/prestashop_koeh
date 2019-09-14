<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:35
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/filter_by_purchase.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19047651815d5a47ab811897-43658394%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd5860765a4f3eab7c214f2a484566fb150d4a03a' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/filter_by_purchase.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19047651815d5a47ab811897-43658394',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47ab824dc5_75828922',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47ab824dc5_75828922')) {function content_5d5a47ab824dc5_75828922($_smarty_tpl) {?>

<div id="filter-by-purchase-box" class="filter-by-purchase-box">
	<h4 class="title"><?php echo smartyTranslate(array('s'=>'Search products','mod'=>'newsletterpro'),$_smarty_tpl);?>
:</h4>
	<div class="clear" style="height: 0;">&nbsp;</div>
	<div class="poduct-search-container">
		<span class="product-search-span ajax-loader" style="display: none;">&nbsp;</span>
		<input id="filter-poduct-search" class="search-bar empty" tyle="text" value="<?php echo smartyTranslate(array('s'=>'search products by:','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'name, reference, category or type:','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'new products','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'or','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'price drop','mod'=>'newsletterpro'),$_smarty_tpl);?>
">
	</div>
	<div id="filter-product-list-box" class="userlist filter-product-list-box products-list">
		<table id="filter-product-list" class="filter-product-list"></table>
	</div>
	<div class="clear" style="clear: both;"></div>

	<br>
	<h4 class="title"><?php echo smartyTranslate(array('s'=>'Products in filter','mod'=>'newsletterpro'),$_smarty_tpl);?>
:</h4>
	<div class="fbp-grid-box">
		<table id="fbp-grid" class="table table-bordered fbp-grid">
			<thead>
				<tr>
					<th class="image" data-template="image"><?php echo smartyTranslate(array('s'=>'Image','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="name" data-field="name"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="reference" data-field="reference"><?php echo smartyTranslate(array('s'=>'Reference','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="price_display" data-field="price_display"><?php echo smartyTranslate(array('s'=>'Price','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
		</table>
	</div>

</div>
<?php }} ?>
