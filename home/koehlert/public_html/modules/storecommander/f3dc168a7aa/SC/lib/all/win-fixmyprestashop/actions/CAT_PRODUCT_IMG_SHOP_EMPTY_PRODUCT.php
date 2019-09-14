<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
    $sql = "SELECT ishop.*
    FROM `"._DB_PREFIX_."image_shop` ishop
        INNER JOIN `"._DB_PREFIX_."image` i ON (i.id_image=ishop.id_image AND ishop.`id_product`!=0)
    WHERE ishop.`id_product` = 0 LIMIT 1500";
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

            var tbImgShopWithoutProduct = dhxlSCExtCheck.tabbar.cells("table_CAT_PRODUCT_IMG_SHOP_EMPTY_PRODUCT").attachToolbar();
            tbImgShopWithoutProduct.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
            tbImgShopWithoutProduct.setItemToolTip('selectall','<?php echo _l('Select all')?>');
            tbImgShopWithoutProduct.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
            tbImgShopWithoutProduct.setItemToolTip('add','<?php echo _l('Update id_product',1)?>');
            tbImgShopWithoutProduct.attachEvent("onClick",
                function(id){
                    if (id=='selectall')
                    {
                        gridImgShopWithoutProduct.selectAll();
                    }
                    if (id=='add')
                    {
                        addImgShopWithoutProduct()
                    }
                });

            var gridImgShopWithoutProduct = dhxlSCExtCheck.tabbar.cells("table_CAT_PRODUCT_IMG_SHOP_EMPTY_PRODUCT").attachGrid();
            gridImgShopWithoutProduct.setImagePath("lib/js/imgs/");
            gridImgShopWithoutProduct.enableSmartRendering(false);
            gridImgShopWithoutProduct.enableMultiselect(true);

            gridImgShopWithoutProduct.setHeader("ID <?php echo _l('Image')?>,ID <?php echo _l('Shop')?>");
            gridImgShopWithoutProduct.setInitWidths("60,60");
            gridImgShopWithoutProduct.setColAlign("right,right");
            gridImgShopWithoutProduct.init();

            var xml = '<rows>';
            <?php foreach ($res as $row) {
                ?>
            xml = xml+'   <row id="<?php echo $row["id_image"]."_".$row["id_shop"] ?>">';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["id_image"] ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["id_shop"] ?>]]></cell>';
            xml = xml+'   </row>';
            <?php } ?>
            xml = xml+'</rows>';
            gridImgShopWithoutProduct.parse(xml);

            dhxlSCExtCheck.tabbar.cells("table_CAT_PRODUCT_IMG_SHOP_EMPTY_PRODUCT").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

            function addImgShopWithoutProduct()
            {
                var selectedImgShopWithoutProducts = gridImgShopWithoutProduct.getSelectedRowId();
                if(selectedImgShopWithoutProducts==null || selectedImgShopWithoutProducts=="")
                    selectedImgShopWithoutProducts = 0;
                if(selectedImgShopWithoutProducts!="0")
                {
                    $.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PRODUCT_IMG_SHOP_EMPTY_PRODUCT&id_lang="+SC_ID_LANG, { "action": "add_id_product", "ids": selectedImgShopWithoutProducts}, function(data){
                        dhxlSCExtCheck.tabbar.tabs("table_CAT_PRODUCT_IMG_SHOP_EMPTY_PRODUCT").close();

                        dhxlSCExtCheck.gridChecks.selectRowById('CAT_PRODUCT_IMG_SHOP_EMPTY_PRODUCT');
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
        "title"=>_l('No id_product'),
        "contentJs"=>$content_js
    ));
}
elseif(!empty($post_action) && $post_action=="add_id_product")
{
    $post_ids = Tools::getValue("ids");
    if(!empty($post_ids))
    {
        $ids = explode(",",$post_ids);
        foreach($ids as $id)
        {
            list($id_image,$id_shop) = explode("_", $id);

            $sql = "SELECT * FROM `"._DB_PREFIX_."image` WHERE id_image='".(int)$id_image."' ";
            $res=Db::getInstance()->ExecuteS($sql);

            $sql = "UPDATE "._DB_PREFIX_."image_shop SET id_product='".(int)$res[0]['id_product']."' WHERE id_image='".(int)$id_image."' AND id_shop='".(int)$id_shop."' ";
            $res=dbExecuteForeignKeyOff($sql);
        }
    }
}
