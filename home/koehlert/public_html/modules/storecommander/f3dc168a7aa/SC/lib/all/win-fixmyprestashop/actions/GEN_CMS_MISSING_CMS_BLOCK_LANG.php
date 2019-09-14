<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "select p.* from "._DB_PREFIX_."cms_block p where p.id_cms_block not in (select pl.id_cms_block from "._DB_PREFIX_."cms_block_lang pl)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangGet("cms_block");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingCmsBlockLang = dhxlSCExtCheck.tabbar.cells("table_GEN_CMS_MISSING_CMS_BLOCK_LANG").attachToolbar();
			tbMissingCmsBlockLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingCmsBlockLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingCmsBlockLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingCmsBlockLang.setItemToolTip('delete','<?php echo _l('Delete incomplete CMS blocks')?>');
			tbMissingCmsBlockLang.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingCmsBlockLang.setItemToolTip('add','<?php echo _l('Recover incomplete CMS blocks')?>');
			tbMissingCmsBlockLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingCmsBlockLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingCmsBlockLang();
					}
					if (id=='add')
					{
						addMissingCmsBlockLang()
					}
				});
		
			var gridMissingCmsBlockLang = dhxlSCExtCheck.tabbar.cells("table_GEN_CMS_MISSING_CMS_BLOCK_LANG").attachGrid();
			gridMissingCmsBlockLang.setImagePath("lib/js/imgs/");
			gridMissingCmsBlockLang.enableSmartRendering(true);
			gridMissingCmsBlockLang.enableMultiselect(true);
	
			gridMissingCmsBlockLang.setHeader("ID");
			gridMissingCmsBlockLang.setInitWidths("*");
			gridMissingCmsBlockLang.setColAlign("left");
			gridMissingCmsBlockLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $cms_block) {?>
			xml = xml+'   <row id="<?php echo $cms_block["id_cms_block"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $cms_block["id_cms_block"] ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingCmsBlockLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_GEN_CMS_MISSING_CMS_BLOCK_LANG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingCmsBlockLang()
			{
				var selectedMissingCmsBlockLangs = gridMissingCmsBlockLang.getSelectedRowId();
				if(selectedMissingCmsBlockLangs==null || selectedMissingCmsBlockLangs=="")
					selectedMissingCmsBlockLangs = 0;
				if(selectedMissingCmsBlockLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=GEN_CMS_MISSING_CMS_BLOCK_LANG&id_lang="+SC_ID_LANG, { "action": "delete_cms_blocks", "ids": selectedMissingCmsBlockLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_GEN_CMS_MISSING_CMS_BLOCK_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('GEN_CMS_MISSING_CMS_BLOCK_LANG');
						 doCheck(false);
					});
				}
			}

			function addMissingCmsBlockLang()
			{
				var selectedMissingCmsBlockLangs = gridMissingCmsBlockLang.getSelectedRowId();
				if(selectedMissingCmsBlockLangs==null || selectedMissingCmsBlockLangs=="")
					selectedMissingCmsBlockLangs = 0;
				if(selectedMissingCmsBlockLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=GEN_CMS_MISSING_CMS_BLOCK_LANG&id_lang="+SC_ID_LANG, { "action": "add_cms_blocks", "ids": selectedMissingCmsBlockLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_GEN_CMS_MISSING_CMS_BLOCK_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('GEN_CMS_MISSING_CMS_BLOCK_LANG');
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
			"title"=>_l('CMS block lang'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_cms_blocks")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$sql = "DELETE FROM "._DB_PREFIX_."cms_block WHERE id_cms_block = '".(int)$id."'";
			$res=Db::getInstance()->ExecuteS($sql);
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_cms_blocks")
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
					WHERE l.id_lang not in (SELECT pl.id_lang FROM "._DB_PREFIX_."cms_block_lang pl WHERE pl.id_cms_block='".(int)$id."')";
			$languages=Db::getInstance()->ExecuteS($sql);
			
			foreach($languages as $language)
			{
				$sql = "INSERT INTO "._DB_PREFIX_."cms_block_lang (id_cms_block, id_lang, name)
						VALUES (".(int)$id.",".(int)$language["id_lang"].",'Cms Block')";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
