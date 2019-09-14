<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
    $res =array();
    $sql = "SELECT id_product, position
            FROM "._DB_PREFIX_."image
            ORDER BY `id_product` ASC, `position` ASC";
    $images = Db::getInstance()->ExecuteS($sql);

    $key = 0;
    $id_last_product = 0;
    foreach($images as $k => $image){
        if ($id_last_product != $image['id_product']) {
            $id_last_product = $image['id_product'];
            $key = 1;
        }
        if ($key != $image['position']){
            $res[$k]['id_product'] = $image['id_product'];
        }
        $key++;
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

            var tbImagePositionOrder = dhxlSCExtCheck.tabbar.cells("table_CAT_PRODUCT_IMG_POSITIONS").attachToolbar();
            tbImagePositionOrder.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
            tbImagePositionOrder.setItemToolTip('selectall','<?php echo _l('Select all')?>');
            tbImagePositionOrder.addButton("reorderImagesPositions", 0, "", "lib/img/cog_go.png", "lib/img/cog_go.png");
            tbImagePositionOrder.setItemToolTip('reorderImagesPositions','<?php echo _l('Reorder images positions',1)?>');
            tbImagePositionOrder.attachEvent("onClick",
                function(id){
                    if (id=='selectall')
                    {
                        gridImagePositionOrder.selectAll();
                    }
                    if (id=='reorderImagesPositions')
                    {
                        reorderImagesPositions()
                    }
                });

            var gridImagePositionOrder = dhxlSCExtCheck.tabbar.cells("table_CAT_PRODUCT_IMG_POSITIONS").attachGrid();
            gridImagePositionOrder.setImagePath("lib/js/imgs/");
            gridImagePositionOrder.enableSmartRendering(false);
            gridImagePositionOrder.enableMultiselect(true);

            gridImagePositionOrder.setHeader("ID <?php echo _l('product')?>");
            gridImagePositionOrder.setInitWidths("100");
            gridImagePositionOrder.setColAlign("left");
            gridImagePositionOrder.init();

            var xml = '<rows>';
            <?php foreach ($res as $i => $row) {
            ?>
            xml = xml+'   <row id="<?php echo $row["id_product"]; ?>">';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["id_product"] ?>]]></cell>';
            xml = xml+'   </row>';
            <?php } ?>
            xml = xml+'</rows>';
            gridImagePositionOrder.parse(xml);

            dhxlSCExtCheck.tabbar.cells("table_CAT_PRODUCT_IMG_POSITIONS").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

            function reorderImagesPositions()
            {
                var selectedImagePositions = gridImagePositionOrder.getSelectedRowId();
                if(selectedImagePositions==null || selectedImagePositions=="")
                    selectedImagePositions = 0;
                if(selectedImagePositions!="0")
                {
                    $.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_PRODUCT_IMG_POSITIONS&id_lang="+SC_ID_LANG, { "action": "reorder_image_position", "ids": selectedImagePositions}, function(data){
                        dhxlSCExtCheck.tabbar.tabs("table_CAT_PRODUCT_IMG_POSITIONS").close();

                        dhxlSCExtCheck.gridChecks.selectRowById('CAT_PRODUCT_IMG_POSITIONS');
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
        "title"=>_l('Image position'),
        "contentJs"=>$content_js
    ));
}
elseif(!empty($post_action) && $post_action=="reorder_image_position")
{
    $post_ids = Tools::getValue("ids");
    if(!empty($post_ids))
    {
        $ids = explode(",",$post_ids);
        foreach($ids as $id_product)
        {
            $sql = "SELECT id_image
            FROM "._DB_PREFIX_."image      
            WHERE id_product = " . (int)$id_product . "
            ORDER BY `position` ASC, `id_image` ASC";
            $images = Db::getInstance()->ExecuteS($sql);

            $newPosition = 1;
            $sql ='';
            foreach($images as $image){
                $sql .= "UPDATE "._DB_PREFIX_."image 
                        SET position = " . (int)$newPosition ."
                        WHERE id_image = " . (int)$image['id_image'] . ";";
                $newPosition++;
            }
            $res=dbExecuteForeignKeyOff($sql);
        }
    }
}
