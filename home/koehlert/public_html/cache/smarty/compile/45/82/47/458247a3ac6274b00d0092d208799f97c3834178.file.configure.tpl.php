<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 12:54:38
         compiled from "/home/koehlert/public_html/modules/splrefgen/views/templates/admin/configure.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9634241795d5a7fee79c3f3-49819046%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '458247a3ac6274b00d0092d208799f97c3834178' => 
    array (
      0 => '/home/koehlert/public_html/modules/splrefgen/views/templates/admin/configure.tpl',
      1 => 1516880358,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9634241795d5a7fee79c3f3-49819046',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'module_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a7fee7abc51_45318933',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a7fee7abc51_45318933')) {function content_5d5a7fee7abc51_45318933($_smarty_tpl) {?>

<div class="panel" id="splref_container">
	<h3><?php echo smartyTranslate(array('s'=>'Supplier references'),$_smarty_tpl);?>
</h3>
	<textarea rows="20" id="splref_references"></textarea>
	<button type="button" id="splref_generate">Generate</button>
</div>
<div class="panel">
<table id="splref_progress" class="table table-condensed"></table>
</div>

<script type="text/javascript">
var progressTable = $('#splref_progress');
var refs = [];
$('#splref_container').on('click', '#splref_generate', function(){
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
splgen.php',
		method: 'POST',
		dataType: 'json',
		data: { ref:refs[genIndex] }
	})
	.fail(function( jqXHR, textStatus, errorThrown ) {
		progressTable.find('#row_'+genIndex).find('.splref_status').html(textStatus +', '+errorThrown);
		splrefGenerate(++genIndex);
	})
	.done(function(response, textStatus, jqXHR){
		progressTable.find('#row_'+genIndex).find('.splref_status').html(textStatus +', '+response.message);
		splrefGenerate(++genIndex);
	});
	
}
</script><?php }} ?>
