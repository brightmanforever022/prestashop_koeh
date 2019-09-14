<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 10:12:53
         compiled from "/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/orders/order_package_details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:855624445d5a5a05460be3-45902854%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c5cf98374d13834a394a2e8955649f88dfaf27e' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/orders/order_package_details.tpl',
      1 => 1548664064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '855624445d5a5a05460be3-45902854',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'orderPackage' => 0,
    'employeeName' => 0,
    'opDetails' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a5a0547c7c9_69268329',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a5a0547c7c9_69268329')) {function content_5d5a5a0547c7c9_69268329($_smarty_tpl) {?><h2><?php echo smartyTranslate(array('s'=>'Order package'),$_smarty_tpl);?>
 #<?php echo $_smarty_tpl->tpl_vars['orderPackage']->value->id;?>
<?php if ($_smarty_tpl->tpl_vars['orderPackage']->value->cancelled) {?> (<?php echo smartyTranslate(array('s'=>'cancelled'),$_smarty_tpl);?>
)<?php }?></h2>

<table>
    <tr>
        <td><?php echo smartyTranslate(array('s'=>'Date:'),$_smarty_tpl);?>
</td>
        <td>&nbsp;</td>
        <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['orderPackage']->value->date_add,'full'=>true),$_smarty_tpl);?>
</td>
    </tr>
    <tr>
        <td><?php echo smartyTranslate(array('s'=>'Employee:'),$_smarty_tpl);?>
</td>
        <td>&nbsp;</td>
        <td><?php echo $_smarty_tpl->tpl_vars['employeeName']->value;?>
</td>
    </tr>
</table>
<table class='table'>
    <thead>
    <tr>
        <th><?php echo smartyTranslate(array('s'=>'Product'),$_smarty_tpl);?>
</th>
        <th><?php echo smartyTranslate(array('s'=>'Sku'),$_smarty_tpl);?>
</th>
        <th><?php echo smartyTranslate(array('s'=>'Quantity'),$_smarty_tpl);?>
</th>
    </tr>
    </thead>
    <tbody>
    <?php  $_smarty_tpl->tpl_vars['detail'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['detail']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['opDetails']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['detail']->key => $_smarty_tpl->tpl_vars['detail']->value) {
$_smarty_tpl->tpl_vars['detail']->_loop = true;
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['detail']->value['product_name'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['detail']->value['product_supplier_reference'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['detail']->value['quantity'];?>
</td>
    </tr>
    <?php } ?>
    </tbody>
</table><?php }} ?>
