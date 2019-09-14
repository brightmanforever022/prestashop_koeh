/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

var current_product = null;
var ajaxQueries = new Array();

$(document).ready(function() {
	// Init all events
	init();

	$('img.js-disabled-action').css({"opacity":0.5});
        
    // switched invoice and delivery templates selctors (shows and hides them) 
    $('#addInvoiceTypeSelector').change(function (){
        if($(this).val() == 1)
        {
            $('#addInvoiceInvoiceTemplateSel').show();
            $('#addInvoiceDeliveryTemplateSel').hide();
        }
        else
        {
            $('#addInvoiceInvoiceTemplateSel').hide();
            $('#addInvoiceDeliveryTemplateSel').show();
        }
    });
        
    $('#addInoiceForm').on('click', '#submitAddInvoice', function(){
    	if( showReadMessagesConfirmation && !confirm(readMessagesConfirmation) ){
    		return false;
    	}
    	
    	var templateType = $('#addInvoiceTypeSelector').val();
    	if( templateType != '1' ){
    		return submitInvoiceAdd();
    	}
    	
    	var invoiceTemplateRequireVat = parseInt( $('#addInvoiceInvoiceTemplateSel option:selected').data('require_vat') );
    	if( invoiceTemplateRequireVat && !customer_vat_confirmed ){
    		alert(txt_invoice_require_vat_customer_unconfirmed);
    		return;
    	}
    	
    	var postParams = {
    		invoice_template_id : $('#addInvoiceInvoiceTemplateSel').val(),
    		template_type : $('#addInvoiceTypeSelector').val(),
    		shipped_products_only : $('#addInvoiceShippedProductsOnly').val()
    	};
    	var orderPackageId = $('#addInvoiceOrderPackageId').val();
    	orderPackageId = parseInt(orderPackageId);
    	// if user selected package list, it will be used to prepare invoice
    	if( orderPackageId > 0 ){
    		postParams.id_order_package = orderPackageId;
    	}
    	else{
            var productDetailIds = [];
            $('.productIdCheckBox:checked').each(function (index, value){
                productDetailIds.push($(value).val());
            });
            if (productDetailIds.length==0){
                alert(aiNoProductsSelected);
                return;
            }
            else{
                // copy ids
            	postParams.product_ids = productDetailIds.join(',');
            }
    	}
    	
    	$.ajax({
    		url: admin_order_tab_link + '&id_order='+id_order+'&action=check_customer_credit_limit&ajax=1',
    		data: postParams,
    		method: 'POST',
    		dataType: 'json',
    		success: function(response){
    			if(response.credit_limit_exceeded === false){
    				submitInvoiceAdd();
    			}
    			else{
    				customerCreditLimitExceededMessage = customerCreditLimitExceededMessage.replace('@limit', response.credit_limit);
    				if( confirm(customerCreditLimitExceededMessage) ){
    					submitInvoiceAdd();
    				}
    			}
    		}
    	});
    });
    /*
	$('#orderProducts .product_stock').each(function(key, item) {
		var sku = $(this).attr('data-id');
		var rr = 'https://www.koehlert.com/admin1234/ajax_product_comb_qnt.php?q='+
			//'https://www.vipdress.de/admin123/index_service.php/supplier_orders/show_supplier_orders_by_sku_ext/'+
			//'https://www.vipdress.de/admin123/index_service.php/supplier_orders/show_supplier_orders_by_sku/'+
			//'https://dmitri.wheel/vipdress.de1/admin123/index_service.php/supplier_orders/show_supplier_orders_by_sku/'
			encodeURIComponent(sku);
		$(this).attr('rel', rr);
	});

	$('#orderProducts .product_stock').cluetip({width:'900px', showTitle: false, cluetipClass:'default', waitImage: '../../img/loader.gif'});
	*/
    $('#orderProducts .stockStatusExpDelivery').cluetip({local:true, showTitle: false, cluetipClass:'nopadding'});
    $('#burgelHelpIcon').cluetip({local: true, showTitle: false, cluezIndex: 108, cluetipClass:'default'});
    $('.stockStatusHelpIcon').cluetip({local: true, showTitle: false, cluezIndex: 108, width:500});
    

	$('[data-toggle="tooltip"]').tooltip();
	
	$('#order_view_content').on('change', '#id_order_state', function(event){
		if( $(event.target).find('option:selected').data('need_date') == '0' ){
			$('#order_state_due_date').val('').attr('disabled', 'disabled');
		}
		else{
			$('#order_state_due_date').removeAttr('disabled');
		}
	});
	$('#order_state_due_date').attr('disabled', 'disabled');
	$('form#submitStateForm').on('submit', function(){
		if( ($('#id_order_state').find('option:selected').data('need_date') == '1')
			&& ($('#order_state_due_date').val() == '') 
		){
			alert(txt_order_state_need_due_date);
			return false;
		}
	});
	$('#status').on('dblclick', '#orderCurrentStateDateDue', function(event){
		var stateDateDue = $(event.target).text();
		var stateDueDateInput = $('<input type="text"  autocomplete="off">');
		stateDueDateInput.attr('id', 'orderCurrentStateDateDueInput');
		stateDueDateInput.val(stateDateDue);
		$(event.target).html(stateDueDateInput).promise().done(function(){
			$("#orderCurrentStateDateDueInput").datepicker({
				prevText:"", 
				nextText:"", 
				dateFormat:"dd.mm.yy",
				showButtonPanel: true,
				onClose : function(dateText, picker){
					var postData = {date_due:dateText};
					$('#orderCurrentStateDateDue').text('Saving');
					$.ajax({
						url: admin_order_tab_link + '&id_order='+ id_order +'&ajax=1&action=change_current_state_due_date',
						data: postData,
						dataType: 'json',
						method: 'POST',
						error: function( jqXHR, textStatus, errorThrown){
							alert( textStatus +': '+ errorThrown );
						},
						success: function(response, textStatus, jqXHR){
							if(!response.success){
								var errorsText = '';
								for( var ei in response.messages ){
									errorsText += response.messages[ei] + "\n";
								}
								alert(errorsText);
							}
							else{
								$('#orderCurrentStateDateDue').text( response.data.status_date_due_formatted );
							}
						}
					});
				}
			});
		});
	});
        $('#cancelOrderPackageBtn').click(function(e){
            e.preventDefault();
            if (!confirm(cancelOrderPackageText))
            {
                $('#cancelOrderPackageForm input[name=just_mark]').val(1);
            }
            $('#cancelOrderPackageForm input[name=order_package_id]').val($('#addInvoiceOrderPackageId').val());
            $('#cancelOrderPackageForm').submit();
        });
        
        $('#showOrderPackageBtn').click(function(e){
            e.preventDefault();
            $.post(admin_order_tab_link, {id: $('#addInvoiceOrderPackageId').val(), ajax: 1, action: 'showOrderPackage'}, 
            function(result){
                fancyMsgBoxAdmin(result, '', 800);
            });
        });

    /**
	 * Public order detail notes
	 */
	$('body.adminorders').on('dblclick', '.productDetailNote, .productDetailNotePrivate', function(){
		$('#orderDetailNoteModal').modal('show');
		$('#orderDetailNoteModal .modal-body').html('Loading...');
		var orderDetalId = $(this).parents('tr').attr('id').match(/orderDetailRow_(\d+)/)[1];
		$.ajax({
			url: admin_order_tab_link + '&action=edit_detail_note&ajax=1&id_order='+id_order+'&id_order_detail='+orderDetalId,
			dataType: 'json',
			success: function(response){
				$('#orderDetailNoteModal .modal-body').html(response.form);
			}
		});
	});
	$('#orderDetailNoteModal').on('click', '#orderDetailNoteDialogSave', function(){
		var formData = $('#orderDetailNoteModal form').serializeArray();
		//formData.push({name: 'id_customer', value: id_customer});
		var formAction = $('#orderDetailNoteModalDialog').find('.modal-body').find('form').attr('action');
		$('#orderDetailNoteModal .modal-body').html('Loading...');
		$.ajax({
			data: formData,
			method: 'POST',
			dataType: 'json',
			url: formAction,
			success: function(response){
				if(response.success && (response.form == null)){
					$('#orderDetailNoteModal').modal('hide');
					$('#orderProducts tbody tr').each(function(){
						var orderDetailRowMatch = $(this).attr('id').match(/orderDetailRow_(\d+)/);
						if( orderDetailRowMatch == null ){
							return;
						}
						var orderDetalRowId = parseInt( orderDetailRowMatch[1] );
						if( orderDetalRowId == parseInt( response.data.id_order_detail ) ){
							$(this).find('td.productDetailNote').html(response.data.note);
							$(this).find('td.productDetailNotePrivate').html(response.data.note_private);
						}
					});
				}
				else{
					$('#orderDetailNoteModal .modal-body').html(response.form);
				}
			}
		});
		
	});

	$('#orderViewCustomerCredLimSwitch').cluetip({local:true, showTitle: false});
	
	$('#shippingLabelPrintAdd').click(function(){
		var labelsNumber = prompt('How many labels to print?');
		labelsNumber = parseInt(labelsNumber);
		if( isNaN(labelsNumber) ){
			alert('Number required');
			return;
		}
		$(this).append('&nbsp;<span>Sending</span>');
		
		var addressId = $('#addressShipping select[name="id_address"]').val();
		addressId = parseInt(addressId);
		if( isNaN(addressId) ){
			alert('Address ID not found. Printing not possible');
			return;
		}
		
		$.ajax({
			method: 'POST',
			dataType: 'json',
			url: admin_order_tab_link + '&action=add_shipping_label_print&ajax=1&id_order='+id_order+'&id_address='+addressId+'&number='+labelsNumber,
			success: function(response){
				if(!response.success){
					alert(response.message);
				}
				else{
					$('#shippingLabelPrintAdd').replaceWith('<span>Set to queue</span>');
				}
			}
		});

	});
	
	var customerSiretId = null;
	$('#orderViewCustomerPanel').on('dblclick', '.order_view_customer_siret_label,.order_view_customer_siret_value', function(){
		if( $('.order_view_customer_siret_value input').length ){
			return false;
		}
		customerSiretId = $('.order_view_customer_siret_value').text();
		var newSiretInp = $('<input>');
		newSiretInp.attr({
			id: 'order_view_customer_siret_input',
			type: 'text'
		}).val(customerSiretId);
		$('span.order_view_customer_siret_conf').hide();
		$('.order_view_customer_siret_value').html(newSiretInp);
		newSiretInp.focus();
	});
	$('#orderViewCustomerPanel').on('blur', '#order_view_customer_siret_input', function(ev){
		ev.stopImmediatePropagation();
		var newCustomerSiretId = $(this).val();
		if( customerSiretId == newCustomerSiretId ){
			$('.order_view_customer_siret_value').text(customerSiretId);
			//$('span.order_view_customer_siret_conf').show();
			vatConfirmedMarkShow();
			return;
		}
		
		$('.order_view_customer_siret_value').text('Saving...');
		var requestData = {
			vat_id: newCustomerSiretId
		};
		$.ajax({
			method: 'POST',
			dataType: 'json',
			data: requestData,
			url: 'index.php?controller=AdminCustomers&token='+token_admin_customers+'&action=update_vat&ajax=1&id_customer='+id_customer,
			success: function(response){
				if(!response.success){
					alert(response.message);
				}
				else{
					$('.order_view_customer_siret_value').text(response.data.vat_id);
					vatConfirmedMarkShow();
					getCustomerObjectVatHistory();
				}
			}
		});
	});
	$('#orderViewCustomerPanel').on('click', 'span.order_view_customer_siret_conf', function(ev){
		var requestData = {
			vat_confirmed: null
		};
		var confirmationText = null;
		if( $(this).hasClass('text-danger') ){
			requestData.vat_confirmed = 1;
			confirmationText = txt_vat_confirmed;
		}
		else{
			requestData.vat_confirmed = 0;
			confirmationText = txt_vat_unconfirmed;
		}
		
		if( !confirm(confirmationText) ){
			return false;
		}
		
		$.ajax({
			method: 'POST',
			dataType: 'json',
			data: requestData,
			url: 'index.php?controller=AdminCustomers&token='+token_admin_customers+'&action=update_vat&ajax=1&id_customer='+id_customer,
			success: function(response){
				if(!response.success){
					alert(response.message);
				}
				else{
					$('span.order_view_customer_siret_conf.text-success').data('active', response.data.vat_confirmed);
					$('span.order_view_customer_siret_conf.text-danger').data('active', !response.data.vat_confirmed);
					customer_vat_confirmed = response.data.vat_confirmed;
					vatConfirmedMarkShow();
					getCustomerObjectVatHistory();
				}
			}
		});

	});
	//$('#orderViewCustomerPanel').on('hover', '.order_view_customer_siret_label button', function(){
	//	$('#orderViewCustomerPanel .order_view_customer_siret_label .dropdown-menu').dropdown('show');
	//});

	vatConfirmedMarkShow();
	getCustomerObjectVatHistory();
	
    $('img.imgm.img-thumbnail').mouseenter(function(){
        var imageBigUrl = $(this).data('srcbig');
        var posRight = 20;
        var posTop = $('html').scrollTop() + 20;
        $('body').append('<div style="top:'+posTop+'px;right:'+posRight+'px;z-index:10;box-shadow:0 0 5px #000;position:absolute;background:#fff;" id="imageBigCont"><img src="'+imageBigUrl+'"></div>');
    })
    .mouseleave(function(){
        $('#imageBigCont').remove();
    });
    $('#addressAll').on('click', 'button.customer-address-delete', function(event){
    	if( confirm('Confirm deleting of customer address?') ){
    		return true;
    	}
    	else{
    		event.stopPropagation();
    		return false;
    	}
    });
    $('#order_view_content').on('click', '#ignoreNoInvoiceEmail', function(ev){
    	var ignore = $(this).prop('checked');
    	var comment = $('#ignoreNoInvoiceEmailComment').val();
    	if( ignore && (comment.length == 0) ){
    		alert('Please write comment');
    		ev.preventDefault();
    		return;
    	}
    	else if( !ignore && !confirm('Do not ignore this order any more?')){
    		ev.preventDefault();
    		return;
    	}
    	
    	var params = {
    		ignore, comment
    	};
		$.ajax({
			method: 'POST',
			dataType: 'json',
			data: params,
			url: admin_order_tab_link + '&action=set_ignore_no_invoice_note&ajax=1&id_order='+id_order,
			success: function(response){
				if(!response.success){
					alert(response.message);
				}
				else{
					if( response.data.ignore ){
						$('#ignoreNoInvoiceEmailComment').val(response.data.comment).prop('readonly', true);
						$('#ignoreNoInvoiceEmailEmployee').show();
						$('#ignoreNoInvoiceEmailEmployee em').text(response.data.employee);
					}
					else{
						$('#ignoreNoInvoiceEmailComment').val('').prop('readonly', false);
						$('#ignoreNoInvoiceEmailEmployee').hide();
						$('#ignoreNoInvoiceEmailEmployee em').text('');
					}
				}
			},
			error: function(){
				
			}
		});

    });
});

