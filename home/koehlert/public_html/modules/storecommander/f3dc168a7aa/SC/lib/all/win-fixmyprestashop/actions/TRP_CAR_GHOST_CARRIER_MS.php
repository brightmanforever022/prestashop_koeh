<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT pl.id_carrier, pl.delay, pl.id_shop, s.name as shop_name
			FROM "._DB_PREFIX_."carrier_lang pl
				INNER JOIN "._DB_PREFIX_."shop s ON (pl.id_shop = s.id_shop)
			WHERE pl.id_carrier NOT IN (SELECT ps.id_carrier FROM "._DB_PREFIX_."carrier_shop ps WHERE ps.id_shop = pl.id_shop)
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
	
			var tbGhostCarrier = dhxlSCExtCheck.tabbar.cells("table_TRP_CAR_GHOST_CARRIER_MS").attachToolbar();
			tbGhostCarrier.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostCarrier.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostCarrier.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostCarrier.setItemToolTip('delete','<?php echo _l('Delete ghost carrier for these shops')?>');
			tbGhostCarrier.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbGhostCarrier.setItemToolTip('add','<?php echo _l('Recover incomplete carriers')?>');
			tbGhostCarrier.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostCarrier.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostCarrier();
					}
					if (id=='add')
					{
						addGhostCarrier()
					}
				});
		
			var gridGhostCarrier = dhxlSCExtCheck.tabbar.cells("table_TRP_CAR_GHOST_CARRIER_MS").attachGrid();
			gridGhostCarrier.setImagePath("lib/js/imgs/");
			gridGhostCarrier.enableSmartRendering(true);
			gridGhostCarrier.enableMultiselect(true);
	
			gridGhostCarrier.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Used ?')?>,<?php echo _l('Shop')?>");
			gridGhostCarrier.setInitWidths("100, 110,110,200");
			gridGhostCarrier.setColAlign("left,left,left,left");
			gridGhostCarrier.init();

			var xml = '<rows>';
			<?php foreach ($res as $carrier) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."orders` WHERE id_carrier = '".$carrier["id_carrier"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $carrier["id_carrier"]."_".$carrier["id_shop"]; ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $carrier["id_carrier"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $carrier["delay"]) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $carrier["shop_name"])." (#".$carrier["id_shop"].")"; ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostCarrier.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_TRP_CAR_GHOST_CARRIER_MS").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostCarrier()
			{
				var selectedGhostCarriers = gridGhostCarrier.getSelectedRowId();
				if(selectedGhostCarriers==null || selectedGhostCarriers=="")
					selectedGhostCarriers = 0;
				if(selectedGhostCarriers!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=TRP_CAR_GHOST_CARRIER_MS&id_lang="+SC_ID_LANG, { "action": "delete_carriers", "ids": selectedGhostCarriers}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_TRP_CAR_GHOST_CARRIER_MS").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('TRP_CAR_GHOST_CARRIER_MS');
						 doCheck(false);
					});
				}
			}

			function addGhostCarrier()
			{
				var selectedGhostCarriers = gridGhostCarrier.getSelectedRowId();
				if(selectedGhostCarriers==null || selectedGhostCarriers=="")
					selectedGhostCarriers = 0;
				if(selectedGhostCarriers!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=TRP_CAR_GHOST_CARRIER_MS&id_lang="+SC_ID_LANG, { "action": "add_carriers", "ids": selectedGhostCarriers}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_TRP_CAR_GHOST_CARRIER_MS").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('TRP_CAR_GHOST_CARRIER_MS');
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
			"title"=>_l('Ghost carrier'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_carriers")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			list($id_carrier, $id_shop) = explode("_",$id);
		
			$sql = "DELETE FROM "._DB_PREFIX_."carrier_lang WHERE id_carrier = ".(int)$id_carrier." AND id_shop = ".(int)$id_shop."";
			dbExecuteForeignKeyOff($sql);
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_carriers")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			list($id_carrier, $id_shop) = explode("_",$id);
			
			$sql = "INSERT INTO "._DB_PREFIX_."carrier_shop (id_carrier, id_shop)
					VALUES('".(int)$id_carrier."','".(int)$id_shop."')";
			dbExecuteForeignKeyOff($sql);
		}
	}
}
