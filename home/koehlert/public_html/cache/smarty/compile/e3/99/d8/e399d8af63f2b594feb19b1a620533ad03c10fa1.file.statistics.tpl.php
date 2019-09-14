<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/statistics.tpl" */ ?>
<?php /*%%SmartyHeaderCode:58289855d5a47a896d108-63559167%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e399d8af63f2b594feb19b1a620533ad03c10fa1' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/statistics.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '58289855d5a47a896d108-63559167',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8986972_31192256',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8986972_31192256')) {function content_5d5a47a8986972_31192256($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#statistics') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">');
	} 
</script>
<?php }?>
	<h4><?php echo smartyTranslate(array('s'=>'Statistics','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>
	<div style="margin-bottom: 5px;">
		<h4 style="float: left;"><?php echo smartyTranslate(array('s'=>'Top clicked products from the newsletter','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
		<a  href="javascript:{}" id="clear-statistics" class="btn btn-default pull-right">
			<i class="icon icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Clear Statistics','mod'=>'newsletterpro'),$_smarty_tpl);?>

		</a>
		<div class="clear"></div>
		<div class="separation"></div>
	</div>
	<table id="statistics-table" class="table table-bordered statistics-table">
		<thead>
			<tr>
				<th class="top" data-field="top"><?php echo smartyTranslate(array('s'=>'Top','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="clicks" data-field="clicks"><?php echo smartyTranslate(array('s'=>'Clicks','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="image" data-template="image"><?php echo smartyTranslate(array('s'=>'Image','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="name" data-field="name"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				<th class="price_display" data-field="price_display"><?php echo smartyTranslate(array('s'=>'Price','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
	</table>
	<br>
</div><?php }} ?>
