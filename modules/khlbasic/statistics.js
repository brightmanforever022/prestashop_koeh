/**
 * 
 */

$(function(){
	$('#khlSaleStatsTable').on('click', '#khlSaleStatsPrev', function(){
		khlSaleStats.getPrevious();
	});
	$('#khlSaleStatsTable').on('click', '#khlSaleStatsExport', function(){
		khlSaleStats.getExport();
	});

    $('select[name="country_id[]"]').multipleSelect({
        multiple: true
        
    });
    $('select[name="agent_id[]"]').multipleSelect({
        multiple: true
        
    });
    $('#khlSaleStatsTable').on('click', '#khlSaleStatsFilter', function(){
    	khlSaleStats.filterData();
    });
});

var khlSaleStats = {
	mode : '',
	self: this,
	remoteRequestAction : '',
	dailyOptions : {
		year : null,
		month : null
	},
	monthlyOptions : {
		year : null
	},
	weeklyOptions : {
		year : null
	},

	init: function(mode){
		khlSaleStats.mode = mode;
		if( mode == 'daily' ){
			khlSaleStats.dailyInit();
		}
		else if( mode == 'weekly' ){
			khlSaleStats.weeklyInit();
		}
		else if( mode == 'monthly' ){
			khlSaleStats.monthlyInit();
		}
	},
	getExport : function(){
		let params = {
			mode : khlSaleStats.mode
		};
		let today = new Date();
		if( khlSaleStats.mode == 'daily' ){
			params.date_from = khlSaleStats.dailyOptions.year +'-'+khlSaleStats.dailyOptions.month;
			params.date_to =  today.getFullYear() +'-'+today.getMonth() + 1;
		}
		else if( khlSaleStats.mode == 'weekly' ){
			params.date_from = khlSaleStats.weeklyOptions.year;
			params.date_to =  today.getFullYear();
		}
		else if( khlSaleStats.mode == 'monthly' ){
			params.date_from = khlSaleStats.monthlyOptions.year;
			params.date_to =  today.getFullYear();
		}
		
		params = khlSaleStats.setRequestFilterParams(params);

		let url = currentIndex + '&action=export_to_excel&token='+token +'&'+ $.param(params);
		
		window.open(url);
		//if()
	},
	filterData : function(){
		$('#khlSaleStatsTable tbody').empty();
		if( khlSaleStats.mode == 'daily' ){
			khlSaleStats.dailyInit();
		}
		else if( khlSaleStats.mode == 'weekly' ){
			khlSaleStats.weeklyInit();
		}
		else if( khlSaleStats.mode == 'monthly' ){
			khlSaleStats.monthlyInit();
		}
	},
	dailyInit : function(){
		khlSaleStats.remoteRequestAction = 'get_daily';
		let today = new Date();
		khlSaleStats.dailyOptions.year = today.getFullYear();
		khlSaleStats.dailyOptions.month = today.getMonth() + 1;
		
		khlSaleStats.getPreviousDaily(null, khlSaleStats.dailyOptions.year +'-'+ khlSaleStats.dailyOptions.month );
	},
	dailyGetPreviousDate : function(){
		if( khlSaleStats.dailyOptions.month == 1 ){
			khlSaleStats.dailyOptions.year -= 1;
			khlSaleStats.dailyOptions.month = 12;
		}
		else{
			khlSaleStats.dailyOptions.month -= 1;
		}
		return khlSaleStats.dailyOptions.year +'-'+ khlSaleStats.dailyOptions.month;
	},
	getPreviousDaily: function(params = null, dateYearMonth = null){
		if(params == null){
			var params = {action: khlSaleStats.remoteRequestAction};
		}
		if( dateYearMonth == null ){
			params.date_year_month = khlSaleStats.dailyGetPreviousDate();
		}
		else{
			params.date_year_month = dateYearMonth;
		}
		
		params = khlSaleStats.setRequestFilterParams(params);
		khlSaleStats.requestData(params);
	},

	weeklyInit : function(){
		khlSaleStats.remoteRequestAction = 'get_weekly';
		let today = new Date();
		khlSaleStats.weeklyOptions.year = today.getFullYear();
		khlSaleStats.getPreviousWeekly(null, khlSaleStats.weeklyOptions.year);
	},
	weeklyGetPreviousDate : function(){
		return --khlSaleStats.weeklyOptions.year;
	},
	getPreviousWeekly: function(params = null, dateYear = null){
		if(params == null){
			var params = {action: khlSaleStats.remoteRequestAction};
		}
		if( dateYear == null ){
			params.date_year = khlSaleStats.weeklyGetPreviousDate();
		}
		else{
			params.date_year = dateYear;
		}
		
		params = khlSaleStats.setRequestFilterParams(params);
		khlSaleStats.requestData(params);
	},
	monthlyInit : function(){
		khlSaleStats.remoteRequestAction = 'get_monthly';
		let today = new Date();
		khlSaleStats.monthlyOptions.year = today.getFullYear();
		khlSaleStats.getPreviousMonhtly(null, khlSaleStats.monthlyOptions.year);
	},
	monthlyGetPreviousDate : function(){
		return --khlSaleStats.monthlyOptions.year;
	},
	getPreviousMonhtly: function(params = null, dateYear = null){
		if(params == null){
			var params = {action: khlSaleStats.remoteRequestAction};
		}
		if( dateYear == null ){
			params.date_year = khlSaleStats.monthlyGetPreviousDate();
		}
		else{
			params.date_year = dateYear;
		}
		
		params = khlSaleStats.setRequestFilterParams(params);
		khlSaleStats.requestData(params);
	},
	getPrevious : function(){
		let params = {
			action: khlSaleStats.remoteRequestAction
		};
		
		if( khlSaleStats.mode == 'daily' ){
			khlSaleStats.getPreviousDaily(params);
		}
		else if( khlSaleStats.mode == 'monthly' ){
			khlSaleStats.getPreviousMonhtly(params);
		}
		else if( khlSaleStats.mode == 'weekly' ){
			khlSaleStats.getPreviousWeekly(params);
		}

	},
	setRequestFilterParams : function(params){
		params.customer_name = $('#customer_name').val();
		params.company_name = $('#company_name').val();
		
		params.country_id = $('#country_id').val();
		params.agent_id = $('#agent_id').val();
		
		return params;
	},
	requestData : function(params){
		$('#khlSaleStatsTable tbody').append('<tr id="khlSaleStatsLoading"><td colspan="10">Loading ...</td></tr>');
		$.ajax({
			url: currentIndex + '&ajax=1&token='+token,
			method: 'GET',
			dataType: 'json',
			data: params
		})
		.done(function(response){
			$('#khlSaleStatsTable tbody tr#khlSaleStatsLoading').remove();
			$('#khlSaleStatsTable tbody').append(response.stats_html);
			//khlSaleStats.previousDates.date_from = response.prev_date_from;
			//khlSaleStats.previousDates.date_to = response.prev_date_to;
		});
	}
};