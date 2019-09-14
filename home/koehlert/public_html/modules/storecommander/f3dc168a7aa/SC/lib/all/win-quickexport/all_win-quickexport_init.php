<div id="divQuickExport" style="margin:10px;display:none;"><textarea id="taQuickExport" style="width:400px;height:200px"></textarea></div>
<script type="text/javascript">
    function displayQuickExportWindow(grid,firstline){
        if (!dhxWins.isWindow("wQuickExportWindow"))
        {
            wQuickExportWindow = dhxWins.createWindow("wQuickExportWindow", 50, 50, 450, 460);
            wQuickExportWindow.setIcon('lib/img/page_excel.png','../../../lib/img/page_excel.png');
            wQuickExportWindow.setText("<?php echo _l('Quick export window') ?>");
            lQEW = new dhtmlXLayoutObject(wQuickExportWindow, "1C");
            lQEW.cells('a').hideHeader();
            wQuickExportWindow.attachEvent("onClose", function(win){
                wQuickExportWindow.hide();
                return false;
            });
            lQEW.cells('a').appendObject('divQuickExport');
            $('#divQuickExport').css('display','block');
            wQuickExportWindow._add_prop_tb=wQuickExportWindow.attachToolbar();
            wQuickExportWindow._add_prop_tb.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning_dis.png");
            wQuickExportWindow._add_prop_tb.setItemToolTip('selectall','<?php echo _l('Select all')?>');
            // events
            wQuickExportWindow._add_prop_tb.attachEvent("onClick",function(id){
                if (id=="selectall")
                    $('#taQuickExport').select();
            });
        }else{
            wQuickExportWindow.show();
        }

        var csv = "";
        var filters = new Array();
        var types = new Array();
        var first = 1;

        if(firstline==1)
        {
            var nb_col = grid.getColumnsNum();
            var row = "";
            for (var i=0;i<nb_col;i++)
            {
                if(!grid.isColumnHidden(i))
                {
                    var name = grid.getColLabel(i);
                    if(row!="")
                        row = row + "\t";
                    row = row +name;
                }
            };
            if(row!="")
            {
                row = row + "\n";
                csv = csv + row;
            }
        }

        grid.forEachRowA(function(rId){
            var row = "";
            grid.forEachCell(rId,function(cellObj,ind){
                if(first==1)
                {
                    if(grid.getFilterElement(ind)!=undefined)
                        filters[ind] = grid.getFilterElement(ind).value;
                    else
                        filters[ind] = "";
                    types[ind] = grid.getColType(ind);
                }
                if(!grid.isColumnHidden(ind) && grid.getRowIndex(rId)>=0)
                {
                    if(types[ind]=="coro" || types[ind]=="co")
                        var value = cellObj.getTitle();
                    <?php if(_s("APP_QUICKEXPORT_NUMBER_SEP")=="1") { ?>
                    else if($.isNumeric(cellObj.getValue()))
                        var value = cellObj.getValue().replace(".",",");
                    <?php } ?>else
                        var value = cellObj.getValue();
                    if(row!="")
                        row = row + "\t";
                    row = row +value;
                }
            });
            if(row!="")
            {
                row = row + "\n";
                csv = csv + row;
            }
        });

        $('#taQuickExport').html(csv);
        $('#taQuickExport').select();
    }
</script>