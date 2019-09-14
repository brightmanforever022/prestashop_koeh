<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 16:41:22
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/footer-module.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7185712595d5ffb120de8c1-99145874%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3161c74af481045f53613b79a348b82d14f0c6bd' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/footer-module.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7185712595d5ffb120de8c1-99145874',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tab_select' => 0,
    'link' => 0,
    'tab_configure' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ffb121299e8_68798320',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ffb121299e8_68798320')) {function content_5d5ffb121299e8_68798320($_smarty_tpl) {?>
<div class="row" id="ta-footer-module">
<h3><?php echo smartyTranslate(array('s'=>'Read before using','mod'=>'tacartreminder'),$_smarty_tpl);?>
</h3>
<div class="col-lg-12">
	<div class="col-xs-5 col-lg-2 col-sm-2 block-logo">
		<img src="../modules/tacartreminder/views/img/logo57x57.png"/>
	</div>
	<div class="col-xs-7 col-lg-10 col-sm-10">
		<?php if (isset($_smarty_tpl->tpl_vars['tab_select']->value)&&$_smarty_tpl->tpl_vars['tab_select']->value=='running') {?>
			<a href="#" class="btn btn-default ta-help-fancy ta-help-page"  href="javascript:;"data-fancybox-href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminLiveCartReminder'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&helppage=steps-running&submitAction=showHelp" title="<?php echo smartyTranslate(array('s'=>'Help for this page','mod'=>'tacartreminder'),$_smarty_tpl);?>
"><img src="../modules/tacartreminder/views/img/helppage.png"/></a>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['tab_select']->value)&&$_smarty_tpl->tpl_vars['tab_select']->value=='cart') {?>
			<a href="#" class="btn btn-default ta-help-fancy ta-help-page"  href="javascript:;"data-fancybox-href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminLiveCartReminder'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&helppage=steps-cart&submitAction=showHelp&tab_select=running" title="<?php echo smartyTranslate(array('s'=>'Help for this page','mod'=>'tacartreminder'),$_smarty_tpl);?>
"><img src="../modules/tacartreminder/views/img/helppage.png"/></a>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['tab_select']->value)&&$_smarty_tpl->tpl_vars['tab_select']->value=='finished') {?>
			<a href="#" class="btn btn-default ta-help-fancy ta-help-page"  href="javascript:;"data-fancybox-href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminLiveCartReminder'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&helppage=steps-finished&tab_select=finished&submitAction=showHelp" title="<?php echo smartyTranslate(array('s'=>'Help for this page','mod'=>'tacartreminder'),$_smarty_tpl);?>
"><img src="../modules/tacartreminder/views/img/helppage.png"/></a>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['tab_select']->value)&&$_smarty_tpl->tpl_vars['tab_select']->value=='manual') {?>
			<a href="#" class="btn btn-default ta-help-fancy ta-help-page"  href="javascript:;"data-fancybox-href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminLiveCartReminder'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&helppage=steps-manual&tab_select=manual&submitAction=showHelp" title="<?php echo smartyTranslate(array('s'=>'Help for this page','mod'=>'tacartreminder'),$_smarty_tpl);?>
"><img src="../modules/tacartreminder/views/img/helppage.png"/></a>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['tab_select']->value)&&$_smarty_tpl->tpl_vars['tab_select']->value=='unsubscribes') {?>
			<a href="#" class="btn btn-default ta-help-fancy ta-help-page"  href="javascript:;"data-fancybox-href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminLiveCartReminder'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&helppage=unsubscribes&tab_select=unsubscribes&submitAction=showHelp" title="<?php echo smartyTranslate(array('s'=>'Help for this page','mod'=>'tacartreminder'),$_smarty_tpl);?>
"><img src="../modules/tacartreminder/views/img/helppage.png"/></a>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['tab_configure']->value)&&$_smarty_tpl->tpl_vars['tab_configure']->value=='configuration') {?>
			<a href="#" class="btn btn-default ta-help-fancy ta-help-page"  href="javascript:;"data-fancybox-href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminLiveCartReminder'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&helppage=configuration&tab_select=configuration&submitAction=showHelp" title="<?php echo smartyTranslate(array('s'=>'Help for this page','mod'=>'tacartreminder'),$_smarty_tpl);?>
"><img src="../modules/tacartreminder/views/img/helppage.png"/></a>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['tab_configure']->value)&&$_smarty_tpl->tpl_vars['tab_configure']->value=='rule') {?>
			<a href="#" class="btn btn-default ta-help-fancy ta-help-page"  href="javascript:;"data-fancybox-href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminLiveCartReminder'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&helppage=rule&tab_select=rule&submitAction=showHelp" title="<?php echo smartyTranslate(array('s'=>'Page help','mod'=>'tacartreminder'),$_smarty_tpl);?>
"><img src="../modules/tacartreminder/views/img/helppage.png"/></a>
		<?php }?>
		<a href="../modules/tacartreminder/readme_en.pdf" class="btn btn-default"><img src="../modules/tacartreminder/views/img/doc_en.png"/></a>
		<a href="../modules/tacartreminder/readme_fr.pdf"  class="btn btn-default"><img src="../modules/tacartreminder/views/img/doc_fr.png"/></a>
		<a href="../modules/tacartreminder/readme_es.pdf" class="btn btn-default"><img src="../modules/tacartreminder/views/img/doc_es.png"/></a>
	</div>
</div>
</div>
<script type="text/javascript">
$('.ta-help-fancy').click(function() {
		var url = $(this).data('fancybox-href');
		$.fancybox({
	        autoSize: true,
	        autoDimensions: true,
	        href: url,
	        beforeShow: function(){
	        	  /*$(".fancybox-skin").css("backgroundColor","#700227");*/
	        },
	        type: 'ajax'
	    });
	});
</script><?php }} ?>
