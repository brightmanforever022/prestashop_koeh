{$customer = $exclusivity->getCustomer()}
<div class="panel">

	<h2>{l s='Requiremnts Satisfied'}: 
		{if $exclusivity->areRequirementsSatisfied()}
		<span class="label label-success">{l s='Yes'}</span>
		{else}
		<span class="label label-danger">{l s='No'}</span>
		{/if}
	</h2> 

	<dl class="dl-horizontal">
		<dt>{l s='Customer'}</dt>
		<dd>{$customer->firstname} {$customer->lastname}</dd>
		<dt>{l s='Radius'}</dt>
		<dd>{$exclusivity->radius}</dd>
		<dt>{l s='Amount to order'}</dt>
		<dd>{$exclusivity->amount}</dd>

		<dt>{l s='Amount real ordered'}</dt>
		<dd>{$exclusivity->getAmountOrdered()}</dd>

		<dt>{l s='Date start'}</dt>
		<dd>{dateFormat date=$exclusivity->date_start}</dd>
		<dt>{l s='Date end'}</dt>
		<dd>{dateFormat date=$exclusivity->date_end}</dd>
	</dl>
	<br>
	<h3>{l s='Orders'}</h3>
	{foreach $exclusivity->getCustomerOrders() as $order}
	<p>
		#{$order->id} , {dateFormat date=$order->date_add}
	</p>
	<table class="table table-condensed">
		<col width="55%">
		<col width="15%">
		<col width="15%">
		<col width="15%">
		<tr>
			<th>{l s='Name'}</th>
			<th class="text-center">{l s='Ordered'}</th>
			<th class="text-center">{l s='Refunded'}</th>
			<th class="text-center">{l s='Returned'}</th>
		</tr>
		{foreach $order->getOrderDetailList() as $orderDetail}
		<tr>
			<td >{$orderDetail['product_name']}</td>
			<td class="text-center">{$orderDetail['product_quantity']}</td>
			<td class="text-center">{$orderDetail['product_quantity_refunded']}</td>
			<td class="text-center">{$orderDetail['product_quantity_return']}</td>
		</tr>
		{/foreach}
	</table>
	<hr>
	{/foreach}
</div>