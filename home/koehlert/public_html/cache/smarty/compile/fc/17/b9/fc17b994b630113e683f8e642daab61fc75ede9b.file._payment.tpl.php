<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1243101085d5ced92441474-74311007%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc17b994b630113e683f8e642daab61fc75ede9b' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_payment.tpl',
      1 => 1481621681,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1243101085d5ced92441474-74311007',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
    'orders_total_paid_tax_incl' => 0,
    'total_paid' => 0,
    'currentState' => 0,
    'currency' => 0,
    'current_index' => 0,
    'brother_order' => 0,
    'payment' => 0,
    'can_edit' => 0,
    'current_id_lang' => 0,
    'invoice' => 0,
    'payment_methods' => 0,
    'payment_method' => 0,
    'currencies' => 0,
    'current_currency' => 0,
    'invoices_collection' => 0,
    'currency_change' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced92583d11_41321392',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced92583d11_41321392')) {function content_5d5ced92583d11_41321392($_smarty_tpl) {?>
<!-- Payments block -->
<div class="panel">
        <div class="panel-heading">
                <i class="icon-money"></i>
                <?php echo smartyTranslate(array('s'=>'Payment','mod'=>'orderedit'),$_smarty_tpl);?>
 <span class="badge"><?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['order']->value->getOrderPayments()), ENT_QUOTES, 'UTF-8', true);?>
</span>
        </div>
        <?php if (count($_smarty_tpl->tpl_vars['order']->value->getOrderPayments())>0) {?>
                <p class="alert alert-danger" style="<?php if (round($_smarty_tpl->tpl_vars['orders_total_paid_tax_incl']->value,2)==round($_smarty_tpl->tpl_vars['total_paid']->value,2)||$_smarty_tpl->tpl_vars['currentState']->value->id==6) {?>display: none;<?php }?>">
                        <?php echo smartyTranslate(array('s'=>'Warning','mod'=>'orderedit'),$_smarty_tpl);?>

                        <strong><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['total_paid']->value,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong>
                        <?php echo smartyTranslate(array('s'=>'paid instead of','mod'=>'orderedit'),$_smarty_tpl);?>

                        <strong class="total_paid"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['orders_total_paid_tax_incl']->value,(int)$_smarty_tpl->tpl_vars['currency']->value->id), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong>
                        <?php  $_smarty_tpl->tpl_vars['brother_order'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['brother_order']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order']->value->getBrother(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['brother_order']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['brother_order']->key => $_smarty_tpl->tpl_vars['brother_order']->value) {
$_smarty_tpl->tpl_vars['brother_order']->_loop = true;
 $_smarty_tpl->tpl_vars['brother_order']->index++;
 $_smarty_tpl->tpl_vars['brother_order']->first = $_smarty_tpl->tpl_vars['brother_order']->index === 0;
?>
                                <?php if ($_smarty_tpl->tpl_vars['brother_order']->first) {?>
                                        <?php if (count($_smarty_tpl->tpl_vars['order']->value->getBrother())==1) {?>
                                                <br /><?php echo smartyTranslate(array('s'=>'This warning also concerns order ','mod'=>'orderedit'),$_smarty_tpl);?>

                                        <?php } else { ?>
                                                <br /><?php echo smartyTranslate(array('s'=>'This warning also concerns the next orders:','mod'=>'orderedit'),$_smarty_tpl);?>

                                        <?php }?>
                                <?php }?>
                                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_index']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;vieworder&amp;id_order=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brother_order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo htmlspecialchars($_GET['token'], ENT_QUOTES, 'UTF-8', true);?>
">
                                        #<?php echo htmlspecialchars(sprintf('%06d',$_smarty_tpl->tpl_vars['brother_order']->value->id), ENT_QUOTES, 'UTF-8', true);?>

                                </a>
                        <?php } ?>
                </p>
        <?php }?>
        <form id="formAddPayment"  method="post">
                <div class="table-responsive">
                        <table class="table">
                                <thead>
                                        <tr>
                                                <th><span class="title_box "><?php echo smartyTranslate(array('s'=>'Date','mod'=>'orderedit'),$_smarty_tpl);?>
