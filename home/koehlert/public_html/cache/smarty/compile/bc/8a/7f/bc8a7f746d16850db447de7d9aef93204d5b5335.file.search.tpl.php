<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:40:35
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4167733785d5963632b5e70-25241452%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc8a7f746d16850db447de7d9aef93204d5b5335' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/search.tpl',
      1 => 1481185475,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4167733785d5963632b5e70-25241452',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'instant_search' => 0,
    'nbProducts' => 0,
    'search_query' => 0,
    'search_tag' => 0,
    'ref' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5963632e9d95_63909723',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5963632e9d95_63909723')) {function content_5d5963632e9d95_63909723($_smarty_tpl) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Search'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

    <?php if (isset($_smarty_tpl->tpl_vars['instant_search']->value)&&$_smarty_tpl->tpl_vars['instant_search']->value) {?>
        <a href="#" class="close">
            <?php echo smartyTranslate(array('s'=>'Return to the previous page'),$_smarty_tpl);?>

        </a>
    <?php } else { ?>
        
    <?php }?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if (!$_smarty_tpl->tpl_vars['nbProducts']->value) {?>
	<p class="alert alert-warning">
		<?php if (isset($_smarty_tpl->tpl_vars['search_query']->value)&&$_smarty_tpl->tpl_vars['search_query']->value) {?>
			<?php echo smartyTranslate(array('s'=>'No results were found for your search'),$_smarty_tpl);?>
&nbsp;"<?php if (isset($_smarty_tpl->tpl_vars['search_query']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"
		<?php } elseif (isset($_smarty_tpl->tpl_vars['search_tag']->value)&&$_smarty_tpl->tpl_vars['search_tag']->value) {?>
			<?php echo smartyTranslate(array('s'=>'No results were found for your search'),$_smarty_tpl);?>
&nbsp;"<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_tag']->value, ENT_QUOTES, 'UTF-8', true);?>
"
		<?php } else { ?>
			<?php echo smartyTranslate(array('s'=>'Please enter a search keyword'),$_smarty_tpl);?>

		<?php }?>
	</p>
<?php } else { ?>
    <?php $_smarty_tpl->_capture_stack[0][] = array('searchText', null, null); ob_start(); ?><?php if (isset($_smarty_tpl->tpl_vars['search_query']->value)&&$_smarty_tpl->tpl_vars['search_query']->value) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } elseif ($_smarty_tpl->tpl_vars['search_tag']->value) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_tag']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } elseif ($_smarty_tpl->tpl_vars['ref']->value) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ref']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
        <span class="lighter">
        <?php echo smartyTranslate(array('s'=>'Search for "%s", %d results found','sprintf'=>array(Smarty::$_smarty_vars['capture']['searchText'],$_smarty_tpl->tpl_vars['nbProducts']->value)),$_smarty_tpl);?>
  
        </span>
    
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./sub/product/product-list-form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php }} ?>
