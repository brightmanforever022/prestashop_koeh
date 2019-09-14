<?php
/**
 * Store Commander
 *
 * @category administration
 * @author Store Commander - support@storecommander.com
 * @version 2015-09-15
 * @uses Prestashop modules
 * @since 2009
 * @copyright Copyright &copy; 2009-2015, Store Commander
 * @license commercial
 * All rights reserved! Copying, duplication strictly prohibited
 *
 * *****************************************
 * *           STORE COMMANDER             *
 * *   http://www.StoreCommander.com       *
 * *            V 2015-09-15               *
 * *****************************************
 *
 * Compatibility: PS version: 1.1 to 1.6.1
 *
 **/
if (SCSG)
{
    ?>
    prop_tb.addListOption('panel', 'segments', 5, "button", '<?php echo _l('Segments',1)?>', "lib/img/blue_folder.png");
    allowed_properties_panel[allowed_properties_panel.length] = "segments";

    prop_tb.addButton('segment_refresh',100,'','lib/img/arrow_refresh.png','lib/img/arrow_refresh.png');
    prop_tb.setItemToolTip('segment_refresh','<?php echo _l('Refresh',1)?>');
    prop_tb.addButtonTwoState('segment_filter', 100, "", "lib/img/filter.png", "lib/img/filter.png");
    prop_tb.setItemToolTip('segment_filter','<?php echo _l('Display only segments used by selected product',1)?>');
    prop_tb.addButton('segment_multi_add',100,'','lib/img/chart_organisation_add_v.png','lib/img/chart_organisation_add_v.png');
    prop_tb.setItemToolTip('segment_multi_add','<?php echo _l('Place selected product in selected segments',1)?>');
    prop_tb.addButton('segment_multi_del',100,'','lib/img/chart_organisation_delete_v.png','lib/img/chart_organisation_delete_v.png');
    prop_tb.setItemToolTip('segment_multi_del','<?php echo _l('Remove selected product from selected segments',1)?>');
    prop_tb.addButton('segment_expand',100,'','lib/img/arrow_out.png','lib/img/arrow_out.png');
    prop_tb.setItemToolTip('segment_expand','<?php echo _l('Expand all items',1)?>');
    prop_tb.addButton('segment_collapse',100,'','lib/img/arrow_in.png','lib/img/arrow_in.png');
    prop_tb.setItemToolTip('segment_collapse','<?php echo _l('Collapse all items',1)?>');
    prop_tb.addButton('segment_open',100,'','lib/img/segmentation.png','lib/img/segmentation.png');
    prop_tb.setItemToolTip('segment_open','<?php echo _l('Open segment',1)?>');


    function setPropertiesPanel_segments(id){
        if (id=='segments')
        {
            hidePropTBButtons();
			prop_tb.setItemText('panel', '<?php echo _l('Segments')?>');
			prop_tb.setItemImage('panel', 'lib/img/blue_folder.png');

			hidePropTBButtons();
			prop_tb.showItem('segment_open');
			prop_tb.showItem('segment_filter');
			prop_tb.showItem('segment_expand');
			prop_tb.showItem('segment_collapse');
			prop_tb.showItem('segment_multi_del');
			prop_tb.showItem('segment_multi_add');
			prop_tb.showItem('segment_refresh');
			propertiesPanel='segments';

			prop_tb._segmentsLayout = dhxLayout.cells('b').attachLayout('1C');
			prop_tb._segmentsLayout.cells('a').hideHeader();
			dhxLayout.cells('b').showHeader();
			prop_tb._segmentsGrid = prop_tb._segmentsLayout.cells('a').attachGrid();
			prop_tb._segmentsGrid.setImagePath("lib/js/imgs/");
			prop_tb._segmentsGrid.setFiltrationLevel(-2);
			prop_tb._segmentsGrid.enableTreeCellEdit(0);
			prop_tb._segmentsGrid.enableSmartRendering(true);
			prop_tb._segmentsGrid.enableMultiselect(true);

			prop_tb._segmentsGrid.attachEvent("onEditCell",function(stage,rId,cInd,nValue,oValue)
			{
					idxUsed=prop_tb._segmentsGrid.getColIndexById('present');
					if (cInd == idxUsed){
						if(stage==1)
						{
							var value = prop_tb._segmentsGrid.cellById(rId,idxUsed).getValue();
							$.post("index.php?ajax=1&act=cat_segmentation_update&type=product&id_segment="+rId+"&ids="+cat_grid.getSelectedRowId()+"&action=present&value="+value+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function(data){
								displaySegments();
							});
						}
					}
					return true;
			});

			prop_tb.attachEvent("onStateChange",function(id,state){
				if (id=='segment_filter')
				{
					if (state)
					{
						segmentsFilter=1;
						prop_tb._segmentsGrid.filterTreeBy(0,1,0);
						prop_tb._segmentsGrid.expandAll();
					}else{
						segmentsFilter=0;
						prop_tb._segmentsGrid.filterTreeBy(0,'',0);
					}
				}
			});

			if (lastProductSelID!=0)
			{
				if(prop_tb._segmentsGrid._rowsNum>0)
					displaySegments();
				else
					displaySegments(true);
			}
		}
		if (id=='segment_refresh')
		{
			displaySegments(true);
		}
		if (id=='segment_multi_add')
		{
			if(prop_tb._segmentsGrid.getSelectedRowId()!=null && lastProductSelID!=null)
			{
				var value = 1;
				var segments = prop_tb._segmentsGrid.getSelectedRowId();
				$.post("index.php?ajax=1&act=cat_segmentation_update&type=product&segments="+segments+"&ids="+cat_grid.getSelectedRowId()+"&action=mass_present&value="+value+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function(data){
					displaySegments();
				});
			}
		}
		if (id=='segment_multi_del')
		{
			if(prop_tb._segmentsGrid.getSelectedRowId()!=null && lastProductSelID!=null)
			{
				var value = 0;
				var segments = prop_tb._segmentsGrid.getSelectedRowId();
				$.post("index.php?ajax=1&act=cat_segmentation_update&type=product&segments="+segments+"&ids="+cat_grid.getSelectedRowId()+"&action=mass_present&value="+value+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function(data){
					displaySegments();
				});
			}
		}
		if (id=='segment_expand')
		{
			prop_tb._segmentsGrid.expandAll();
		}
		if (id=='segment_collapse')
		{
			prop_tb._segmentsGrid.collapseAll();
		}
		if (id=='segment_open')
		{
			var tabId = prop_tb._segmentsGrid.getSelectedRowId();
			if(tabId!=undefined && tabId!=null && tabId!=0)
			{
				if (!dhxWins.isWindow("toolsSegmentationWindow"))
				{
					toolsSegmentationWindow = dhxWins.createWindow("toolsSegmentationWindow", 50, 50, $(window).width()-100, $(window).height()-100);
					toolsSegmentationWindow.setIcon('../../../lib/img/segmentation.png','../../../lib/img/segmentation.png');
					toolsSegmentationWindow.setText("Segmentation");
					toolsSegmentationWindow.attachEvent("onClose", function(win){
							toolsSegmentationWindow.hide();
							return false;
						});
					$.get("index.php?ajax=1&act=all_win-segmentation_init&selectedSegmentId="+tabId,function(data){
							$('#jsExecute').html(data);
						});

				}else{
					$.get("index.php?ajax=1&act=all_win-segmentation_init&selectedSegmentId="+tabId,function(data){
							$('#jsExecute').html(data);
						});
					toolsSegmentationWindow.show();
				}
			}
		}
    }
    prop_tb.attachEvent("onClick", setPropertiesPanel_segments);

    var segmentsFilter=0;
    function displaySegments(force_refresh, callback)
    {
        if (prop_tb._segmentsGrid._rowsNum>0 && force_refresh!=true)
        {
            $.post("index.php?ajax=1&act=cat_segmentation_relation_get&type=product&idlist="+lastProductSelID+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function(data){
                selArray=data.split(',');
                prop_tb._segmentsGrid.forEachRow(function(id){
                    var manuel_add = prop_tb._segmentsGrid.getUserData(id,"manuel_add");
                    prop_tb._segmentsGrid.cells(id,0).setDisabled(false);
                    if (in_array(id,selArray) && manuel_add==1)
                    {
                     prop_tb._segmentsGrid.cellById(id,0).setValue(1);
                    }else{
                        prop_tb._segmentsGrid.cellById(id,0).setValue(0);
                    }
                    if (manuel_add!=1)
                        prop_tb._segmentsGrid.cells(id,0).setDisabled(true);
                });
                segment_setNbSelected();
            });
        }
        else if(force_refresh==true)
        {
            if ((cat_grid.getSelectedRowId()==null || cat_grid.getSelectedRowId()=='') && force_refresh!=true) return false;
            prop_tb._segmentsGrid.clearAll(true);
            prop_tb._segmentsGrid.loadXML("index.php?ajax=1&act=cat_segmentation_get&type=catalog&id_lang="+SC_ID_LANG,function()
            {
                nb=prop_tb._segmentsGrid.getRowsNum();
                prop_tb._sb.setText(nb+(nb>1?" <?php echo _l('segments')?>":" <?php echo _l('segment')?>"));
                prop_tb._segmentsGrid._rowsNum=nb;

                prop_tb._segmentsGrid.forEachRow(function(id){
                    var manuel_add = prop_tb._segmentsGrid.getUserData(id,"manuel_add");
                    if (manuel_add==1)
                    {
                        prop_tb._segmentsGrid.cells(id,0).setDisabled(false);
                    }
                    else
                    {
                        prop_tb._segmentsGrid.cells(id,0).setDisabled(true);
                    }
                });


                displaySegments();

                if (callback!='') eval(callback);
            });

        }
    }

    function segment_setNbSelected()
    {
        _segment_setNbSelected("");
    }
    function _segment_setNbSelected(parent_id)
    {
        var nb_count = 0;

        var row_n = prop_tb._segmentsGrid.getSubItems(parent_id);

        if(row_n!=undefined && row_n!=null && row_n!="")
        {
            var rows = row_n.split(",");
            $.each(rows, function(num, id){
                var checked = prop_tb._segmentsGrid.cellById(id,0).getValue();
                if(checked==true)
                {
                    nb_count = nb_count*1 + 1;
                }

                var nb_children = _segment_setNbSelected(id);

                var text_base = prop_tb._segmentsGrid.cellById(id,1).getValue();
                var exp = text_base.split("<strong");
                text_base = exp[0];
                var text = text_base+" <strong>["+nb_children+"]</strong>";
                prop_tb._segmentsGrid.cellById(id,1).setValue(text);

                nb_count = nb_count*1 + nb_children;
            });
        }
        return nb_count;
    }

    cat_grid.attachEvent("onRowSelect",function (idproduct){
        if (propertiesPanel=='segments')
        {
            if (cat_grid.getSelectedRowId()!=null)
            {
                displaySegments(true);
            }
        }
    });

<?php
}
