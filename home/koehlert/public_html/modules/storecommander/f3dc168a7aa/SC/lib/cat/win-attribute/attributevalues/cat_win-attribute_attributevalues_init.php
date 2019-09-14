// INITIALISATION TOOLBAR
<?php $propname = _l('Attribute values',1); ?>
wAttributes.tbAttr.addListOption('win_attr_prop_subproperties', 'win_attr_prop_attributevalues', 1, "button", '<?php echo $propname; ?>', "lib/img/description.png");

wAttributes.tbAttr.attachEvent("onClick", function(id){
	if(id=="win_attr_prop_attributevalues")
	{
		hideWinAttributeSubpropertiesItems();
		wAttributes.tbAttr.setItemText('win_attr_prop_subproperties', '<?php echo $propname; ?>');
		wAttributes.tbAttr.setItemImage('win_attr_prop_subproperties', 'lib/img/description.png');
		actual_winattribute_subproperties = "win_attr_prop_attributevalues";
		initWinAttributePropAttributeValues();
        displayAttributes();
	}
});


wAttributes.tbAttr.addButton("refresh", 100, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
wAttributes.tbAttr.setItemToolTip('refresh','<?php echo _l('Refresh grid',1)?>');
if (isIPAD)
{
    wAttributes.tbAttr.addButtonTwoState('lightNavigation', 100, "", "lib/img/cursor.png", "lib/img/cursor.png");
    wAttributes.tbAttr.setItemToolTip('lightNavigation','<?php echo _l('Light navigation (simple click on grid)',1)?>');
}
wAttributes.tbAttr.addInput("add_input", 100,"1",30);
wAttributes.tbAttr.setItemToolTip('add_input','<?php echo _l('Number of attributes to create when clicking on the Create button',1)?>');
wAttributes.tbAttr.addButton("add_attr", 100, "", "lib/img/add.png", "lib/img/add.png");
wAttributes.tbAttr.setItemToolTip('add_attr','<?php echo _l('Create new attributes',1)?>');
wAttributes.tbAttr.addButton("del_attr", 100, "", "lib/img/delete.gif", "lib/img/delete.gif");
wAttributes.tbAttr.setItemToolTip('del_attr','<?php echo _l('Delete attribute(s) and all combinations using this attribute',1)?>');
wAttributes.tbAttr.addButton("merge_attr", 100, "", "lib/img/shape_move_front.png", "lib/img/shape_move_front.png");
wAttributes.tbAttr.setItemToolTip('merge_attr','<?php echo _l('Merge selected attributes',1)?>');
<?php if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) { ?>
wAttributes.tbAttr.addButton("attr_setposition", 100, "", "lib/img/layers.png", "lib/img/layers_dis.png");
wAttributes.tbAttr.setItemToolTip('attr_setposition','<?php echo _l('Save positions',1)?>');
<?php } ?>
wAttributes.tbAttr.addSeparator("sep", 100);
wAttributes.tbAttr.addButton("img_add", 100, "", "lib/img/picture_add.png", "lib/img/picture_add.png");
wAttributes.tbAttr.setItemToolTip('img_add','<?php echo _l('Add texture of selected element',1)?>');
wAttributes.tbAttr.addButton("img_del", 100, "", "lib/img/picture_delete.png", "lib/img/picture_delete.png");
wAttributes.tbAttr.setItemToolTip('img_del','<?php echo _l('Delete texture of selected elements',1)?>');


