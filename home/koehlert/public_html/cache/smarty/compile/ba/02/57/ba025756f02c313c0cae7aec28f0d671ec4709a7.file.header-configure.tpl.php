<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 18:38:05
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/header-configure.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15974254845d60166d2e1270-38018537%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba025756f02c313c0cae7aec28f0d671ec4709a7' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/header-configure.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15974254845d60166d2e1270-38018537',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tab_configure' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d60166d30d914_79797999',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d60166d30d914_79797999')) {function content_5d60166d30d914_79797999($_smarty_tpl) {?>
<div class="row">
	<div class="navigation col-md-2">
		<nav class="list-group">
			<a class="list-group-item <?php if ($_smarty_tpl->tpl_vars['tab_configure']->value=='mail') {?>active<?php }?>" href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules'));?>
&configure=tacartreminder&tab_select=settings&tab_configure=mail"><?php echo smartyTranslate(array('s'=>'Email templates','mod'=>'tacartreminder'),$_smarty_tpl);?>
</a>
			<a class="list-group-item <?php if ($_smarty_tpl->tpl_vars['tab_configure']->value=='rule') {?>active<?php }?>" href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules'));?>
&configure=tacartreminder&tab_select=settings&tab_configure=rule"><?php echo smartyTranslate(array('s'=>'Rules','mod'=>'tacartreminder'),$_smarty_tpl);?>
</a>
			<a class="list-group-item <?php if ($_smarty_tpl->tpl_vars['tab_configure']->value=='configuration') {?>active<?php }?>" href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules'));?>
&configure=tacartreminder&tab_select=settings&tab_configure=configuration"><?php echo smartyTranslate(array('s'=>'Configuration','mod'=>'tacartreminder'),$_smarty_tpl);?>
</a>
			<a class="list-group-item <?php if ($_smarty_tpl->tpl_vars['tab_configure']->value=='cronjob') {?>active<?php }?>" href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules'));?>
&configure=tacartreminder&tab_select=settings&tab_configure=cronjob"><?php echo smartyTranslate(array('s'=>'Automated task','mod'=>'tacartreminder'),$_smarty_tpl);?>
</a>
			<!-- a class="list-group-item <?php if ($_smarty_tpl->tpl_vars['tab_configure']->value=='supervising') {?>active<?php }?>" href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules'));?>
&configure=tacartreminder&tab_select=settings&tab_configure=supervising"><?php echo smartyTranslate(array('s'=>'Supervising','mod'=>'tacartreminder'),$_smarty_tpl);?>
</a-->
		</nav>
	</div>
	<div class="col-md-10"><?php }} ?>
