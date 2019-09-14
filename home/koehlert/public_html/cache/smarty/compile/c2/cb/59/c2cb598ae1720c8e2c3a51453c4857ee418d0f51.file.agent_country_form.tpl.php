<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 17:12:38
         compiled from "/home/koehlert/public_html/modules/agentsales//views/templates/admin/agent_country_form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6828661365d596ae62ba540-77939834%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2cb598ae1720c8e2c3a51453c4857ee418d0f51' => 
    array (
      0 => '/home/koehlert/public_html/modules/agentsales//views/templates/admin/agent_country_form.tpl',
      1 => 1561110324,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6828661365d596ae62ba540-77939834',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'agent_country' => 0,
    'countries_options' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596ae62c8d47_09912493',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596ae62c8d47_09912493')) {function content_5d596ae62c8d47_09912493($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/home/koehlert/public_html/tools/smarty/plugins/function.html_options.php';
?><form action="" method="post" id="agentsalesCountryForm">
    <input type="hidden" name="id" value="<?php if (isset($_smarty_tpl->tpl_vars['agent_country']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['agent_country']->value['id'];?>
<?php }?>">
      <label><?php echo smartyTranslate(array('s'=>'Country','mod'=>'agentsales'),$_smarty_tpl);?>
</label>
      <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['countries_options']->value,'name'=>'id_country','selected'=>$_smarty_tpl->tpl_vars['agent_country']->value['id_country']),$_smarty_tpl);?>

      
      <label><?php echo smartyTranslate(array('s'=>'Postcodes','mod'=>'agentsales'),$_smarty_tpl);?>
</label>
      <textarea rows="5" cols="20" name="postcodes"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['agent_country']->value['postcodes'], ENT_QUOTES, 'UTF-8', true);?>
</textarea>
      <br>
      <button type="button" id="agentsalesCountrySubmit" class="btn btn-default"
        ><?php echo smartyTranslate(array('s'=>'Save related country','mod'=>'agentsales'),$_smarty_tpl);?>
</button>
</form><?php }} ?>
