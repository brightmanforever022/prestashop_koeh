<div class="row">
  <div class="col-md-2">
    <label for="customer_name" class="">{l s='Customer name'}</label>
    <div>
    	<input name="customer_name" type="text" class="form-control" id="customer_name" >
    </div>
  </div>
  <div class="col-md-2">
    <label for="company_name">{l s='Company'}</label>
    <div>
    <input name="company_name" type="text" class="form-control" id="company_name">
    </div>
  </div>
  <div class="col-md-2">
    <label for="country_id">{l s='Country'}</label>
    <div>
    {html_options name='country_id[]' id='country_id' options=$countries_list multiple='multiple'}
    </div>
  </div>
  <div class="col-md-2">
    <label for="agent_id">{l s='Agent'}</label>
    <div>
    {html_options name='agent_id[]' id='agent_id' options=$agents_list multiple='multiple'}
    </div>
  </div>

  <div class="col-md-1">
  	<label class="">&nbsp;</label>
  	<div>
  	<button type="submit" class="btn btn-default" id="khlSaleStatsFilter">{l s='Filter'}</button>
  	</div>
  </div>
</div>			
