<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "select pl.id_product, pl.name from "._DB_PREFIX_."product_lang pl where pl.id_product not in (select p.id_product from "._DB_PREFIX_."product p) ORDER BY id_lang ASC LIMIT 1500";
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
	
			var tbMissingProductInfo = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_MISSING_PRODUCT_INFORMATION").attachToolbar();
			tbMissingProductInfo.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingProductInfo.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingProductInfo.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingProductInfo.setItemToolTip('delete','<?php echo _l('Delete incomplete products')?>');
			tbMissingProductInfo.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingProductInfo.setItemToolTip('add','<?php echo _l('Recover incomplete products')?>');
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
					if (id=='add')
					{
						addMissingProductInfo()
					}
				});
		
			var gridMissingProductInfo = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_MISSING_PRODUCT_INFORMATION").attachGrid();
			gridMissingProductInfo.setImagePath("lib/js/imgs/");
			gridMissingProductInfo.enableSmartRendering(true);
			gridMissingProductInfo.enableMultiselect(true);
	
			gridMissingProductInfo.setHeader("ID,<?php echo _l('Name')?>");
			gridMissingProductInfo.setInitWidths("100,200");
			gridMissingProductInfo.setColAlign("left,left");
			gridMissingProductInfo.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $product) { ?>
			xml = xml+'   <row id="<?php echo $product["id_product"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $product["id_product"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $product["name"]) ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingProductInfo.parse(xml);

			dhxlSCExtCheck.tabbar.cells("CAT_PROD_MISSING_PRODUCT_INFORMATION").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingProductInfo()
			{
				var selectedMissingProductInfos = gridMissingProductInfo.getSelectedRowId();
				if(selectedMissingProductInfos==null || selectedMissingProductInfos=="")
					selectedMissingProductInfos = 0;
				if(selectedMissingProductInfos!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_MISSING_PRODUCT_INFORMATION&id_lang="+SC_ID_LANG, { "action": "delete_products", "ids": selectedMissingProductInfos}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_MISSING_PRODUCT_INFORMATION").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_MISSING_PRODUCT_INFORMATION');
						 doCheck(false);
					});
				}
			}

			function addMissingProductInfo()
			{
				var selectedMissingProductInfos = gridMissingProductInfo.getSelectedRowId();
				if(selectedMissingProductInfos==null || selectedMissingProductInfos=="")
					selectedMissingProductInfos = 0;
				if(selectedMissingProductInfos!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_MISSING_PRODUCT_INFORMATION&id_lang="+SC_ID_LANG, { "action": "add_products", "ids": selectedMissingProductInfos}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_MISSING_PRODUCT_INFORMATION").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_MISSING_PRODUCT_INFORMATION');
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
		$sql = "DELETE FROM "._DB_PREFIX_."product_lang WHERE id_product IN (".psql($post_ids).")";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
elseif(!empty($post_action) && $post_action=="add_products")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$sql = "INSERT INTO "._DB_PREFIX_."product (id_product, id_category_default, date_add, date_upd)
					VALUES (".(int)$id.",1,'".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
			$res=dbExecuteForeignKeyOff($sql);
			
			$sql = "INSERT INTO "._DB_PREFIX_."category_product (id_product, id_category)
					VALUES (".(int)$id.",1)";
			$res=dbExecuteForeignKeyOff($sql);
			
			Module::hookExec('afterSaveProduct', array('id_product' => (int)$id));
		}
	}
}
