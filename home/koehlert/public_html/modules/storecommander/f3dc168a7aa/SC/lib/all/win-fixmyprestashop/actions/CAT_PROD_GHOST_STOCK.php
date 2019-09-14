<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT pl.id_product 
        FROM "._DB_PREFIX_."stock pl 
        WHERE pl.id_product NOT IN (SELECT p.id_product FROM "._DB_PREFIX_."product p) 
            AND pl.id_product_attribute = 0
        LIMIT 1500";
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
	
			var tbGhostStock = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_GHOST_STOCK").attachToolbar();
			tbGhostStock.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostStock.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostStock.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostStock.setItemToolTip('delete','<?php echo _l('Delete incomplete stock')?>');
			tbGhostStock.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostStock.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostStock();
					}
				});
		
			var gridGhostStock = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_GHOST_STOCK").attachGrid();
			gridGhostStock.setImagePath("lib/js/imgs/");
			gridGhostStock.enableSmartRendering(true);
			gridGhostStock.enableMultiselect(true);
	
			gridGhostStock.setHeader("<?php echo _l('Deleted products ID')?>");
			gridGhostStock.setInitWidths("*");
			gridGhostStock.setColAlign("left");
			gridGhostStock.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $product) { ?>
			xml = xml+'   <row id="<?php echo $product["id_product"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $product["id_product"] ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostStock.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_GHOST_STOCK").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostStock()
			{
				var selectedGhostStocks = gridGhostStock.getSelectedRowId();
				if(selectedGhostStocks==null || selectedGhostStocks=="")
					selectedGhostStocks = 0;
				if(selectedGhostStocks!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_GHOST_STOCK&id_lang="+SC_ID_LANG, { "action": "delete_stocks", "ids": selectedGhostStocks}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_GHOST_STOCK").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_GHOST_STOCK');
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
			"title"=>_l('Ghost stock'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_stocks")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$sql = "DELETE FROM "._DB_PREFIX_."stock WHERE id_product IN (".psql($post_ids).") AND id_product_attribute = 0";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
