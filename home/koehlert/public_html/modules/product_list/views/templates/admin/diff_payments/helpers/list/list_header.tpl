{*
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
*}
{if $ajax}
	<script type="text/javascript">
		$(function () {
			$(".ajax_table_link").click(function () {
				var link = $(this);
				$.post($(this).attr('href'), function (data) {
					if (data.success == 1) {
						showSuccessMessage(data.text);
						if (link.hasClass('action-disabled')){
							link.removeClass('action-disabled').addClass('action-enabled');
						} else {
							link.removeClass('action-enabled').addClass('action-disabled');
						}
						link.children().each(function () {
							if ($(this).hasClass('hidden')) {
								$(this).removeClass('hidden');
							} else {
								$(this).addClass('hidden');
							}
						});
					} else {
						showErrorMessage(data.text);
					}
				}, 'json');
				return false;
			});
		});
	</script>
{/if}
{* Display column names and arrows for ordering (ASC, DESC) *}
{if $is_order_position}
	<script type="text/javascript" src="../js/jquery/plugins/jquery.tablednd.js"></script>
	<script type="text/javascript">
		var come_from = '{$list_id|addslashes}';
		var alternate = {if $order_way == 'DESC'}'1'{else}'0'{/if};
	</script>
	<script type="text/javascript" src="../js/admin/dnd.js"></script>
{/if}
{if !$simple_header}
	<script type="text/javascript">
		$(function() {
			$('table.{$list_id} .filter').keypress(function(e){
				var key = (e.keyCode ? e.keyCode : e.which);
				if (key == 13)
				{
					e.preventDefault();
					formSubmit(e, 'submitFilterButton{$list_id}');
				}
			})
			$('#submitFilterButton{$list_id}').click(function() {
				$('#submitFilter{$list_id}').val(1);
			});

			if ($("table .datepicker").length > 0) {
				$("table .datepicker").datepicker({
					prevText: '',
					nextText: '',
					altFormat: 'yy-mm-dd'
				});
			}
		});
	</script>
{/if}

{if !$simple_header}
	<div class="leadin">
		{block name="leadin"}{/block}
	</div>
{/if}

{block name="override_header"}{/block}

{hook h='displayAdminListBefore'}

{if isset($name_controller)}
	{capture name=hookName assign=hookName}display{$name_controller|ucfirst}ListBefore{/capture}
	{hook h=$hookName}
{elseif isset($smarty.get.controller)}
	{capture name=hookName assign=hookName}display{$smarty.get.controller|ucfirst|htmlentities}ListBefore{/capture}
	{hook h=$hookName}
{/if}

<div class="alert alert-warning" id="{$list_id}-empty-filters-alert" style="display:none;">{l s='Please fill at least one field to perform a search in this list.'}</div>
{if isset($sql) && $sql}
	<form id="sql_form_{$list_id|escape:'html':'UTF-8'}" action="{$link->getAdminLink('AdminRequestSql')|escape}&amp;addrequest_sql" method="post" class="hide">
		<input type="hidden" id="sql_query_{$list_id|escape:'html':'UTF-8'}" name="sql" value="{$sql|escape}"/>
		<input type="hidden" id="sql_name_{$list_id|escape:'html':'UTF-8'}" name="name" value=""/>
	</form>
{/if}

{block name="startForm"}
	<form method="post" action="{$action|escape:'html':'UTF-8'}" class="form-horizontal clearfix" id="form-{$list_id}">
{/block}