function vatConfirmedMarkShow(){
	var vatId = $('.order_view_customer_siret_value').text();
	if( !vatId.length ){
		$('.order_view_customer_siret_conf').hide();
		return;
	}
	$('.order_view_customer_siret_conf').each(function(){
		if( $(this).data('active') == 1 ){
			$(this).show();
		}
		else{
			$(this).hide();
		}
	});
}
function getCustomerObjectVatHistory(){
	$.ajax({
		method: 'GET',
		dataType: 'json',
		url: 'index.php?controller=AdminCustomers&token='+token_admin_customers+'&action=get_vat_history&ajax=1&id_customer='+id_customer,
		success: function(response){
			if(!response.success){
				alert(response.message);
			}
			else if(response.data.length){
				var html = '<table class="table table-condensed">';
				for( var i in response.data ){
					html += '<tr>'
						+'<td>'+response.data[i].date_add_formatted+'</td>'
						+'<td>'+response.data[i].employee_name+'</td>'
						+'<td>'+response.data[i].field+'</td>'
						+'<td>'+response.data[i].value_formatted+'</td>'
						+'</tr>';
				}
				html += '</table>';
				$('.order_view_customer_siret_history').html(html);
			}
			else{
				$('.order_view_customer_siret_history').html('No history');
			}
		}
	});
}

