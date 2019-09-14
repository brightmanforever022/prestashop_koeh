<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:44:02
         compiled from "/home/koehlert/public_html/modules/agentsales/views/templates/admin/display_admin_order_right.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19108940165d596432132391-39630354%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5561f98c9597826ca8e410c70505007366eb626f' => 
    array (
      0 => '/home/koehlert/public_html/modules/agentsales/views/templates/admin/display_admin_order_right.tpl',
      1 => 1536319122,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19108940165d596432132391-39630354',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'agents' => 0,
    'agent' => 0,
    'id_order' => 0,
    'agentsalesAgentsControllerUrl' => 0,
    'authenticated_owner_admin' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59643215fe68_74604144',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59643215fe68_74604144')) {function content_5d59643215fe68_74604144($_smarty_tpl) {?>
<div class="col-lg-12" id="agentsalesOrderToAgentContainer">
	<div class="panel">
		<div class="panel-heading">
			<?php echo smartyTranslate(array('s'=>'Associate order with agent','mod'=>'agentsales'),$_smarty_tpl);?>

		</div>
		<div class="">
		<div id="agentsalesOrderToAgentMessages"></div>
		<form action="" method="post" id="agentsalesOrderToAgentForm" class="form-inline">
			<input type="hidden" name="id_agent[]" value="0">
			<div class="form-group" style="height:300px;overflow-y:auto;">
			<?php  $_smarty_tpl->tpl_vars['agent'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['agent']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['agents']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['agent']->key => $_smarty_tpl->tpl_vars['agent']->value) {
$_smarty_tpl->tpl_vars['agent']->_loop = true;
?>
			<label>
				<input name="id_agent[]" value="<?php echo $_smarty_tpl->tpl_vars['agent']->value['id_customer'];?>
" <?php if ($_smarty_tpl->tpl_vars['agent']->value['selected']) {?>checked="checked"<?php }?> 
				<?php if (!$_smarty_tpl->tpl_vars['agent']->value['editable']) {?>disabled<?php }?> type="checkbox">
				<?php echo $_smarty_tpl->tpl_vars['agent']->value['lastname'];?>
 <?php echo $_smarty_tpl->tpl_vars['agent']->value['firstname'];?>
 (<?php echo $_smarty_tpl->tpl_vars['agent']->value['company'];?>
)
			</label><br>
			<?php } ?>
			</div>
			<input type="hidden" name="id_order" value="<?php echo $_smarty_tpl->tpl_vars['id_order']->value;?>
">

			<button class="btn btn-primary" type="submit"><?php echo smartyTranslate(array('s'=>'Save'),$_smarty_tpl);?>
</button>
		</form>
		</div>
	</div>
</div>
<script type="text/javascript">
var agentsalesAgentsControllerUrl = "<?php echo $_smarty_tpl->tpl_vars['agentsalesAgentsControllerUrl']->value;?>
";
var authenticatedOwnerAdmin = <?php echo $_smarty_tpl->tpl_vars['authenticated_owner_admin']->value;?>
;
$(function(){
	$('#agentsalesOrderToAgentContainer').on('click', 'input[name="id_agent[]"]', function(){
		if(!authenticatedOwnerAdmin){
			var chckdCnt = $('input[name="id_agent[]"]:checked').length;
			var confirmText = 'You are already assigned to one other commisions in this order. '+
				'Do you want to remove the other option so you can add a new one?';
			if((chckdCnt > 1) && confirm(confirmText)){
				event.preventDefault();
				return false;
			}
			else{
				return true;
			}
		}
	});
	$('#agentsalesOrderToAgentContainer').on('submit', '#agentsalesOrderToAgentForm', function(event){
		event.preventDefault();
		
		$('#agentsalesOrderToAgentMessages').empty();
		$('#agentsalesOrderToAgentMessages').html(
			'<div class="alert alert-info">Loading...</div>'
		);

		$.ajax({
			url: agentsalesAgentsControllerUrl +'&action=save_order_agent',
			method: 'post',
			dataType: 'json',
			data: $('#agentsalesOrderToAgentForm').serialize()
		})
		.done(function(response){
			if(response.success){
				$('#agentsalesOrderToAgentMessages').html(
					'<div class="alert alert-success">'+ response.message +'</div>'
				);
				$('#agentsalesOrderToAgentForm input').removeAttr('checked').removeProp('checked');
				for( var i in response.data.sales ){
					$('#agentsalesOrderToAgentForm input[value="'+ response.data.sales[i].id_agent +'"]')
						.attr('checked', 'checked');
				}
			}
			else{
				$('#agentsalesOrderToAgentMessages').html(
					'<div class="alert alert-danger">'+ response.message +'</div>'
				);
			}
		});
	});
});

</script><?php }} ?>
