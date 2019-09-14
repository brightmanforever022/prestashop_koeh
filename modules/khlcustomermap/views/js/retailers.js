/**
 * 
 */
var RetailerFinder = {
	config: {},
	map: null,
	markers: [],
	init: function(config){
		this.config = config;
		this.map = new google.maps.Map(document.getElementById(this.config.mapContainerId), {
			center: { lat: 0.0, lng: 0.0 },
			zoom: 2,
			streetViewControl: false,
			mapTypeControl: false
		});
		$('#'+this.config.searchFormId).on('click', 'button', function(){
			var formData = $('#'+RetailerFinder.config.searchFormId).serializeArray();
			
			var formHasErrors = false;
			var errorMessage = '';
			for( let i in formData ){
				if( (formData[i].name == 'area') && (formData[i].value == '' || formData[i].value.length < 3) ){
					formHasErrors = true;
					errorMessage += RetailerFinder.config.translations.inputAreaEmpty +"\n";
				}
				if( (formData[i].name == 'id_country') && (formData[i].value == '0') ){
					formHasErrors = true;
					errorMessage += RetailerFinder.config.translations.inputCountryEmpty +"\n";
				}
			}
			
			if( formHasErrors ){
				alert(errorMessage);
				return false;
			}
			
			RetailerFinder.search(formData);
		});
	},
	search : function(searchParams){
		$('#retailerResultsList').hide();
		$('#retailerResultsList ul').empty();
		$.ajax({
			url: this.config.controllerUrl + '?action=search&ajax=1',
			method: 'GET',
			dataType: 'json',
			data: searchParams,
			success: function(response){
				if(response.success){
					RetailerFinder.display(response.data);
				}
				else{
					alert(response.message);
				}
			},
			error: function( jqXHR, textStatus, errorThrown){
				alert('Error: '+ textStatus +' : '+ errorThrown);
			}
		});
	},
	display: function(retailers){
		if( this.markers.length ){
			while(this.markers.length){
				let marker = this.markers.pop();
				marker.setMap(null);
				delete marker;
			}
		}
		
		if( !retailers.length ){
			this.map.setCenter( { lat: 0.0, lng: 0.0 } );
			this.map.setZoom( 2 );
			return;
		}
		$('#retailerResultsList').show(500);
		this.markers = retailers.map(function(retailer, i) {
			$('#retailerResultsList ul').append('<li class="col-lg-6">'+
					'<h4>'+ retailer.company +'</h4>'
					+ '<p>'
					+ retailer.address1
					+ ( (typeof retailer.address2 == 'String') && retailer.address2.length ? ', '+retailer.address2 : '' )
					+ ', '+ retailer.postcode
					+ ', '+ retailer.city
					+ '</p>'
				+'</li>'
			);
			
			var infoWindowContent = '<h4>'+ retailer.company +'</h4>';
			infoWindowContent += retailer.address1
				+ ( (typeof retailer.address2 == 'String') && retailer.address2.length ? '<br>'+retailer.address2 : '' )
				+ '<br>'+ retailer.postcode
				+ '<br>'+ retailer.city
			;

			var infowindow = new google.maps.InfoWindow({
				content: infoWindowContent
			});
			
			var iconUrl = RetailerFinder.config.markerImagesDir + 'green.png';

			var marker = new google.maps.Marker({
	            position: {lat: retailer.latitude, lng: retailer.longitude},
	            icon: iconUrl
	            //label: labels[i % labels.length]
			});
			
			marker.addListener('click', function(){
				infowindow.open(RetailerFinder.map, marker);
			});
			
			return marker;
		});
		this.markers.forEach(function(item, index, array) {
			item.setMap(RetailerFinder.map);
		});
		
		this.map.setCenter( this.markers[0].getPosition() );
		this.map.setZoom( 10 );
	}
};