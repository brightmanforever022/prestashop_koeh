/**
* 2017 Nsweb
*
*/
$(function(){
	$('#form-agentsales_invoice').on('dblclick', 'td.commision_value', function(e){
		//e.preventDefault();
		var tableCell = $(this);
		var agentsalesOrderId = parseInt( tableCell.parents('tr').find('input[type="checkbox"]').val() );
		var oldValue = tableCell.html().replace(',', '.').trim();
		console.log(oldValue);
		var updateUrl = currentIndex + '&action=commision_update&ajax=1&'+
			'agentsales_invoice_id='+ agentsalesOrderId +'&token='+token;
		var input = $('<input>').attr('type','text').attr('name','commision_value')
			.attr('size','6').val(oldValue);
		tableCell.html(input);
		input.focus()
		.keypress(function(e){
			if(e.which == 13){
				this.blur();
				return false;
			}
		})
		.blur(function(){
			var newValue = $(this).val();
			if(oldValue == newValue){
				tableCell.html(oldValue);
				return;
			}
			//console.log(newValue);
			params = {commision_value:newValue};
			$.ajax({
				url: updateUrl,
				method: 'POST',
				dataType: 'json',
				data: params,
				success: function(response){
					location.reload();
				}
			});
		});
		return false;
	});
	$('table.agentsales_invoice thead').find('tr.filter').find('th:first').html(
		$('<input/>').attr({type:'checkbox'}).click(function(){
			if($(this).prop('checked')){
				checkDelBoxes($('#form-agentsales_invoice').get(0), 'agentsales_invoiceBox[]', true);
			}
			else{
				checkDelBoxes($('#form-agentsales_invoice').get(0), 'agentsales_invoiceBox[]', false);
			}
		})
	);
	
	AgentCountriesManager.init();
});

var AgentCountriesManager = {
	agentCountry : null,
	init: function(){
		if( (typeof id_customer == 'undefined') || (typeof agentsalesCountriesControllerUrl == 'undefined')){
			return;
		}
		
		AgentCountriesManager.list();
		$('#agentsalesCountryFormContainer').on('click', '#agentsalesCountrySubmit', function(){
			AgentCountriesManager.save();
		});
		$('#agentsalesCountriesList').on('click', 'button.agent-country-remove', function(){
			if( !confirm('Confirm deleting?') ){
				return;
			}
			AgentCountriesManager.remove($(this).data('id'));
		});
		$('#agentsalesCountriesList').on('click', 'button.agent-country-edit', function(){
			AgentCountriesManager.edit($(this).data('id'));
		});
		$('#agentsalesCountriesPanel').on('click', '#agentsalesCountryNew', function(){
			AgentCountriesManager.add();
		});

	},
	list : function(){
		$('#agentsalesCountriesList').html('Loading...');
		var params = {id_agent:id_customer};
		$.ajax({
			url: agentsalesCountriesControllerUrl + '&ajax=1&action=list',
			method: 'GET',
			dataType: 'json',
			data: params,
			success: function(response){
				if(!response.success){
					alert(response.message);
				}
				$('#agentsalesCountriesList').html(response.html);
			}
		});

	},
	save : function(){
		var params = $('#agentsalesCountryForm').serializeArray();
		params.push({'name':'id_agent', 'value':id_customer});
		$.ajax({
			url: agentsalesCountriesControllerUrl + '&ajax=1&action=edit',
			method: 'POST',
			dataType: 'json',
			data: params,
			success: function(response){
				if(!response.success){
					alert(response.message);
					$('#agentsalesCountryFormContainer').html( response.html );
				}
				else{
					$('#agentsalesCountryFormContainer').fadeOut(100);
					$('#agentsalesCountryFormContainer').html( response.html );
					AgentCountriesManager.list();
				}
			}
		});

	},
	edit : function(id){
		var params = {'id':id};
		$.ajax({
			url: agentsalesCountriesControllerUrl + '&ajax=1&action=edit',
			method: 'GET',
			dataType: 'json',
			data: params,
			success: function(response){
				if(!response.success){
					alert(response.message);
				}
				$('#agentsalesCountryFormContainer').fadeIn(100);
				AgentCountriesManager.agentCountry = response.data;
				$('#agentsalesCountryFormContainer').html( response.html ).promise().done(function(){
					$('#agentsalesCountryFormContainer textarea').val(AgentCountriesManager.agentCountry.postcodes.replace(/\\n/g, "\n"));
				});
				/*setTimeout(function(){
					$('#agentsalesCountryFormContainer textarea').val(response.data.postcodes);
				}, 1000);*/
			}
		});
	},
	add: function(){
		$('#agentsalesCountryFormContainer').fadeIn(100);
		$('#agentsalesCountryForm').find('select,textarea').val('');
	},
	remove : function(id){
		var params = {'id':id};
		$.ajax({
			url: agentsalesCountriesControllerUrl + '&ajax=1&action=delete',
			method: 'POST',
			dataType: 'json',
			data: params,
			success: function(response){
				if(!response.success){
					alert(response.message);
				}
				AgentCountriesManager.list();
			}
		});
		
	}
};