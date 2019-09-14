
<div class="col-lg-3">
	<div id="agentsalesAgentCustomersSearchPanel" class="panel">
		<div class="panel-heading">
			<i class="fa fa-search"></i> {l s='Search customers' mod='agentsales'}</div>
		<div class="form-inline">
			<div class="form-group">
				<label for="agentsales_search">{l s='Type keyword' mod='agentsales'}:</label>
				<br>
				<input type="text" id="agentsales_keyword" class="form-control">
				<button type="button" id="agentsales_search" class="form-control"
					>{l s='Search'}</button>
			</div>
			<hr>
			<div id="agentsales_search_results">
			</div>
		</div>
	</div>

</div>
<div class="col-lg-9">
	<div id="agentsalesAgentCustomersLinkedPanel" class="panel">
		<div class="panel-heading">
			<i class="fa fa-search"></i> {l s='Linked customers' mod='agentsales'}
		</div>
		<div class="panel-body">
			<ul class="list-group" id="agentsalesAgentCustomersLinked">
			</ul>				
		</div>
	</div>
</div>

<script type="text/javascript">
var asAgentId = {$id_agent};
var agentsalesAgentsControllerUrl = "{$agentsalesAgentsControllerUrl}";
var asTransAdd = "{$trnsl_Add}";
var asTransRemove = "{$trnsl_Remove}";
var asTransNoResult = "{$trnsl_No_Results}";

var asCustomersRelated = {$customers_json};
$(function(){
	$('#agentsalesAgentCustomersSearchPanel').on('click', '#agentsales_search', function(){
		$('#agentsales_search_results').empty().append('<span class="loading">Loading...</span>');
		//$('#agentsales_search_results').empty().append(
		//	'<button class="btn btn-primary-reverse onclick btn-lg unbind"></button>');
		params = { 'q': $('#agentsales_keyword').val() };
		$.ajax({
			url: agentsalesAgentsControllerUrl + '&action=search_customers',
			method: 'GET',
			dataType: 'json',
			data: params,
			cache: false
		})
		.done(function(response, textStatus, jqXHR){
			if(textStatus != 'success'){
				alert('Request error:' + textStatus);
			}
			$('#agentsales_search_results').empty();
			//console.log(response.customers.length);
			if(response.found){
				$('#agentsales_search_results').append('<ul class="list-group"></ul>');
				for(var i in response.customers){
					$('#agentsales_search_results ul').append(
						'<li class="list-group-item">' 
						+ '<button name="link" class="btn btn-success btn-sm pull-right agentsalesLinkToAgent" data-id="'+response.customers[i].id_customer+'" type="button">'
						+ asTransAdd +'</button>'
						+ '<span>'
							+ response.customers[i].lastname +' '
							+ response.customers[i].firstname +', '
							+ response.customers[i].email 
							+ (response.customers[i].company ? ', ' +response.customers[i].company : '') 
						+'</span>'
						+ '</li>'
					);
				}
			}
			else{
				$('#agentsales_search_results').append(
					'<p class="alert alert-warning">'+ asTransNoResult +'</p>');
			}
		})
		.fail(function(jqXHR, textStatus, errorThrown){
			alert('Request error:' + errorThrown);
		});
	});
	
	$('#agentsales_search_results').on('click', 'button.agentsalesLinkToAgent', function(){
		customerId = parseInt($(this).attr('data-id'));
		if( $('#agentsalesAgentCustomersLinked').find('li[data-id="'+customerId+'"]').length ){
			return;
		}
		params = { 'id_customer': $(this).attr('data-id'), 'id_agent':asAgentId, 'link': 1 };
		$.ajax({
			url: agentsalesAgentsControllerUrl + '&action=link_customer_to_agent',
			method: 'POST',
			dataType: 'json',
			data: params,
			cache: false
		})
		.done(function(response, textStatus, jqXHR){
			if(textStatus != 'success'){
				alert('Request error:' + textStatus);
			}
			if(response.success){
				agentsalesCustomerRelatedRender(response.data.customer, true);
			}
			else{
				alert('Request error:' + response.message);
			}
		})
		.fail(function(jqXHR, textStatus, errorThrown){
			alert('Request error:' + errorThrown);
		});

	});
	$('#agentsalesAgentCustomersLinked').on('click', 'button.agentsalesUnlinkFromAgent', function(){
		params = { 'id_customer': $(this).attr('data-id'), 'id_agent':asAgentId, 'link': 0 };
		$.ajax({
			url: agentsalesAgentsControllerUrl + '&action=link_customer_to_agent',
			method: 'POST',
			dataType: 'json',
			data: params,
			cache: false
		})
		.done(function(response, textStatus, jqXHR){
			if(textStatus != 'success'){
				alert('Request error:' + textStatus);
			}
			if(response.success){
				$('#agentsalesAgentCustomersLinked').find('li[data-id="'+response.data.customer.id_customer+'"]').remove();
			}
			else{
				alert('Request error:' + response.message);
			}
		})
		.fail(function(jqXHR, textStatus, errorThrown){
			alert('Request error:' + errorThrown);
		});

	});

	for(var i in asCustomersRelated){
		agentsalesCustomerRelatedRender(asCustomersRelated[i], false);
	}
});

function agentsalesCustomerRelatedRender(customer, highlight){
	var html = '<li class="list-group-item col-md-6" data-id="'+customer.id_customer+'" style="min-height:3em;">' 
		+ '<button class="btn btn-warning btn-sm pull-right agentsalesUnlinkFromAgent" data-id="'+customer.id_customer+'" type="button">'
		+ asTransRemove +'</button>'
		+ '<span>'
			+ customer.lastname +' '
			+ customer.firstname +'<br>'
			+ customer.email +'<br> '
			+ (customer.company ? customer.company : '&nbsp;') 
		+'</span>'
		+ '</li>'
	;
	if(highlight){
		$('#agentsalesAgentCustomersLinked').prepend(html);
	}
	else{
		$('#agentsalesAgentCustomersLinked').append(html);
	}
}

</script>