<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 16:41:22
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/menu-top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20497697035d5ffb120ad400-20995136%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78dc8bd7f6f16f4f63a27dcf303700e50ca58989' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/menu-top.tpl',
      1 => 1521714356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20497697035d5ffb120ad400-20995136',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'count_manual' => 0,
    'ta_cr_tab_select' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5ffb120dbff0_45807205',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5ffb120dbff0_45807205')) {function content_5d5ffb120dbff0_45807205($_smarty_tpl) {?>
<script type="text/javascript">
$(document).ready(function(){
		var setting_url = '<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminModules'));?>
&configure=tacartreminder&tab_select=settings';
		var admin_controller_url = '<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminLiveCartReminder'));?>
';
		$('.ta-module-admin-nav li').live('click', function(){
				if($(this).data('tabSelect')=='settings')
					location.href = setting_url;
				else 
					location.href = admin_controller_url + '&tab_select=' + $(this).data('tabSelect');
		});
	});
</script>
<div class="ta-module-admin-nav">
  <nav>
    <ul>
      <?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['count_manual']->value);?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1>0) {?><li class="<?php if ($_smarty_tpl->tpl_vars['ta_cr_tab_select']->value=='manual') {?>tab-current <?php }?>apple" data-tab-select='manual'><a class="flaticon flaticon-support3"><span><?php echo smartyTranslate(array('s'=>'Manual to do','mod'=>'tacartreminder'),$_smarty_tpl);?>
</span><div class="ta-badge ta-badge-warning nav-animate-badge"><?php echo intval($_smarty_tpl->tpl_vars['count_manual']->value);?>
</div></a></li><?php }?>
      <li class="<?php if ($_smarty_tpl->tpl_vars['ta_cr_tab_select']->value=='cart') {?>tab-current <?php }?>purple" data-tab-select='cart'><a class="flaticon flaticon-shopping11"><span><?php echo smartyTranslate(array('s'=>'Cart','mod'=>'tacartreminder'),$_smarty_tpl);?>
</span></a></li>
      <li class="<?php if ($_smarty_tpl->tpl_vars['ta_cr_tab_select']->value=='running') {?>tab-current <?php }?>apple" data-tab-select='running'><a class="flaticon flaticon-chronometer10"><span><?php echo smartyTranslate(array('s'=>'Running','mod'=>'tacartreminder'),$_smarty_tpl);?>
</span></a></li>
      <li class="<?php if ($_smarty_tpl->tpl_vars['ta_cr_tab_select']->value=='finished') {?>tab-current <?php }?>apple" data-tab-select='finished'><a class="flaticon flaticon-task"><span><?php echo smartyTranslate(array('s'=>'Completed','mod'=>'tacartreminder'),$_smarty_tpl);?>
</span></a></li>
      <li class="<?php if ($_smarty_tpl->tpl_vars['ta_cr_tab_select']->value=='unsubscribes') {?>tab-current <?php }?>apple" data-tab-select='unsubscribes'><a class="flaticon flaticon-man403"><span><?php echo smartyTranslate(array('s'=>'Unsubscribed','mod'=>'tacartreminder'),$_smarty_tpl);?>
</span></a></li>
      <li class="<?php if ($_smarty_tpl->tpl_vars['ta_cr_tab_select']->value=='stats') {?>tab-current <?php }?>apple" data-tab-select='stats'><a class="flaticon flaticon-ascendant6"><span><?php echo smartyTranslate(array('s'=>'Statistics','mod'=>'tacartreminder'),$_smarty_tpl);?>
</span></a></li>
      <li class="<?php if ($_smarty_tpl->tpl_vars['ta_cr_tab_select']->value=='settings') {?>tab-current <?php }?>apple" data-tab-select='settings'><a class="flaticon flaticon-tools6"><span><?php echo smartyTranslate(array('s'=>'Settings','mod'=>'tacartreminder'),$_smarty_tpl);?>
</span></a></li>
    </ul>
  </nav>
</div>
<?php }} ?>
