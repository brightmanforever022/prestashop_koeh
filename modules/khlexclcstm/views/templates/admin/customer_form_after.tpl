<div class="panel">
  <div class="panel-heading">
    {l s='Exclude customers from buying same products' mod='khlexclcstm'}
  </div>
  <div class="row">
    <div class="col-lg-12">
        <p class="alert alert-info">
            This form allows to set a group of customers which can not buy same products within period of {$excluded_period_days} days.
            Customers in the group are in equal conditions. If customer A bought product, customers B and C can not buy it.
            Once excluded period is over, any customer in the group can buy this product.
            Product can not be bought in any size. But other colors of this style can be bought. 
        </p>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <h4>{l s='Add customer' mod='khlexclcstm'}</h4>
      <input id="customer_search" type="text" placeholder="Search customer" class="form-control">
      <hr>
      <div id="customer_search_results"></div>
    </div>
    <div class="col-lg-6" id="">
      <h4>{l s='Excluded customers' mod='khlexclcstm'}</h4>
      <div id="excluded_customers_list"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
<!--
var id_customer = {$id_customer};
var mainexclCustomersControllerUrl = "{$mainexcl_controller_url}";
//-->
</script>