<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:38:54
         compiled from "/home/koehlert/public_html/modules/khlcart//shopping-cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13070672445d5a43fe5127d7-36643237%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '103312c17e2918d4972cb872e813ead4086235d7' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlcart//shopping-cart.tpl',
      1 => 1561647388,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13070672445d5a43fe5127d7-36643237',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nostock_nosupply_products_to_warn' => 0,
    'product_warn' => 0,
    'nostock_nosupply_message' => 0,
    'first_order_allowed' => 0,
    'first_order_disallowed_message' => 0,
    'nostock_nosupply_ids' => 0,
    'nostock_nosupply_cart_line_message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a43fe5435f5_95820378',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a43fe5435f5_95820378')) {function content_5d5a43fe5435f5_95820378($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['nostock_nosupply_products_to_warn']->value)) {?>
<ul class="alert alert-danger alert-nostocknoprdc">
	<?php  $_smarty_tpl->tpl_vars['product_warn'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product_warn']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['nostock_nosupply_products_to_warn']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product_warn']->key => $_smarty_tpl->tpl_vars['product_warn']->value) {
$_smarty_tpl->tpl_vars['product_warn']->_loop = true;
?>
	<li>"<?php echo $_smarty_tpl->tpl_vars['product_warn']->value['product']->supplier_reference;?>
 <?php echo $_smarty_tpl->tpl_vars['product_warn']->value['combinations_text'];?>
" : <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['nostock_nosupply_message']->value, ENT_QUOTES, 'UTF-8', true);?>
</li>
	<?php } ?>
</ul>
<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['first_order_allowed']->value) {?>
<ul class="alert alert-danger alert-firstorderdisallowed">
    <li><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['first_order_disallowed_message']->value, ENT_QUOTES, 'UTF-8', true);?>
</li>
</ul>

<?php }?>

<script type="text/javascript">
var nostockNoSupplyIds = <?php echo $_smarty_tpl->tpl_vars['nostock_nosupply_ids']->value;?>
;
var checkout_allowed = <?php echo intval($_smarty_tpl->tpl_vars['first_order_allowed']->value);?>
;
$(function(){
	$('#cart_summary tbody tr span.nostock_nosupply_line_warn').remove();
	$('#cart_summary tbody tr').each(function(ind, elem){
		//let prodRowId = $(this).attr('id');
		let prodRowIdParts = $(this).attr('id').match(/product_(\d+)_(\d+)_(\d+)_(\d+)/);
		if(!Array.isArray(prodRowIdParts)){
			return;
		}
		let cartProdId = parseInt( prodRowIdParts[1] ); 
		let cartProdCombId = parseInt( prodRowIdParts[2] );
		for( let nsi = 0; nsi < nostockNoSupplyIds.length ; nsi++ ){
			if( (nostockNoSupplyIds[nsi].id_product == cartProdId)
				&& (nostockNoSupplyIds[nsi].id_product_combination == cartProdCombId)
			){
				$(this).find('td.cart_avail')
					.append('<span class="label label-danger nostock_nosupply_line_warn"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['nostock_nosupply_cart_line_message']->value, ENT_QUOTES, 'UTF-8', true);?>
</span>');
			}
		}
		
	});
	
	if(checkout_allowed){
		$('#cart_proceed_to_checkout').show();
	}
	else{
		$('#cart_proceed_to_checkout').hide();
	}
});

</script><?php }} ?>
