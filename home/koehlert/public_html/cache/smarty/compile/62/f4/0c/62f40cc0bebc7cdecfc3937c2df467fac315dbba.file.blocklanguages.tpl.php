<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:27:45
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/modules/blocklanguages/blocklanguages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8887406025d596061d263b3-73681536%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62f40cc0bebc7cdecfc3937c2df467fac315dbba' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/modules/blocklanguages/blocklanguages.tpl',
      1 => 1481597744,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8887406025d596061d263b3-73681536',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'languages' => 0,
    'language' => 0,
    'lang_iso' => 0,
    'indice_lang' => 0,
    'lang_rewrite_urls' => 0,
    'lang_leo_rewrite_urls' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596061d506a9_84168832',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596061d506a9_84168832')) {function content_5d596061d506a9_84168832($_smarty_tpl) {?>
<!-- Block languages module -->
	<div class="pull-right languages-block" id="languages-block-top">
            <ul id="first-languages" class="languages-block_ul">
            <?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['language']->key;
?>
		<li <?php if ($_smarty_tpl->tpl_vars['language']->value['iso_code']==$_smarty_tpl->tpl_vars['lang_iso']->value) {?>class="selected"<?php }?>>
		<?php if ($_smarty_tpl->tpl_vars['language']->value['iso_code']!=$_smarty_tpl->tpl_vars['lang_iso']->value) {?>
                    <?php if (isset($_smarty_tpl->tpl_vars['indice_lang'])) {$_smarty_tpl->tpl_vars['indice_lang'] = clone $_smarty_tpl->tpl_vars['indice_lang'];
$_smarty_tpl->tpl_vars['indice_lang']->value = $_smarty_tpl->tpl_vars['language']->value['id_lang']; $_smarty_tpl->tpl_vars['indice_lang']->nocache = null; $_smarty_tpl->tpl_vars['indice_lang']->scope = 0;
} else $_smarty_tpl->tpl_vars['indice_lang'] = new Smarty_variable($_smarty_tpl->tpl_vars['language']->value['id_lang'], null, 0);?>
                    <?php if (isset($_smarty_tpl->tpl_vars['lang_rewrite_urls']->value[$_smarty_tpl->tpl_vars['indice_lang']->value])) {?>
			<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lang_rewrite_urls']->value[$_smarty_tpl->tpl_vars['indice_lang']->value], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
">
                    <?php } elseif (isset($_smarty_tpl->tpl_vars['lang_leo_rewrite_urls']->value[$_smarty_tpl->tpl_vars['indice_lang']->value])) {?>
			<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lang_leo_rewrite_urls']->value[$_smarty_tpl->tpl_vars['indice_lang']->value], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
">
		    <?php } else { ?>
			<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getLanguageLink($_smarty_tpl->tpl_vars['language']->value['id_lang']), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
">
		    <?php }?>
		<?php }?>
                        <?php echo strtoupper($_smarty_tpl->tpl_vars['language']->value['iso_code']);?>

                    <?php if ($_smarty_tpl->tpl_vars['language']->value['iso_code']!=$_smarty_tpl->tpl_vars['lang_iso']->value) {?>
			</a>
                    <?php }?>
		</li>
	    <?php } ?>
            </ul>
		
	</div>
			
<!-- /Block languages module -->
<?php }} ?>
