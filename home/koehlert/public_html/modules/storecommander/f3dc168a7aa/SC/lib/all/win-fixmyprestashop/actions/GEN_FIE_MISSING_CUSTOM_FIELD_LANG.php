<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "select p.* from "._DB_PREFIX_."customization_field p where p.id_customization_field not in (select pl.id_customization_field from "._DB_PREFIX_."customization_field_lang pl)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangGet("customization_field");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingCustomizationFieldLang = dhxlSCExtCheck.tabbar.cells("table_GEN_FIE_MISSING_CUSTOM_FIELD_LANG").attachToolbar();
			tbMissingCustomizationFieldLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingCustomizationFieldLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingCustomizationFieldLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingCustomizationFieldLang.setItemToolTip('delete','<?php echo _l('Delete incomplete customization fields')?>');
			tbMissingCustomizationFieldLang.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingCustomizationFieldLang.setItemToolTip('add','<?php echo _l('Recover incomplete customization fields')?>');
			tbMissingCustomizationFieldLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingCustomizationFieldLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingCustomizationFieldLang();
					}
					if (id=='add')
					{
						addMissingCustomizationFieldLang()
					}
				});
		
			var gridMissingCustomizationFieldLang = dhxlSCExtCheck.tabbar.cells("table_GEN_FIE_MISSING_CUSTOM_FIELD_LANG").attachGrid();
			gridMissingCustomizationFieldLang.setImagePath("lib/js/imgs/");
			gridMissingCustomizationFieldLang.enableSmartRendering(true);
			gridMissingCustomizationFieldLang.enableMultiselect(true);
	
			gridMissingCustomizationFieldLang.setHeader("ID");
			gridMissingCustomizationFieldLang.setInitWidths("*");
			gridMissingCustomizationFieldLang.setColAlign("left");
			gridMissingCustomizationFieldLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $customization_field) { ?>
			xml = xml+'   <row id="<?php echo $customization_field["id_customization_field"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $customization_field["id_customization_field"] ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingCustomizationFieldLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_GEN_FIE_MISSING_CUSTOM_FIELD_LANG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingCustomizationFieldLang()
			{
				var selectedMissingCustomizationFieldLangs = gridMissingCustomizationFieldLang.getSelectedRowId();
				if(selectedMissingCustomizationFieldLangs==null || selectedMissingCustomizationFieldLangs=="")
					selectedMissingCustomizationFieldLangs = 0;
				if(selectedMissingCustomizationFieldLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=GEN_FIE_MISSING_CUSTOM_FIELD_LANG&id_lang="+SC_ID_LANG, { "action": "delete_customization_fields", "ids": selectedMissingCustomizationFieldLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_GEN_FIE_MISSING_CUSTOM_FIELD_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('GEN_FIE_MISSING_CUSTOM_FIELD_LANG');
						 doCheck(false);
					});
				}
			}

			function addMissingCustomizationFieldLang()
			{
				var selectedMissingCustomizationFieldLangs = gridMissingCustomizationFieldLang.getSelectedRowId();
				if(selectedMissingCustomizationFieldLangs==null || selectedMissingCustomizationFieldLangs=="")
					selectedMissingCustomizationFieldLangs = 0;
				if(selectedMissingCustomizationFieldLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=GEN_FIE_MISSING_CUSTOM_FIELD_LANG&id_lang="+SC_ID_LANG, { "action": "add_customization_fields", "ids": selectedMissingCustomizationFieldLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_GEN_FIE_MISSING_CUSTOM_FIELD_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('GEN_FIE_MISSING_CUSTOM_FIELD_LANG');
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
			"title"=>_l('Field lang'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_customization_fields")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$customization_field = new CustomizationField($id);
			$customization_field->delete();
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_customization_fields")
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
					WHERE l.id_lang not in (SELECT pl.id_lang FROM "._DB_PREFIX_."customization_field_lang pl WHERE pl.id_customization_field='".(int)$id."')";
			$languages=Db::getInstance()->ExecuteS($sql);
			
			foreach($languages as $language)
			{
				$sql = "INSERT INTO "._DB_PREFIX_."customization_field_lang (id_customization_field, id_lang, name)
						VALUES (".$id.",".$language["id_lang"].",'Customized field')";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
