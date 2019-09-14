<?php /* Smarty version Smarty-3.1.19, created on 2019-09-02 15:24:23
         compiled from "/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/orders/supplier_order.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16686315915d6d1807a11ce9-20762111%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b04bed5baddb497155ac0003ec3533c70e561fe' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/orders/supplier_order.tpl',
      1 => 1506592408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16686315915d6d1807a11ce9-20762111',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d6d1807a7dba2_12622376',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d6d1807a7dba2_12622376')) {function content_5d6d1807a7dba2_12622376($_smarty_tpl) {?><html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <style type="text/css" media="all">
            
            * {font-size: 16px;}
            table {border-collapse: collapse; border:1px solid black}
            table th {background-color: #ccc;} 
            table td {border: 1px solid black; padding:10px; border-spacing:0px}
            /*
            table.products {border: none;}
            table.products td {border: none; padding:3px;}
            .bold { font-weight: bold;}
            .boldRed { font-weight: bold; color:red }
            .redBg {background-color: red;}
            .supplierReference{font-size: 18px;}
            .summaryReference{color: red}*/
            
        </style>
    </head>
    <body>
        <h2><?php echo smartyTranslate(array('s'=>'Ordered products'),$_smarty_tpl);?>
 </h2>
        <table>
            <thead>
                <tr>
                    <th><?php echo smartyTranslate(array('s'=>'Photo'),$_smarty_tpl);?>
</th>
                    <th><?php echo smartyTranslate(array('s'=>'Sup. reference'),$_smarty_tpl);?>
</th>
                    <th><?php echo smartyTranslate(array('s'=>'Size'),$_smarty_tpl);?>
</th>
                    <th><?php echo smartyTranslate(array('s'=>'Quantity'),$_smarty_tpl);?>
</th>
                </tr>
            </thead>
            <tbody>
                <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
                <tr>
                    <td><img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['imageLink'];?>
" /></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['product']->value['product_supplier_reference'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['product']->value['size'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['product']->value['quantity'];?>
</td>
                </tr>
                <?php }
if (!$_smarty_tpl->tpl_vars['product']->_loop) {
?>
                    <tr>
                        <td colspan="4"><em><?php echo smartyTranslate(array('s'=>'No orders selected or selected orders contain no items'),$_smarty_tpl);?>
</em></td>
                    </tr>    
                <?php } ?>
            </tbody>
        </table>
    </body>
</html><?php }} ?>
