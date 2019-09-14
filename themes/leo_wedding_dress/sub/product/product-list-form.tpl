<div class="content_sortPagiBar clearfix" {*if !($nb_products > $products_per_page && $start!=$stop)}style="display:none" {/if*}>
    <div class="sortPagiBar clearfix row">
        <div class="col-md-8 col-sm-6 col-xs-12">
          {include file="$tpl_dir./pagination-category.tpl" no_follow=1}
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="sort top_pagi">
                {include file="$tpl_dir./nbr-product-page.tpl"}	
            </div>
        </div>
    </div>
    <div class="sortPagiBar clearfix row" style="margin-top:10px">
        <div class="col-md-6 col-sm-6 col-xs-12">
            {include file="$tpl_dir./product-sort.tpl"}
        </div>
        <div class="product-compare col-md-6 col-sm-6 col-xs-12">
            {include file="$tpl_dir./product-compare.tpl"}
        </div>

    </div>
</div>
{include file="$tpl_dir./product-list.tpl" products=$products}

<div class="content_sortPagiBar" {if !($nb_products > $products_per_page && $start!=$stop)}style="display:none" {/if}>
    <div class="bottom-pagination-content clearfix row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            {include file="$tpl_dir./pagination.tpl" no_follow=1 paginationId='bottom'}
        </div>
        <div class="product-compare col-md-2 col-sm-4 col-xs-6">
            {include file="$tpl_dir./product-compare.tpl" paginationId='bottom'}
        </div>
    </div>
</div>
