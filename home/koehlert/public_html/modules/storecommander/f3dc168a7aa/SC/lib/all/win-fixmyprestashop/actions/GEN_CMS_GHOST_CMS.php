<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "select pl.id_cms, pl.link_rewrite as name from "._DB_PREFIX_."cms_lang pl where pl.id_cms not in (select p.id_cms from "._DB_PREFIX_."cms p) ORDER BY id_lang ASC LIMIT 1500";
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
	
			var tbGhostCMS = dhxlSCExtCheck.tabbar.cells("table_GEN_CMS_GHOST_CMS").attachToolbar();
			tbGhostCMS.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostCMS.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostCMS.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostCMS.setItemToolTip('delete','<?php echo _l('Delete incomplete CMS')?>');
			tbGhostCMS.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostCMS.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostCMS();
					}
				});
		
			var gridGhostCMS = dhxlSCExtCheck.tabbar.cells("table_GEN_CMS_GHOST_CMS").attachGrid();
			gridGhostCMS.setImagePath("lib/js/imgs/");
			gridGhostCMS.enableSmartRendering(true);
			gridGhostCMS.enableMultiselect(true);
	
			gridGhostCMS.setHeader("ID,<?php echo _l('Name')?>");
			gridGhostCMS.setInitWidths("100, *");
			gridGhostCMS.setColAlign("left,left");
			gridGhostCMS.init();

			var xml = '<rows>';
			<?php foreach ($res as $cms) { ?>
			xml = xml+'   <row id="<?php echo $cms["id_cms"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $cms["id_cms"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $cms["name"]) ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostCMS.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_GEN_CMS_GHOST_CMS").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostCMS()
			{
				var selectedGhostCMS = gridGhostCMS.getSelectedRowId();
				if(selectedGhostCMS==null || selectedGhostCMS=="")
					selectedGhostCMS = 0;
				if(selectedGhostCMS!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=GEN_CMS_GHOST_CMS&id_lang="+SC_ID_LANG, { "action": "delete_cms", "ids": selectedGhostCMS}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_GEN_CMS_GHOST_CMS").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('GEN_CMS_GHOST_CMS');
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
			"title"=>_l('Ghost CMS'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_cms")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$sql = "DELETE FROM "._DB_PREFIX_."cms_lang WHERE id_cms IN (".psql($post_ids).")";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
