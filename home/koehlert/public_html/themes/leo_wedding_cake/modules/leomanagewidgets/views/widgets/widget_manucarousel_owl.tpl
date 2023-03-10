{**
 *  Leo Prestashop Theme Framework for Prestashop 1.5.x
 *
 * @package   leotempcp
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 *
 **}
 
 {if $manufacturers}
 <div id="manufacture-carousel" class="widget-manufacture block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="page-subheading">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">
		<div class="carousel slide" id="manucarousel">
			<div class="row">
				<div id="{$tab}" class="owl-carousel owl-theme">
					{$mmanufacturers=array_chunk($manufacturers,$owl_rows)}
					{foreach from=$mmanufacturers item=manufacturers name=mypLoop}
						<div class="item">
							{foreach from=$manufacturers item=manufacturer name=manufacturers}
								{if $manufacturer@iteration%$columnspage==1&&$columnspage>1}
									<div>
								{/if}
								<div class="logo-manu">
									<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{l s='view products' mod='leomanagewidgets'}">
									<img src="{$manufacturer.image|escape:'htmlall':'UTF-8'}" alt=""/></a>
								</div>
								{if ($manufacturer@iteration%$columnspage==0||$smarty.foreach.manufacturers.last)&&$columnspage>1}
									</div>
								{/if}
							{/foreach}
						</div>
					{/foreach}
				</div>
			</div>
		</div>
	</div>
</div>
{/if}


{assign var="call_owl_carousel" value="#{$tab}"}
{include file='./owl_carousel_config.tpl'}