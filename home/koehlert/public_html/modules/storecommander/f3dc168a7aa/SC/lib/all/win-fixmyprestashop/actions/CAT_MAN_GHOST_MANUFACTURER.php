<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "select pl.id_manufacturer from "._DB_PREFIX_."manufacturer_lang pl where pl.id_manufacturer not in (select p.id_manufacturer from "._DB_PREFIX_."manufacturer p) ORDER BY id_lang ASC LIMIT 1500";
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
	
			var tbGhostManufacturer = dhxlSCExtCheck.tabbar.cells("table_CAT_MAN_GHOST_MANUFACTURER").attachToolbar();
			tbGhostManufacturer.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostManufacturer.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostManufacturer.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostManufacturer.setItemToolTip('delete','<?php echo _l('Delete incomplete manufacturers')?>');
			tbGhostManufacturer.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbGhostManufacturer.setItemToolTip('add','<?php echo _l('Recover incomplete manufacturers')?>');
			tbGhostManufacturer.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostManufacturer.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostManufacturer();
					}
					if (id=='add')
					{
						addGhostManufacturer()
					}
				});
		
			var gridGhostManufacturer = dhxlSCExtCheck.tabbar.cells("table_CAT_MAN_GHOST_MANUFACTURER").attachGrid();
			gridGhostManufacturer.setImagePath("lib/js/imgs/");
			gridGhostManufacturer.enableSmartRendering(true);
			gridGhostManufacturer.enableMultiselect(true);
	
			gridGhostManufacturer.setHeader("ID,<?php echo _l('Used?')?>");
			gridGhostManufacturer.setInitWidths("100,50");
			gridGhostManufacturer.setColAlign("left,left");
			gridGhostManufacturer.init();

			var xml = '<rows>';
			<?php foreach ($res as $manufacturer) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."product` WHERE id_manufacturer = '".(int)$manufacturer["id_manufacturer"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $manufacturer["id_manufacturer"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $manufacturer["id_manufacturer"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostManufacturer.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_MAN_GHOST_MANUFACTURER").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostManufacturer()
			{
				var selectedGhostManufacturers = gridGhostManufacturer.getSelectedRowId();
				if(selectedGhostManufacturers==null || selectedGhostManufacturers=="")
					selectedGhostManufacturers = 0;
				if(selectedGhostManufacturers!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_MAN_GHOST_MANUFACTURER&id_lang="+SC_ID_LANG, { "action": "delete_manufacturers", "ids": selectedGhostManufacturers}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_MAN_GHOST_MANUFACTURER").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_MAN_GHOST_MANUFACTURER');
						 doCheck(false);
					});
				}
			}

			function addGhostManufacturer()
			{
				var selectedGhostManufacturers = gridGhostManufacturer.getSelectedRowId();
				if(selectedGhostManufacturers==null || selectedGhostManufacturers=="")
					selectedGhostManufacturers = 0;
				if(selectedGhostManufacturers!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_MAN_GHOST_MANUFACTURER&id_lang="+SC_ID_LANG, { "action": "add_manufacturers", "ids": selectedGhostManufacturers}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_MAN_GHOST_MANUFACTURER").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_MAN_GHOST_MANUFACTURER');
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
			"title"=>_l('Ghost manuf.'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_manufacturers")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$sql = "DELETE FROM "._DB_PREFIX_."manufacturer_lang WHERE id_manufacturer IN (".psql($post_ids).")";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
elseif(!empty($post_action) && $post_action=="add_manufacturers")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$sql = "INSERT INTO "._DB_PREFIX_."manufacturer (id_manufacturer, name, active, date_add, date_upd)
					VALUES (".(int)$id.",'Manufacturer', 0, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";
			$res=dbExecuteForeignKeyOff($sql);
		}
	}
}
