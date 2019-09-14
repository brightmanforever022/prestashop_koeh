<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 18:38:19
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/condition_group.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2720293295d60167b159848-01422225%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc99613fba7494c748593edf547e1def47cdf1ff' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/condition_group.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2720293295d60167b159848-01422225',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'condition_group_id' => 0,
    'conditions' => 0,
    'condition' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d60167b18d368_91486971',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d60167b18d368_91486971')) {function content_5d60167b18d368_91486971($_smarty_tpl) {?>
<tr id="condition_group_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_tr" data-count-condition="<?php echo count($_smarty_tpl->tpl_vars['conditions']->value);?>
" data-id-group-condition="<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
">
	<td>
		<a class="btn btn-default" href="javascript:removeConditionGroup(<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
);">
			<i class="flaticon-cancel6 text-danger"></i>
		</a>
	</td>
	<td>
		<div class="col-lg-12">
			<input type="hidden" name="condition_group[]" value="<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
" />
		</div>
		<div class="form-group">
			<label class="control-label col-lg-4"><?php echo smartyTranslate(array('s'=>'Add a rule applicable to','mod'=>'tacartreminder'),$_smarty_tpl);?>
</label>
			<div class="col-lg-4">
				<select class="form-control" id="condition_type_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
">
					<option value=""><?php echo smartyTranslate(array('s'=>'-- Choose --','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="cart_product" ><?php echo smartyTranslate(array('s'=>'Cart - Products','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="cart_category"><?php echo smartyTranslate(array('s'=>'Cart - Product Categories','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="cart_product_manufacturer"><?php echo smartyTranslate(array('s'=>'Cart - Product Manufacturers','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="cart_product_supplier"><?php echo smartyTranslate(array('s'=>'Cart - Product Suppliers','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="cart_amount"><?php echo smartyTranslate(array('s'=>'Cart - Amount (before tax)','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="cart_product_stockavailable"><?php echo smartyTranslate(array('s'=>'Cart - Product stock (at least 1)','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="cart_product_stockavailable_forall"><?php echo smartyTranslate(array('s'=>'Cart - Product stock (for all)','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="cart_product_quantity_total"><?php echo smartyTranslate(array('s'=>'Cart - Product quantity total','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="customer_gender"><?php echo smartyTranslate(array('s'=>'Customer - Gender','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="customer_order_count"><?php echo smartyTranslate(array('s'=>'Customer - Order count','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="customer_age"><?php echo smartyTranslate(array('s'=>'Customer - Age','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="customer_lang"><?php echo smartyTranslate(array('s'=>'Customer - Language','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="customer_email"><?php echo smartyTranslate(array('s'=>'Customer - Email','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="customer_newsletter"><?php echo smartyTranslate(array('s'=>'Customer - Newsletter','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="customer_group"><?php echo smartyTranslate(array('s'=>'Customer - Group','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="customer_registration_date"><?php echo smartyTranslate(array('s'=>'Customer - Registration date','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="customer_rule_already_applied"><?php echo smartyTranslate(array('s'=>'Customer - Rule already applied','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="customer_optin"><?php echo smartyTranslate(array('s'=>'Customer - Optin','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<option value="address_country"><?php echo smartyTranslate(array('s'=>'Customer - Country address','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					
				</select>
			</div>
			<div class="col-lg-4">
				<a class="btn btn-default" href="javascript:addCondition(<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
);">
					<i class="flaticon-add11"></i>
					<?php echo smartyTranslate(array('s'=>'Add','mod'=>'tacartreminder'),$_smarty_tpl);?>

				</a>
			</div>

		</div>
		<?php echo smartyTranslate(array('s'=>'The cart must meet all of these:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<table id="condition_table_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
" class="table table-bordered">
			
			<?php if (isset($_smarty_tpl->tpl_vars['conditions']->value)&&count($_smarty_tpl->tpl_vars['conditions']->value)>0) {?>
				<?php  $_smarty_tpl->tpl_vars['condition'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['condition']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['conditions']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['condition']->key => $_smarty_tpl->tpl_vars['condition']->value) {
$_smarty_tpl->tpl_vars['condition']->_loop = true;
?>
					<?php echo $_smarty_tpl->tpl_vars['condition']->value;?>

				<?php } ?>
			<?php }?>
		</table>
	</td>
</tr>
<?php }} ?>
