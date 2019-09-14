<div class="panel">
	<div class="panel-heading">
		{l s='Totals' mod='agentcomm'}
	</div>
	<div class="panel-content">
	{if isset($agents_stats)}
		<h4>{l s='Invoices total'}: {$agents_stats['total']}</h4>
		<h4>{l s='Commissions for paid invoices'}: {$agents_stats['commision_invoice_paid']}</h4>
        <h4>{l s='Commissions for unpaid invoices'}: {$agents_stats['commision_invoice_unpaid']}</h4>
		<h4>{l s='Commissions for orders where are no invoices created yet'}: {$agents_stats['pending_commissions']} <a role="button" data-toggle="collapse" href="#pendingCommissionsList">Show</a></h4>
		
		<div class="collapse" id="pendingCommissionsList">
			<table class="table table-bordered">
				<tr>
					<th>Order</th>
					<th>Base</th>
					<th>Comm.</th>
					<th>Agent</th>
				</tr>
			{foreach $pending_commissions_list as $pending_commission_data}
				<tr>
					<td>{$pending_commission_data['id_order']}</td>
					<td>{displayPrice price=$pending_commission_data['commission_base']}</td>
					<td>{displayPrice price=$pending_commission_data['commission_value']}</td>
					<td>{$pending_commission_data['agent_name']}</td>
				</tr>
			{/foreach}
			</table>
		</div>
	{/if}
	</div>
</div>
