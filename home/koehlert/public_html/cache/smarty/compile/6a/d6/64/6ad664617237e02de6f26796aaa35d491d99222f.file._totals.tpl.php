<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_totals.tpl" */ ?>
<?php /*%%SmartyHeaderCode:280499585d5ced92c54bf1-16053101%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6ad664617237e02de6f26796aaa35d491d99222f' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_totals.tpl',
      1 => 1481621681,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '280499585d5ced92c54bf1-16053101',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
    'currency' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced92c87891_25390641',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced92c87891_25390641')) {function content_5d5ced92c87891_25390641($_smarty_tpl) {?>
<div class="panel panel-total">
    <table class="table" width="450px;" style="border-radius:0px;"cellspacing="0" cellpadding="0">
        <tr id="total_products">
            <td width="150px;"><b><?php echo smartyTranslate(array('s'=>'Products','mod'=>'orderedit'),$_smarty_tpl);?>
</b></td>
            <td class="amount" align="right"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['order']->value->total_products_wt,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
            <td class="partial_refund_fields current-edit" style="display:none;">&nbsp;</td>
        </tr>
        <tr id="total_discounts">
            <td><b><?php echo smartyTranslate(array('s'=>'Discounts','mod'=>'orderedit'),$_smarty_tpl);?>
</b></td>
            <td class="amount" align="right">-<?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['order']->value->total_discounts_tax_incl,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
            <td class="partial_refund_fields current-edit" style="display:none;">&nbsp;</td>
        </tr>
        <tr id="total_wrapping">
            <td><b><?php echo smartyTranslate(array('s'=>'Wrapping','mod'=>'orderedit'),$_smarty_tpl);?>
</b></td>
            <td class="amount" align="right"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['order']->value->total_wrapping_tax_incl,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
            <td class="partial_refund_fields current-edit" style="display:none;">&nbsp;</td>
        </tr>
        <tr id="total_shipping">
            <td><b><?php echo smartyTranslate(array('s'=>'Shipping','mod'=>'orderedit'),$_smarty_tpl);?>
</b></td>
            <td class="amount" align="right"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['order']->value->total_shipping_tax_incl,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
            <td class="partial_refund_fields current-edit" style="display:none;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->prefix, ENT_QUOTES, 'UTF-8', true);?>
<input type="text" size="3" name="partialRefundShippingCost" value="0" /><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->suffix, ENT_QUOTES, 'UTF-8', true);?>
</td>
        </tr>
        <tr style="font-size: 20px" id="total_order">
            <td style="font-size: 20px"><?php echo smartyTranslate(array('s'=>'Total','mod'=>'orderedit'),$_smarty_tpl);?>
</td>
            <td class="amount" style="font-size: 20px" align="right">
                <?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['order']->value->total_paid_tax_incl,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

            </td>
            <td class="partial_refund_fields current-edit" style="display:none;">&nbsp;</td>
        </tr>
    </table>
</div><?php }} ?>
