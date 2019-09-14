<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "select p.* from "._DB_PREFIX_."carrier p where p.id_carrier not in (select pl.id_carrier from "._DB_PREFIX_."carrier_lang pl)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangGet("carrier");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingCarrierLang = dhxlSCExtCheck.tabbar.cells("table_TRP_CAR_MISSING_CARRIER_LANG").attachToolbar();
			tbMissingCarrierLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingCarrierLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingCarrierLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingCarrierLang.setItemToolTip('delete','<?php echo _l('Delete incomplete carriers')?>');
			tbMissingCarrierLang.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingCarrierLang.setItemToolTip('add','<?php echo _l('Recover incomplete carriers')?>');
			tbMissingCarrierLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingCarrierLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingCarrierLang();
					}
					if (id=='add')
					{
						addMissingCarrierLang()
					}
				});
		
			var gridMissingCarrierLang = dhxlSCExtCheck.tabbar.cells("table_TRP_CAR_MISSING_CARRIER_LANG").attachGrid();
			gridMissingCarrierLang.setImagePath("lib/js/imgs/");
			gridMissingCarrierLang.enableSmartRendering(true);
			gridMissingCarrierLang.enableMultiselect(true);
	
			gridMissingCarrierLang.setHeader("ID,<?php echo _l('Used ?')?>");
			gridMissingCarrierLang.setInitWidths("100,50");
			gridMissingCarrierLang.setColAlign("left,left");
			gridMissingCarrierLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $carrier) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."orders` WHERE id_carrier = '".(int)$carrier["id_carrier"]."'LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $carrier["id_carrier"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $carrier["id_carrier"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingCarrierLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_TRP_CAR_MISSING_CARRIER_LANG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingCarrierLang()
			{
				var selectedMissingCarrierLangs = gridMissingCarrierLang.getSelectedRowId();
				if(selectedMissingCarrierLangs==null || selectedMissingCarrierLangs=="")
					selectedMissingCarrierLangs = 0;
				if(selectedMissingCarrierLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=TRP_CAR_MISSING_CARRIER_LANG&id_lang="+SC_ID_LANG, { "action": "delete_carriers", "ids": selectedMissingCarrierLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_TRP_CAR_MISSING_CARRIER_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('TRP_CAR_MISSING_CARRIER_LANG');
						 doCheck(false);
					});
				}
			}

			function addMissingCarrierLang()
			{
				var selectedMissingCarrierLangs = gridMissingCarrierLang.getSelectedRowId();
				if(selectedMissingCarrierLangs==null || selectedMissingCarrierLangs=="")
					selectedMissingCarrierLangs = 0;
				if(selectedMissingCarrierLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=TRP_CAR_MISSING_CARRIER_LANG&id_lang="+SC_ID_LANG, { "action": "add_carriers", "ids": selectedMissingCarrierLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_TRP_CAR_MISSING_CARRIER_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('TRP_CAR_MISSING_CARRIER_LANG');
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
			"title"=>_l('Carrier lang'),
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
			$carrier = new Carrier($id);
			$carrier->delete();
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_carriers")
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
					WHERE l.id_lang not in (SELECT pl.id_lang FROM "._DB_PREFIX_."carrier_lang pl WHERE pl.id_carrier='".$id."')";
			$languages=Db::getInstance()->ExecuteS($sql);
			
			foreach($languages as $language)
			{
				$sql = "INSERT INTO "._DB_PREFIX_."carrier_lang (id_carrier, id_lang, delay)
						VALUES (".$id.",".$language["id_lang"].",'Carrier')";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
