
<div class="panel">
	<p class="text-muted">{$note_text}
	</p>
	<ul class="nav nav-pills nav-justified">
		<li class="">
			<a class="btn {if $stats_mode == 'daily'}btn-primary{else}btn-default{/if}" href="{$currentIndex}&token={$token}&mode=daily">{l s='Daily'}</a></li>
		<li class="">
			<a class="btn {if $stats_mode == 'weekly'}btn-primary{else}btn-default{/if}" href="{$currentIndex}&token={$token}&mode=weekly">{l s='Weekly'}</a></li>
		<li >
			<a class="btn {if $stats_mode == 'monthly'}btn-primary{else}btn-default{/if}" href="{$currentIndex}&token={$token}&mode=monthly">{l s='Monthly'}</a></li>
	</ul>
	{if $stats_mode == 'daily'}
		{include './stats_daily.tpl'}
	{elseif $stats_mode == 'weekly'}
		{include './stats_weekly.tpl'}
	{elseif $stats_mode == 'monthly'}
		{include './stats_monthly.tpl'}
	{/if}
</div>