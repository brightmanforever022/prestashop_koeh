<?php
$post_action = Tools::getValue("action");
$action_name = 'CAT_PRODUCT_DUPLICATE_UPC';
$tab_title = _l('Products same UPC');

if(!empty($post_action) && $post_action=="do_check")
{
    $res = array();
    $sql = 'SELECT upc, count(*) AS c
                FROM '._DB_PREFIX_.'product
                WHERE upc != ""
                GROUP BY upc
                HAVING c > 1
                ORDER BY c DESC';
    $ref_found = Db::getInstance()->ExecuteS($sql);
    if(!empty($ref_found)) {
        $refs= array();
        foreach($ref_found as $row) {
            $refs[] = $row['upc'];
        }
        $sql = 'SELECT p.id_product,p.id_category_default,p.upc,pl.name, p.active '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' , ps.active ': '').'
                    FROM '._DB_PREFIX_.'product p
                    LEFT JOIN '._DB_PREFIX_.'product_lang pl 
                    ON (pl.id_product = p.id_product AND pl.id_lang = '.(int)$id_lang.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND pl.id_shop = p.id_shop_default': '').')
                    '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' INNER JOIN '._DB_PREFIX_.'product_shop ps ON (ps.id_product = p.id_product AND ps.id_shop = p.id_shop_default ) ': '').'
                    WHERE p.upc IN ("'.implode('","',$refs).'") 
                    ORDER BY p.upc';
        $res = Db::getInstance()->ExecuteS($sql);
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

            var tbProductSameUPC = dhxlSCExtCheck.tabbar.cells("table_<?php echo $action_name; ?>").attachToolbar();
            var idProductSameUPC = '';
            tbProductSameUPC.addButton("gotocatalog", 0, "", "lib/img/table_go.png", "lib/img/table_go.png");
            tbProductSameUPC.setItemToolTip('gotocatalog','<?php echo _l('Go to the product in catalog.')?>');
            tbProductSameUPC.addButton("exportcsv", 0, "", "lib/img/page_excel.png", "lib/img/page_excel.png");
            tbProductSameUPC.setItemToolTip('exportcsv','<?php echo _l('Export grid to clipboard in CSV format for MSExcel with tab delimiter.')?>');
            tbProductSameUPC.attachEvent("onClick",
                function(id){
                    if (id=='gotocatalog')
                    {
                        if(idProductSameUPC !== '') {
                            let url = "?page=cat_tree&open_cat_grid="+idProductSameUPC;
                            window.open(url,'_blank');
                        }

                    }
                    if(id=='exportcsv') {
                        displayQuickExportWindow(gridProductSameUPC,1);
                    }
                });

            var gridProductSameUPC = dhxlSCExtCheck.tabbar.cells("table_<?php echo $action_name; ?>").attachGrid();
            gridProductSameUPC.setImagePath("lib/js/imgs/");
            gridProductSameUPC.enableSmartRendering(true);
            gridProductSameUPC.enableMultiselect(false);

            gridProductSameUPC.setHeader("ID <?php echo _l('product')?>,<?php echo _l('UPC')?>,<?php echo _l('Active')?>,<?php echo _l('Name')?>");
            gridProductSameUPC.setInitWidths("100,100,60,*");
            gridProductSameUPC.setColAlign("left,left,left,left");
            gridProductSameUPC.setColSorting("int,str,str,str");
            gridProductSameUPC.init();

            gridProductSameUPC.attachEvent('onRowSelect',function(id){
                idProductSameUPC = id;
            });

            var xml = '<rows>';
            <?php foreach ($res as $row) { ?>
            xml = xml+'   <row id="<?php echo $row["id_category_default"].'-'.$row["id_product"] ?>">';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["id_product"] ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["upc"] ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo (!empty($row["active"])?_l("Yes"):_l("No")); ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo addslashes($row["name"]) ?>]]></cell>';
            xml = xml+'   </row>';
            <?php } ?>
            xml = xml+'</rows>';
            gridProductSameUPC.parse(xml);

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
