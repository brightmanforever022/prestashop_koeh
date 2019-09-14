<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "SELECT p.*, s.id_shop, s.name AS shop_name
			FROM "._DB_PREFIX_."category p
				INNER JOIN "._DB_PREFIX_."category_shop ps ON (p.id_category = ps.id_category)
					INNER JOIN "._DB_PREFIX_."shop s ON (s.id_shop = ps.id_shop)
			WHERE
				p.id_category NOT IN (SELECT pl.id_category FROM "._DB_PREFIX_."category_lang pl WHERE pl.id_shop = ps.id_shop)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangMSGet("category");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingCategoryLang = dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_MISSING_CAT_LANG_MS").attachToolbar();
			tbMissingCategoryLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingCategoryLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingCategoryLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingCategoryLang.setItemToolTip('delete','<?php echo _l('Remove categories from shops')?>');
			tbMissingCategoryLang.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingCategoryLang.setItemToolTip('add','<?php echo _l('Recover incomplete categories')?>');
			tbMissingCategoryLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingCategoryLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingCategoryLang();
					}
					if (id=='add')
					{
						addMissingCategoryLang()
					}
				});
		
			var gridMissingCategoryLang = dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_MISSING_CAT_LANG_MS").attachGrid();
			gridMissingCategoryLang.setImagePath("lib/js/imgs/");
			gridMissingCategoryLang.enableSmartRendering(true);
			gridMissingCategoryLang.enableMultiselect(true);
	
			gridMissingCategoryLang.setHeader("ID,<?php echo _l('Used?')?>,<?php echo _l('Shop')?>");
			gridMissingCategoryLang.setInitWidths("100,100,200");
			gridMissingCategoryLang.setColAlign("left,left,left");
			gridMissingCategoryLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $category) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."category_product` WHERE id_category = '".(int)$category["id_category"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $category["id_category"]."_".$category["id_shop"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $category["id_category"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $category["shop_name"])." (#".$category["id_shop"].")"; ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingCategoryLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_CAT_MISSING_CAT_LANG_MS").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingCategoryLang()
			{
				var selectedMissingCategoryLangs = gridMissingCategoryLang.getSelectedRowId();
				if(selectedMissingCategoryLangs==null || selectedMissingCategoryLangs=="")
					selectedMissingCategoryLangs = 0;
				if(selectedMissingCategoryLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_CAT_MISSING_CAT_LANG_MS&id_lang="+SC_ID_LANG, { "action": "delete_categories", "ids": selectedMissingCategoryLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_CAT_MISSING_CAT_LANG_MS").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_CAT_MISSING_CAT_LANG_MS');
						 doCheck(false);
					});
				}
			}

			function addMissingCategoryLang()
			{
				var selectedMissingCategoryLangs = gridMissingCategoryLang.getSelectedRowId();
				if(selectedMissingCategoryLangs==null || selectedMissingCategoryLangs=="")
					selectedMissingCategoryLangs = 0;
				if(selectedMissingCategoryLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_CAT_MISSING_CAT_LANG_MS&id_lang="+SC_ID_LANG, { "action": "add_categorys", "ids": selectedMissingCategoryLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_CAT_MISSING_CAT_LANG_MS").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_CAT_MISSING_CAT_LANG_MS');
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
			"title"=>_l('Category lang'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_categories")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			list($id_category, $id_shop) = explode("_",$id);
				
			$sql = "DELETE FROM "._DB_PREFIX_."category_shop WHERE id_category = ".(int)$id_category." AND id_shop = ".(int)$id_shop."";
			dbExecuteForeignKeyOff($sql);
				
			$sql = "DELETE FROM "._DB_PREFIX_."category_lang WHERE id_category = ".(int)$id_category." AND id_shop = ".(int)$id_shop."";
			dbExecuteForeignKeyOff($sql);
			
			$sql = "SELECT id_shop_default FROM "._DB_PREFIX_."category WHERE id_category = ".(int)$id_category."";
			$shop_default = Db::getInstance()->getValue($sql);
			if(!empty($shop_default) && $shop_default==$id_shop)
			{
				$sql = "SELECT id_shop FROM "._DB_PREFIX_."category_shop WHERE id_category = ".(int)$id_category." AND id_shop!=".(int)$id_shop." LIMIT 1";
				$shop_id = Db::getInstance()->executeS($sql);
				if(!empty($shop_id[0]["id_shop"]))
				{
					$shop_id = $shop_id[0]["id_shop"];
					$sql = "UPDATE "._DB_PREFIX_."category SET id_shop_default = ".(int)$shop_id." WHERE id_category = ".(int)$id_category."";
					dbExecuteForeignKeyOff($sql);
				}
			}
		}
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
			list($id_category, $id_shop) = explode("_",$id);
			
			/*$sql = "SELECT ps.id_shop
			FROM "._DB_PREFIX_."category_shop ps
			WHERE
				ps.id_category IN (SELECT pl.id_category FROM "._DB_PREFIX_."category_lang pl WHERE pl.id_shop = ps.id_shop AND pl.id_category = ".(int)$id_category.")
				AND ps.id_category = ".(int)$id_category." 
				AND ps.id_shop!=".(int)$id_shop." 
			LIMIT 1";
			$base_shop_id = Db::getInstance()->executeS($sql);
			if(!empty($base_shop_id[0]["id_shop"]))
			{
				$base_shop_id = $base_shop_id[0]["id_shop"];
				$category = new Category($id_category, null, $base_shop_id);
				$category->id_shop_list = array($id_shop);
				$category->save();
			}*/
			
			$langs_in_shop = Language::getLanguages(false, $id_shop);
				
			foreach ($langs_in_shop as $lang)
			{
				$sql = "SELECT id_shop
					FROM "._DB_PREFIX_."category_lang
					WHERE id_category = ".(int)$id_category."
						AND id_shop=".(int)$id_shop."
						AND id_lang=".(int)$lang["id_lang"]."
					LIMIT 1";
				$exist = Db::getInstance()->executeS($sql);
				if(empty($exist[0]["id_shop"])) // S'il n'y a pas de langue pour ce produit / shop
				{
					// On va regarder s'il existe la même langue pour une autre boutique
					$sql = "SELECT *
					FROM "._DB_PREFIX_."category_lang
					WHERE id_category = ".(int)$id_category."
						AND id_lang=".(int)$lang["id_lang"]."
					LIMIT 1";
					$in_other_lang = Db::getInstance()->executeS($sql);
					if(!empty($in_other_lang[0]["id_shop"]))
					{
						$in_other_lang = $in_other_lang[0];
						$sql = "INSERT INTO "._DB_PREFIX_."category_lang (id_category,id_shop,id_lang,name,description,link_rewrite,meta_title,meta_keywords,meta_description )
						VALUES ('".(int)$id_category."','".(int)$id_shop."','".(int)$lang["id_lang"]."','".pSQL($in_other_lang["name"])."','".pSQL($in_other_lang["description"])."','".pSQL($in_other_lang["link_rewrite"])."','".pSQL($in_other_lang["meta_title"])."','".pSQL($in_other_lang["meta_keywords"])."','".pSQL($in_other_lang["meta_description"])."')";
						dbExecuteForeignKeyOff($sql);
					}
					else
					{
						$created = false;
						$default_lang = Configuration::get("PS_LANG_DEFAULT");
						if(!empty($default_lang))
						{
							// On va regarder s'il existe la langue par défaut pour la boutique
							$sql = "SELECT *
							FROM "._DB_PREFIX_."category_lang
							WHERE id_category = ".(int)$id_category."
								AND id_shop=".(int)$id_shop."
								AND id_lang=".(int)$default_lang."
							LIMIT 1";
							$in_default_lang = Db::getInstance()->executeS($sql);
							if(!empty($in_default_lang[0]["id_shop"]))
							{
								$in_default_lang = $in_default_lang[0];
								$sql = "INSERT INTO "._DB_PREFIX_."category_lang (id_category,id_shop,id_lang,name,description,link_rewrite,meta_title,meta_keywords,meta_description )
								VALUES ('".(int)$id_category."','".(int)$id_shop."','".(int)$lang["id_lang"]."','".pSQL($in_default_lang["name"])."','".pSQL($in_default_lang["description"])."','".pSQL($in_default_lang["link_rewrite"])."','".pSQL($in_default_lang["meta_title"])."','".pSQL($in_default_lang["meta_keywords"])."','".pSQL($in_default_lang["meta_description"])."')";
								dbExecuteForeignKeyOff($sql);
								$created = true;
							}
							else
							{
								// On va regarder s'il existe la langue par défaut pour une autre boutique
								$sql = "SELECT *
								FROM "._DB_PREFIX_."category_lang
								WHERE id_category = ".(int)$id_category."
									AND id_lang=".(int)$default_lang."
								LIMIT 1";
								$in_default_lang = Db::getInstance()->executeS($sql);
								if(!empty($in_default_lang[0]["id_shop"]))
								{
									$in_default_lang = $in_default_lang[0];
									$sql = "INSERT INTO "._DB_PREFIX_."category_lang (id_category,id_shop,id_lang,name,description,link_rewrite,meta_title,meta_keywords,meta_description )
									VALUES ('".(int)$id_category."','".(int)$id_shop."','".(int)$lang["id_lang"]."','".pSQL($in_default_lang["name"])."','".pSQL($in_default_lang["description"])."','".pSQL($in_default_lang["link_rewrite"])."','".pSQL($in_default_lang["meta_title"])."','".pSQL($in_default_lang["meta_keywords"])."','".pSQL($in_default_lang["meta_description"])."')";
									dbExecuteForeignKeyOff($sql);
									$created = true;
								}
							}
						}
			
						// On va créé une ligne basique
						if(!$created)
						{
							$sql = "INSERT INTO "._DB_PREFIX_."category_lang (id_category,id_shop,id_lang,name,description,link_rewrite,meta_title,meta_keywords,meta_description )
									VALUES ('".(int)$id_category."','".(int)$id_shop."','".(int)$lang["id_lang"]."','Category ".$id_category."','','category_".$id_category."','','','')";
							dbExecuteForeignKeyOff($sql);
						}
					}
				}
			}
		}
	}
}