</span></th>
                                                <th><span class="title_box "><?php echo smartyTranslate(array('s'=>'Payment method','mod'=>'orderedit'),$_smarty_tpl);?>
</span></th>
                                                <th><span class="title_box "><?php echo smartyTranslate(array('s'=>'Transaction ID','mod'=>'orderedit'),$_smarty_tpl);?>
</span></th>
                                                <th><span class="title_box "><?php echo smartyTranslate(array('s'=>'Amount','mod'=>'orderedit'),$_smarty_tpl);?>
</span></th>
                                                <th><span class="title_box "><?php echo smartyTranslate(array('s'=>'Invoice','mod'=>'orderedit'),$_smarty_tpl);?>
</span></th>
                                                <th></th>
                                        </tr>
                                </thead>
                                <tbody>
                                        <?php  $_smarty_tpl->tpl_vars['payment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['payment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order']->value->getOrderPaymentCollection(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['payment']->key => $_smarty_tpl->tpl_vars['payment']->value) {
$_smarty_tpl->tpl_vars['payment']->_loop = true;
?>
                                        <tr class="payment_line">
                                                <td>
                                                    <div class="editable">
                                                        <input type="hidden" name="id_payment" rel="orderPayment" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" />
                                                        <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                        <p class="customVal" style="display:none;">
                                                            <span></span>
                                                        </p>
                                                        <?php }?>
                                                        <p class="displayVal">
                                                            <span class="payment_date_show "><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->date_add, ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                        </p>
                                                        <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                        <p class="realVal" style="display:none;">
                                                            <span class="payment_date_edit">
                                                                <input type="text" class="datetime_pick" id="payment_date_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" rel="paymentDate" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->date_add, ENT_QUOTES, 'UTF-8', true);?>
" />
                                                            </span>
                                                        </p>
                                                        <?php }?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="editable">
                                                        <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                            <p class="customVal" style="display:none;">
                                                                <span></span>
                                                            </p>
                                                        <?php }?>
                                                        <p class="displayVal">
                                                            <span class="payment_name_show"><?php if ((stristr($_smarty_tpl->tpl_vars['order']->value->payment,$_smarty_tpl->tpl_vars['payment']->value->payment_method))) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->payment, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->payment_method, ENT_QUOTES, 'UTF-8', true);?>
<?php }?></span>
                                                        </p>
                                                        <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                            <p class="realVal" style="display:none;">
                                                            <span class="payment_name_edit">
                                                                <input type="text" id="payment_name_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" rel="paymentName" value="<?php if ((stristr($_smarty_tpl->tpl_vars['order']->value->payment,$_smarty_tpl->tpl_vars['payment']->value->payment_method))) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->payment, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->payment_method, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" />
                                                            </span>
                                                            </p>
                                                        <?php }?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="editable">
                                                        <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                        <p class="customVal" style="display:none;">
                                                            <span></span>
                                                        </p>
                                                        <?php }?>
                                                        <p class="displayVal">
                                                            <span class="payment_transaction_show"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->transaction_id, ENT_QUOTES, 'UTF-8', true);?>
</span>
                                                        </p>
                                                        <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                        <p class="realVal" style="display:none;">
                                                            <span class="payment_transaction_edit">
                                                                <input type="text" id="payment_transaction_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" rel="paymentTransaction" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->transaction_id, ENT_QUOTES, 'UTF-8', true);?>
