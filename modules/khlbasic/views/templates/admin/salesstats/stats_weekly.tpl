<table class="table table-bordered" id="khlSaleStatsTable">
	<thead>
		<tr>
			<td colspan="10">
			{include './filter_form.tpl'}
			</td>
		</tr>

		<tr>
			<th>{l s='Date'}</th>
			<th>{l s='Sold dresses'}</th>
			<th>{l s='Sale revenue'}</th>
		</tr>
	</thead>
	<tbody>
	{include './stats_weekly_rows.tpl'}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="10">
				<button id="khlSaleStatsPrev" class="btn btn-primary pull-left">Previous</button>
				
				<button id="khlSaleStatsExport" class="btn btn-default pull-right">Export</button>

			</td>
		</tr>
	</tfoot>
</table>

<script type="text/javascript">
<!--
khlSaleStats.init('weekly');
//-->
</script>