{if !$simple_header}
	<input type="hidden" id="submitFilter{$list_id}" name="submitFilter{$list_id}" value="0"/>
	<input type="hidden" name="page" value="{$page|intval}"/>
	<input type="hidden" name="selected_pagination" value="{$selected_pagination|intval}"/>
	{block name="override_form_extra"}{/block}
	<div class="panel col-lg-12">
		<div class="panel-heading">
			{if isset($icon)}<i class="{$icon}"></i> {/if}{if is_array($title)}{$title|end}{else}{$title}{/if}
			{if isset($toolbar_btn) && count($toolbar_btn) >0}
				<span class="badge">{$list_total}</span>
				{l s='Sum to pay total' mod='product_list'}
				<span class="badge">{displayPrice price=$sumToPayTotal}</span>
				<button class="btn" onclick="$('#sumsToPayByReminderStateContainer').show()" type="button">{l s='Details'}</button>
				<span class="panel-heading-action">
                                    <a class="list-toolbar-btn" href="#" onClick="$('#remindersConfig').toggle('slow'); return false;" >{*Config*}
                                        <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s='Config reminders'}" data-html="true" data-placement="top">
								<i class="process-icon-cogs"></i>
							</span>
                                    </a>
				{foreach from=$toolbar_btn item=btn key=k}
					{if $k != 'modules-list' && $k != 'back'}
						<a id="desc-{$table}-{if isset($btn.imgclass)}{$btn.imgclass}{else}{$k}{/if}" class="list-toolbar-btn{if isset($btn.target) && $btn.target} _blank{/if}"{if isset($btn.href)} href="{$btn.href|escape:'html':'UTF-8'}"{/if}{if isset($btn.js) && $btn.js} onclick="{$btn.js}"{/if}>
							<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s=$btn.desc}" data-html="true" data-placement="top">
								<i class="process-icon-{if isset($btn.imgclass)}{$btn.imgclass}{else}{$k}{/if}{if isset($btn.class)} {$btn.class}{/if}"></i>
							</span>
						</a>
					{/if}
				{/foreach}
					<a class="list-toolbar-btn" href="javascript:location.reload();">
						<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s='Refresh list'}" data-html="true" data-placement="top">
							<i class="process-icon-refresh"></i>
						</span>
					</a>
				{if isset($sql) && $sql}
					{assign var=sql_manager value=Profile::getProfileAccess(Context::getContext()->employee->id_profile, Tab::getIdFromClassName('AdminRequestSql'))}

					{if $sql_manager.view == 1}
						<a class="list-toolbar-btn" href="javascript:void(0);" onclick="$('.leadin').first().append('<div class=\'alert alert-info\'>' + $('#sql_query_{$list_id|escape:'html':'UTF-8'}').val() + '</div>'); $(this).attr('onclick', '');">
							<span class="label-tooltip" data-toggle="tooltip" data-original-title="{l s='Show SQL query'}" data-html="true" data-placement="top" >
								<i class="process-icon-terminal"></i>
							</span>
						</a>
						<a class="list-toolbar-btn" href="javascript:void(0);" onclick="$('#sql_name_{$list_id|escape:'html':'UTF-8'}').val(createSqlQueryName()); $('#sql_query_{$list_id|escape:'html':'UTF-8'}').val($('#sql_query_{$list_id|escape:'html':'UTF-8'}').val().replace(/\s+limit\s+[0-9,\s]+$/ig, '').trim()); $('#sql_form_{$list_id|escape:'html':'UTF-8'}').submit();">
							<span class="label-tooltip" data-toggle="tooltip" data-original-title="{l s='Export to SQL Manager'}" data-html="true" data-placement="top" >
								<i class="process-icon-database"></i>
							</span>
						</a>
					{/if}
				{/if}
				</span>
			{/if}
		</div>
		{if $show_toolbar}
			<script type="text/javascript">
				//<![CDATA[
				var submited = false;
				$(function() {
					//get reference on save link
					btn_save = $('i[class~="process-icon-save"]').parent();
					//get reference on form submit button
					btn_submit = $('#{$table}_form_submit_btn');
					if (btn_save.length > 0 && btn_submit.length > 0) {
						//get reference on save and stay link
						btn_save_and_stay = $('i[class~="process-icon-save-and-stay"]').parent();
						//get reference on current save link label
						lbl_save = $('#desc-{$table}-save div');
						//override save link label with submit button value
						if (btn_submit.val().length > 0) {
							lbl_save.html(btn_submit.attr("value"));
						}
						if (btn_save_and_stay.length > 0) {
							//get reference on current save link label
							lbl_save_and_stay = $('#desc-{$table}-save-and-stay div');
							//override save and stay link label with submit button value
							if (btn_submit.val().length > 0 && lbl_save_and_stay && !lbl_save_and_stay.hasClass('locked')) {
								lbl_save_and_stay.html(btn_submit.val() + " {l s='and stay'} ");
							}
						}
						//hide standard submit button
						btn_submit.hide();
						//bind enter key press to validate form
						$('#{$table}_form').keypress(function (e) {
							if (e.which == 13 && e.target.localName != 'textarea') {
								$('#desc-{$table}-save').click();
							}
						});
						//submit the form
						{block name=formSubmit}
							btn_save.click(function() {
								// Avoid double click
								if (submited) {
									return false;
								}
								submited = true;
								//add hidden input to emulate submit button click when posting the form -> field name posted
								btn_submit.before('<input type="hidden" name="'+btn_submit.attr("name")+'" value="1" />');
								$('#{$table}_form').submit();
								return false;
							});
							if (btn_save_and_stay) {
								btn_save_and_stay.click(function() {
									//add hidden input to emulate submit button click when posting the form -> field name posted
									btn_submit.before('<input type="hidden" name="'+btn_submit.attr("name")+'AndStay" value="1" />');
									$('#{$table}_form').submit();
									return false;
								});
							}
						{/block}
					}
				});
				//]]>
			</script>
		{/if}
{elseif $simple_header}
	<div class="panel col-lg-12">
		{if isset($title)}<h3>{if isset($icon)}<i class="{$icon}"></i> {/if}{if is_array($title)}{$title|end}{else}{$title}{/if}</h3>{/if}
{/if}


	{if $bulk_actions && $has_bulk_actions}
		{assign var=y value=2}
	{else}
		{assign var=y value=1}
	{/if}
	<style>
	@media (max-width: 992px) {
		{foreach from=$fields_display item=param name=params}
			.table-responsive-row td:nth-of-type({math equation="x+y" x=$smarty.foreach.params.index y=$y}):before {
				content: "{$param.title}";
			}
		{/foreach}
	}
	</style>
