<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "select pl.id_supplier from "._DB_PREFIX_."supplier_lang pl where pl.id_supplier not in (select p.id_supplier from "._DB_PREFIX_."supplier p) ORDER BY id_lang ASC LIMIT 1500";
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
	
			var tbGhostSupplier = dhxlSCExtCheck.tabbar.cells("table_CAT_SUP_GHOST_SUPPLIER").attachToolbar();
			tbGhostSupplier.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostSupplier.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostSupplier.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostSupplier.setItemToolTip('delete','<?php echo _l('Delete incomplete suppliers')?>');
			tbGhostSupplier.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbGhostSupplier.setItemToolTip('add','<?php echo _l('Recover incomplete suppliers')?>');
			tbGhostSupplier.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostSupplier.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostSupplier();
					}
					if (id=='add')
					{
						addGhostSupplier()
					}
				});
		
			var gridGhostSupplier = dhxlSCExtCheck.tabbar.cells("table_CAT_SUP_GHOST_SUPPLIER").attachGrid();
			gridGhostSupplier.setImagePath("lib/js/imgs/");
			gridGhostSupplier.enableSmartRendering(true);
			gridGhostSupplier.enableMultiselect(true);
	
			gridGhostSupplier.setHeader("ID,<?php echo _l('Used?')?>");
			gridGhostSupplier.setInitWidths("100,50");
			gridGhostSupplier.setColAlign("left,left");
			gridGhostSupplier.init();

			var xml = '<rows>';
			<?php foreach ($res as $supplier) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."product` WHERE id_supplier = '".(int)$supplier["id_supplier"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $supplier["id_supplier"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $supplier["id_supplier"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostSupplier.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_SUP_GHOST_SUPPLIER").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostSupplier()
			{
				var selectedGhostSuppliers = gridGhostSupplier.getSelectedRowId();
				if(selectedGhostSuppliers==null || selectedGhostSuppliers=="")
					selectedGhostSuppliers = 0;
				if(selectedGhostSuppliers!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_SUP_GHOST_SUPPLIER&id_lang="+SC_ID_LANG, { "action": "delete_suppliers", "ids": selectedGhostSuppliers}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_SUP_GHOST_SUPPLIER").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_SUP_GHOST_SUPPLIER');
						 doCheck(false);
					});
				}
			}

			function addGhostSupplier()
			{
				var selectedGhostSuppliers = gridGhostSupplier.getSelectedRowId();
				if(selectedGhostSuppliers==null || selectedGhostSuppliers=="")
					selectedGhostSuppliers = 0;
				if(selectedGhostSuppliers!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_SUP_GHOST_SUPPLIER&id_lang="+SC_ID_LANG, { "action": "add_suppliers", "ids": selectedGhostSuppliers}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_SUP_GHOST_SUPPLIER").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_SUP_GHOST_SUPPLIER');
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
			"title"=>_l('Ghost supplier'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_suppliers")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$sql = "DELETE FROM "._DB_PREFIX_."supplier_lang WHERE id_supplier IN (".psql($post_ids).")";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
elseif(!empty($post_action) && $post_action=="add_suppliers")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$sql = "INSERT INTO "._DB_PREFIX_."supplier (id_supplier, name, active, date_add, date_upd)
					VALUES (".(int)$id.",'Supplier', 0, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";
			$res=dbExecuteForeignKeyOff($sql);
		}
	}
}
