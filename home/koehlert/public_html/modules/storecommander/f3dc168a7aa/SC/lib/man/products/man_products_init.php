
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
if(_r("GRI_MAN_PROPERTIES_PRODUCTS")) { ?>
    prop_tb.addListOption('panel', 'products', 3, "button", '<?php echo _l('Products',1)?>', "lib/img/tree_id_categ_default.png");
    allowed_properties_panel[allowed_properties_panel.length] = "products";
<?php } ?>

    prop_tb.addButtonTwoState("products_without_man", 100, "", "lib/img/filter_show.png", "lib/img/filter_show.png");
    prop_tb.setItemToolTip('products_without_man','<?php echo _l('If enabled: show products without manufacturer',1)?>');
    prop_tb.addButton("products_refresh", 100, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
    prop_tb.setItemToolTip('products_refresh','<?php echo _l('Refresh grid',1)?>');
    prop_tb.addButton("products_add", 100, "", "lib/img/chart_organisation_add_v.png", "lib/img/chart_organisation_add_v.png");
    prop_tb.setItemToolTip('products_add','<?php echo _l('Add selected products to a manufacturer',1)?>');
    prop_tb.addButton('products_del',100,'','lib/img/chart_organisation_delete_v.png','lib/img/chart_organisation_delete_v.png');
    prop_tb.setItemToolTip('products_del','<?php echo _l('Remove manufacturers from selected products',1)?>');
    prop_tb.addButton("products_selectall", 100, "", "lib/img/application_lightning.png", "lib/img/chart_organisation_delete_v.png");
    prop_tb.setItemToolTip('products_selectall','<?php echo _l('Select all products',1)?>');
    prop_tb.addButton("gotocatalog", 101, "", "lib/img/table_go.png", "lib/img/table_go.png");
    prop_tb.setItemToolTip('gotocatalog','<?php echo _l('Go to the product in catalog.')?>');
    prop_tb.addButton("combi_exportcsv", 100, "", "lib/img/page_excel.png", "lib/img/page_excel.png");
	prop_tb.setItemToolTip('combi_exportcsv','<?php echo _l('Export grid to clipboard in CSV format for MSExcel with tab delimiter.',1)?>');

	prop_tb._productsUploadWindow=new Array();


    var products_without_man = 0;

	clipboardType_Products = null;
	needInitProducts = 1;
	function initProducts(){
		if (needInitProducts)
		{
			prop_tb._productsLayout = dhxLayout.cells('b').attachLayout('1C');
			prop_tb._productsLayout.cells('a').hideHeader();
			dhxLayout.cells('b').showHeader();
			prop_tb._productsGrid = prop_tb._productsLayout.cells('a').attachGrid();
			prop_tb._productsGrid.setImagePath("lib/js/imgs/");
			prop_tb._productsGrid.enableDragAndDrop(true);
			prop_tb._productsGrid.setDragBehavior('child');
			prop_tb._productsGrid.enableMultiselect(true);

			// UISettings
			prop_tb._productsGrid._uisettings_prefix='man_product';
			prop_tb._productsGrid._uisettings_name=prop_tb._productsGrid._uisettings_prefix;
		   	prop_tb._productsGrid._first_loading=1;

			// UISettings
			initGridUISettings(prop_tb._productsGrid);

			prop_tb._productsGrid.attachEvent("onEditCell",onEditCellProduct);
			needInitProducts=0;
		}
	}

    function addManufacturerProductsInQueue(rId, action, cIn, vars)
	{
		var params = {
			name: "man_products_update_queue",
			row: rId,
			action: action,
			params: {},
			callback: "callbackManufacturerProductsUpdate('"+rId+"','"+action+"','"+rId+"',{data});"
		};

		// COLUMN VALUES
		if(cIn!=undefined && cIn!="" && cIn!=null && cIn!=0) {
            params.params[prop_tb._productsGrid.getColumnId(cIn)] = prop_tb._productsGrid.cells(rId,cIn).getValue();
        }
		if(vars!=undefined && vars!=null && vars!="" && vars!=0){
			$.each(vars, function(key, value){
				params.params[key] = value;
			});
		}

		params.params = JSON.stringify(params.params);
		addInUpdateQueue(params,prop_tb._productsGrid);
	}

    function onEditCellProduct(stage,rId,cInd,nValue,oValue){
        idxManufacturer=prop_tb._productsGrid.getColIndexById('id_manufacturer');
        if (cInd == idxManufacturer){
            if(stage==2)
            {
                if (nValue!=oValue){
                    addManufacturerProductsInQueue(rId, "update", cInd);
                    return true;
                }
            }
        }
    }

	function setPropertiesPanel_products(id){
		if (id=='products')
		{
			if(last_manufacturerID!=undefined && last_manufacturerID!="")
			{
				idxProductName=man_grid.getColIndexById('name');
				dhxLayout.cells('b').setText('<?php echo _l('Properties',1).' '._l('of',1)?> '+man_grid.cells(last_manufacturerID,idxProductName).getValue());
			}
			hidePropTBButtons();
			prop_tb.showItem('products_selectall');
			prop_tb.showItem('products_add');
			prop_tb.showItem('products_del');
			prop_tb.showItem('products_refresh');
			prop_tb.showItem('products_without_man');
			prop_tb.showItem('gotocatalog');
			prop_tb.showItem('combi_exportcsv');
			prop_tb.setItemText('panel', '<?php echo _l('Products',1)?>');
			prop_tb.setItemImage('panel', 'lib/img/tree_id_categ_default.png');
			needInitProducts=1;
			initProducts();
			propertiesPanel='products';
			if (last_manufacturerID!=0)
			{
				displayProducts();
			}
		}
		if (id=='products_refresh'){
			displayProducts();
		}
		if (id=='products_selectall'){
			prop_tb._productsGrid.selectAll();
		}
		if (id=='products_add'){
		    idxManufacturer=prop_tb._productsGrid.getColIndexById('id_manufacturer');
		    nValue = man_grid.getSelectedRowId();
		    if(nValue.indexOf(",") !== -1){
		        alert('<?php echo _l('Please select only one manufacturer',1)?>')
            } else {
                selection = prop_tb._productsGrid.getSelectedRowId();
                selArray=selection.split(',');
                for(i=0 ; i < selArray.length ; i++)
                {
                    prop_tb._productsGrid.cells(selArray[i],idxManufacturer).setValue(nValue);
                    onEditCellProduct(2,selArray[i],idxManufacturer,nValue,null);
                }
            }
		}
		if (id=='products_del'){
		    idxManufacturer=prop_tb._productsGrid.getColIndexById('id_manufacturer');
            selection = prop_tb._productsGrid.getSelectedRowId();
            selArray=selection.split(',');
            for(i=0 ; i < selArray.length ; i++)
            {
                prop_tb._productsGrid.cells(selArray[i],idxManufacturer).setValue(0);
                onEditCellProduct(2,selArray[i],idxManufacturer,0,null);
            }
		}
        if(id=='gotocatalog')
		{
			selection=prop_tb._productsGrid.getSelectedRowId();
			if (selection!='' && selection!=null)
			{
				var rowIds = selection.split(",");
				var rowId = rowIds[0];

				var open_cat_grid_ids  = prop_tb._productsGrid.getUserData(rowId, "open_cat_grid");
				if (open_cat_grid_ids!='' && open_cat_grid_ids!=null)
				{
					var url = "?page=cat_tree&open_cat_grid="+open_cat_grid_ids;
					window.open(url,'_blank');
				}
			}
		}
        if (id=='combi_exportcsv'){
			displayQuickExportWindow(prop_tb._productsGrid,1);
		}
	}
	prop_tb.attachEvent("onClick", setPropertiesPanel_products);

    prop_tb.attachEvent("onStateChange", function(id,state){
        if (id=="products_without_man") {
            if(state) {
                products_without_man=1;
            } else {
                products_without_man=0;
            }
            displayProducts();
        }
    });



function displayProducts(callback)
{
	prop_tb._productsGrid.clearAll(true);
	prop_tb._productsGrid.load("index.php?ajax=1&act=man_products_get&id_manufacturer="+man_grid.getSelectedRowId()+"&id_shop="+shopselection+"&products_without_man="+products_without_man+"&id_lang="+SC_ID_LANG,function()
    {
        nb=prop_tb._productsGrid.getRowsNum();
        prop_tb._sb.setText(nb+(nb>1?" <?php echo _l('products')?>":" <?php echo _l('product')?>"));

        // UISettings
        loadGridUISettings(prop_tb._productsGrid);
        prop_tb._productsGrid._first_loading=0;

        if (callback!='') eval(callback);
    });
}

// CALLBACK FUNCTION
function callbackManufacturerProductsUpdate(sid,action,tid)
{
	if (action=='update')
	{
		prop_tb._productsGrid.setRowTextNormal(sid);
	}
    initProducts();
    displayProducts();
}


man_grid.attachEvent("onRowSelect",function (idproduct){
    if (propertiesPanel=='products'){
        initProducts();
        displayProducts();
    }
});
