/**
 * 
 */
var hidePriceCookieName = 'hide_price';
$(document).ready(function(){
	var hidePrices = Cookies.get(hidePriceCookieName);
	if( $('body').hasClass('product') ){
		khlBasicHidePrices(hidePrices);
	}
	if( !$('body').hasClass('category') ){
		return;
	}
	
	var hidePriceControl = $('<input type="checkbox" id="hidePriceControl">');
	if( (typeof hidePrices != 'undefined') && (hidePrices == 'true') ){
		khlBasicHidePrices(true);
		hidePriceControl.prop('checked', 'checked');
	}
	var hidePriceElem = $('<div class="hide-price-block"></div>');
	var hidePriceLabel = $('<label>'+ hidePricesSwitchLabel +'</label>');
	hidePriceElem.append(hidePriceControl);
	hidePriceElem.append(hidePriceLabel);
	$('#left_column').prepend(hidePriceElem);
	$('#hidePriceControl').uniform();

	$('body').on('click', '#hidePriceControl', function(e){
		if($(this).prop('checked')){
			Cookies.set(hidePriceCookieName, true, {expires:30});
			khlBasicHidePrices(true);
		}
		else{
			Cookies.remove(hidePriceCookieName);
			khlBasicHidePrices(false);
		}
		e.stopPropagation();
	});
	$( document ).ajaxSuccess(function( event, xhr, settings ){
		if(settings.url.match(/blocklayered-ajax\.php/)){
			if($('#hidePriceControl').prop('checked')){
				khlBasicHidePrices(true);
			}
			else{
				khlBasicHidePrices(false);
			}
		}
	});
});
function khlBasicHidePrices(flag){
	$('.content_price,.our_price_display').css('visibility', (flag ? 'hidden' : 'visible'));
}