function submitInvoiceAdd(){
	
	if( confirm(txt_add_invoice_and_print_now) ){
		$('#addInvoicePrintNow').val('1');
	}
	
	var orderPackageId = $('#addInvoiceOrderPackageId').val();
	orderPackageId = parseInt(orderPackageId);
	// if user selected package list, it will be used to prepare invoice
	if( orderPackageId > 0 ){
		$('#addInoiceForm').submit();
	}
	else{
	    // copy product ids in form
	    var productDetailIds = [];
	    $('.productIdCheckBox:checked').each(function (index, value){
	        productDetailIds.push($(value).val());
	    });
	    
	    if (productDetailIds.length==0)
	    {
	        alert(aiNoProductsSelected);
	        //event.preventDefault();
	    }
	    else
	    {
	        // copy ids
	        $('#addInvoiceProductIds').val(productDetailIds.join(','));
	        $('#addInoiceForm').submit();
	    }
	}
}

function stopAjaxQuery() {
	if (typeof(ajaxQueries) == 'undefined')
		ajaxQueries = new Array();
	for(i = 0; i < ajaxQueries.length; i++)
		ajaxQueries[i].abort();
	ajaxQueries = new Array();
}

function updateInvoice(invoices)
{
	// Update select on product edition line
	$('.edit_product_invoice').each(function() {
		var selected = $(this).children('option:selected').val();

		$(this).children('option').remove();
		for(i in invoices)
		{
			// Create new option
			var option = $('<option>'+invoices[i].name+'</option>').attr('value', invoices[i].id);
			if (invoices[i].id == selected)
				option.attr('selected', true);

			$(this).append(option);
		}
	});

	// Update select on product addition line
	$('#add_product_product_invoice').each(function() {
		var parent = $(this).children('optgroup.existing');
		parent.children('option').remove();
		for(i in invoices)
		{
			// Create new option
			var option = $('<option>'+invoices[i].name+'</option>').attr('value', invoices[i].id);

			parent.append(option);
		}
		parent.children('option:first').attr('selected', true);
	});

	// Update select on product addition line
	$('#payment_invoice').each(function() {
		$(this).children('option').remove();
		for(i in invoices)
		{
			// Create new option
			var option = $('<option>'+invoices[i].name+'</option>').attr('value', invoices[i].id);

			$(this).append(option);
		}
	});
}

function updateDocuments(documents_html)
{
    return;
	$('#documents_table').attr('id', 'documents_table_old');
	$('#documents_table_old').after(documents_html);
	$('#documents_table_old').remove();
}

function updateShipping(shipping_html)
{
	$('#shipping_table').attr('id', 'shipping_table_old');
	$('#shipping_table_old').after(shipping_html);
	$('#shipping_table_old').remove();
}

function updateDiscountForm(discount_form_html)
{
	$('#voucher_form').html(discount_form_html);
}

function populateWarehouseList(warehouse_list)
{
	$('#add_product_product_warehouse_area').hide();
	if (warehouse_list.length > 1)
	{
		$('#add_product_product_warehouse_area').show();
	}
	var order_warehouse_list = $('#warehouse_list').val().split(',');
	$('#add_product_warehouse').html('');
	var warehouse_selected = false;
	$.each(warehouse_list, function() {
		if (warehouse_selected == false && $.inArray(this.id_warehouse, order_warehouse_list))
			warehouse_selected = this.id_warehouse;

		$('#add_product_warehouse').append($('<option value="' + this.id_warehouse + '">' + this.name + '</option>'));
	});
	if (warehouse_selected)
		$('#add_product_warehouse').val(warehouse_selected);
}

function addProductRefreshTotal()
{
	var quantity = parseInt($('#add_product_product_quantity').val());
	if (quantity < 1|| isNaN(quantity))
		quantity = 1;
	if (use_taxes)
		var price = parseFloat($('#add_product_product_price_tax_incl').val());
	else
		var price = parseFloat($('#add_product_product_price_tax_excl').val());

	if (price < 0 || isNaN(price))
		price = 0;
	var total = makeTotalProductCaculation(quantity, price);
	$('#add_product_product_total').html(formatCurrency(total, currency_format, currency_sign, currency_blank));
}

