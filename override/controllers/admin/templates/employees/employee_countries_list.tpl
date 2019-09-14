<table class="table">
  <tr>
    <th>{l s='ID'}</th>
    <th>{l s='Country'}</th>
    <th>{l s='Postcodes'}</th>
    <th>{l s='Action'}</th>
  </tr>
  {foreach $employee_countries_list as $employee_country}
  <tr>
    <td>{$employee_country.id_employee_country}</td>
    <td>{$employee_country.country_name}</td>
    <td>{$employee_country.postcodes}</td>
    <td>
      <button class="btn btn-warning btn-xs employee-country-edit" data-id="{$employee_country.id_employee_country}">{l s='Edit'}</button>
      <button class="btn btn-danger btn-xs employee-country-remove" data-id="{$employee_country.id_employee_country}">{l s='Remove'}</button>
    </td>
  </tr>
  {/foreach}
</table>
