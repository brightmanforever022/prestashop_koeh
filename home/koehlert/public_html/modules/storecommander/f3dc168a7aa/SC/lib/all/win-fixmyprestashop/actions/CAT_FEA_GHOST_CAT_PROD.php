<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "select pl.id_feature from "._DB_PREFIX_."feature_product pl where pl.id_feature not in (select p.id_feature from "._DB_PREFIX_."feature p) LIMIT 1500";
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
	
			var tbGhostFeatureProduct = dhxlSCExtCheck.tabbar.cells("table_CAT_FEA_GHOST_CAT_PROD").attachToolbar();
			tbGhostFeatureProduct.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostFeatureProduct.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostFeatureProduct.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostFeatureProduct.setItemToolTip('delete','<?php echo _l('Delete incomplete features')?>');
			tbGhostFeatureProduct.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostFeatureProduct.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostFeatureProduct();
					}
				});
		
			var gridGhostFeatureProduct = dhxlSCExtCheck.tabbar.cells("table_CAT_FEA_GHOST_CAT_PROD").attachGrid();
			gridGhostFeatureProduct.setImagePath("lib/js/imgs/");
			gridGhostFeatureProduct.enableSmartRendering(true);
			gridGhostFeatureProduct.enableMultiselect(true);
	
			gridGhostFeatureProduct.setHeader("<?php echo _l('Deleted features ID')?>");
			gridGhostFeatureProduct.setInitWidths("*");
			gridGhostFeatureProduct.setColAlign("left");
			gridGhostFeatureProduct.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $product) { ?>
			xml = xml+'   <row id="<?php echo $product["id_feature"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $product["id_feature"] ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostFeatureProduct.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_FEA_GHOST_CAT_PROD").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostFeatureProduct()
			{
				var selectedGhostFeatureProducts = gridGhostFeatureProduct.getSelectedRowId();
				if(selectedGhostFeatureProducts==null || selectedGhostFeatureProducts=="")
					selectedGhostFeatureProducts = 0;
				if(selectedGhostFeatureProducts!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_FEA_GHOST_CAT_PROD&id_lang="+SC_ID_LANG, { "action": "delete_features", "ids": selectedGhostFeatureProducts}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_FEA_GHOST_CAT_PROD").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_FEA_GHOST_CAT_PROD');
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
			"title"=>_l('Ghost feat_prod'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_features")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$sql = "DELETE FROM "._DB_PREFIX_."feature_product WHERE id_feature IN (".psql($post_ids).")";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
