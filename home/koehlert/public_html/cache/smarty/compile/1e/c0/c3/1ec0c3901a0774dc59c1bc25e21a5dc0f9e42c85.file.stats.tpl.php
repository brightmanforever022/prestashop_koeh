<?php /* Smarty version Smarty-3.1.19, created on 2019-08-20 10:31:24
         compiled from "/home/koehlert/public_html/modules/khlbasic/views/templates/admin/salesstats/stats.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14039252385d5bafdc7c86d3-14567663%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ec0c3901a0774dc59c1bc25e21a5dc0f9e42c85' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlbasic/views/templates/admin/salesstats/stats.tpl',
      1 => 1545910165,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14039252385d5bafdc7c86d3-14567663',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'note_text' => 0,
    'stats_mode' => 0,
    'currentIndex' => 0,
    'token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5bafdc808b23_21168597',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5bafdc808b23_21168597')) {function content_5d5bafdc808b23_21168597($_smarty_tpl) {?>
<div class="panel">
	<p class="text-muted"><?php echo $_smarty_tpl->tpl_vars['note_text']->value;?>

	</p>
	<ul class="nav nav-pills nav-justified">
		<li class="">
			<a class="btn <?php if ($_smarty_tpl->tpl_vars['stats_mode']->value=='daily') {?>btn-primary<?php } else { ?>btn-default<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['currentIndex']->value;?>
&token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
&mode=daily"><?php echo smartyTranslate(array('s'=>'Daily'),$_smarty_tpl);?>
</a></li>
		<li class="">
			<a class="btn <?php if ($_smarty_tpl->tpl_vars['stats_mode']->value=='weekly') {?>btn-primary<?php } else { ?>btn-default<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['currentIndex']->value;?>
&token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
&mode=weekly"><?php echo smartyTranslate(array('s'=>'Weekly'),$_smarty_tpl);?>
</a></li>
		<li >
			<a class="btn <?php if ($_smarty_tpl->tpl_vars['stats_mode']->value=='monthly') {?>btn-primary<?php } else { ?>btn-default<?php }?>" href="<?php echo $_smarty_tpl->tpl_vars['currentIndex']->value;?>
&token=<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
&mode=monthly"><?php echo smartyTranslate(array('s'=>'Monthly'),$_smarty_tpl);?>
</a></li>
	</ul>
	<?php if ($_smarty_tpl->tpl_vars['stats_mode']->value=='daily') {?>
		<?php echo $_smarty_tpl->getSubTemplate ('./stats_daily.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php } elseif ($_smarty_tpl->tpl_vars['stats_mode']->value=='weekly') {?>
		<?php echo $_smarty_tpl->getSubTemplate ('./stats_weekly.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php } elseif ($_smarty_tpl->tpl_vars['stats_mode']->value=='monthly') {?>
		<?php echo $_smarty_tpl->getSubTemplate ('./stats_monthly.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php }?>
</div><?php }} ?>
