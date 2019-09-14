<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/create_template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3974390935d5a47a87a85f8-94611541%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9df8445ae9053913099a08086d1dd82dd7747018' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/create_template.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3974390935d5a47a87a85f8-94611541',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'module_img_path' => 0,
    'newsletter_template' => 0,
    'id_lang' => 0,
    'title' => 0,
    'default_lang' => 0,
    'header' => 0,
    'footer' => 0,
    'page_link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8822c27_08135343',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8822c27_08135343')) {function content_5d5a47a8822c27_08135343($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#createTemplate') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="display: none;">');
	} 
</script>
<?php }?>

	<h4 style="float: left;"><?php echo smartyTranslate(array('s'=>'Create newsletter template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<a id="newsletter_help" href="javascript:{}" class="btn btn-default newsletter-help" onclick="NewsletterProControllers.TemplateController.showNewsletterHelp();"><i class="icon icon-eye"></i> <?php echo smartyTranslate(array('s'=>'View available variables','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
	<a href="javascript:{}" id="chimp-import-html" class="btn btn-default chimp-import-html" style="float: right; margin-right: 10px; display: none;"><img src="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['module_img_path']->value);?>
chimp16.png"><span><?php echo smartyTranslate(array('s'=>'Import from Mail Chimp','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></a>
	<div class="clear"></div>
	<div class="separation"></div>

	<div class="data-grid-div">
		<table id="newsletter-template-list" class="table table-bordered newsletter-template-list">
			<thead>
				<tr>
					<th class="name" data-field="name"><?php echo smartyTranslate(array('s'=>'Template Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="date" data-field="date"><?php echo smartyTranslate(array('s'=>'Date Modified','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="attachment" data-template="attachment"><?php echo smartyTranslate(array('s'=>'Attachment','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
					<th class="actions" data-template="actions"><?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
		</table>
	</div>

	<br>
	<div>
		<h4><?php echo smartyTranslate(array('s'=>'Template adjustments','mod'=>'newsletterpro'),$_smarty_tpl);?>
:</h4>
		<div class="separation"></div>

		<p class="help-block" style="width: auto;"><?php echo smartyTranslate(array('s'=>'The responsive templates are not adjustable, because the responsive layout can be damaged by the adjustments. You can adjust them by changing the CSS and HTML.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
		<div class="template-settings">
			<div class="ts-left">
				<div id="slider-container" class="slider-container" style="display: none;">
					<label><?php echo smartyTranslate(array('s'=>'Template width:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
					<div id="template-width-slider"></div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="ts-right">

				<div class="color-container">
					<div style="display: none;">
						<label><?php echo smartyTranslate(array('s'=>'Template bg color:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
						<div class="clear" style="margin-bottom: 6px;"></div>
						<input id="template-container-color" class="gk-color" value="FFFFFF">
					</div>

					<div style="display: none;">
						<label><?php echo smartyTranslate(array('s'=>'Content bg color:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
						<div class="clear" style="margin-bottom: 6px;"></div>
						<input id="template-content-color" class="gk-color" value="FFFFFF">
					</div>

					<div>
						<label><?php echo smartyTranslate(array('s'=>'All links color:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
						<div class="clear" style="margin-bottom: 6px;"></div>
						<input id="links-color" class="gk-color" value="FFFFFF">
					</div>
				</div>

				<div class="color-container">
					<div style="display: none;">
						<label><?php echo smartyTranslate(array('s'=>'Products bg color:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
						<div class="clear" style="margin-bottom: 6px;"></div>
						<input id="products-bg-color" class="gk-color" value="FFFFFF">
					</div>

					<div style="display: none;">
						<label><?php echo smartyTranslate(array('s'=>'Products name color:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
						<div class="clear" style="margin-bottom: 6px;"></div>
						<input id="products-name-color" class="gk-color" value="FFFFFF">
					</div>

					<div style="display: none;">
						<label><?php echo smartyTranslate(array('s'=>'Description color:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
						<div class="clear" style="margin-bottom: 6px;"></div>
						<input id="products-description-color" class="gk-color" value="FFFFFF">
					</div>
				</div>

				<div class="color-container">
					<div style="display: none;">
						<label><?php echo smartyTranslate(array('s'=>'Products border color:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
						<div class="clear" style="margin-bottom: 6px;"></div>
						<input id="products-border-color" class="gk-color" value="FFFFFF">
					</div>

					<div style="display: none;">
						<label><?php echo smartyTranslate(array('s'=>'Short description color:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
						<div class="clear" style="margin-bottom: 6px;"></div>
						<input id="products-s-description-color" class="gk-color" value="FFFFFF">
					</div>

					<div style="display: none;">
						<label><?php echo smartyTranslate(array('s'=>'Price color:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
						<div class="clear" style="margin-bottom: 6px;"></div>
						<input id="products-price-color" class="gk-color" value="FFFFFF">
					</div>
				</div>

				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="newsletter-template-div">
		<div class="clearfix">
			<div class="col-sm-1">
				<label class="control-label">
					<span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Title','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
				</label>			
			</div>
			<div class="col-sm-11">
				
				<div class="form-inline">
					<div class="form-group">
						<?php  $_smarty_tpl->tpl_vars['title'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['title']->_loop = false;
 $_smarty_tpl->tpl_vars['id_lang'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['newsletter_template']->value['title']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['title']->key => $_smarty_tpl->tpl_vars['title']->value) {
$_smarty_tpl->tpl_vars['title']->_loop = true;
 $_smarty_tpl->tpl_vars['id_lang']->value = $_smarty_tpl->tpl_vars['title']->key;
?>
							<input id="page-title-<?php echo intval($_smarty_tpl->tpl_vars['id_lang']->value);?>
" data-lang="<?php echo intval($_smarty_tpl->tpl_vars['id_lang']->value);?>
" class="form-control pull-left fixed-width-xxl" type="text" name="page_title" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8', true);?>
" style="<?php if ($_smarty_tpl->tpl_vars['id_lang']->value==$_smarty_tpl->tpl_vars['default_lang']->value) {?>display: block;<?php } else { ?>display: none;<?php }?>"/>
						<?php } ?>
					</div>
					<div class="form-group">
						<div class="gk_lang_select"></div>
					</div>
					<div class="form-group">
						<span id="page-title-message">&nbsp;</span>
					</div>
				</div>
			</div>
		</div>

		<div id="newsletter-template" style="display: inline-block;">
			<p class="help-block"><?php echo smartyTranslate(array('s'=>'Press the help button in the upper right corner to see full list of available variables.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
			
			<div id="newsletter-template-content" class="form-group clearfix">
				<div class="form-inline">
					<div class="form-group">
						<div id="tab_template" class="newsletter-template">
							<a id="tab_newsletter-template_0" href="#createTemplate" class="btn btn-default first_item"><i class="icon icon-edit"></i> <?php echo smartyTranslate(array('s'=>'Edit','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
							<a id="tab_newsletter-template_1" href="#createTemplate" class="btn btn-default item"><i class="icon icon-eye"></i> <?php echo smartyTranslate(array('s'=>'View','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
							<a id="tab_newsletter-template_3" href="#createTemplate" class="btn btn-default item"><i class="icon icon-code"></i> <?php echo smartyTranslate(array('s'=>'Header','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
							<a id="tab_newsletter-template_4" href="#createTemplate" class="btn btn-default item"><i class="icon icon-code"></i> <?php echo smartyTranslate(array('s'=>'Footer','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
							<a id="tab_newsletter-template_5" href="#createTemplate" class="btn btn-default item"><i class="icon icon-code"></i> <?php echo smartyTranslate(array('s'=>'CSS Style','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
							<a id="tab_newsletter-template_2" href="#createTemplate" class="btn btn-default last_item tab-global-css"><i class="icon icon-code"></i> <?php echo smartyTranslate(array('s'=>'Global CSS ( for all templates )','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
						</div>
					</div>
					<div class="form-group pull-right">
						<div id="newsletter-template-lang-select" class="gk_lang_select"></div>
					</div>
					<div class="form-group pull-right btn-margin">
						<a id="np-view-newsletter-template-in-browser" href="javascript:{}" target="_blank" class="btn btn-default item"><i class="icon icon-eye"></i> <?php echo smartyTranslate(array('s'=>'View in Browser','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
					</div>
				</div>

				<div id="tab_template_content" class="newsletter-template clearfix">
					<div id="tab_content_newsletter-template_0">

						<?php echo $_smarty_tpl->getSubTemplate ((((string)$_smarty_tpl->tpl_vars['tpl_location']->value)).("templates/admin/textarea_multilang_template.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('class_name'=>'newsletter_rte','config'=>'newsletter_config','content_name'=>'newsletter_content','input_name'=>"newsletter_template_text",'input_value'=>$_smarty_tpl->tpl_vars['newsletter_template']->value['body'],'content_css'=>$_smarty_tpl->tpl_vars['newsletter_template']->value['css_link'],'init_callback'=>'NewsletterPro.modules.createTemplate.initTinyCallback'), 0);?>

					</div>
					<div id="tab_content_newsletter-template_1" style="display: none;">
						<div class="view-content">
							<iframe id="view-newsletter-template-content" style="display: block; vertical-align: top;" scrolling="no" src="about:blank" class="view-newsletter-template-content"> </iframe>
							<div class="clear"></div>
						</div>
					</div>
					<div id="tab_content_newsletter-template_2" style="display: none;">
						<textarea id="template-css" class="template-css" wrap="off" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['newsletter_template']->value['css_global_file'][$_smarty_tpl->tpl_vars['default_lang']->value], ENT_QUOTES, 'UTF-8', true);?>
</textarea>
					</div>
					<div id="tab_content_newsletter-template_3" style="display: none;">
						<?php  $_smarty_tpl->tpl_vars['header'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['header']->_loop = false;
 $_smarty_tpl->tpl_vars['id_lang'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['newsletter_template']->value['header']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['header']->key => $_smarty_tpl->tpl_vars['header']->value) {
$_smarty_tpl->tpl_vars['header']->_loop = true;
 $_smarty_tpl->tpl_vars['id_lang']->value = $_smarty_tpl->tpl_vars['header']->key;
?>
							<textarea id="template-header-<?php echo intval($_smarty_tpl->tpl_vars['id_lang']->value);?>
" data-lang="<?php echo intval($_smarty_tpl->tpl_vars['id_lang']->value);?>
" class="template-header" wrap="off" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="<?php if ($_smarty_tpl->tpl_vars['id_lang']->value==$_smarty_tpl->tpl_vars['default_lang']->value) {?>display: block;<?php } else { ?>display: none;<?php }?>"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['header']->value, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
						<?php } ?>
					</div>
					<div id="tab_content_newsletter-template_4" style="display: none;">
						<?php  $_smarty_tpl->tpl_vars['footer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['footer']->_loop = false;
 $_smarty_tpl->tpl_vars['id_lang'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['newsletter_template']->value['footer']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['footer']->key => $_smarty_tpl->tpl_vars['footer']->value) {
$_smarty_tpl->tpl_vars['footer']->_loop = true;
 $_smarty_tpl->tpl_vars['id_lang']->value = $_smarty_tpl->tpl_vars['footer']->key;
?>
							<textarea id="template-footer-<?php echo intval($_smarty_tpl->tpl_vars['id_lang']->value);?>
" data-lang="<?php echo intval($_smarty_tpl->tpl_vars['id_lang']->value);?>
" class="template-footer" wrap="off" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" style="<?php if ($_smarty_tpl->tpl_vars['id_lang']->value==$_smarty_tpl->tpl_vars['default_lang']->value) {?>display: block;<?php } else { ?>display: none;<?php }?>"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['footer']->value, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
						<?php } ?>
					</div>
					<div id="tab_content_newsletter-template_5" style="display: none;">
						<textarea id="template-css-style" class="template-css-style" wrap="off" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['newsletter_template']->value['css_file'][$_smarty_tpl->tpl_vars['default_lang']->value], ENT_QUOTES, 'UTF-8', true);?>
</textarea>
					</div>
				</div>
			</div>

			<div class="form-group clearfix">
				<div class="col-sm-4">
					<div id="save-newsletter-template-message" style="display: none;">&nbsp;</div>
				</div>
				
				<div class="col-sm-8">
					<a id="save-newsletter-template" href="javascript:{}" class="btn btn-default pull-right btn-margin">
						<span class="btn-ajax-loader"></span>
						<i class="icon icon-save"></i> <span><?php echo smartyTranslate(array('s'=>'Save','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</a>

					<a id="save-as-newsletter-template" href="javascript:{}" class="btn btn-default pull-right btn-margin">
						<span class="btn-ajax-loader"></span>
						<i class="icon icon-save"></i> <span><?php echo smartyTranslate(array('s'=>'Save As','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</a>

					<form id="inputImportHTMLForm" class="defaultForm" action="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['page_link']->value);?>
#createTemplate" method="post" enctype="multipart/form-data">
						<div class="fileUpload btn btn-default pull-right btn-margin" style="margin-left: 2px; margin-right: 2px; margin-top: 0; margin-bottom: 0;">
							<i class="icon icon-upload"></i> <span><?php echo smartyTranslate(array('s'=>'Import HTML','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
							<input id="inputImportHTML" type="file" name="inputImportHTML" class="upload">
						</div>
					</form>

					<a id="export-html" href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['page_link']->value);?>
&exportHTML#createTemplate" class="btn btn-default pull-right btn-margin">
					<i class="icon icon-download"></i> <span><?php echo smartyTranslate(array('s'=>'Export HTML','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</a>				

					<a id="chimp-export-html" href="javascript:{}" class="btn btn-default pull-right btn-margin">
						<i class="icon icon-download"></i> <span><?php echo smartyTranslate(array('s'=>'Export to Mail Chimp','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
					</a>
				</div>
			</div>

			<a id="setp1" href="#selectProducts" class="btn btn-primary pull-left  btn-margin" onclick="NewsletterProControllers.NavigationController.goToStep( 3 );">
				<span>&laquo; <?php echo smartyTranslate(array('s'=>'Previous Step','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
			</a>
			<a id="setp2" href="#sendNewsletters" class="btn btn-primary pull-right btn-margin" onclick="NewsletterProControllers.NavigationController.goToStep( 5 );">
				<span><?php echo smartyTranslate(array('s'=>'Next Step','mod'=>'newsletterpro'),$_smarty_tpl);?>
 &raquo;</span>
			</a>
		</div>
	</div>
</div><?php }} ?>