" />
                                                            </span>
                                                        </p>
                                                        <?php }?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="editable">
                                                        <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                        <p class="customVal" style="display:none;">
                                                            <span></span>
                                                        </p>
                                                        <?php }?>
                                                        <p class="displayVal">
                                                            <span class="payment_amount_show"><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayPrice($_smarty_tpl->tpl_vars['payment']->value->amount,(int)$_smarty_tpl->tpl_vars['payment']->value->id_currency), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
                                                        </p>
                                                        <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                        <p class="realVal" style="display:none;">
                                                            <span class="payment_amount_edit">
                                                                <input type="text" id="payment_amount_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" rel="paymentAmountEdit" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->amount, ENT_QUOTES, 'UTF-8', true);?>
" />
                                                            </span>
                                                        </p>
                                                        <?php }?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (!isset($_smarty_tpl->tpl_vars['invoice'])) $_smarty_tpl->tpl_vars['invoice'] = new Smarty_Variable(null);if ($_smarty_tpl->tpl_vars['invoice']->value = $_smarty_tpl->tpl_vars['payment']->value->getOrderInvoice($_smarty_tpl->tpl_vars['order']->value->id)) {?>
                                                        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['invoice']->value->getInvoiceNumberFormatted($_smarty_tpl->tpl_vars['current_id_lang']->value), ENT_QUOTES, 'UTF-8', true);?>

                                                    <?php } else { ?>
                                                        <?php echo smartyTranslate(array('s'=>'No invoice','mod'=>'orderedit'),$_smarty_tpl);?>

                                                    <?php }?>
                                                </td>
                                                <td class="actions">
                                                        <div class="btn-group btn-group-nowrap">
                                                                <button type="button" class="btn btn-default open_payment_information">
                                                                <i class="icon-search"></i>
                                                                <?php echo smartyTranslate(array('s'=>'Details','mod'=>'orderedit'),$_smarty_tpl);?>

                                                                </button>
                                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                                        <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                        <li>
                                                                            <a href="#" class="delete_payment_from_order btn btn-default" rel="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
">
                                                                               <i class="icon-trash"></i> <?php echo smartyTranslate(array('s'=>'Delete','mod'=>'orderedit'),$_smarty_tpl);?>

                                                                            </a>
                                                                        </li>
                                                                </ul>
                                                        </div>
                                                </td>
                                        </tr>
                                        <tr class="payment_information" style="display: none;">
                                                <td colspan="5">
                                                        <p>
                                                                <b><?php echo smartyTranslate(array('s'=>'Card Number','mod'=>'orderedit'),$_smarty_tpl);?>
</b>&nbsp;
                                                                <div class="editable">
                                                                    <input type="hidden" name="id_payment" rel="orderPayment" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" />
                                                                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                                    <p class="customVal" style="display:none;">
                                                                        <span></span>
                                                                    </p>
                                                                    <?php }?>
                                                                    <p class="displayVal">
                                                                        <span class="card_number_show"><?php if ($_smarty_tpl->tpl_vars['payment']->value->card_number) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->card_number, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Not defined','mod'=>'orderedit'),$_smarty_tpl);?>
<?php }?></span>
                                                                    </p>
                                                                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                                    <p class="realVal" style="display:none;">
                                                                        <span class="card_number_edit">
                                                                            <input type="text" id="card_number_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" rel="cardNumber" value="<?php if ($_smarty_tpl->tpl_vars['payment']->value->card_number) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->card_number, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" />
                                                                        </span>
                                                                    </p>
                                                                    <?php }?>
                                                                </div>
                                                        </p>
                                                        <p>
                                                                <b><?php echo smartyTranslate(array('s'=>'Card Brand','mod'=>'orderedit'),$_smarty_tpl);?>
</b>&nbsp;
                                                                <div class="editable">
                                                                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                                    <p class="customVal" style="display:none;">
                                                                        <span></span>
                                                                    </p>
                                                                    <?php }?>
                                                                    <p class="displayVal">
                                                                        <span class="card_brand_show"><?php if ($_smarty_tpl->tpl_vars['payment']->value->card_brand) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->card_brand, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Not defined','mod'=>'orderedit'),$_smarty_tpl);?>
