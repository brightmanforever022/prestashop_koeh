<?php
$post_action = Tools::getValue("action");
if(!empty($_POST["action"]) && $_POST["action"]=="do_check" && empty($_POST["for_PS"]))
{

    $sql = "select pl.id_product, pl.name, pr.reference,pr.id_supplier
    from "._DB_PREFIX_."product pr
    INNER JOIN "._DB_PREFIX_."product_lang pl ON (pr.id_product=pl.id_product AND pl.id_lang=".(int)$id_lang.")
        WHERE pr.id_product NOT IN (
            select pr2.id_product
            from "._DB_PREFIX_."product pr2
                INNER JOIN "._DB_PREFIX_."product_supplier psu ON (pr2.id_product=psu.id_product AND pr2.id_supplier=psu.id_supplier)
            WHERE pr2.id_supplier!=0  AND psu.id_product_attribute = 0)
        AND pr.id_supplier!=0
     GROUP BY pr.id_product LIMIT 1500";


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

            var tbMissingDefaultSupplierTableChecking = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_DEFAULT_SUPPLIER_TABLE_CHECKING").attachToolbar();
            tbMissingDefaultSupplierTableChecking.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
            tbMissingDefaultSupplierTableChecking.setItemToolTip('selectall','<?php echo _l('Select all')?>');
            tbMissingDefaultSupplierTableChecking.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
            tbMissingDefaultSupplierTableChecking.setItemToolTip('add','<?php echo _l('Recover incomplete suppliers')?>');
            tbMissingDefaultSupplierTableChecking.attachEvent("onClick",
                function(id){
                    if (id=='selectall')
                    {
                        gridMissingDefaultSupplierTableChecking.selectAll();
                    }
                    if (id=='add')
                    {
                        addMissingDefaultSupplierTableChecking()
                    }
                });

            var gridMissingDefaultSupplierTableChecking = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_DEFAULT_SUPPLIER_TABLE_CHECKING").attachGrid();
            gridMissingDefaultSupplierTableChecking.setImagePath("lib/js/imgs/");
            gridMissingDefaultSupplierTableChecking.enableSmartRendering(true);
            gridMissingDefaultSupplierTableChecking.enableMultiselect(true);
            gridMissingDefaultSupplierTableChecking.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Reference')?>");
            gridMissingDefaultSupplierTableChecking.setInitWidths("100,110,110");
            gridMissingDefaultSupplierTableChecking.setColAlign("left,left,left");
            gridMissingDefaultSupplierTableChecking.init();

            var xml = '<rows>';
            <?php foreach ($res as $product) { ?>
            xml = xml+'   <row id="<?php echo $product["id_product"]."_".$product['id_supplier']; ?>">';
            xml = xml+'  	<cell><![CDATA[<?php echo $product["id_product"] ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $product["name"]) ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $product["reference"]) ?>]]></cell>';
            xml = xml+'   </row>';
            <?php } ?>
            xml = xml+'</rows>';
            gridMissingDefaultSupplierTableChecking.parse(xml);
            
            dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_DEFAULT_SUPPLIER_TABLE_CHECKING").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });
         
            function addMissingDefaultSupplierTableChecking()
            {
                var selectedMissingDefaultSupplierTableChecking = gridMissingDefaultSupplierTableChecking.getSelectedRowId();
                if(selectedMissingDefaultSupplierTableChecking==null || selectedMissingDefaultSupplierTableChecking=="")
                    selectedMissingDefaultSupplierTableChecking = 0;
                if(selectedMissingDefaultSupplierTableChecking!="0")
                {
                    $.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_DEFAULT_SUPPLIER_TABLE_CHECKING&id_lang="+SC_ID_LANG, { "action": "add_missingSupplier", "ids": selectedMissingDefaultSupplierTableChecking}, function(data){
                        dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_DEFAULT_SUPPLIER_TABLE_CHECKING").close();

                        dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_DEFAULT_SUPPLIER_TABLE_CHECKING');
                        doCheck(false);
                    });
                }
            }

        </script>
        <?php
        $content_js = ob_get_clean();
    }
    echo json_encode(array(
        "results"=>$results,
        "contentType"=>"grid",
        "content"=>$content,
        "title"=>_l('Default supplier'),
        "contentJs"=>$content_js
    ));
}
elseif(!empty($post_action) && $post_action=="add_missingSupplier")
{
    $post_ids = Tools::getValue("ids");
    if(!empty($post_ids))
    {
        $ids = explode(",",$post_ids);
        foreach($ids as $id)
        {
            list($id_product, $id_supplier) = explode("_", $id);

            if(!empty($id_product) && !empty($id_supplier));
            {

                $sql = "INSERT INTO " . _DB_PREFIX_ . "product_supplier (id_product, id_supplier, id_product_attribute)
					VALUES (" . (int)$id_product . "," . (int)$id_supplier . ",0)";
                dbExecuteForeignKeyOff($sql);

            }
        }
    }
}
