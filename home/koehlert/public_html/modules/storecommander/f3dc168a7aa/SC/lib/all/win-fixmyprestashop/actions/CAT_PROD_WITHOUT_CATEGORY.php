<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	$sql = "SELECT p.id_product, pl.name, p.id_category_default, cl.name AS category_name
        FROM "._DB_PREFIX_."product p
         LEFT JOIN "._DB_PREFIX_."product_lang pl 
                    ON (pl.id_product = p.id_product AND pl.id_lang = ".(int)$id_lang.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND pl.id_shop = p.id_shop_default': '').")                    
         LEFT JOIN "._DB_PREFIX_."category_lang cl 
                    ON (cl.id_category = p.id_category_default AND cl.id_lang = ".(int)$id_lang.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND cl.id_shop = p.id_shop_default': '').")                    
        WHERE p.id_product NOT IN (SELECT cp.id_product FROM "._DB_PREFIX_."category_product cp) 
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
	
			var tbProductWithoutCategory = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_WITHOUT_CATEGORY").attachToolbar();
			tbProductWithoutCategory.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbProductWithoutCategory.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbProductWithoutCategory.addButton("put_default", 0, "", "lib/img/accessory.png", "lib/img/accessory.png");
			tbProductWithoutCategory.setItemToolTip('put_default','<?php echo _l('Put product in his default category')?>');
			tbProductWithoutCategory.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridProductWithoutCategory.selectAll();
					}
					if (id=='put_default')
					{
                        putdefaultProductWithoutCategory();
					}
				});
		
			var gridProductWithoutCategory = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_WITHOUT_CATEGORY").attachGrid();
			gridProductWithoutCategory.setImagePath("lib/js/imgs/");
			gridProductWithoutCategory.enableSmartRendering(true);
			gridProductWithoutCategory.enableMultiselect(true);
	
			gridProductWithoutCategory.setHeader("ID <?php echo _l('product')?>,<?php echo _l('Name')?>,<?php echo _l('Default category')?>");
			gridProductWithoutCategory.setInitWidths("100,*,*");
			gridProductWithoutCategory.setColAlign("left,left,left");
			gridProductWithoutCategory.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $product) { ?>
			xml = xml+'   <row id="<?php echo $product["id_product"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $product["id_product"] ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo addslashes($product["name"]); ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo "#".$product["id_category_default"]." ".addslashes($product["category_name"]); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridProductWithoutCategory.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_WITHOUT_CATEGORY").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function putdefaultProductWithoutCategory()
			{
				var selectedProductWithoutCategorys = gridProductWithoutCategory.getSelectedRowId();
				if(selectedProductWithoutCategorys==null || selectedProductWithoutCategorys=="")
					selectedProductWithoutCategorys = 0;
				if(selectedProductWithoutCategorys!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_WITHOUT_CATEGORY&id_lang="+SC_ID_LANG, { "action": "put_default", "ids": selectedProductWithoutCategorys}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_WITHOUT_CATEGORY").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_WITHOUT_CATEGORY');
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
			"title"=>_l('Without cat.'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="put_default")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
        $sql = "SELECT *
        FROM "._DB_PREFIX_."product
        WHERE id_product IN (".psql($post_ids).")";
        $res=Db::getInstance()->ExecuteS($sql);

        foreach ($res as $pdt)
        {
            if(!empty($pdt["id_category_default"]))
            {
                $sql = "INSERT INTO "._DB_PREFIX_."category_product (id_category,id_product,`position`)
                    VALUES ('".(int)$pdt["id_category_default"]."','".(int)$pdt["id_product"]."','0')";
                $res=dbExecuteForeignKeyOff($sql);
            }
        }
	}
}
