<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:40:35
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/nbr-product-page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1387024895d5963633c1116-58611937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e947ad29128deee75a578cdb7e02acc3bdd900cf' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/nbr-product-page.tpl',
      1 => 1556017948,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1387024895d5963633c1116-58611937',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'link' => 0,
    'manufacturer' => 0,
    'supplier' => 0,
    'requestNb' => 0,
    'search_query' => 0,
    'tag' => 0,
    'requestKey' => 0,
    'requestValue' => 0,
    'paginationId' => 0,
    'nArray' => 0,
    'lastnValue' => 0,
    'nb_products' => 0,
    'nValue' => 0,
    'n' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596363439456_20527913',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596363439456_20527913')) {function content_5d596363439456_20527913($_smarty_tpl) {?>

	<?php if (isset($_GET['id_category'])&&$_GET['id_category']&&isset($_smarty_tpl->tpl_vars['category']->value)) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['requestPage'])) {$_smarty_tpl->tpl_vars['requestPage'] = clone $_smarty_tpl->tpl_vars['requestPage'];
$_smarty_tpl->tpl_vars['requestPage']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink('category',$_smarty_tpl->tpl_vars['category']->value,false,false,true,false); $_smarty_tpl->tpl_vars['requestPage']->nocache = null; $_smarty_tpl->tpl_vars['requestPage']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink('category',$_smarty_tpl->tpl_vars['category']->value,false,false,true,false), null, 0);?>
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
		<?php if (isset($_smarty_tpl->tpl_vars['requestPage'])) {$_smarty_tpl->tpl_vars['requestPage'] = clone $_smarty_tpl->tpl_vars['requestPage'];
$_smarty_tpl->tpl_vars['requestPage']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,false,false,true,false); $_smarty_tpl->tpl_vars['requestPage']->nocache = null; $_smarty_tpl->tpl_vars['requestPage']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,false,false,true,false), null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['requestNb'])) {$_smarty_tpl->tpl_vars['requestNb'] = clone $_smarty_tpl->tpl_vars['requestNb'];
$_smarty_tpl->tpl_vars['requestNb']->value = $_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,true,false,false,true); $_smarty_tpl->tpl_vars['requestNb']->nocache = null; $_smarty_tpl->tpl_vars['requestNb']->scope = 0;
} else $_smarty_tpl->tpl_vars['requestNb'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,true,false,false,true), null, 0);?>
	<?php }?>
	<!-- nbr product/page -->
	
		<form action="<?php if (!is_array($_smarty_tpl->tpl_vars['requestNb']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['requestNb']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['requestNb']->value['requestUrl'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" method="get" class="nbrItemPage form-horizontal">
			<div class="clearfix selector1 form-group">
				<?php if (isset($_smarty_tpl->tpl_vars['search_query']->value)&&$_smarty_tpl->tpl_vars['search_query']->value) {?>
					<input type="hidden" name="search_query" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
				<?php }?>
				<?php if (isset($_smarty_tpl->tpl_vars['tag']->value)&&$_smarty_tpl->tpl_vars['tag']->value&&!is_array($_smarty_tpl->tpl_vars['tag']->value)) {?>
					<input type="hidden" name="tag" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tag']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
				<?php }?>
				
				<?php if (is_array($_smarty_tpl->tpl_vars['requestNb']->value)) {?>
					<?php  $_smarty_tpl->tpl_vars['requestValue'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['requestValue']->_loop = false;
 $_smarty_tpl->tpl_vars['requestKey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['requestNb']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['requestValue']->key => $_smarty_tpl->tpl_vars['requestValue']->value) {
$_smarty_tpl->tpl_vars['requestValue']->_loop = true;
 $_smarty_tpl->tpl_vars['requestKey']->value = $_smarty_tpl->tpl_vars['requestValue']->key;
?>
						<?php if ($_smarty_tpl->tpl_vars['requestKey']->value!='requestUrl') {?>
							<input type="hidden" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['requestKey']->value, ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['requestValue']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
						<?php }?>
					<?php } ?>
				<?php }?>
				<label class="col-xs-6 col-md-7 control-label"><span><?php echo smartyTranslate(array('s'=>'Show '),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'per page'),$_smarty_tpl);?>
</span></label>
				<div class="col-xs-6 col-md-5">
				<select name="n" id="nb_item<?php if (isset($_smarty_tpl->tpl_vars['paginationId']->value)) {?>_<?php echo $_smarty_tpl->tpl_vars['paginationId']->value;?>
<?php }?>" class="form-control">
					<?php if (isset($_smarty_tpl->tpl_vars["lastnValue"])) {$_smarty_tpl->tpl_vars["lastnValue"] = clone $_smarty_tpl->tpl_vars["lastnValue"];
$_smarty_tpl->tpl_vars["lastnValue"]->value = "0"; $_smarty_tpl->tpl_vars["lastnValue"]->nocache = null; $_smarty_tpl->tpl_vars["lastnValue"]->scope = 0;
} else $_smarty_tpl->tpl_vars["lastnValue"] = new Smarty_variable("0", null, 0);?>
					<?php  $_smarty_tpl->tpl_vars['nValue'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['nValue']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['nArray']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['nValue']->key => $_smarty_tpl->tpl_vars['nValue']->value) {
$_smarty_tpl->tpl_vars['nValue']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['lastnValue']->value<=$_smarty_tpl->tpl_vars['nb_products']->value) {?>
							<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['nValue']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['n']->value==$_smarty_tpl->tpl_vars['nValue']->value) {?>selected="selected"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['nValue']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
						<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars["lastnValue"])) {$_smarty_tpl->tpl_vars["lastnValue"] = clone $_smarty_tpl->tpl_vars["lastnValue"];
$_smarty_tpl->tpl_vars["lastnValue"]->value = $_smarty_tpl->tpl_vars['nValue']->value; $_smarty_tpl->tpl_vars["lastnValue"]->nocache = null; $_smarty_tpl->tpl_vars["lastnValue"]->scope = 0;
} else $_smarty_tpl->tpl_vars["lastnValue"] = new Smarty_variable($_smarty_tpl->tpl_vars['nValue']->value, null, 0);?>
					<?php } ?>
				</select>
               	</div>
			</div>
		</form>
	
	<!-- /nbr product/page -->
<?php }} ?>
