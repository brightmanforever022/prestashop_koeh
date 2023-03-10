{*
	************************
		Creat by leo themes
	**************************
*}
{if !isset($callFromModule) || $callFromModule==0}
{include file="$tpl_dir./layout/setting.tpl"}
{/if}
<div class="product-container product-block" itemscope itemtype="http://schema.org/Product">
	<div class="left-block">
	{hook h='productVariants' productId=$product.id_product}
		<div class="product-image-container image">
		    <div class="leo-more-info" data-idproduct="{$product.id_product}"></div>
			<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
				<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" itemprop="image" />
				<span class="product-additional" data-idproduct="{$product.id_product}"></span>
			</a>		
			{if isset($product.new) && $product.new == 1}				
				<span class="label labelnew"><span class="label-new">{l s='New'}</span></span>				
			{/if}
			{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
				<span class="label labelsale"><span class="label-sale">{l s='Sale!'}</span></span>
			{/if}
				
		</div>
		{hook h="displayProductDeliveryTime" product=$product}
		{hook h="displayProductPriceBlock" product=$product type="weight"}
		
		<div class="content-buttons clearfix">
			{if $page_name !='product'}	
				<div class="cart">
					{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
						{if (!isset($product.customization_required) || !$product.customization_required) && ($product.allow_oosp || $product.quantity > 0)}
							{if isset($static_token)}
								<a class="button ajax_add_to_cart_button btn" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
										<i class="fa fa-shopping-cart"></i><span>{l s='Add to cart'}</span>
								</a>
							{else}
								<a class="button ajax_add_to_cart_button btn" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
									<i class="fa fa-shopping-cart"></i><span>{l s='Add to cart'}</span>
								</a>
							{/if}
						{else}
							<div class="btn btn-default disabled" title="{l s='Out of stock'}">
								<i class="fa fa-shopping-cart"></i><span>{l s='Out of stock'}</span> 
							</div>
						{/if}
					{/if}
				</div>  
			{/if}
			{if $ENABLE_WISHLIST}			
			<div class="wishlist btn-small">					
				{hook h='displayProductListFunctionalButtons' product=$product}				
			</div>	
			{/if}
			{if isset($comparator_max_item) && $comparator_max_item}				
				<a class="add_to_compare compare btn btn-outline" href="{$product.link|escape:'html':'UTF-8'}" data-id-product="{$product.id_product}" title="{l s='Add to compare'}" >
					<i class="fa fa-align-center"></i> 
				</a>										
			{/if}
			{if isset($quick_view) && $quick_view}
				<div class="btn-small">		
					<a class="btn quick-view" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}" title="{l s='Quick view'}" >
						<i class="fa fa-eye"></i>
					</a>
				</div>
			{/if}

		</div>	
	</div>

	<div class="right-block">
		<div class="product-meta">
			<div class="product-title">
				<h5 itemprop="name" class="name">
					{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
					<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
						{$product.supplier_reference_code|escape:'html':'UTF-8'}
					</a>
				</h5>
				{if !isset($moduleCalling) || $moduleCalling != "productcategory"}
					{hook h='displayProductListReviews' product=$product}
				{/if} 
			</div>
			<div class="product-desc" itemprop="description">
				{$product.description_short|strip_tags:'UTF-8'}
			</div>
			
			<div class="functional-buttons">
				{if (!$PS_CATALOG_MODE && ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
					<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="content_price">
						{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
							<meta itemprop="priceCurrency" content="{$currency->iso_code}" />
							{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
								{hook h="displayProductPriceBlock" product=$product type="old_price"}
								<span class="old-price product-price">
									{displayWtPrice p=$product.price_without_reduction}
								</span>
								{if $product.specific_prices.reduction_type == 'percentage'}
									<span class="price-percent-reduction">-{$product.specific_prices.reduction * 100}%</span>
								{/if}
							{/if}
							<span itemprop="price" class="price product-price">
								{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
							</span>
							{hook h="displayProductPriceBlock" product=$product type="price"}
							{hook h="displayProductPriceBlock" product=$product type="unit_price"}
						{/if}
					</div>
				{/if}
			</div>

			{if isset($product.color_list) && $ENABLE_COLOR}
				<div class="color-list-container">{$product.color_list} </div>
			{/if} 
		</div> <!-- end product meta -->
		
	</div>
</div>
<!-- .product-container> -->

