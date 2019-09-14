<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 16:41:21
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/live_cart_reminder/reminder-line.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14681935545d5ffb11acb0b5-78768657%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'afa414b67cf4752645f67a2f138dcf69a533e7f6' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/live_cart_reminder/reminder-line.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14681935545d5ffb11acb0b5-78768657',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id_cart' => 0,
    'journal_reminder' => 0,
    'reminder' => 0,
    'to_launch' => 0,
    'to_accomplish' => 0,
    'journal_reminder_position' => 0,
    'cart_reminder_to_close' => 0,
    'nbsecond' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ffb11b877d8_87123378',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ffb11b877d8_87123378')) {function content_5d5ffb11b877d8_87123378($_smarty_tpl) {?>
<tr class="reminder-action-line reminder-line-<?php echo intval($_smarty_tpl->tpl_vars['id_cart']->value);?>
 <?php if (($_smarty_tpl->tpl_vars['journal_reminder']->value&&$_smarty_tpl->tpl_vars['journal_reminder']->value['manual_process'])||(!$_smarty_tpl->tpl_vars['journal_reminder']->value&&$_smarty_tpl->tpl_vars['reminder']->value['manual_process'])) {?>manual-process<?php }?>" style="display:none">
	<td style="padding:7px;">
		<span class="position_reminder_line <?php if ($_smarty_tpl->tpl_vars['to_launch']->value) {?>pendinglaunch<?php }?><?php if ($_smarty_tpl->tpl_vars['to_accomplish']->value) {?>pendingaccomplish<?php }?>" style="background-color:<?php if ($_smarty_tpl->tpl_vars['journal_reminder']->value&&!$_smarty_tpl->tpl_vars['to_accomplish']->value) {?>#79bd3c<?php } elseif ($_smarty_tpl->tpl_vars['to_launch']->value) {?>orange<?php } elseif ($_smarty_tpl->tpl_vars['to_accomplish']->value) {?>#FF0066<?php } else { ?>#999<?php }?>">
			<?php if (isset($_smarty_tpl->tpl_vars['journal_reminder_position']->value)) {?><?php echo intval($_smarty_tpl->tpl_vars['journal_reminder_position']->value);?>
<?php } elseif (isset($_smarty_tpl->tpl_vars['reminder']->value)) {?><?php echo intval($_smarty_tpl->tpl_vars['reminder']->value['position']);?>
<?php } else { ?>?<?php }?>
		</span>
	</td>
	<td>
		<?php if ($_smarty_tpl->tpl_vars['journal_reminder']->value) {?>
			<?php if (!$_smarty_tpl->tpl_vars['journal_reminder']->value['manual_process']) {?>
				<?php if ($_smarty_tpl->tpl_vars['journal_reminder']->value['isopen']) {?>
					<i class="flaticon flaticon-eye46" style="color:#79bd3c;font-size:16px;" title="<?php echo smartyTranslate(array('s'=>'The email was opened','mod'=>'tacartreminder'),$_smarty_tpl);?>
"></i>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['journal_reminder']->value['isclick']) {?>
					<i class="flaticon flaticon-left27" style="color:#79bd3c;font-size:22px;" title="<?php echo smartyTranslate(array('s'=>'The email was clicked','mod'=>'tacartreminder'),$_smarty_tpl);?>
"></i>
				<?php }?>
				<br/>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['journal_reminder']->value['manual_process']) {?>
				<?php if ($_smarty_tpl->tpl_vars['journal_reminder']->value['performed']) {?>
					<span style="font-size:10px"><?php echo smartyTranslate(array('s'=>'Completed on ','mod'=>'tacartreminder'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['journal_reminder']->value['date_performed'],'full'=>1),$_smarty_tpl);?>
 
					<?php if (intval($_smarty_tpl->tpl_vars['journal_reminder']->value['id_employee'])) {?><?php echo smartyTranslate(array('s'=>'by','mod'=>'tacartreminder'),$_smarty_tpl);?>
 <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['journal_reminder']->value['e_firstname'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['journal_reminder']->value['e_lastname'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?></span>
				<?php } elseif (!$_smarty_tpl->tpl_vars['to_accomplish']->value) {?>
					<span style="font-size:10px"><?php echo smartyTranslate(array('s'=>'Not Completed','mod'=>'tacartreminder'),$_smarty_tpl);?>
</span>
				<?php }?>
			<?php } else { ?>
				<span style="font-size:10px"><?php echo smartyTranslate(array('s'=>'Sent on ','mod'=>'tacartreminder'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['journal_reminder']->value['date_performed'],'full'=>1),$_smarty_tpl);?>
</span>
			<?php }?>
		<?php }?>
		<?php if (!$_smarty_tpl->tpl_vars['journal_reminder']->value&&$_smarty_tpl->tpl_vars['to_launch']->value&&$_smarty_tpl->tpl_vars['cart_reminder_to_close']->value) {?>
			<?php echo smartyTranslate(array('s'=>'The rule no longer applies. The reminder will be canceled','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['to_accomplish']->value) {?>
			<?php echo smartyTranslate(array('s'=>'To do','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif (!$_smarty_tpl->tpl_vars['journal_reminder']->value&&$_smarty_tpl->tpl_vars['to_launch']->value&&$_smarty_tpl->tpl_vars['nbsecond']->value>0) {?>
			<span class="flip-clock-wrapper" data-id-reminder="<?php echo intval($_smarty_tpl->tpl_vars['reminder']->value['id_reminder']);?>
" data-nb-second="<?php echo intval($_smarty_tpl->tpl_vars['nbsecond']->value);?>
"/>
		<?php } elseif (!$_smarty_tpl->tpl_vars['journal_reminder']->value&&!$_smarty_tpl->tpl_vars['to_launch']->value) {?>
			<?php echo smartyTranslate(array('s'=>'Pending previous reminder','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php } elseif (!$_smarty_tpl->tpl_vars['journal_reminder']->value&&$_smarty_tpl->tpl_vars['to_launch']->value) {?>
			<?php echo smartyTranslate(array('s'=>'Pending action','mod'=>'tacartreminder'),$_smarty_tpl);?>

		<?php }?>
	</td>
	<td style="padding:0">
		<?php if (($_smarty_tpl->tpl_vars['journal_reminder']->value&&$_smarty_tpl->tpl_vars['journal_reminder']->value['manual_process']&&!$_smarty_tpl->tpl_vars['to_accomplish']->value)||(isset($_smarty_tpl->tpl_vars['reminder']->value)&&($_smarty_tpl->tpl_vars['journal_reminder']->value||($_smarty_tpl->tpl_vars['to_launch']->value&&!$_smarty_tpl->tpl_vars['cart_reminder_to_close']->value)))) {?>
			<?php if (($_smarty_tpl->tpl_vars['journal_reminder']->value&&$_smarty_tpl->tpl_vars['journal_reminder']->value['manual_process'])||(!$_smarty_tpl->tpl_vars['journal_reminder']->value&&$_smarty_tpl->tpl_vars['reminder']->value['manual_process'])) {?>
				<a href="javascript:;" data-id-reminder="<?php echo intval($_smarty_tpl->tpl_vars['reminder']->value['id_reminder']);?>
" data-id-cart="<?php echo intval($_smarty_tpl->tpl_vars['id_cart']->value);?>
" class="launch-reminder-manual" ><i class="flaticon-support3" style="font-size:20px;cursor:pointer;"></i></a>
			<?php } else { ?>
				<a href="javascript:;" data-id-reminder="<?php echo intval($_smarty_tpl->tpl_vars['reminder']->value['id_reminder']);?>
" data-id-cart="<?php echo intval($_smarty_tpl->tpl_vars['id_cart']->value);?>
" class="launch-reminder"><i class="flaticon-mail29" style="font-size:20px;cursor:pointer;"></i></a>
			<?php }?>
		<?php }?>
	</td>
</tr>
<?php if (($_smarty_tpl->tpl_vars['journal_reminder']->value&&!$_smarty_tpl->tpl_vars['journal_reminder']->value['manual_process'])||(!$_smarty_tpl->tpl_vars['journal_reminder']->value&&!$_smarty_tpl->tpl_vars['reminder']->value['manual_process']&&!$_smarty_tpl->tpl_vars['cart_reminder_to_close']->value)) {?>
<tr class="reminder-mail-line reminder-line-<?php echo intval($_smarty_tpl->tpl_vars['id_cart']->value);?>
" style="display:none">
	<td colspan="3" style="text-align:center"><i ><?php if (!$_smarty_tpl->tpl_vars['journal_reminder']->value) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['reminder']->value['mail_template_name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php } else { ?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['journal_reminder']->value['mail_name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?></i></td>
</tr>
<?php }?><?php }} ?>
