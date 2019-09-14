<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 17:12:38
         compiled from "/home/koehlert/public_html/modules/khlexclcstm//views/templates/admin/customer_form_after.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12960352035d596ae628e8e4-68191270%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5894c72dbb4dcaa877814ede6965746004c0eff3' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlexclcstm//views/templates/admin/customer_form_after.tpl',
      1 => 1564124177,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12960352035d596ae628e8e4-68191270',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'excluded_period_days' => 0,
    'id_customer' => 0,
    'mainexcl_controller_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596ae629b695_21364750',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596ae629b695_21364750')) {function content_5d596ae629b695_21364750($_smarty_tpl) {?><div class="panel">
  <div class="panel-heading">
    <?php echo smartyTranslate(array('s'=>'Exclude customers from buying same products','mod'=>'khlexclcstm'),$_smarty_tpl);?>

  </div>
  <div class="row">
    <div class="col-lg-12">
        <p class="alert alert-info">
            This form allows to set a group of customers which can not buy same products within period of <?php echo $_smarty_tpl->tpl_vars['excluded_period_days']->value;?>
 days.
            Customers in the group are in equal conditions. If customer A bought product, customers B and C can not buy it.
            Once excluded period is over, any customer in the group can buy this product.
            Product can not be bought in any size. But other colors of this style can be bought. 
        </p>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <h4><?php echo smartyTranslate(array('s'=>'Add customer','mod'=>'khlexclcstm'),$_smarty_tpl);?>
</h4>
      <input id="customer_search" type="text" placeholder="Search customer" class="form-control">
      <hr>
      <div id="customer_search_results"></div>
    </div>
    <div class="col-lg-6" id="">
      <h4><?php echo smartyTranslate(array('s'=>'Excluded customers','mod'=>'khlexclcstm'),$_smarty_tpl);?>
</h4>
      <div id="excluded_customers_list"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
<!--
var id_customer = <?php echo $_smarty_tpl->tpl_vars['id_customer']->value;?>
;
var mainexclCustomersControllerUrl = "<?php echo $_smarty_tpl->tpl_vars['mainexcl_controller_url']->value;?>
";
//-->
</script><?php }} ?>
