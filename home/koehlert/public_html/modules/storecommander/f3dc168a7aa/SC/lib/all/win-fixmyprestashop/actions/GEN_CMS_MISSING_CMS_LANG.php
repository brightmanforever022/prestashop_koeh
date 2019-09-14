<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "select p.* from "._DB_PREFIX_."cms p where p.id_cms not in (select pl.id_cms from "._DB_PREFIX_."cms_lang pl)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangGet("cms");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingCMSLang = dhxlSCExtCheck.tabbar.cells("table_GEN_CMS_MISSING_CMS_LANG").attachToolbar();
			tbMissingCMSLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingCMSLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingCMSLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingCMSLang.setItemToolTip('delete','<?php echo _l('Delete incomplete CMS')?>');
			tbMissingCMSLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingCMSLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingCMSLang();
					}
				});
		
			var gridMissingCMSLang = dhxlSCExtCheck.tabbar.cells("table_GEN_CMS_MISSING_CMS_LANG").attachGrid();
			gridMissingCMSLang.setImagePath("lib/js/imgs/");
			gridMissingCMSLang.enableSmartRendering(true);
			gridMissingCMSLang.enableMultiselect(true);
	
			gridMissingCMSLang.setHeader("ID");
			gridMissingCMSLang.setInitWidths("*");
			gridMissingCMSLang.setColAlign("left");
			gridMissingCMSLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $cms) { ?>
			xml = xml+'   <row id="<?php echo $cms["id_cms"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $cms["id_cms"] ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingCMSLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_GEN_CMS_MISSING_CMS_LANG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingCMSLang()
			{
				var selectedMissingCMSLangs = gridMissingCMSLang.getSelectedRowId();
				if(selectedMissingCMSLangs==null || selectedMissingCMSLangs=="")
					selectedMissingCMSLangs = 0;
				if(selectedMissingCMSLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=GEN_CMS_MISSING_CMS_LANG&id_lang="+SC_ID_LANG, { "action": "delete_cms", "ids": selectedMissingCMSLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_GEN_CMS_MISSING_CMS_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('GEN_CMS_MISSING_CMS_LANG');
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
			"title"=>_l('CMS lang'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_cms")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$cms = new CMS($id);
			$cms->delete();
		}
	}
}