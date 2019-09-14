{if isset($stats_weekly)}
	{foreach $stats_weekly as $stats_item}
		<tr>
		{if isset($stats_item.period_name)}
			<td colspan="10"> <strong>{$stats_item.period_name}</strong> </td>
		{elseif isset($stats_item.no_records)}
			<td colspan="10">{l s='No records found'}</td>
		{else}
			<td>{$stats_item.report_date}</td>
			<td>{$stats_item.sold_quantity}</td>
			<td>{displayPrice price=$stats_item.sale_revenue}</td>
		{/if}
		</tr>
	{/foreach}
{/if}