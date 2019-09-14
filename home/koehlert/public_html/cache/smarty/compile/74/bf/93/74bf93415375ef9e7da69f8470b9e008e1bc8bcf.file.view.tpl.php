<?php /* Smarty version Smarty-3.1.19, created on 2019-09-02 15:00:16
         compiled from "/home/koehlert/public_html/modules/khlcustomermap/views/templates/admin/customers_map/helpers/view/view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1217477905d6d12600bdd69-71297531%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '74bf93415375ef9e7da69f8470b9e008e1bc8bcf' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlcustomermap/views/templates/admin/customers_map/helpers/view/view.tpl',
      1 => 1559209833,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1217477905d6d12600bdd69-71297531',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'search_form_element_options' => 0,
    'customers_no_geodata_count' => 0,
    'customers_invalid_geodata_list' => 0,
    'link' => 0,
    'customer_invalid_geodata' => 0,
    'markercluster_js_url' => 0,
    'google_maps_api_key' => 0,
    'customers_map_controller_url' => 0,
    'markers_dir_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d6d1260120f41_88166657',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d6d1260120f41_88166657')) {function content_5d6d1260120f41_88166657($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/home/koehlert/public_html/tools/smarty/plugins/function.html_options.php';
?>

  <div class="panel">
    <form class="form-inline" id="customersMapSearchForm">
      <div class="form-group">
        <?php echo smarty_function_html_options(array('name'=>'status','options'=>$_smarty_tpl->tpl_vars['search_form_element_options']->value['status'],'class'=>'form-control'),$_smarty_tpl);?>

      </div>
      <div class="form-group">
        <?php echo smarty_function_html_options(array('name'=>'no_order_for_latest','options'=>$_smarty_tpl->tpl_vars['search_form_element_options']->value['not_order_for_latest'],'multiple'=>'multiple'),$_smarty_tpl);?>

      </div>
      <div class="form-group">
        <input name="postcode_start" class="form-control" placeholder="<?php echo smartyTranslate(array('s'=>'Postcode starts','mod'=>'khlcustomermap'),$_smarty_tpl);?>
">
      </div>
      <div class="form-group">
        <?php echo smarty_function_html_options(array('name'=>'id_country','options'=>$_smarty_tpl->tpl_vars['search_form_element_options']->value['id_country']),$_smarty_tpl);?>

      </div>
      
      <button type="button" class="btn btn-primary" id="customersMapSearchFormSubmit"><?php echo smartyTranslate(array('s'=>'Search','mod'=>'khlcustomermap'),$_smarty_tpl);?>
</button>
      <button type="reset" class="btn btn-default"><?php echo smartyTranslate(array('s'=>'Reset','mod'=>'khlcustomermap'),$_smarty_tpl);?>
</button>
    </form>
    <hr>
    <div class="row">
      <div class="col-lg-6">
        <p>Displayed customers: <span id="customersDisplayedCountLabel"></span></p>
      </div>
      <div class="col-lg-6 text-right">
        <p>
        Customers without geo data <span id="customersNoGeodataCountLabel"><?php echo $_smarty_tpl->tpl_vars['customers_no_geodata_count']->value;?>
</span>
        <button class="btn btn-default btn-xs" type="button" id="customersGeocodeButton">Get geodata</button>
        </p>
      </div>
    </div>

    
  </div>


<div id="customers_map" style="height:600px;"></div>

<div class="row">
  <div class="panel">
    <p>
      Customers with invalid geodata: <?php echo count($_smarty_tpl->tpl_vars['customers_invalid_geodata_list']->value);?>

      <br>
      IDs: 
      <?php  $_smarty_tpl->tpl_vars['customer_invalid_geodata'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customer_invalid_geodata']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['customers_invalid_geodata_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['customer_invalid_geodata']->key => $_smarty_tpl->tpl_vars['customer_invalid_geodata']->value) {
$_smarty_tpl->tpl_vars['customer_invalid_geodata']->_loop = true;
?>
      <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminCustomers');?>
&id_customer=<?php echo $_smarty_tpl->tpl_vars['customer_invalid_geodata']->value['id_customer'];?>
&updatecustomer"><?php echo $_smarty_tpl->tpl_vars['customer_invalid_geodata']->value['id_customer'];?>
</a>,
      <?php } ?>
    </p>
  </div>
</div>

<script src="<?php echo $_smarty_tpl->tpl_vars['markercluster_js_url']->value;?>
"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_smarty_tpl->tpl_vars['google_maps_api_key']->value;?>
&callback=initCustomersMap" async defer></script>

<script type="text/javascript">
function initCustomersMap(){
	KoehlertCustomersMap.init({
		map_container_id:'customers_map',
		data_url: '<?php echo $_smarty_tpl->tpl_vars['customers_map_controller_url']->value;?>
',
		markers_images_dir: '<?php echo $_smarty_tpl->tpl_vars['markers_dir_url']->value;?>
',
		customers_no_geodata_label: $('#customersNoGeodataCountLabel'),
		customers_geocode_button: $('#customersGeocodeButton'),
		customers_displayed_count_label: $('#customersDisplayedCountLabel'),
		customers_map_search_form: $('#customersMapSearchForm')
	});
}

</script><?php }} ?>