function editProductRefreshTotal(element)
{
	element = element.parent().parent().parent();
	var element_list = [];

	// Customized product
	if(element.hasClass('customized'))
	{
		var element_list = $('.customized-' + element.find('.edit_product_id_order_detail').val());
		element = $(element_list[0]);
	}

	var quantity = parseInt(element.find('td .edit_product_quantity').val());
	if (quantity < 1 || isNaN(quantity))
		quantity = 1;
	if (use_taxes)
		var price = parseFloat(element.find('td .edit_product_price_tax_incl').val());
	else
		var price = parseFloat(element.find('td .edit_product_price_tax_excl').val())

	if (price < 0 || isNaN(price))
		price = 0;

	// Customized product
	if (element_list.length)
	{
		var qty = 0;
		$.each(element_list, function(i, elm) {
			if($(elm).find('.edit_product_quantity').length)
			{
				qty += parseInt($(elm).find('.edit_product_quantity').val());
				subtotal = makeTotalProductCaculation($(elm).find('.edit_product_quantity').val(), price);
				$(elm).find('.total_product').html(formatCurrency(subtotal, currency_format, currency_sign, currency_blank));
			}
		});

		var total = makeTotalProductCaculation(qty, price);
		element.find('td.total_product').html(formatCurrency(total, currency_format, currency_sign, currency_blank));
		element.find('td.productQuantity').html(qty);
	}
	else
	{
		var total = makeTotalProductCaculation(quantity, price);
		element.find('td.total_product').html(formatCurrency(total, currency_format, currency_sign, currency_blank));
	}

}

function makeTotalProductCaculation(quantity, price)
{
	return Math.round(quantity * price * 100) / 100;
}

function addViewOrderDetailRow(view)
{
	html = $(view);
	html.find('td').hide();
	$('tr#new_invoice').hide();
	$('tr#new_product').hide();

	// Initialize fields
	closeAddProduct();

	$('tr#new_product').before(html);
	html.find('td').each(function() {
		if (!$(this).is('.product_invoice'))
			$(this).fadeIn('slow');
	});
}

function refreshProductLineView(element, view)
{
	var new_product_line = $(view);
	new_product_line.find('td').hide();

	var element_list = [];
	if (element.parent().parent().find('.edit_product_id_order_detail').length)
		var element_list = $('.customized-' + element.parent().parent().find('.edit_product_id_order_detail').val());
	if (!element_list.length)
		element_list = $(element.parent().parent());

	var current_product_line = element.parent().parent();
	current_product_line.replaceWith(new_product_line);
	element_list.remove();

	new_product_line.find('td').each(function() {
		if (!$(this).is('.product_invoice'))
			$(this).fadeIn('slow');
	});
	return new_product_line;
}

function updateAmounts(order)
{
	$('#total_products td.amount').fadeOut('slow', function() {
		$(this).html(formatCurrency(parseFloat(order.total_products_wt), currency_format, currency_sign, currency_blank));
		$(this).fadeIn('slow');
	});
        $('#total_taxes td.amount').fadeOut('slow', function() {
		$(this).html(formatCurrency(parseFloat(order.total_paid_tax_incl)-parseFloat(order.total_paid_tax_excl), currency_format, currency_sign, currency_blank));
		$(this).fadeIn('slow');
	});
	$('#total_discounts td.amount').fadeOut('slow', function() {
		$(this).html(formatCurrency(parseFloat(order.total_discounts_tax_incl), currency_format, currency_sign, currency_blank));
		$(this).fadeIn('slow');
	});
	if (order.total_discounts_tax_incl > 0)
		$('#total_discounts').slideDown('slow');
	$('#total_wrapping td.amount').fadeOut('slow', function() {
		$(this).html(formatCurrency(parseFloat(order.total_wrapping_tax_incl), currency_format, currency_sign, currency_blank));
		$(this).fadeIn('slow');
	});
	if (order.total_wrapping_tax_incl > 0)
		$('#total_wrapping').slideDown('slow');
	$('#total_shipping td.amount').fadeOut('slow', function() {
		$(this).html(formatCurrency(parseFloat(order.total_shipping_tax_incl), currency_format, currency_sign, currency_blank));
		$(this).fadeIn('slow');
	});
	$('#total_order td.amount').fadeOut('slow', function() {
		$(this).html(formatCurrency(parseFloat(order.total_paid_tax_incl), currency_format, currency_sign, currency_blank));
		$(this).fadeIn('slow');
	});
	$('.total_paid').fadeOut('slow', function() {
		$(this).html(formatCurrency(parseFloat(order.total_paid_tax_incl), currency_format, currency_sign, currency_blank));
		$(this).fadeIn('slow');
	});
	$('.alert').slideDown('slow');
	$('#product_number').fadeOut('slow', function() {
		var old_quantity = parseInt($(this).html());
		$(this).html(old_quantity + 1);
		$(this).fadeIn('slow');
	});
	$('#shipping_table .weight').fadeOut('slow', function() {
		$(this).html(order.weight);
		$(this).fadeIn('slow');
	});
}

function closeAddProduct()
{
	$('tr#new_invoice').hide();
	$('tr#new_product').hide();

	// Initialize fields
	$('tr#new_product select, tr#new_product input').each(function() {
		if (!$(this).is('.button'))
			$(this).val('')
	});
	$('tr#new_invoice select, tr#new_invoice input').val('');
	$('#add_product_product_quantity').val('1');
	$('#add_product_product_attribute_id option').remove();
	$('#add_product_product_attribute_area').hide();
	if (stock_management)
		$('#add_product_product_stock').html('0');
	current_product = null;
}



/**
 * This method allow to initialize all events
 */
