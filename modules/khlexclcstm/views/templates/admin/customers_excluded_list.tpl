<table class="table">
  <tr>
    <th>{l s='ID' mod='khlexclcstm'}</th>
    <th>{l s='Company' mod='khlexclcstm'}</th>
    <th>{l s='Name' mod='khlexclcstm'}</th>
    <th>{l s='Action' mod='khlexclcstm'}</th>
  </tr>
  {foreach $customers_excluded as $customer_excluded}
  <tr>
    <td>{$customer_excluded.id_excluded}</td>
    <td>{$customer_excluded.company}</td>
    <td>{$customer_excluded.firstname} {$customer_excluded.lastname}</td>
    <td>
      <button class="btn btn-danger btn-xs excluded-customer-remove" data-id_main_to_excl="{$customer_excluded.id_customer_main_to_excl}">{l s='Remove'}</button>
    </td>
  </tr>
  {/foreach}
</table>
