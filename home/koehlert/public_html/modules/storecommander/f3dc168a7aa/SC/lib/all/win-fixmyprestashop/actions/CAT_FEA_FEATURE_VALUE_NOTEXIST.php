<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
    $sql = "SELECT id_feature_value, COUNT( id_product ) as NB
    FROM `"._DB_PREFIX_."feature_product`
    WHERE `id_feature_value` NOT IN ( SELECT id_feature_value FROM `"._DB_PREFIX_."feature_value` )
    GROUP BY id_feature_value
    ORDER BY id_feature_value";
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

            var tbFeatureValueNotExist = dhxlSCExtCheck.tabbar.cells("table_CAT_FEA_FEATURE_VALUE_NOTEXIST").attachToolbar();
            tbFeatureValueNotExist.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
            tbFeatureValueNotExist.setItemToolTip('selectall','<?php echo _l('Select all')?>');
            tbFeatureValueNotExist.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
            tbFeatureValueNotExist.setItemToolTip('delete','<?php echo _l('Delete id_feature_value not existing')?>');
            tbFeatureValueNotExist.attachEvent("onClick",
                function(id){
                    if (id=='selectall')
                    {
                        gridFeatureValueNotExist.selectAll();
                    }
                    if (id=='delete')
                    {
                        deleteFeatureValueNotExist();
                    }
                });

            var gridFeatureValueNotExist = dhxlSCExtCheck.tabbar.cells("table_CAT_FEA_FEATURE_VALUE_NOTEXIST").attachGrid();
            gridFeatureValueNotExist.setImagePath("lib/js/imgs/");
            gridFeatureValueNotExist.enableSmartRendering(true);
            gridFeatureValueNotExist.enableMultiselect(true);

            gridFeatureValueNotExist.setHeader("id_feature_value,<?php echo _l('Used')?>");
            gridFeatureValueNotExist.setInitWidths("100,100");
            gridFeatureValueNotExist.setColAlign("left,left");
            gridFeatureValueNotExist.init();

            var xml = '<rows>';
            <?php foreach ($res as $row) {
            ?>
            xml = xml+'   <row id="<?php echo $row["id_feature_value"] ?>">';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["id_feature_value"]; ?>]]></cell>';
            xml = xml+'  	<cell><![CDATA[<?php echo $row["NB"]; ?>]]></cell>';
            xml = xml+'   </row>';
            <?php } ?>
            xml = xml+'</rows>';
            gridFeatureValueNotExist.parse(xml);

            function deleteFeatureValueNotExist()
            {
                var selectedFeatureValueNotExists = gridFeatureValueNotExist.getSelectedRowId();
                if(selectedFeatureValueNotExists==null || selectedFeatureValueNotExists=="")
                    selectedFeatureValueNotExists = 0;
                if(selectedFeatureValueNotExists!="0")
                {
                    $.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CAT_FEA_FEATURE_VALUE_NOTEXIST&id_lang="+SC_ID_LANG, { "action": "delete_feature_value_notexist", "ids": selectedFeatureValueNotExists}, function(data){
                        dhxlSCExtCheck.tabbar.tabs("table_CAT_FEA_FEATURE_VALUE_NOTEXIST").close();

                        dhxlSCExtCheck.gridChecks.selectRowById('CAT_FEA_FEATURE_VALUE_NOTEXIST');
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
        "title"=>_l('Feat. Val. not exist'),
        "contentJs"=>$content_js
    ));
}
elseif(!empty($post_action) && $post_action=="delete_feature_value_notexist")
{
    $post_ids = Tools::getValue("ids");
    if(!empty($post_ids))
    {
        $ids = explode(",", $post_ids);
        foreach($ids as $id)
        {
            if(!empty($id))
            {
                $sql = "DELETE FROM "._DB_PREFIX_."feature_product WHERE id_feature_value='".(int)$id."'";
                dbExecuteForeignKeyOff($sql);
            }
        }
    }
}
