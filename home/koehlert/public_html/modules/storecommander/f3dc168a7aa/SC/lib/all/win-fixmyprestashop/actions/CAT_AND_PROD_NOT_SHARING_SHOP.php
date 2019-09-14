<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT id_category, id_product, id_lang
		FROM 
		(
		SELECT cp.id_category, cp.id_product, SUM(IF(cs.id_shop = ps.id_shop and cs.id_shop,1,0)) AS compte, ls.id_lang
		FROM "._DB_PREFIX_."category_product cp
		LEFT JOIN "._DB_PREFIX_."category_shop cs ON cp.id_category = cs.id_category 
		LEFT JOIN "._DB_PREFIX_."product_shop ps ON cp.id_product = ps.id_product 
		LEFT JOIN "._DB_PREFIX_."lang_shop ls ON ls.id_shop = cs.id_shop
		GROUP BY cp.id_category, cp.id_product, ls.id_lang
		) 
		AS cnt
		WHERE cnt.compte = 0 LIMIT 1500";
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
	
			var tbPCNotSharingShop = dhxlSCExtCheck.tabbar.cells("table_CAT_AND_PROD_NOT_SHARING_SHOP").attachToolbar();
			tbPCNotSharingShop.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbPCNotSharingShop.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbPCNotSharingShop.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbPCNotSharingShop.setItemToolTip('delete','<?php echo _l('Delete associations')?>');
			tbPCNotSharingShop.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridPCNotSharingShop.selectAll();
					}
					if (id=='delete')
					{
						deletePCNotSharingShop()
					}
				});
		
			var gridPCNotSharingShop = dhxlSCExtCheck.tabbar.cells("table_CAT_AND_PROD_NOT_SHARING_SHOP").attachGrid();
			gridPCNotSharingShop.setImagePath("lib/js/imgs/");
			gridPCNotSharingShop.enableSmartRendering(true);
			gridPCNotSharingShop.enableMultiselect(true);
	
			gridPCNotSharingShop.setHeader("ID <?php echo _l('Product')?>,<?php echo _l('Product')?>,ID <?php echo _l('Category')?>,<?php echo _l('Category')?>");
			gridPCNotSharingShop.setInitWidths("40,150,40,150");
			gridPCNotSharingShop.setColAlign("left,left,left,left");
			gridPCNotSharingShop.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $row) {
				$product = new Product($row["id_product"], false, $row["id_lang"]);
				$category = new Category($row["id_category"], $row["id_lang"]);
				?>
			xml = xml+'   <row id="<?php echo $row["id_product"]."_".$row["id_category"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $row["id_product"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $product->name) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo $row["id_category"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $category->name) ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridPCNotSharingShop.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_AND_PROD_NOT_SHARING_SHOP").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deletePCNotSharingShop()
			{
				var selectedPCNotSharingShops = gridPCNotSharingShop.getSelectedRowId();
				if(selectedPCNotSharingShops==null || selectedPCNotSharingShops=="")
					selectedPCNotSharingShops = 0;
				if(selectedPCNotSharingShops!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_AND_PROD_NOT_SHARING_SHOP&id_lang="+SC_ID_LANG, { "action": "delete_association", "ids": selectedPCNotSharingShops}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_AND_PROD_NOT_SHARING_SHOP").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_AND_PROD_NOT_SHARING_SHOP');
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
			list($id_product, $id_category) = explode("_", $id);
			
			$sql = "DELETE FROM "._DB_PREFIX_."category_product WHERE id_product = '".(int)$id_product."' AND id_category = '".(int)$id_category."'";
			$res=dbExecuteForeignKeyOff($sql);
		}
	}
}
