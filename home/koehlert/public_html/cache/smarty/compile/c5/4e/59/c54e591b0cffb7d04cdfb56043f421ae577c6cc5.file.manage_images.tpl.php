<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/manage_images.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6166615745d5a47a86eec31-84807532%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c54e591b0cffb7d04cdfb56043f421ae577c6cc5' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/manage_images.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6166615745d5a47a86eec31-84807532',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'style' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a870d5e7_42176484',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a870d5e7_42176484')) {function content_5d5a47a870d5e7_42176484($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;" class="images">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#manageImages') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;" class="images">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;" class="images">');
	} 
</script>
<?php }?>

	<h4><?php echo smartyTranslate(array('s'=>'Manage Images','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>

	<div class="form-group clearfix">
		<form id="upload-image-form" class="defaultForm" method="post" enctype="multipart/form-data" <?php if (isset($_smarty_tpl->tpl_vars['style']->value)) {?>style="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['style']->value);?>
"<?php }?>>
			<div class="form-inline">
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><?php echo smartyTranslate(array('s'=>'Upload image','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						<input class="form-control" type="file" name="upload_image"/>
					</div>
				</div>

				<div class="col-sm-2">
					<div class="input-group">
						<span class="input-group-addon"><?php echo smartyTranslate(array('s'=>'Width','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						<input class="form-control text-center" type="text" name="upload_image_width" id="upload-image-width" value="">
					</div>
				</div>

				<div class="col-sm-4">
					<a href="javascript:{}" id="upload-image" class="btn btn-default">
						<i class="icon icon-upload on-left"></i> <span><?php echo smartyTranslate(array('s'=>'Upload','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</a>
				</div>
			</div>
		</form>		
	</div>

	
	<div class="images-grid-box">
		<table id="images-list" class="table table-bordered images-list">
			<thead>
				<tr>
					<th class="preview" data-template="preview">&nbsp;</th>
					<th class="dimensions" data-template="dimensions"><?php echo smartyTranslate(array('s'=>'Dimensions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="size" data-field="size"><?php echo smartyTranslate(array('s'=>'Size','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>			
					<th class="date" data-field="date"><?php echo smartyTranslate(array('s'=>'Date Add','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
		</table>
	</div>
	<br>
</div><?php }} ?>
