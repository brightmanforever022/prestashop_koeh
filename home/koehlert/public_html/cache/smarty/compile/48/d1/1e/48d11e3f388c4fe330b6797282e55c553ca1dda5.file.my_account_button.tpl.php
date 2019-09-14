<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 17:20:05
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/front/1.6/my_account_button.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9349353035d596ca5af2254-74943017%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48d11e3f388c4fe330b6797282e55c553ca1dda5' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/front/1.6/my_account_button.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9349353035d596ca5af2254-74943017',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'my_account_url' => 0,
    'url_location' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596ca5b09259_60414766',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596ca5b09259_60414766')) {function content_5d596ca5b09259_60414766($_smarty_tpl) {?>

<li><a href="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['my_account_url']->value);?>
" title="<?php echo smartyTranslate(array('s'=>'Newsletter Pro Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>
"><img style="float: left; margin-top: 12px; margin-left: 13px; vertical-align: middle;" src="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['url_location']->value);?>
views/img/newsletterpro_icon.png" alt="<?php echo smartyTranslate(array('s'=>'Newsletter Pro Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>
" class="icon" /><span><?php echo smartyTranslate(array('s'=>'Newsletter Pro Settings','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></a></li>
<?php }} ?>
