<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 11:16:48
         compiled from "/home/koehlert/public_html/modules/khlexclusivity//views/templates/admin/details_customer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19779444735d5a6900f04962-69627899%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e41c8e028329917d1465fda2508f67add208ce63' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlexclusivity//views/templates/admin/details_customer.tpl',
      1 => 1538656764,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19779444735d5a6900f04962-69627899',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'exclusivity' => 0,
    'exclusivity_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a6900f2c652_26898676',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a6900f2c652_26898676')) {function content_5d5a6900f2c652_26898676($_smarty_tpl) {?><div class="col-lg-12">
<div class="panel">
	<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Exclusivity'),$_smarty_tpl);?>
</div>
	<div class="panel-body">
<?php if (isset($_smarty_tpl->tpl_vars['exclusivity']->value)) {?>
	<h2><?php echo smartyTranslate(array('s'=>'Requiremnts Satisfied'),$_smarty_tpl);?>
: 
		<?php if ($_smarty_tpl->tpl_vars['exclusivity']->value->areRequirementsSatisfied()) {?>
		<span class="label label-success"><?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
</span>
		<?php } else { ?>
		<span class="label label-danger"><?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
</span>
		<?php }?>
	</h2> 

	<dl class="dl-horizontal">
		<dt><?php echo smartyTranslate(array('s'=>'Radius'),$_smarty_tpl);?>
</dt>
		<dd><?php echo $_smarty_tpl->tpl_vars['exclusivity']->value->radius;?>
</dd>
		
		<dt><?php echo smartyTranslate(array('s'=>'Amount to order in period'),$_smarty_tpl);?>
</dt>
		<dd><?php echo $_smarty_tpl->tpl_vars['exclusivity']->value->amount;?>
</dd>
		
		<dt><?php echo smartyTranslate(array('s'=>'Amount should be ordered'),$_smarty_tpl);?>
</dt>
		<dd><?php echo $_smarty_tpl->tpl_vars['exclusivity']->value->getAmountShouldBeOrdered();?>
</dd>

		<dt><?php echo smartyTranslate(array('s'=>'Amount ordered to date'),$_smarty_tpl);?>
</dt>
		<dd><?php echo $_smarty_tpl->tpl_vars['exclusivity']->value->getAmountOrdered();?>
</dd>

		<dt><?php echo smartyTranslate(array('s'=>'Date start'),$_smarty_tpl);?>
</dt>
		<dd><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['exclusivity']->value->date_start),$_smarty_tpl);?>
</dd>
		<dt><?php echo smartyTranslate(array('s'=>'Date end'),$_smarty_tpl);?>
</dt>
		<dd><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['exclusivity']->value->date_end),$_smarty_tpl);?>
</dd>
	</dl>
<?php } else { ?>

<a href="<?php echo $_smarty_tpl->tpl_vars['exclusivity_url']->value;?>
" class="btn btn-default"><?php echo smartyTranslate(array('s'=>'Create exclusivity'),$_smarty_tpl);?>
</a>

<?php }?>
	</div>
</div>
</div>
<?php }} ?>
