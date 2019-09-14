<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT *
		FROM `"._DB_PREFIX_."product_lang`
		WHERE id_shop = 0 LIMIT 1500";
	$res=Db::getInstance()->ExecuteS($sql);
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbProductLangEmptyShop = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_LANG_WITH_EMPTY_SHOP").attachToolbar();
			tbProductLangEmptyShop.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbProductLangEmptyShop.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbProductLangEmptyShop.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbProductLangEmptyShop.setItemToolTip('delete','<?php echo _l('Delete incomplete products')?>');
			tbProductLangEmptyShop.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridProductLangEmptyShop.selectAll();
					}
					if (id=='delete')
					{
						deleteProductLangEmptyShop();
					}
				});
		
			var gridProductLangEmptyShop = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_LANG_WITH_EMPTY_SHOP").attachGrid();
			gridProductLangEmptyShop.setImagePath("lib/js/imgs/");
			gridProductLangEmptyShop.enableSmartRendering(true);
			gridProductLangEmptyShop.enableMultiselect(true);

			gridProductLangEmptyShop.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Lang')?>");
			gridProductLangEmptyShop.setInitWidths("100,300,200");
			gridProductLangEmptyShop.setColAlign("left,left,left");
			gridProductLangEmptyShop.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $product) {
				$lang = Language::getLanguage($product["id_lang"]);
			?>
			xml = xml+'   <row id="<?php echo $product["id_product"]."_".$product["id_lang"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $product["id_product"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $product["name"]) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $lang["name"]) ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridProductLangEmptyShop.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_LANG_WITH_EMPTY_SHOP").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteProductLangEmptyShop()
			{
				var selectedProductLangEmptyShops = gridProductLangEmptyShop.getSelectedRowId();
				if(selectedProductLangEmptyShops==null || selectedProductLangEmptyShops=="")
					selectedProductLangEmptyShops = 0;
				if(selectedProductLangEmptyShops!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_LANG_WITH_EMPTY_SHOP&id_lang="+SC_ID_LANG, { "action": "delete_products", "ids": selectedProductLangEmptyShops}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_LANG_WITH_EMPTY_SHOP").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_LANG_WITH_EMPTY_SHOP');
						 doCheck(false);
					});
				}
			}
		</script>
		<?php 
		$content_js = ob_get_clean();
	}
	echo Tools::jsonEncode(array(
			"results"=>$results,
			"contentType"=>"grid", 
			"content"=>$content,
			"title"=>_l('Prod_lang empty shop'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_products")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			list($id_product,$id_lang) = explode('_', $id);
			if(!empty($id_product) && !empty($id_lang))
			{
				$sql = "DELETE FROM `"._DB_PREFIX_."product_lang` 
				WHERE id_product = '".(int)$id_product."'
					AND id_lang = '".(int)$id_lang."'
					AND id_shop = '0'";
				dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
