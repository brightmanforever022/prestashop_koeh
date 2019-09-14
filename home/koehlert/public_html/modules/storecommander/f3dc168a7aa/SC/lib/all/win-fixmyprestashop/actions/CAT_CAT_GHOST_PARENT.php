<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT c.id_category FROM `"._DB_PREFIX_."category` c WHERE c.id_parent!=0 AND c.id_parent NOT IN (SELECT cc.id_category FROM `"._DB_PREFIX_."category` cc) LIMIT 1500";
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
	
			var tbChangeCategory = dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_PARENT").attachToolbar();
			tbChangeCategory.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbChangeCategory.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbChangeCategory.addButton("change", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbChangeCategory.setItemToolTip('change','<?php echo _l('Change ID parent',1)?>');
			tbChangeCategory.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridChangeCategory.selectAll();
					}
					if (id=='change')
					{
						addChangeCategory()
					}
				});
		
			var gridChangeCategory = dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_PARENT").attachGrid();
			gridChangeCategory.setImagePath("lib/js/imgs/");
			gridChangeCategory.enableSmartRendering(true);
			gridChangeCategory.enableMultiselect(true);
	
			gridChangeCategory.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Used?')?>");
			gridChangeCategory.setInitWidths("100, 110,50");
			gridChangeCategory.setColAlign("left,left,left");
			gridChangeCategory.init();

			var xml = '<rows>';
			<?php foreach ($res as $category) {
				$cat = new Category((int)$category["id_category"], SCI::getConfigurationValue("PS_LANG_DEFAULT"));
				$sql = "SELECT * FROM `"._DB_PREFIX_."category_product` WHERE id_category = '".(int)$category["id_category"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $category["id_category"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $category["id_category"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $cat->name); ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridChangeCategory.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_PARENT").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function addChangeCategory()
			{
				var selectedChangeCategorys = gridChangeCategory.getSelectedRowId();
				if(selectedChangeCategorys==null || selectedChangeCategorys=="")
					selectedChangeCategorys = 0;
				if(selectedChangeCategorys!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_CAT_GHOST_PARENT&id_lang="+SC_ID_LANG, { "action": "change_categories", "ids": selectedChangeCategorys}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_CAT_GHOST_PARENT").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_CAT_GHOST_PARENT');
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
			"title"=>_l('Parent category'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="change_categories")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$category_id = 1;
			if(version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			{
				$sql = "SELECT id_shop_default
				FROM `"._DB_PREFIX_."category`
				WHERE id_category = '".(int)$id."'";
				$shop_id=Db::getInstance()->getValue($sql);
				if(!empty($shop_id))
				{
					$sql = "SELECT id_category
					FROM `"._DB_PREFIX_."shop`
					WHERE id_shop = '".(int)$shop_id."'";
					$category_id=Db::getInstance()->getValue($sql);
				}
			}
			if(empty($category_id))
				$category_id = 1;
			
			$sql = "UPDATE `"._DB_PREFIX_."category` SET id_parent = '".(int)$category_id."' WHERE id_category = '".(int)$id."'";
			dbExecuteForeignKeyOff($sql);
		}
	}
}