function init()
{
	$('[data-toggle="tooltip"]').tooltip();
	
	$('#txt_msg').on('keyup', function(){
		var length = $('#txt_msg').val().length;
		if (length > 600) length = '600+';
		$('#nbchars').html(length+'/600');
	});
        
        // change in stock state link
        $('.inStockChangeLink').unbind('click').on('click', function(e){
            e.preventDefault();
            var orderDetailId = $(this).parent().parent().find('input.productIdCheckBox').val();
            var clickedA = this;
            $.post(admin_order_tab_link, {id: orderDetailId, ajax: 1, action: 'toggleStockState'}, function(result){
                    if (result.error)
                    {
                        jAlert(result.error);
                    }
                   if (result.inStock)
                   {
                       $(clickedA).children('i').removeClass('icon-remove').addClass('icon-check');
                       $(clickedA).removeClass('action-disabled').addClass('action-enabled');
                   }
                   else
                   {
                       $(clickedA).children('i').removeClass('icon-check').addClass('icon-remove');
                       $(clickedA).removeClass('action-enabled').addClass('action-disabled');
                   }
               }, 'json');
        });
        
        // change in shipped state link
        $('.shippedCol').unbind('click').on('click', function(e){
            e.preventDefault();
            // check if field is already in edit mode
            if ($(this).find('#saveShippedNum').length)
            {
                return;
            }
            var enableTooltip = false;
            if ($(this).children('.label-tooltip').length)
            {
                $(this).children('.label-tooltip').tooltip('hide');
                $(this).children('.label-tooltip').tooltip('disable');
                enableTooltip = true;
            }
            //$(this).parents('tr').find('*').attr('disabled','disabled').addClass('disabled');
            
            /*
            if( $(this).parent().is('td') ){
            	var element = $(this);
            }
            else{
            	var element = $(this).parent();
            }
            */
           var productIdCheckbox = $(this).parents('tr').find('td').first().find('input.productIdCheckBox');
            var rowCheckboxChecked = productIdCheckbox.prop('checked');
            var orderDetailId = productIdCheckbox.val();
                        
           // save current shipped num
            var shippedNum = $(this).find('.shippedNum').text();
            var checkMark = $(this).find('.list-action-enable');
            checkMark.hide();
            // show input fields
            $(this).find('.shippedNum').html('<input type="text" name="shipped_num" id="shippedNumInput" value="'+shippedNum+
                    '" style="width: 45px;display: inline;" />');
            $(this).find('.needToBeShippedNum').after('<br /><button id="saveShippedNum" class="btn btn-default" type="button">'+txt_ok+
                    '</button>'+'<button id="cancelShippedNum" class="btn btn-default" type="button">'+txt_cancel+'</button>');
            // add event listeners to created buttons
            $('#cancelShippedNum').click(function(e){
                e.stopPropagation();
                // return all back
                $(this).siblings('.shippedNum').text(shippedNum);
                $(this).siblings('.needToBeShippedNum + br').remove();
                checkMark.show();
                $(this).siblings('#saveShippedNum').remove();
                if (enableTooltip)
                {
                    $(this).parent().tooltip('enable');
                }
                $(this).remove();
            });
            
            $('#saveShippedNum').click(function(e){
                e.stopPropagation();
            $.post(admin_order_tab_link, {id: orderDetailId, ajax: 1, action: 'saveShippedNum', 
                num: $(this).siblings('.shippedNum').children('#shippedNumInput').val()}, function(result){
            	if (result.error){
                    jAlert(result.error);
                    return;
                }

            	let new_product_line = refreshProductLineView(enableTooltip?checkMark.parent():checkMark, result.view);
            	
				init();
				
				$('.standard_refund_fields').hide();
				$('.partial_refund_fields').hide();
				$('.add_product_fields').hide();
				$('.row-editing-warning').hide();
				$('td.product_action').attr('colspan', 3);
				$('.order_action').show();
				
				if( rowCheckboxChecked ){
					$(new_product_line).find('td').first().find('input.productIdCheckBox').prop('checked', true);
				}

            }, 'json');
           });
        });
        
        
	$('#newMessage').unbind('click').click(function(e) {
		$(this).hide();
		$('#message').show();
		e.preventDefault();
	});

	$('#cancelMessage').unbind('click').click(function(e) {
		$('#newMessage').show();
		$('#message').hide();
		e.preventDefault();
	});

	$('#add_product').unbind('click').click(function(e) {
		$('.cancel_product_change_link:visible').trigger('click');
		$('.add_product_fields').show();
		$('.edit_product_fields, .standard_refund_fields, .partial_refund_fields, .order_action').hide();
		$('tr#new_product').slideDown('fast', function () {
			$('tr#new_product td').fadeIn('fast', function() {
				$('#add_product_product_name').focus();
				scroll_if_anchor('#new_product');
			});
		});
		e.preventDefault();
	});

	$('#cancelAddProduct').unbind('click').click(function() {
		$('.order_action').show();
		$('tr#new_product td').fadeOut('fast');
	});

	$("#add_product_product_name").autocomplete(admin_order_tab_link,
		{
			minChars: 3,
			max: 10,
			width: 500,
			selectFirst: false,
			scroll: false,
			dataType: "json",
			highlightItem: true,
			formatItem: function(data, i, max, value, term) {
				return value;
			},
			parse: function(data) {
				var products = new Array();
				if (typeof(data.products) != 'undefined')
					for (var i = 0; i < data.products.length; i++)
						products[i] = { data: data.products[i], value: data.products[i].name };
				return products;
			},
			extraParams: {
				ajax: true,
				token: token,
				action: 'searchProducts',
				id_lang: id_lang,
				id_currency: id_currency,
				id_address: id_address,
				id_customer: id_customer,
				product_search: function() { return $('#add_product_product_name').val(); }
			}
		}
	)
	.result(function(event, data, formatted) {
		if (!data)
		{
			$('tr#new_product input, tr#new_product select').each(function() {
				if ($(this).attr('id') != 'add_product_product_name')
					$('tr#new_product input, tr#new_product select, tr#new_product button').attr('disabled', true);
			});
		}
		else
		{
			$('tr#new_product input, tr#new_product select, tr#new_product button').removeAttr('disabled');
			// Keep product variable
			current_product = data;
			$('#add_product_product_id').val(data.id_product);
			$('#add_product_product_name').val(data.name);
			$('#add_product_product_price_tax_incl').val(data.price_tax_incl);
			$('#add_product_product_price_tax_excl').val(data.price_tax_excl);
			addProductRefreshTotal();
			if (stock_management)
				$('#add_product_product_stock').html(data.stock[0]);

			if (current_product.combinations.length !== 0)
			{
				// Reset combinations list
				$('select#add_product_product_attribute_id').html('');
				var defaultAttribute = 0;
				$.each(current_product.combinations, function() {
					$('select#add_product_product_attribute_id').append('<option value="'+this.id_product_attribute+'"'+(this.default_on == 1 ? ' selected="selected"' : '')+'>'+this.attributes+'</option>');
					if (this.default_on == 1)
					{
						if (stock_management)
							$('#add_product_product_stock').html(this.qty_in_stock);
						defaultAttribute = this.id_product_attribute;
					}
				});
				// Show select list
				$('#add_product_product_attribute_area').show();

				populateWarehouseList(current_product.warehouse_list[defaultAttribute]);
			}
			else
			{
				// Reset combinations list
				$('select#add_product_product_attribute_id').html('');
				// Hide select list
				$('#add_product_product_attribute_area').hide();

				populateWarehouseList(current_product.warehouse_list[0]);
			}
		}
	});

	$('select#add_product_product_attribute_id').unbind('change');
	$('select#add_product_product_attribute_id').change(function() {
		$('#add_product_product_price_tax_incl').val(current_product.combinations[$(this).val()].price_tax_incl);
		$('#add_product_product_price_tax_excl').val(current_product.combinations[$(this).val()].price_tax_excl);

		populateWarehouseList(current_product.warehouse_list[$(this).val()]);

		addProductRefreshTotal();
		if (stock_management)
			$('#add_product_product_stock').html(current_product.combinations[$(this).val()].qty_in_stock);
	});

	$('input#add_product_product_quantity').unbind('keyup').keyup(addProductQuantityChange).unbind('change').
                change(addProductQuantityChange);

	$('#submitAddProduct').unbind('click').click(function(e) {
		e.preventDefault();
		stopAjaxQuery();
		var go = true;

		if ($('input#add_product_product_id').val() == 0)
		{
			jAlert(txt_add_product_no_product);
			go = false;
		}

		if ($('input#add_product_product_quantity').val() == 0)
		{
			jAlert(txt_add_product_no_product_quantity);
			go = false;
		}

		if ($('input#add_product_product_price_excl').val() == 0)
		{
			jAlert(txt_add_product_no_product_price);
			go = false;
		}
		
		if(current_product.stock_clearance == '1'){
			go = confirm(txt_add_product_stock_clearance);
		}

		if (go)
		{
			if (parseInt($('input#add_product_product_quantity').val()) > parseInt($('#add_product_product_stock').html()))
				go = confirm(txt_add_product_stock_issue);

			if (go)
			{
				var query = 'ajax=1&token='+token+'&action=addProductOnOrder&id_order='+id_order+'&';

				query += $('#add_product_warehouse').serialize()+'&';
				query += $('tr#new_product select, tr#new_product input').serialize();
				if ($('select#add_product_product_invoice').val() == 0)
					query += '&'+$('tr#new_invoice select, tr#new_invoice input').serialize();

				var ajax_query = $.ajax({
					type: 'POST',
					url: admin_order_tab_link,
					cache: false,
					dataType: 'json',
					data : query,
					success : function(data) {
						if (data.result)
						{
							if (data.refresh)
							{
								location.reload();
								return;
							}
							go = false;
							addViewOrderDetailRow(data.view);
							updateAmounts(data.order);
							updateInvoice(data.invoices);
							updateDocuments(data.documents_html);
							updateShipping(data.shipping_html);
							updateDiscountForm(data.discount_form_html);

							// Initialize all events
							init();

							$('.standard_refund_fields').hide();
							$('.partial_refund_fields').hide();
							$('.order_action').show();
						}
						else
							jAlert(data.error);
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						jAlert("Impossible to add the product to the cart.\n\ntextStatus: '" + textStatus + "'\nerrorThrown: '" + errorThrown + "'\nresponseText:\n" + XMLHttpRequest.responseText);
					}
				});
				ajaxQueries.push(ajax_query);
			}
		}
	});

	$('.edit_shipping_number_link').unbind('click').click(function(e) {
		$(this).parent().parent().find('.shipping_number_show').hide();
		$(this).parent().find('.shipping_number_edit').show();

		$(this).parent().find('.edit_shipping_number_link').hide();
		$(this).parent().find('.cancel_shipping_number_link').show();
		e.preventDefault();
	});

	$('.cancel_shipping_number_link').unbind('click').click(function(e) {
		$(this).parent().parent().find('.shipping_number_show').show();
		$(this).parent().find('.shipping_number_edit').hide();

		$(this).parent().find('.edit_shipping_number_link').show();
		$(this).parent().find('.cancel_shipping_number_link').hide();
		e.preventDefault();
	});

	$('#add_product_product_invoice').unbind('change').change(function() {
		if ($(this).val() == '0')
			$('#new_invoice').slideDown('slow');
		else
			$('#new_invoice').slideUp('slow');
	});

	$('#add_product_product_price_tax_excl').unbind('keyup').keyup(function() {
		var price_tax_excl = parseFloat($(this).val());
		if (price_tax_excl < 0 || isNaN(price_tax_excl))
			price_tax_excl = 0;

		var tax_rate = current_product.tax_rate / 100 + 1;
		$('#add_product_product_price_tax_incl').val(ps_round(price_tax_excl * tax_rate, 2));

		// Update total product
		addProductRefreshTotal();
	});

	$('#add_product_product_price_tax_incl').unbind('keyup').keyup(function() {
		var price_tax_incl = parseFloat($(this).val());
		if (price_tax_incl < 0 || isNaN(price_tax_incl))
			price_tax_incl = 0;

		var tax_rate = current_product.tax_rate / 100 + 1;
		$('#add_product_product_price_tax_excl').val(ps_round(price_tax_incl / tax_rate, 2));

		// Update total product
		addProductRefreshTotal();
	});

	$('.edit_product_change_link').unbind('click').click(function(e) {
		$('.add_product_fields, .standard_refund_fields, .order_action').hide();
		$('.edit_product_fields').show();
		$('.row-editing-warning').hide();
		$('.cancel_product_change_link:visible').trigger('click');
		closeAddProduct();
		var element = $(this);
		$.ajax({
			type: 'POST',
			url: admin_order_tab_link,
			cache: false,
			dataType: 'json',
			data : {
				ajax: 1,
				token: token,
				action: 'loadProductInformation',
				id_order_detail: element.closest('tr.product-line-row').find('input.edit_product_id_order_detail').val(),
				id_address: id_address,
				id_order: id_order
			},
			success : function(data)
			{
				if (data.result)
				{
					current_product = data;

					var element_list = $('.customized-' + element.parents('.product-line-row').find('.edit_product_id_order_detail').val());
					if (!element_list.length)
					{
						element_list = element.parents('.product-line-row');
						element_list.find('td .product_quantity_show').hide();
						element_list.find('td .product_quantity_edit').show();
					}
					else
					{
						element_list.find('td .product_quantity_show').hide();
						element_list.find('td .product_quantity_edit').show();
					}
					element_list.find('td .product_price_show').hide();
					element_list.find('td .product_price_edit').show();
					element_list.find('td.cancelCheck').hide();
					element_list.find('td.cancelQuantity').hide();
					element_list.find('td.product_invoice').show();
					$('td.product_action').attr('colspan', 3);
					$('th.edit_product_fields').show();
					$('th.edit_product_fields').attr('colspan',  2);
					element_list.find('td.product_action').attr('colspan', 1);
					element.parent().children('.edit_product_change_link').parent().hide();
					element.parent().parent().find('button.submitProductChange').show();
					element.parent().parent().find('.cancel_product_change_link').show();

					if (+data.reduction_percent != +0)
						element_list.find('.row-editing-warning').show();

					$('.standard_refund_fields').hide();
					$('.partial_refund_fields').hide();
				}
				else
					jAlert(data.error);
			}
		});
		e.preventDefault();
	});

	$('.cancel_product_change_link').unbind('click').click(function(e)
	{
		current_product = null;
		$('.edit_product_fields').hide();
		$('.row-editing-warning').hide();
		var element_list = $('.customized-' + $(this).parent().parent().find('.edit_product_id_order_detail').val());
		if (!element_list.length)
			element_list = $($(this).parent().parent());
		element_list.find('td .product_price_show').show();
		element_list.find('td .product_quantity_show').show();
		element_list.find('td .product_price_edit').hide();
		element_list.find('td .product_quantity_edit').hide();
		element_list.find('td.product_invoice').hide();
		element_list.find('td.cancelCheck').show();
		element_list.find('td.cancelQuantity').show();
		element_list.find('.edit_product_change_link').parent().show();
		element_list.find('button.submitProductChange').hide();
		element_list.find('.cancel_product_change_link').hide();
		$('.order_action').show();
		$('.standard_refund_fields').hide();
		e.preventDefault();
	});

	$('button.submitProductChange').unbind('click').click(function(e) {
		e.preventDefault();

		/*if ($(this).closest('tr.product-line-row').find('td .edit_product_quantity').val() <= 0)
		{
			jAlert(txt_add_product_no_product_quantity);
			return false;
		}*/
		if ($(this).closest('tr.product-line-row').find('td .edit_product_price').val() <= 0)
		{
			jAlert(txt_add_product_no_product_price);
			return false;
		}
		if (confirm(txt_confirm))
		{
			var element = $(this);
			var element_list = $('.customized-' + $(this).parent().parent().find('.edit_product_id_order_detail').val());
			query = 'ajax=1&token='+token+'&action=editProductOnOrder&id_order='+id_order+'&';
			if (element_list.length)
				query += element_list.parent().parent().find('input:visible, select:visible, .edit_product_id_order_detail').serialize();
			else
				query += element.parent().parent().find('input:visible, select:visible, .edit_product_id_order_detail').serialize();

			$.ajax({
				type: 'POST',
				url: admin_order_tab_link,
				cache: false,
				dataType: 'json',
				data : query,
				success : function(data)
				{
					if (data.result)
					{
						refreshProductLineView(element, data.view);
						updateAmounts(data.order);
						updateInvoice(data.invoices);
						updateDocuments(data.documents_html);
						updateDiscountForm(data.discount_form_html);

						// Initialize all events
						init();

						$('.standard_refund_fields').hide();
						$('.partial_refund_fields').hide();
						$('.add_product_fields').hide();
						$('.row-editing-warning').hide();
						$('td.product_action').attr('colspan', 3);
					}
					else
						jAlert(data.error);
					$('.order_action').show();
				}
			});
		}

		return false;
	});

	$('.edit_product_price_tax_excl').unbind('keyup').keyup(function() {
		var price_tax_excl = parseFloat($(this).val());
		if (price_tax_excl < 0 || isNaN(price_tax_excl))
			price_tax_excl = 0;
		var tax_rate = current_product.tax_rate / 100 + 1;
		$('.edit_product_price_tax_incl:visible').val(ps_round(price_tax_excl * tax_rate, 2));
		// Update total product
		editProductRefreshTotal($(this));
	});

	$('.edit_product_price_tax_incl').unbind('keyup');
	$('.edit_product_price_tax_incl').keyup(function() {
		var price_tax_incl = parseFloat($(this).val());
		if (price_tax_incl < 0 || isNaN(price_tax_incl))
			price_tax_incl = 0;

		var tax_rate = current_product.tax_rate / 100 + 1;
		$('.edit_product_price_tax_excl:visible').val(ps_round(price_tax_incl / tax_rate, 2));
		// Update total product
		editProductRefreshTotal($(this));
	});

	$('.edit_product_quantity').unbind('keyup');
	$('.edit_product_quantity').keyup(function() {
		var quantity = parseInt($(this).val());
		if (quantity < 1 || isNaN(quantity))
			quantity = 1;
		var stock_available = parseInt($(this).parent().parent().parent().find('td.product_stock').html());
		// total update
		editProductRefreshTotal($(this));
	});

	$('.delete_product_line').unbind('click').click(function(e) {
            
            if (showReadMessagesConfirmation && !confirm(readMessagesConfirmation))
            {
                return false;
            }
		if (!confirm(txt_confirm))
			return false;
		var tr_product = $(this).closest('.product-line-row');
		var id_order_detail = $(this).closest('.product-line-row').find('td .edit_product_id_order_detail').val();
		var query = 'ajax=1&action=deleteProductLine&token='+token+'&id_order_detail='+id_order_detail+'&id_order='+id_order;

		$.ajax({
			type: 'POST',
			url: admin_order_tab_link,
			cache: false,
			dataType: 'json',
			data : query,
			success : function(data)
			{
				if (data.result)
				{
					tr_product.fadeOut('slow', function() {
						$(this).remove();
					});
					updateAmounts(data.order);
					updateInvoice(data.invoices);
					updateDocuments(data.documents_html);
					updateDiscountForm(data.discount_form_html);
				}
				else
					jAlert(data.error);
			}
		});
		e.preventDefault();
	});


	$('.js-set-payment').unbind('click').click(function(e) {
		var amount = $(this).attr('data-amount');
		$('input[name=payment_amount]').val(amount);
		var id_invoice = $(this).attr('data-id-invoice');
		$('select[name=payment_invoice] option[value='+id_invoice+']').attr('selected', true);
		e.preventDefault();
	});

	$('#add_voucher').unbind('click').click(function(e) {
		$('.order_action').hide();
		$('.panel-vouchers,#voucher_form').show();
		e.preventDefault();
	});

	$('#cancel_add_voucher').unbind('click').click(function(e) {
		$('#voucher_form').hide();
		if (!has_voucher)
			$('.panel-vouchers').hide();
		$('.order_action').show();
		e.preventDefault();
	});

	$('#discount_type').unbind('change').change(function() {
		// Percent type
		if ($(this).val() == 1)
		{
			$('#discount_value_field').show();
			$('#discount_currency_sign').hide();
			$('#discount_value_help').hide();
			$('#discount_percent_symbol').show();
		}
		// Amount type
		else if ($(this).val() == 2)
		{
			$('#discount_value_field').show();
			$('#discount_percent_symbol').hide();
			$('#discount_value_help').show();
			$('#discount_currency_sign').show();
		}
		// Free shipping
		else if ($(this).val() == 3)
		{
			$('#discount_value_field').hide();
		}
	});

	$('#discount_all_invoices').unbind('change').change(function() {
		if ($(this).is(':checked'))
			$('select[name=discount_invoice]').attr('disabled', true);
		else
			$('select[name=discount_invoice]').attr('disabled', false);
	});

	$('.open_payment_information').unbind('click').click(function(e) {
		if ($(this).parent().parent().next('tr').is(':visible'))
			$(this).parent().parent().next('tr').hide();
		else
			$(this).parent().parent().next('tr').show();
		e.preventDefault();
	});
}


