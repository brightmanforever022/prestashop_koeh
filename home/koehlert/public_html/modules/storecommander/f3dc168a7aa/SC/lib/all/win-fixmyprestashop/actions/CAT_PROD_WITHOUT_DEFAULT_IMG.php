<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$res = array();
	$shops = Shop::getShops(false);
	foreach($shops as $id_shop=>$shop)
	{
		$sql = "
		SELECT ip.id_product,isp.id_shop
		FROM "._DB_PREFIX_."image ip
			INNER JOIN "._DB_PREFIX_."image_shop isp ON (ip.id_image=isp.id_image)
		WHERE 
			isp.id_shop = '".(int)$id_shop."'
			AND ip.id_product NOT IN (
				SELECT i.id_product
				FROM "._DB_PREFIX_."image i
					INNER JOIN "._DB_PREFIX_."image_shop isp2 ON (i.id_image=isp2.id_image)
				WHERE isp2.cover='1'
					AND isp2.id_shop = '".(int)$id_shop."'
			)
		GROUP BY ip.id_product
		 LIMIT 1500";
		$res2=Db::getInstance()->ExecuteS($sql);
		if(!empty($res2) && count($res2)>0)
		{
			foreach ($res2 as $product) 
			{
				$product_inst = new Product((int)$product["id_product"], false, (int)$id_lang, (int)$id_shop);
				
				$res[] = array(
					"id_product"=>$product["id_product"],
					"id_shop"=>$product["id_shop"],
					"shop_name"=>$shop["name"],
					"name"=>$product_inst->name
				);
			}
		}
	}
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbNoDefaultImg = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_WITHOUT_DEFAULT_IMG").attachToolbar();
			tbNoDefaultImg.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbNoDefaultImg.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbNoDefaultImg.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbNoDefaultImg.setItemToolTip('add','<?php echo _l('Recover incomplete products')?>');
			tbNoDefaultImg.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridNoDefaultImg.selectAll();
					}
					if (id=='add')
					{
						addNoDefaultImg()
					}
				});
		
			var gridNoDefaultImg = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_WITHOUT_DEFAULT_IMG").attachGrid();
			gridNoDefaultImg.setImagePath("lib/js/imgs/");
			gridNoDefaultImg.enableSmartRendering(true);
			gridNoDefaultImg.enableMultiselect(true);
			gridNoDefaultImg.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Shop')?>");
			gridNoDefaultImg.setInitWidths("100,100,200");
			gridNoDefaultImg.setColAlign("left,left,left");
			gridNoDefaultImg.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $product) { ?>
			xml = xml+'   <row id="<?php echo $product["id_product"]."_".$product["id_shop"]; ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $product["id_product"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo  str_replace("'","\'",($product["name"])) ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo  str_replace("'","\'",($product["shop_name"]))." (#".$product["id_shop"].")"; ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridNoDefaultImg.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_WITHOUT_DEFAULT_IMG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function addNoDefaultImg()
			{
				var selectedNoDefaultImg = gridNoDefaultImg.getSelectedRowId();
				if(selectedNoDefaultImg==null || selectedNoDefaultImg=="")
					selectedNoDefaultImg = 0;
				if(selectedNoDefaultImg!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_WITHOUT_DEFAULT_IMG&id_lang="+SC_ID_LANG, { "action": "add_products", "ids": selectedNoDefaultImg}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_WITHOUT_DEFAULT_IMG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_WITHOUT_DEFAULT_IMG');
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
			"title"=>_l('No default combi'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="add_products")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			list($id_product, $id_shop) = explode("_",$id);
		
			$ida=Db::getInstance()->ExecuteS('SELECT pas2.id_product_attribute 
			FROM '._DB_PREFIX_.'product_attribute_shop pas2 
			WHERE pas2.id_product_attribute IN (
				SELECT pa.id_product_attribute 
				FROM '._DB_PREFIX_.'product_attribute pa 
				WHERE pa.id_product = '.(int)$id_product.'
			) 
				AND pas2.id_shop = "'.(int)$id_shop.'"
			ORDER BY pas2.price ASC
			LIMIT 1');
			if(!empty($ida[0]["id_product_attribute"]))			
				dbExecuteForeignKeyOff('UPDATE '._DB_PREFIX_.'product_attribute_shop SET default_on=1 WHERE id_product_attribute = '.(int)$ida[0]["id_product_attribute"].' AND id_shop = "'.(int)$id_shop.'"');
		}
	}
}
