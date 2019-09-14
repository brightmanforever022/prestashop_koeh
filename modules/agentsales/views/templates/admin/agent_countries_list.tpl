<table class="table">
  <tr>
    <th>{l s='ID' mod='agentsales'}</th>
    <th>{l s='Country' mod='agentsales'}</th>
    <th>{l s='Postcodes' mod='agentsales'}</th>
    <th>{l s='Action' mod='agentsales'}</th>
  </tr>
  {foreach $agent_countries_list as $agent_country}
  <tr>
    <td>{$agent_country.id}</td>
    <td>{$agent_country.country_name}</td>
    <td>{$agent_country.postcodes}</td>
    <td>
      <button class="btn btn-warning btn-xs agent-country-edit" data-id="{$agent_country.id}">{l s='Edit' mod='agentsales'}</button>
      <button class="btn btn-danger btn-xs agent-country-remove" data-id="{$agent_country.id}">{l s='Remove' mod='agentsales'}</button>
    </td>
  </tr>
  {/foreach}
</table>
