<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:40:35
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/pagination.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1174375445d596363585dd8-52390776%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b3327c6d8bcf51dc3e70e2c335f7db0b8a7825f0' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/pagination.tpl',
      1 => 1518535829,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1174375445d596363585dd8-52390776',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nb_products' => 0,
    'products_per_page' => 0,
    'start' => 0,
    'stop' => 0,
    'no_follow' => 0,
    'p' => 0,
    'seoUrls' => 0,
    'category' => 0,
    'current_url' => 0,
    'link' => 0,
    'manufacturer' => 0,
    'supplier' => 0,
    'paginationId' => 0,
    'requestNb' => 0,
    'search_query' => 0,
    'tag' => 0,
    'requestKey' => 0,
    'requestValue' => 0,
    'no_follow_text' => 0,
    'requestPage' => 0,
    'p_previous' => 0,
    'pages_nb' => 0,
    'p_next' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596363642b78_52017973',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596363642b78_52017973')) {function content_5d596363642b78_52017973($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['nb_products']->value>$_smarty_tpl->tpl_vars['products_per_page']->value&&$_smarty_tpl->tpl_vars['start']->value!=$_smarty_tpl->tpl_vars['stop']->value) {?>
<?php if (isset($_smarty_tpl->tpl_vars['no_follow']->value)&&$_smarty_tpl->tpl_vars['no_follow']->value) {?>
	<?php if (isset($_smarty_tpl->tpl_vars['no_follow_text'])) {$_smarty_tpl->tpl_vars['no_follow_text'] = clone $_smarty_tpl->tpl_vars['no_follow_text'];
$_smarty_tpl->tpl_vars['no_follow_text']->value = 'rel="nofollow"'; $_smarty_tpl->tpl_vars['no_follow_text']->nocache = null; $_smarty_tpl->tpl_vars['no_follow_text']->scope = 0;
} else $_smarty_tpl->tpl_vars['no_follow_text'] = new Smarty_variable('rel="nofollow"', null, 0);?>
<?php } else { ?>
	<?php if (isset($_smarty_tpl->tpl_vars['no_follow_text'])) {$_smarty_tpl->tpl_vars['no_follow_text'] = clone $_smarty_tpl->tpl_vars['no_follow_text'];
$_smarty_tpl->tpl_vars['no_follow_text']->value = ''; $_smarty_tpl->tpl_vars['no_follow_text']->nocache = null; $_smarty_tpl->tpl_vars['no_follow_text']->scope = 0;
} else $_smarty_tpl->tpl_vars['no_follow_text'] = new Smarty_variable('', null, 0);?>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['p']->value)&&$_smarty_tpl->tpl_vars['p']->value) {?>
    <?php if (!isset($_smarty_tpl->tpl_vars['seoUrls']->value)) {?>
         <?php if (isset($_smarty_tpl->tpl_vars['seoUrls'])) {$_smarty_tpl->tpl_vars['seoUrls'] = clone $_smarty_tpl->tpl_vars['seoUrls'];
$_smarty_tpl->tpl_vars['seoUrls']->value = false; $_smarty_tpl->tpl_vars['seoUrls']->nocache = null; $_smarty_tpl->tpl_vars['seoUrls']->scope = 0;
} else $_smarty_tpl->tpl_vars['seoUrls'] = new Smarty_variable(false, null, 0);?>
    <?php }?>
	<?php if (isset($_GET['id_category'])&&$_GET['id_category']&&isset($_smarty_tpl->tpl_vars['category']->value)) {?>
		<?php if (!isset($_smarty_tpl->tpl_vars['current_url']->value)) {?>
			<?php if (isset($_smarty_tpl->tpl_vars['requestPage'])) {$_smarty_tpl->tpl_vars['requestPage'] = clone $_smarty_tpl->tpl_vars['requestPage'];
$_smarty_tpl->tpl_vars['requestPage']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink('category',$_smarty_tpl->tpl_vars['category']->value,false,false,true,false); $_smarty_tpl->tpl_vars['requestPage']->nocache = null; $_smarty_tpl->tpl_vars['requestPage']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('category',$_smarty_tpl->tpl_vars['category']->value,false,false,true,false), null, 0);?>
		<?php } else { ?>
			<?php if (isset($_smarty_tpl->tpl_vars['requestPage'])) {$_smarty_tpl->tpl_vars['requestPage'] = clone $_smarty_tpl->tpl_vars['requestPage'];
$_smarty_tpl->tpl_vars['requestPage']->value = $_smarty_tpl->tpl_vars['current_url']->value; $_smarty_tpl->tpl_vars['requestPage']->nocache = null; $_smarty_tpl->tpl_vars['requestPage']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['current_url']->value, null, 0);?>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['requestNb'])) {$_smarty_tpl->tpl_vars['requestNb'] = clone $_smarty_tpl->tpl_vars['requestNb'];
$_smarty_tpl->tpl_vars['requestNb']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink('category',$_smarty_tpl->tpl_vars['category']->value,true,false,false,true); $_smarty_tpl->tpl_vars['requestNb']->nocache = null; $_smarty_tpl->tpl_vars['requestNb']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestNb'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('category',$_smarty_tpl->tpl_vars['category']->value,true,false,false,true), null, 0);?>
	<?php } elseif (isset($_GET['id_manufacturer'])&&$_GET['id_manufacturer']&&isset($_smarty_tpl->tpl_vars['manufacturer']->value)) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['requestPage'])) {$_smarty_tpl->tpl_vars['requestPage'] = clone $_smarty_tpl->tpl_vars['requestPage'];
$_smarty_tpl->tpl_vars['requestPage']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink('manufacturer',$_smarty_tpl->tpl_vars['manufacturer']->value,false,false,true,false); $_smarty_tpl->tpl_vars['requestPage']->nocache = null; $_smarty_tpl->tpl_vars['requestPage']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('manufacturer',$_smarty_tpl->tpl_vars['manufacturer']->value,false,false,true,false), null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['requestNb'])) {$_smarty_tpl->tpl_vars['requestNb'] = clone $_smarty_tpl->tpl_vars['requestNb'];
$_smarty_tpl->tpl_vars['requestNb']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink('manufacturer',$_smarty_tpl->tpl_vars['manufacturer']->value,true,false,false,true); $_smarty_tpl->tpl_vars['requestNb']->nocache = null; $_smarty_tpl->tpl_vars['requestNb']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestNb'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('manufacturer',$_smarty_tpl->tpl_vars['manufacturer']->value,true,false,false,true), null, 0);?>
	<?php } elseif (isset($_GET['id_supplier'])&&$_GET['id_supplier']&&isset($_smarty_tpl->tpl_vars['supplier']->value)) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['requestPage'])) {$_smarty_tpl->tpl_vars['requestPage'] = clone $_smarty_tpl->tpl_vars['requestPage'];
$_smarty_tpl->tpl_vars['requestPage']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink('supplier',$_smarty_tpl->tpl_vars['supplier']->value,false,false,true,false); $_smarty_tpl->tpl_vars['requestPage']->nocache = null; $_smarty_tpl->tpl_vars['requestPage']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('supplier',$_smarty_tpl->tpl_vars['supplier']->value,false,false,true,false), null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['requestNb'])) {$_smarty_tpl->tpl_vars['requestNb'] = clone $_smarty_tpl->tpl_vars['requestNb'];
$_smarty_tpl->tpl_vars['requestNb']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink('supplier',$_smarty_tpl->tpl_vars['supplier']->value,true,false,false,true); $_smarty_tpl->tpl_vars['requestNb']->nocache = null; $_smarty_tpl->tpl_vars['requestNb']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestNb'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('supplier',$_smarty_tpl->tpl_vars['supplier']->value,true,false,false,true), null, 0);?>
	<?php } else { ?>
		<?php if (!isset($_smarty_tpl->tpl_vars['current_url']->value)) {?>
			<?php if (isset($_smarty_tpl->tpl_vars['requestPage'])) {$_smarty_tpl->tpl_vars['requestPage'] = clone $_smarty_tpl->tpl_vars['requestPage'];
$_smarty_tpl->tpl_vars['requestPage']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,false,false,true,false); $_smarty_tpl->tpl_vars['requestPage']->nocache = null; $_smarty_tpl->tpl_vars['requestPage']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,false,false,true,false), null, 0);?>
		<?php } else { ?>
			<?php if (isset($_smarty_tpl->tpl_vars['requestPage'])) {$_smarty_tpl->tpl_vars['requestPage'] = clone $_smarty_tpl->tpl_vars['requestPage'];
$_smarty_tpl->tpl_vars['requestPage']->value = $_smarty_tpl->tpl_vars['current_url']->value; $_smarty_tpl->tpl_vars['requestPage']->nocache = null; $_smarty_tpl->tpl_vars['requestPage']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['current_url']->value, null, 0);?>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['requestNb'])) {$_smarty_tpl->tpl_vars['requestNb'] = clone $_smarty_tpl->tpl_vars['requestNb'];
$_smarty_tpl->tpl_vars['requestNb']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,true,false,false,true); $_smarty_tpl->tpl_vars['requestNb']->nocache = null; $_smarty_tpl->tpl_vars['requestNb']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestNb'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,true,false,false,true), null, 0);?>
	<?php }?>
	<!-- Pagination -->
	<div id="pagination<?php if (isset($_smarty_tpl->tpl_vars['paginationId']->value)) {?>_<?php echo $_smarty_tpl->tpl_vars['paginationId']->value;?>
