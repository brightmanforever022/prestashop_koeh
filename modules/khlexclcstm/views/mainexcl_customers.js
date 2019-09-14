/**
 * 
 */
$(function(){
	MainExlcCustomers.excludedList();
	$('#customer_search').typeWatch({
		captureLength: 2,
		highlight: true,
		wait: 100,
		callback: function(){
			MainExlcCustomers.customerSearch(); 
		}
	});
	$('#customer_search_results').on('click', '.setup-customer', function(e){
		var customerId = $(this).data('customer');
		MainExlcCustomers.excludedAdd(customerId);
	});
	$('#excluded_customers_list').on('click', '.excluded-customer-remove', function(e){
		if( !confirm('Confirm removing this customer?') ){
			return;
		}
		var mainToExclId = $(this).data('id_main_to_excl');
		MainExlcCustomers.excludedRemove(mainToExclId);
	});

});

var MainExlcCustomers = {
	customerSearch : function(){
		$('#customer_search_results').html('<div class="alert alert-info">Searching</div>');
		$.ajax({
			type:"POST",
			url : currentIndex+'&token='+token,
			async: true,
			dataType: "json",
			data : {
				ajax: "1",
				tab: "AdminCustomers",
				action: "searchCustomers",
				customer_search: $('#customer_search').val()},
			success : function(res)
			{
				if(res.found)
				{
					var html = '';
					$.each(res.customers, function() {
						html += '<div class="customerCard col-lg-6">';
						html += '<div class="panel">';
						html += '<div class="panel-heading">'+this.firstname+' '+this.lastname;
						html += '<span class="pull-right">#'+this.id_customer+'</span></div>';
						html += '<div class="">';
						html += '<span>'+this.company+'</span><br/>';
						html += '<span>'+this.email+'</span><br/>';
						//html += '<span class="text-muted">'+((this.birthday != '0000-00-00') ? this.birthday : '')+'</span><br/>';
						//html += '<div class="panel-footer">';
						html += '<button type="button" data-customer="'+this.id_customer+'" class="setup-customer btn btn-default pull-right"><i class="icon-arrow-right"></i> Choose</button>';
						html += '<br/></div>';
						html += '</div>';
						html += '</div>';
					});
				}
				else
					html = '<div class="alert alert-warning"><i class="icon-warning-sign"></i>&nbsp;No customers found</div>';
				$('#customer_search_results').html(html);
			}
		});

	},
	excludedAdd : function(customerExcludedId){
		$.ajax({
			type:"POST",
			url : mainexclCustomersControllerUrl,
			async: true,
			dataType: "json",
			data : {
				ajax: "1",
				action: "add",
				id_main : id_customer,
				id_excluded : customerExcludedId
			},
			success : function(response)
			{
				if( !response.success ){
					alert(response.message);
					return;
				}

				MainExlcCustomers.excludedList();
			}
		});
		
	},
	excludedList: function(){
		$('#excluded_customers_list').html('Loading...');
		$.ajax({
			type:"POST",
			url : mainexclCustomersControllerUrl,
			async: true,
			dataType: "json",
			data : {
				ajax: "1",
				action: "list",
				id_main : id_customer
			},
			success : function(response)
			{
				if( !response.success ){
					alert(response.message);
					return;
				}

				$('#excluded_customers_list').html(response.data);
			}
		});
	},
	excludedRemove: function(mainToExclId){
		$.ajax({
			type:"POST",
			url : mainexclCustomersControllerUrl,
			async: true,
			dataType: "json",
			data : {
				ajax: "1",
				action: "remove",
				id_main_to_excl : mainToExclId,
			},
			success : function(response)
			{
				if( !response.success ){
					alert(response.message);
					return;
				}

				MainExlcCustomers.excludedList();
			}
		});

	}
};