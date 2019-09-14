<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{

    $sql = "SELECT p.id_product, p.reference, p.id_tax_rules_group, pl.name
            FROM "._DB_PREFIX_."product p
            LEFT JOIN "._DB_PREFIX_."product_lang pl ON (pl.id_product = p.id_product AND pl.id_lang  = ".(int)$cookie->id_lang.")
            LEFT JOIN "._DB_PREFIX_."tax_rules_group trg ON (p.id_tax_rules_group = trg.id_tax_rules_group)
            WHERE trg.deleted = 1
            GROUP BY p.id_product, p.reference, pl.name";
    $res=Db::getInstance()->ExecuteS($sql);

    $sql = "SELECT id_tax_rules_group, name
        FROM "._DB_PREFIX_."tax_rules_group
        WHERE deleted = 0";
    $taxes=Db::getInstance()->ExecuteS($sql);

    $content = "";
    $results = "OK";
    if(!empty($res) && count($res)>0)
    {
        $name_key = "CAT_PRODUCT_TAX_DELETED";
        $results = "KO";
        ob_start();
        ?>
        <script type="text/javascript">

            var colsProductDeletedTax = dhxlSCExtCheck.tabbar.cells("table_CAT_PRODUCT_TAX_DELETED").attachLayout("2U");

            // LISTE PRODUCTS
            var tbLeftProductDeletedTax = colsProductDeletedTax.cells('a').attachToolbar();
            colsProductDeletedTax.cells('a').setText("<?php echo _l('Products') ?>");
            tbLeftProductDeletedTax.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
            tbLeftProductDeletedTax.setItemToolTip('selectall','<?php echo _l('Select all')?>');
            tbLeftProductDeletedTax.attachEvent("onClick",
                function(id){
                    if (id=='selectall')
                    {
                        gridLeftProductDeletedTax.selectAll();
                    }
                });

            var gridLeftProductDeletedTax = colsProductDeletedTax.cells('a').attachGrid();
            gridLeftProductDeletedTax.setImagePath("lib/js/imgs/");
            gridLeftProductDeletedTax.enableSmartRendering(true);
            gridLeftProductDeletedTax.enableMultiselect(true);

            gridLeftProductDeletedTax.setHeader("<?php echo _l('ID')?>,<?php echo _l('Ref')?>,<?php echo _l('Name')?>");
            gridLeftProductDeletedTax.setColAlign("left,left,left");
            gridLeftProductDeletedTax.setColTypes("ro,ro,ro");
            gridLeftProductDeletedTax.setInitWidths("40,80,");
            gridLeftProductDeletedTax.init();

            var xml = '<rows>';
            <?php foreach ($res as $id=>$row) {
            ?>
            xml = xml+'<row id="<?php echo $row['id_product'] ?>">';
            xml = xml+'	<userdata name="ids"><?php echo $row['id_product'] ?></userdata>';
            xml = xml+'	<cell><![CDATA[<?php echo $row['id_product'] ?>]]></cell>';
            xml = xml+'	<cell><![CDATA[<?php echo str_replace("'", "\'", $row['reference']) ?>]]></cell>';
            xml = xml+'	<cell><![CDATA[<?php echo str_replace("'", "\'", $row['name']) ?>]]></cell>';
            xml = xml+'</row>';
            <?php
            } ?>
            xml = xml+'</rows>';
            gridLeftProductDeletedTax.parse(xml);

            dhxlSCExtCheck.tabbar.cells("table_CAT_PRODUCT_TAX_DELETED").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

            gridLeftProductDeletedTax.attachEvent("onRowSelect", function(id,ind){
                var ids = gridLeftProductDeletedTax.getUserData(id, "ids");
            });

            // LISTE TAXE RULES GROUP
            var tbRightProductDeletedTax = colsProductDeletedTax.cells('b').attachToolbar();
            colsProductDeletedTax.cells('b').setText("<?php echo _l('Tax rules groups') ?>");
            tbRightProductDeletedTax.addButton("updateTax", 0, "", "lib/img/disk.png", "lib/img/disk.png");
            tbRightProductDeletedTax.setItemToolTip('updateTax','<?php echo _l('Apply selected tax')?>');
            tbRightProductDeletedTax.attachEvent("onClick",
                function(id){
                    if (id=='updateTax')
                    {
                        updateTax();
                    }
                });

            var gridRightProductDeletedTax = colsProductDeletedTax.cells('b').attachGrid();
            gridRightProductDeletedTax.setImagePath("lib/js/imgs/");
            gridRightProductDeletedTax.enableSmartRendering(true);
            gridRightProductDeletedTax.enableMultiselect(false);

            gridRightProductDeletedTax.setHeader("<?php echo _l('ID')?>,<?php echo _l('Name')?>");
            gridRightProductDeletedTax.setColAlign("left,left");
            gridRightProductDeletedTax.setColTypes("ro,ro");
            gridRightProductDeletedTax.setInitWidths("40,");
            gridRightProductDeletedTax.init();

            var xml = '<rows>';
            <?php foreach ($taxes as $id=>$row) {
                ?>
            xml = xml+'<row id="<?php echo $row['id_tax_rules_group'] ?>">';
            xml = xml+'	<cell><![CDATA[<?php echo str_replace("'", "\'", $row['id_tax_rules_group']) ?>]]></cell>';
            xml = xml+'	<cell><![CDATA[<?php echo str_replace("'", "\'", $row['name']) ?>]]></cell>';
            xml = xml+'</row>';
            <?php
            } ?>
            xml = xml+'</rows>';

            gridRightProductDeletedTax.parse(xml);

            function updateTax()
            {
                var ids = gridLeftProductDeletedTax.getSelectedRowId();
                gridLeftProductDeletedTax.selectAll();
                var selectedTax = gridRightProductDeletedTax.getSelectedRowId();
                if(selectedTax==null || selectedTax=="")
                    selectedTax = 0;
                if(ids==null || ids=="")
                    ids = 0;
                if(selectedTax!="0" && ids!="0") {
                    $.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PRODUCT_TAX_DELETED&id_lang="+SC_ID_LANG, { "action": "update_id_tax_rules_group", "ids": ids, "selectedTax" : selectedTax}, function(data){
                        dhxlSCExtCheck.tabbar.tabs("table_CAT_PRODUCT_TAX_DELETED").close();

                        dhxlSCExtCheck.gridChecks.selectRowById('CAT_PRODUCT_TAX_DELETED');
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
        "title"=>_l('Product taxes deleted'),
        "contentJs"=>$content_js
    ));
}
elseif(!empty($post_action) && $post_action=="update_id_tax_rules_group")
{
    $post_ids = Tools::getValue("ids");
    $selectedTax = Tools::getValue("selectedTax");
    if(isset($post_ids))
    {
        $ids = explode(",",$post_ids);
        foreach($ids as $id)
        {
            $sql = "UPDATE "._DB_PREFIX_."product
                    SET id_tax_rules_group = ". (int)$selectedTax ."
                    WHERE id_product = " . (int)$id;

            $res=dbExecuteForeignKeyOff($sql);
        }
    }
}
