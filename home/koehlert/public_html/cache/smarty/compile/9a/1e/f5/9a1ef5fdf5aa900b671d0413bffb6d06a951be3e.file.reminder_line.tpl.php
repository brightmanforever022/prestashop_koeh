<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 18:38:19
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/reminder_line.tpl" */ ?>
<?php /*%%SmartyHeaderCode:705019435d60167b198c83-67781440%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a1ef5fdf5aa900b671d0413bffb6d06a951be3e' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/_configure/reminder_line.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '705019435d60167b198c83-67781440',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'position' => 0,
    'id_reminder' => 0,
    'manual_process' => 0,
    'mail_templates' => 0,
    'mail_template' => 0,
    'id_mail_template' => 0,
    'admin_mails' => 0,
    'nb_hour' => 0,
    'delete_avalable' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d60167b1f6418_23248868',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d60167b1f6418_23248868')) {function content_5d60167b1f6418_23248868($_smarty_tpl) {?>
<tr id="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_tr" data-id-reminder="<?php echo intval($_smarty_tpl->tpl_vars['id_reminder']->value);?>
">
	<td width="10px">
		<span class="ta-badge ta-badge-info"><?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
</span>
		<input type="hidden" name="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_id" value="<?php echo intval($_smarty_tpl->tpl_vars['id_reminder']->value);?>
" />
	</td>
	<td>
		<div >
				<label class="control-label">
					<span class="label-tooltip" 
						title="<?php echo smartyTranslate(array('s'=>'For example, if you want to call your customer directly. If other reminders exist, they will be executed only if you clicked completed.','mod'=>'tacartreminder'),$_smarty_tpl);?>
">
						<?php echo smartyTranslate(array('s'=>'Manual','mod'=>'tacartreminder'),$_smarty_tpl);?>

					</span>
				</label><br/><br/>
				<div >
					<span class="switch prestashop-switch" >
						<input type="radio" name="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_manual_process" class="radio-manual-process" data-pos-reminder="<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
" data-id-reminder="<?php echo intval($_smarty_tpl->tpl_vars['id_reminder']->value);?>
" id="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_manual_process_on" value="1" <?php if ($_smarty_tpl->tpl_vars['manual_process']->value) {?> checked="checked"<?php }?>/>
						<label for="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_manual_process_on"><?php echo smartyTranslate(array('s'=>'Yes','mod'=>'tacartreminder'),$_smarty_tpl);?>
</label>
						<input type="radio" name="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_manual_process" class="radio-manual-process" data-pos-reminder="<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
" data-id-reminder="<?php echo intval($_smarty_tpl->tpl_vars['id_reminder']->value);?>
" id="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_manual_process_off" value="0" <?php if (!$_smarty_tpl->tpl_vars['manual_process']->value) {?> checked="checked"<?php }?> />
						<label for="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_manual_process_off"><?php echo smartyTranslate(array('s'=>'No','mod'=>'tacartreminder'),$_smarty_tpl);?>
</label>
						<a class="slide-button btn"></a>
					</span>
				</div>
		</div>
	</td>
	<td>
		<div  id="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_id_mail_template" style="<?php if ($_smarty_tpl->tpl_vars['manual_process']->value) {?>display:none<?php }?>">
		<label class="control-label">
					<span class="label-tooltip" data-toggle="tooltip"
					title="<?php echo smartyTranslate(array('s'=>'Select an email template','mod'=>'tacartreminder'),$_smarty_tpl);?>
">
						<?php echo smartyTranslate(array('s'=>'Email template','mod'=>'tacartreminder'),$_smarty_tpl);?>

					</span>
				</label><br/><br/>
		<select name="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_id_mail_template" >
			<option value=""><?php echo smartyTranslate(array('s'=>'-- Choose --','mod'=>'tacartreminder'),$_smarty_tpl);?>
</option>
			<?php if (isset($_smarty_tpl->tpl_vars['mail_templates']->value)&&count($_smarty_tpl->tpl_vars['mail_templates']->value)) {?>
				<?php  $_smarty_tpl->tpl_vars['mail_template'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mail_template']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mail_templates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mail_template']->key => $_smarty_tpl->tpl_vars['mail_template']->value) {
$_smarty_tpl->tpl_vars['mail_template']->_loop = true;
?>
					<option value="<?php echo intval($_smarty_tpl->tpl_vars['mail_template']->value['id_mail_template']);?>
" <?php if ($_smarty_tpl->tpl_vars['id_mail_template']->value==$_smarty_tpl->tpl_vars['mail_template']->value['id_mail_template']) {?>selected<?php }?>>
						<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['mail_template']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

					</option>
				<?php } ?>
			<?php }?>
		</select>
		</div>
		<div   id="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_admin_mails" style="<?php if (!$_smarty_tpl->tpl_vars['manual_process']->value) {?>display:none<?php }?>">
			<label class="control-label">
					<span class="label-tooltip" data-toggle="tooltip"
					title="<?php echo smartyTranslate(array('s'=>'This field permit to specify the email addresses to be notified. 
								 A message with the customer information and the contents of the cart will be sent.
								 If you want multiple addresses, you must be separated by commas eg : email1@example.com, email2@example.com','mod'=>'tacartreminder'),$_smarty_tpl);?>
">
						<?php echo smartyTranslate(array('s'=>'Admin Mails','mod'=>'tacartreminder'),$_smarty_tpl);?>

					</span>
				</label><br/><br/>
				<input name="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_admin_mails"  type="text" placeholder="<?php echo smartyTranslate(array('s'=>'eg : admin@myshop.com','mod'=>'tacartreminder'),$_smarty_tpl);?>
" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['admin_mails']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
		</div>
	</td>
	<td width="150px">
		<?php if ($_smarty_tpl->tpl_vars['position']->value==1) {?>
		<label class="control-label">
			<span class="label-tooltip" data-toggle="tooltip"
				  title="<?php echo smartyTranslate(array('s'=>'Number of hours after the cart is considered abandoned','mod'=>'tacartreminder'),$_smarty_tpl);?>
">
						<?php echo smartyTranslate(array('s'=>'After abandonned','mod'=>'tacartreminder'),$_smarty_tpl);?>

			</span>
		</label>
		<?php } elseif ($_smarty_tpl->tpl_vars['position']->value>1) {?>
		<label class="control-label">
			<span class="label-tooltip" data-toggle="tooltip"
				  title="<?php echo smartyTranslate(array('s'=>'Number of hours after the reminder %s is executed','mod'=>'tacartreminder','sprintf'=>($_smarty_tpl->tpl_vars['position']->value-1)),$_smarty_tpl);?>
">
						<?php echo smartyTranslate(array('s'=>'After reminder %s','mod'=>'tacartreminder','sprintf'=>($_smarty_tpl->tpl_vars['position']->value-1)),$_smarty_tpl);?>

			</span>
		</label>
		<?php }?>
		
		<br/><br/>
		<div class="input-group">
			
			<span class="input-group-addon"><?php echo smartyTranslate(array('s'=>'hour','mod'=>'tacartreminder'),$_smarty_tpl);?>
</span>
			<input type="text" name="reminder_<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
_nb_hour" class="input-mini" value="<?php echo floatval($_smarty_tpl->tpl_vars['nb_hour']->value);?>
"></input>
		</div>
	</td>
	<td class="action_delete" data-position="<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
">
		<?php if ($_smarty_tpl->tpl_vars['delete_avalable']->value) {?>
		<a class="btn btn-default check_reminder_to_delete" data-pos-reminder="<?php echo intval($_smarty_tpl->tpl_vars['position']->value);?>
" data-id-reminder="<?php echo intval($_smarty_tpl->tpl_vars['id_reminder']->value);?>
" href="javascript:;" >
			<i class="flaticon-cancel6"></i>
		</a>
		<?php }?>
	</td>
</tr><?php }} ?>