<?php }?>" class="pagination clearfix pull-left">
	    <?php if ($_smarty_tpl->tpl_vars['nb_products']->value>$_smarty_tpl->tpl_vars['products_per_page']->value&&$_smarty_tpl->tpl_vars['start']->value!=$_smarty_tpl->tpl_vars['stop']->value) {?>
			<form class="showall pull-left" action="<?php if (!is_array($_smarty_tpl->tpl_vars['requestNb']->value)) {?><?php echo $_smarty_tpl->tpl_vars['requestNb']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['requestNb']->value['requestUrl'];?>
<?php }?>" method="get">
				<div>
					<?php if (isset($_smarty_tpl->tpl_vars['search_query']->value)&&$_smarty_tpl->tpl_vars['search_query']->value) {?>
						<input type="hidden" name="search_query" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
					<?php }?>
					<?php if (isset($_smarty_tpl->tpl_vars['tag']->value)&&$_smarty_tpl->tpl_vars['tag']->value&&!is_array($_smarty_tpl->tpl_vars['tag']->value)) {?>
						<input type="hidden" name="tag" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tag']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
					<?php }?>
                    <span class="product_number" style="float:left;"><?php echo $_smarty_tpl->tpl_vars['nb_products']->value;?>
 <?php echo smartyTranslate(array('s'=>'Artikel | '),$_smarty_tpl);?>