function initWinAttributePropAttributeValues()
{
    <?php if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) { ?>
	wAttributes.tbAttr.showItem('attr_setposition');
    <?php } ?>
	wAttributes.tbAttr.showItem('merge_attr');
	wAttributes.tbAttr.showItem('del_attr');
	wAttributes.tbAttr.showItem('add_attr');
	wAttributes.tbAttr.showItem('add_input');
    if (isIPAD)
    {
        wAttributes.tbAttr.showItem('lightNavigation');
    }
	wAttributes.tbAttr.showItem('refresh');

    wAttributes.gridAttributes=dhxlAttributes.cells('b').attachGrid();
	wAttributes.gridAttributes._name='attributes';
	wAttributes.gridAttributes.setImagePath("lib/js/imgs/");
	wAttributes.gridAttributes.enableSmartRendering(true);

	// UISettings
	wAttributes.gridAttributes._uisettings_prefix='cat_win-attribute_attributevalues';
	wAttributes.gridAttributes._uisettings_name=wAttributes.gridAttributes._uisettings_prefix;
	wAttributes.gridAttributes._first_loading=1;

	// UISettings
	initGridUISettings(wAttributes.gridAttributes);

	function doOnColorChanged(stage, rId, cIn) {
		var coltype=wAttributes.gridAttributes.getColType(cIn);
		if (stage==1 && this.editor && this.editor.obj && coltype!='cp') this.editor.obj.select();
    if (stage==2) {
    	if (wAttributes.gridAttributes.getColIndexById('color')==1)
    	{
        if (cIn == 1) {
            wAttributes.gridAttributes.cells(rId, 2).setValue(wAttributes.gridAttributes.cells(rId, 1).getValue());
        } else if (cIn == 2) {
            wAttributes.gridAttributes.cells(rId, 1).setValue(wAttributes.gridAttributes.cells(rId, 2).getValue());
        }
      }
    }
    return true;
	}
	wAttributes.gridAttributes.attachEvent("onEditCell", doOnColorChanged);

    wAttributes.gridGroups.attachEvent("onRowSelect",function(idgroup){
		if (lastGroupSelID!=idgroup)
		{
			if(actual_winattribute_subproperties == 'win_attr_prop_attributevalues') {
                lastGroupSelID=idgroup;
                displayAttributes(idgroup);
            }
		}
	});


	attributesDataProcessorURLBase="index.php?ajax=1&act=cat_win-attribute_attributevalues_update&id_lang="+SC_ID_LANG;
	attributesDataProcessor = new dataProcessor(attributesDataProcessorURLBase);
	attributesDataProcessor.enableDataNames(true);
	attributesDataProcessor.enablePartialDataSend(true);
	attributesDataProcessor.setUpdateMode('cell');
	attributesDataProcessor.attachEvent("onAfterUpdate",function(sid,action,tid,xml_node){
			if (action=='insert')
			{
				wAttributes.gridAttributes.cells(tid,0).setValue(tid);
			}
			return true;
		});
	attributesDataProcessor.init(wAttributes.gridAttributes);

	wAttributes.gridAttributes.enableDragAndDrop(true);
	wAttributes.gridAttributes.setDragBehavior("child");
	wAttributes.gridAttributes.attachEvent("onDragIn",function(idsource){
		<?php if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) { ?>
			return true;
		<?php } else { ?>
			return false;
		<?php } ?>
		});
	wAttributes.gridAttributes.attachEvent("onDrag",function(sourceid,targetid,sourceobject,targetobject){
		<?php if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) { ?>
		if(targetobject._name==undefined || targetobject._name==null || sourceobject._name!="attributes" || targetobject._name!="attributes")
			return false;
		else
			return true;
		<?php } else { ?>
			return false;
		<?php } ?>
		});
	wAttributes.gridAttributes.attachEvent("onBeforeDrag",function(idsource){
			if (wAttributes.gridAttributes.getSelectedRowId()==null) draggedAttribute=idsource;
			return true;
		});

	draggedAttribute=0;

}

