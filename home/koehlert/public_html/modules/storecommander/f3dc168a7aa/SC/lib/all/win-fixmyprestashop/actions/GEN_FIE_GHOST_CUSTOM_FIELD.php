<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT pl.id_customization_field, pl.name FROM "._DB_PREFIX_."customization_field_lang pl WHERE pl.id_customization_field NOT IN (SELECT p.id_customization_field FROM "._DB_PREFIX_."customization_field p) ORDER BY id_lang ASC LIMIT 1500";
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
	
			var tbGhostCustomizationField = dhxlSCExtCheck.tabbar.cells("table_GEN_FIE_GHOST_CUSTOM_FIELD").attachToolbar();
			tbGhostCustomizationField.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostCustomizationField.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostCustomizationField.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostCustomizationField.setItemToolTip('delete','<?php echo _l('Delete incomplete customization fields')?>');
			tbGhostCustomizationField.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostCustomizationField.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostCustomizationField();
					}
				});
		
			var gridGhostCustomizationField = dhxlSCExtCheck.tabbar.cells("table_GEN_FIE_GHOST_CUSTOM_FIELD").attachGrid();
			gridGhostCustomizationField.setImagePath("lib/js/imgs/");
			gridGhostCustomizationField.enableSmartRendering(true);
			gridGhostCustomizationField.enableMultiselect(true);
	
			gridGhostCustomizationField.setHeader("ID,<?php echo _l('Name')?>");
			gridGhostCustomizationField.setInitWidths("100,50");
			gridGhostCustomizationField.setColAlign("left,left");
			gridGhostCustomizationField.init();

			var xml = '<rows>';
			<?php foreach ($res as $customization_field) { ?>
			xml = xml+'   <row id="<?php echo $customization_field["id_customization_field"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $customization_field["id_customization_field"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $customization_field["name"]); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostCustomizationField.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_GEN_FIE_GHOST_CUSTOM_FIELD").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostCustomizationField()
			{
				var selectedGhostCustomizationFields = gridGhostCustomizationField.getSelectedRowId();
				if(selectedGhostCustomizationFields==null || selectedGhostCustomizationFields=="")
					selectedGhostCustomizationFields = 0;
				if(selectedGhostCustomizationFields!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=GEN_FIE_GHOST_CUSTOM_FIELD&id_lang="+SC_ID_LANG, { "action": "delete_customization_fields", "ids": selectedGhostCustomizationFields}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_GEN_FIE_GHOST_CUSTOM_FIELD").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('GEN_FIE_GHOST_CUSTOM_FIELD');
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
			"title"=>_l('Ghost field'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_customization_fields")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$sql = "DELETE FROM "._DB_PREFIX_."customization_field_lang WHERE id_customization_field IN (".psql($post_ids).")";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
