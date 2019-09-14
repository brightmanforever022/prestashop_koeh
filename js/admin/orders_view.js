/**
 * Scripts for employees with 'view' access
 */
$(document).ready(function(){
    /**
     * Popup with stock, expected delivery, quantity from other orders
     */
    orderProductStockDetailsPopup.init();
    $('#orderProducts').on('mouseover', '.product_stock', function(e){
    	orderProductStockDetailsPopup.show(e.target);
	});
	$('#orderProducts').on('mouseout', '.product_stock', function(){
		orderProductStockDetailsPopup.hide(false);
	});
    $('#orderProducts').on('click', '.product_stock', function(e){
    	orderProductStockDetailsPopup.stick();
	});
	$('body').on('dblclick', '#orderProductStockPanel', function(){
		orderProductStockDetailsPopup.hide(true);
	});

});

var orderProductStockDetailsPopup = {
	init : function(){
		var baseUrl = 'ajax_product_comb_qnt.php?id_order='+id_order;
		$('#orderProducts tbody tr.product-line-row').each(function(){
			let sku = $(this).attr('data-prod_spl_ref');
			let url = baseUrl + '&q='+encodeURIComponent(sku);
			$.get(url, function(response){
				orderProductStockDetailsPopup.productsStocks.push({
					sku : sku,
					html : response
				});
			});
		});
	},
	productsStocks : [],
	popupPanel : null,
	show : function(target){
		if( this.popupPanel != null ){
			return;
		}
		var sku = $(target).attr('data-id');
		var containerWidth = $('#content>.row').width();
		var eventTargetOffset = $(target).offset();
		var eventTargetHeight = $(target).height();
		this.popupPanel = $('<div id="orderProductStockPanel" style="min-height:300px;border:1px solid gray;background:white;position:absolute;overflow-x:auto;"></div>');
		this.popupPanel.css({width:(containerWidth-10)+'px',top:(eventTargetOffset.top+eventTargetHeight)+'px'});
		for( let i = 0; i < orderProductStockDetailsPopup.productsStocks.length; i++ ){
			if( orderProductStockDetailsPopup.productsStocks[i].sku == sku ){
				this.popupPanel.html(orderProductStockDetailsPopup.productsStocks[i].html);
				break;
			}
		}
		$('#content').append(this.popupPanel);
	},
	stick : function(){
		this.popupPanel.addClass('orderProductStockPanelSticked');
	},
	hide : function(force = false){
		if(force || (!force && !$('#orderProductStockPanel').hasClass('orderProductStockPanelSticked'))){
			$('#orderProductStockPanel').remove();
			this.popupPanel = null;
		}
	}
};
