<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT id_product, id_category, position
			FROM `"._DB_PREFIX_."category_product`
			GROUP BY id_category, id_product
			HAVING COUNT( CONCAT( id_category, '_', id_product ) ) >1
			ORDER BY position ASC LIMIT 1500";
	$resSQL=Db::getInstance()->ExecuteS($sql);
	$res=array();
	foreach($resSQL as $r)
	{
		$res[]=$r;
		if (count($res)>500)
			break;
	}
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbGhostCategoryProduct = dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_CAT_PROD_PROD_DUP").attachToolbar();
			tbGhostCategoryProduct.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostCategoryProduct.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostCategoryProduct.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostCategoryProduct.setItemToolTip('delete','<?php echo _l('Delete duplicates')?>');
			tbGhostCategoryProduct.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostCategoryProduct.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostProductDupProduct();
					}
				});
		
			var gridGhostCategoryProduct = dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_CAT_PROD_PROD_DUP").attachGrid();
			gridGhostCategoryProduct.setImagePath("lib/js/imgs/");
			gridGhostCategoryProduct.enableSmartRendering(true);
			gridGhostCategoryProduct.enableMultiselect(true);
	
			gridGhostCategoryProduct.setHeader("<?php echo _l('Product')?>,<?php echo _l('Category')?>");
			gridGhostCategoryProduct.setColAlign("left,left");
			gridGhostCategoryProduct.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $row) { ?>
			xml = xml+'<row id="<?php echo $row["id_product"]."_".$row["id_category"]."_".$row["position"] ?>">';
			xml = xml+'	<cell><![CDATA[<?php echo $row["id_product"] ?>]]></cell>';
			xml = xml+'	<cell><![CDATA[<?php echo $row["id_category"] ?>]]></cell>';
			xml = xml+'</row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostCategoryProduct.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_CAT_PROD_PROD_DUP").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostProductDupProduct()
			{
				var selectedGhostCategoryPDupProducts = gridGhostCategoryProduct.getSelectedRowId();
				if(selectedGhostCategoryPDupProducts==null || selectedGhostCategoryPDupProducts=="")
					selectedGhostCategoryPDupProducts = 0;
				/*if(selectedGhostCategoryPDupProducts!="0")
				{*/
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_CAT_GHOST_CAT_PROD_PROD_DUP&id_lang="+SC_ID_LANG, { "action": "delete_product", "ids": selectedGhostCategoryPDupProducts}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_CAT_GHOST_CAT_PROD_PROD_DUP").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_CAT_GHOST_CAT_PROD_PROD_DUP');
						 doCheck(false);
					});
				//}
			}
		</script>
		<?php 
		$content_js = ob_get_clean();
	}
	echo Tools::jsonEncode(array(
			"results"=>$results,
			"contentType"=>"grid", 
			"content"=>$content, 
			"title"=>_l('Dupl. cat_prod'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_product")
{
	$post_ids = Tools::getValue("ids");
	if(isset($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			list($id_product,$id_category,$position) = explode("_",$id);
			
			$sql = "DELETE FROM "._DB_PREFIX_."category_product WHERE id_product='".(int)$id_product."' AND id_category='".(int)$id_category."'";
			$res=dbExecuteForeignKeyOff($sql);
			
			dbExecuteForeignKeyOff("INSERT INTO "._DB_PREFIX_."category_product (id_category,id_product,position) VALUES (".(int)$id_category.",".(int)$id_product.",".(int)$position.")");
		}
	}
}
