<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "select p.* from "._DB_PREFIX_."country p where p.id_country not in (select pl.id_country from "._DB_PREFIX_."country_lang pl)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangGet("country");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingCountryLang = dhxlSCExtCheck.tabbar.cells("table_TRP_CTY_MISSING_COUNTRY_LANG").attachToolbar();
			tbMissingCountryLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingCountryLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			/*tbMissingCountryLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingCountryLang.setItemToolTip('delete','<?php echo _l('Delete incomplete countries')?>');*/
			tbMissingCountryLang.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingCountryLang.setItemToolTip('add','<?php echo _l('Recover incomplete countries')?>');
			tbMissingCountryLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingCountryLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingCountryLang();
					}
					if (id=='add')
					{
						addMissingCountryLang()
					}
				});
		
			var gridMissingCountryLang = dhxlSCExtCheck.tabbar.cells("table_TRP_CTY_MISSING_COUNTRY_LANG").attachGrid();
			gridMissingCountryLang.setImagePath("lib/js/imgs/");
			gridMissingCountryLang.enableSmartRendering(true);
			gridMissingCountryLang.enableMultiselect(true);
	
			gridMissingCountryLang.setHeader("ID,<?php echo _l('Used ?')?>");
			gridMissingCountryLang.setInitWidths("100,50");
			gridMissingCountryLang.setColAlign("left,left");
			gridMissingCountryLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $country) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."address` WHERE id_country = '".$country["id_country"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $country["id_country"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $country["id_country"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingCountryLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_TRP_CTY_MISSING_COUNTRY_LANG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingCountryLang()
			{
				var selectedMissingCountryLangs = gridMissingCountryLang.getSelectedRowId();
				if(selectedMissingCountryLangs==null || selectedMissingCountryLangs=="")
					selectedMissingCountryLangs = 0;
				if(selectedMissingCountryLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=TRP_CTY_MISSING_COUNTRY_LANG&id_lang="+SC_ID_LANG, { "action": "delete_countries", "ids": selectedMissingCountryLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_TRP_CTY_MISSING_COUNTRY_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('TRP_CTY_MISSING_COUNTRY_LANG');
						 doCheck(false);
					});
				}
			}

			function addMissingCountryLang()
			{
				var selectedMissingCountryLangs = gridMissingCountryLang.getSelectedRowId();
				if(selectedMissingCountryLangs==null || selectedMissingCountryLangs=="")
					selectedMissingCountryLangs = 0;
				if(selectedMissingCountryLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=TRP_CTY_MISSING_COUNTRY_LANG&id_lang="+SC_ID_LANG, { "action": "add_countries", "ids": selectedMissingCountryLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_TRP_CTY_MISSING_COUNTRY_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('TRP_CTY_MISSING_COUNTRY_LANG');
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
			"title"=>_l('Country lang'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_countries")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$country = new Country($id);
			$country->delete();
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_countries")
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
					WHERE l.id_lang not in (SELECT pl.id_lang FROM "._DB_PREFIX_."country_lang pl WHERE pl.id_country='".$id."')";
			$languages=Db::getInstance()->ExecuteS($sql);
			
			foreach($languages as $language)
			{
				$sql = "INSERT INTO "._DB_PREFIX_."country_lang (id_country, id_lang, name)
						VALUES (".$id.",".$language["id_lang"].",'Country')";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
