<?php /* Smarty version Smarty-3.1.19, created on 2019-08-20 10:31:24
         compiled from "/home/koehlert/public_html/modules/khlbasic/views/templates/admin/salesstats/filter_form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9067065835d5bafdc814f48-61842486%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '095f9450d565fddbbbc989bd2332fe3714fed19d' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlbasic/views/templates/admin/salesstats/filter_form.tpl',
      1 => 1545908276,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9067065835d5bafdc814f48-61842486',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'countries_list' => 0,
    'agents_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5bafdc81fae0_86681758',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5bafdc81fae0_86681758')) {function content_5d5bafdc81fae0_86681758($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/home/koehlert/public_html/tools/smarty/plugins/function.html_options.php';
?><div class="row">
  <div class="col-md-2">
    <label for="customer_name" class=""><?php echo smartyTranslate(array('s'=>'Customer name'),$_smarty_tpl);?>
</label>
    <div>
    	<input name="customer_name" type="text" class="form-control" id="customer_name" >
    </div>
  </div>
  <div class="col-md-2">
    <label for="company_name"><?php echo smartyTranslate(array('s'=>'Company'),$_smarty_tpl);?>
</label>
    <div>
    <input name="company_name" type="text" class="form-control" id="company_name">
    </div>
  </div>
  <div class="col-md-2">
    <label for="country_id"><?php echo smartyTranslate(array('s'=>'Country'),$_smarty_tpl);?>
</label>
    <div>
    <?php echo smarty_function_html_options(array('name'=>'country_id[]','id'=>'country_id','options'=>$_smarty_tpl->tpl_vars['countries_list']->value,'multiple'=>'multiple'),$_smarty_tpl);?>

    </div>
  </div>
  <div class="col-md-2">
    <label for="agent_id"><?php echo smartyTranslate(array('s'=>'Agent'),$_smarty_tpl);?>
</label>
    <div>
    <?php echo smarty_function_html_options(array('name'=>'agent_id[]','id'=>'agent_id','options'=>$_smarty_tpl->tpl_vars['agents_list']->value,'multiple'=>'multiple'),$_smarty_tpl);?>

    </div>
  </div>

  <div class="col-md-1">
  	<label class="">&nbsp;</label>
  	<div>
  	<button type="submit" class="btn btn-default" id="khlSaleStatsFilter"><?php echo smartyTranslate(array('s'=>'Filter'),$_smarty_tpl);?>
</button>
  	</div>
  </div>
</div>			
<?php }} ?>
