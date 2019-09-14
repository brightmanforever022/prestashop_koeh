<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
    $sql = 'SELECT p.`id_product` 
                FROM ' . _DB_PREFIX_ . 'product p
                INNER JOIN ' . _DB_PREFIX_ . 'product_shop ps ON (ps.id_product = p.id_product AND ps.id_shop = p.id_shop_default)
                WHERE p.`id_category_default` != ps.`id_category_default`
                OR p.`id_tax_rules_group` != ps.`id_tax_rules_group`
                OR p.`on_sale` != ps.`on_sale`
                OR p.`online_only` != ps.`online_only`
                OR p.`ecotax` != ps.`ecotax`
                OR p.`minimal_quantity` != ps.`minimal_quantity`
                OR p.`price` != ps.`price`
                OR p.`wholesale_price` != ps.`wholesale_price`
                OR p.`unity` != ps.`unity`
                OR p.`unit_price_ratio` != ps.`unit_price_ratio`
                OR p.`additional_shipping_cost` != ps.`additional_shipping_cost`
                OR p.`customizable` != ps.`customizable`
                OR p.`uploadable_files` != ps.`uploadable_files`
                OR p.`text_fields` != ps.`text_fields`
                OR p.`active` != ps.`active`
                OR p.`redirect_type` != ps.`redirect_type`
                OR p.`id_product_redirected` != ps.`id_product_redirected`
                OR p.`available_for_order` != ps.`available_for_order`
                OR p.`available_date` != ps.`available_date`';
    if (version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
        $sql .='OR p.`show_condition` != ps.`show_condition`';
    }
    $sql .='OR p.`condition` != ps.`condition`
                OR p.`show_price` != ps.`show_price`
                OR p.`indexed` != ps.`indexed`
                OR p.`visibility` != ps.`visibility`
                OR p.`cache_default_attribute` != ps.`cache_default_attribute`
                OR p.`advanced_stock_management` != ps.`advanced_stock_management`
                OR p.`date_add` != ps.`date_add`
                OR p.`date_upd` != ps.`date_upd`
                OR p.`pack_stock_type` != ps.`pack_stock_type`';

    $res = Db::getInstance()->ExecuteS($sql);

    $content = "";
    $content_js = "";
    $results = "OK";
    if(!empty($res) && count($res)>0)
    {
        $results = "KO";
        ob_start();
        ?>
        <script type="text/javascript">

            var tbProductInfoChanged = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_DIFF_INFOS_SHOP").attachToolbar();
            tbProductInfoChanged.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
            tbProductInfoChanged.setItemToolTip('selectall','<?php echo _l('Select all')?>');
            tbProductInfoChanged.addButton("replaceProductInfosShop", 0, "", "lib/img/cog_go.png", "lib/img/cog_go.png");
            tbProductInfoChanged.setItemToolTip('replaceProductInfosShop','<?php echo _l('Copy infos from ps_product_shop to products')?>');
            tbProductInfoChanged.attachEvent("onClick",
                function(id){
                    if (id=='selectall')
                    {
                        gridProductInfoChanged.selectAll();
                    }
                    if (id=='replaceProductInfosShop')
                    {
                        replaceProductInfosShop();
                    }
                });

            var gridProductInfoChanged = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_DIFF_INFOS_SHOP").attachGrid();
            gridProductInfoChanged.setImagePath("lib/js/imgs/");
            gridProductInfoChanged.enableSmartRendering(true);
            gridProductInfoChanged.enableMultiselect(true);

            gridProductInfoChanged.setHeader("<?php echo _l('Product ID')?>");
            gridProductInfoChanged.setInitWidths("80,200,100");
            gridProductInfoChanged.setColAlign("right,left,left");
            gridProductInfoChanged.init();

            var xml = '<rows>';
            <?php foreach ($res as $product) { ?>
            xml = xml+'   <row id="<?php echo $product["id_product"] ?>">';
            xml = xml+'  	<cell><![CDATA[<?php echo $product["id_product"] ?>]]></cell>';
            xml = xml+'   </row>';
            <?php } ?>
            xml = xml+'</rows>';
            gridProductInfoChanged.parse(xml);

            dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_DIFF_INFOS_SHOP").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

            <?php foreach ($res as $product) {
            if(empty($product["name"])) {?>
            gridProductInfoChanged.cells("<?php echo $product["id_product"] ?>",1).setBgColor('red');
            <?php
            }
            } ?>

            function replaceProductInfosShop()
            {
                var selectedProductInfoChanged = gridProductInfoChanged.getSelectedRowId();
                if(selectedProductInfoChanged==null || selectedProductInfoChanged=="")
                    selectedProductInfoChanged = 0;
                if(selectedProductInfoChanged!="0")
                {
                    $.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_DIFF_INFOS_SHOP&id_lang="+SC_ID_LANG, { "action": "replace_product_infos", "ids": selectedProductInfoChanged}, function(data){
                        dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_DIFF_INFOS_SHOP").close();

                        dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_DIFF_INFOS_SHOP');
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
        "title"=>_l('Different information'),
        "contentJs"=>$content_js
    ));
}
elseif(!empty($post_action) && $post_action=="replace_product_infos")
{
    $post_ids = Tools::getValue("ids");
    if(!empty($post_ids))
    {
        $ids = explode(",",$post_ids);
        foreach($ids as $id)
        {
            $id_default_shop = (int)Configuration::get('PS_SHOP_DEFAULT');
            $sql = "UPDATE "._DB_PREFIX_."product p
                    INNER JOIN "._DB_PREFIX_."product_shop ps ON (ps.id_product = p.id_product AND ps.id_shop = p.id_shop_default)
                    SET p.`id_category_default` = ps.`id_category_default`,
                    p.`id_tax_rules_group` = ps.`id_tax_rules_group`,
                    p.`on_sale` = ps.`on_sale`,
                    p.`online_only` = ps.`online_only`,
                    p.`ecotax` = ps.`ecotax`,
                    p.`minimal_quantity` = ps.`minimal_quantity`,
                    p.`price` = ps.`price`,
                    p.`wholesale_price` = ps.`wholesale_price`,
                    p.`unity` = ps.`unity`,
                    p.`unit_price_ratio` = ps.`unit_price_ratio`,
                    p.`additional_shipping_cost` = ps.`additional_shipping_cost`,
                    p.`customizable` = ps.`customizable`,
                    p.`uploadable_files` = ps.`uploadable_files`,
                    p.`text_fields` = ps.`text_fields`,
                    p.`active` = ps.`active`,
                    p.`redirect_type` = ps.`redirect_type`,
                    p.`id_product_redirected` = ps.`id_product_redirected`,
                    p.`available_for_order` = ps.`available_for_order`,";
            if (version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
                $sql .= "p.`show_condition` = ps.`show_condition`,
                         p.`available_date` = CASE ps.`available_date` WHEN '0000-00-00' THEN NULL ELSE ps.`available_date` END,";
            } else {
                $sql .= "p.`available_date` = ps.`available_date`,";
            }
            $sql .="p.`condition` = ps.`condition`,
                    p.`show_price` = ps.`show_price`,
                    p.`indexed` = ps.`indexed`,
                    p.`visibility` = ps.`visibility`,
                    p.`cache_default_attribute` = ps.`cache_default_attribute`,
                    p.`advanced_stock_management` = ps.`advanced_stock_management`,
                    p.`date_add` = ps.`date_add`,
                    p.`date_upd` = ps.`date_upd`,
                    p.`pack_stock_type` = ps.`pack_stock_type`
                    WHERE p.id_product = " . (int)$id;
            $res=dbExecuteForeignKeyOff($sql);
        }
    }
}
