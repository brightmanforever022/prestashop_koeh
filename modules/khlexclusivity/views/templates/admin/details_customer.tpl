<div class="col-lg-12">
<div class="panel">
	<div class="panel-heading">{l s='Exclusivity'}</div>
	<div class="panel-body">
{if isset($exclusivity)}
	<h2>{l s='Requiremnts Satisfied'}: 
		{if $exclusivity->areRequirementsSatisfied()}
		<span class="label label-success">{l s='Yes'}</span>
		{else}
		<span class="label label-danger">{l s='No'}</span>
		{/if}
	</h2> 

	<dl class="dl-horizontal">
		<dt>{l s='Radius'}</dt>
		<dd>{$exclusivity->radius}</dd>
		
		<dt>{l s='Amount to order in period'}</dt>
		<dd>{$exclusivity->amount}</dd>
		
		<dt>{l s='Amount should be ordered'}</dt>
		<dd>{$exclusivity->getAmountShouldBeOrdered()}</dd>

		<dt>{l s='Amount ordered to date'}</dt>
		<dd>{$exclusivity->getAmountOrdered()}</dd>

		<dt>{l s='Date start'}</dt>
		<dd>{dateFormat date=$exclusivity->date_start}</dd>
		<dt>{l s='Date end'}</dt>
		<dd>{dateFormat date=$exclusivity->date_end}</dd>
	</dl>
{else}

<a href="{$exclusivity_url}" class="btn btn-default">{l s='Create exclusivity'}</a>

{/if}
	</div>
</div>
</div>
