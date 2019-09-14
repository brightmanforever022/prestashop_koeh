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
?>
    <?php if(_r("GRI_CAT_PROPERTIES_GRID_SEO")) { ?>
	prop_tb.addListOption('panel', 'pdtseo', 15, "button", '<?php echo _l('SEO',1)?>', "lib/img/description.png");
	allowed_properties_panel[allowed_properties_panel.length] = "pdtseo";
    <?php } ?>

	clipboardType_PdtSeo = null;	
	needInitPdtSeo = 1;
	function initPdtSeo()
	{
		if (needInitPdtSeo)
		{
			prop_tb._PdtSeoLayout = dhxLayout.cells('b').attachLayout('2E');
			dhxLayout.cells('b').showHeader();
			
			// SEO
			prop_tb._pdtSeo = prop_tb._PdtSeoLayout.cells('a');
			prop_tb._pdtSeo.setText('<?php echo _l('SEO',1)?>');
			
			prop_tb._pdtSeo_tb = prop_tb._pdtSeo.attachToolbar();
			prop_tb._pdtSeo_tb.addButton("PdtSeo_refresh", 100, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
			prop_tb._pdtSeo_tb.setItemToolTip('PdtSeo_refresh','<?php echo _l('Refresh grid',1)?>');
			prop_tb._pdtSeo_tb.addButton("exportcsv", 100, "", "lib/img/page_excel.png", "lib/img/page_excel.png");
			prop_tb._pdtSeo_tb.setItemToolTip('exportcsv','<?php echo _l('Export grid to clipboard in CSV format for MSExcel with tab delimiter.')?>');
			prop_tb._pdtSeo_tb.addButton("go_to_settings", 100, "", "lib/img/cog_edit.png", "lib/img/cog_edit.png");
			prop_tb._pdtSeo_tb.setItemToolTip('go_to_settings','<?php echo _l('Open settings')?>');

            let opts = [
                ['copy_mt', 'obj', 'META title', ''],
                ['copy_mtmd', 'obj', 'META title & META description', ''],
                ['copy_md', 'obj', 'META description', '']
            ];
            prop_tb._pdtSeo_tb.addButtonSelect("copy_name_to", 100, '<?php echo _l('Copy product name to ... for selected rows', 1) ?>', opts, "lib/img/textfield_key.png", "lib/img/textfield_key.png",false,true);
            prop_tb._pdtSeo_tb.setItemToolTip('copy_name_to','<?php echo _l('Copy product name to ... for selected rows',1)?>');

			prop_tb._pdtSeo_tb.attachEvent("onClick", function(id){
					if (id=='PdtSeo_refresh')
					{
						displayPdtSeo();
					}
					if (id=='exportcsv'){
						displayQuickExportWindow(prop_tb._pdtSeoGrid,1);
					}
                    if (id=='go_to_settings'){
                        openSettingsWindow('Catalog','SEO');
                    }
                    if (id.indexOf('copy_') != -1)
					{
                        let selected_rows = prop_tb._pdtSeoGrid.getSelectedRowId();
                        selected_rows = selected_rows.split(',');
                        selected_rows.forEach(function(rId,val) {
                            let idxProductName = prop_tb._pdtSeoGrid.getColIndexById('name');
                            let idxMetaTitle = prop_tb._pdtSeoGrid.getColIndexById('meta_title');
                            let idxMetaDescription = prop_tb._pdtSeoGrid.getColIndexById('meta_description');
                            let product_name = String(prop_tb._pdtSeoGrid.cells(rId,idxProductName).getValue());
                            let current_MetaTitle = String(prop_tb._pdtSeoGrid.cells(rId,idxMetaTitle).getValue());
                            let current_MetaDescription = String(prop_tb._pdtSeoGrid.cells(rId,idxMetaDescription).getValue());

                            if(id == 'copy_mt') {
                                prop_tb._pdtSeoGrid.cells(rId,idxMetaTitle).setValue(product_name);
								prop_tb._pdtSeoGrid.cells(rId,idxMetaTitle).cell.wasChanged=true;
                                onEditCellPdtSeo(2,rId,idxMetaTitle,product_name,current_MetaTitle);
                            } else if (id == 'copy_mtmd') {
                                prop_tb._pdtSeoGrid.cells(rId,idxMetaTitle).setValue(product_name);
								prop_tb._pdtSeoGrid.cells(rId,idxMetaTitle).cell.wasChanged=true;
                                onEditCellPdtSeo(2,rId,idxMetaTitle,product_name,current_MetaTitle);
                                prop_tb._pdtSeoGrid.cells(rId,idxMetaDescription).setValue(product_name);
								prop_tb._pdtSeoGrid.cells(rId,idxMetaDescription).cell.wasChanged=true;
                                onEditCellPdtSeo(2,rId,idxMetaDescription,product_name,current_MetaDescription);
                            } else {
                                prop_tb._pdtSeoGrid.cells(rId,idxMetaDescription).setValue(product_name);
								prop_tb._pdtSeoGrid.cells(rId,idxMetaDescription).cell.wasChanged=true;
                                onEditCellPdtSeo(2,rId,idxMetaDescription,product_name,current_MetaDescription);
                            }
                        });
					}
				});
			
			prop_tb._pdtSeoGrid = prop_tb._pdtSeo.attachGrid();
			prop_tb._pdtSeoGrid._name='_pdtSeoGrid';
			prop_tb._pdtSeoGrid.setImagePath("lib/js/imgs/");
  			prop_tb._pdtSeoGrid.enableDragAndDrop(false);
			prop_tb._pdtSeoGrid.enableMultiselect(false);
			
			// UISettings
			prop_tb._pdtSeoGrid._uisettings_prefix='cat_PdtSeo';
			prop_tb._pdtSeoGrid._uisettings_name=prop_tb._pdtSeoGrid._uisettings_prefix;
		   	prop_tb._pdtSeoGrid._first_loading=1;
		   	
			// UISettings
			initGridUISettings(prop_tb._pdtSeoGrid);
			
			prop_tb._pdtSeoGrid.attachEvent("onEditCell",onEditCellPdtSeo);
			
			
			prop_tb._pdtSeoGrid.attachEvent("onRowSelect",function (idstock){
				if (propertiesPanel=='pdtseo'){
					displayGoogleAdwords();
				}
			});
			
			// Context menu for MultiShops Info Product grid
			pdtSeo_cmenu=new dhtmlXMenuObject();
			pdtSeo_cmenu.renderAsContextMenu();
			function onGridPdtSeoContextButtonClick(itemId){
				tabId=prop_tb._pdtSeoGrid.contextID.split('_');
				tabId=tabId[0]+"_"+tabId[1]<?php if(SCMS) { ?>+"_"+tabId[2]<?php } ?>;
				if (itemId=="copy"){
					if (lastColumnRightClicked_PdtSeo!=0)
					{
						clipboardValue_PdtSeo=prop_tb._pdtSeoGrid.cells(tabId,lastColumnRightClicked_PdtSeo).getValue();
						pdtSeo_cmenu.setItemText('paste' , '<?php echo _l('Paste')?> '+prop_tb._pdtSeoGrid.cells(tabId,lastColumnRightClicked_PdtSeo).getTitle());
						clipboardType_PdtSeo=lastColumnRightClicked_PdtSeo;
					}
				}
				if (itemId=="paste"){
					if (lastColumnRightClicked_PdtSeo!=0 && clipboardValue_PdtSeo!=null && clipboardType_PdtSeo==lastColumnRightClicked_PdtSeo)
					{
						selection=prop_tb._pdtSeoGrid.getSelectedRowId();
						if (selection!='' && selection!=null)
						{
							selArray=selection.split(',');
							for(i=0 ; i < selArray.length ; i++)
							{
								var oValue = prop_tb._pdtSeoGrid.cells(selArray[i],lastColumnRightClicked_PdtSeo).getValue();
								prop_tb._pdtSeoGrid.cells(selArray[i],lastColumnRightClicked_PdtSeo).setValue(clipboardValue_PdtSeo);
								prop_tb._pdtSeoGrid.cells(selArray[i],lastColumnRightClicked_PdtSeo).cell.wasChanged=true;
								onEditCellPdtSeo(2,selArray[i],lastColumnRightClicked_PdtSeo,clipboardValue_PdtSeo,oValue);
							}
						}
					}
				}
			}
			pdtSeo_cmenu.attachEvent("onClick", onGridPdtSeoContextButtonClick);
			var contextMenuXML='<menu absolutePosition="auto" mode="popup" maxItems="8"  globalCss="contextMenu" globalSecondCss="contextMenu" globalTextCss="contextMenuItem">'+
					'<item text="Object" id="object" enabled="false"/>'+
					'<item text="Lang" id="lang" enabled="false"/>'+
					<?php if(SCMS) { ?>'<item text="Shop" id="shop" enabled="false"/>'+<?php } ?>
					'<item text="<?php echo _l('Copy')?>" id="copy"/>'+
					'<item text="<?php echo _l('Paste')?>" id="paste"/>'+
				'</menu>';
			pdtSeo_cmenu.loadStruct(contextMenuXML);
			prop_tb._pdtSeoGrid.enableContextMenu(pdtSeo_cmenu);

			prop_tb._pdtSeoGrid.attachEvent("onBeforeContextMenu", function(rowid,colidx,grid){
				var disableOnCols=new Array(
						prop_tb._pdtSeoGrid.getColIndexById('id_product'),
						<?php if(SCMS) { ?>prop_tb._pdtSeoGrid.getColIndexById('shop'),<?php } ?>
						prop_tb._pdtSeoGrid.getColIndexById('lang'),
						prop_tb._pdtSeoGrid.getColIndexById('meta_title_width'),
						prop_tb._pdtSeoGrid.getColIndexById('meta_description_width'),
						prop_tb._pdtSeoGrid.getColIndexById('meta_keywords_width')
						);
				if (in_array(colidx,disableOnCols))
				{
					return false;
				}
				lastColumnRightClicked_PdtSeo=colidx;
				pdtSeo_cmenu.setItemText('object', '<?php echo _l('Product:')?> '+prop_tb._pdtSeoGrid.cells(rowid,prop_tb._pdtSeoGrid.getColIndexById('name')).getTitle());
				<?php if(SCMS) { ?>pdtSeo_cmenu.setItemText('shop', '<?php echo _l('Shop:')?> '+prop_tb._pdtSeoGrid.cells(rowid,prop_tb._pdtSeoGrid.getColIndexById('shop')).getTitle());<?php } ?>
				pdtSeo_cmenu.setItemText('lang', '<?php echo _l('Lang:')?> '+prop_tb._pdtSeoGrid.cells(rowid,prop_tb._pdtSeoGrid.getColIndexById('lang')).getTitle());
				if (lastColumnRightClicked_PdtSeo==clipboardType_PdtSeo)
				{
					pdtSeo_cmenu.setItemEnabled('paste');
				}else{
					pdtSeo_cmenu.setItemDisabled('paste');
				}
				return true;
			});
			
			// GOOGLE ADD
			prop_tb._googleAdwords = prop_tb._PdtSeoLayout.cells('b');
			prop_tb._googleAdwords.setHeight(150);
			prop_tb._googleAdwords.setText('<?php echo _l('Google Adwords',1)?>');
			
			prop_tb._googleAdwords_tb = prop_tb._googleAdwords.attachToolbar();
			prop_tb._googleAdwords_tb.addButton("googleAdwords_refresh", 100, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
			prop_tb._googleAdwords_tb.setItemToolTip('googleAdwords_refresh','<?php echo _l('Refresh grid',1)?>');
			prop_tb._googleAdwords_tb.attachEvent("onClick", function(id){
				if (id=='googleAdwords_refresh')
				{
					displayGoogleAdwords();
				}
			});

            prop_tb._PdtSeoLayout.attachEvent("onPanelResizeFinish", function(name){
                name.forEach(function(id){
                    if(id=='b'){
                        saveParamUISettings('cat_Seo_Height', prop_tb._googleAdwords.getHeight());
                    }
                });
                return true;
            });
		
			needInitPdtSeo=0;
		}
	}
	
	
			
	function onEditCellPdtSeo(stage,rId,cInd,nValue,oValue)
	{
		if (stage==1 && this.editor && this.editor.obj) this.editor.obj.select();
		
		if (stage==2 && nValue!=oValue)
		{		
			idxLinkRewrite=prop_tb._pdtSeoGrid.getColIndexById('link_rewrite');
			if (nValue!="" && cInd==idxLinkRewrite)
			{
				<?php 
				$accented = Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL');
				if($accented==1) {	?>
					prop_tb._pdtSeoGrid.cells(rId,idxLinkRewrite).setValue(getAccentedLinkRewriteFromString(nValue.substr(0,<?php echo _s('CAT_LINK_REWRITE_SIZE')?>)));				
				<?php } else { ?>
					prop_tb._pdtSeoGrid.cells(rId,idxLinkRewrite).setValue(getLinkRewriteFromString(nValue.substr(0,<?php echo _s('CAT_LINK_REWRITE_SIZE')?>)));				
				<?php } ?>
			}
		
			var params = {
				name: "cat_seo_update_queue",
				row: rId,
				action: "update",
				params: {},
				callback: "callbackPdtSeo('"+rId+"','update','"+rId+"');"
			};
			// COLUMN VALUES
			/*prop_tb._pdtSeoGrid.forEachCell(rId,function(cellObj,ind){
				params.params[prop_tb._pdtSeoGrid.getColumnId(ind)] = prop_tb._pdtSeoGrid.cells(rId,ind).getValue();
			});*/
			params.params[prop_tb._pdtSeoGrid.getColumnId(cInd)] = prop_tb._pdtSeoGrid.cells(rId,cInd).getValue();
			// USER DATA
			/*params.params['marginMatrix_form'] = specificPrice_grid.getUserData("", "marginMatrix_form");*/
			
			params.params = JSON.stringify(params.params);
			addInUpdateQueue(params,prop_tb._pdtSeoGrid);
		}
		return true;
	}
	// CALLBACK FUNCTION
	function callbackPdtSeo(sid,action,tid)
	{
		if (action=='update')
			prop_tb._pdtSeoGrid.setRowTextNormal(sid);
	}
	
	function setPropertiesPanel_PdtSeo(id){
		if (id=='pdtseo')
		{
			if(lastProductSelID!=undefined && lastProductSelID!="")
			{
				idxProductName=cat_grid.getColIndexById('name');
				dhxLayout.cells('b').setText('<?php echo _l('Properties',1).' '._l('of',1)?> '+cat_grid.cells(lastProductSelID,idxProductName).getValue());
			}
			hidePropTBButtons();
			prop_tb.setItemText('panel', '<?php echo _l('SEO',1)?>');
			prop_tb.setItemImage('panel', 'lib/img/description.png');
			needInitPdtSeo = 1;
			initPdtSeo();
			propertiesPanel='pdtseo';
			if (lastProductSelID!=0)
			{
				displayPdtSeo();
				displayGoogleAdwords();
			}
		}
	}
	prop_tb.attachEvent("onClick", setPropertiesPanel_PdtSeo);

	function displayPdtSeo()
	{
		prop_tb._pdtSeoGrid.clearAll(true);
		var tempIdList = (cat_grid.getSelectedRowId()!=null?cat_grid.getSelectedRowId():"");
		$.post("index.php?ajax=1&act=cat_seo_get&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{'idlist': tempIdList},function(data)
		{
			prop_tb._pdtSeoGrid.parse(data);
			nb=prop_tb._pdtSeoGrid.getRowsNum();
			prop_tb._pdtSeoGrid._rowsNum=nb;
			
   			// UISettings
			loadGridUISettings(prop_tb._pdtSeoGrid);
			prop_tb._pdtSeoGrid._first_loading=0;
		});
	}

	function displayGoogleAdwords()
	{
        let cell_height = 150;
        let ui_cell_height = getParamUISettings('cat_Seo_Height');
        if(ui_cell_height !== '') {
            cell_height = ui_cell_height;
        }

		prop_tb._googleAdwords.setHeight(cell_height);
		prop_tb._googleAdwords.attachURL("index.php?ajax=1&act=cat_seo_add_get&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function(data){});
	}



	cat_grid.attachEvent("onRowSelect",function (idproduct){
			if (propertiesPanel=='pdtseo'){
				//initPdtSeo();
				displayPdtSeo();
				displayGoogleAdwords();
			}
		});