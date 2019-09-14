<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:40:34
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/modules/mailalerts/views/templates/hook/my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19537277285d596362e94bc2-21924951%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6117cc601262bf70b96c05da976ef97776c07df1' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/modules/mailalerts/views/templates/hook/my-account.tpl',
      1 => 1442250768,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19537277285d596362e94bc2-21924951',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596362e9d051_03396996',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596362e9d051_03396996')) {function content_5d596362e9d051_03396996($_smarty_tpl) {?>

<li class="mailalerts">
	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('mailalerts','account',array(),true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'My alerts','mod'=>'mailalerts'),$_smarty_tpl);?>
" rel="nofollow">
    	<i class="fa fa-envelope"></i>
		<span><?php echo smartyTranslate(array('s'=>'My alerts','mod'=>'mailalerts'),$_smarty_tpl);?>
</span>
	</a>
</li>
<?php }} ?>
