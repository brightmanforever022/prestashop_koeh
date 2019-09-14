<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 09:44:56
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/front/unsubscribe.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17727521905d5a5378b4da72-03047269%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '936627760614e7e142f2b861d0906504b6b98e68' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/front/unsubscribe.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17727521905d5a5378b4da72-03047269',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'navigationPipe' => 0,
    'unsubscribe' => 0,
    'email_not_found' => 0,
    'email_not_valid' => 0,
    'token_not_valid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a5378b765d3_55215147',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a5378b765d3_55215147')) {function content_5d5a5378b765d3_55215147($_smarty_tpl) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?>
<span class="navigation-pipe"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['navigationPipe']->value, ENT_QUOTES, 'UTF-8', true);?>
</span><?php echo smartyTranslate(array('s'=>'Unsubscribe','mod'=>'newsletterpro'),$_smarty_tpl);?>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<div id="newsletterpro-unsubscribe">
	<?php if (isset($_smarty_tpl->tpl_vars['unsubscribe']->value)) {?>
	<p class="success"><?php echo smartyTranslate(array('s'=>'You have successfully unsubscribed from our newsletter.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
	<?php } elseif (isset($_smarty_tpl->tpl_vars['email_not_found']->value)) {?>
	<p class="error"><?php echo smartyTranslate(array('s'=>'You are not subscribed at our newsletter.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
	<?php } elseif (isset($_smarty_tpl->tpl_vars['email_not_valid']->value)) {?>
	<p class="error"><?php echo smartyTranslate(array('s'=>'Your email is not valid.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
	<?php } elseif (isset($_smarty_tpl->tpl_vars['token_not_valid']->value)) {?>
	<p class="error"><?php echo smartyTranslate(array('s'=>'Invalid unsubscription token.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
	<?php } else { ?>
	&nbsp;
	<?php }?>
</div><?php }} ?>
