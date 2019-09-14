<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/settings_option.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18922150795d5a47a8594f89-44321972%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '222c7314f3317cb916354656c5661d4b512e1b93' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/settings_option.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18922150795d5a47a8594f89-44321972',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title_name' => 0,
    'label_id' => 0,
    'label_name' => 0,
    'is_checked' => 0,
    'input_onchange' => 0,
    'description' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a85bf199_77686556',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a85bf199_77686556')) {function content_5d5a47a85bf199_77686556($_smarty_tpl) {?>
<div class="form-group clearfix">
	<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title_name']->value, ENT_QUOTES, 'UTF-8', true);?>
</span></label>

	<div class="col-sm-9">
		
		<div class="fixed-width-l clearfix">
			<div class="col-sm-3">
				<div class="row">
					<span class="switch prestashop-switch">
						<input id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['label_id']->value, ENT_QUOTES, 'UTF-8', true);?>
_yes" type="radio" value="1" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['label_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if (isset($_smarty_tpl->tpl_vars['is_checked']->value)&&$_smarty_tpl->tpl_vars['is_checked']->value) {?>checked<?php }?> 
							<?php if (isset($_smarty_tpl->tpl_vars['input_onchange']->value)) {?>onchange="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_onchange']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>>
						
						<label for="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['label_id']->value, ENT_QUOTES, 'UTF-8', true);?>
_yes">
							<?php echo smartyTranslate(array('s'=>'Yes','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</label>

						<input id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['label_id']->value, ENT_QUOTES, 'UTF-8', true);?>
_no" type="radio" value="0" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['label_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if (isset($_smarty_tpl->tpl_vars['is_checked']->value)&&!$_smarty_tpl->tpl_vars['is_checked']->value) {?>checked<?php }?>
							<?php if (isset($_smarty_tpl->tpl_vars['input_onchange']->value)) {?>onchange="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_onchange']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>>

						<label for="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['label_id']->value, ENT_QUOTES, 'UTF-8', true);?>
_no">
							<?php echo smartyTranslate(array('s'=>'No','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</label>
						<a class="slide-button btn"></a>
					</span>
				</div>
			</div>

		</div>
		<?php if (isset($_smarty_tpl->tpl_vars['description']->value)) {?>
			<p class="help-block"><?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['description']->value);?>
</p>
		<?php }?>
	</div>
</div><?php }} ?>
