<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:37
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/filter_by_range.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10293679445d5a47ad53fa15-44944546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15de3a7d4a947c1dd51221d5e5fc9fceedfde07a' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/filter_by_range.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10293679445d5a47ad53fa15-44944546',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47ad54c669_47464602',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47ad54c669_47464602')) {function content_5d5a47ad54c669_47464602($_smarty_tpl) {?>

<div id="range-selection-box" class="range-selection-box">	
	<div class="slider-container">
		<label><?php echo smartyTranslate(array('s'=>'Range','mod'=>'newsletterpro'),$_smarty_tpl);?>
</label>
		<div id="slider-range-selection"></div>
	</div>
</div>
<?php }} ?>
