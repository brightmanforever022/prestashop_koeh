<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 18:38:19
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/condition.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4930680195d60167b073b28-29568876%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cd1a2e1d5559067b378787b73c0f061c8c9dda51' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/condition.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4930680195d60167b073b28-29568876',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'condition_group_id' => 0,
    'condition_id' => 0,
    'condition_type' => 0,
    'condition_type_value' => 0,
    'condition_sign' => 0,
    'condition_value' => 0,
    'currency_sign' => 0,
    'condition_choose_content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d60167b155381_13447845',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d60167b155381_13447845')) {function content_5d60167b155381_13447845($_smarty_tpl) {?>
<tr id="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_tr">
	<td>
		<input type="hidden" name="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
[]" value="<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
" />
		<input type="hidden" name="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_type" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['condition_type']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" />
		<input type="hidden" name="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_typevalue" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['condition_type_value']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
		<?php if ($_smarty_tpl->tpl_vars['condition_type']->value=='cart_product') {?>
			<?php echo smartyTranslate(array('s'=>'Products:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='cart_category') {?>
			<?php echo smartyTranslate(array('s'=>'Categories:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='cart_product_manufacturer') {?>
			<?php echo smartyTranslate(array('s'=>'Manufacturers:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='cart_product_supplier') {?>
			<?php echo smartyTranslate(array('s'=>'Suppliers:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='cart_amount') {?>
			<?php echo smartyTranslate(array('s'=>'Cart amount:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='cart_product_stockavailable') {?>
			<?php echo smartyTranslate(array('s'=>'Product stock (at least 1):','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='cart_product_stockavailable_forall') {?>
			<?php echo smartyTranslate(array('s'=>'Product stock (for all):','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='cart_product_quantity_total') {?>
			<?php echo smartyTranslate(array('s'=>'Product quantity total:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_lang') {?>
			<?php echo smartyTranslate(array('s'=>'Customer language:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_email') {?>
			<?php echo smartyTranslate(array('s'=>'Customer email:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_newsletter') {?>
			<?php echo smartyTranslate(array('s'=>'Customer newsletter:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_optin') {?>
			<?php echo smartyTranslate(array('s'=>'Customer optin:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_gender') {?>
			<?php echo smartyTranslate(array('s'=>'Customer gender:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='address_country') {?>
			<?php echo smartyTranslate(array('s'=>'Countries:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_group') {?>
			<?php echo smartyTranslate(array('s'=>'Customer group:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_order_count') {?>
			<?php echo smartyTranslate(array('s'=>'Customer order count:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_registration_date') {?>
			<?php echo smartyTranslate(array('s'=>'Customer registration date:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_age') {?>
			<?php echo smartyTranslate(array('s'=>'Customer age:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_rule_already_applied') {?>
			<?php echo smartyTranslate(array('s'=>'Rule already applied to this same customer:','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php }?>
	</td>
	<td <?php if ($_smarty_tpl->tpl_vars['condition_type_value']->value!='list') {?> colspan="2"<?php }?>>
		<?php if ($_smarty_tpl->tpl_vars['condition_type_value']->value=='list') {?>
			<input type="text" id="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_match" value="" disabled="disabled" />
		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type_value']->value=='integer'||$_smarty_tpl->tpl_vars['condition_type_value']->value=='string'||$_smarty_tpl->tpl_vars['condition_type_value']->value=='price') {?>
			<table>
			<tr>			
				<td><select name="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_sign" >
					<?php if ($_smarty_tpl->tpl_vars['condition_type_value']->value=='integer'||$_smarty_tpl->tpl_vars['condition_type_value']->value=='price') {?>
						<option value="=" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='=') {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'=  (Equal)','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
						<option value=">" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='>') {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'>  (Exceeds)','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
						<option value=">=" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='>=') {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'>= (Exceeds or Equal)','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
						<option value="<" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='<') {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'<  (Less than)','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
						<option value="<=" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='<=') {?>selected<?php }?>>&lt;= <?php echo smartyTranslate(array('s'=>'(Less than or Equal)','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
						<option value="<>" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='<>') {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'<> (Different)','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<?php } else { ?>
						<option value="=" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='=') {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Equal','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
						<option value="contain" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='contain') {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Contains','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
						<option value="not_contain" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='not_contain') {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Does not contain','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
						<option value="<>" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='<>') {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Different','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
						<option value="match" <?php if ($_smarty_tpl->tpl_vars['condition_sign']->value=='match') {?>selected<?php }?>><?php echo smartyTranslate(array('s'=>'Match','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
					<?php }?>
					</select>
				</td>
				<td>
					<?php if ($_smarty_tpl->tpl_vars['condition_type']->value=='customer_registration_date') {?>
						<div class="input-group">
							<span class="input-group-addon"><?php echo smartyTranslate(array('s'=>'Days','mod'=>'tacartreminder'),$_smarty_tpl);?>
</span>
							<input maxlength="14" id="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value" name="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value" 
								type="text" value="<?php echo floatval($_smarty_tpl->tpl_vars['condition_value']->value);?>
" onchange="this.value = this.value.replace(/,/g, '.');">
						</div>
					<?php } elseif ($_smarty_tpl->tpl_vars['condition_type_value']->value=='price') {?>
						<div class="input-group">
							<span class="input-group-addon"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency_sign']->value, ENT_QUOTES, 'UTF-8', true);?>
</span>
							<input maxlength="14" id="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value" name="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value" 
								type="text" value="<?php echo floatval($_smarty_tpl->tpl_vars['condition_value']->value);?>
" onchange="this.value = this.value.replace(/,/g, '.');">
						</div>
					<?php } else { ?>
						<input type="text" id="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value" name="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['condition_value']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>						
					<?php }?>
				</td>
			</tr>
			</table>
		<?php } elseif ($_smarty_tpl->tpl_vars['condition_type_value']->value=='bool') {?>
			<span class="switch prestashop-switch fixed-width-lg">
					<input type="radio" name="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value" id="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value_on" value="1" <?php if ($_smarty_tpl->tpl_vars['condition_value']->value) {?> checked="checked" <?php }?>>
					<label for="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value_on"><?php echo smartyTranslate(array('s'=>'Yes','mod'=>'tacartreminder'),$_smarty_tpl);?>
</label>
					<input type="radio" name="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value" id="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value_off" value="0" <?php if (!$_smarty_tpl->tpl_vars['condition_value']->value) {?> checked="checked" <?php }?>>
					<label for="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_value_off"><?php echo smartyTranslate(array('s'=>'No','mod'=>'tacartreminder'),$_smarty_tpl);?>
</label>
					<a class="slide-button btn"></a>
			</span>
		<?php }?>
	</td>
	<?php if ($_smarty_tpl->tpl_vars['condition_type_value']->value=='list') {?>
	<td>
		<a class="btn btn-default" id="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_choose_link" href="#condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_choose_content">
			<i class="flaticon-list30"></i>
			<?php echo smartyTranslate(array('s'=>'Select','mod'=>'tacartreminder'),$_smarty_tpl);?>

		</a>
		<div>
			<div id="condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_choose_content">
				<?php echo $_smarty_tpl->tpl_vars['condition_choose_content']->value;?>

			</div>
		</div>
	</td>
	<?php }?>
	<td class="text-right">
		<a class="btn btn-default" href="javascript:removeCondition(<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
, <?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
);">
			<i class="flaticon-cancel6"></i>
		</a>
	</td>
</tr>

<script type="text/javascript">
<?php if ($_smarty_tpl->tpl_vars['condition_type_value']->value=='list') {?>
	$('#condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_choose_content').parent().hide();
	$("#condition_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_choose_link").fancybox({
		autoDimensions: false,
		autoSize: false,
		width: 600,
		height: 290});
	<?php if ($_smarty_tpl->tpl_vars['condition_type']->value!='cart_category') {?>
		$(document).ready(function() { updateConditionShortDescription($('#condition_select_<?php echo intval($_smarty_tpl->tpl_vars['condition_group_id']->value);?>
_<?php echo intval($_smarty_tpl->tpl_vars['condition_id']->value);?>
_add')); });
	<?php }?>
<?php }?>
</script><?php }} ?>
