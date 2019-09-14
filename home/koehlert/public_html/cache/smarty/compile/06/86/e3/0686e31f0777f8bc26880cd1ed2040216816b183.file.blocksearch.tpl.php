<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:40:34
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/modules/blocksearch/blocksearch.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2595222045d596362f2e748-21298202%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0686e31f0777f8bc26880cd1ed2040216816b183' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/modules/blocksearch/blocksearch.tpl',
      1 => 1535474306,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2595222045d596362f2e748-21298202',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'search_query' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596362f3c053_68217965',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596362f3c053_68217965')) {function content_5d596362f3c053_68217965($_smarty_tpl) {?>

<!-- Block search module -->
<div id="search_block_left" class="block exclusive">
	<form method="get" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search',true,null,null,false,null,true), ENT_QUOTES, 'UTF-8', true);?>
" id="searchbox">
		<p class="block_content clearfix">
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="controller" value="search" />
			<input type="hidden" name="orderway" value="desc" />
			<button type="submit" name="submit_search" class="fa fa-search">&nbsp;</button>
			<input class="search_query form-control grey" type="text" id="search_query_block" name="search_query" placeholder="<?php echo smartyTranslate(array('s'=>'Search products','mod'=>stripslashes(mb_convert_encoding(htmlspecialchars('blocksearch', ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'))),$_smarty_tpl);?>
" value="<?php echo stripslashes(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
" />
		</p>
	</form>
</div>
<!-- /Block search module --><?php }} ?>
