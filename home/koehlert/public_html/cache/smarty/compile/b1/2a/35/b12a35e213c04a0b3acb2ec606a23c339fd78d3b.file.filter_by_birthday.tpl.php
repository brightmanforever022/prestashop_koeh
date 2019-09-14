<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:34
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/filter_by_birthday.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2974472485d5a47aabb6030-09573519%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b12a35e213c04a0b3acb2ec606a23c339fd78d3b' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/filter_by_birthday.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2974472485d5a47aabb6030-09573519',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fbb_class' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47aabecaa1_96974561',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47aabecaa1_96974561')) {function content_5d5a47aabecaa1_96974561($_smarty_tpl) {?>

<div id="filter-by-birthday-box" class="form-group filter-by-birthday-box <?php if (isset($_smarty_tpl->tpl_vars['fbb_class']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fbb_class']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
	<h4 class="title"><?php echo smartyTranslate(array('s'=>'Select the birthday date:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="col-sm-12 row">
		<div class="form-inline">
			<div class="col-sm-12 pull-left">
				<label class="control-label" style="padding-top: 0;"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'From:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<input id="fbb-from-<?php if (isset($_smarty_tpl->tpl_vars['fbb_class']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fbb_class']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" type="text" class="form-control fbb-from <?php if (isset($_smarty_tpl->tpl_vars['fbb_class']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fbb_class']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">

				<label class="control-label" style="padding-top: 0;"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'To:','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<input id="fbb-to-<?php if (isset($_smarty_tpl->tpl_vars['fbb_class']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fbb_class']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" type="text" class="form-control fbb-to <?php if (isset($_smarty_tpl->tpl_vars['fbb_class']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fbb_class']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
				<a href="javascript:{}" class="btn btn-default btn-margin fbb-clear <?php if (isset($_smarty_tpl->tpl_vars['fbb_class']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fbb_class']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" id="fbb-clear-<?php if (isset($_smarty_tpl->tpl_vars['fbb_class']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fbb_class']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"><?php echo smartyTranslate(array('s'=>'Clear','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
			</div>
		</div>
	</div>
</div><?php }} ?>
