<?php /* Smarty version Smarty-3.1.19, created on 2019-08-22 13:16:53
         compiled from "/home/koehlert/public_html/modules/transphotos/views/templates/admin/configure.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19759755075d5e79a5455a30-62723406%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4fa75c780de6db85b62bf4c2c073a08b34bb1168' => 
    array (
      0 => '/home/koehlert/public_html/modules/transphotos/views/templates/admin/configure.tpl',
      1 => 1520332245,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19759755075d5e79a5455a30-62723406',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'services' => 0,
    'srvKey' => 0,
    'module_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5e79a547dc01_04333349',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5e79a547dc01_04333349')) {function content_5d5e79a547dc01_04333349($_smarty_tpl) {?>

<div class="panel" id="splref_container">
	<h4>Server</h4>
	<select id="splref_server">
	<?php  $_smarty_tpl->tpl_vars['srvUrl'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['srvUrl']->_loop = false;
 $_smarty_tpl->tpl_vars['srvKey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['services']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['srvUrl']->key => $_smarty_tpl->tpl_vars['srvUrl']->value) {
$_smarty_tpl->tpl_vars['srvUrl']->_loop = true;
 $_smarty_tpl->tpl_vars['srvKey']->value = $_smarty_tpl->tpl_vars['srvUrl']->key;
?>
	<option value="<?php echo $_smarty_tpl->tpl_vars['srvKey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['srvKey']->value;?>
</option>
	<?php } ?>
	</select>
	<h4><?php echo smartyTranslate(array('s'=>'Supplier references'),$_smarty_tpl);?>
</h4>
	<textarea rows="20" id="splref_references"></textarea>
	<button type="button" id="splref_generate">Generate</button>
</div>
<div class="panel">
<table id="splref_progress" class="table table-condensed"></table>
</div>

<script type="text/javascript">
var progressTable = $('#splref_progress');
var refs = [];
$('#splref_container').delegate('#splref_generate', 'click', function(){
	var refsTmp = $('#splref_references').val().split("\n");
	refs = [];
	//genIndex = 0;
	for(var ri = 0; ri < refsTmp.length; ri++){
		refsTmp[ri] = refsTmp[ri].trim();
		if(refsTmp[ri].length <= 0){
			continue;
		}
		refs.push(refsTmp[ri]);
	}
	progressTable.empty();
	for(var ri = 0; ri < refs.length; ri++){
		var row = $('<tr/>');
		row.attr('id', 'row_'+ri)
			.append('<td class="splref_name">'+ refs[ri] +'</td><td class="splref_status">waiting</td>');
		progressTable.append(row);
	}
	splrefGenerate(0);
});
function splrefGenerate(genIndex){
	if(genIndex > (refs.length-1)){
		return;
	}
	$.ajax({
		url: '<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
export.php',
		type: 'POST',
		dataType: 'json',
		data: { ref:refs[genIndex], server: $('#splref_server').val() },
		success: function(response, textStatus, jqXHR){
			progressTable.find('#row_'+genIndex).find('.splref_status').html(textStatus +', '+response.message);
			splrefGenerate(++genIndex);
		},
		error: function( jqXHR, textStatus, errorThrown ) {
			progressTable.find('#row_'+genIndex).find('.splref_status').html(textStatus +', '+errorThrown);
			splrefGenerate(++genIndex);
		}
	});
	
;
	
}
</script><?php }} ?>
