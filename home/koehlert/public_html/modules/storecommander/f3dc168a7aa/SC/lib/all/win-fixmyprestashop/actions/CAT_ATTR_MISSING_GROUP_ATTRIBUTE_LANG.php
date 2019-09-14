<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "select p.* from "._DB_PREFIX_."attribute_group p where p.id_attribute_group not in (select pl.id_attribute_group from "._DB_PREFIX_."attribute_group_lang pl)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangGet("attribute_group");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingAttributeGroupLang = dhxlSCExtCheck.tabbar.cells("table_CAT_ATTR_MISSING_GROUP_ATTRIBUTE_LANG").attachToolbar();
			tbMissingAttributeGroupLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingAttributeGroupLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingAttributeGroupLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingAttributeGroupLang.setItemToolTip('delete','<?php echo _l('Delete incomplete attribute_groups')?>');
			tbMissingAttributeGroupLang.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingAttributeGroupLang.setItemToolTip('add','<?php echo _l('Recover incomplete attributes groups')?>');
			tbMissingAttributeGroupLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingAttributeGroupLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingAttributeGroupLang();
					}
					if (id=='add')
					{
						addMissingAttributeGroupLang()
					}
				});
		
			var gridMissingAttributeGroupLang = dhxlSCExtCheck.tabbar.cells("table_CAT_ATTR_MISSING_GROUP_ATTRIBUTE_LANG").attachGrid();
			gridMissingAttributeGroupLang.setImagePath("lib/js/imgs/");
			gridMissingAttributeGroupLang.enableSmartRendering(true);
			gridMissingAttributeGroupLang.enableMultiselect(true);
	
			gridMissingAttributeGroupLang.setHeader("ID,<?php echo _l('Used?')?>");
			gridMissingAttributeGroupLang.setInitWidths("100,50");
			gridMissingAttributeGroupLang.setColAlign("left,left");
			gridMissingAttributeGroupLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $attribute_group) {
				$sql = "SELECT pac.* 
				FROM `"._DB_PREFIX_."product_attribute_combination` pac 
					INNER JOIN "._DB_PREFIX_."attribute a ON a.id_attribute = pac.id_attribute
				WHERE a.id_attribute_group = '".(int)$attribute_group["id_attribute_group"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $attribute_group["id_attribute_group"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $attribute_group["id_attribute_group"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingAttributeGroupLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_ATTR_MISSING_GROUP_ATTRIBUTE_LANG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingAttributeGroupLang()
			{
				var selectedMissingAttributeGroupLangs = gridMissingAttributeGroupLang.getSelectedRowId();
				if(selectedMissingAttributeGroupLangs==null || selectedMissingAttributeGroupLangs=="")
					selectedMissingAttributeGroupLangs = 0;
				if(selectedMissingAttributeGroupLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_ATTR_MISSING_GROUP_ATTRIBUTE_LANG&id_lang="+SC_ID_LANG, { "action": "delete_attribute_groups", "ids": selectedMissingAttributeGroupLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_ATTR_MISSING_GROUP_ATTRIBUTE_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_ATTR_MISSING_GROUP_ATTRIBUTE_LANG');
						 doCheck(false);
					});
				}
			}

			function addMissingAttributeGroupLang()
			{
				var selectedMissingAttributeGroupLangs = gridMissingAttributeGroupLang.getSelectedRowId();
				if(selectedMissingAttributeGroupLangs==null || selectedMissingAttributeGroupLangs=="")
					selectedMissingAttributeGroupLangs = 0;
				if(selectedMissingAttributeGroupLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_ATTR_MISSING_GROUP_ATTRIBUTE_LANG&id_lang="+SC_ID_LANG, { "action": "add_attribute_groups", "ids": selectedMissingAttributeGroupLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_ATTR_MISSING_GROUP_ATTRIBUTE_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_ATTR_MISSING_GROUP_ATTRIBUTE_LANG');
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
			"title"=>_l('Attr. Group lg.'),			
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_attribute_groups")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$attribute_group = new AttributeGroup($id);
			$attribute_group->delete();
			if(version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			{
				$sql = "DELETE FROM "._DB_PREFIX_."attribute_group WHERE id_attribute_group = ".(int)$id."";
				dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_attribute_groups")
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
					WHERE l.id_lang not in (SELECT pl.id_lang FROM "._DB_PREFIX_."attribute_group_lang pl WHERE pl.id_attribute_group='".(int)$id."')";
			$languages=Db::getInstance()->ExecuteS($sql);
			
			foreach($languages as $language)
			{
				$sql = "INSERT INTO "._DB_PREFIX_."attribute_group_lang (id_attribute_group, id_lang, name, public_name)
						VALUES (".(int)$id.",".(int)$language["id_lang"].",'Attribute group','Attribute group')";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
