prop_tb.attachEvent("onClick", function setPropertiesPanel_combinationmultiproduct(id){
	if (id=='combinationmultiproduct')
	{
		prop_tb.combimulprd_subproperties_tb.addListOption('combimulprdSubProperties', 'combimulprd_images', 9, "button", '<?php
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

 echo _l('Images',1)?>', "lib/img/picture.png");

		prop_tb.combimulprd_subproperties_tb.attachEvent("onClick", function(id){
			if(id=="combimulprd_images")
			{
				hideCombinationMultiProduct_SubpropertiesItems();
				prop_tb.combimulprd_subproperties_tb.setItemText('combimulprdSubProperties', '<?php echo _l('Images',1)?>');
				prop_tb.combimulprd_subproperties_tb.setItemImage('combimulprdSubProperties', 'lib/img/picture.png');
				actual_subproperties = "combimulprd_images";
				initCombinationMultiProductImage();
			}
		});


		prop_tb._combinationmultiproductGrid.attachEvent("onRowSelect", function(id,ind){
			if (!prop_tb._combinationmultiproductLayout.cells('b').isCollapsed())
			{
				if(actual_subproperties == "combimulprd_images"){
			 		var v_scroll=prop_tb._combinationmultiproductImagesGrid.objBox.scrollTop;
					getCombinationMultiProductImages('prop_tb._combinationmultiproductImagesGrid.objBox.scrollTop = "'+v_scroll+'";');
				}
			}
		});
	}
});

var lastCheckedRow = 0;
function initCombinationMultiProductImage()
{
	if(needInitCombinationMultiProductImage==1)
	{
		prop_tb.combimulprd_subproperties_tb.addButton("combimulprd_img_add", 100, "", "lib/img/picture_add.png", "lib/img/picture_add.png");
		prop_tb.combimulprd_subproperties_tb.setItemToolTip('combimulprd_img_add','<?php echo _l('Upload new images',1)?>');
		prop_tb.combimulprd_subproperties_tb.addButton("combimulprd_img_all_association", 100, "", "lib/img/chart_organisation_add_v.png", "lib/img/chart_organisation_add_v.png");
		prop_tb.combimulprd_subproperties_tb.setItemToolTip('combimulprd_img_all_association','<?php echo _l('Assign all images to selected combination',1)?>');
		prop_tb.combimulprd_subproperties_tb.addButton("combimulprd_img_all_dissociation", 100, "", "lib/img/chart_organisation_delete_v.png", "lib/img/chart_organisation_delete_v.png");
		prop_tb.combimulprd_subproperties_tb.setItemToolTip('combimulprd_img_all_dissociation','<?php echo _l('Dissociate all images to selected combination',1)?>');

		prop_tb.combimulprd_subproperties_tb.attachEvent("onClick", function(id){
			if(id=='combimulprd_img_add')
			{
				var products_ids = lastProductSelID;
				var products_attr_ids = prop_tb._combinationmultiproductGrid.getSelectedRowId();
				if (products_ids!=0)
				{
					if (!dhxWins.isWindow("wProductImages"+products_ids))
					{
						prop_tb._imagesUploadWindow[products_ids] = dhxWins.createWindow("prop_tb._imagesUploadWindow[products_ids]", 50, 50, 585, 400);
						prop_tb._imagesUploadWindow[products_ids].setIcon('lib/img/picture_add.png','../../../lib/img/picture_add.png');

						if(products_ids === parseInt(products_ids, 10))
							prop_tb._imagesUploadWindow[products_ids].setText(cat_grid.cells(products_ids,idxProductName).getValue());
						else
							prop_tb._imagesUploadWindow[products_ids].setText('<?php echo _l('Upload images',1)?>');

						ll = new dhtmlXLayoutObject(prop_tb._imagesUploadWindow[products_ids], "1C");
						ll.cells('a').hideHeader();

						ll_toolbar=ll.cells('a').attachToolbar();
						ll_toolbar.addButtonTwoState("auto_upload", 0, "", "lib/img/picture_go.png", "lib/img/picture_go.png");
						ll_toolbar.setItemToolTip('auto_upload','<?php echo _l('If enabled: Images will be automatically uploaded once selected',1)?>');
						ll_toolbar.setItemState('auto_upload', ($.cookie('sc_cat_img_auto_upload')==1?1:0));

						ll_toolbar.attachEvent("onStateChange", function(id,state){
								if (id=='auto_upload'){
									var auto_upload = 0;
									if (state) {
									  auto_upload=1;
									}else{
									  auto_upload=0;
									}
									$.cookie('sc_cat_img_auto_upload',auto_upload, { expires: 60 });
								}
							});

						ll.cells('a').attachURL("index.php?ajax=1&act=cat_image_upload&is_attr=1&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),null,{product_list:products_ids, attr_list:products_attr_ids,multi:1});
						prop_tb._imagesUploadWindow[products_ids].attachEvent("onClose", function(win){
								win.hide();
								getCombinationMultiProductImages();
								return false;
							});
					}else{
						prop_tb._imagesUploadWindow[products_ids].show();
					}
				}else{
					alert('<?php echo _l('Please select a product',1)?>');
				}
			}
			if (id=='combimulprd_img_all_association')
			{
				prop_tb._combinationmultiproductImagesGrid.checkAll(true);
				var state = true;
				var checkboxColumn = prop_tb._combinationmultiproductImagesGrid.getColIndexById('used');
				var imgsChecked = prop_tb._combinationmultiproductImagesGrid.getCheckedRows(checkboxColumn);
				$.post("index.php?ajax=1&act=cat_combinationmultiproduct_image_update&state="+state,{'selection':prop_tb._combinationmultiproductGrid.getSelectedRowId(), 'ids':imgsChecked},function(data){
					var v_scroll=prop_tb._combinationmultiproductImagesGrid.objBox.scrollTop;
					getCombinationMultiProductImages('prop_tb._combinationmultiproductImagesGrid.objBox.scrollTop = "'+v_scroll+'";');
				});
			}
			if (id=='combimulprd_img_all_dissociation')
			{
				if (cat_grid.getSelectedRowId()!=null && prop_tb._combinationmultiproductGrid.getSelectedRowId()!='' && confirm('<?php echo _l('Are you sure you want to dissociate the selected items?',1)?>'))
				{
					prop_tb._combinationmultiproductImagesGrid.checkAll(true);
					var checkboxColumn = prop_tb._combinationmultiproductImagesGrid.getColIndexById('used');
					var imgsChecked = prop_tb._combinationmultiproductImagesGrid.getCheckedRows(checkboxColumn);
					var state = false;
					$.post("index.php?ajax=1&act=cat_combinationmultiproduct_image_update&state="+state,{'selection':prop_tb._combinationmultiproductGrid.getSelectedRowId(), 'ids':imgsChecked},function(data){
						var v_scroll=prop_tb._combinationmultiproductImagesGrid.objBox.scrollTop;
						getCombinationMultiProductImages('prop_tb._combinationmultiproductImagesGrid.objBox.scrollTop = "'+v_scroll+'";');
					});
				}
			}
		});

		needInitCombinationMultiProductImage = 0;
	}

	<?php
	if (version_compare(_PS_VERSION_, '1.2.0.1', '>='))
	{
	?>
		prop_tb.combimulprd_subproperties_tb.showItem('combimulprd_img_add');
		prop_tb.combimulprd_subproperties_tb.showItem('combimulprd_img_all_association');
		prop_tb.combimulprd_subproperties_tb.showItem('combimulprd_img_all_dissociation');
		prop_tb._combinationmultiproductImagesGrid = prop_tb._combinationmultiproductLayout.cells('b').attachGrid();
		prop_tb._combinationmultiproductImagesGrid.setImagePath("lib/js/imgs/");
		prop_tb._combinationmultiproductImagesGrid._lastCombination=0;
		prop_tb._combinationmultiproductImagesGrid.attachEvent("onCheck", function(rId,cInd,state){
            $.post("index.php?ajax=1&act=cat_combinationmultiproduct_image_update&ids="+rId+"&state="+state,{'selection':prop_tb._combinationmultiproductGrid.getSelectedRowId()},function(data){
                    var v_scroll=prop_tb._combinationmultiproductImagesGrid.objBox.scrollTop;
                    getCombinationMultiProductImages('prop_tb._combinationmultiproductImagesGrid.objBox.scrollTop = "'+v_scroll+'";');
                });
        });
		prop_tb._combinationmultiproductImagesGrid.attachEvent("onRowSelect", function(rId,cInd){
			if (cInd==1) {
				$.get("index.php?ajax=1&act=cat_combinationmultiproduct_image_relation_get&id_image="+rId, function(data){
                    prop_tb._combinationmultiproductGrid.clearSelection();
                    list=data.split(',');
                    list.forEach(function(item){
                        prop_tb._combinationmultiproductGrid.selectRowById(item, true);
                    });
                });
            }
		});

		// UISettings
		prop_tb._combinationmultiproductImagesGrid._uisettings_prefix='cat_combimulprd_image';
		prop_tb._combinationmultiproductImagesGrid._uisettings_name=prop_tb._combinationmultiproductImagesGrid._uisettings_prefix;
	   	prop_tb._combinationmultiproductImagesGrid._first_loading=1;

		// UISettings
		initGridUISettings(prop_tb._combinationmultiproductImagesGrid);

		getCombinationMultiProductImages();
	<?php
		}
	?>
}


function getCombinationMultiProductImages(callback)
{
<?php
	if (version_compare(_PS_VERSION_, '1.2.0.1', '>='))
	{
?>
	if (prop_tb._combinationmultiproductGrid.getSelectedRowId() && prop_tb._combinationmultiproductGrid.getSelectedRowId().substr(0,3)!='NEW')
	{
		prop_tb._combinationmultiproductImagesGrid._lastCombination=prop_tb._combinationmultiproductGrid.getSelectedRowId();
		prop_tb._combinationmultiproductImagesGrid.post("index.php?ajax=1&act=cat_combinationmultiproduct_image_get&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),"selection="+prop_tb._combinationmultiproductImagesGrid._lastCombination,function(){
			// UISettings
			loadGridUISettings(prop_tb._combinationmultiproductImagesGrid);
			prop_tb._combinationmultiproductImagesGrid._first_loading=0;

			if (typeof(callback)=='undefined') callback='';
			eval(callback);
		});
	}else if(prop_tb._combinationmultiproductGrid.getSelectedRowId()==null){
		prop_tb._combinationmultiproductImagesGrid._lastCombination=0;
		prop_tb._combinationmultiproductImagesGrid.clearAll();
	}
<?php
	}else{
?>
		prop_tb._combinationmultiproductLayout.cells('b').collapse();
<?php
	}
?>
}
