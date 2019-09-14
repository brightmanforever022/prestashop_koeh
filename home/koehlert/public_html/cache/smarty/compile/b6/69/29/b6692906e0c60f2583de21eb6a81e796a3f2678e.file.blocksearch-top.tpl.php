<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:27:46
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/modules/blocksearch/blocksearch-top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11105449195d59606224f063-14101833%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6692906e0c60f2583de21eb6a81e796a3f2678e' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/modules/blocksearch/blocksearch-top.tpl',
      1 => 1535124339,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11105449195d59606224f063-14101833',
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
  'unifunc' => 'content_5d59606225d4e7_40850686',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59606225d4e7_40850686')) {function content_5d59606225d4e7_40850686($_smarty_tpl) {?>

<!-- Block search module TOP -->
<div id="search_block_top" class="pull-right e-scale popup-over">
		<form id="searchbox" method="get" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search',null,null,null,false,null,true), ENT_QUOTES, 'UTF-8', true);?>
" >
			<input type="hidden" name="controller" value="search" />
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="orderway" value="desc" />
			<button type="submit" name="submit_search" class="fa fa-search">&nbsp;</button> 
			<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="<?php echo smartyTranslate(array('s'=>'Search products','mod'=>'blocksearch'),$_smarty_tpl);?>
" value="<?php echo stripslashes(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
" />
		</form>
</div>
<!-- /Block search module TOP --><?php }} ?>