</span>
	                <button type="submit" class="show_all all_shows">
	                	<span><?php echo smartyTranslate(array('s'=>'Alle anzeigen'),$_smarty_tpl);?>
</span>
	                </button>
					<?php if (is_array($_smarty_tpl->tpl_vars['requestNb']->value)) {?>
                                            <?php if (isset($_smarty_tpl->tpl_vars['requestNb']->value['blreset'])) {?>
                                                
                                            <?php } else { ?>
						<?php  $_smarty_tpl->tpl_vars['requestValue'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['requestValue']->_loop = false;
 $_smarty_tpl->tpl_vars['requestKey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['requestNb']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['requestValue']->key => $_smarty_tpl->tpl_vars['requestValue']->value) {
$_smarty_tpl->tpl_vars['requestValue']->_loop = true;
 $_smarty_tpl->tpl_vars['requestKey']->value = $_smarty_tpl->tpl_vars['requestValue']->key;
?>
							<?php if ($_smarty_tpl->tpl_vars['requestKey']->value!='requestUrl'&&$_smarty_tpl->tpl_vars['requestKey']->value!='p') {?>
								<input type="hidden" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['requestKey']->value, ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['requestValue']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
							<?php }?>
						<?php } ?>
                                            <?php }?>
					<?php }?>
	                <input name="n" id="nb_item" class="hidden" value="<?php echo $_smarty_tpl->tpl_vars['nb_products']->value;?>
" />
				</div>
			</form>
		<?php }?>
		
		<?php if ($_smarty_tpl->tpl_vars['start']->value!=$_smarty_tpl->tpl_vars['stop']->value) {?>
		<div class="pagination pull-left">
			<?php if ($_smarty_tpl->tpl_vars['p']->value!=1) {?>
				<?php if (isset($_smarty_tpl->tpl_vars['p_previous'])) {$_smarty_tpl->tpl_vars['p_previous'] = clone $_smarty_tpl->tpl_vars['p_previous'];
$_smarty_tpl->tpl_vars['p_previous']->value = $_smarty_tpl->tpl_vars['p']->value-1; $_smarty_tpl->tpl_vars['p_previous']->nocache = null; $_smarty_tpl->tpl_vars['p_previous']->scope = 0;
} else $_smarty_tpl->tpl_vars['p_previous'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value-1, null, 0);?>
					<a <?php echo $_smarty_tpl->tpl_vars['no_follow_text']->value;?>
 href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['requestPage']->value,$_smarty_tpl->tpl_vars['p_previous']->value,$_smarty_tpl->tpl_vars['seoUrls']->value);?>
" rel="prev" class="pagination_previous">
						<i class="fa fa-chevron-left"></i>
					</a>
			<?php } else { ?>
					<span class="pagination_previous disabled">
						<i class="fa fa-chevron-left"></i>
					</span>
			<?php }?>
			<div class="paginationMiddle">
				<select class="paginationDropdown">
				 <option><?php echo smartyTranslate(array('s'=>'Page %1$d from %2$d','sprintf'=>array($_smarty_tpl->tpl_vars['p']->value,$_smarty_tpl->tpl_vars['pages_nb']->value)),$_smarty_tpl);?>
