<div class="panel" id="agentsalesCountriesPanel" style="min-height: 450px;">
  <div class="panel-heading">
    {l s='Agent\'s related countries' mod='agentsales'}
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-info">This form allows to manage agent's related countries.</div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <h4>{l s='Add/Edit country' mod='agentsales'}</h4>
      <button type="button" class="btn btn-primary" id="agentsalesCountryNew">{l s='New country' mod='agentsales'}</button>
      <div id="agentsalesCountryFormContainer" hidden>
      {include file='./agent_country_form.tpl'}
      </div>
    </div>
    <div class="col-lg-8" id="">
      <h4>{l s='Related countries' mod='agentsales'}</h4>
      <div id="agentsalesCountriesList"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
<!--
var id_customer = {$id_customer};
var agentsalesCountriesControllerUrl = "{$agentsalescountries_controller_url}";
//-->
</script>