function addProductQuantityChange() 
{
    if (stock_management)
    {
        var quantity = parseInt($(this).val());
        if (quantity < 1 || isNaN(quantity))
            quantity = 1;
        var stock_available = parseInt($('#add_product_product_stock').html());
        // stock status update
        if (quantity > stock_available)
            $('#add_product_product_stock').css('font-weight', 'bold').css('color', 'red').css('font-size', '1.2em');
        else
            $('#add_product_product_stock').css('font-weight', 'normal').css('color', 'black').css('font-size', '1em');
    }
    // total update
    addProductRefreshTotal();
}

/* Refund system script */
var flagRefund = '';

$(document).ready(function() {
	$('#desc-order-standard_refund').click(function() {
		$('.cancel_product_change_link:visible').trigger('click');
		closeAddProduct();
		if (flagRefund == 'standard') {
			flagRefund = '';
			$('.partial_refund_fields').hide();
			$('.standard_refund_fields').hide();
		}
		else {
			if( $('#orderProducts .returnOrderDetailCheckBox').length == 0 ){
				alert('Nothing to return, no products were shipped. Use Edit/Delete product instead!');
				return;
			}
			flagRefund = 'standard';
			$('.partial_refund_fields').hide();
			$('.standard_refund_fields').fadeIn();
		}
		if (order_discount_price)
			actualizeTotalRefundVoucher();
	});

	$('#desc-order-partial_refund').click(function() {
		$('.cancel_product_change_link:visible').trigger('click');
		closeAddProduct();
		if (flagRefund == 'partial') {
			flagRefund = '';
			$('.partial_refund_fields').hide();
			$('.standard_refund_fields').hide();
		}
		else {
			flagRefund = 'partial';
			$('.standard_refund_fields, .product_action, .order_action').hide();
			$('.product_action').hide();
			$('.partial_refund_fields').fadeIn();
		}

		if (order_discount_price)
			actualizeRefundVoucher();
	});
});

