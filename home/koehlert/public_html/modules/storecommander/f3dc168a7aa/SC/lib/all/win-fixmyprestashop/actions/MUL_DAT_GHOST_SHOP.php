<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*
	 * TABLES
	 */
    include (dirname(__FILE__).'/../all_win-fixmyprestashop_controls.php');
	
	/*
	 * REQUETES
	 */
	$content = "";
	$content_js = "";
	$results = "OK";
	$elements = array();

	foreach($shop_tables as $shop_table)
	{
		$good_version = true;
		if(!empty($shop_table['vs_min']) && version_compare(_PS_VERSION_, $shop_table['vs_min'], '<'))
			$good_version = false;
		if(!empty($shop_table['vs_max']) && version_compare(_PS_VERSION_, $shop_table['vs_max'], '>'))
			$good_version = false;
		if($good_version)
		{
			$sql = "select pl.* from "._DB_PREFIX_.$shop_table["table"]."_shop pl where pl.id_".$shop_table["table"]." not in (select p.id_".$shop_table["table"]." from "._DB_PREFIX_.$shop_table["table"]." p) ORDER BY id_shop ASC LIMIT 1500";
			$res=Db::getInstance()->ExecuteS($sql);
			if(!empty($res) && count($res)>0)
			{
				foreach($res as $row)
				{
					$elements[] = array(
						"id"=> $row["id_".$shop_table["table"]],
						"table"=> $shop_table["table"]
					);
				}
			}
		}
	}

	if(!empty($elements) && count($elements)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">

			var tbGhostShop = dhxlSCExtCheck.tabbar.cells("table_MUL_DAT_GHOST_SHOP").attachToolbar();
			tbGhostShop.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostShop.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostShop.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostShop.setItemToolTip('delete','<?php echo _l('Delete incomplete elements')?>');
			tbGhostShop.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostShop.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostShop();
					}
				});
		
			var gridGhostShop = dhxlSCExtCheck.tabbar.cells("table_MUL_DAT_GHOST_SHOP").attachGrid();
			gridGhostShop.setImagePath("lib/js/imgs/");
			gridGhostShop.enableSmartRendering(true);
			gridGhostShop.enableMultiselect(true);
	
			gridGhostShop.setHeader("<?php echo _l('Table')?>,ID");
			gridGhostShop.setInitWidths("100,50");
			gridGhostShop.setColAlign("left,left");
			gridGhostShop.init();

			var xml = '<rows>';
			<?php foreach ($elements as $element) { ?>
			xml = xml+'   <row id="<?php echo $element["table"]."-".$element["id"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $element["table"]) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo $element["id"] ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostShop.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_MUL_DAT_GHOST_SHOP").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($elements) ; ?>', height: 25 });

			function deleteGhostShop()
			{
				var selectedGhostShops = gridGhostShop.getSelectedRowId();
				if(selectedGhostShops==null || selectedGhostShops=="")
					selectedGhostShops = 0;
				if(selectedGhostShops!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=MUL_DAT_GHOST_SHOP&id_lang="+SC_ID_LANG, { "action": "delete_shops", "ids": selectedGhostShops}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_MUL_DAT_GHOST_SHOP").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('MUL_DAT_GHOST_SHOP');
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
			"title"=>_l('Ghost shop'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_shops")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",", $post_ids);
		foreach($ids as $table_id)
		{
			list($table, $id) = explode("-", $table_id);
			
			$sql = "DELETE FROM "._DB_PREFIX_.$table."_shop WHERE id_".$table." = '".$id."'";
			$res=dbExecuteForeignKeyOff($sql);
		}
	}
}
