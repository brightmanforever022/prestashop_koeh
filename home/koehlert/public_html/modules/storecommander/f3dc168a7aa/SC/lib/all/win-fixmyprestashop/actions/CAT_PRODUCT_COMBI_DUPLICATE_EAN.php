<?php
$post_action = Tools::getValue("action");
$action_name = 'CAT_PRODUCT_COMBI_DUPLICATE_EAN';
$tab_title = _l('P/Combi. same EAN13');

if(!empty($post_action) && $post_action=="do_check")
{
    $res = array();
    /*$sql = 'SELECT p.id_product,IFNULL(pa.id_product_attribute,0) AS id_product_attribute,p.ean13,pl.name,p.id_category_default
                FROM '._DB_PREFIX_.'product p
                LEFT JOIN '._DB_PREFIX_.'product_lang pl
                    ON (pl.id_product = p.id_product AND pl.id_lang = '.(int)$id_lang.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND pl.id_shop = '.(int)SCI::getSelectedShop() : '').')
                LEFT JOIN '._DB_PREFIX_.'product_attribute pa ON (pa.id_product = p.id_product)
                WHERE p.ean13 != ""
                UNION
                SELECT pa.id_product as prd_from_attr,IFNULL(pa.id_product_attribute,0) AS id_product_attribute,pa.ean13,pl.name,p.id_category_default
                FROM '._DB_PREFIX_.'product p
                RIGHT JOIN '._DB_PREFIX_.'product_lang pl
                    ON (pl.id_product = p.id_product AND pl.id_lang = '.(int)$id_lang.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND pl.id_shop = '.(int)SCI::getSelectedShop() : '').')
                JOIN '._DB_PREFIX_.'product_attribute pa ON (pa.ean13 = p.ean13)
                WHERE pa.ean13 != ""
                ORDER BY ean13,id_product,id_product_attribute';*/

    $sql = 'SELECT p.id_product,pl.name,pa.id_product_attribute,p.ean13,p.id_category_default, p.active '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' , ps.active ': '').',
              ppa.id_category_default AS id_category_default_combi,ppa.id_product AS id_product_combi,papl.name AS name_combi, ppa.active AS active_combi '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' , pspa.active AS active_combi ': '').'
            FROM '._DB_PREFIX_.'product p
            INNER JOIN '._DB_PREFIX_.'product_lang pl
                ON (pl.id_product = p.id_product AND pl.id_lang = '.(int)$id_lang.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND pl.id_shop = p.id_shop_default': '').')
            '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' INNER JOIN '._DB_PREFIX_.'product_shop ps ON (ps.id_product = p.id_product AND ps.id_shop = p.id_shop_default ) ': '').'
            INNER JOIN '._DB_PREFIX_.'product_attribute pa ON (pa.ean13 = p.ean13)
                INNER JOIN '._DB_PREFIX_.'product ppa ON (pa.id_product = ppa.id_product)
                    INNER JOIN '._DB_PREFIX_.'product_lang papl
                        ON (papl.id_product = ppa.id_product AND papl.id_lang = '.(int)$id_lang.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND papl.id_shop = ppa.id_shop_default': '').')
                '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' INNER JOIN '._DB_PREFIX_.'product_shop pspa ON (pspa.id_product = ppa.id_product AND pspa.id_shop = ppa.id_shop_default ) ': '').'
            WHERE pa.ean13 != ""
            ORDER BY p.ean13,p.id_product,pa.id_product_attribute';
    $res = Db::getInstance()->ExecuteS($sql);

    $content = "";
    $content_js = "";
    $results = "OK";
    if(!empty($res) && count($res)>0)
    {
        $tmp = array();
        foreach($res as $row) {
            $tmp[] = $row['id_product_attribute'];
        }
        $attr_name = SCI::cachingAttributeName($id_lang,$tmp);
        $results = "KO";
        ob_start();
        ?>
        <script type="text/javascript">

            var tbProductCombiSameEAN = dhxlSCExtCheck.tabbar.cells("table_<?php echo $action_name; ?>").attachToolbar();
            var idProductCombiSameEAN = '';
            tbProductCombiSameEAN.addButton("gotoCombicatalog", 0, "", "lib/img/combinations.gif", "lib/img/combinations.gif");
            tbProductCombiSameEAN.setItemToolTip('gotoCombicatalog','<?php echo _l('Go to the combination in catalog.')?>');
            tbProductCombiSameEAN.addButton("gotocatalog", 0, "", "lib/img/table_go.png", "lib/img/table_go.png");
            tbProductCombiSameEAN.setItemToolTip('gotocatalog','<?php echo _l('Go to the product in catalog.')?>');
            tbProductCombiSameEAN.addButton("exportcsv", 0, "", "lib/img/page_excel.png", "lib/img/page_excel.png");
            tbProductCombiSameEAN.setItemToolTip('exportcsv','<?php echo _l('Export grid to clipboard in CSV format for MSExcel with tab delimiter.')?>');
            tbProductCombiSameEAN.attachEvent("onClick",
                function(id){
                    if (id=='gotocatalog')
                    {
                        if(idProductCombiSameEAN !== '') {
                            var path = gridProductCombiSameEAN.getUserData(idProductCombiSameEAN, "path_pdt");
                            let url = "?page=cat_tree&open_cat_grid="+path;
                            window.open(url,'_blank');
                        }
                    }
                    if (id=='gotoCombicatalog')
                    {
                        if(idProductCombiSameEAN !== '') {
                            var path = gridProductCombiSameEAN.getUserData(idProductCombiSameEAN, "path_combi");
                            let url = "?page=cat_tree&open_cat_grid="+path;
                            window.open(url,'_blank');
                        }
                    }
                    if(id=='exportcsv') {
                        displayQuickExportWindow(gridProductCombiSameEAN,1);
                    }
                });

            var gridProductCombiSameEAN = dhxlSCExtCheck.tabbar.cells("table_<?php echo $action_name; ?>").attachGrid();
            gridProductCombiSameEAN.setImagePath("lib/js/imgs/");
            gridProductCombiSameEAN.enableSmartRendering(true);
            gridProductCombiSameEAN.enableMultiselect(false);

            gridProductCombiSameEAN.setHeader("ID <?php echo _l('product')?>,<?php echo _l('Active')?>,<?php echo _l('Product name')?>,<?php echo _l('EAN')?>,ID <?php echo _l('Combination')?>,<?php echo _l('Active')?>,<?php echo _l('Product name')?>,<?php echo _l('Combination name')?>");
            gridProductCombiSameEAN.setInitWidths("100,60,200,100,100,60,100,200");
            gridProductCombiSameEAN.setColAlign("left,left,left,left,left,left,left");
            gridProductCombiSameEAN.setColSorting("int,str,str,str,int,str,str,str");
            gridProductCombiSameEAN.init();

            gridProductCombiSameEAN.attachEvent('onRowSelect',function(id){
                idProductCombiSameEAN = id;
            });

            var xml = '<rows>';
            <?php foreach ($res as $row) { ?>
            xml = xml+'   <row id="<?php echo $row["id_product"].'_'.$row["id_product_attribute"] ?>">';
            xml = xml+'  	<userdata name="path_pdt"><?php echo $row["id_category_default"].'-'.$row["id_product"] ?></userdata>';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["id_product"] ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo (!empty($row["active"])?_l("Yes"):_l("No")); ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo addslashes($row["name"]) ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo (!empty($row["ean13"]) ? $row["ean13"] : 0) ?>]]></cell>';
            xml = xml+'  	<userdata name="path_combi"><?php echo $row["id_category_default_combi"].'-'.$row["id_product_combi"].'-'.$row["id_product_attribute"] ?></userdata>';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["id_product_combi"].'-'.$row["id_product_attribute"] ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo (!empty($row["active_combi"])?_l("Yes"):_l("No")); ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo addslashes($row["name_combi"]) ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo (array_key_exists($row["id_product_attribute"],$attr_name) ? addslashes($attr_name[$row["id_product_attribute"]]) : '') ?>]]></cell>';
            xml = xml+'   </row>';
            <?php } ?>
            xml = xml+'</rows>';
            gridProductCombiSameEAN.parse(xml);

            dhxlSCExtCheck.tabbar.cells("table_<?php echo $action_name; ?>").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });
        </script>
        <?php
        $content_js = ob_get_clean();
    }
    echo Tools::jsonEncode(array(
        "results"=>$results,
        "contentType"=>"grid",
        "content"=>$content,
        "title"=>$tab_title,
        "contentJs"=>$content_js
    ));
}