<?php }?></span>
                                                                    </p>
                                                                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                                    <p class="realVal" style="display:none;">
                                                                        <span class="card_brand_edit">
                                                                            <input type="text" id="card_brand_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" rel="cardBrand" value="<?php if ($_smarty_tpl->tpl_vars['payment']->value->card_brand) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->card_brand, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" />
                                                                        </span>
                                                                    </p>
                                                                    <?php }?>
                                                                </div>
                                                        </p>
                                                        <p>
                                                                <b><?php echo smartyTranslate(array('s'=>'Card Expiration','mod'=>'orderedit'),$_smarty_tpl);?>
</b>&nbsp;
                                                                <div class="editable">
                                                                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                                    <p class="customVal" style="display:none;">
                                                                        <span></span>
                                                                    </p>
                                                                    <?php }?>
                                                                    <p class="displayVal">
                                                                        <span class="card_expiration_show"><?php if ($_smarty_tpl->tpl_vars['payment']->value->card_expiration) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->card_expiration, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Not defined','mod'=>'orderedit'),$_smarty_tpl);?>
<?php }?></span>
                                                                    </p>
                                                                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                                    <p class="realVal" style="display:none;">
                                                                        <span class="card_expiration_edit">
                                                                            <input type="text" id="card_expiration_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" rel="cardExpiration" value="<?php if ($_smarty_tpl->tpl_vars['payment']->value->card_expiration) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->card_expiration, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" />
                                                                        </span>
                                                                    </p>
                                                                    <?php }?>
                                                                </div>
                                                        </p>
                                                        <p>
                                                                <b><?php echo smartyTranslate(array('s'=>'Card Holder','mod'=>'orderedit'),$_smarty_tpl);?>
</b>&nbsp;
                                                                <div class="editable">
                                                                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                                    <p class="customVal" style="display:none;">
                                                                        <span></span>
                                                                    </p>
                                                                    <?php }?>
                                                                    <p class="displayVal">
                                                                        <span class="card_holder_show"><?php if ($_smarty_tpl->tpl_vars['payment']->value->card_holder) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->card_holder, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Not defined','mod'=>'orderedit'),$_smarty_tpl);?>
<?php }?></span>
                                                                    </p>
                                                                    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
                                                                    <p class="realVal" style="display:none;">
                                                                        <span class="card_holder_edit">
                                                                            <input type="text" id="card_expiration_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" rel="cardHolder" value="<?php if ($_smarty_tpl->tpl_vars['payment']->value->card_holder) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment']->value->card_holder, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" />
                                                                        </span>
                                                                    </p>
                                                                    <?php }?>
                                                                </div>
                                                        </p>
                                                </td>
                                        </tr>
                                        <?php }
if (!$_smarty_tpl->tpl_vars['payment']->_loop) {
?>
                                        <tr>
                                                <td class="list-empty hidden-print" colspan="6">
                                                        <div class="list-empty-msg">
                                                                <i class="icon-warning-sign list-empty-icon"></i>
                                                                <?php echo smartyTranslate(array('s'=>'No payment methods are available','mod'=>'orderedit'),$_smarty_tpl);?>

                                                        </div>
                                                </td>
                                        </tr>
                                        <?php } ?>
                                        <tr class="current-edit hidden-print">
                                                <td>
                                                        <div class="input-group fixed-width-xl">
                                                                <input type="text" name="payment_date" class="datepicker" value="<?php echo htmlspecialchars(date('Y-m-d'), ENT_QUOTES, 'UTF-8', true);?>
