<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 18:38:19
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/helpers/view/view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14179409275d60167b1fff71-86830123%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a0b0fb3038eeb4a1ad579cfab1d349fa1bf3519e' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/helpers/view/view.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
    'df39576aae3f7510caed0854c1f7310a951ae39a' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/helpers/view/view.tpl',
      1 => 1440056612,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14179409275d60167b1fff71-86830123',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name_controller' => 0,
    'hookName' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d60167b24cbb8_92375984',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d60167b24cbb8_92375984')) {function content_5d60167b24cbb8_92375984($_smarty_tpl) {?>

<div class="leadin"></div>


<?php if ($_smarty_tpl->tpl_vars['type_render']->value=='rule') {?>
<script>
	var validate_url = '<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['validate_url']->value);?>
';
	var nbr_steps = <?php echo count($_smarty_tpl->tpl_vars['wizard_steps']->value['steps']);?>
;
	var tacartreminder_configure_url = '<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['tacartreminder_configure_url']->value);?>
';
</script>
<div class="row">
	<div class="col-sm-12">
		<div id="rule_wizard" class="ta-form">
			<ul id="progressbar">
				<?php  $_smarty_tpl->tpl_vars['step'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['step']->_loop = false;
 $_smarty_tpl->tpl_vars['step_nbr'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['wizard_steps']->value['steps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['step']->key => $_smarty_tpl->tpl_vars['step']->value) {
$_smarty_tpl->tpl_vars['step']->_loop = true;
 $_smarty_tpl->tpl_vars['step_nbr']->value = $_smarty_tpl->tpl_vars['step']->key;
?>
					<li <?php if ($_smarty_tpl->tpl_vars['step_nbr']->value==0) {?>class="active"<?php }?>>
						<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['step']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<br />
						<?php if (isset($_smarty_tpl->tpl_vars['step']->value['desc'])) {?><small><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['step']->value['desc'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</small><?php }?>
					</li>
				<?php } ?>
			</ul>
			<?php  $_smarty_tpl->tpl_vars['content'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['content']->_loop = false;
 $_smarty_tpl->tpl_vars['step_nbr'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['wizard_contents']->value['contents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['content']->key => $_smarty_tpl->tpl_vars['content']->value) {
$_smarty_tpl->tpl_vars['content']->_loop = true;
 $_smarty_tpl->tpl_vars['step_nbr']->value = $_smarty_tpl->tpl_vars['content']->key;
?>
				<fieldset class="ta-step"> 	
					<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

					<div class="button-option-bar">
						<?php if ($_smarty_tpl->tpl_vars['step_nbr']->value==0) {?><a href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['tacartreminder_configure_url']->value);?>
" class="previous action-button" ><?php echo smartyTranslate(array('s'=>'Return','mod'=>'tacartreminder'),$_smarty_tpl);?>
</a><?php }?>
						<?php if ($_smarty_tpl->tpl_vars['step_nbr']->value>0) {?><input type="button" name="previous" class="previous action-button" value="<?php echo smartyTranslate(array('s'=>'Previous','mod'=>'tacartreminder'),$_smarty_tpl);?>
" /><?php }?>
						<div class="process-next-save">
							<?php if ($_smarty_tpl->tpl_vars['step_nbr']->value<(count($_smarty_tpl->tpl_vars['wizard_steps']->value['steps'])-1)) {?><input type="button" name="next" class="next action-button" value="<?php echo smartyTranslate(array('s'=>'Next','mod'=>'tacartreminder'),$_smarty_tpl);?>
" /><?php }?>
							<input type="button" name="submitRule" class="action-button pull-right  save-button" value="<?php echo smartyTranslate(array('s'=>'Save','mod'=>'tacartreminder'),$_smarty_tpl);?>
" />
						</div>
					</div>
				</fieldset>
			<?php } ?>
		</div>
	</div>
</div>
<?php } elseif ($_smarty_tpl->tpl_vars['type_render']->value=='mail_template') {?>

<div class="row">
	<div class="col-sm-12 ta-form" id="mail_template_form">
		<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

	</div>
</div>
<?php }?>


<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayAdminView'),$_smarty_tpl);?>

<?php if (isset($_smarty_tpl->tpl_vars['name_controller']->value)) {?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo ucfirst($_smarty_tpl->tpl_vars['name_controller']->value);?>
View<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php } elseif (isset($_GET['controller'])) {?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo htmlentities(ucfirst($_GET['controller']));?>
View<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
