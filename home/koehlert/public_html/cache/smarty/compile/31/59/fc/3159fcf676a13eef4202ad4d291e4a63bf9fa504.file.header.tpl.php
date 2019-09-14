<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 16:41:22
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/live_cart_reminder/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12911885645d5ffb1206a736-14986330%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3159fcf676a13eef4202ad4d291e4a63bf9fa504' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/live_cart_reminder/header.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12911885645d5ffb1206a736-14986330',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ad' => 0,
    'ps_version' => 0,
    'token' => 0,
    'iso' => 0,
    'link' => 0,
    'currency' => 0,
    'ta_cr_tab_select' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ffb120aaa13_73668416',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ffb120aaa13_73668416')) {function content_5d5ffb120aaa13_73668416($_smarty_tpl) {?>
<script type="text/javascript">
	var ad = '<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['ad']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
	<?php if ($_smarty_tpl->tpl_vars['ps_version']->value<"1.6") {?>
		var ps15 = true;
	<?php } else { ?>
		var ps15 = false;
	<?php }?>
	var ad = '<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['ad']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
	var token = '<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
	var iso = '<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['iso']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
	var pathCSS = '<?php echo mb_convert_encoding(htmlspecialchars(@constant('_THEME_CSS_DIR_'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
	var admin_cart_url = '<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminCarts'));?>
';
	var admin_cart_token = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminCarts'),$_smarty_tpl);?>
';
	var confirm_reminder_done = '<?php echo smartyTranslate(array('s'=>'Indicate that the reminder is completed. Activate the next reminder for this cart?','mod'=>'tacartreminder','js'=>1),$_smarty_tpl);?>
';
	var confirm_reminder_finish = '<?php echo smartyTranslate(array('s'=>'Finish reminders on this cart?','mod'=>'tacartreminder','js'=>1),$_smarty_tpl);?>
';
	var currency_format = <?php echo intval($_smarty_tpl->tpl_vars['currency']->value->format);?>
;
	var currency_sign = '<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['currency']->value->sign);?>
';
	var currency_blank = <?php echo intval($_smarty_tpl->tpl_vars['currency']->value->blank);?>
;
	var priceDisplayPrecision = 0;
</script>
<input type="hidden" value="" id="voucher" />
<?php echo $_smarty_tpl->getSubTemplate ("../menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if ($_smarty_tpl->tpl_vars['ta_cr_tab_select']->value=='manual') {?>
	<script type="text/javascript">
		$( document ).ready(function() {
			$('.ta-reminders-openorclose').trigger('click');
		});
	</script>
<?php }?><?php }} ?>
