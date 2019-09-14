<table class="table table-condensed shop-comments-table comments-status-{$comments_status_text}" 
  data-reference_id="{$reference_id}" data-reference_type="{$reference_type}">
	<tr>
		<th>{l s='Employee' mod='shopcomments'}</th>
		<th>{l s='Date' mod='shopcomments'}</th>
		<th>{l s='Comment' mod='shopcomments'}</th>
	</tr>
	{foreach $comments as $comment}
	<tr data-comment_id="{$comment['id']}" class="{if $comment['status']==0}warning status-archived{else}status-active{/if}">
		<td>{$comment['employee_name']}</td>
		<td>{dateFormat date=$comment['date_created'] full=true}</td>
		<td>{$comment['message']}</td>
	</tr>
	{/foreach}
</table>