/**
 * 
 */

$(document).ready(function(){
    $("#customersMapSearchForm select[name='no_order_for_latest']").multipleSelect({
        multiple: true,
        multipleWidth: 200
    });

});

var KoehlertCustomersMap = {
	map: null,
	dataUrl: null,
	markerclusterImagesDir : null,
	markersImagesDir : null,
	//customersList: null,
	markers : [],
	customersGeocodeButton: null,
	customersNoGeodataCountLabel:null,
	customersDisplayedCountLabel: null,
	customers_map_search_form: null,
	init: function(options){
		this.dataUrl = options.data_url;
		this.markersImagesDir = options.markers_images_dir;
		this.markerclusterImagesDir = options.markers_images_dir + 'm';
		this.map = new google.maps.Map(document.getElementById(options.map_container_id), {
	          center: {lat: 0.0, lng: 0.0},
	          zoom: 1
	    });
		
		this.customers_map_search_form = options.customers_map_search_form;
		this.getFilteredCustomersList();
		
		this.customersGeocodeButton = options.customers_geocode_button ;
		this.customersNoGeodataCountLabel = options.customers_no_geodata_label;
		
		this.customersGeocodeButton.on('click', KoehlertCustomersMap.onClickCustomersGeocodeButton);
		this.customersDisplayedCountLabel = options.customers_displayed_count_label;
		
		
		this.customers_map_search_form.find('#customersMapSearchFormSubmit,button[type="reset"]').on('click', function(event){
			KoehlertCustomersMap.getFilteredCustomersList();
		});
	},
	onClickCustomersGeocodeButton: function(){
		$.ajax({
			url: KoehlertCustomersMap.dataUrl + '&ajax=1&action=geocode_customers&limit=100',
			method: 'GET',
			dataType: 'json',
			success: function(response){
				if(response.success){
					KoehlertCustomersMap.customersNoGeodataCountLabel.text(response.data.customers_no_geodata_count);
					KoehlertCustomersMap.getCustomers();
				}
				else{
					alert(response.message);
				}
			}
		});
		
	},
	getCustomers: function(postParams){
		$.ajax({
			url: this.dataUrl + '&ajax=1&action=get_customers',
			method: 'POST',
			dataType: 'json',
			data: postParams,
			success: function(response){
				if(response.success){
					KoehlertCustomersMap.displayCustomers(response.data);
				}
			}
		});
	},
	displayCustomers: function(customers){
		if( this.markers.length ){
			while(this.markers.length){
				let marker = this.markers.pop();
				marker.setMap(null);
				delete marker;
			}
		}
		
		this.markers = customers.map(function(customer, i) {
			var infoWindowContent = '<h4>'+ 
				(customer.company != null ? customer.company : '('+ customer.firstname+' '+customer.lastname +')') +
				' ['+customer.id_customer+']' +'</h4>';
			if( customer.order_recent_date_formatted != null ){
				infoWindowContent += '<p>Last order: '+ customer.order_recent_date_formatted +'</p>';
			}
			if( customer.orders_total_formatted != null ){
				infoWindowContent += '<p>Orders total<br>';
				infoWindowContent += '<span>All time: '+ customer.orders_total_formatted +'</span><br>';

				if( customer.orders_total_12_formatted != null ){
					infoWindowContent += '<span>12 month: '+ customer.orders_total_12_formatted +'</span><br>';
				}
				if( customer.orders_total_6_formatted != null ){
					infoWindowContent += '<span>6 month: '+ customer.orders_total_6_formatted +'</span>';
				}

				infoWindowContent += '</p>';
			}

			var infowindow = new google.maps.InfoWindow({
				content: infoWindowContent
			});
			
			var iconUrl = KoehlertCustomersMap.markersImagesDir + 'red.png';
			if( customer.active && customer.customer_group_key_account){
				iconUrl = KoehlertCustomersMap.markersImagesDir + 'orange.png';
			}
			else if( customer.active && !customer.customer_group_key_account){
				iconUrl = KoehlertCustomersMap.markersImagesDir + 'green.png';
			}
			else if( !customer.active ){
				iconUrl = KoehlertCustomersMap.markersImagesDir + 'red.png';
			}

			var marker = new google.maps.Marker({
	            position: {lat: customer.latitude, lng: customer.longitude},
	            icon: iconUrl
	            //label: labels[i % labels.length]
			});
			
			marker.addListener('click', function(){
				infowindow.open(KoehlertCustomersMap.map, marker);
			});
			
			return marker;
		});
		this.markers.forEach(function(item, index, array) {
			item.setMap(KoehlertCustomersMap.map);
		});
		
		this.customersDisplayedCountLabel.text( this.markers.length );
		
		//var markerCluster = new MarkerClusterer(this.map, this.markers, {imagePath:this.markerclusterImagesDir});
	},
	getFilteredCustomersList: function(){
		var searchParams = {};
		var searchForm = this.customers_map_search_form.find('input,select,textarea').each(function(ind, elem){
			var elemName = $(this).attr('name');
			if( typeof elemName == 'undefined' ){
				return;
			}
			var elemVal = null;

			if( ($(this).prop('tagName') == 'SELECT') && ($(this).attr('multiple') == 'multiple') ){
				elemVal = $(this).multipleSelect('getSelects');
				if( Array.isArray(elemVal) && elemVal.length ){
					searchParams[elemName] = elemVal;
				}
			}
			else{
				elemVal = $(this).val();
			}
			
			if( typeof elemVal == 'string' ){
				elemVal = elemVal.trim();
				
				if( elemVal.length ){
					searchParams[elemName] = elemVal;
				}
			}
		});

		this.getCustomers(searchParams);

	}
};