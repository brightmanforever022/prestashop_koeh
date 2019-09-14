{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if $nb_products > $products_per_page && $start!=$stop}
{if isset($no_follow) AND $no_follow}
	{assign var='no_follow_text' value='rel="nofollow"'}
{else}
	{assign var='no_follow_text' value=''}
{/if}

{if isset($p) AND $p}
    {if !isset($seoUrls)}
         {assign var='seoUrls' value=false}
    {/if}
	{if isset($smarty.get.id_category) && $smarty.get.id_category && isset($category)}
		{if !isset($current_url)}
			{assign var='requestPage' value=$link->getPaginationLink('category', $category, false, false, true, false)}
		{else}
			{assign var='requestPage' value=$current_url}
		{/if}
		{assign var='requestNb' value=$link->getPaginationLink('category', $category, true, false, false, true)}
	{elseif isset($smarty.get.id_manufacturer) && $smarty.get.id_manufacturer && isset($manufacturer)}
		{assign var='requestPage' value=$link->getPaginationLink('manufacturer', $manufacturer, false, false, true, false)}
		{assign var='requestNb' value=$link->getPaginationLink('manufacturer', $manufacturer, true, false, false, true)}
	{elseif isset($smarty.get.id_supplier) && $smarty.get.id_supplier && isset($supplier)}
		{assign var='requestPage' value=$link->getPaginationLink('supplier', $supplier, false, false, true, false)}
		{assign var='requestNb' value=$link->getPaginationLink('supplier', $supplier, true, false, false, true)}
	{else}
		{if !isset($current_url)}
			{assign var='requestPage' value=$link->getPaginationLink(false, false, false, false, true, false)}
		{else}
			{assign var='requestPage' value=$current_url}
		{/if}
		{assign var='requestNb' value=$link->getPaginationLink(false, false, true, false, false, true)}
	{/if}
	<!-- Pagination -->
	<div id="pagination{if isset($paginationId)}_{$paginationId}{/if}" class="pagination pagination_top clearfix row">
	    {if $nb_products > $products_per_page && $start!=$stop}
			<form class="showall pull-left col-md-6" action="{if !is_array($requestNb)}{$requestNb}{else}{$requestNb.requestUrl}{/if}" method="get">
				<div>
					{if isset($search_query) AND $search_query}
						<input type="hidden" name="search_query" value="{$search_query|escape:'html':'UTF-8'}" />
					{/if}
					{if isset($tag) AND $tag AND !is_array($tag)}
						<input type="hidden" name="tag" value="{$tag|escape:'html':'UTF-8'}" />
					{/if}
                    <span class="product_number" style="float:left;">{$nb_products} {l s='Artikel | '}</span>
	                <button type="submit" class="show_all all_shows">
	                	<span>{l s='Alle anzeigen'}</span>
	                </button>
					{if is_array($requestNb)}
                                            {if isset($requestNb['blreset'])}
                                                {*<input type="hidden" name="id_category_layered" value="{$requestNb['id_category_layered']}" />*}
                                            {else}
						{foreach from=$requestNb item=requestValue key=requestKey}
							{if $requestKey != 'requestUrl' && $requestKey != 'p'}
								<input type="hidden" name="{$requestKey|escape:'html':'UTF-8'}" value="{$requestValue|escape:'html':'UTF-8'}" />
							{/if}
						{/foreach}
                                            {/if}
					{/if}
	                <input name="n" id="nb_item" class="hidden" value="{$nb_products}" />
				</div>
			</form>
		{/if}
                {if $start!=$stop}
		<div class="pagination col-md-6" style="/*display: table;*/  margin: 0 auto;">
			{if $p != 1}
				{assign var='p_previous' value=$p-1}
					<a {$no_follow_text} href="{$link->goPage($requestPage, $p_previous, $seoUrls)}" rel="prev" class="pagination_previous">
						<i class="fa fa-chevron-left"></i>
					</a>
			{else}
					<span class="pagination_previous disabled">
						<i class="fa fa-chevron-left"></i>
					</span>
			{/if}
			<div class="paginationMiddle">
				<select class="paginationDropdown">
				 <option>{l s='Page %1$d from %2$d' sprintf=[$p, $pages_nb]}</option>
				 {section name=pagination start=1 loop=$pages_nb+1 step=1}
				 <option value="{$link->goPage($requestPage, $smarty.section.pagination.index, $seoUrls)}">{$smarty.section.pagination.index}</option>
				 {/section}
				</select>
			</div>
			{if $pages_nb > 1 AND $p != $pages_nb}
					{assign var='p_next' value=$p+1}
					<a {$no_follow_text} href="{$link->goPage($requestPage, $p_next, $seoUrls)}" rel="next" class="pagination_next">
						<i class="fa fa-chevron-right"></i>
					</a>
			{else}
					<span class="pagination_next disabled">
						<i class="fa fa-chevron-right"></i>
					</span>
			{/if}
		</div>
		
		{/if}
	</div>
	<!-- /Pagination -->
{/if}
{else}
    <div id="pagination{if isset($paginationId)}_{$paginationId}{/if}" class="pagination clearfix pull-left" style="display:none"></div>
{/if}