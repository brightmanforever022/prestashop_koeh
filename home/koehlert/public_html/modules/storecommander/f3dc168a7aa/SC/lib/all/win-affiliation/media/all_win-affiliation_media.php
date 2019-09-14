<script type="text/javascript">

dhxlAffMedia = dhxlGenAffViewMedias.cells("a").attachLayout("3T");

// GRID
<?php if(SCMS) { ?>
dhxlAffMediaTop = dhxlAffMedia.cells("a").attachLayout("2U");
dhxlAffMediaList = dhxlAffMediaTop.cells("a");
<?php } else { ?>
dhxlAffMediaList = dhxlAffMedia.cells("a");
<?php } ?>

dhxlAffMediaList.setText("<?php echo _l('Medias',1);?> - <?php echo _l('Banners',1);?>");

dhxlAffMediaTb=dhxlAffMediaList.attachToolbar();
dhxlAffMediaTb.addButton("help", 0, "", "lib/img/help.png", "lib/img/help.png");
dhxlAffMediaTb.setItemToolTip('help','<?php echo _l('Help', 1)?>');
dhxlAffMediaTb.addButton("del_banner", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
dhxlAffMediaTb.setItemToolTip('del_banner','<?php echo _l('Delete banner', 1)?>');
dhxlAffMediaTb.addButton("deactivate_banner", 0, "", "lib/img/picture_delete.png", "lib/img/picture_delete.png");
dhxlAffMediaTb.setItemToolTip('deactivate_banner','<?php echo _l('Deactivate', 1)?>');
dhxlAffMediaTb.addButton("activate_banner", 0, "", "lib/img/picture_add.png", "lib/img/picture_add.png");
dhxlAffMediaTb.setItemToolTip('activate_banner','<?php echo _l('Activate', 1)?>');
dhxlAffMediaTb.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
dhxlAffMediaTb.setItemToolTip('selectall','<?php echo _l('Select all', 1)?>');
dhxlAffMediaTb.addButton("refresh", 0, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
dhxlAffMediaTb.setItemToolTip('refresh','<?php echo _l('Refresh grid', 1)?>');
	
dhxlAffMediaTb.attachEvent("onClick", function(id){
	if (id=='refresh')
	{
		displayBanner();
	}
	if (id=='selectall')
	{
		dhxlAffMediaGrid.selectAll();
	}
	if (id=='del_banner')
	{
		if (confirm('<?php echo _l('Are you sure you want to delete this banner?', 1)?>'))
		{
			dhxlAffMediaGrid.deleteSelectedRows();
		}
	}
	if (id=='deactivate_banner')
	{
		if(dhxlAffMediaGrid.getSelectedRowId()!="" && dhxlAffMediaGrid.getSelectedRowId()!=null)
		{
			$.post("index.php?ajax=1&act=all_win-affiliation_media_update&id_lang="+SC_ID_LANG,{action:"mass_active",value:"0",ids:dhxlAffMediaGrid.getSelectedRowId()},function(data){
				displayBanner();
			});
		}
	}
	if (id=='activate_banner')
	{
		if(dhxlAffMediaGrid.getSelectedRowId()!="" && dhxlAffMediaGrid.getSelectedRowId()!=null)
		{
			$.post("index.php?ajax=1&act=all_win-affiliation_media_update&id_lang="+SC_ID_LANG,{action:"mass_active",value:"1",ids:dhxlAffMediaGrid.getSelectedRowId()},function(data){
				displayBanner();
			});
		}
	}
});

dhxlAffMediaGrid=dhxlAffMediaList.attachGrid();
dhxlAffMediaGrid.setImagePath("lib/js/imgs/");
dhxlAffMediaGrid.enableMultiselect(true);
dhxlAffMediaGrid.enableSmartRendering(true);
var lastCol = 0;
dhxlAffMediaGrid.attachEvent("onEditCell", function(stage, rId, cIn){
	if (stage==1 && this.editor && this.editor.obj) this.editor.obj.select();
	lastCol = cIn;
	return true;
});

dhxlAffMediaGrid.attachEvent("onRowSelect", function(rowid,ind){
	var url = dhxlAffMediaGrid.getUserData(rowid,"url");
	dhxlAffMediaPreview.attachURL("index.php?ajax=1&act=all_win-affiliation_media_picture&url="+url);
	<?php if(SCMS) { ?>
	displayBannerShops();
	<?php } ?>
});


// UISettings
dhxlAffMediaGrid._uisettings_prefix='sctools_scaffiliation_medias';
dhxlAffMediaGrid._uisettings_name=dhxlAffMediaGrid._uisettings_prefix;
dhxlAffMediaGrid._first_loading=1;
initGridUISettings(dhxlAffMediaGrid);

groupsDataProcessorURLBase="index.php?ajax=1&act=all_win-affiliation_media_update&id_lang="+SC_ID_LANG;
groupsDataProcessor = new dataProcessor(groupsDataProcessorURLBase);
groupsDataProcessor.enableDataNames(true);
groupsDataProcessor.enablePartialDataSend(true);
groupsDataProcessor.setUpdateMode('cell');
groupsDataProcessor.init(dhxlAffMediaGrid); 

groupsDataProcessor.attachEvent("onBeforeUpdate",function(id,status, data){
	idxUrl=dhxlAffMediaGrid.getColIndexById('url');
	if(idxUrl==lastCol)
	{
		var url = dhxlAffMediaGrid.cells(id,idxUrl).getValue();
		if(url!=undefined && url!="" && url!=null)
			url = encodeURIComponent(url);

		$.post("index.php?ajax=1&act=all_win-affiliation_media_update&gr_id="+id+"&action=url&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"url":url},function(data){
		});
		groupsDataProcessor.setUpdated(id,false,"updated");
		return false;
	}
	return true;
});

function displayBanner()
{
	oldFilters=new Array();
	for(var i=0,l=dhxlAffMediaGrid.getColumnsNum();i<l;i++)
	{
		if (dhxlAffMediaGrid.getFilterElement(i)!=null && dhxlAffMediaGrid.getFilterElement(i).value!='')
			oldFilters[dhxlAffMediaGrid.getColumnId(i)]=dhxlAffMediaGrid.getFilterElement(i).value;
	}
	dhxlAffMediaGrid.clearAll(true);
	dhxlAffMediaGrid.loadXML("index.php?ajax=1&act=all_win-affiliation_media_get&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function()
	{
		nb=dhxlAffMediaGrid.getRowsNum();
		/*for(var i=0;i<dhxlAffMediaGrid.getColumnsNum();i++)
		{
			if (dhxlAffMediaGrid.getFilterElement(i)!=null && oldFilters[dhxlAffMediaGrid.getColumnId(i)]!=undefined)
			{
				dhxlAffMediaGrid.getFilterElement(i).value=oldFilters[dhxlAffMediaGrid.getColumnId(i)];
			}
		}
		dhxlAffMediaGrid.filterByAll();*/

		// UISettings
		loadGridUISettings(dhxlAffMediaGrid);
		dhxlAffMediaGrid._first_loading=0;
	});
}
displayBanner();

// SHOPS
<?php if(SCMS) { ?>
dhxlAffMediaShops = dhxlAffMediaTop.cells("b");
dhxlAffMediaShops.setText("<?php echo _l('Multistore sharing manager',1);?>");


dhxlAffMediaShopsTb=dhxlAffMediaShops.attachToolbar();
dhxlAffMediaShopsTb.addButton("help", 0, "", "lib/img/help.png", "lib/img/help.png");
dhxlAffMediaShopsTb.setItemToolTip('help','<?php echo _l('Help', 1)?>');
dhxlAffMediaShopsTb.addButton("shopshare_del_select", 0, "", "lib/img/chart_organisation_delete_v.png", "lib/img/chart_organisation_delete_v.png");
dhxlAffMediaShopsTb.setItemToolTip('shopshare_del_select','<?php echo _l('Remove all the selected banners to all the selected shops', 1)?>');
dhxlAffMediaShopsTb.addButton("shopshare_add_select", 0, "", "lib/img/chart_organisation_add_v.png", "lib/img/chart_organisation_add_v.png");
dhxlAffMediaShopsTb.setItemToolTip('shopshare_add_select','<?php echo _l('Add all the selected banners to all the selected shops', 1)?>');
dhxlAffMediaShopsTb.addButton("shopshare_refresh", 0, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
dhxlAffMediaShopsTb.setItemToolTip('shopshare_refresh','<?php echo _l('Refresh grid', 1)?>');
	
dhxlAffMediaShopsTb.attachEvent("onClick", function(id){
	if (id=='shopshare_refresh')
	{
		displayBannerShops();
	}
	if (id=='shopshare_del_select')
	{
		if( (dhxlAffMediaGrid.getSelectedRowId()!="" && dhxlAffMediaGrid.getSelectedRowId()!=null)
				&&
			(dhxlAffMediaGrid.getSelectedRowId()!="" && dhxlAffMediaGrid.getSelectedRowId()!=null)
		)
		{
			var value = 0;
			$.post("index.php?ajax=1&act=all_win-affiliation_media_shopshare_update&id_shop="+dhxlAffMediaShopsGrid.getSelectedRowId()+"&action=mass_present&value="+value+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"idlist":dhxlAffMediaGrid.getSelectedRowId()},function(data){
				displayBannerShops();
			});
		}
	}
	if (id=='shopshare_add_select')
	{
		if( (dhxlAffMediaGrid.getSelectedRowId()!="" && dhxlAffMediaGrid.getSelectedRowId()!=null)
				&&
			(dhxlAffMediaShopsGrid.getSelectedRowId()!="" && dhxlAffMediaShopsGrid.getSelectedRowId()!=null)
		)
		{
			var value = 1;
			$.post("index.php?ajax=1&act=all_win-affiliation_media_shopshare_update&id_shop="+dhxlAffMediaShopsGrid.getSelectedRowId()+"&action=mass_present&value="+value+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"idlist":dhxlAffMediaGrid.getSelectedRowId()},function(data){
				displayBannerShops();
			});
		}
	}
});

dhxlAffMediaShopsGrid=dhxlAffMediaShops.attachGrid();
dhxlAffMediaShopsGrid.setImagePath("lib/js/imgs/");
dhxlAffMediaShopsGrid.enableMultiselect(true);
dhxlAffMediaShopsGrid.attachEvent("onEditCell", function(stage, rId, cInd){
		if (stage==1 && this.editor && this.editor.obj) this.editor.obj.select();

		if(stage==1)
		{
			idxPresent=dhxlAffMediaShopsGrid.getColIndexById('present');
			var value = dhxlAffMediaShopsGrid.cells(rId,cInd).isChecked();
			$.post("index.php?ajax=1&act=all_win-affiliation_media_shopshare_update&id_shop="+rId+"&action=present&value="+value+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"idlist":dhxlAffMediaGrid.getSelectedRowId()},function(data){
			});
		}
		return true;
	});

function displayBannerShops()
{
	dhxlAffMediaShopsGrid.clearAll(true);
	dhxlAffMediaShopsGrid.loadXML("index.php?ajax=1&act=all_win-affiliation_media_shopshare_get&idlist="+dhxlAffMediaGrid.getSelectedRowId()+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function()
	{});
}

<?php } ?>

// PREVIEW
dhxlAffMediaPreview = dhxlAffMedia.cells("b");
dhxlAffMediaPreview.hideHeader();

// FORM
dhxlAffMediaForm = dhxlAffMedia.cells("c");
dhxlAffMediaForm.setText("<?php echo _l('Add new banners',1);?>");
dhxlAffMediaForm.attachURL("index.php?ajax=1&act=all_win-affiliation_media_upload");

</script>