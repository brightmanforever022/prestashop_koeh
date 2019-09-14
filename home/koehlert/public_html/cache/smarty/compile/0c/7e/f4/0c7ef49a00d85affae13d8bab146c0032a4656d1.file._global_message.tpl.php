<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/message_placeholders/_global_message.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14693908915d5ced9211c278-57276111%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c7ef49a00d85affae13d8bab146c0032a4656d1' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/message_placeholders/_global_message.tpl',
      1 => 1481621681,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14693908915d5ced9211c278-57276111',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced9212fa69_62622654',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced9212fa69_62622654')) {function content_5d5ced9212fa69_62622654($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['order']->value->hasBeenPaid()||$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()) {?>
    <div class="orderedit_msg warn">
        <ul>
            <?php if ($_smarty_tpl->tpl_vars['order']->value->hasBeenPaid()&&$_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()) {?>
                <li class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'This order has already been paid and delivered. It is advised to avoid modifying it now.','mod'=>'orderedit'),$_smarty_tpl);?>
</li>
            <?php } else { ?>
                <?php if ($_smarty_tpl->tpl_vars['order']->value->hasBeenPaid()) {?>
                <li class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'This order has already been paid. It is advised to avoid modifying it now.','mod'=>'orderedit'),$_smarty_tpl);?>
</li>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['order']->value->hasBeenDelivered()) {?>
                <li class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'This order has already been delivered. It is advised to avoid modifying it now.','mod'=>'orderedit'),$_smarty_tpl);?>
</li>
                <?php }?>
            <?php }?>
        </ul>
    </div>
<?php }?><?php }} ?>
