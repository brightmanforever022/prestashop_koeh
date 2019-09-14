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
if(SCMS) {
?>
// INITIALISATION TOOLBAR
wAttributes.tbAttr.addListOption('win_attr_prop_subproperties', 'win_attr_prop_shopshare', 3, "button", '<?php echo _l('Multistore sharing manager',1)?>', "lib/img/sitemap_color.png");

wAttributes.tbAttr.attachEvent("onClick", function(id){
	if(id=="win_attr_prop_shopshare")
	{
		hideWinAttributeSubpropertiesItems();
		wAttributes.tbAttr.setItemText('win_attr_prop_subproperties', '<?php echo _l('Multistore sharing manager',1)?>');
		wAttributes.tbAttr.setItemImage('win_attr_prop_subproperties', 'lib/img/sitemap_color.png');
		actual_winattribute_subproperties = "win_attr_prop_shopshare";
        initWinAttributePropShopShare();
	}
});
wAttributes.gridGroups.attachEvent("onRowSelect", function(id,ind){
	if (!dhxlAttributes.cells('b').isCollapsed())
	{
		if(actual_winattribute_subproperties == "win_attr_prop_shopshare"){
	 		getWinAttributePropShopShare();
		}
	}
});

wAttributes.tbAttr.addButton('win_attribute_prop_shopshare_refresh',100,'','lib/img/arrow_refresh.png','lib/img/arrow_refresh.png');
wAttributes.tbAttr.setItemToolTip('win_attribute_prop_shopshare_refresh','<?php echo _l('Refresh grid',1)?>');
wAttributes.tbAttr.addButton("win_attribute_prop_shopshare_add_select", 100, "", "lib/img/chart_organisation_add_v.png", "lib/img/chart_organisation_add_v.png");
wAttributes.tbAttr.setItemToolTip('win_attribute_prop_shopshare_add_select','<?php echo _l('Add all selected categories to all selected shops',1)?>');
wAttributes.tbAttr.addButton("win_attribute_prop_shopshare_del_select", 100, "", "lib/img/chart_organisation_delete_v.png", "lib/img/chart_organisation_delete_v.png");
wAttributes.tbAttr.setItemToolTip('win_attribute_prop_shopshare_del_select','<?php echo _l('Delete all selected categories from all selected shops',1)?>');
hideWinAttributeSubpropertiesItems();

wAttributes.tbAttr.attachEvent("onClick", function(id){
	if (id=='win_attribute_prop_shopshare_refresh')
	{
		getWinAttributePropShopShare();
	}
	if (id=='win_attribute_prop_shopshare_add_select')
	{
		$.post("index.php?ajax=1&act=cat_win-attribute_shopshare_update&action=mass_present&value=true&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"idlist":wAttributes.gridGroups.getSelectedRowId(),"id_shop":win_attribute_prop_shopshare_grid.getSelectedRowId()},function(data){
			getWinAttributePropShopShare();
		});
	}
	if (id=='win_attribute_prop_shopshare_del_select')
	{
		$.post("index.php?ajax=1&act=cat_win-attribute_shopshare_update&action=mass_present&value=false&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"idlist":wAttributes.gridGroups.getSelectedRowId(),"id_shop":win_attribute_prop_shopshare_grid.getSelectedRowId()},function(data){
            getWinAttributePropShopShare();
		});
	}
});

// FUNCTIONS
var win_attribute_prop_shopshare = null;
function initWinAttributePropShopShare()
{
	wAttributes.tbAttr.showItem('win_attribute_prop_shopshare_refresh');
	wAttributes.tbAttr.showItem('win_attribute_prop_shopshare_add_select');
	wAttributes.tbAttr.showItem('win_attribute_prop_shopshare_del_select');

	win_attribute_prop_shopshare = dhxlAttributes.cells('b').attachLayout("1C");
	dhxlAttributes.cells('b').showHeader();

	// GRID
    win_attribute_prop_shopshare.cells('a').hideHeader();

    win_attribute_prop_shopshare_grid = win_attribute_prop_shopshare.cells('a').attachGrid();
    win_attribute_prop_shopshare_grid.setImagePath("lib/js/imgs/");
    win_attribute_prop_shopshare_grid.enableDragAndDrop(false);
    win_attribute_prop_shopshare_grid.enableMultiselect(true);

    // UISettings
    win_attribute_prop_shopshare_grid._uisettings_prefix='win_attribute_prop_shopshare_grid';
    win_attribute_prop_shopshare_grid._uisettings_name=win_attribute_prop_shopshare_grid._uisettings_prefix;
    win_attribute_prop_shopshare_grid._first_loading=1;

    // UISettings
    initGridUISettings(win_attribute_prop_shopshare_grid);

    getWinAttributePropShopShare();

    win_attribute_prop_shopshare_grid.attachEvent("onEditCell",function(stage,rId,cInd,nValue,oValue)
    {
        if(stage==1)
        {
            idxPresent=win_attribute_prop_shopshare_grid.getColIndexById('present');

            var action = "";
            if(cInd==idxPresent)
                action = "present";

            if(action!="")
            {
                var value = win_attribute_prop_shopshare_grid.cells(rId,cInd).isChecked();
                $.post("index.php?ajax=1&act=cat_win-attribute_shopshare_update&id_shop="+rId+"&action="+action+"&value="+value+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"idlist":wAttributes.gridGroups.getSelectedRowId()},function(data){
                    getWinAttributePropShopShare();
                });
            }
        }
        return true;
    });
}

function getWinAttributePropShopShare()
{
	win_attribute_prop_shopshare_grid.clearAll(true);
    var tempIdList = (wAttributes.gridGroups.getSelectedRowId()!=null?wAttributes.gridGroups.getSelectedRowId():"");
    $.post("index.php?ajax=1&act=cat_win-attribute_shopshare_get&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{'idlist': tempIdList},function(data)
    {
        win_attribute_prop_shopshare_grid.parse(data);
        // UISettings
        loadGridUISettings(win_attribute_prop_shopshare_grid);
        win_attribute_prop_shopshare_grid._first_loading=0;
    });
}
<?php } ?>