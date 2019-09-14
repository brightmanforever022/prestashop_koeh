<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_discounts.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9150614975d5ced92baee59-13511296%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bae4082c062306a924aa8a4b8553f031df523dab' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_discounts.tpl',
      1 => 1481621681,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9150614975d5ced92baee59-13511296',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
    'discounts' => 0,
    'can_edit' => 0,
    'discount' => 0,
    'currency' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced92c1f578_93992711',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced92c1f578_93992711')) {function content_5d5ced92c1f578_93992711($_smarty_tpl) {?>
<div class="panel panel-vouchers">
    <input type="hidden" id="discountsTotal" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->total_discounts_tax_incl, ENT_QUOTES, 'UTF-8', true);?>
" />
    <table cellspacing="0" cellpadding="0" class="table" style="width:100%;">
        <tr>
            <th><img src="../img/admin/coupon.gif" alt="<?php echo smartyTranslate(array('s'=>'Discounts','mod'=>'orderedit'),$_smarty_tpl);?>
" /><?php echo smartyTranslate(array('s'=>'Discount name','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
            <th align="center" style="width: 100px"><?php echo smartyTranslate(array('s'=>'Value','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
            <th align="center" style="width: 30px"><?php echo smartyTranslate(array('s'=>'Action','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['discount'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['discount']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['discounts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['discount']->key => $_smarty_tpl->tpl_vars['discount']->value) {
$_smarty_tpl->tpl_vars['discount']->_loop = true;
?>
        <tr>
            <td>
                <div class="editable">
                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                    <p class="customVal" style="display:none;">
                        <span></span>
                    </p>
                    <?php }?>
                    <p class="displayVal">
                        <span class="discountName"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['discount']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</span>
                    </p>
                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                    <p class="realVal" style="display:none;">
                        <span class="discount_name_edit">
                            <input type="text" name="discount_name" class="edit_discount_name" rel="discountNameEdit" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['discount']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" />
                        </span>
                    </p>
                    <?php }?>
                </div>
            </td>
            <td align="center">
                <?php if ($_smarty_tpl->tpl_vars['discount']->value['value']!=0.00) {?>
                    -
                <?php }?>
                <div class="editable">
                    <input type="hidden" name="id_order_discount" rel="orderDiscountId" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['discount']->value['id_order_cart_rule'], ENT_QUOTES, 'UTF-8', true);?>
" />
                    <input type="hidden" name="discount_tax_excl_original" rel="orderDiscountTaxExclOriginal" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['discount']->value['value_tax_excl'], ENT_QUOTES, 'UTF-8', true);?>
" />
                    <input type="hidden" name="discount_tax_incl_original" rel="orderDiscountTaxInclOriginal" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['discount']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
" />
                    <input type="hidden" name="discount_id_invoice" rel="orderDiscountInvoiceId" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['discount']->value['id_order_invoice'], ENT_QUOTES, 'UTF-8', true);?>
" />
                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                    <p class="customVal" style="display:none;">
                        <span></span>
                    </p>
                    <?php }?>
                    <p class="displayVal">
                        <span class="displayVal order_discount_show"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['discount']->value['value'],(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
                    </p>
                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                    <p class="realVal" style="display:none;">
                        <span class="order_discount_edit">
                            <?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
                            <input type="text" name="discount_tax_excl" class="edit_discount_price_tax_excl edit_discount_price" rel="discountPriceEdit" value="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['discount']->value['value_tax_excl'],2), ENT_QUOTES, 'UTF-8', true);?>
" size="5" /> <?php if (!($_smarty_tpl->tpl_vars['currency']->value->sign%2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?> <?php echo smartyTranslate(array('s'=>'tax excl.','mod'=>'orderedit'),$_smarty_tpl);?>
<br />
                            <?php if ($_smarty_tpl->tpl_vars['currency']->value->sign%2) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
                            <input type="text" name="discount_tax_incl" class="edit_discount_price_tax_incl edit_discount_price" rel="discountPriceWtEdit" value="<?php echo htmlspecialchars(Tools::ps_round($_smarty_tpl->tpl_vars['discount']->value['value'],2), ENT_QUOTES, 'UTF-8', true);?>
" size="5" /> <?php if (!($_smarty_tpl->tpl_vars['currency']->value->sign%2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value->sign, ENT_QUOTES, 'UTF-8', true);?>
<?php }?> <?php echo smartyTranslate(array('s'=>'tax incl.','mod'=>'orderedit'),$_smarty_tpl);?>

                        </span>
                    </p>
                    <?php }?>
                </div>
            </td>
            <td class="center">
                <a href="#" rel="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['discount']->value['id_order_cart_rule'], ENT_QUOTES, 'UTF-8', true);?>
" class="deleteDiscount"><img src="../img/admin/delete.gif" alt="<?php echo smartyTranslate(array('s'=>'Delete voucher','mod'=>'orderedit'),$_smarty_tpl);?>
" /></a>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3" class="center">
                <a class="btn btn-default" href="#" id="add_voucher"><i class="icon-ticket"></i> <?php echo smartyTranslate(array('s'=>'Add a new discount','mod'=>'orderedit'),$_smarty_tpl);?>
</a>
            </td>
        </tr>
        <tr style="display: none" >
            <td colspan="3" class="current-edit" id="voucher_form">
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_discount_form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            </td>
        </tr>
    </table>
</div>
<?php }} ?>
