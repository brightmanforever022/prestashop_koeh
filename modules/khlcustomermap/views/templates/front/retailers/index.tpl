{capture name=path}<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">{l s='My account'}</a><span class="navigation-pipe">{$navigationPipe}</span><span class="navigation_page">{l s='My vouchers'}</span>{/capture}
<div id="retailerPage">
<h1 class="page-heading">
  {l s='Find retailer'}
</h1>

<form id="retailerSearchForm">
<div class="row">
  <div class="col-lg-5 col-xs-12">
    <input type="text" name="area" class="form-control input-sm" placeholder="{l s='Postcode or city' mod='khlcustomermap'}">
  </div>
  <div class="col-lg-6 col-xs-12">
    {html_options name=id_country options=$countries_options selected=$user_country_id class='form-control'}
  </div>
  <div class="col-lg-1 col-xs-12 text-right">
    <button type="button" class="btn btn-outline button button-small btn-sm">{l s='Search' mod='khlcustomermap'}</button>
  </div>
</div>
</form>
<hr>

<div class="row retailer-results-wrapper">
  <div class="col-lg-12 hidden-xs" id="retailerResultsList"><ul class="row"></ul></div>
</div>

<div class="row retailer-results-wrapper">
  <div class="col-lg-12">
    <div id="retailerResultsMap"></div>
  </div>
</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key={$google_maps_api_key}&callback=initCustomersMap" async defer></script>
<script type="text/javascript">
function initCustomersMap(){
  RetailerFinder.init({
    controllerUrl:'{$controller_url}',
    mapContainerId:'retailerResultsMap',
    searchFormId:'retailerSearchForm',
    markerImagesDir:'{$markers_dir_url}',
    translations : {
        inputAreaEmpty: '{l s='Please enter postcode or city, minimum is 3 characters' mod='khlcustomermap'}',
        inputCountryEmpty: '{l s='Please select country' mod='khlcustomermap'}'
    }
  });
}
</script>