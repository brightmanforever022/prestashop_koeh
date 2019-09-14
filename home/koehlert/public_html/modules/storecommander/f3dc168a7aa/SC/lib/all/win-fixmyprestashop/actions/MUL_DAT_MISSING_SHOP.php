<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*
	 * TABLES
	 */
    include (dirname(__FILE__).'/../all_win-fixmyprestashop_controls.php');
	
	/*
	 * REQUETES
	 */
	$content = "";
	$content_js = "";
	$results = "OK";
	$elements = array();
	
	foreach($shop_tables as $shop_table)
	{
		$good_version = true;
		if(!empty($shop_table['vs_min']) && version_compare(_PS_VERSION_, $shop_table['vs_min'], '<'))
			$good_version = false;
		if(!empty($shop_table['vs_max']) && version_compare(_PS_VERSION_, $shop_table['vs_max'], '>'))
			$good_version = false;
		if($good_version)
		{
			$sql = "SELECT p.* FROM "._DB_PREFIX_.psql($shop_table["table"])." p WHERE p.id_".psql($shop_table["table"])." NOT IN (SELECT pl.id_".psql($shop_table["table"])." FROM "._DB_PREFIX_."".psql($shop_table["table"])."_shop pl) LIMIT 1500";

			$res=Db::getInstance()->ExecuteS($sql);
			if(!empty($res) && count($res)>0)
			{
				foreach($res as $row)
				{
					$elements[] = array(
						"id"=> $row["id_".$shop_table["table"]],
						"table"=> $shop_table["table"]
					);
				}
			}
		}
	}
	
	if(!empty($elements) && count($elements)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingShop = dhxlSCExtCheck.tabbar.cells("table_MUL_DAT_MISSING_SHOP").attachToolbar();
			tbMissingShop.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingShop.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingShop.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingShop.setItemToolTip('add','<?php echo _l('Recover incomplete elements')?>');
			tbMissingShop.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingShop.selectAll();
					}
					if (id=='add')
					{
						addMissingShop()
					}
				});
		
			var gridMissingShop = dhxlSCExtCheck.tabbar.cells("table_MUL_DAT_MISSING_SHOP").attachGrid();
			gridMissingShop.setImagePath("lib/js/imgs/");
			gridMissingShop.enableSmartRendering(true);
			gridMissingShop.enableMultiselect(true);
	
			gridMissingShop.setHeader("<?php echo _l('Table')?>,ID");
			gridMissingShop.setInitWidths("100,50");
			gridMissingShop.setColAlign("left,left");
			gridMissingShop.init();

			var xml = '<rows>';
			<?php foreach ($elements as $element) { ?>
			xml = xml+'   <row id="<?php echo $element["table"]."-".$element["id"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $element["table"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo $element["id"] ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingShop.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_MUL_DAT_MISSING_SHOP").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($elements) ; ?>', height: 25 });

			function addMissingShop()
			{
				var selectedMissingShops = gridMissingShop.getSelectedRowId();
				if(selectedMissingShops==null || selectedMissingShops=="")
					selectedMissingShops = 0;
				if(selectedMissingShops!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=MUL_DAT_MISSING_SHOP&id_lang="+SC_ID_LANG, { "action": "add_shops", "ids": selectedMissingShops}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_MUL_DAT_MISSING_SHOP").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('MUL_DAT_MISSING_SHOP');
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
			"title"=>_l('Missing shop'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="add_shops")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$shop_id = Configuration::get("PS_SHOP_DEFAULT");
		$ids = explode(",",$post_ids);
		foreach($ids as $table_id)
		{
			list($table, $id) = explode("-", $table_id);
			
			$sql = "INSERT INTO "._DB_PREFIX_.$table."_shop (id_shop, id_".$table.")
					VALUES (".$shop_id.",".$id.")";
			$res=dbExecuteForeignKeyOff($sql);
		}
	}
}
