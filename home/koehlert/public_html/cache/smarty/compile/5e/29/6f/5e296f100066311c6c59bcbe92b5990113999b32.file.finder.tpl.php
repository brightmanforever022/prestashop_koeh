<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 13:59:16
         compiled from "/home/koehlert/public_html/modules/khlordadr/views/templates/admin/finder.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12309622445d5a8f143c5ef0-35195286%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5e296f100066311c6c59bcbe92b5990113999b32' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlordadr/views/templates/admin/finder.tpl',
      1 => 1562768754,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12309622445d5a8f143c5ef0-35195286',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'countries_list' => 0,
    'country' => 0,
    'module_adr_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a8f143fb670_59458361',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a8f143fb670_59458361')) {function content_5d5a8f143fb670_59458361($_smarty_tpl) {?><form method="get" class="defaultForm form-horizontal" id="khlordadr_form" action="">
<div class="panel">
	<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Search customers','mod'=>'khlordadr'),$_smarty_tpl);?>
</div>
	<div class="form-wrapper">
		<div class="form-group">
			<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Radius','mod'=>'khlordadr'),$_smarty_tpl);?>
</label>
			<div class="col-lg-9">
				<input type="text" name="radius"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Country'),$_smarty_tpl);?>
</label>
			<div class="col-lg-9">
				<select name="country">
				<?php  $_smarty_tpl->tpl_vars['country'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['country']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countries_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['country']->key => $_smarty_tpl->tpl_vars['country']->value) {
$_smarty_tpl->tpl_vars['country']->_loop = true;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['country']->value['id_country'];?>
"><?php echo $_smarty_tpl->tpl_vars['country']->value['name'];?>
</option>
				<?php } ?>
				</select>
				
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Start location','mod'=>'khlordadr'),$_smarty_tpl);?>
</label>
			<div class="col-lg-9">
				<input type="text" name="start"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Active customers only','mod'=>'khlordadr'),$_smarty_tpl);?>
</label>
			<div class="col-lg-9">
				<input type="checkbox" name="customer_active" value="1"/>
			</div>
		</div>

	</div>
	<div class="panel-footer">
		<button type="submit" name="save" class="btn btn-default pull-right"><?php echo smartyTranslate(array('s'=>'Search','mod'=>'khlordadr'),$_smarty_tpl);?>
</button>
	</div>
	
</div>
</form>
<div class="panel">
	<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Addresses','mod'=>'khlordadr'),$_smarty_tpl);?>
</div>

	<div class="panel-body" id="khlordadr_locations"></div>
</div>

<script type="text/javascript">

$(function(){
	$('#content').on('submit', '#khlordadr_form', function(event){
		event.preventDefault();
		$.ajax({
			url: "<?php echo $_smarty_tpl->tpl_vars['module_adr_url']->value;?>
&action=locations",
			dataType: 'html',
			data: $('#khlordadr_form').serialize(),
			beforeSend: function(){
				$('#khlordadr_locations').html('Loading...');
			}
		})
		.done(function(response){
			$('#khlordadr_locations').html(response);
		});
	});
	$('#khlordadr_locations').on('click', 'a.address_more', function(event){
		event.preventDefault();
		var addressId = $(this).attr('data-address_id');
		$.ajax({
			url: "<?php echo $_smarty_tpl->tpl_vars['module_adr_url']->value;?>
&action=customer_info",
			dataType: 'html',
			data: { id_address: addressId },
			beforeSend: function(){
				$('#address_id_'+addressId).append('<br><p>Loading...</p>');
			}
		})
		.done(function(response){
			//$('#khlordadr_locations').html();
			$('#address_id_'+addressId+' p').html(response);
		});
		return false;
	});
});



</script>

<?php }} ?>
