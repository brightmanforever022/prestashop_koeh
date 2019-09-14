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

if(_r("GRI_CAT_PROPERTIES_GRID_DESC")) { ?>
		prop_tb.addListOption('panel', 'descriptions', 2, "button", '<?php echo _l('Descriptions',1)?>', "lib/img/description.png");
		allowed_properties_panel[allowed_properties_panel.length] = "descriptions";
	prop_tb.addButton("description_refresh", 100, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
	prop_tb.setItemToolTip('description_refresh','<?php echo _l('Refresh',1)?>');
	prop_tb.addButton('desc_save',100,'','lib/img/page_save.png','lib/img/page_save.png');
	prop_tb.setItemToolTip('desc_save','<?php echo _l('Save descriptions',1)?>');
	prop_tb.addText('txt_descriptionsize', 100, '<?php echo _l('Short description charset')._l(':').' '.'0/'._s('CAT_SHORT_DESC_SIZE')?>');
    prop_tb.addButtonTwoState('desc_twodesc', 100, "", "lib/img/application_tile_vertical.png", "lib/img/application_tile_vertical.png");
    prop_tb.setItemToolTip('desc_twodesc','<?php echo _l('Display all descriptions',1)?>');
    prop_tb.addButtonTwoState('desc_3cols', 100, "", "lib/img/cols_3.png", "lib/img/cols_3.png");
    prop_tb.setItemToolTip('desc_3cols','<?php echo _l('Display on 3 columns',1)?>');
	<?php if (_s('APP_FOULEFACTORY') && SCI::getFFActive()) { ?>
		prop_tb.addButton('desc_fouleFactory', 100, "", "lib/img/foulefactory_icon.png", "lib/img/foulefactory_icon.png");
		prop_tb.setItemToolTip('desc_fouleFactory','<?php echo _l('Enhance your product pages in 3 minutes with FouleFactory',1)?>');
	<?php } ?>

    not_save = 0;

	needInitDescriptions = 1;
	function initDescriptions(){
		if (needInitDescriptions)
		{
            <?php
            if(count($languages) > 1) {?>
			    prop_tb._descriptionsLayout = dhxLayout.cells('b').attachLayout('2U');
            <?php } else { ?>
                prop_tb._descriptionsLayout = dhxLayout.cells('b').attachLayout('1C');
            <?php } ?>
			prop_tb._descriptionsLayout.cells('a').hideHeader();
			<?php if(_s("APP_RICH_EDITOR")==1) { ?>
			prop_tb._descriptionsLayout.cells('a').attachURL('index.php?ajax=1&act=cat_description_tinymce'+URLOptions);
			<?php } else { ?>
			prop_tb._descriptionsLayout.cells('a').attachURL('index.php?ajax=1&act=cat_description_ckeditor'+URLOptions);
			<?php } ?>
			dhxLayout.cells('b').showHeader();

            // subproperties
            <?php
            if(count($languages) > 1) {?>
            if(getParamUISettings('start_cat_description') == 1) {
                prop_tb._descriptionsLayout.cells('b').collapse();
            }
            actual_subproperties = "desc_translation";
            prop_tb._descriptionsLayout.cells('b').setWidth(200);
            prop_tb._descriptionsLayout.cells('b').setText("<?php echo _l('Description')?>");
            prop_tb.desc_subproperties_tb=prop_tb._descriptionsLayout.cells('b').attachToolbar();
            var opts = new Array();
			prop_tb.desc_subproperties_tb.addButtonSelect("descSubProperties", 0, "<?php echo _l('Translation')?>", opts, "lib/img/description.png", "lib/img/description.png",false,true);
			hideDescSubpropertiesItems();
            <?php } ?>

            prop_tb._descriptionsLayout.attachEvent("onCollapse", function(name){
                saveParamUISettings('start_cat_description', 1);
            });
            prop_tb._descriptionsLayout.attachEvent("onExpand", function(name){
                saveParamUISettings('start_cat_description', 0);
            });

			needInitDescriptions=0;
		}
	}

    function hideDescSubpropertiesItems()
	{
		prop_tb.desc_subproperties_tb.forEachItem(function(itemId){
	        if(itemId!="descSubProperties") {
	        	prop_tb.desc_subproperties_tb.hideItem(itemId);
            }
	    });
	}

	function setPropertiesPanel_descriptions(id){
		// ask to save description if modified
		if (propertiesPanel=='descriptions' && id!='desc_save' && typeof prop_tb._descriptionsLayout!='undefined')
			checkDescriptionsBeforeChangeRow();

		if (id=='descriptions')
		{
			hidePropTBButtons();
			prop_tb.showItem('description_refresh');
			prop_tb.showItem('desc_save');
			prop_tb.showItem('desc_twodesc');
			prop_tb.showItem('desc_3cols');
			<?php if (_s('APP_FOULEFACTORY') && SCI::getFFActive()) { ?>
				prop_tb.showItem('desc_fouleFactory');
			<?php } ?>
			prop_tb.showItem('txt_descriptionsize');
			prop_tb.setItemState("desc_twodesc", 1);
			prop_tb.setItemText('panel', '<?php echo _l('Descriptions',1)?>');
			prop_tb.setItemImage('panel', 'lib/img/description.png');
			URLOptions='';
			if (lastProductSelID!=0) URLOptions='&id_product='+lastProductSelID+'&id_lang='+SC_ID_LANG;
			needInitDescriptions = 1;
			initDescriptions();
            <?php if(count($languages) > 1) {?>
            needInitDescriptionTranslation=1;
		    initDescriptionTranslation();
            <?php } ?>
			propertiesPanel='descriptions';
            <?php if(_s("CAT_PROPERTIES_DESCRIPTION_AUTO_SIZING")==1) { ?>
			    dhxLayout.cells('b').setWidth(680);
            <?php } ?>
		}

		if (id=='desc_save')
		{
            not_save = 0;
			<?php if(_s("APP_RICH_EDITOR")!=1) { ?>
			prop_tb._descriptionsLayout.cells('a').progressOn();
			<?php } ?>
			prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.ajaxSave();
		}
		if (id=='description_refresh')
		{
			if (lastProductSelID!=0) URLOptions='&id_product='+lastProductSelID+'&id_lang='+SC_ID_LANG;
			<?php if(_s("APP_RICH_EDITOR")==1) { ?>
				prop_tb._descriptionsLayout.cells('a').attachURL('index.php?ajax=1&act=cat_description_tinymce'+URLOptions);
			<?php } else { ?>
				prop_tb._descriptionsLayout.cells('a').attachURL('index.php?ajax=1&act=cat_description_ckeditor'+URLOptions);
			<?php } ?>
		}
		if(id=='desc_fouleFactory')
		{
			showWCatFoulefactory();
		}
	}
	prop_tb.attachEvent("onClick", setPropertiesPanel_descriptions);

	prop_tb.attachEvent("onStateChange",function(id,state){
		if (id=='desc_twodesc')
		{
			if (state)
			{
				prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.showShortDesc();
			}else{
				prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.hideShortDesc();
			}
		}
		if (id=='desc_3cols')
		{
			if (state)
			{
                cat.cells("a").collapse();
                var tmp_size = ($(window).width()*1)/3;
                dhxLayout.cells('b').setWidth(tmp_size*2);
                prop_tb._descriptionsLayout.cells('b').expand();
                prop_tb._descriptionsLayout.cells('b').setWidth(tmp_size);
			}else{
                cat.cells("a").expand();
                var start_cat_size_prop = getParamUISettings('start_cat_size_prop');
                dhxLayout.cells('b').setWidth(start_cat_size_prop);
                prop_tb._descriptionsLayout.cells('b').collapse();
			}
		}
	});	


	cat_grid_tb.attachEvent("onClick",function(id){
<?php
	$tmp=array();
	$clang=_l('Language');
	foreach($languages AS $lang){
		echo'
			if (id==\'cat_lang_'.$lang['iso_code'].'\')
			{
				if (propertiesPanel==\'descriptions\' && typeof prop_tb._descriptionsLayout!=\'undefined\')
					checkDescriptionsBeforeChangeRow();
			}
';
	}
?>
	});

    cat_grid.attachEvent("onBeforeSelect", function(newP,oldP,newI){
        checkDescriptionsBeforeChangeRow();
        return true;
    });

	cat_grid.attachEvent("onRowSelect",function (idproduct){
			lastProductSelID=idproduct;
			idxProductName=cat_grid.getColIndexById('name');
			if (propertiesPanel=='descriptions')
			{
				if (prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.checkSize())
				{
					dhxLayout.cells('b').setText('<?php echo _l('Properties',1).' '._l('of',1)?> '+cat_grid.cells(lastProductSelID,idxProductName).getValue());
					<?php if(_s("APP_RICH_EDITOR")!=1) { ?>
						prop_tb._descriptionsLayout.cells('a').progressOn();
					<?php } ?>
					prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.ajaxLoad('&id_product='+lastProductSelID+'&id_lang='+SC_ID_LANG,lastProductSelID,SC_ID_LANG);
				}else{
					dhtmlx.message({text:'<?php echo _l('Short description charset must be < ')._s('CAT_SHORT_DESC_SIZE').' '._l('chars',1)?>',type:'error'});
				}
			}
		});

        function checkDescriptionsBeforeChangeRow(currentproduct)
        {
            if (propertiesPanel=='descriptions')
            {
                if(not_save !== 0) {
                    prop_tb._descriptionsLayout.cells('a').getFrame().contentWindow.checkChange();
                }
            }
        }

<?php } ?>