
<div class="col-lg-12" id="agentsalesOrderToAgentContainer">
	<div class="panel">
		<div class="panel-heading">
			{l s='Associate order with agent' mod='agentsales'}
		</div>
		<div class="">
		<div id="agentsalesOrderToAgentMessages"></div>
		<form action="" method="post" id="agentsalesOrderToAgentForm" class="form-inline">
			<input type="hidden" name="id_agent[]" value="0">
			<div class="form-group" style="height:300px;overflow-y:auto;">
			{foreach $agents as $agent}
			<label>
				<input name="id_agent[]" value="{$agent['id_customer']}" {if $agent['selected']}checked="checked"{/if} 
				{if !$agent['editable']}disabled{/if} type="checkbox">
				{$agent['lastname']} {$agent['firstname']} ({$agent['company']})
			</label><br>
			{/foreach}
			</div>
			<input type="hidden" name="id_order" value="{$id_order}">

			<button class="btn btn-primary" type="submit">{l s='Save'}</button>
		</form>
		</div>
	</div>
</div>
<script type="text/javascript">
var agentsalesAgentsControllerUrl = "{$agentsalesAgentsControllerUrl}";
var authenticatedOwnerAdmin = {$authenticated_owner_admin};
$(function(){
	$('#agentsalesOrderToAgentContainer').on('click', 'input[name="id_agent[]"]', function(){
		if(!authenticatedOwnerAdmin){
			var chckdCnt = $('input[name="id_agent[]"]:checked').length;
			var confirmText = 'You are already assigned to one other commisions in this order. '+
				'Do you want to remove the other option so you can add a new one?';
			if((chckdCnt > 1) && confirm(confirmText)){
				event.preventDefault();
				return false;
			}
			else{
				return true;
			}
		}
	});
	$('#agentsalesOrderToAgentContainer').on('submit', '#agentsalesOrderToAgentForm', function(event){
		event.preventDefault();
		
		$('#agentsalesOrderToAgentMessages').empty();
		$('#agentsalesOrderToAgentMessages').html(
			'<div class="alert alert-info">Loading...</div>'
		);

		$.ajax({
			url: agentsalesAgentsControllerUrl +'&action=save_order_agent',
			method: 'post',
			dataType: 'json',
			data: $('#agentsalesOrderToAgentForm').serialize()
		})
		.done(function(response){
			if(response.success){
				$('#agentsalesOrderToAgentMessages').html(
					'<div class="alert alert-success">'+ response.message +'</div>'
				);
				$('#agentsalesOrderToAgentForm input').removeAttr('checked').removeProp('checked');
				for( var i in response.data.sales ){
					$('#agentsalesOrderToAgentForm input[value="'+ response.data.sales[i].id_agent +'"]')
						.attr('checked', 'checked');
				}
			}
			else{
				$('#agentsalesOrderToAgentMessages').html(
					'<div class="alert alert-danger">'+ response.message +'</div>'
				);
			}
		});
	});
});

</script>