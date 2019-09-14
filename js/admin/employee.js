/**
 * 
 */

$(function(){
	if( (typeof id_employee != 'undefined') || (typeof employeeAreaControllerUrl != 'undefined')){
		EmployeeCountriesManager.init();
	}
});

var EmployeeCountriesManager = {
	employeeCountry : null,
	init: function(){
		
		EmployeeCountriesManager.list();
		$('#employeeCountryFormContainer').on('click', '#employeeCountrySubmit', function(){
			EmployeeCountriesManager.save();
		});
		$('#employeeCountriesList').on('click', 'button.employee-country-remove', function(){
			if( !confirm('Confirm deleting?') ){
				return;
			}
			EmployeeCountriesManager.remove($(this).data('id'));
		});
		$('#employeeCountriesList').on('click', 'button.employee-country-edit', function(){
			EmployeeCountriesManager.edit($(this).data('id'));
		});
		$('#employeeCountriesPanel').on('click', '#employeeCountryNew', function(){
			EmployeeCountriesManager.add();
		});

	},
	list : function(){
		$('#employeeCountryForm').find('select,textarea').val('');
		$('#employeeCountryFormContainer').fadeOut(100);
		

		$('#employeeCountriesList').html('Loading...');
		var params = {id_employee:id_employee};
		$.ajax({
			url: employeeAreaControllerUrl + '&ajax=1&action=list',
			method: 'GET',
			dataType: 'json',
			data: params,
			success: function(response){
				if(!response.success){
					alert(response.message);
				}
				$('#employeeCountriesList').html(response.html);
			}
		});

	},
	save : function(){
		var params = $('#employeeCountryForm').serializeArray();
		params.push({'name':'id_employee', 'value':id_employee});
		$.ajax({
			url: employeeAreaControllerUrl + '&ajax=1&action=edit',
			method: 'POST',
			dataType: 'json',
			data: params,
			success: function(response){
				if(!response.success){
					alert(response.message);
					$('#employeeCountryFormContainer').html( response.html );
				}
				else{
					$('#employeeCountryFormContainer').fadeOut(100);
					$('#employeeCountryFormContainer').html( response.html );
					EmployeeCountriesManager.list();
				}
			}
		});

	},
	edit : function(id){
		var params = {'id':id};
		$.ajax({
			url: employeeAreaControllerUrl + '&ajax=1&action=edit',
			method: 'GET',
			dataType: 'json',
			data: params,
			success: function(response){
				if(!response.success){
					alert(response.message);
				}
				$('#employeeCountryFormContainer').fadeIn(100);
				EmployeeCountriesManager.agentCountry = response.data;
				$('#employeeCountryFormContainer').html( response.html ).promise().done(function(){
					$('#employeeCountryFormContainer textarea').val(EmployeeCountriesManager.agentCountry.postcodes.replace(/\\n/g, "\n"));
				});
				/*setTimeout(function(){
					$('#agentsalesCountryFormContainer textarea').val(response.data.postcodes);
				}, 1000);*/
			}
		});
	},
	add: function(){
		$('#employeeCountryFormContainer').fadeIn(100);
		$('#employeeCountryForm').find('input,select,textarea').val('');
	},
	remove : function(id){
		var params = {'id':id};
		$.ajax({
			url: employeeAreaControllerUrl + '&ajax=1&action=delete',
			method: 'POST',
			dataType: 'json',
			data: params,
			success: function(response){
				if(!response.success){
					alert(response.message);
				}
				EmployeeCountriesManager.list();
			}
		});
		
	}
};