" />
                                                                <div class="input-group-addon">
                                                                        <i class="icon-calendar-o"></i>
                                                                </div>
                                                        </div>
                                                </td>
                                                <td>
                                                        <select name="payment_method" class="payment_method">
                                                        <?php  $_smarty_tpl->tpl_vars['payment_method'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['payment_method']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['payment_methods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['payment_method']->key => $_smarty_tpl->tpl_vars['payment_method']->value) {
$_smarty_tpl->tpl_vars['payment_method']->_loop = true;
?>
                                                                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment_method']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['payment_method']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                        <?php } ?>
                                                        </select>
                                                </td>
                                                <td>
                                                        <input type="text" name="payment_transaction_id" value="" class="form-control fixed-width-sm"/>
                                                </td>
                                                <td>
                                                        <input type="text" name="payment_amount" value="" class="form-control fixed-width-sm pull-left" />
                                                        <select name="payment_currency" class="payment_currency form-control fixed-width-xs pull-left">
                                                                <?php  $_smarty_tpl->tpl_vars['current_currency'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['current_currency']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['current_currency']->key => $_smarty_tpl->tpl_vars['current_currency']->value) {
$_smarty_tpl->tpl_vars['current_currency']->_loop = true;
?>
                                                                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_currency']->value['id_currency'], ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['current_currency']->value['id_currency']==$_smarty_tpl->tpl_vars['currency']->value->id) {?> selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_currency']->value['sign'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                                <?php } ?>
                                                        </select>
                                                </td>
                                                <td>
                                                        <?php if (count($_smarty_tpl->tpl_vars['invoices_collection']->value)>0) {?>
                                                                <select name="payment_invoice" id="payment_invoice">
                                                                <?php  $_smarty_tpl->tpl_vars['invoice'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invoice']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['invoices_collection']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['invoice']->key => $_smarty_tpl->tpl_vars['invoice']->value) {
$_smarty_tpl->tpl_vars['invoice']->_loop = true;
?>
                                                                        <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['invoice']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" selected="selected"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['invoice']->value->getInvoiceNumberFormatted($_smarty_tpl->tpl_vars['current_id_lang']->value,$_smarty_tpl->tpl_vars['order']->value->id_shop), ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                                <?php } ?>
                                                                </select>
                                                        <?php }?>
                                                </td>
                                                <td class="actions">
                                                        <button class="btn btn-primary btn-block" type="submit" name="submitAddPayment">
                                                                <?php echo smartyTranslate(array('s'=>'Add','mod'=>'orderedit'),$_smarty_tpl);?>

                                                        </button>
                                                </td>
                                        </tr>
                                </tbody>
                        </table>
                </div>
        </form>
        <?php if ((!$_smarty_tpl->tpl_vars['order']->value->valid&&sizeof($_smarty_tpl->tpl_vars['currencies']->value)>1)) {?>
                <form class="form-horizontal well" method="post">
                        <div class="row">
                                <label class="control-label col-lg-3"><?php echo smartyTranslate(array('s'=>'Change currency','mod'=>'orderedit'),$_smarty_tpl);?>
</label>
                                <div class="col-lg-6">
                                        <select name="new_currency">
                                        <?php  $_smarty_tpl->tpl_vars['currency_change'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['currency_change']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['currency_change']->key => $_smarty_tpl->tpl_vars['currency_change']->value) {
$_smarty_tpl->tpl_vars['currency_change']->_loop = true;
?>
                                                <?php if ($_smarty_tpl->tpl_vars['currency_change']->value['id_currency']!=$_smarty_tpl->tpl_vars['order']->value->id_currency) {?>
                                                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency_change']->value['id_currency'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency_change']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
 - <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency_change']->value['sign'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                <?php }?>
                                        <?php } ?>
                                        </select>
                                        <p class="help-block"><?php echo smartyTranslate(array('s'=>'Do not forget to update your exchange rate before making this change.','mod'=>'orderedit'),$_smarty_tpl);?>
</p>
                                </div>
                                <div class="col-lg-3">
                                        <button type="submit" class="btn btn-default" name="submitChangeCurrency"><i class="icon-refresh"></i> <?php echo smartyTranslate(array('s'=>'Change','mod'=>'orderedit'),$_smarty_tpl);?>
</button>
                                </div>
                        </div>
                </form>
        <?php }?>
</div><?php }} ?>
