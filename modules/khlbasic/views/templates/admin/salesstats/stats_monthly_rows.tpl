{if isset($stats_monthly)}
	{foreach $stats_monthly as $stats_item}
		<tr>
		{if isset($stats_item.period_name)}
			<td> <strong>{$stats_item.period_name}</strong> </td>
			<td> <strong>{$stats_item.sold_quantity_total}</strong> </td>
			<td> <strong>{displayPrice price=$stats_item.sale_revenue_total}</strong> </td>
		{elseif isset($stats_item.no_records)}
			<td colspan="10">{l s='No records found'}</td>
		{else}
			<td>{$stats_item.report_date_formatted}</td>
			<td>{$stats_item.sold_quantity}</td>
			<td>{displayPrice price=$stats_item.sale_revenue}</td>
		
		{/if}
		</tr>
	{/foreach}
{/if}