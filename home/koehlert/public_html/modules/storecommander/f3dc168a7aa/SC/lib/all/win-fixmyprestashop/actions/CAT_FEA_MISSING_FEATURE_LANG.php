<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "select p.* from "._DB_PREFIX_."feature p where p.id_feature not in (select pl.id_feature from "._DB_PREFIX_."feature_lang pl)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangGet("feature");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingFeatureLang = dhxlSCExtCheck.tabbar.cells("table_CAT_FEA_MISSING_FEATURE_LANG").attachToolbar();
			tbMissingFeatureLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingFeatureLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingFeatureLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingFeatureLang.setItemToolTip('delete','<?php echo _l('Delete incomplete features')?>');
			tbMissingFeatureLang.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingFeatureLang.setItemToolTip('add','<?php echo _l('Recover incomplete features')?>');
			tbMissingFeatureLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingFeatureLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingFeatureLang();
					}
					if (id=='add')
					{
						addMissingFeatureLang()
					}
				});
		
			var gridMissingFeatureLang = dhxlSCExtCheck.tabbar.cells("table_CAT_FEA_MISSING_FEATURE_LANG").attachGrid();
			gridMissingFeatureLang.setImagePath("lib/js/imgs/");
			gridMissingFeatureLang.enableSmartRendering(true);
			gridMissingFeatureLang.enableMultiselect(true);
	
			gridMissingFeatureLang.setHeader("ID,<?php echo _l('Used?')?>");
			gridMissingFeatureLang.setInitWidths("100,50");
			gridMissingFeatureLang.setColAlign("left,left");
			gridMissingFeatureLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $feature) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."feature_product` WHERE id_feature = '".(int)$feature["id_feature"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $feature["id_feature"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $feature["id_feature"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingFeatureLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_FEA_MISSING_FEATURE_LANG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });
			
			function deleteMissingFeatureLang()
			{
				var selectedMissingFeatureLangs = gridMissingFeatureLang.getSelectedRowId();
				if(selectedMissingFeatureLangs==null || selectedMissingFeatureLangs=="")
					selectedMissingFeatureLangs = 0;
				if(selectedMissingFeatureLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_FEA_MISSING_FEATURE_LANG&id_lang="+SC_ID_LANG, { "action": "delete_features", "ids": selectedMissingFeatureLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_FEA_MISSING_FEATURE_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_FEA_MISSING_FEATURE_LANG');
						 doCheck(false);
					});
				}
			}

			function addMissingFeatureLang()
			{
				var selectedMissingFeatureLangs = gridMissingFeatureLang.getSelectedRowId();
				if(selectedMissingFeatureLangs==null || selectedMissingFeatureLangs=="")
					selectedMissingFeatureLangs = 0;
				if(selectedMissingFeatureLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_FEA_MISSING_FEATURE_LANG&id_lang="+SC_ID_LANG, { "action": "add_features", "ids": selectedMissingFeatureLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_FEA_MISSING_FEATURE_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_FEA_MISSING_FEATURE_LANG');
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
			"title"=>_l('Feature lang'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_features")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$feature = new Feature($id);
			$feature->delete();
			if(version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			{
				$sql = "DELETE FROM "._DB_PREFIX_."feature WHERE id_feature = ".(int)$id."";
				dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_features")
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
					WHERE l.id_lang not in (SELECT pl.id_lang FROM "._DB_PREFIX_."feature_lang pl WHERE pl.id_feature='".(int)$id."')";
			$languages=Db::getInstance()->ExecuteS($sql);
			
			foreach($languages as $language)
			{
				$sql = "INSERT INTO "._DB_PREFIX_."feature_lang (id_feature, id_lang, name)
						VALUES (".(int)$id.",".(int)$language["id_lang"].",'Feature')";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
