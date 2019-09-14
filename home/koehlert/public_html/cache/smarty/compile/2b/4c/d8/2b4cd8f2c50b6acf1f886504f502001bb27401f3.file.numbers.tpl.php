<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:44:02
         compiled from "/home/koehlert/public_html/modules/trackship/views/templates/admin/numbers.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7035125285d5964320a3d01-51629687%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b4cd8f2c50b6acf1f886504f502001bb27401f3' => 
    array (
      0 => '/home/koehlert/public_html/modules/trackship/views/templates/admin/numbers.tpl',
      1 => 1562768760,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7035125285d5964320a3d01-51629687',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_tracking_numbers' => 0,
    'number' => 0,
    'tab_access' => 0,
    'trackship_token' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5964320de682_40898361',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5964320de682_40898361')) {function content_5d5964320de682_40898361($_smarty_tpl) {?><div id="trackshipPanel" class="panel">
	<div class="panel-heading"><i class="icon-truck"></i> <?php echo smartyTranslate(array('s'=>'Shipping numbers','mod'=>'trackship'),$_smarty_tpl);?>
</div>
	<div class="panel-body">
	
	<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th><?php echo smartyTranslate(array('s'=>'Date','mod'=>'trackship'),$_smarty_tpl);?>
</th>
				<th><?php echo smartyTranslate(array('s'=>'Number','mod'=>'trackship'),$_smarty_tpl);?>
</th>
				<th><?php echo smartyTranslate(array('s'=>'Action','mod'=>'trackship'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
		<tbody>
		<?php  $_smarty_tpl->tpl_vars['number'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['number']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order_tracking_numbers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['number']->key => $_smarty_tpl->tpl_vars['number']->value) {
$_smarty_tpl->tpl_vars['number']->_loop = true;
?>
		<tr data-id="<?php echo $_smarty_tpl->tpl_vars['number']->value['id'];?>
">
			<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['number']->value['date_added'],'full'=>true),$_smarty_tpl);?>
</td>
			<td><a target="_blank" href="https://wwwapps.ups.com/WebTracking/track?track=yes&loc=de_DE&trackNums=<?php echo $_smarty_tpl->tpl_vars['number']->value['code'];?>
"><?php echo $_smarty_tpl->tpl_vars['number']->value['code'];?>
</a></td>
			<td>
            <?php if ($_smarty_tpl->tpl_vars['tab_access']->value['edit']=='1') {?>
            <button class="btn btn-danger btn-xs trackshipNumberRemove" data-id="<?php echo $_smarty_tpl->tpl_vars['number']->value['id'];?>
"><?php echo smartyTranslate(array('s'=>'Remove','mod'=>'trackship'),$_smarty_tpl);?>
</button>
            <?php }?>
            </td>
		</tr>
		<?php }
if (!$_smarty_tpl->tpl_vars['number']->_loop) {
?>
		<tr>
			<td colspan="10"><?php echo smartyTranslate(array('s'=>'No tracking numbers attached at the moment','mod'=>'trackship'),$_smarty_tpl);?>
</td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	</div>
	</div>
</div>

<script type="text/javascript">
$(function(){
	$('#trackshipPanel').on('click', 'button.trackshipNumberRemove', function(){
		if(!confirm("<?php echo smartyTranslate(array('s'=>'Confirm deleting?'),$_smarty_tpl);?>
")){
			return;
		}
		var params = { tkn: "<?php echo $_smarty_tpl->tpl_vars['trackship_token']->value;?>
", id: $(this).data('id') };
		$.ajax({
			url: "<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('trackship','numbers');?>
?action=remove",
			method: 'POST',
			dataType: 'json',
			data: params
		})
		.done(function(response){
			if(response.success){
				$('#trackshipPanel table tr[data-id="'+ response.id +'"]').remove();
			}
		});
	});
});
</script><?php }} ?>
