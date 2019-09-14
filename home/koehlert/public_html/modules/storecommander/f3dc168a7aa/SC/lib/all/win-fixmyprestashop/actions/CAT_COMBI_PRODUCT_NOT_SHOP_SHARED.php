<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT pa.id_product, pas.id_shop, ash.id_lang
			FROM "._DB_PREFIX_."product_attribute_shop pas 
			INNER JOIN "._DB_PREFIX_."product_attribute pa ON (pas.id_product_attribute=pa.id_product_attribute)
			INNER JOIN "._DB_PREFIX_."lang_shop ash ON (ash.id_shop = pas.id_shop)
			WHERE pas.id_shop NOT IN (SELECT ps.id_shop FROM "._DB_PREFIX_."product_shop ps WHERE ps.id_product=pa.id_product)";
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
	
			var tbProductNotShopShared = dhxlSCExtCheck.tabbar.cells("table_CAT_COMBI_PRODUCT_NOT_SHOP_SHARED").attachToolbar();
			tbProductNotShopShared.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbProductNotShopShared.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbProductNotShopShared.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbProductNotShopShared.setItemToolTip('delete','<?php echo _l('Delete associations')?>');
			tbProductNotShopShared.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbProductNotShopShared.setItemToolTip('add','<?php echo _l('Share product')?>');
			tbProductNotShopShared.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridProductNotShopShared.selectAll();
					}
					if (id=='delete')
					{
						deleteProductNotShopShared()
					}
					if (id=='add')
					{
						addProductNotShopShared()
					}
				});
		
			var gridProductNotShopShared = dhxlSCExtCheck.tabbar.cells("table_CAT_COMBI_PRODUCT_NOT_SHOP_SHARED").attachGrid();
			gridProductNotShopShared.setImagePath("lib/js/imgs/");
			gridProductNotShopShared.enableSmartRendering(false);
			gridProductNotShopShared.enableMultiselect(true);
	
			gridProductNotShopShared.setHeader("ID <?php echo _l('Product')?>,<?php echo _l('Product')?>,ID <?php echo _l('Shop')?>,<?php echo _l('Shop')?>");
			gridProductNotShopShared.setInitWidths("40,150,40,150");
			gridProductNotShopShared.setColAlign("left,left,left,left");
			gridProductNotShopShared.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $row) {
				$product = new Product($row["id_product"], false, (int)$row["id_lang"], $row["id_shop"]);
				$shop = new Shop($row["id_shop"], (int)$row["id_lang"]);
				?>
			xml = xml+'   <row id="<?php echo $row["id_product"]."_".$row["id_shop"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $row["id_product"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $product->name) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo $row["id_shop"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $shop->name) ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridProductNotShopShared.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_COMBI_PRODUCT_NOT_SHOP_SHARED").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteProductNotShopShared()
			{
				var selectedProductNotShopShareds = gridProductNotShopShared.getSelectedRowId();
				if(selectedProductNotShopShareds==null || selectedProductNotShopShareds=="")
					selectedProductNotShopShareds = 0;
				if(selectedProductNotShopShareds!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_COMBI_PRODUCT_NOT_SHOP_SHARED&id_lang="+SC_ID_LANG, { "action": "delete_association", "ids": selectedProductNotShopShareds}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_COMBI_PRODUCT_NOT_SHOP_SHARED").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_COMBI_PRODUCT_NOT_SHOP_SHARED');
						 doCheck(false);
					});
				}
			}
			function addProductNotShopShared()
			{
				var selectedProductNotShopShareds = gridProductNotShopShared.getSelectedRowId();
				if(selectedProductNotShopShareds==null || selectedProductNotShopShareds=="")
					selectedProductNotShopShareds = 0;
				if(selectedProductNotShopShareds!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_COMBI_PRODUCT_NOT_SHOP_SHARED&id_lang="+SC_ID_LANG, { "action": "add_association", "ids": selectedProductNotShopShareds}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_COMBI_PRODUCT_NOT_SHOP_SHARED").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_COMBI_PRODUCT_NOT_SHOP_SHARED');
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
			"title"=>_l('Not sharing shop'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_association")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			list($id_product, $id_shop) = explode("_", $id);
			
			$sql = "SELECT id_product_attribute FROM "._DB_PREFIX_."product_attribute WHERE id_product = '".(int)$id_product."'";
			$attrs=Db::getInstance()->executeS($sql);
			foreach($attrs as $attr)
			{
				$sql = "DELETE FROM "._DB_PREFIX_."product_attribute_shop WHERE id_product_attribute = '".(int)$attr["id_product_attribute"]."' AND id_shop = '".(int)$id_shop."'";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_association")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			list($id_product, $id_shop) = explode("_", $id);
			
			$product = new Product((int)$id_product);
			$product->id_shop_list = array($id_shop);
			$product->price=floatval($product->price);
			$product->save();
		}
	}
}
