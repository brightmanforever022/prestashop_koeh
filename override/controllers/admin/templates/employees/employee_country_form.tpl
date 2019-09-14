<form action="" method="post" id="employeeCountryForm">
    <input type="hidden" name="id" value="{if isset($employee_country.id_employee_country)}{$employee_country.id_employee_country}{/if}">
      <label>{l s='Country'}</label>
      {html_options options=$countries_options name='id_country' selected=$employee_country.id_country}
      
      <label>{l s='Postcodes'}</label>
      <textarea rows="5" cols="20" name="postcodes">{$employee_country.postcodes|escape}</textarea>
      <p class="text-muted">
      To match from "10000" to "19999" set "1".<br>
      To match from "10000" to "10999" set "10".<br>
      For entire country set "*".<br>
      </p>
      <br>
      <button type="button" id="employeeCountrySubmit" class="btn btn-default"
        >{l s='Save related country'}</button>
</form>