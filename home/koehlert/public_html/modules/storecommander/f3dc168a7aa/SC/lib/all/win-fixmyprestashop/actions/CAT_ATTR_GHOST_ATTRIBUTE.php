<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "select pl.id_attribute, pl.name from "._DB_PREFIX_."attribute_lang pl where pl.id_attribute not in (select p.id_attribute from "._DB_PREFIX_."attribute p) ORDER BY id_lang ASC LIMIT 1500";
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
	
			var tbGhostAttribut = dhxlSCExtCheck.tabbar.cells("table_CAT_ATTR_GHOST_ATTRIBUTE").attachToolbar();
			tbGhostAttribut.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostAttribut.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostAttribut.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostAttribut.setItemToolTip('delete','<?php echo _l('Delete incomplete attributes')?>');
			tbGhostAttribut.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostAttribut.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostAttribut();
					}
				});
		
			var gridGhostAttribut = dhxlSCExtCheck.tabbar.cells("table_CAT_ATTR_GHOST_ATTRIBUTE").attachGrid();
			gridGhostAttribut.setImagePath("lib/js/imgs/");
			gridGhostAttribut.enableSmartRendering(true);
			gridGhostAttribut.enableMultiselect(true);
	
			gridGhostAttribut.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Used?')?>");
			gridGhostAttribut.setInitWidths("100, 80,50");
			gridGhostAttribut.setColAlign("left,left,left");
			gridGhostAttribut.init();

			var xml = '<rows>';
			<?php foreach ($res as $attribute) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."product_attribute_combination` WHERE id_attribute = '".$attribute["id_attribute"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $attribute["id_attribute"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $attribute["id_attribute"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", str_replace("\n", "", str_replace("\r", "",$attribute["name"]))) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostAttribut.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_ATTR_GHOST_ATTRIBUTE").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostAttribut()
			{
				var selectedGhostAttributs = gridGhostAttribut.getSelectedRowId();
				if(selectedGhostAttributs==null || selectedGhostAttributs=="")
					selectedGhostAttributs = 0;
				if(selectedGhostAttributs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_ATTR_GHOST_ATTRIBUTE&id_lang="+SC_ID_LANG, { "action": "delete_attributes", "ids": selectedGhostAttributs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_ATTR_GHOST_ATTRIBUTE").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_ATTR_GHOST_ATTRIBUTE');
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
			"title"=>_l('Ghost attr.'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_attributes")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$sql = "DELETE FROM "._DB_PREFIX_."attribute_lang WHERE id_attribute IN (".psql($post_ids).")";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
