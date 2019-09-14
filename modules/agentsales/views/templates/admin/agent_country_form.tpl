<form action="" method="post" id="agentsalesCountryForm">
    <input type="hidden" name="id" value="{if isset($agent_country.id)}{$agent_country.id}{/if}">
      <label>{l s='Country' mod='agentsales'}</label>
      {html_options options=$countries_options name='id_country' selected=$agent_country.id_country}
      
      <label>{l s='Postcodes' mod='agentsales'}</label>
      <textarea rows="5" cols="20" name="postcodes">{$agent_country.postcodes|escape}</textarea>
      <br>
      <button type="button" id="agentsalesCountrySubmit" class="btn btn-default"
        >{l s='Save related country' mod='agentsales'}</button>
</form>