<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "select p.* from "._DB_PREFIX_."manufacturer p where p.id_manufacturer not in (select pl.id_manufacturer from "._DB_PREFIX_."manufacturer_lang pl)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangGet("manufacturer");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingManufacturerLang = dhxlSCExtCheck.tabbar.cells("table_CAT_MAN_MISSING_MANUFACTURER_LANG").attachToolbar();
			tbMissingManufacturerLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingManufacturerLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingManufacturerLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingManufacturerLang.setItemToolTip('delete','<?php echo _l('Delete incomplete manufacturers')?>');
			tbMissingManufacturerLang.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingManufacturerLang.setItemToolTip('add','<?php echo _l('Recover incomplete manufacturers')?>');
			tbMissingManufacturerLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingManufacturerLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingManufacturerLang();
					}
					if (id=='add')
					{
						addMissingManufacturerLang()
					}
				});
		
			var gridMissingManufacturerLang = dhxlSCExtCheck.tabbar.cells("table_CAT_MAN_MISSING_MANUFACTURER_LANG").attachGrid();
			gridMissingManufacturerLang.setImagePath("lib/js/imgs/");
			gridMissingManufacturerLang.enableSmartRendering(true);
			gridMissingManufacturerLang.enableMultiselect(true);
	
			gridMissingManufacturerLang.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Used?')?>");
			gridMissingManufacturerLang.setInitWidths("100,110,50");
			gridMissingManufacturerLang.setColAlign("left,left,left");
			gridMissingManufacturerLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $manufacturer) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."manufacturer` WHERE id_manufacturer = '".(int)$manufacturer["id_manufacturer"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $manufacturer["id_manufacturer"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $manufacturer["id_manufacturer"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $manufacturer["name"]); ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingManufacturerLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_MAN_MISSING_MANUFACTURER_LANG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingManufacturerLang()
			{
				var selectedMissingManufacturerLangs = gridMissingManufacturerLang.getSelectedRowId();
				if(selectedMissingManufacturerLangs==null || selectedMissingManufacturerLangs=="")
					selectedMissingManufacturerLangs = 0;
				if(selectedMissingManufacturerLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_MAN_MISSING_MANUFACTURER_LANG&id_lang="+SC_ID_LANG, { "action": "delete_manufacturers", "ids": selectedMissingManufacturerLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_MAN_MISSING_MANUFACTURER_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_MAN_MISSING_MANUFACTURER_LANG');
						 doCheck(false);
					});
				}
			}

			function addMissingManufacturerLang()
			{
				var selectedMissingManufacturerLangs = gridMissingManufacturerLang.getSelectedRowId();
				if(selectedMissingManufacturerLangs==null || selectedMissingManufacturerLangs=="")
					selectedMissingManufacturerLangs = 0;
				if(selectedMissingManufacturerLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_MAN_MISSING_MANUFACTURER_LANG&id_lang="+SC_ID_LANG, { "action": "add_manufacturers", "ids": selectedMissingManufacturerLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_MAN_MISSING_MANUFACTURER_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_MAN_MISSING_MANUFACTURER_LANG');
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
			"title"=>_l('Manuf. lang'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_manufacturers")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$manufacturer = new Manufacturer($id);
			$manufacturer->delete();
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_manufacturers")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		//$languages = Language::getLanguages(false);
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$sql = "SELECT  l.*
					FROM "._DB_PREFIX_."lang l
					WHERE l.id_lang not in (SELECT pl.id_lang FROM "._DB_PREFIX_."manufacturer_lang pl WHERE pl.id_manufacturer='".(int)$id."')";
			$languages=Db::getInstance()->ExecuteS($sql);
			
			foreach($languages as $language)
			{
				$sql = "INSERT INTO "._DB_PREFIX_."manufacturer_lang (id_manufacturer, id_lang)
						VALUES (".(int)$id.",".(int)$language["id_lang"].")";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
