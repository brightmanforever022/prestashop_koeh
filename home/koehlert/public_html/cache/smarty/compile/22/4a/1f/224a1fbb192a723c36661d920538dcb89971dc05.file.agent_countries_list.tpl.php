<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 17:12:39
         compiled from "/home/koehlert/public_html/modules/agentsales//views/templates/admin/agent_countries_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16156868345d596ae72e63f7-54921501%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '224a1fbb192a723c36661d920538dcb89971dc05' => 
    array (
      0 => '/home/koehlert/public_html/modules/agentsales//views/templates/admin/agent_countries_list.tpl',
      1 => 1561110324,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16156868345d596ae72e63f7-54921501',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'agent_countries_list' => 0,
    'agent_country' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596ae72fc476_36854193',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596ae72fc476_36854193')) {function content_5d596ae72fc476_36854193($_smarty_tpl) {?><table class="table">
  <tr>
    <th><?php echo smartyTranslate(array('s'=>'ID','mod'=>'agentsales'),$_smarty_tpl);?>
</th>
    <th><?php echo smartyTranslate(array('s'=>'Country','mod'=>'agentsales'),$_smarty_tpl);?>
</th>
    <th><?php echo smartyTranslate(array('s'=>'Postcodes','mod'=>'agentsales'),$_smarty_tpl);?>
</th>
    <th><?php echo smartyTranslate(array('s'=>'Action','mod'=>'agentsales'),$_smarty_tpl);?>
</th>
  </tr>
  <?php  $_smarty_tpl->tpl_vars['agent_country'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['agent_country']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['agent_countries_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['agent_country']->key => $_smarty_tpl->tpl_vars['agent_country']->value) {
$_smarty_tpl->tpl_vars['agent_country']->_loop = true;
?>
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['agent_country']->value['id'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['agent_country']->value['country_name'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['agent_country']->value['postcodes'];?>
</td>
    <td>
      <button class="btn btn-warning btn-xs agent-country-edit" data-id="<?php echo $_smarty_tpl->tpl_vars['agent_country']->value['id'];?>
"><?php echo smartyTranslate(array('s'=>'Edit','mod'=>'agentsales'),$_smarty_tpl);?>
</button>
      <button class="btn btn-danger btn-xs agent-country-remove" data-id="<?php echo $_smarty_tpl->tpl_vars['agent_country']->value['id'];?>
"><?php echo smartyTranslate(array('s'=>'Remove','mod'=>'agentsales'),$_smarty_tpl);?>
</button>
    </td>
  </tr>
  <?php } ?>
</table>
<?php }} ?>
