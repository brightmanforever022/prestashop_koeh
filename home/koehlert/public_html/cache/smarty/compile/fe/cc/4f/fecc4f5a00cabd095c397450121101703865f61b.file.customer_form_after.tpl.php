<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 17:12:38
         compiled from "/home/koehlert/public_html/modules/agentsales//views/templates/admin/customer_form_after.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8218087375d596ae62aeae7-88216516%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fecc4f5a00cabd095c397450121101703865f61b' => 
    array (
      0 => '/home/koehlert/public_html/modules/agentsales//views/templates/admin/customer_form_after.tpl',
      1 => 1561110325,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8218087375d596ae62aeae7-88216516',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id_customer' => 0,
    'agentsalescountries_controller_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596ae62b86a0_88692570',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596ae62b86a0_88692570')) {function content_5d596ae62b86a0_88692570($_smarty_tpl) {?><div class="panel" id="agentsalesCountriesPanel" style="min-height: 450px;">
  <div class="panel-heading">
    <?php echo smartyTranslate(array('s'=>'Agent\'s related countries','mod'=>'agentsales'),$_smarty_tpl);?>

  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-info">This form allows to manage agent's related countries.</div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <h4><?php echo smartyTranslate(array('s'=>'Add/Edit country','mod'=>'agentsales'),$_smarty_tpl);?>
</h4>
      <button type="button" class="btn btn-primary" id="agentsalesCountryNew"><?php echo smartyTranslate(array('s'=>'New country','mod'=>'agentsales'),$_smarty_tpl);?>
</button>
      <div id="agentsalesCountryFormContainer" hidden>
      <?php echo $_smarty_tpl->getSubTemplate ('./agent_country_form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

      </div>
    </div>
    <div class="col-lg-8" id="">
      <h4><?php echo smartyTranslate(array('s'=>'Related countries','mod'=>'agentsales'),$_smarty_tpl);?>
</h4>
      <div id="agentsalesCountriesList"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
<!--
var id_customer = <?php echo $_smarty_tpl->tpl_vars['id_customer']->value;?>
;
var agentsalesCountriesControllerUrl = "<?php echo $_smarty_tpl->tpl_vars['agentsalescountries_controller_url']->value;?>
";
//-->
</script><?php }} ?>
