/**
 * 
 */

//google.charts.load('current', {'packages':['corechart']});
google.charts.load('current', {'packages':['corechart']});
$(function(){
	khlProductListSaleGraph.init();
	
    $('img.prod-thumb').mouseenter(function(){
        var imageBigUrl = $(this).data('srcbig');
        var posRight = $(window).width() / 2 - 550 / 2;
        var posTop = $('html').scrollTop() + 20;
        $('body').append('<div style="top:'+posTop+'px;right:'+posRight+'px;z-index:10;box-shadow:0 0 5px #000;position:absolute;background:#fff;" id="imageBigCont"><img src="'+imageBigUrl+'"></div>');
    })
    .mouseleave(function(){
        $('#imageBigCont').remove();
    });

$('td.clearanceFieldContainer').on('dblclick', '.clearanceField', function () {
        var parentTd = $(this).parent();
        var previousContent = parentTd.html();
        var productId = $(parentTd).siblings('.row-selector').children('input').val();
        
        // add edit clearanace state form
        parentTd.html(clearanceEditFormTpl.replace(/#id#/g, productId));
        
        // set cur clearance state
        $('#clearanceSelector'+productId).val($(this).attr('clearance'));
        $('#clearanceSaveBtn'+productId).click(function (e) {
            e.preventDefault();
            $.post(controllerLink, {id: productId, clearance: $('#clearanceSelector'+productId).val(), ajax: 1, action: 'changeClearanceMode'}, 
            function(result){
                if (result.error)
                {
                    alert(result.error);
                }
                else
                {
                    $(parentTd).siblings('.product_price').html(result.price);
                    showCrearanceField(result.clearance, $(parentTd));
                }
            }, 'json');
        });

        $('#clearanceCancelBtn'+productId).click(function () {
            parentTd.html(previousContent);
        });
});



});


function showCrearanceField(clearance, field)
{
    var show = '<span clearance="'+clearance+'" class="clearanceField list-action-enable ';
    if (clearance == clearanceNo)
    {
        show += 'action-disabled"><i class="icon-remove"></i></span>';
    }
    else
    {
        show += 'action-enabled" title="'+clearanceText+' '+clearance+'"><i class="icon-check"></i> '+clearance+'</span>';
    }
    field.html(show);
}


var khlProductListSaleGraph = {
	graphPopup : null,
	gchart: null,
	reportProductId : null,
	reportProductAttrId : null,
	reportProductSplRef: null,
	init: function(){
		this.graphPopup = $('#salesGraphPopup');
		
		$('#content table.product tbody').find('.khl_total_sales,.dbk_total_sales, table.product_sizes_stock th.sale_stats, table.product_sizes_stock td.sale_stats').css('cursor', 'pointer');
		$('#content table.product tbody')
		.on('mouseover', '.khl_total_sales,.dbk_total_sales, table.product_sizes_stock th.sale_stats, table.product_sizes_stock td.sale_stats', function(){
			$(this).css('background-color', '#b0f0ff');
		})
		.on('mouseleave', '.khl_total_sales,.dbk_total_sales, table.product_sizes_stock th.sale_stats, table.product_sizes_stock td.sale_stats', function(){
			$(this).css('background-color', 'none');
		});
		$('#content table.product tbody').on('click', '.khl_total_sales,.dbk_total_sales', function(ev){
			return khlProductListSaleGraph.handleListMainCellClick(ev);
		});
		$('#content table.product tbody').on('click', 'table.product_sizes_stock th.sale_stats, table.product_sizes_stock td.sale_stats', function(ev){
			return khlProductListSaleGraph.handleListSizeCellClick(ev);
		});
		this.graphPopup.on('shown.bs.modal', function () {
			khlProductListSaleGraph.displayGraph();
		});
		this.graphPopup.on('hidden.bs.modal', function () {
			khlProductListSaleGraph.destroyGraph();
		});
	},
	handleListMainCellClick: function(ev){
		if( !this.findProductIdFromRowCell(ev.currentTarget) ){
			alert('Product ID not found');
			return false;
		}
		this.reportProductSplRef = $(ev.currentTarget).parent('tr').find('td.base_prod_spl_ref').text();
		
		this.displayPopup();
	},
	handleListSizeCellClick: function(ev){
		var mainCell = $(ev.target).parents('table.product_sizes_stock').parent('td');
		
		if(ev.target.tagName == 'TD'){
			var cellIndex = $(ev.target).parent('tr').find('td').index(ev.target);
			if(cellIndex >= 0){
				this.reportProductSplRef = $(ev.target).parent('tr').prev().find('th').eq(cellIndex).data('spl_ref');
			}
		}
		else{
			this.reportProductSplRef = $(ev.target).data('spl_ref');
		}
		
		if( !this.findProductIdFromRowCell(mainCell) ){
			alert('Product ID not found');
			return false;
		}

		this.reportProductAttrId = parseInt( $(ev.target).data('attr_id') );
		if( isNaN(this.reportProductAttrId) || (this.reportProductAttrId < 1) ){
			alert('Attribute ID not found');
			return false;
		}
		
		this.displayPopup();
	},
	findProductIdFromRowCell: function(rowCell){
		this.reportProductId = $(rowCell).parent('tr').find('td.row-selector').find('input[type="checkbox"]').val();
		this.reportProductId = parseInt(this.reportProductId);
		
		if( isNaN(this.reportProductId) || (this.reportProductId == 0) ){
			//alert('Product ID not found');
			return false;
		}
		else{
			return true;
		}
	},
	displayPopup : function(ev){
		this.graphPopup.modal('show');
		
	},
	displayGraph: function(){
		var graphData = [];
		var reportProductKey = '';
		if( this.reportProductId == null ){
			return;
		}
		$(this.graphPopup).find('.modal-title').text('Sale stats for "'+ this.reportProductSplRef +'"');
		reportProductKey = this.reportProductId;
		
		if(this.reportProductAttrId != null){
			reportProductKey += ('_'+ this.reportProductAttrId);
		}
		else{
			reportProductKey += '_0';
		}
		
		if( typeof productsSaleStats[reportProductKey] == 'undefined' ){
			return;
		}
		
		graphData.push([
			'Period', 
			'koehlert.com',
			{type: 'string', role: 'annotation'},
			'deinballkleid.de',
			{type: 'string', role: 'annotation'}
		]);
		for(var prodStats in productsSaleStats[reportProductKey] ){
			graphData.push([
				productsSaleStats[reportProductKey][prodStats]['report_date_formatted'], 
				productsSaleStats[reportProductKey][prodStats]['khl_quantity'], 
				productsSaleStats[reportProductKey][prodStats]['khl_quantity'],
				productsSaleStats[reportProductKey][prodStats]['dbk_quantity'],
				productsSaleStats[reportProductKey][prodStats]['dbk_quantity']
			]);
		}
		var khlProductSales12M = 0;
		var dbkProductSales12M = 0;
		for(var s12i = 12; s12i < 24; s12i++ ){
			khlProductSales12M += productsSaleStats[reportProductKey][s12i]['khl_quantity'];
			dbkProductSales12M += productsSaleStats[reportProductKey][s12i]['dbk_quantity'];
		}
		$(this.graphPopup).find('.modal-header').find('p').html(
			'Last 12 month statistics<br>'+
			'Koehlert.com sales: '+ khlProductSales12M +'<br>'+
			'DBK sales: '+ dbkProductSales12M
		);
		
        var data = google.visualization.arrayToDataTable(graphData);

        var options = {
        	chartArea: {width: '95%', height: '75%'},
        	height: 500,
            //title: 'Statistics',
            //curveType: 'function',
            legend: { position: 'bottom' },
            hAxis: { slantedTextAngle: 90 },
            annotations: {
                alwaysOutside: true,
                textStyle: {
                  fontSize: 16,
                  bold: true,
                  color: '#000',
                  auraColor: '#C0C0C0'
                }
            },
        };

        this.gchart = new google.visualization.LineChart(document.getElementById('salesGraphLeft'));
        this.gchart.draw(data, options);

	},
	destroyGraph: function(){
		this.gchart.clearChart();
		this.gchart = null;
		this.reportProductId = null;
		this.reportProductAttrId = null;
		this.reportProductSplRef = null;
	}
};