<div id="countriesSelectContainer" style="width:220px;"></div>
<div id="remindersSelectContainer" style="width:220px;"></div>
	{block name="preTable"}
            {if $tab_access['edit'] == '1'}
            <script type="text/javascript">
				//<![CDATA[
                                var ajaxActionBaseUrl = currentIndex+'&ajax=1&token='+token+'&action=';
				$(function() {
                                    $('#remindersConfigSaveBtn').click(function(){
                                        
                                        $.post(ajaxActionBaseUrl+'SaveRemindersCfg', $('#remindersConfig input').serialize(),
                                                    function(result){
                                                        if (result.error)
                                                        {
                                                            showErrorMessage(result.error);
                                                        }
                                                        else
                                                        {
                                                            showSuccessMessage('{l s='Reminders configuration saved'}');
                                                            setTimeout(function(){
                                                                $('#remindersConfig').toggle('slow');
                                                            }, 1000);
                                                        }
                                                    },
                                                    'json');
                                        return false;
                                    });
                                });
             //]]>
	    </script>                   
            
            <div id="remindersConfig" style="display:none">
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        <span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="{l s='Number of days from due date till 1st reminder'}" >
                            {l s='Days till 1st reminder'}
                        </span>
                    </label>
                        <div class="col-lg-1 ">
                            <input name="reminder1Days" value="{$reminder1Days}" class="" required="required" type="text" autocomplete="off">
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        <span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="{l s='Number of days from 1st reminder date till 2nd reminder'}" >
                            {l s='Days till 2nd reminder'}
                        </span>
                    </label>
                        <div class="col-lg-1 ">
                            <input name="reminder2Days" value="{$reminder2Days}" class="" required="required" type="text" autocomplete="off">
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        <span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="{l s='Number of days from 2nd till 3st reminder'}" >
                            {l s='Days till 3rd reminder'}
                        </span>
                    </label>
                        <div class="col-lg-1 ">
                            <input name="reminder3Days" value="{$reminder3Days}" class="" required="required" type="text" autocomplete="off">
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        <span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="{l s='Fee to add to invoice when 2nd reminder sent, 0 to disable'}" >
                            {l s='2nd reminder fee'}
                        </span>
                    </label>
                    <div class="col-lg-1 ">
                        <input name="reminder2Fee" value="{$reminder2Fee}" class="" required="required" type="text" autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-3">
                    </label>
                        <div class="col-lg-4 ">
                            <button class="btn btn-default" id="remindersConfigSaveBtn">{l s='Save'}</button>
                            <button class="btn btn-default" onClick="$('#remindersConfig').toggle('slow'); return false;">{l s='Hide'}</button>
                        </div>
                </div>
            </div>
            {/if}
        {/block}
    <div id="sumsToPayByReminderStateContainer" style="display:none;width:30%;">
    	<table class="table">
    	{foreach $sumsToPayByReminderState as $sumToPayByState}
    		<tr>
    			<td>{$sumToPayByState.reminder_state_name}</td>
    			<td>{displayPrice price=$sumToPayByState.sum_paid}</td>
    		</tr>
    	{/foreach}
    	</table>
    </div>
    
    <div class="row">
      <div class="col-md-2">
          <label>{l s='Payment type' mod='product_list'}</label>
          <input type="hidden" name="order_invoiceFilter_payment_type[]" value="">
          {html_options multiple="multiple" name='order_invoiceFilter_payment_type[]' options=$invoice_payment_type_options selected=$invoice_payment_type_selected}
      </div>
    
    </div>
    <hr>
	<div class="table-responsive-row clearfix{if isset($use_overflow) && $use_overflow} overflow-y{/if}">
		<table{if $table_id} id="table-{$table_id}"{/if} class="table{if $table_dnd} tableDnD{/if} {$table}" >
			<thead>
				<tr class="nodrag nodrop">
					{if $bulk_actions && $has_bulk_actions}
						<th class="center fixed-width-xs"></th>
					{/if}
					{foreach $fields_display AS $key => $params}
					<th class="{if isset($params.class)}{$params.class}{/if}{if isset($params.align)} {$params.align}{/if}">
						<span class="title_box{if isset($order_by) && ($key == $order_by)} active{/if}">
							{if isset($params.hint)}
								<span class="label-tooltip" data-toggle="tooltip"
									title="
										{if is_array($params.hint)}
											{foreach $params.hint as $hint}
												{if is_array($hint)}
													{$hint.text}
												{else}
													{$hint}
												{/if}
											{/foreach}
										{else}
											{$params.hint}
										{/if}
									">
									{$params.title}
								</span>
							{else}
								{$params.title}
							{/if}
							{if (!isset($params.orderby) || $params.orderby) && !$simple_header && $show_filters}
								<a class="sorting-link{if isset($order_by) && ($key == $order_by) && ($order_way == 'DESC')} active{/if}" href="{$currentIndex|escape:'html':'UTF-8'}&amp;{$list_id}Orderby={$key|urlencode}&amp;{$list_id}Orderway=desc&amp;token={$token|escape:'html':'UTF-8'}{if isset($smarty.get.$identifier)}&amp;{$identifier}={$smarty.get.$identifier|intval}{/if}">
									<i class="icon-caret-down"></i>
								</a>
								<a class="sorting-link{if isset($order_by) && ($key == $order_by) && ($order_way == 'ASC')} active{/if}" href="{$currentIndex|escape:'html':'UTF-8'}&amp;{$list_id}Orderby={$key|urlencode}&amp;{$list_id}Orderway=asc&amp;token={$token|escape:'html':'UTF-8'}{if isset($smarty.get.$identifier)}&amp;{$identifier}={$smarty.get.$identifier|intval}{/if}">
									<i class="icon-caret-up"></i>
								</a>
							{/if}
						</span>
					</th>
					{/foreach}
					{if $shop_link_type}
						<th>
							<span class="title_box">
							{if $shop_link_type == 'shop'}
								{l s='Shop'}
							{else}
								{l s='Shop group'}
							{/if}
							</span>
						</th>
					{/if}
					{if $has_actions || $show_filters}
						<th>{if !$simple_header}{/if}</th>
					{/if}
				</tr>
			{if !$simple_header && $show_filters}
				<tr class="nodrag nodrop filter {if $row_hover}row_hover{/if}">
					{if $has_bulk_actions}
						<th class="text-center">
							--
						</th>
					{/if}
					{* Filters (input, select, date or bool) *}
					{foreach $fields_display AS $key => $params}
						<th {if isset($params.align)} class="{$params.align}" {/if}>
							{if isset($params.search) && !$params.search}
								--
							{else}
								{if $params.type == 'bool'}
									<select class="filter fixed-width-sm center" name="{$list_id}Filter_{$key}">
										<option value="">-</option>
										<option value="1" {if $params.value == 1} selected="selected" {/if}>{l s='Yes'}</option>
										<option value="0" {if $params.value == 0 && $params.value != ''} selected="selected" {/if}>{l s='No'}</option>
									</select>
								{elseif $params.type == 'date' || $params.type == 'datetime'}
									<div class="date_range row">
 										<div class="input-group fixed-width-md center">
											<input type="text" class="filter datepicker date-input form-control" id="local_{$params.id_date}_0" name="local_{$params.name_date}[0]"  placeholder="{l s='From'}" />
											<input type="hidden" id="{$params.id_date}_0" name="{$params.name_date}[0]" value="{if isset($params.value.0)}{$params.value.0}{/if}">
											<span class="input-group-addon">
												<i class="icon-calendar"></i>
											</span>
										</div>
 										<div class="input-group fixed-width-md center">
											<input type="text" class="filter datepicker date-input form-control" id="local_{$params.id_date}_1" name="local_{$params.name_date}[1]"  placeholder="{l s='To'}" />
											<input type="hidden" id="{$params.id_date}_1" name="{$params.name_date}[1]" value="{if isset($params.value.1)}{$params.value.1}{/if}">
											<span class="input-group-addon">
												<i class="icon-calendar"></i>
											</span>
										</div>
										<script>
											$(function() {
												var dateStart = parseDate($("#{$params.id_date}_0").val());
												var dateEnd = parseDate($("#{$params.id_date}_1").val());
												$("#local_{$params.id_date}_0").datepicker("option", "altField", "#{$params.id_date}_0");
												$("#local_{$params.id_date}_1").datepicker("option", "altField", "#{$params.id_date}_1");
												if (dateStart !== null){
													$("#local_{$params.id_date}_0").datepicker("setDate", dateStart);
												}
												if (dateEnd !== null){
													$("#local_{$params.id_date}_1").datepicker("setDate", dateEnd);
												}
											});
										</script>
									</div>
								{elseif $params.type == 'select'}
									{if isset($params.filter_key)}
										{if isset($params.multiple) && $params.multiple}
										<input type="hidden" name="{$list_id}Filter_{$params.filter_key}[]" value="">
										<select class="filter center" name="{$list_id}Filter_{$params.filter_key}[]" multiple="multiple"  
											{if isset($params.width)} style="width:{$params.width}px"{/if} {if isset($params.id)} id="{$params.id}"{/if} >
											{html_options options=$params.list selected=$params.value}
										</select>
										{else}
										<select class="filter center" name="{$list_id}Filter_{$params.filter_key}" onchange="$('#submitFilterButton{$list_id}').focus();$('#submitFilterButton{$list_id}').click();"  
											{if isset($params.width)} style="width:{$params.width}px"{/if} >
											
											<option value="" {if $params.value == ''} selected="selected" {/if}>-</option>
											{if isset($params.list) && is_array($params.list)}
												{foreach $params.list AS $option_value => $option_display}
													<option value="{$option_value}" {if (string)$option_display === (string)$params.value ||  (string)$option_value === (string)$params.value} selected="selected"{/if}>{$option_display}</option>
												{/foreach}
											{/if}
										</select>
										{/if}
									
									{/if}
								{else}
									<input type="text" class="filter" name="{$list_id}Filter_{if isset($params.filter_key)}{$params.filter_key}{else}{$key}{/if}" value="{$params.value|escape:'html':'UTF-8'}" {if isset($params.width) && $params.width != 'auto'} style="width:{$params.width}px"{/if} />
								{/if}
							{/if}
						</th>
					{/foreach}

					{if $shop_link_type}
						<th>--</th>
					{/if}
					{if $has_actions || $show_filters}
						<th class="actions">
							{if $show_filters}
							<span class="pull-right">
								{*Search must be before reset for default form submit*}
								<button type="submit" id="submitFilterButton{$list_id}" name="submitFilter" class="btn btn-default" data-list-id="{$list_id}">
									<i class="icon-search"></i> {l s='Search'}
								</button>
								{if $filters_has_value}
									<button type="submit" name="submitReset{$list_id}" class="btn btn-warning">
										<i class="icon-eraser"></i> {l s='Reset'}
									</button>
								{/if}
							</span>
							{/if}
						</th>
					{/if}
				</tr>
			{/if}
			</thead>
		<script type="text/javascript">
			$('.sorting-link').on('click',function(e){
				e.preventDefault();
				$(this).closest("form").attr('action', $(this).attr('href'));
				//$('#submitFilter'+$(this).data("list-id")).val($(this).data("page")).closest("form").submit();
				//$('#submitFilter{$list_id}').val($(this).data("page")).closest("form").submit();
				$(this).closest("form").submit();
			});
		</script>
			