

  <div class="panel">
    <form class="form-inline" id="customersMapSearchForm">
      <div class="form-group">
        {html_options name=status options=$search_form_element_options['status'] class='form-control'}
      </div>
      <div class="form-group">
        {html_options name=no_order_for_latest options=$search_form_element_options['not_order_for_latest'] multiple=multiple}
      </div>
      <div class="form-group">
        <input name="postcode_start" class="form-control" placeholder="{l s='Postcode starts' mod='khlcustomermap'}">
      </div>
      <div class="form-group">
        {html_options name=id_country options=$search_form_element_options['id_country']}
      </div>
      
      <button type="button" class="btn btn-primary" id="customersMapSearchFormSubmit">{l s='Search' mod='khlcustomermap'}</button>
      <button type="reset" class="btn btn-default">{l s='Reset' mod='khlcustomermap'}</button>
    </form>
    <hr>
    <div class="row">
      <div class="col-lg-6">
        <p>Displayed customers: <span id="customersDisplayedCountLabel"></span></p>
      </div>
      <div class="col-lg-6 text-right">
        <p>
        Customers without geo data <span id="customersNoGeodataCountLabel">{$customers_no_geodata_count}</span>
        <button class="btn btn-default btn-xs" type="button" id="customersGeocodeButton">Get geodata</button>
        </p>
      </div>
    </div>

    
  </div>


<div id="customers_map" style="height:600px;"></div>

<div class="row">
  <div class="panel">
    <p>
      Customers with invalid geodata: {$customers_invalid_geodata_list|count}
      <br>
      IDs: 
      {foreach $customers_invalid_geodata_list as $customer_invalid_geodata}
      <a href="{$link->getAdminLink('AdminCustomers')}&id_customer={$customer_invalid_geodata.id_customer}&updatecustomer">{$customer_invalid_geodata.id_customer}</a>,
      {/foreach}
    </p>
  </div>
</div>

<script src="{$markercluster_js_url}"></script>

<script src="https://maps.googleapis.com/maps/api/js?key={$google_maps_api_key}&callback=initCustomersMap" async defer></script>

<script type="text/javascript">
function initCustomersMap(){
	KoehlertCustomersMap.init({
		map_container_id:'customers_map',
		data_url: '{$customers_map_controller_url}',
		markers_images_dir: '{$markers_dir_url}',
		customers_no_geodata_label: $('#customersNoGeodataCountLabel'),
		customers_geocode_button: $('#customersGeocodeButton'),
		customers_displayed_count_label: $('#customersDisplayedCountLabel'),
		customers_map_search_form: $('#customersMapSearchForm')
	});
}

</script>