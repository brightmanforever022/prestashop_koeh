{*
* 2007-2014 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel" id="splref_container">
	<h4>Server</h4>
	<select id="splref_server">
	{foreach $services as $srvKey => $srvUrl}
	<option value="{$srvKey}">{$srvKey}</option>
	{/foreach}
	</select>
	<h4>{l s='Supplier references'}</h4>
	<textarea rows="20" id="splref_references"></textarea>
	<button type="button" id="splref_generate">Generate</button>
</div>
<div class="panel">
<table id="splref_progress" class="table table-condensed"></table>
</div>

<script type="text/javascript">
var progressTable = $('#splref_progress');
var refs = [];
$('#splref_container').delegate('#splref_generate', 'click', function(){
	var refsTmp = $('#splref_references').val().split("\n");
	refs = [];
	//genIndex = 0;
	for(var ri = 0; ri < refsTmp.length; ri++){
		refsTmp[ri] = refsTmp[ri].trim();
		if(refsTmp[ri].length <= 0){
			continue;
		}
		refs.push(refsTmp[ri]);
	}
	progressTable.empty();
	for(var ri = 0; ri < refs.length; ri++){
		var row = $('<tr/>');
		row.attr('id', 'row_'+ri)
			.append('<td class="splref_name">'+ refs[ri] +'</td><td class="splref_status">waiting</td>');
		progressTable.append(row);
	}
	splrefGenerate(0);
});
function splrefGenerate(genIndex){
	if(genIndex > (refs.length-1)){
		return;
	}
	$.ajax({
		url: '{$module_dir}export.php',
		type: 'POST',
		dataType: 'json',
		data: { ref:refs[genIndex], server: $('#splref_server').val() },
		success: function(response, textStatus, jqXHR){
			progressTable.find('#row_'+genIndex).find('.splref_status').html(textStatus +', '+response.message);
			splrefGenerate(++genIndex);
		},
		error: function( jqXHR, textStatus, errorThrown ) {
			progressTable.find('#row_'+genIndex).find('.splref_status').html(textStatus +', '+errorThrown);
			splrefGenerate(++genIndex);
		}
	});
	
;
	
}
</script>