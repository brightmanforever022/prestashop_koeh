<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "select p.* from "._DB_PREFIX_."supplier p where p.id_supplier not in (select pl.id_supplier from "._DB_PREFIX_."supplier_lang pl)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangGet("supplier");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingSupplierLang = dhxlSCExtCheck.tabbar.cells("table_CAT_SUP_MISSING_SUPPLIER_LANG").attachToolbar();
			tbMissingSupplierLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingSupplierLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingSupplierLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingSupplierLang.setItemToolTip('delete','<?php echo _l('Delete incomplete suppliers')?>');
			tbMissingSupplierLang.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingSupplierLang.setItemToolTip('add','<?php echo _l('Recover incomplete suppliers')?>');
			tbMissingSupplierLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingSupplierLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingSupplierLang();
					}
					if (id=='add')
					{
						addMissingSupplierLang()
					}
				});
		
			var gridMissingSupplierLang = dhxlSCExtCheck.tabbar.cells("table_CAT_SUP_MISSING_SUPPLIER_LANG").attachGrid();
			gridMissingSupplierLang.setImagePath("lib/js/imgs/");
			gridMissingSupplierLang.enableSmartRendering(true);
			gridMissingSupplierLang.enableMultiselect(true);
	
			gridMissingSupplierLang.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Used?')?>");
			gridMissingSupplierLang.setInitWidths("100,110,50");
			gridMissingSupplierLang.setColAlign("left,left,left");
			gridMissingSupplierLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $supplier) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."product` WHERE id_supplier = '".(int)$supplier["id_supplier"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $supplier["id_supplier"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $supplier["id_supplier"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $supplier["name"]) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingSupplierLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_SUP_MISSING_SUPPLIER_LANG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingSupplierLang()
			{
				var selectedMissingSupplierLangs = gridMissingSupplierLang.getSelectedRowId();
				if(selectedMissingSupplierLangs==null || selectedMissingSupplierLangs=="")
					selectedMissingSupplierLangs = 0;
				if(selectedMissingSupplierLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_SUP_MISSING_SUPPLIER_LANG&id_lang="+SC_ID_LANG, { "action": "delete_suppliers", "ids": selectedMissingSupplierLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_SUP_MISSING_SUPPLIER_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_SUP_MISSING_SUPPLIER_LANG');
						 doCheck(false);
					});
				}
			}

			function addMissingSupplierLang()
			{
				var selectedMissingSupplierLangs = gridMissingSupplierLang.getSelectedRowId();
				if(selectedMissingSupplierLangs==null || selectedMissingSupplierLangs=="")
					selectedMissingSupplierLangs = 0;
				if(selectedMissingSupplierLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_SUP_MISSING_SUPPLIER_LANG&id_lang="+SC_ID_LANG, { "action": "add_suppliers", "ids": selectedMissingSupplierLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_SUP_MISSING_SUPPLIER_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_SUP_MISSING_SUPPLIER_LANG');
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
			"title"=>_l('Supplier lang'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_suppliers")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$supplier = new Supplier($id);
			$supplier->delete();
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_suppliers")
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
					WHERE l.id_lang not in (SELECT pl.id_lang FROM "._DB_PREFIX_."supplier_lang pl WHERE pl.id_supplier='".(int)$id."')";
			$languages=Db::getInstance()->ExecuteS($sql);
			
			foreach($languages as $language)
			{
				$sql = "INSERT INTO "._DB_PREFIX_."supplier_lang (id_supplier, id_lang)
						VALUES (".(int)$id.",".(int)$language["id_lang"].")";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