</option>
				 <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['name'] = 'pagination';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['pages_nb']->value+1) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] = ((int) 1) == 0 ? 1 : (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total']);
?>
				 <option value="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['requestPage']->value,$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'],$_smarty_tpl->tpl_vars['seoUrls']->value);?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'];?>
</option>
				 <?php endfor; endif; ?>
				</select>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['pages_nb']->value>1&&$_smarty_tpl->tpl_vars['p']->value!=$_smarty_tpl->tpl_vars['pages_nb']->value) {?>
					<?php if (isset($_smarty_tpl->tpl_vars['p_next'])) {$_smarty_tpl->tpl_vars['p_next'] = clone $_smarty_tpl->tpl_vars['p_next'];
$_smarty_tpl->tpl_vars['p_next']->value = $_smarty_tpl->tpl_vars['p']->value+1; $_smarty_tpl->tpl_vars['p_next']->nocache = null; $_smarty_tpl->tpl_vars['p_next']->scope = 0;
} else $_smarty_tpl->tpl_vars['p_next'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value+1, null, 0);?>
					<a <?php echo $_smarty_tpl->tpl_vars['no_follow_text']->value;?>
 href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['requestPage']->value,$_smarty_tpl->tpl_vars['p_next']->value,$_smarty_tpl->tpl_vars['seoUrls']->value);?>
" rel="next" class="pagination_next">
						<i class="fa fa-chevron-right"></i>
					</a>
			<?php } else { ?>
					<span class="pagination_next disabled">
						<i class="fa fa-chevron-right"></i>
					</span>
			<?php }?>
		</div>
		
		<?php }?>
	</div>
    
	<!-- /Pagination -->
<?php }?>
<?php } else { ?>
    <div id="pagination<?php if (isset($_smarty_tpl->tpl_vars['paginationId']->value)) {?>_<?php echo $_smarty_tpl->tpl_vars['paginationId']->value;?>
<?php }?>" class="pagination clearfix pull-left" style="display:none"></div>
<?php }?><?php }} ?>