wAttributes.tbAttr.attachEvent("onClick",function(id){
    if (id=='refresh')
    {
        displayAttributes(lastGroupSelID);
    }
    if (id=='add_attr')
    {
        if (lastGroupSelID!=0)
        {
            var newId = new Date().getTime();
            nb=wAttributes.tbAttr.getValue('add_input');
            if (isNaN(nb)) nb=1;
            for (i=1;i<=nb;i++)
            {
                col2data="";
                if (wAttributes.gridGroups.cells(lastGroupSelID,1).getValue()==1) col2data="#000000";
                wAttributes.gridAttributes.addRow(newId*100+i,[newId*100+i,col2data]);
            }
        }
    }
    if (id=='del_attr')
    {
        if (confirm('<?php echo _l('Are you sure you want to delete the selected items?',1)?>'))
            wAttributes.gridAttributes.deleteSelectedRows();
    }
    if (id=='merge_attr')
    {
        if (wAttributes.gridAttributes.getSelectedRowId()==null || wAttributes.gridAttributes.getSelectedRowId().split(',').length<2)
        {
            alert('<?php echo _l('You must select one item',1)?>');
        }else if (confirm('<?php echo _l('Are you sure you want to merge the selected items?',1)?>'))
        {
            $.post("index.php?ajax=1&act=cat_win-attribute_attributevalues_update&action=merge",{'attrlist':wAttributes.gridAttributes.getSelectedRowId()},function(data){
                if (data.substr(0,3)=='OK:') {
                    displayAttributes('wAttributes.gridAttributes.selectRowById('+data.substr(3,10)+',false,true);');
                }else{
                    dhtmlx.message({text:'Error: '+data,type:'error'});
                }
            });
        }

    }
    if (id=='attr_setposition'){
        if (wAttributes.gridAttributes.getRowsNum()>0)
        {
            var positions='';
            var idx=0;
            var i = 1 ;
            wAttributes.gridAttributes.forEachRow(function(id){
                    positions+=id+','+wAttributes.gridAttributes.getRowIndex(id)+';';
                    idx++;
                });
            $.post("index.php?ajax=1&act=cat_win-attribute_attributevalues_update&action=position&"+new Date().getTime(),{ positions: positions },function(){
                displayAttributes(lastGroupSelID);
            });
        }
    }
    if (id=='img_add')
    {
        if (wAttributes.gridAttributes.getSelectedRowId()==null || wAttributes.gridAttributes.getSelectedRowId().split(',').length!=1)
        {
            alert('<?php echo _l('You must select one item',1)?>');
        }else{
            if (dhxWins.isWindow("wAttributeTexture")) wAttributeTexture.close();
            if (!dhxWins.isWindow("wAttributeTexture"))
            {
                wAttributeTexture = dhxWins.createWindow("wAttributeTexture", 50, 50, 585, 400);
                wAttributeTexture.setIcon('lib/img/picture_add.png','../../../lib/img/picture_add.png');
                idxAttributeName=wAttributes.gridAttributes.getColIndexById('name¤<?php echo $user_lang_iso;?>');
                wAttributeTexture.setText('<?php echo _l('Texture',1)?> '+wAttributes.gridAttributes.cells(wAttributes.gridAttributes.getSelectedRowId(),idxAttributeName).getValue());
                ll = new dhtmlXLayoutObject(wAttributeTexture, "1C");
                ll.cells('a').hideHeader();
                ll.cells('a').attachURL('index.php?ajax=1&act=cat_win-attribute_attributevalues_texture&action=add&id_attribute='+wAttributes.gridAttributes.getSelectedRowId()+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function(data){});
            }
        }
    }
    if (id=='img_del')
    {
        if (wAttributes.gridAttributes.getSelectedRowId()==null)
        {
            alert('<?php echo _l('You must select one item')?>');
        }else if (confirm('<?php echo _l('Are you sure you want to delete the selected items?',1)?>'))
        {
            $.post("index.php?ajax=1&act=cat_win-attribute_attributevalues_texture&action=delete",{'id_attribute':wAttributes.gridAttributes.getSelectedRowId()},function(){
                displayAttributes();
            });
        }

    }
});

wAttributes.tbAttr.attachEvent("onStateChange",function(id,state){
    if (id=='lightNavigation')
    {
        if (state)
        {
            wAttributes.gridAttributes.enableLightMouseNavigation(true);
        }else{
            wAttributes.gridAttributes.enableLightMouseNavigation(false);
        }
    }
});

function displayAttributes(callback)
{
	wAttributes.gridAttributes.clearAll(true);
	wAttributes.tbAttr.hideItem('sep');
	wAttributes.tbAttr.hideItem('img_add');
	wAttributes.tbAttr.hideItem('img_del');
	idxColorCol=wAttributes.gridGroups.getColIndexById('is_color_group');
	if (lastGroupSelID!=0) {
		wAttributes.gridAttributes.load("index.php?ajax=1&act=cat_win-attribute_attributevalues_get&id_attribute_group="+lastGroupSelID+"&iscolor="+wAttributes.gridGroups.cells(lastGroupSelID,idxColorCol).getValue()+"&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),function()
        {
            attributesDataProcessor.serverProcessor=attributesDataProcessorURLBase+"&id_attribute_group="+lastGroupSelID;
            nb=wAttributes.gridGroups.getRowsNum();
            nb2=wAttributes.gridAttributes.getRowsNum();
            wAttributes._sb.setText(nb+(nb>1?" <?php echo _l('groups')?>":" <?php echo _l('group')?>")+" / "+nb2+(nb2>1?" <?php echo _l('attributes')?>":" <?php echo _l('attribute')?>"));
        // UISettings
            loadGridUISettings(wAttributes.gridAttributes);
            wAttributes.gridAttributes._first_loading=0;

        if (wAttributes.gridAttributes.getColIndexById('color'))
        {
                wAttributes.tbAttr.showItem('sep');
                wAttributes.tbAttr.showItem('img_add');
                wAttributes.tbAttr.showItem('img_del');
        }
        if (callback!='') eval(callback);
        });
    }
}