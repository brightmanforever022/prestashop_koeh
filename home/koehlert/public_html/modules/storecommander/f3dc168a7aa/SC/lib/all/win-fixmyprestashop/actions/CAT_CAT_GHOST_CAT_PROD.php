<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "select pl.id_category from "._DB_PREFIX_."category_product pl where pl.id_category not in (select p.id_category from "._DB_PREFIX_."category p) LIMIT 1500";
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
	
			var tbGhostCategoryProduct = dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_CAT_PROD").attachToolbar();
			tbGhostCategoryProduct.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostCategoryProduct.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostCategoryProduct.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostCategoryProduct.setItemToolTip('delete','<?php echo _l('Delete incomplete categories')?>');
			tbGhostCategoryProduct.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostCategoryProduct.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostCategoryProduct();
					}
				});
		
			var gridGhostCategoryProduct = dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_CAT_PROD").attachGrid();
			gridGhostCategoryProduct.setImagePath("lib/js/imgs/");
			gridGhostCategoryProduct.enableSmartRendering(true);
			gridGhostCategoryProduct.enableMultiselect(true);
	
			gridGhostCategoryProduct.setHeader("<?php echo _l('ID deleted categories')?>");
			gridGhostCategoryProduct.setInitWidths("*");
			gridGhostCategoryProduct.setColAlign("left");
			gridGhostCategoryProduct.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $product) { ?>
			xml = xml+'   <row id="<?php echo $product["id_category"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $product["id_category"] ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostCategoryProduct.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_CAT_PROD").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostCategoryProduct()
			{
				var selectedGhostCategoryProducts = gridGhostCategoryProduct.getSelectedRowId();
				if(selectedGhostCategoryProducts==null || selectedGhostCategoryProducts=="")
					selectedGhostCategoryProducts = 0;
				/*if(selectedGhostCategoryProducts!="0")
				{*/
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_CAT_GHOST_CAT_PROD&id_lang="+SC_ID_LANG, { "action": "delete_categories", "ids": selectedGhostCategoryProducts}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_CAT_GHOST_CAT_PROD").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_CAT_GHOST_CAT_PROD');
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
			"title"=>_l('Ghost cat_prod'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_categories")
{
	$post_ids = Tools::getValue("ids");
	if(isset($post_ids))
	{
		$sql = "DELETE FROM "._DB_PREFIX_."category_product WHERE id_category IN (".psql($post_ids).")";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
