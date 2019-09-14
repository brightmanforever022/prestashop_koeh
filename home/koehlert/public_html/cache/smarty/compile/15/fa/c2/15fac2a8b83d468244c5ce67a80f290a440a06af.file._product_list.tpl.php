<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_product_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1272551055d5ced92664642-40176558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15fac2a8b83d468244c5ce67a80f290a440a06af' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_product_list.tpl',
      1 => 1481621681,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1272551055d5ced92664642-40176558',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'can_edit' => 0,
    'order' => 0,
    'products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced926ae7a7_17927036',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced926ae7a7_17927036')) {function content_5d5ced926ae7a7_17927036($_smarty_tpl) {?>
<div style="float:left;width: 100%;">
    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
    <div style="float: left;"><a href="#" class="add_product btn btn-default"><i class="icon-plus-sign"></i> <?php echo smartyTranslate(array('s'=>'Add a product','mod'=>'orderedit'),$_smarty_tpl);?>
</a></div>
    <div style="float: right; margin-right: 10px" id="refundForm">
    <!--
        <a href="#" class="standard_refund"><img src="../img/admin/add.gif" alt="<?php echo smartyTranslate(array('s'=>'Process a standard refund','mod'=>'orderedit'),$_smarty_tpl);?>
" /> <?php echo smartyTranslate(array('s'=>'Process a standard refund','mod'=>'orderedit'),$_smarty_tpl);?>
</a>
        <a href="#" class="partial_refund"><img src="../img/admin/add.gif" alt="<?php echo smartyTranslate(array('s'=>'Process a partial refund','mod'=>'orderedit'),$_smarty_tpl);?>
" /> <?php echo smartyTranslate(array('s'=>'Process a partial refund','mod'=>'orderedit'),$_smarty_tpl);?>
</a>
    -->
    </div>
    <br clear="left" /><br />
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['can_edit']->value) {?>
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_new_product.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php }?>
    <table style="width: 100%;" cellspacing="0" cellpadding="0" class="table" id="orderProducts">
        <thead>
            <tr>
                <th height="39" align="center" style="width: 7%">&nbsp;</th>
                <th><?php echo smartyTranslate(array('s'=>'Product','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
                <th><?php echo smartyTranslate(array('s'=>'Reference','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
                <th style="width: 15%;"><?php echo smartyTranslate(array('s'=>'Supplier Reference','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
                <th style="width: 8%;"><?php echo smartyTranslate(array('s'=>'Unit Weight','mod'=>'orderedit'),$_smarty_tpl);?>
 <sup>*</sup></th>
                <th style="width: 8%; text-align: center"><?php echo smartyTranslate(array('s'=>'Reduction %','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
                <th style="width: 8%; text-align: center"><?php echo smartyTranslate(array('s'=>'Unit Price','mod'=>'orderedit'),$_smarty_tpl);?>
 <sup>*</sup></th>
                <th style="width: 8%; text-align: center"><?php echo smartyTranslate(array('s'=>'Tax rate','mod'=>'orderedit'),$_smarty_tpl);?>
 <sup>*</sup></th>
                <th style="width: 4%; text-align: center"><?php echo smartyTranslate(array('s'=>'Qty','mod'=>'orderedit'),$_smarty_tpl);?>
</th>
                <th style="width: 10%; text-align: center"><?php echo smartyTranslate(array('s'=>'Total','mod'=>'orderedit'),$_smarty_tpl);?>
 <sup>*</sup></th>
                <th colspan="2" style="display: none;" class="add_product_fields">&nbsp;</th>
                <th colspan="2" style="display: none;" class="edit_product_fields">&nbsp;</th>
                <th colspan="2" style="display: none;" class="standard_refund_fields">
                    <img src="../img/admin/delete.gif" alt="<?php echo smartyTranslate(array('s'=>'Products','mod'=>'orderedit'),$_smarty_tpl);?>
" />
                    <?php if (($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()||$_smarty_tpl->tpl_vars['order']->value->hasBeenShipped())) {?>
                        <?php echo smartyTranslate(array('s'=>'Return','mod'=>'orderedit'),$_smarty_tpl);?>

                    <?php } elseif (($_smarty_tpl->tpl_vars['order']->value->hasBeenPaid())) {?>
                        <?php echo smartyTranslate(array('s'=>'Refund','mod'=>'orderedit'),$_smarty_tpl);?>

                    <?php } else { ?>
                        <?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'orderedit'),$_smarty_tpl);?>

                    <?php }?>
                </th>
                <th style="width: 12%;text-align:right;display:none" class="partial_refund_fields">
                    <?php echo smartyTranslate(array('s'=>'Partial refund','mod'=>'orderedit'),$_smarty_tpl);?>

                </th>
                <th style="width: 8%;text-align:center;">
                    <?php echo smartyTranslate(array('s'=>'Action','mod'=>'orderedit'),$_smarty_tpl);?>

                </th>
            </tr>
        </thead>
        <tbody>
            <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['i']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['product']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['i']['index']++;
?>
                
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_customized_data.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('index'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['i']['index']), 0);?>


                
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_product_line.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('index'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['i']['index']), 0);?>

            <?php } ?>
        </tbody>
    </table>

    <div class="row">
        <div class="alert alert-warning">
            <sup>*</sup> <?php echo smartyTranslate(array('s'=>'For this customer group, prices are displayed as:','mod'=>'orderedit'),$_smarty_tpl);?>

            <?php if (($_smarty_tpl->tpl_vars['order']->value->getTaxCalculationMethod()==@constant('PS_TAX_EXC'))) {?>
                <?php echo smartyTranslate(array('s'=>'tax excluded.','mod'=>'orderedit'),$_smarty_tpl);?>

            <?php } else { ?>
                <?php echo smartyTranslate(array('s'=>'tax included.','mod'=>'orderedit'),$_smarty_tpl);?>

            <?php }?>
    
            <?php if (!Configuration::get('PS_ORDER_RETURN')) {?>
                <br /><br /><?php echo smartyTranslate(array('s'=>'Merchandise returns are disabled','mod'=>'orderedit'),$_smarty_tpl);?>

            <?php }?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-6">
            <div id="discounts_wrapper">
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_discounts.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            </div>
        </div>
        <div class="col-xs-6">
            <div id="totals_wrapper">
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['orderedit_tpl_dir']->value)."/helpers/_totals.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            </div>
        </div>
    </div>
</div><?php }} ?>
