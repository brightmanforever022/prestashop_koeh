<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/tutorials.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5205293165d5a47a8baf5b6-60413713%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb054b7dc9c493531e6b46cd28efeb1a1737b162' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/tutorials.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5205293165d5a47a8baf5b6-60413713',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'tutorial_link' => 0,
    'module_img_path' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8bdcbb3_58560893',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8bdcbb3_58560893')) {function content_5d5a47a8bdcbb3_58560893($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#tutorials') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">');
	} 
</script>
<?php }?>
	<h4><?php echo smartyTranslate(array('s'=>'Tutorials','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>
	<div>
		<div class="clearfix tutorial-video">
			<a class="tutorial-button" href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['tutorial_link']->value);?>
" target="_blank">
				<img class="tutorial-img" src="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['module_img_path']->value);?>
full.jpg">
			</a>
			<div class="description">
				<h4><?php echo smartyTranslate(array('s'=>'How to','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
				<div class="separation"></div>

				<p> <?php echo smartyTranslate(array('s'=>'Create a custom template with Newsletter Pro.','mod'=>'newsletterpro'),$_smarty_tpl);?>
 </p>
				<p> <?php echo smartyTranslate(array('s'=>'Insert selected products into template.','mod'=>'newsletterpro'),$_smarty_tpl);?>
 </p>
				<p> <?php echo smartyTranslate(array('s'=>'Upload and add images into template.','mod'=>'newsletterpro'),$_smarty_tpl);?>
 </p>
				<p> <?php echo smartyTranslate(array('s'=>'Select the customers with filters and then send newsletters.','mod'=>'newsletterpro'),$_smarty_tpl);?>
 </p>
				<p> <?php echo smartyTranslate(array('s'=>'Select the customers with filters and then schedule multiple tasks.','mod'=>'newsletterpro'),$_smarty_tpl);?>
 </p>
				<p> <?php echo smartyTranslate(array('s'=>'View newsletter history.','mod'=>'newsletterpro'),$_smarty_tpl);?>
 </p>
				<p> <?php echo smartyTranslate(array('s'=>'Newsletter Statistics. View top 100 clicked products.','mod'=>'newsletterpro'),$_smarty_tpl);?>
 </p>
				<p> <?php echo smartyTranslate(array('s'=>'Setup the newsletter statistics for Google Analytics.','mod'=>'newsletterpro'),$_smarty_tpl);?>

				<p> <?php echo smartyTranslate(array('s'=>'Create multiple SMTP configurations (Gmail, Mailjet, Mandrill, ...)','mod'=>'newsletterpro'),$_smarty_tpl);?>

				<p> <?php echo smartyTranslate(array('s'=>'Mail Chimp synchronization. (The Customers, Visitors and Personal list)','mod'=>'newsletterpro'),$_smarty_tpl);?>

				<p> <?php echo smartyTranslate(array('s'=>'Import & Export templates from Mail Chimp.','mod'=>'newsletterpro'),$_smarty_tpl);?>

				<p> <?php echo smartyTranslate(array('s'=>'Change template appearance using CSS style.','mod'=>'newsletterpro'),$_smarty_tpl);?>

				<p> <?php echo smartyTranslate(array('s'=>'Import email addresses from a CSV file.','mod'=>'newsletterpro'),$_smarty_tpl);?>

				<p> <?php echo smartyTranslate(array('s'=>'Allow customers to subscribe at multiple categories.','mod'=>'newsletterpro'),$_smarty_tpl);?>

				<p> <?php echo smartyTranslate(array('s'=>'The power of dynamic variables.','mod'=>'newsletterpro'),$_smarty_tpl);?>

				<p> <?php echo smartyTranslate(array('s'=>'Create new variables related to the customers.','mod'=>'newsletterpro'),$_smarty_tpl);?>

				<p> <?php echo smartyTranslate(array('s'=>'Select the new products.','mod'=>'newsletterpro'),$_smarty_tpl);?>

				<p> <?php echo smartyTranslate(array('s'=>'Preview the products on multiple templates in real time.','mod'=>'newsletterpro'),$_smarty_tpl);?>

			</div>
		</div>
	</div>
</div><?php }} ?>
