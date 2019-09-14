<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/task/template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8678046955d5a47a8c9c652-67421495%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00af09a77cf594e560668e44f199fc5270245e3d' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/task/template.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8678046955d5a47a8c9c652-67421495',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'email_sleep' => 0,
    'newsletter_template_list' => 0,
    'template' => 0,
    'shop_email' => 0,
    'shops' => 0,
    'shop' => 0,
    'languages' => 0,
    'lang' => 0,
    'default_lang' => 0,
    'all_active_languages' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8cf9432_49236780',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8cf9432_49236780')) {function content_5d5a47a8cf9432_49236780($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/koehlert/public_html/tools/smarty/plugins/modifier.replace.php';
?> 

<script id="task-template" type="text/template" style="display: none;">
	<div>
		<div class="new-task-box">
			<div class="form-group clearfix">
				<label class="control-label"><?php echo smartyTranslate(array('s'=>'You have selected','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <strong><span id="selected_emails_count">0</span></strong> <?php echo smartyTranslate(array('s'=>'emails','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
			</div>

			<div class="form-group clearfix">
				<div class="form-inline">
					<label class="control-label pull-left"><?php echo smartyTranslate(array('s'=>'Send one newsletter at','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
					<input id="task-sleep" class="form-control pull-left text-center task-sleep" type="number" step="1" value="<?php echo intval($_smarty_tpl->tpl_vars['email_sleep']->value);?>
">
					<label class="control-label aona-seconds pull-left"><?php echo smartyTranslate(array('s'=>'seconds','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
				</div>
			</div>
			
			<div class="form-group clearfix">
				<label class="control-label col-sm-4"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Date','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-8">
					<input type="text" id="task-datepicker" class="form-control task-datepicker">
				</div>
			</div>


			<div class="form-group clearfix">
				<label class="control-label col-sm-4"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Template','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-8">
					<div class="clearfix task-new-smtp"> 
						<select autocomplete="off" id="task-select-template" class="float-left gk-smtp-select gk-select">
							<?php  $_smarty_tpl->tpl_vars['template'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['template']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['newsletter_template_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['template']->key => $_smarty_tpl->tpl_vars['template']->value) {
$_smarty_tpl->tpl_vars['template']->_loop = true;
?>
								<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['template']->value['filename'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['template']->value['selected']==true) {?> selected="selected" <?php }?>><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['template']->value['name'],'.html','');?>
</option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>

			<div class="form-group clearfix">
				<label class="control-label col-sm-4"><?php echo smartyTranslate(array('s'=>'Send method','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
				<div class="col-sm-8">
					<div class="radio">
						<label class="in-win" for="task-mail-method">
							<input id="task-mail-method" type="radio" name="task-send-method" value="mail" checked="checked">
							<?php echo smartyTranslate(array('s'=>'Function mail()','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</label>
					</div>
					<div class="radio">
						<label class="in-win" for="task-smtp-method">
							<input id="task-smtp-method" type="radio" name="task-send-method" value="smtp">
							<?php echo smartyTranslate(array('s'=>'SMTP configuration','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</label>
					</div>
				</div>
			</div>

			<div id="div-task-smtp-select" class="form-group clearfix" style="display: none;">
				<label class="control-label col-sm-4"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Select SMTP','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-8 task-new-smtp">
					<select id="task-smtp-select"></select>
				</div>
			</div>
			
			<div class="form-group clearfix">
				<label class="control-label col-sm-4"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Send a test','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-8">
					<input id="task-email-test" class="form-control task-email-test" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_email']->value, ENT_QUOTES, 'UTF-8', true);?>
">
				</div>
			</div>

			<div class="form-group clearfix">
				<div class="col-sm-8 col-sm-offset-4">
					<div class="form-inline">
						<div class="form-group">
							<div id="task-test-email-lang-select"></div>
						</div>
						<div class="form-group">
							<a href="javascript:{}" id="task-smtp-test" class="btn btn-default pull-left task-smtp-test">
								<span class="btn-ajax-loader" style="display: none;"></span>
								<i class="icon icon-envelope"></i> <?php echo smartyTranslate(array('s'=>'Send a test','mod'=>'newsletterpro'),$_smarty_tpl);?>

							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="clearfix">
				<div id="task-smtp-test-message" class="col-sm-12 task-smtp-test-message"></div>
			</div>
			
			<div class="clearfix">
				<a href="javascript:{}" id="add-task" class="btn btn-default pull-right">
					<i class="icon icon-plus-square"></i>
					<?php echo smartyTranslate(array('s'=>'Add Task','mod'=>'newsletterpro'),$_smarty_tpl);?>

				</a>
			</div>

		</div>
	</div>
</script>

<script id="add-new-email-template" type="text/template" style="display: none;">
	<div>
		<div>
			<form id="add-new-email-from" class="add-new-email-from" method="POST">
				<div class="clearfix">
					<div class="form-group clearfix">
						<label class="control-label col-sm-4">
							<span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'First Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="firstname">
						</div>
					</div>

					<div class="form-group clearfix">
						<label class="control-label col-sm-4">
							<span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Last Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="lastname">
						</div>
					</div>


					<div class="form-group clearfix">
						<label class="control-label col-sm-4">
							<span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="email">
						</div>
					</div>


					<div class="form-group clearfix">
						<label class="control-label col-sm-4">
							<span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Shop','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						</label>
						<div class="col-sm-8">
							<select class="gk-select" name="id_shop">
								<?php  $_smarty_tpl->tpl_vars['shop'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['shop']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['shops']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['shop']->key => $_smarty_tpl->tpl_vars['shop']->value) {
$_smarty_tpl->tpl_vars['shop']->_loop = true;
?>
									<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php } ?>
							</select>
						</div>
					</div>


					<div class="form-group clearfix">
						<label class="control-label col-sm-4">
							<span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Language','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
						</label>
						<div class="col-sm-8">
							<select class="gk-select" name="id_lang">
								<?php  $_smarty_tpl->tpl_vars['lang'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lang']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lang']->key => $_smarty_tpl->tpl_vars['lang']->value) {
$_smarty_tpl->tpl_vars['lang']->_loop = true;
?>
									<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lang']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['default_lang']->value==$_smarty_tpl->tpl_vars['lang']->value['id_lang']) {?> selected="selected" <?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lang']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</option>
								<?php } ?>
							</select>
						</div>
					</div>

				</div>
				<a id="add-new-email-action" class="btn btn-default add-new-email-action" href="javascript:{}">
					<i class="icon icon-plus-square"></i>
					<?php echo smartyTranslate(array('s'=>'Add','mod'=>'newsletterpro'),$_smarty_tpl);?>

				</a>
				<div id="add-new-email-error" class="error-msg" style="margin: 0; float: none; display: inline-block;">
				</div>
			</form>
			<div class="clear" style="clear: both;"></div>
		</div>
	</div>
</script>

<script id="list-of-interest-template" type="text/template" style="display: none;">
	<div>
		<div id="list-of-interest-template-add" class="list-of-interest-template-add">
			<div class="form-group clearfix input-list">
				<div class="col-sm-6 text-left">
					<label class="control-label"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				</div>
				<div class="col-sm-6">
					<div id="add-new-fs-langs" class="pull-right add-new-fs-langs gk_lang_select"></div>
				</div>
			</div>
			<div class="form-group clearfix">
				<?php  $_smarty_tpl->tpl_vars['lang'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lang']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['all_active_languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lang']->key => $_smarty_tpl->tpl_vars['lang']->value) {
$_smarty_tpl->tpl_vars['lang']->_loop = true;
?>
					<input data-lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lang']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" name="loi_input_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lang']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" type="text" class="form-control" style="<?php if ($_smarty_tpl->tpl_vars['lang']->value['id_lang']==$_smarty_tpl->tpl_vars['default_lang']->value) {?>display: block;<?php } else { ?>display: none;<?php }?>">
				<?php } ?>
			</div>
			<div class="clearfix">
				<a href="javascript:{}" id="add-loi-button" class="btn btn-default add-button"><i class="icon icon-plus-square"> </i> <?php echo smartyTranslate(array('s'=>'Add','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
			</div>
		</div>

		<div id="list-of-interest-template-update" class="list-of-interest-template-update">
			<div class="form-group clearfix input-list">
				
				<div class="form-group clearfix">
					<div class="col-sm-6 text-left">
						<div class="row">
							<label class="control-label"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div id="update-fs-langs" class="update-fs-langs gk_lang_select" style="float: right;"></div>
						</div>
					</div>
				</div>

				<div class="form-group clearfix">
					<?php  $_smarty_tpl->tpl_vars['lang'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lang']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['all_active_languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lang']->key => $_smarty_tpl->tpl_vars['lang']->value) {
$_smarty_tpl->tpl_vars['lang']->_loop = true;
?>
						<input data-lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lang']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" name="loi_input_update_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lang']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" type="text" class="form-control" style="<?php if ($_smarty_tpl->tpl_vars['lang']->value['id_lang']==$_smarty_tpl->tpl_vars['default_lang']->value) {?>display: block;<?php } else { ?>display: none;<?php }?>">
					<?php } ?>
				</div>
			</div>

			<div class="clearfix">
				<div class="form-inline">
					<div class="form-group">
						<label class="control-label" style="padding: 0;"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Position','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
						<input id="loi-position" name="loi_position" type="text" class="form-control text-center fixed-width-xs position">
					</div>
					<div class="form-group pull-right">
						<a href="javascript:{}" id="update-loi-button" class="btn btn-default update-button"><i class="icon icon-save"> </i> <?php echo smartyTranslate(array('s'=>'Save','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<!-- this is in use -->
<div id="voucher-alert-box" class="voucher-alert-box" style="display: none;"> </div><?php }} ?>
