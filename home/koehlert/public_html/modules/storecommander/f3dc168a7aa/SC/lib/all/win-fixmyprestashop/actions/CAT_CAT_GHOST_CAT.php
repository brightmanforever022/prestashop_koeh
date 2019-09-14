<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "select pl.id_category, pl.name, c.id_parent
			from "._DB_PREFIX_."category_lang pl 
				INNER JOIN "._DB_PREFIX_."category c ON (pl.id_category = c.id_category)
			where pl.id_category not in (select p.id_category from "._DB_PREFIX_."category p) 
			ORDER BY id_lang ASC";
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
	
			var tbGhostCategory = dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_CAT").attachToolbar();
			tbGhostCategory.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbGhostCategory.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbGhostCategory.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbGhostCategory.setItemToolTip('delete','<?php echo _l('Delete incomplete categories')?>');
			tbGhostCategory.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbGhostCategory.setItemToolTip('add','<?php echo _l('Recover incomplete categories')?>');
			tbGhostCategory.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridGhostCategory.selectAll();
					}
					if (id=='delete')
					{
						deleteGhostCategory();
					}
					if (id=='add')
					{
						addGhostCategory()
					}
				});
		
			var gridGhostCategory = dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_CAT").attachGrid();
			gridGhostCategory.setImagePath("lib/js/imgs/");
			gridGhostCategory.enableSmartRendering(true);
			gridGhostCategory.enableMultiselect(true);
	
			gridGhostCategory.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Used?')?>");
			gridGhostCategory.setInitWidths("100, 110,50");
			gridGhostCategory.setColAlign("left,left,left");
			gridGhostCategory.init();

			var xml = '<rows>';
			<?php foreach ($res as $category) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."category_product` WHERE id_category = '".(int)$category["id_category"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
				
				$is_root = false;
				if($category["id_parent"]==0)
					$is_root = true;
			?>
			xml = xml+'   <row id="<?php echo $category["id_category"] ?>">';
			xml = xml+'  	<userdata name="is_root"><?php echo intval($is_root) ?></userdata>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'","\'",$category["id_category"]) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'","\'",$category["name"]) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridGhostCategory.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_GHOST_CAT").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteGhostCategory()
			{
				var selectedGhostCategorys = gridGhostCategory.getSelectedRowId();
				if(selectedGhostCategorys==null || selectedGhostCategorys=="")
					selectedGhostCategorys = 0;
				if(selectedGhostCategorys!="0")
				{
					var final_ids = "";
					var temp_ids = selectedGhostCategorys.split(",");
					var has_root = false;
					
					$.each(temp_ids, function(num, id) {
						var is_root = gridGhostCategory.getUserData(id,"is_root");
						if(is_root!=1)
						{
							if(final_ids!="")
								final_ids = final_ids + ",";
							final_ids = final_ids + id;
						}
						else
							has_root = true;
						
					});
					
					if(has_root)
						dhtmlx.message({text:'<?php echo _l('One of selected cagetories is the Root category, and can not be deleted',1)?>',type:'error',expire:5000});
					
					if(final_ids!="")
					{
						$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_CAT_GHOST_CAT&id_lang="+SC_ID_LANG, { "action": "delete_categories", "ids": selectedGhostCategorys}, function(data){
							dhxlSCExtCheck.tabbar.tabs("table_CAT_CAT_GHOST_CAT").close();
	
							 dhxlSCExtCheck.gridChecks.selectRowById('CAT_CAT_GHOST_CAT');
							 doCheck(false);
						});
					}
				}
			}

			function addGhostCategory()
			{
				var selectedGhostCategorys = gridGhostCategory.getSelectedRowId();
				if(selectedGhostCategorys==null || selectedGhostCategorys=="")
					selectedGhostCategorys = 0;
				if(selectedGhostCategorys!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_CAT_GHOST_CAT&id_lang="+SC_ID_LANG, { "action": "add_categorys", "ids": selectedGhostCategorys}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_CAT_GHOST_CAT").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_CAT_GHOST_CAT');
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
			"title"=>_l('Ghost category'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_categories")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$sql = "DELETE FROM "._DB_PREFIX_."category_lang WHERE id_category IN (".psql($post_ids).")";
		$res=dbExecuteForeignKeyOff($sql);
	}
}
elseif(!empty($post_action) && $post_action=="add_categorys")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$sql = "INSERT INTO "._DB_PREFIX_."category (id_category, active, date_add, date_upd, id_parent)
					VALUES (".(int)$id.", 0, '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', 1)";
			$res=dbExecuteForeignKeyOff($sql);
			
			$cat = new Category($id);
			$cat->active = 0;
			$cat->save();
		}
	}
}
