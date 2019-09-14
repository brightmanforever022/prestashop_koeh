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
 if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && _r("GRI_CAT_PROPERTIES_GRID_SPECIFIC_PRICE")) { ?>

// INITIALISATION TOOLBAR
prop_tb.attachEvent("onClick", function setPropertiesPanel_combinationmultiproduct(id){
	if (id=='combinationmultiproduct')
	{
	
		prop_tb.combimulprd_subproperties_tb.addListOption('combimulprdSubProperties', 'combimulprd_specificprices', 9, "button", '<?php echo _l('Specific prices',1)?>', "lib/img/text_list_numbers.png");

		prop_tb.combimulprd_subproperties_tb.attachEvent("onClick", function(id){
			if(id=="combimulprd_specificprices")
			{
				hideCombinationMultiProduct_SubpropertiesItems();
				prop_tb.combimulprd_subproperties_tb.setItemText('combimulprdSubProperties', '<?php echo _l('Specific prices',1)?>');
				prop_tb.combimulprd_subproperties_tb.setItemImage('combimulprdSubProperties', 'lib/img/text_list_numbers.png');
				actual_subproperties = "combimulprd_specificprices";
				initCombinationMultiProductSpecificPrices();
			}
		});
				
		prop_tb._combinationmultiproductGrid.attachEvent("onRowSelect", function(id,ind){
			if (!prop_tb._combinationmultiproductLayout.cells('b').isCollapsed())
			{
				if(actual_subproperties == "combimulprd_specificprices"){
			 		getCombinationMultiProductSpecificPrices();
				}
			}
		});
		
		prop_tb.combimulprd_subproperties_tb.addButton('specificprice_refresh',100,'','lib/img/arrow_refresh.png','lib/img/arrow_refresh.png');
		prop_tb.combimulprd_subproperties_tb.setItemToolTip('specificprice_refresh','<?php echo _l('Refresh grid',1)?>');
		prop_tb.combimulprd_subproperties_tb.addButton('specificprice_add',100,'','lib/img/add.png','lib/img/add.png');
		prop_tb.combimulprd_subproperties_tb.setItemToolTip('specificprice_add','<?php echo _l('Create new specific price',1)?>');
		prop_tb.combimulprd_subproperties_tb.addButton('specificprice_del',100,'','lib/img/delete.gif','lib/img/delete.gif');
		prop_tb.combimulprd_subproperties_tb.setItemToolTip('specificprice_del','<?php echo _l('Delete selected item',1)?>');
		prop_tb.combimulprd_subproperties_tb.attachEvent("onClick", function(id){
			if (id=='specificprice_refresh')
			{
				if (lastCombiSelID!=0)
					getCombinationMultiProductSpecificPrices();
			}
			if (id=='specificprice_add')
			{
				if (lastCombiSelID==0){
					alert('<?php echo _l('Please select a combination',1)?>');
				}else{
					var newId = new Date().getTime();
					specificpricesDataProcessorURLBase="index.php?ajax=1&act=cat_combinationmultiproduct_specificprice_update&id_product="+lastProductSelID+"&id_lang="+SC_ID_LANG;
					specificpricesDataProcessor.serverProcessor=specificpricesDataProcessorURLBase;
					specificpricesDataProcessor.enablePartialDataSend(false);
					var maxQuantity=1;
					var maxValue=10;
					var percent='';
					newRow=new Array(newId,prop_tb._combinationmultiproductGrid.getSelectedRowId(),0,<?php echo (SCMS?'0,0,':''); ?> 1, <?php echo (version_compare(_PS_VERSION_, '1.5.0.0', '>=')?-1:0);?>,'','','','','');
					prop_tb._combinationmultiproductSpecificPricesGrid.addRow(newId,newRow);
	
				}
			}
			if (id=='specificprice_del')
			{
				if (prop_tb._combinationmultiproductSpecificPricesGrid.getSelectedRowId()==null)
				{
					alert('<?php echo _l('Please select an item',1)?>');
				}else{
					if (lastCombiSelID!=0)
					{
						if (confirm('<?php echo _l('Are you sure you want to delete the selected items?',1)?>'))
						{
							//prop_tb._combinationmultiproductSpecificPricesGrid.deleteSelectedRows();
							selection=prop_tb._combinationmultiproductSpecificPricesGrid.getSelectedRowId();
							$.post('index.php?ajax=1&act=cat_combinationmultiproduct_specificprice_del',{'rowslist':selection},function(data){
									if (selection!='' && selection!=null)
									{
										getCombinationMultiProductSpecificPrices();
									}
								});
						}
					}else{
						alert('<?php echo _l('Please select a product',1)?>');
					}
				}
			}
		});
	}
});
			
// INIT GRID
clipboardType_CombinationMultiProductSpecificprices = null;
combimulprd_customername = null;
function initCombinationMultiProductSpecificPrices()
{
	hideCombinationMultiProduct_SubpropertiesItems();
	prop_tb.combimulprd_subproperties_tb.showItem('specificprice_refresh');
	prop_tb.combimulprd_subproperties_tb.showItem('specificprice_add');
	prop_tb.combimulprd_subproperties_tb.showItem('specificprice_del');
	
	prop_tb._combinationmultiproductSpecificPricesGrid = prop_tb._combinationmultiproductLayout.cells('b').attachGrid();
	prop_tb._combinationmultiproductSpecificPricesGrid.setImagePath("lib/js/imgs/");
	prop_tb._combinationmultiproductSpecificPricesGrid.setDateFormat("%Y-%m-%d %H:%i:%s","%Y-%m-%d %H:%i:%s");
	
	// UISettings
	prop_tb._combinationmultiproductSpecificPricesGrid._uisettings_prefix='cat_combinationmultiproduct_specificprice';
	prop_tb._combinationmultiproductSpecificPricesGrid._uisettings_name=prop_tb._combinationmultiproductSpecificPricesGrid._uisettings_prefix;
   	prop_tb._combinationmultiproductSpecificPricesGrid._first_loading=1;
   	
	// UISettings
	initGridUISettings(prop_tb._combinationmultiproductSpecificPricesGrid);
	 prop_tb._combinationmultiproductSpecificPricesGrid.enableColumnMove(false);
	
	prop_tb._combinationmultiproductSpecificPricesGrid.attachEvent("onEditCell", function(stage, rId, cIn,nValue,oValue){
			if (stage==1 && this.editor && this.editor.obj) this.editor.obj.select();
            if(stage==2 && nValue!=oValue)
             {
                 // CHECK ID_CUSTOMER
                 if (prop_tb._combinationmultiproductSpecificPricesGrid.getColumnId(cIn) == "id_customer") {
                     var cellValue = prop_tb._combinationmultiproductSpecificPricesGrid.cells(rId,cIn).getValue();
                     var cellValueInt = parseInt(cellValue);
                     if (!Number.isInteger(cellValueInt) && cellValue != 0) {
                         dhtmlx.message({text:'<?php echo _l('This customer in unknown'); ?>',type:'error',expire:3000});
                         return false;
                     }
                 }
     
                 if (combimulprd_customername) {
                     prop_tb._combinationmultiproductSpecificPricesGrid.cells(rId,cIn).setValue(combimulprd_customername);
                     combimulprd_customername = null;
                 }
             }
			return true;
	});
	
	specificpricesDataProcessorURLBase="index.php?ajax=1&act=cat_combinationmultiproduct_specificprice_update&id_product="+lastProductSelID+"&id_product_attribute="+prop_tb._combinationmultiproductGrid.getSelectedRowId()+"&id_lang="+SC_ID_LANG;
	specificpricesDataProcessor = new dataProcessor(specificpricesDataProcessorURLBase);
	specificpricesDataProcessor.enableDataNames(true);
	specificpricesDataProcessor.enablePartialDataSend(true);
	specificpricesDataProcessor.setTransactionMode("POST");
	specificpricesDataProcessor.attachEvent("onAfterUpdate",function(sid,action,tid,xml){
			if (action=='insert')
			{
				specificpricesDataProcessor.enablePartialDataSend(true);
				prop_tb._combinationmultiproductSpecificPricesGrid.cells(tid,0).setValue(tid);
			}
		});
	specificpricesDataProcessorURLBase="index.php?ajax=1&act=cat_combinationmultiproduct_specificprice_update&id_product="+lastProductSelID+"&id_product_attribute="+prop_tb._combinationmultiproductGrid.getSelectedRowId()+"&id_lang="+SC_ID_LANG;
	specificpricesDataProcessor.serverProcessor=specificpricesDataProcessorURLBase;
	specificpricesDataProcessor.init(prop_tb._combinationmultiproductSpecificPricesGrid);
	
	prop_tb._combinationmultiproductSpecificPricesGrid.attachEvent("onDhxCalendarCreated",function(calendar){
		calendar.setSensitiveRange("2012-01-01",null);
	});
			
	// Context menu for grid
	combinationmultiproductspecificprices_cmenu=new dhtmlXMenuObject();
	combinationmultiproductspecificprices_cmenu.renderAsContextMenu();
	function onGridCombinationMultiProductSpecificpricesContextButtonClick(itemId){
		tabId=prop_tb._combinationmultiproductSpecificPricesGrid.contextID.split('_');
		tabId=tabId[0];
		if (itemId=="copy"){
			if (lastColumnRightClicked_CombinationMultiProductSpecificprices!=0)
			{
				clipboardValue_CombinationMultiProductSpecificprices=prop_tb._combinationmultiproductSpecificPricesGrid.cells(tabId,lastColumnRightClicked_CombinationMultiProductSpecificprices).getValue();

                if(lastColumnRightClicked_CombinationMultiProductSpecificprices == prop_tb._combinationmultiproductSpecificPricesGrid.getColIndexById('id_customer'))
                {
                     var mask = prop_tb._combinationmultiproductSpecificPricesGrid.cells(tabId,lastColumnRightClicked_CombinationMultiProductSpecificprices).getValue();
                     $.post('index.php?ajax=1&act=cat_specificprice_customer_get&ajaxCall=1&getIdCus=1',{'mask':mask},function(data)			{
                         var res = JSON.parse(data);
                         clipboardValue_CombinationMultiProductSpecificprices=parseInt(res.id_customer);
                         combimulprd_customername = res.name;
                     });
                 } else {
                    clipboardValue_CombinationMultiProductSpecificprices=prop_tb._combinationmultiproductSpecificPricesGrid.cells(tabId,lastColumnRightClicked_CombinationMultiProductSpecificprices).getValue();
                 }

                 combinationmultiproductspecificprices_cmenu.setItemText('paste' , '<?php echo _l('Paste')?> '+prop_tb._combinationmultiproductSpecificPricesGrid.cells(tabId,lastColumnRightClicked_CombinationMultiProductSpecificprices).getTitle());
				clipboardType_CombinationMultiProductSpecificprices=lastColumnRightClicked_CombinationMultiProductSpecificprices;
			}
		}
		if (itemId=="paste"){
			if (lastColumnRightClicked_CombinationMultiProductSpecificprices!=0 && clipboardValue_CombinationMultiProductSpecificprices!=null && clipboardType_CombinationMultiProductSpecificprices==lastColumnRightClicked_CombinationMultiProductSpecificprices)
			{
				selection=prop_tb._combinationmultiproductSpecificPricesGrid.getSelectedRowId();
				if (selection!='' && selection!=null)
				{
					selArray=selection.split(',');
					for(i=0 ; i < selArray.length ; i++)
					{
						if (prop_tb._combinationmultiproductSpecificPricesGrid.getColumnId(lastColumnRightClicked_CombinationMultiProductSpecificprices).substr(0,5)!='attr_')
						{
							prop_tb._combinationmultiproductSpecificPricesGrid.cells(selArray[i],lastColumnRightClicked_CombinationMultiProductSpecificprices).setValue(clipboardValue_CombinationMultiProductSpecificprices);
							prop_tb._combinationmultiproductSpecificPricesGrid.cells(selArray[i],lastColumnRightClicked_CombinationMultiProductSpecificprices).cell.wasChanged=true;
							specificpricesDataProcessor.setUpdated(selArray[i],true,"updated");
						}
					}
				}
			}
		}
	}
	combinationmultiproductspecificprices_cmenu.attachEvent("onClick", onGridCombinationMultiProductSpecificpricesContextButtonClick);
	var contextMenuXML='<menu absolutePosition="auto" mode="popup" maxItems="8"  globalCss="contextMenu" globalSecondCss="contextMenu" globalTextCss="contextMenuItem">'+
			'<item text="Object" id="object" enabled="false"/>'+
			'<item text="<?php echo _l('Copy')?>" id="copy"/>'+
			'<item text="<?php echo _l('Paste')?>" id="paste"/>'+
		'</menu>';
	combinationmultiproductspecificprices_cmenu.loadStruct(contextMenuXML);
	prop_tb._combinationmultiproductSpecificPricesGrid.enableContextMenu(combinationmultiproductspecificprices_cmenu);

	prop_tb._combinationmultiproductSpecificPricesGrid.attachEvent("onBeforeContextMenu", function(rowid,colidx,grid){
		var disableOnCols=new Array(
				prop_tb._combinationmultiproductSpecificPricesGrid.getColIndexById('id_product_attribute'),
				prop_tb._combinationmultiproductSpecificPricesGrid.getColIndexById('id_specific_price')
				);
		if (in_array(colidx,disableOnCols))
		{
			return false;
		}
		lastColumnRightClicked_CombinationMultiProductSpecificprices=colidx;
		combinationmultiproductspecificprices_cmenu.setItemText('object', '<?php echo _l('Specific price:')?> '+prop_tb._combinationmultiproductSpecificPricesGrid.cells(rowid,prop_tb._combinationmultiproductSpecificPricesGrid.getColIndexById('id_specific_price')).getTitle());
		if (lastColumnRightClicked_CombinationMultiProductSpecificprices==clipboardType_CombinationMultiProductSpecificprices)
		{
			combinationmultiproductspecificprices_cmenu.setItemEnabled('paste');
		}else{
			combinationmultiproductspecificprices_cmenu.setItemDisabled('paste');
		}
		return true;
	});
	
	getCombinationMultiProductSpecificPrices();
}

// DISPLAY
	function getCombinationMultiProductSpecificPrices()
	{
		prop_tb._combinationmultiproductSpecificPricesGrid.clearAll(true);
		$.post("index.php?ajax=1&act=cat_combinationmultiproduct_specificprice_get&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{'id_product_attribute': prop_tb._combinationmultiproductGrid.getSelectedRowId()},function(data)
		{
			prop_tb._combinationmultiproductSpecificPricesGrid.parse(data);
			nb=prop_tb._combinationmultiproductSpecificPricesGrid.getRowsNum();
			prop_tb._sb.setText('');
			
   			// UISettings
			loadGridUISettings(prop_tb._combinationmultiproductSpecificPricesGrid);
			prop_tb._combinationmultiproductSpecificPricesGrid._first_loading=0;
		});
	}

<?php } ?>