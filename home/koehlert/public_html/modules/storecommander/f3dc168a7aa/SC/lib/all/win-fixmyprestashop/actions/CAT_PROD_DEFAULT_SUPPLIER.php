<?php
$post_action = Tools::getValue("action");
if(!empty($_POST["action"]) && $_POST["action"]=="do_check" && empty($_POST["for_PS"]))
{
    //$sql = "select pl.id_product, pl.name from "._DB_PREFIX_."product_lang pl where pl.id_product not in (select p.id_product from "._DB_PREFIX_."product p) ORDER BY id_lang ASC";
    //$sql = "select pl.id_product, pl.name from "._DB_PREFIX_."product_lang pl, product_supplier ps WHERE pl.id_product = ps.id_product AND ps.id_supplier = 0 ORDER BY ps.id_supplier ASC";
    //$sql = "select pl.id_product, pl.name from "._DB_PREFIX_."product_lang pl LEFT JOIN ps_product_supplier ps ON ( pl.id_product = ps.id_product AND ps.id_supplier = 0 )ORDER BY ps.id_supplier ASC";
    // $sql = "select pl.id_product, pl.name from "._DB_PREFIX_."product_lang pl LEFT JOIN ps_product_supplier ps where ps.id_supplier not in (select ps.id_supplier from "._DB_PREFIX_."product_supplier ) ORDER BY pl.id_product ASC";
    $sql = "select pl.id_product, pl.name, pr.reference from "._DB_PREFIX_."product_lang pl INNER JOIN "._DB_PREFIX_."product pr ON ( pl.id_product = pr.id_product AND pr.id_supplier = 0 )ORDER BY pr.id_supplier ASC LIMIT 1500";

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

            var tbMissingDefaultSupplier = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_DEFAULT_SUPPLIER").attachToolbar();
            tbMissingDefaultSupplier.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
            tbMissingDefaultSupplier.setItemToolTip('selectall','<?php echo _l('Select all')?>');
            tbMissingDefaultSupplier.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
            tbMissingDefaultSupplier.setItemToolTip('delete','<?php echo _l('Delete incomplete suppliers')?>');
            tbMissingDefaultSupplier.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
            tbMissingDefaultSupplier.setItemToolTip('add','<?php echo _l('Recover incomplete suppliers')?>');
            tbMissingDefaultSupplier.attachEvent("onClick",
                function(id){
                    if (id=='selectall')
                    {
                        gridMissingDefaultSupplier.selectAll();
                    }
                    if (id=='delete')
                    {
                        deleteMissingDefaultSupplier();
                    }
                    if (id=='add')
                    {
                        addMissingDefaultSupplier()
                    }
                });

            var gridMissingDefaultSupplier = dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_DEFAULT_SUPPLIER").attachGrid();
            gridMissingDefaultSupplier.setImagePath("lib/js/imgs/");
            gridMissingDefaultSupplier.enableSmartRendering(true);
            gridMissingDefaultSupplier.enableMultiselect(true);
            gridMissingDefaultSupplier.setHeader("ID,<?php echo _l('Name')?>,<?php echo _l('Reference')?>");
            gridMissingDefaultSupplier.setInitWidths("100,110,110");
            gridMissingDefaultSupplier.setColAlign("left,left,left");
            gridMissingDefaultSupplier.init();

            var xml = '<rows>';
            <?php foreach ($res as $product) { ?>
            xml = xml+'   <row id="<?php echo $product["id_product"] ?>">';
            xml = xml+'  	<cell><![CDATA[<?php echo $product["id_product"] ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $product["name"]) ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo str_replace("'", "\'", $product["reference"]) ?>]]></cell>';
            xml = xml+'   </row>';
            <?php } ?>
            xml = xml+'</rows>';
            gridMissingDefaultSupplier.parse(xml);

            dhxlSCExtCheck.tabbar.cells("table_CAT_PROD_DEFAULT_SUPPLIER").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

            function deleteMissingDefaultSupplier()
            {
                var selectedMissingDefaultSupplier = gridMissingDefaultSupplier.getSelectedRowId();
                if(selectedMissingDefaultSupplier==null || selectedMissingDefaultSupplier=="")
                    selectedMissingDefaultSupplier = 0;
                if(selectedMissingDefaultSupplier!="0")
                {
                    $.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_DEFAULT_SUPPLIER&id_lang="+SC_ID_LANG, { "action": "delete_products", "ids": selectedMissingDefaultSupplier}, function(data){
                        dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_DEFAULT_SUPPLIER").close();

                        dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_DEFAULT_SUPPLIER');
                        doCheck(false);
                    });
                }
            }

            function addMissingdefaultSupplier()
            {
                var selectedMissingDefaultSupplier = gridMissingDefaultSupplier.getSelectedRowId();
                if(selectedMissingDefaultSupplier==null || selectedMissingDefaultSupplier=="")
                    selectedMissingDefaultSupplier = 0;
                if(selectedMissingDefaultSupplier!="0")
                {
                    $.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PROD_DEFAULT_SUPPLIER&id_lang="+SC_ID_LANG, { "action": "add_products", "ids": selectedMissingDefaultSupplier}, function(data){
                        dhxlSCExtCheck.tabbar.tabs("table_CAT_PROD_DEFAULT_SUPPLIER").close();

                        dhxlSCExtCheck.gridChecks.selectRowById('CAT_PROD_DEFAULT_SUPPLIER');
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

