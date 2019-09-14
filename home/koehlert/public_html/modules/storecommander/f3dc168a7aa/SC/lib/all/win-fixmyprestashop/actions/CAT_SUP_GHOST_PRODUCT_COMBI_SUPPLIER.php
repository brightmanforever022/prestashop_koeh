<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$res = array();
	
	$sql = "SELECT *  FROM `"._DB_PREFIX_."product_supplier` WHERE id_product NOT IN (SELECT id_product FROM "._DB_PREFIX_."product) LIMIT 1500";
	$res_prod=Db::getInstance()->ExecuteS($sql);
	foreach($res_prod as $prod)
	{
		$res[$prod["id_product"]."_0"] = array("id_product"=>$prod["id_product"],"id_product_attribute"=>0);
	}
	
	$sql = "SELECT *  FROM `"._DB_PREFIX_."product_supplier` WHERE id_product_attribute != 0 && id_product_attribute NOT IN (SELECT id_product_attribute FROM "._DB_PREFIX_."product_attribute_shop) LIMIT 1500";
	$res_prod_attr=Db::getInstance()->ExecuteS($sql);
	foreach($res_prod_attr as $prod_attr)
	{
		$res[$prod_attr["id_product"]."_".$prod_attr["id_product_attribute"]] = array("id_product"=>$prod_attr["id_product"],"id_product_attribute"=>$prod_attr["id_product_attribute"]);
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
	
			var tbGhostProductCombiSupplier = dhxlSCExtCheck.tabbar.cells("table_CAT_SUP_GHOST_PRODUCT_COMBI_SUPPLIER").attachToolbar();
			tbGhostProductCombiSupplier.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostProductCombiSupplier.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostProductCombiSupplier.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostProductCombiSupplier.setItemToolTip('delete','<?php echo _l('Delete products/combinations')?>');
			tbGhostProductCombiSupplier.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostProductCombiSupplier.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostProductCombiSupplier();
					}
				});
		
			var gridGhostProductCombiSupplier = dhxlSCExtCheck.tabbar.cells("table_CAT_SUP_GHOST_PRODUCT_COMBI_SUPPLIER").attachGrid();
			gridGhostProductCombiSupplier.setImagePath("lib/js/imgs/");
			gridGhostProductCombiSupplier.enableSmartRendering(true);
			gridGhostProductCombiSupplier.enableMultiselect(true);
	
			gridGhostProductCombiSupplier.setHeader("<?php echo _l('Product')?>,<?php echo _l('Combination')?>");
			gridGhostProductCombiSupplier.setColAlign("left,left");
			gridGhostProductCombiSupplier.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $id=>$row) { ?>
			xml = xml+'   <row id="<?php echo $id ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $row["id_product"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo $row["id_product_attribute"] ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostProductCombiSupplier.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_SUP_GHOST_PRODUCT_COMBI_SUPPLIER").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostProductCombiSupplier()
			{
				var selectedGhostProductCombiSupplier = gridGhostProductCombiSupplier.getSelectedRowId();
				if(selectedGhostProductCombiSupplier==null || selectedGhostProductCombiSupplier=="")
					selectedGhostProductCombiSupplier = 0;
				/*if(selectedGhostProductCombiSupplier!="0")
				{*/
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_SUP_GHOST_PRODUCT_COMBI_SUPPLIER&id_lang="+SC_ID_LANG, { "action": "delete_product", "ids": selectedGhostProductCombiSupplier}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_SUP_GHOST_PRODUCT_COMBI_SUPPLIER").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_SUP_GHOST_PRODUCT_COMBI_SUPPLIER');
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
			"title"=>_l('Ghost. prod_supp'),
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
			list($id_product,$id_product_attribute) = explode("_",$id);
			
			if(!empty($id_product_attribute))
				$sql = "DELETE FROM "._DB_PREFIX_."product_supplier WHERE id_product='".(int)$id_product."' AND id_product_attribute='".(int)$id_product_attribute."'";
			else
				$sql = "DELETE FROM "._DB_PREFIX_."product_supplier WHERE id_product='".(int)$id_product."'";
			$res=dbExecuteForeignKeyOff($sql);
		}
	}
}
