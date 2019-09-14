{extends file="helpers/form/form.tpl"}
{block name="after"}
{if $can_edit}
<div class="panel" id="employeeCountriesPanel" style="min-height: 450px;">
  <div class="panel-heading">
    {l s='Related countries'}
  </div>
  <div class="row">
    <div class="col-lg-12">
      <p class="alert alert-info">
      {l s='If country not set, employee linked to all countries. If postcodes of country not set, employee linked to entire country'}
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <h4>{l s='Add/Edit country'}</h4>
      <button type="button" class="btn btn-primary" id="employeeCountryNew">{l s='New country'}</button>
      <div id="employeeCountryFormContainer" hidden>
      {include file='../../employee_country_form.tpl'}
      </div>
    </div>
    <div class="col-lg-8" id="">
      <h4>{l s='Related countries'}</h4>
      <div id="employeeCountriesList"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
<!--
var id_employee = {$id_employee};
var employeeAreaControllerUrl = "{$employee_area_controller_url}";
//-->
</script>
{/if}
{/block}