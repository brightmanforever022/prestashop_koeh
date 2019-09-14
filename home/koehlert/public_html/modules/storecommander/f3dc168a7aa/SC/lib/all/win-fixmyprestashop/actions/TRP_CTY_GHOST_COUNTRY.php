<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT cl.id_country, cl.name FROM "._DB_PREFIX_."country_lang cl WHERE cl.id_country NOT IN (SELECT c.id_country FROM "._DB_PREFIX_."country c) ORDER BY cl.id_lang ASC LIMIT 1500";
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
	
			var tbGhostCountry = dhxlSCExtCheck.tabbar.cells("table_TRP_CTY_GHOST_COUNTRY").attachToolbar();
			tbGhostCountry.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostCountry.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostCountry.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostCountry.setItemToolTip('delete','<?php echo _l('Delete incomplete countries')?>');
			tbGhostCountry.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostCountry.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostCountry();
					}
				});
		
			var gridGhostCountry = dhxlSCExtCheck.tabbar.cells("table_TRP_CTY_GHOST_COUNTRY").attachGrid();
			gridGhostCountry.setImagePath("lib/js/imgs/");
			gridGhostCountry.enableSmartRendering(true);
			gridGhostCountry.enableMultiselect(true);
	
			gridGhostCountry.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Used ?')?>");
			gridGhostCountry.setInitWidths("100, 110,50");
			gridGhostCountry.setColAlign("left,left,left");
			gridGhostCountry.init();

			var xml = '<rows>';
			<?php foreach ($res as $country) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."address` WHERE id_country = '".$country["id_country"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $country["id_country"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $country["id_country"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $country["name"]) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostCountry.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_TRP_CTY_GHOST_COUNTRY").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostCountry()
			{
				var selectedGhostCountries = gridGhostCountry.getSelectedRowId();
				if(selectedGhostCountries==null || selectedGhostCountries=="")
					selectedGhostCountries = 0;
				if(selectedGhostCountries!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=TRP_CTY_GHOST_COUNTRY&id_lang="+SC_ID_LANG, { "action": "delete_countries", "ids": selectedGhostCountries}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_TRP_CTY_GHOST_COUNTRY").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('TRP_CTY_GHOST_COUNTRY');
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
			"title"=>_l('Ghost country'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_countries")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$sql = "DELETE FROM "._DB_PREFIX_."country_lang WHERE id_country IN (".psql($post_ids).")";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
