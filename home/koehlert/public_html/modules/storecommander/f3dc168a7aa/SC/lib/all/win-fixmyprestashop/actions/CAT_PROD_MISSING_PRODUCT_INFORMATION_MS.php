<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT pl.id_product, pl.name, pl.id_shop, s.name as shop_name
			FROM "._DB_PREFIX_."product_lang pl 
				INNER JOIN "._DB_PREFIX_."shop s ON (pl.id_shop = s.id_shop) 
			WHERE pl.id_product not in (SELECT ps.id_product FROM "._DB_PREFIX_."product_shop ps WHERE ps.id_shop = pl.id_shop) 
			ORDER BY id_lang ASC LIMIT 1500";
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
	
			var tbMissingProductInfo = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_MISSING_PRODUCT_INFORMATION_MS").attachToolbar();
			tbMissingProductInfo.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingProductInfo.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingProductInfo.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingProductInfo.setItemToolTip('delete','<?php echo _l('Delete ghost product for these shops')?>');
			tbMissingProductInfo.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingProductInfo.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingProductInfo();
					}
				});
		
			var gridMissingProductInfo = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_MISSING_PRODUCT_INFORMATION_MS").attachGrid();
			gridMissingProductInfo.setImagePath("lib/js/imgs/");
			gridMissingProductInfo.enableSmartRendering(true);
			gridMissingProductInfo.enableMultiselect(true);
	
			gridMissingProductInfo.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Shop')?>");
			gridMissingProductInfo.setInitWidths("100,100,200");
			gridMissingProductInfo.setColAlign("left,left,left");
			gridMissingProductInfo.init();

			var xml = '<rows>';
			<?php foreach ($res as $product) { ?>
			xml = xml+'   <row id="<?php echo $product["id_product"]."_".$product["id_shop"]; ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $product["id_product"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo  str_replace("'","\'",str_replace("\'","'",($product["name"]))) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo  str_replace("'","\'",str_replace("\'","'",($product["shop_name"])))." (#".$product["id_shop"].")"; ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingProductInfo.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_MISSING_PRODUCT_INFORMATION_MS").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingProductInfo()
			{
				var selectedMissingProductInfos = gridMissingProductInfo.getSelectedRowId();
				if(selectedMissingProductInfos==null || selectedMissingProductInfos=="")
					selectedMissingProductInfos = 0;
				if(selectedMissingProductInfos!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_MISSING_PRODUCT_INFORMATION_MS&id_lang="+SC_ID_LANG, { "action": "delete_products", "ids": selectedMissingProductInfos}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_MISSING_PRODUCT_INFORMATION_MS").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_MISSING_PRODUCT_INFORMATION_MS');
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
			"title"=>_l('Product info.'),
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
			list($id_product, $id_shop) = explode("_",$id);
		
			$sql = "DELETE FROM "._DB_PREFIX_."product_lang WHERE id_product = ".(int)$id_product." AND id_shop = ".(int)$id_shop."";
			dbExecuteForeignKeyOff($sql);
		}
	}
}
