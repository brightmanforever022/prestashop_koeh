// INITIALISATION TOOLBAR
ord_wincartrules_prop_tb.addListOption('ord_prop_subproperties', 'ord_prop_orderdetail', 4, "button", '<?php
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
 echo _l('Orders detail',1)?>', "lib/img/cart.png");

ord_wincartrules_prop_tb.attachEvent("onClick", function(id){
	if(id=="ord_prop_orderdetail")
	{
		hideCartRulesSubpropertiesItems();
		ord_wincartrules_prop_tb.setItemText('ord_prop_subproperties', '<?php echo _l('Orders detail',1)?>');
		ord_wincartrules_prop_tb.setItemImage('ord_prop_subproperties', 'lib/img/cart.png');
		actual_wincartrules_subproperties = "ord_prop_orderdetail";
        initOrdOrderDetailProp();
	}
});

ord_wincartrules_prop_tb.addButton('ord_prop_orderdetail_refresh',100,'','lib/img/arrow_refresh.png','lib/img/arrow_refresh.png');
ord_wincartrules_prop_tb.setItemToolTip('ord_prop_orderdetail_refresh','<?php echo _l('Refresh grid',1)?>');
ord_wincartrules_prop_tb.addButton("exportcsv", 100, "", "lib/img/page_excel.png", "lib/img/page_excel.png");
ord_wincartrules_prop_tb.setItemToolTip('exportcsv','<?php echo _l('Export grid to clipboard in CSV format for MSExcel with tab delimiter.')?>');
hideCartRulesSubpropertiesItems();

ord_wincartrules_prop_tb.attachEvent("onClick", function(id)
{
    if (id=='ord_prop_orderdetail_refresh')
    {
        getOrdOrderDetailProp();
    }
    if (id=='exportcsv'){
        displayQuickExportWindow(ord_prop_orderdetail_grid,1);
    }
});

// FUNCTIONS
cartrules_grid.attachEvent("onRowSelect",function (id_cart_rule)
{
    if (!dhxlCartRules_prop.isCollapsed())
    {
        if(actual_wincartrules_subproperties == "ord_prop_orderdetail") {
            lastCartRuleSelected = id_cart_rule;
            getOrdOrderDetailProp();
        }
    }
});

var ord_prop_orderdetail = null;
function initOrdOrderDetailProp()
{
	ord_wincartrules_prop_tb.showItem('ord_prop_orderdetail_refresh');
	ord_wincartrules_prop_tb.showItem('exportcsv');
	ord_prop_orderdetail = dhxlCartRules.cells('b').attachLayout("1C");
	dhxlCartRules.cells('b').showHeader();
	
	// GRID
    ord_prop_orderdetail.cells('a').hideHeader();

    ord_prop_orderdetail_grid = ord_prop_orderdetail.cells('a').attachGrid();
    ord_prop_orderdetail_grid.setImagePath("lib/js/imgs/");
    ord_prop_orderdetail_grid.enableDragAndDrop(false);
    ord_prop_orderdetail_grid.enableMultiselect(true);

    // UISettings
    ord_prop_orderdetail_grid._uisettings_prefix='ord_prop_orderdetail_grid';
    ord_prop_orderdetail_grid._uisettings_name=ord_prop_orderdetail_grid._uisettings_prefix;
    ord_prop_orderdetail_grid._first_loading=1;

    // UISettings
    initGridUISettings(ord_prop_orderdetail_grid);

    getOrdOrderDetailProp();
}

function getOrdOrderDetailProp()
{
	ord_prop_orderdetail_grid.clearAll(true);
    var selected_cart_rules = cartrules_grid.getSelectedRowId();
    ord_prop_orderdetail_grid.load("index.php?ajax=1&act=ord_win-cartrules_orderdetail_get&ids="+selected_cart_rules+"&id_lang="+SC_ID_LANG,function()
    {
        // UISettings
        loadGridUISettings(ord_prop_orderdetail_grid);
        ord_prop_orderdetail_grid._first_loading=0;
    });
}