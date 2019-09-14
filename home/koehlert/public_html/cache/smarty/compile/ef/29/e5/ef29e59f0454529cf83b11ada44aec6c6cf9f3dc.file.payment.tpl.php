<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:41:02
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/modules/bankwire/views/templates/hook/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5414360385d5a447e455de2-12674124%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef29e59f0454529cf83b11ada44aec6c6cf9f3dc' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/modules/bankwire/views/templates/hook/payment.tpl',
      1 => 1470314267,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5414360385d5a447e455de2-12674124',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a447e472423_39466775',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a447e472423_39466775')) {function content_5d5a447e472423_39466775($_smarty_tpl) {?>
<div class="row">
	<div class="col-xs-12 col-md-6">
        <p class="payment_module">
            <a 
            class="bankwire" 
            href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('bankwire','payment'), ENT_QUOTES, 'UTF-8', true);?>
" 
            title="<?php echo smartyTranslate(array('s'=>'Pay by bank wire','mod'=>'bankwire'),$_smarty_tpl);?>
">
            	<?php echo smartyTranslate(array('s'=>'Pay by bank wire','mod'=>'bankwire'),$_smarty_tpl);?>
 <br>
            	<span class="payment-descriptin-subtitle">
            		<?php echo smartyTranslate(array('s'=>'Ihre Ware wird umgehend nach Zahlungseingang versendet. Sofern es sich um Orderware handelt, versenden wir diese sobald diese verfügbar ist.','mod'=>'bankwire'),$_smarty_tpl);?>

            	</span>
            	
            	
            </a>
        </p>
    </div>
</div><?php }} ?>
