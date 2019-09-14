<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:27:46
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8110933505d59606227cf86-64348951%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82e00f28900fc14b85c1b96ca805da4cb4045af7' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/footer.tpl',
      1 => 1536580952,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8110933505d59606227cf86-64348951',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'LEO_LAYOUT_DIRECTION' => 0,
    'HOOK_BOTTOM' => 0,
    'left_column_size' => 0,
    'right_column_size' => 0,
    'cols' => 0,
    'HOOK_FOOTER' => 0,
    'HOOK_FOOTNAV' => 0,
    'LEO_PANELTOOL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5960622b08b9_50184698',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5960622b08b9_50184698')) {function content_5d5960622b08b9_50184698($_smarty_tpl) {?>

<?php if (!isset($_smarty_tpl->tpl_vars['content_only']->value)||!$_smarty_tpl->tpl_vars['content_only']->value) {?>
						<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./layout/".((string)$_smarty_tpl->tpl_vars['LEO_LAYOUT_DIRECTION']->value)."/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


                
                	</div>
				</div>
				
            </section>
<!-- Footer -->
            <?php if (isset($_smarty_tpl->tpl_vars['HOOK_BOTTOM']->value)&&!empty($_smarty_tpl->tpl_vars['HOOK_BOTTOM']->value)) {?>
			
				<section id="bottom">
				<div class="container">	
				<?php if (isset($_smarty_tpl->tpl_vars['left_column_size']->value)&&isset($_smarty_tpl->tpl_vars['right_column_size']->value)) {?><?php if (isset($_smarty_tpl->tpl_vars['cols'])) {$_smarty_tpl->tpl_vars['cols'] = clone $_smarty_tpl->tpl_vars['cols'];
$_smarty_tpl->tpl_vars['cols']->value = (12-$_smarty_tpl->tpl_vars['left_column_size']->value-$_smarty_tpl->tpl_vars['right_column_size']->value); $_smarty_tpl->tpl_vars['cols']->nocache = null; $_smarty_tpl->tpl_vars['cols']->scope = 0;
} else $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable((12-$_smarty_tpl->tpl_vars['left_column_size']->value-$_smarty_tpl->tpl_vars['right_column_size']->value), null, 0);?><?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['cols'])) {$_smarty_tpl->tpl_vars['cols'] = clone $_smarty_tpl->tpl_vars['cols'];
$_smarty_tpl->tpl_vars['cols']->value = 12; $_smarty_tpl->tpl_vars['cols']->nocache = null; $_smarty_tpl->tpl_vars['cols']->scope = 0;
} else $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable(12, null, 0);?><?php }?>
				<div class="<?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['cols']->value);?>
<?php $_tmp9=ob_get_clean();?><?php if ($_tmp9!=12) {?>row<?php } else { ?>inner<?php }?>">
					<?php echo $_smarty_tpl->tpl_vars['HOOK_BOTTOM']->value;?>

				</div>
				</div>
				</section>
			<?php }?>
		<!-- Footer -->
			<footer id="footer" class="footer-container">       
				<div class="container"> 
					<div class="inner">	
						<?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>
							
					</div> 
				</div>
				<?php if (isset($_smarty_tpl->tpl_vars['HOOK_FOOTNAV']->value)&&!empty($_smarty_tpl->tpl_vars['HOOK_FOOTNAV']->value)) {?>
				<div class="footer-nav">
					<div class="container">
						<div class="inner">
							<?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTNAV']->value;?>

						</div>
					</div>
				</div>
				<?php }?>
            </footer>
		</section><!-- #page -->
<?php }?>
<p id="back-top">
<a href="#top" title="<?php echo smartyTranslate(array('s'=>'Scroll To Top'),$_smarty_tpl);?>
"></a>
</p>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./global.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if (isset($_smarty_tpl->tpl_vars['LEO_PANELTOOL']->value)&&$_smarty_tpl->tpl_vars['LEO_PANELTOOL']->value) {?>
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./info/paneltool.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayTemplate"),$_smarty_tpl);?>

	</body>
</html><?php }} ?>
