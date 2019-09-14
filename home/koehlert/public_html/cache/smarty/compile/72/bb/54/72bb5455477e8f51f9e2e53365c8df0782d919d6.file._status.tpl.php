<?php /* Smarty version Smarty-3.1.19, created on 2019-08-21 09:06:58
         compiled from "/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_status.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2700277005d5ced9213d643-67121185%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72bb5455477e8f51f9e2e53365c8df0782d919d6' => 
    array (
      0 => '/home/koehlert/public_html/modules//orderedit/views/templates/admin/_configure/order_edit/helpers/_status.tpl',
      1 => 1481621681,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2700277005d5ced9213d643-67121185',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'current_index' => 0,
    'token' => 0,
    'states' => 0,
    'state' => 0,
    'order' => 0,
    'history' => 0,
    'key' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ced92180e58_96005650',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ced92180e58_96005650')) {function content_5d5ced92180e58_96005650($_smarty_tpl) {?>
<!-- Change status form -->
<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_index']->value, ENT_QUOTES, 'UTF-8', true);?>
&vieworder&token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
" method="post" id="stateSubmitForm">
    <div class="row">
        <div class="col-lg-9">
            <select id="id_order_state" name="id_order_state">
            <?php  $_smarty_tpl->tpl_vars['state'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['state']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['states']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['state']->key => $_smarty_tpl->tpl_vars['state']->value) {
$_smarty_tpl->tpl_vars['state']->_loop = true;
?>
                <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['state']->value['id_order_state'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars(stripslashes($_smarty_tpl->tpl_vars['state']->value['name']), ENT_QUOTES, 'UTF-8', true);?>
</option>
            <?php } ?>
            </select>
            <input type="hidden" name="id_order" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order']->value->id, ENT_QUOTES, 'UTF-8', true);?>
" />
        </div>
        <div class="col-lg-3">
            <input type="submit" name="submitState" value="<?php echo smartyTranslate(array('s'=>'Add','mod'=>'orderedit'),$_smarty_tpl);?>
" class="btn btn-primary" />
        </div>
    </div>
</form>
<br />

<!-- History of status -->
<table cellspacing="0" cellpadding="0" class="table history-status" style="width: 100%;">
    <colgroup>
        <col width="1%">
        <col width="">
        <col width="20%">
        <col width="20%">
        <col width="1%">
    </colgroup>
<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['history']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['row']->key;
?>
    <?php if (($_smarty_tpl->tpl_vars['key']->value==0)) {?>
    <tr>
        <th><img src="../img/os/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['id_order_state'], ENT_QUOTES, 'UTF-8', true);?>
.gif" /></th>
        <th><?php echo htmlspecialchars(stripslashes($_smarty_tpl->tpl_vars['row']->value['ostate_name']), ENT_QUOTES, 'UTF-8', true);?>
</th>
        <th><?php if ($_smarty_tpl->tpl_vars['row']->value['employee_lastname']) {?><?php echo htmlspecialchars(stripslashes($_smarty_tpl->tpl_vars['row']->value['employee_firstname']), ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars(stripslashes($_smarty_tpl->tpl_vars['row']->value['employee_lastname']), ENT_QUOTES, 'UTF-8', true);?>
<?php }?></th>
        <th><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['row']->value['date_add'],'full'=>true),$_smarty_tpl);?>
</th>
        <th>
            <a href="#" class="delete_order_status btn btn-default" rel="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['id_order_history'], ENT_QUOTES, 'UTF-8', true);?>
">
                <i class="icon-trash"></i>
            </a>
        </th>
    </tr>
    <?php } else { ?>
    <tr class="<?php if (($_smarty_tpl->tpl_vars['key']->value%2)) {?>alt_row<?php }?>">
        <td><img src="../img/os/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['id_order_state'], ENT_QUOTES, 'UTF-8', true);?>
.gif" /></td>
        <td><?php echo htmlspecialchars(stripslashes($_smarty_tpl->tpl_vars['row']->value['ostate_name']), ENT_QUOTES, 'UTF-8', true);?>
</td>
        <td><?php if ($_smarty_tpl->tpl_vars['row']->value['employee_lastname']) {?><?php echo htmlspecialchars(stripslashes($_smarty_tpl->tpl_vars['row']->value['employee_firstname']), ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars(stripslashes($_smarty_tpl->tpl_vars['row']->value['employee_lastname']), ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?>&nbsp;<?php }?></td>
        <td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['row']->value['date_add'],'full'=>true),$_smarty_tpl);?>
</td>
        <td>
            <a href="#" class="delete_order_status btn btn-default" rel="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['id_order_history'], ENT_QUOTES, 'UTF-8', true);?>
">
                <i class="icon-trash"></i>
            </a>
        </td>
    </tr>
    <?php }?>
<?php } ?>
</table><?php }} ?>
