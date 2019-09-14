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
 
	if(_r("GRI_ORD_PROPERTIES_GRID_ORDERS")) 
	{
?>
	prop_tb.addListOption('panel', 'orderorders', 1, "button", '<?php echo _l('Orders and products',1)?>', "lib/img/cart.png");
	allowed_properties_panel[allowed_properties_panel.length] = "orderorders";

	prop_tb.addButton("orderorders_refresh", 100, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
	prop_tb.setItemToolTip('orderorders_refresh','<?php echo _l('Refresh grid',1)?>');
    prop_tb.addButton("orderorders_selectall", 100, "", "lib/img/application_lightning.png", "lib/img/application_lightning_dis.png");
    prop_tb.setItemToolTip('orderorders_selectall','<?php echo _l('Select all',1)?>');
    prop_tb.addButton("orderorders_gotoorder", 100, "", "lib/img/table_go.png", "lib/img/table_go.png");
    prop_tb.setItemToolTip('orderorders_gotoorder','<?php echo _l('Go to the order')?>');
    prop_tb.addButton("orderorders_exportcsv", 100, "", "lib/img/page_excel.png", "lib/img/page_excel.png");
    prop_tb.setItemToolTip('orderorders_exportcsv','<?php echo _l('Export grid to clipboard in CSV format for MSExcel with tab delimiter.')?>');


    var lastOrderPropSelID = 0;
	needinitOrderOrders = 1;
	function initOrderOrders(){
		if (needinitOrderOrders)
		{
			prop_tb._orderOrdersLayout = dhxLayout.cells('b').attachLayout('2E');
			prop_tb._orderOrdersLayout.cells('a').hideHeader();
			dhxLayout.cells('b').showHeader();
			prop_tb._orderOrdersGrid = prop_tb._orderOrdersLayout.cells('a').attachGrid();
			prop_tb._orderOrdersGrid.setImagePath("lib/js/imgs/");
			prop_tb._orderOrdersGrid.enableMultiselect(true);
			
			// UISettings
			prop_tb._orderOrdersGrid._uisettings_prefix='ord_orders';
			prop_tb._orderOrdersGrid._uisettings_name=prop_tb._orderOrdersGrid._uisettings_prefix;
		   	prop_tb._orderOrdersGrid._first_loading=1;
		   	
			// UISettings
			initGridUISettings(prop_tb._orderOrdersGrid);
			
			prop_tb._orderOrdersGrid.attachEvent("onRowSelect",function (idorder){
				if (propertiesPanel=='orderorders' && !dhxLayout.cells('b').isCollapsed()){
                    lastOrderPropSelID = idorder;
					displayOrderOrdersProducts();
				}
			});
			
			prop_tb._orderOrdersLayout.cells('b').setText('<?php echo _l('Products',1)?>');
            prop_tb._orderProductGrid_TB = prop_tb._orderOrdersLayout.cells('b').attachToolbar();
			prop_tb._orderProductGrid = prop_tb._orderOrdersLayout.cells('b').attachGrid();
			prop_tb._orderProductGrid.setImagePath("lib/js/imgs/");
            prop_tb._orderProductGrid.enableMultiselect(false);

            prop_tb._orderProductGrid_TB.addButton("orderordersProducts_refresh", 100, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
            prop_tb._orderProductGrid_TB.setItemToolTip('orderordersProducts_refresh','<?php echo _l('Refresh grid',1)?>');
            prop_tb._orderProductGrid_TB.addButton("orderordersProducts_exportcsv", 100, "", "lib/img/page_excel.png", "lib/img/page_excel.png");
            prop_tb._orderProductGrid_TB.setItemToolTip('orderordersProducts_exportcsv','<?php echo _l('Export grid to clipboard in CSV format for MSExcel with tab delimiter.')?>');
            prop_tb._orderProductGrid_TB.addButton("orderordersProducts_gotoproduct", 100, "", "lib/img/table_go.png", "lib/img/table_go.png");
            prop_tb._orderProductGrid_TB.setItemToolTip('orderordersProducts_gotoproduct','<?php echo _l('Go to the product in catalog.')?>');

            prop_tb._orderProductGrid_TB.attachEvent("onClick", setPropertiesPanel_orderOrdersProducts);

			
			// UISettings
			prop_tb._orderProductGrid._uisettings_prefix='ord_orders_products';
			prop_tb._orderProductGrid._uisettings_name=prop_tb._orderProductGrid._uisettings_prefix;
		   	prop_tb._orderProductGrid._first_loading=1;
		   	
			// UISettings
			initGridUISettings(prop_tb._orderProductGrid);
			
			needinitOrderOrders=0;
		}
	}


	function setPropertiesPanel_orderOrders(id){
		if (id=='orderorders')
		{
            if(lastOrderSelID!=undefined && lastOrderSelID!="")
            {
                var rowId = ord_grid.getSelectedRowId();
                idxCustomer=ord_grid.getColIndexById('id_customer');
                dhxLayout.cells('b').setText('<?php echo _l('Properties',1).' '._l('of',1).' '._l('customer',1)?> '+ord_grid.cells(rowId,idxCustomer).getValue());
            }
			hidePropTBButtons();
			prop_tb.showItem('orderorders_refresh');
			prop_tb.showItem('orderorders_gotoorder');
			prop_tb.showItem('orderorders_selectall');
			prop_tb.showItem('orderorders_exportcsv');
			prop_tb.setItemText('panel', '<?php echo _l('Orders and products',1)?>');
			prop_tb.setItemImage('panel', 'lib/img/cart.png');
			needinitOrderOrders = 1;
			initOrderOrders();
			propertiesPanel='orderorders';
			if (lastOrderSelID!=0)
			{
				displayOrderOrders();
			}
		}
		if (id=='orderorders_refresh')
		{
			displayOrderOrders();
			prop_tb._orderProductGrid.clearAll(true);
		}
		if (id=='orderorders_gotoorder')
		{
            if(lastOrderPropSelID!=undefined && lastOrderPropSelID!="")
            {
                for(var i=0,l=ord_grid.getColumnsNum();i<l;i++)
                {
                    if (ord_grid.getFilterElement(i)!=null) ord_grid.getFilterElement(i).value="";
                }

                idxIdOrder = ord_grid.getColIndexById("id_order");
                ord_grid.getFilterElement(idxIdOrder).value=lastOrderPropSelID;

                ord_grid.filterByAll();
            }
        }
        if (id=='orderorders_selectall'){
            prop_tb._orderOrdersGrid.selectAll();
            displayOrderOrdersProducts();
            prop_tb._orderProductGrid.clearAll(true);
        }
        if (id=='orderorders_exportcsv'){
            displayQuickExportWindow(prop_tb._orderOrdersGrid,1);
        }

	}
	prop_tb.attachEvent("onClick", setPropertiesPanel_orderOrders);

	function setPropertiesPanel_orderOrdersProducts(id){
		if (id=='orderordersProducts_refresh')
		{
            displayOrderOrdersProducts();
			prop_tb._orderProductGrid.clearAll(true);
		}
		if (id=='orderordersProducts_gotoproduct')
		{
            var id = prop_tb._orderProductGrid.getSelectedRowId();
            if(id!=undefined && id!=null && id!=0 && id!='')
            {
                var path = prop_tb._orderProductGrid.getUserData(id, "path_pdt");
                let url = "?page=cat_tree&open_cat_grid="+path;
                window.open(url,'_blank');
            }
		}
        if (id=='orderordersProducts_exportcsv'){
            displayQuickExportWindow(prop_tb._orderProductGrid,1);
        }
	}

	function displayOrderOrders()
	{
		var customers_id = "";
		idxIdCustomer=ord_grid.getColIndexById('id_customer');
		$.each( ord_grid.getSelectedRowId().split(','), function( num, rowid ) {
			if(customers_id!="")
				customers_id = customers_id+",";
			customers_id = customers_id+ord_grid.cells(rowid,idxIdCustomer).getValue();
		});
		prop_tb._orderOrdersGrid.clearAll(true);
		prop_tb._orderOrdersGrid.load("index.php?ajax=1&act=ord_orders_get&id_customer="+customers_id+"&id_lang="+SC_ID_LANG,function()
		{
			nb=prop_tb._orderOrdersGrid.getRowsNum();
			prop_tb._sb.setText('');
				
            // UISettings
            loadGridUISettings(prop_tb._orderOrdersGrid);

            // UISettings
            prop_tb._orderOrdersGrid._first_loading=0;

            if(lastOrderSelID!=undefined && lastOrderSelID!=null && lastOrderSelID!="" && lastOrderSelID!=0)
            {
                prop_tb._orderOrdersGrid.setRowColor(lastOrderSelID,"e2c7d4");
            }
		});
	}

	function displayOrderOrdersProducts()
	{
		prop_tb._orderProductGrid.clearAll(true);
		prop_tb._orderProductGrid.load("index.php?ajax=1&act=ord_orders_products_get&id_order="+prop_tb._orderOrdersGrid.getSelectedRowId()+"&id_lang="+SC_ID_LANG,function()
		{
			nb=prop_tb._orderProductGrid.getRowsNum();
			prop_tb._sb.setText('');
				
            // UISettings
            loadGridUISettings(prop_tb._orderProductGrid);

            // UISettings
            prop_tb._orderProductGrid._first_loading=0;
		});
	}

	ord_grid.attachEvent("onRowSelect",function (){
			if (propertiesPanel=='orderorders' && !dhxLayout.cells('b').isCollapsed()){
				displayOrderOrders();
                if(lastOrderSelID!=undefined && lastOrderSelID!="")
                {
                    var rowId = ord_grid.getSelectedRowId();
                    idxCustomer=ord_grid.getColIndexById('id_customer');
                    dhxLayout.cells('b').setText('<?php echo _l('Properties',1).' '._l('of',1).' '._l('customer',1)?> '+ord_grid.cells(rowId,idxCustomer).getValue());
                }
			}
		});

<?php
	} // end permission
?>