{extends file="controllers/customers/helpers/list/list_header.tpl"}
{block name=leadin}
	{if isset($delete_customer) && $delete_customer}
		<form action="{$REQUEST_URI|escape:'html':'UTF-8'}" method="post">
			<div class="alert alert-warning">
				<h4>{l s='How do you want to delete the selected customers?'}</h4>
				<p>{l s='There are two ways of deleting a customer. Please choose your preferred method.'}</p>
				<br>
				<ul class="listForm list-unstyled">
					<li>
						<label for="deleteMode_deleted" class="control-label">
							<input type="radio" name="deleteMode" value="deleted" id="deleteMode_deleted" />
							{l s='I do not want my customer(s) to register again with the same email address. All selected customer(s) will be removed from this list but their corresponding data will be kept in the database.'}
						</label>
					</li>
				</ul>
				{foreach $POST as $key => $value}
					{if is_array($value)}
						{foreach $value as $val}
							<input type="hidden" name="{$key|escape:'html':'UTF-8'}[]" value="{$val|escape:'html':'UTF-8'}" />
						{/foreach}
					{else}
						<input type="hidden" name="{$key|escape:'html':'UTF-8'}" value="{$value|escape:'html':'UTF-8'}" />
					{/if}
				{/foreach}
				<input type="submit" class="btn btn-default" value="{l s='Delete'}" />
			</div>
		</form>
		<script>
			$(document).ready(function() {
				$('table[name=\'list_table\']').hide();
			});
		</script>
	{/if}

{/block}
{block name="preTable"}
<div class="row">
  <div class="col-md-2">
    <label>{l s='Did not ordered'}</label>
    {html_options name=customerFilter_did_not_ordered options=$did_not_ordered_filter_options selected=$did_not_ordered_selected}
  </div>
</div>
<hr>
{/block}