<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:41:21
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/order-confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16439704705d5a449156d877-66068647%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46c8c66c83f403d85c31248ff1ef92de953fa74f' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/order-confirmation.tpl',
      1 => 1524844973,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16439704705d5a449156d877-66068647',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'is_guest' => 0,
    'id_order_formatted' => 0,
    'reference_order' => 0,
    'email' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a4491598999_15081127',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a4491598999_15081127')) {function content_5d5a4491598999_15081127($_smarty_tpl) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Order confirmation'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<h1 class="page-heading"><?php echo smartyTranslate(array('s'=>'Order confirmation'),$_smarty_tpl);?>
</h1>

<?php if (isset($_smarty_tpl->tpl_vars['current_step'])) {$_smarty_tpl->tpl_vars['current_step'] = clone $_smarty_tpl->tpl_vars['current_step'];
$_smarty_tpl->tpl_vars['current_step']->value = 'payment'; $_smarty_tpl->tpl_vars['current_step']->nocache = null; $_smarty_tpl->tpl_vars['current_step']->scope = 0;
} else $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('payment', null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./order-steps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>





<p class="cheque-indent alert alert-success">
<strong class="dark"><?php echo smartyTranslate(array('s'=>'Your order on Christian Koehlert is complete.'),$_smarty_tpl);?>
</strong>
</p>
<p><?php echo smartyTranslate(array('s'=>'Vielen Dank für Ihren Auftrag.'),$_smarty_tpl);?>
</p>
<p><?php echo smartyTranslate(array('s'=>'Wir werden Ihre Bestellung umgehend prüfen und Ihnen dann eine Auftragsbestätigung zukommen lassen. In dieser Auftragsbestätigung finden Sie alle weiteren Details zur
Lieferzeit und Bezahlung.'),$_smarty_tpl);?>

</p>

<p><?php echo smartyTranslate(array('s'=>'Wir danken für Ihr Vertrauen und wünschen Ihnen gute Geschäfte.'),$_smarty_tpl);?>
</p>

</p>
<?php if ($_smarty_tpl->tpl_vars['is_guest']->value) {?>
	<p><?php echo smartyTranslate(array('s'=>'Your order ID is:'),$_smarty_tpl);?>
 <span class="bold"><?php echo $_smarty_tpl->tpl_vars['id_order_formatted']->value;?>
</span> . <?php echo smartyTranslate(array('s'=>'Your order ID has been sent via email.'),$_smarty_tpl);?>
</p>
    <p class="cart_navigation exclusive">
	<a class="button-exclusive btn btn-outline" href="<?php ob_start();?><?php echo urlencode($_smarty_tpl->tpl_vars['reference_order']->value);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo urlencode($_smarty_tpl->tpl_vars['email']->value);?>
<?php $_tmp2=ob_get_clean();?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('guest-tracking',true,null,"id_order=".$_tmp1."&email=".$_tmp2), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Follow my order'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Follow my order'),$_smarty_tpl);?>
</a>
    </p>
<?php } else { ?>
<p class="cart_navigation exclusive">
	<a class="button-exclusive btn btn-outline" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('history',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Go to your order history page'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'View your order history'),$_smarty_tpl);?>
</a>
</p>
<?php }?>
<?php }} ?>
