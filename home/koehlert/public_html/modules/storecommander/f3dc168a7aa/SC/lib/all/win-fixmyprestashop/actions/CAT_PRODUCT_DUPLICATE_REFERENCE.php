<?php
$post_action = Tools::getValue("action");
$action_name = 'CAT_PRODUCT_DUPLICATE_REFERENCE';
$tab_title = _l('Products same ref.');

if(!empty($post_action) && $post_action=="do_check")
{
    $res = array();
    $sql = 'SELECT reference, count(*) AS c
                FROM '._DB_PREFIX_.'product
                WHERE reference != ""
                GROUP BY reference
                HAVING c > 1
                ORDER BY c DESC';
    $ref_found = Db::getInstance()->ExecuteS($sql);
    if(!empty($ref_found)) {
        $refs= array();
        foreach($ref_found as $row) {
            $refs[] = $row['reference'];
        }
        $sql = 'SELECT p.id_product,p.id_category_default,p.reference,pl.name, p.active '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' , ps.active ': '').'
                    FROM '._DB_PREFIX_.'product p
                    LEFT JOIN '._DB_PREFIX_.'product_lang pl 
                        ON (pl.id_product = p.id_product AND pl.id_lang = '.(int)$id_lang.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' AND pl.id_shop = p.id_shop_default ': '').')
                    '.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? ' INNER JOIN '._DB_PREFIX_.'product_shop ps ON (ps.id_product = p.id_product AND ps.id_shop = p.id_shop_default ) ': '').'
                    WHERE p.reference IN ("'.implode('","',$refs).'") 
                    ORDER BY p.reference';
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

            var tbProductSameRef = dhxlSCExtCheck.tabbar.cells("table_<?php echo $action_name; ?>").attachToolbar();
            var idProductSameRef = '';
            tbProductSameRef.addButton("gotocatalog", 0, "", "lib/img/table_go.png", "lib/img/table_go.png");
            tbProductSameRef.setItemToolTip('gotocatalog','<?php echo _l('Go to the product in catalog.')?>');
            tbProductSameRef.addButton("exportcsv", 0, "", "lib/img/page_excel.png", "lib/img/page_excel.png");
            tbProductSameRef.setItemToolTip('exportcsv','<?php echo _l('Export grid to clipboard in CSV format for MSExcel with tab delimiter.')?>');
            tbProductSameRef.attachEvent("onClick",
                function(id){
                    if (id=='gotocatalog')
                    {
                        if(idProductSameRef !== '') {
                            let url = "?page=cat_tree&open_cat_grid="+idProductSameRef;
                            window.open(url,'_blank');
                        }

                    }
                    if(id=='exportcsv') {
                        displayQuickExportWindow(gridProductSameRef,1);
                    }
                });

            var gridProductSameRef = dhxlSCExtCheck.tabbar.cells("table_<?php echo $action_name; ?>").attachGrid();
            gridProductSameRef.setImagePath("lib/js/imgs/");
            gridProductSameRef.enableSmartRendering(true);
            gridProductSameRef.enableMultiselect(false);

            gridProductSameRef.setHeader("ID <?php echo _l('product')?>,<?php echo _l('Reference')?>,<?php echo _l('Active')?>,<?php echo _l('Name')?>");
            gridProductSameRef.setInitWidths("100,100,60,*");
            gridProductSameRef.setColAlign("left,left,left,left");
            gridProductSameRef.setColSorting("int,str,str,str");
            gridProductSameRef.init();

            gridProductSameRef.attachEvent('onRowSelect',function(id){
                idProductSameRef = id;
            });

            var xml = '<rows>';
            <?php foreach ($res as $row) { ?>
            xml = xml+'   <row id="<?php echo $row["id_category_default"].'-'.$row["id_product"] ?>">';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["id_product"] ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["reference"] ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo (!empty($row["active"])?_l("Yes"):_l("No")); ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo addslashes($row["name"]) ?>]]></cell>';
            xml = xml+'   </row>';
            <?php } ?>
            xml = xml+'</rows>';
            gridProductSameRef.parse(xml);

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
