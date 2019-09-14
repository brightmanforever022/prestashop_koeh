<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:36
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/front/category_tree.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18143671955d5a47ac72bb99-74841592%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '88389ee2e35aaa804f154a707143ba4420ce4474' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/front/category_tree.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18143671955d5a47ac72bb99-74841592',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'input_name' => 0,
    'selected_cat' => 0,
    'selected_label' => 0,
    'home' => 0,
    'use_radio' => 0,
    'ajax_request_url' => 0,
    'use_in_popup' => 0,
    'use_shop_context' => 0,
    'use_search' => 0,
    'content' => 0,
    'option_no_decide' => 0,
    'root' => 0,
    'root_input' => 0,
    'home_is_selected' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47ac76d195_27906643',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47ac76d195_27906643')) {function content_5d5a47ac76d195_27906643($_smarty_tpl) {?>

<script type="text/javascript">

	var inputName = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_name']->value, ENT_QUOTES, 'UTF-8', true);?>
';
	var selectedCat = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['selected_cat']->value, ENT_QUOTES, 'UTF-8', true);?>
';
	var selectedLabel = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['selected_label']->value, ENT_QUOTES, 'UTF-8', true);?>
';
	var home = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['home']->value, ENT_QUOTES, 'UTF-8', true);?>
';
	var use_radio = Number('<?php echo intval($_smarty_tpl->tpl_vars['use_radio']->value);?>
');
	var ajaxRequestUrl = '<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['ajax_request_url']->value);?>
';

	<?php if (!$_smarty_tpl->tpl_vars['use_in_popup']->value) {?>
		$(document).ready(function(){
			buildTreeView(Number('<?php echo intval($_smarty_tpl->tpl_vars['use_shop_context']->value);?>
'));
		});
	<?php } else { ?>
		buildTreeView(Number('<?php echo intval($_smarty_tpl->tpl_vars['use_shop_context']->value);?>
'));
	<?php }?>
</script>

<div class="form-group clearfix category-filter">

	<div class="form-group col-sm-12 clearfix">
		<span><a href="#" id="collapse_all" class="btn btn-default"><?php echo smartyTranslate(array('s'=>'Collapse All','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;</span>	
		<span><a href="#" id="expand_all" class="btn btn-default"><?php echo smartyTranslate(array('s'=>'Expand All','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;</span>
		<?php if (!$_smarty_tpl->tpl_vars['use_radio']->value) {?>
			<span><a href="#" id="check_all" class="btn btn-default"><?php echo smartyTranslate(array('s'=>'Check All','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;</span>
			<span><a href="#" id="uncheck_all" class="btn btn-default"><?php echo smartyTranslate(array('s'=>'Uncheck All','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a></span>
		<?php }?>
	</div>

	<div class="form-group col-sm-12 clearfix">
		<?php if ($_smarty_tpl->tpl_vars['use_search']->value) {?>
			<div class="form-inline">
				<div class="form-group">
					<label class="control-label" style="padding-top: 0;"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'search','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
					<input type="text" name="search_cat" id="search_cat" class="form-control">
				</div>
			</div>
		<?php }?>
	</div>

	
	<?php echo strval($_smarty_tpl->tpl_vars['content']->value);?>


	<?php if ($_smarty_tpl->tpl_vars['option_no_decide']->value) {?>
	<ul class="filetree" style="list-style: none;">
		<li class="hasChildren">
			<input type="<?php if (!$_smarty_tpl->tpl_vars['use_radio']->value) {?>checkbox<?php } else { ?>radio<?php }?>" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" value="-1" onclick="clickOnCategoryBox($(this));" />
			<span class="category_label"><?php echo smartyTranslate(array('s'=>'Customers who have not chosen any category','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
		</li>
	</ul>
	<?php }?>

	<ul id="categories-treeview" class="filetree">

		<li id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root']->value['id_category'], ENT_QUOTES, 'UTF-8', true);?>
" class="hasChildren">
			<span class="folder">
			<?php if ($_smarty_tpl->tpl_vars['root_input']->value) {?>
				<input type="<?php if (!$_smarty_tpl->tpl_vars['use_radio']->value) {?>checkbox<?php } else { ?>radio<?php }?>" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input_name']->value, ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root']->value['id_category'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['home_is_selected']->value) {?> checked <?php }?> onclick="clickOnCategoryBox($(this));" />
				<span class="category_label"> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['root']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
 </span>
			<?php } else { ?>
				&nbsp;
			<?php }?>
			</span>
			<ul>
				<li><span class="placeholder">&nbsp;</span></li>
		  	</ul>
		</li>
	</ul>
</div>

<?php if ($_smarty_tpl->tpl_vars['use_search']->value) {?>
	<script type="text/javascript">
		$(document).ready(function(){
			searchCategory();
		});
	</script>
<?php }?><?php }} ?>