function checkPartialRefundProductQuantity(it)
{
	if (parseInt($(it).val()) > parseInt($(it).closest('td').find('.partialRefundProductQuantity').val()))
		$(it).val($(it).closest('td').find('.partialRefundProductQuantity').val());
	if (order_discount_price)
		actualizeRefundVoucher();
}

function checkPartialRefundProductAmount(it)
{
	var old_price = $(it).closest('td').find('.partialRefundProductAmount').val();
	if (typeof $(it).val() !== undefined && typeof new_price !== undefined &&
		parseFloat($(it).val()) > parseFloat(old_price))
		$(it).val(old_price);

	if (order_discount_price)
		actualizeRefundVoucher();
}

function actualizeRefundVoucher()
{
	var total = 0.0;
	$('.edit_product_price_tax_incl.edit_product_price').each(function(){
		quantity_refund_product = parseFloat($(this).closest('td').parent().find('td.partial_refund_fields.current-edit').find('input[onchange="checkPartialRefundProductQuantity(this)"]').val());
		if (quantity_refund_product > 0)
		{
			current_amount = parseFloat($(this).closest('td').parent().find('td.partial_refund_fields.current-edit').find('input[onchange="checkPartialRefundProductAmount(this)"]').val()) ?
			parseFloat($(this).closest('td').parent().find('td.partial_refund_fields.current-edit').find('input[onchange="checkPartialRefundProductAmount(this)"]').val())
			: parseFloat($(this).val());
			total += current_amount * quantity_refund_product;
		}
	});
	$('#total_refund_1').remove();
	$('#lab_refund_1').append('<span id="total_refund_1">' + formatCurrency(total, currency_format, currency_sign, currency_blank) + '</span>');
	$('#lab_refund_1').append('<input type="hidden" name="order_discount_price" value=' + order_discount_price + '/>');
	$('#total_refund_2').remove();
        
        var orderTotalTi = parseFloat($('#total_order .amount').text());
        var decreaseDiscountReturn = total*order_discount_price_ti/orderTotalTi;
        $('#lab_refund_2').append('<span id="total_refund_2">' + formatCurrency(decreaseDiscountReturn, currency_format, currency_sign, currency_blank) + '</span>');
        /*
	if (parseFloat(total - order_discount_price) > 0.0) {
		document.getElementById('refund_2').disabled = false;
		$('#lab_refund_2').append('<span id="total_refund_2">' + formatCurrency((total - order_discount_price), currency_format, currency_sign, currency_blank) + '</span>');
	}
	else {
		if (document.getElementById('refund_2').checked === true)
			document.getElementById('refund_1').checked = true;
		document.getElementById('refund_2').disabled = true;
		$('#lab_refund_2').append('<span id="total_refund_2">' + errorRefund + '</span>');
	}
        */
}

