{if isset($nostock_nosupply_products_to_warn)}
<ul class="alert alert-danger alert-nostocknoprdc">
	{foreach $nostock_nosupply_products_to_warn as $product_warn}
	<li>"{$product_warn['product']->supplier_reference} {$product_warn['combinations_text']}" : {$nostock_nosupply_message|escape:'html':'UTF-8'}</li>
	{/foreach}
</ul>
{/if}

{if !$first_order_allowed}
<ul class="alert alert-danger alert-firstorderdisallowed">
    <li>{$first_order_disallowed_message|escape:'html':'UTF-8'}</li>
</ul>

{/if}

<script type="text/javascript">
var nostockNoSupplyIds = {$nostock_nosupply_ids};
var checkout_allowed = {$first_order_allowed|intval};
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
					.append('<span class="label label-danger nostock_nosupply_line_warn">{$nostock_nosupply_cart_line_message|escape:'html':'UTF-8'}</span>');
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

</script>