<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$products = array();
	if(version_compare(_PS_VERSION_, '1.5.0.0', '>='))
	{
		$sql = "SELECT i.id_product, pl.name, s.name as name_shop, ims.id_shop,
					(SELECT COUNT(*) 
						FROM "._DB_PREFIX_."image_shop ims2 
							INNER JOIN "._DB_PREFIX_."image i2 ON (i2.id_image = ims2.id_image)
						WHERE 
							i2.id_product = i.id_product 
							AND ims.id_shop = ims2.id_shop
							AND ims2.cover = 1
					) AS nb_cover, 
					(SELECT COUNT(*) 
						FROM "._DB_PREFIX_."image_shop ims2 
							INNER JOIN "._DB_PREFIX_."image i2 ON (i2.id_image = ims2.id_image)
						WHERE 
							i2.id_product = i.id_product 
							AND ims.id_shop = ims2.id_shop
					) AS nb
				FROM "._DB_PREFIX_."image_shop ims
					INNER JOIN "._DB_PREFIX_."shop s ON (s.id_shop = ims.id_shop)
					INNER JOIN "._DB_PREFIX_."image i ON (i.id_image = ims.id_image)
						INNER JOIN "._DB_PREFIX_."product_lang pl ON (pl.id_product = i.id_product AND pl.id_lang = '".(int)SCI::getConfigurationValue("PS_LANG_DEFAULT")."')
				GROUP BY i.id_product, ims.id_shop LIMIT 1500";
		$res=Db::getInstance()->ExecuteS($sql);
		if(!empty($res) && count($res)>0)
		{
			foreach ($res as $p)
			{
				if(empty($p["nb_cover"]) && !empty($p["nb"]))
					$products[] = $p;
			}
		}
	}
	else
	{
		$sql = "SELECT i.id_product, pl.name, (SELECT COUNT(*) FROM "._DB_PREFIX_."image i2 WHERE i2.id_product = i.id_product AND cover = 1) AS nb_cover, (SELECT COUNT(*) FROM "._DB_PREFIX_."image i2 WHERE i2.id_product = i.id_product) AS nb
			FROM "._DB_PREFIX_."image i
				INNER JOIN "._DB_PREFIX_."product_lang pl ON (pl.id_product = i.id_product AND pl.id_lang = '".(int)SCI::getConfigurationValue("PS_LANG_DEFAULT")."')
			GROUP BY i.id_product LIMIT 1500";
		$res=Db::getInstance()->ExecuteS($sql);
		if(!empty($res) && count($res)>0)
		{
			foreach ($res as $p)
			{
				if(empty($p["nb_cover"]) && !empty($p["nb"]))
					$products[] = $p;
			}
		}
	}
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($products) && count($products)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingCoverImage = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_MISSING_COVER_IMAGE").attachToolbar();
			tbMissingCoverImage.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingCoverImage.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingCoverImage.addButton("put_cover", 0, "", "lib/img/picture_add.png", "lib/img/picture_add.png");
			tbMissingCoverImage.setItemToolTip('put_cover','<?php echo _l('Put first image on cover')?>');
			tbMissingCoverImage.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingCoverImage.selectAll();
					}
					if (id=='put_cover')
					{
						<?php if(version_compare(_PS_VERSION_, '1.5.0.0', '>=')) { ?>
							addMissingCoverImageMS()
						<?php } else { ?>
							addMissingCoverImage()
						<?php } ?>
					}
				});
		
			var gridMissingCoverImage = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_MISSING_COVER_IMAGE").attachGrid();
			gridMissingCoverImage.setImagePath("lib/js/imgs/");
			gridMissingCoverImage.enableSmartRendering(true);
			gridMissingCoverImage.enableMultiselect(true);
	
			gridMissingCoverImage.setHeader("ID,<?php echo _l('Name')?><?php if(version_compare(_PS_VERSION_, '1.5.0.0', '>=')) echo ","._l('Shop') ?>");
			gridMissingCoverImage.setInitWidths("100,<?php if(version_compare(_PS_VERSION_, '1.5.0.0', '>=')) echo "100," ?>*");
			gridMissingCoverImage.setColAlign("left,left<?php if(version_compare(_PS_VERSION_, '1.5.0.0', '>=')) echo ",left" ?>");
			gridMissingCoverImage.init();
	
			var xml = '<rows>';
			<?php foreach ($products as $product) { ?>
			<?php if(version_compare(_PS_VERSION_, '1.5.0.0', '>=')) { ?>
			xml = xml+'   <row id="<?php echo $product["id_product"]."_".$product["id_shop"] ?>">';
			<?php } else { ?>
			xml = xml+'   <row id="<?php echo $product["id_product"] ?>">';
			<?php } ?>
			xml = xml+'  	<cell><![CDATA[<?php echo $product["id_product"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", str_replace("\'","'",$product["name"])) ?>]]></cell>';
			<?php if(version_compare(_PS_VERSION_, '1.5.0.0', '>=')) { ?>
			xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", str_replace("\'","'",$product["name_shop"])) ?>]]></cell>';
			<?php } ?>
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingCoverImage.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_MISSING_COVER_IMAGE").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function addMissingCoverImage()
			{
				var selectedMissingCoverImages = gridMissingCoverImage.getSelectedRowId();
				if(selectedMissingCoverImages==null || selectedMissingCoverImages=="")
					selectedMissingCoverImages = 0;
				if(selectedMissingCoverImages!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_MISSING_COVER_IMAGE&id_lang="+SC_ID_LANG, { "action": "image_cover", "ids": selectedMissingCoverImages}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_MISSING_COVER_IMAGE").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_MISSING_COVER_IMAGE');
						 doCheck(false);
					});
				}
			}

			function addMissingCoverImageMS()
			{
				var selectedMissingCoverImages = gridMissingCoverImage.getSelectedRowId();
				if(selectedMissingCoverImages==null || selectedMissingCoverImages=="")
					selectedMissingCoverImages = 0;
				if(selectedMissingCoverImages!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_MISSING_COVER_IMAGE&id_lang="+SC_ID_LANG, { "action": "image_cover_ms", "ids": selectedMissingCoverImages}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_MISSING_COVER_IMAGE").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_MISSING_COVER_IMAGE');
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
			"title"=>_l('Image cover'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="image_cover")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$sql = "SELECT id_image
					FROM "._DB_PREFIX_."image
					WHERE id_product = '".(int)$id."'
					ORDER BY position ASC
					LIMIT 1";
			$image_first=Db::getInstance()->executeS($sql);
			if(!empty($image_first[0]["id_image"]))
			{
				$sql = "UPDATE "._DB_PREFIX_."image SET cover = '1' WHERE id_image = '".(int)$image_first[0]["id_image"]."'";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
elseif(!empty($post_action) && $post_action=="image_cover_ms")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			list($id_product,$id_shop) = explode("_",$id);
			
			$sql = "SELECT ims.id_image, ims.id_shop
					FROM "._DB_PREFIX_."image_shop ims
						INNER JOIN "._DB_PREFIX_."image i ON (i.id_image = ims.id_image)
					WHERE i.id_product = '".(int)$id_product."'
						AND ims.id_shop = '".(int)$id_shop."'
					ORDER BY i.position ASC
					LIMIT 1";
			$image_first=Db::getInstance()->executeS($sql);
			if(!empty($image_first[0]["id_image"]) && !empty($image_first[0]["id_shop"]))
			{
				$sql = "UPDATE "._DB_PREFIX_."image_shop SET cover = '1' WHERE id_image = '".(int)$image_first[0]["id_image"]."' AND id_shop = '".(int)$image_first[0]["id_shop"]."'";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