function actualizeTotalRefundVoucher()
{
	var total = 0.0;
	$('.edit_product_price_tax_excl.edit_product_price').each(function(){
		quantity_refund_product = parseFloat($(this).closest('td').parent().find('td.cancelQuantity').children().val());
		if (typeof quantity_refund_product !== 'undefined' && quantity_refund_product > 0)
			total += $(this).val() * quantity_refund_product;
	});
	$('#total_refund_1').remove();
	$('#lab_refund_total_1').append('<span id="total_refund_1">' + formatCurrency(total, currency_format, currency_sign, currency_blank) + '</span>');
	$('#lab_refund_total_1').append('<input type="hidden" name="order_discount_price" value=' + order_discount_price + '/>');
	$('#total_refund_2').remove();
        
        var decreaseDiscountReturn = total*order_discount_price_te/orderTotalProductsTe;
        $('#lab_refund_total_2').append('<span id="total_refund_2">' + formatCurrency((total-decreaseDiscountReturn), currency_format, currency_sign, currency_blank) + '</span>');
        /*
	if (parseFloat(total - order_discount_price) > 0.0) {
		document.getElementById('refund_total_2').disabled = false;
		$('#lab_refund_total_2').append('<span id="total_refund_2">' + formatCurrency((total - order_discount_price), currency_format, currency_sign, currency_blank) + '</span>');
	}
	else {
		if (document.getElementById('refund_total_2').checked === true)
			document.getElementById('refund_total_1').checked = true;
		document.getElementById('refund_total_2').disabled = true;
		$('#lab_refund_total_2').append('<span id="total_refund_2">' + errorRefund + '</span>');
	}
        */
}

function setCancelQuantity(itself, id_order_detail, quantity)
{
	$('#cancelQuantity_' + id_order_detail).val($(itself).prop('checked') ? quantity : '');
	if (order_discount_price)
		actualizeTotalRefundVoucher();
}

function checkTotalRefundProductQuantity(it)
{
	$(it).parent().parent().find('td.cancelCheck input[type=checkbox]').attr("checked", true);
	if (parseInt($(it).val()) > parseInt($(it).closest('td').find('.partialRefundProductQuantity').val()))
		$(it).val($(it).closest('td').find('.partialRefundProductQuantity').val());
	if (order_discount_price)
		actualizeTotalRefundVoucher();
}
