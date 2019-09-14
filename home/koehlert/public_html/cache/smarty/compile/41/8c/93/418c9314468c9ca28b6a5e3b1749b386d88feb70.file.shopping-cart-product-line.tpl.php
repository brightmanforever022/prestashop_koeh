<?php /* Smarty version Smarty-3.1.19, created on 2019-08-23 23:00:02
         compiled from "/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/mail_template/shopping-cart-product-line.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7432123275d59c35a5515a7-49996552%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '418c9314468c9ca28b6a5e3b1749b386d88feb70' => 
    array (
      0 => '/home/koehlert/public_html/modules/tacartreminder/views/templates/admin/mail_template/shopping-cart-product-line.tpl',
      1 => 1566589911,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7432123275d59c35a5515a7-49996552',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59c35a5b29b9_01431719',
  'variables' => 
  array (
    'product' => 0,
    'id_lang' => 0,
    'link' => 0,
    'smallSize' => 0,
    'quantityDisplayed' => 0,
    'productId' => 0,
    'productAttributeId' => 0,
    'customizedDatas' => 0,
    'priceDisplay' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59c35a5b29b9_01431719')) {function content_5d59c35a5b29b9_01431719($_smarty_tpl) {?>
<tr class="product-line">
	<td class="product-line-col td-product-image">
		<table class="table">
			<tr>
				<td>
					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['category'],null,$_smarty_tpl->tpl_vars['id_lang']->value,$_smarty_tpl->tpl_vars['product']->value['id_shop'],$_smarty_tpl->tpl_vars['product']->value['id_product_attribute']), ENT_QUOTES, 'UTF-8', true);?>
"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'small_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if (isset($_smarty_tpl->tpl_vars['smallSize']->value)) {?>width="<?php echo intval($_smarty_tpl->tpl_vars['smallSize']->value['width']);?>
" height="<?php echo intval($_smarty_tpl->tpl_vars['smallSize']->value['height']);?>
" <?php }?> /></a>
				</td>
			</tr>
		</table>
	</td>
	<td class="product-line-col td-product-description">
		<table class="table">
				<tr>
					<td>
						<span class="product_name">
							<strong><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</strong><?php if (isset($_smarty_tpl->tpl_vars['product']->value['attributes'])&&$_smarty_tpl->tpl_vars['product']->value['attributes']) {?><br /><em><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['attributes'], ENT_QUOTES, 'UTF-8', true);?>
</em><?php }?>
						</span>
					</td>
			</tr>
		</table>
	</td>
	<td class="product-line-col td-product-quantity">
			<table class="table">
				<tr>
					<td>
						<span class="product-quantity">
							<?php if ($_smarty_tpl->tpl_vars['quantityDisplayed']->value==0&&isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value])) {?>
								<?php echo intval($_smarty_tpl->tpl_vars['product']->value['customizationQuantityTotal']);?>
&nbsp;x
							<?php } else { ?>
								<?php echo intval($_smarty_tpl->tpl_vars['product']->value['cart_quantity'])-intval($_smarty_tpl->tpl_vars['quantityDisplayed']->value);?>
&nbsp;x
							<?php }?>
						</span>
					</td>
				</tr>
			</table>
	</td>
	<td class="product-line-col">
		<table class="table">
			<tr>
				<td align="center" style="min-width:35px;">
						<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['gift'])) {?>
							<?php echo smartyTranslate(array('s'=>'Gift!','mod'=>'tacartreminder'),$_smarty_tpl);?>

						<?php } else { ?>
            				<?php if (!$_smarty_tpl->tpl_vars['priceDisplay']->value) {?>
								<span class="product-price <?php if (isset($_smarty_tpl->tpl_vars['product']->value['is_discounted'])&&$_smarty_tpl->tpl_vars['product']->value['is_discounted']) {?>product-discounted<?php }?>"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price_wt_dp'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
							<?php } else { ?>
               	 				<span class="product-price <?php if (isset($_smarty_tpl->tpl_vars['product']->value['is_discounted'])&&$_smarty_tpl->tpl_vars['product']->value['is_discounted']) {?>product-discounted<?php }?>"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price_dp'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
							<?php }?>
							
						<?php }?>
				</td>
			</tr>
		</table>
	</td>
	
</tr><?php }} ?>
