<script type="text/javascript">
	var pro_type_selected = "type_products";
	var pro_field_selected = "";
	var pro_advprop_selected = "select_options";
	

	dhxlSCGridsEditorPro=toolsSCGridsEditorPro.attachLayout("2U");

	// Colonne des grilles
		dhxlSCGridsEditorPro.cells('a').setText("<?php echo _l('Custom fields') ?>");
		dhxlSCGridsEditorPro.cells('a').setWidth(400);
	
		dhxlSCGridsEditorPro.tbCustomFields=dhxlSCGridsEditorPro.cells('a').attachToolbar();
		dhxlSCGridsEditorPro.tbCustomFields.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
		dhxlSCGridsEditorPro.tbCustomFields.setItemToolTip('delete','<?php echo _l('Delete field')?>');
		dhxlSCGridsEditorPro.tbCustomFields.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
		dhxlSCGridsEditorPro.tbCustomFields.setItemToolTip('add','<?php echo _l('Add new field')?>');
		var opts = [['type_products', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Products grids',1)?>', ''],
					['type_combinations', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Combinations grid',1)?>', ''],
					['type_combinationmultiproduct', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Multi-product combinations',1)?>', ''],
					['type_productimport', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Product import',1)?>', ''],
					['type_productexport', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Product export',1)?>', ''],
					['type_productsort', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Products positions',1)?>', ''],
					['type_msproduct', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('MS - products information',1)?>', ''],
					['type_mscombination', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('MS - combinations',1)?>', ''],
					['type_image', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Product images',1)?>', ''],
					['type_propsupplier', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Suppliers',1)?>', ''],
					['type_categories', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Categories',1)?>', ''],
					['type_propspeprice', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Properties - specific prices',1)?>', ''],
					['type_winspeprice', 'obj', '<?php echo _l('Catalog:',1)?> <?php echo _l('Window - specific prices',1)?>', ''],
					['type_customers', 'obj', '<?php echo _l('Customers:',1)?> <?php echo _l('Customers grids',1)?>', ''],
                    ['type_customersimport', 'obj', '<?php echo _l('Customers:',1)?> <?php echo _l('Customers import',1)?>', ''],
                    ['type_orders', 'obj', '<?php echo _l('Orders:',1)?> <?php echo _l('Orders grids',1)?>', ''],
                    ['type_cms', 'obj', '<?php echo _l('CMS:',1)?> <?php echo _l('CMS',1)?>', ''],
                ['type_gmapartner', 'obj', '<?php echo _l('Addons:',1)?> <?php echo _l('Affiliation program',1)?> - <?php echo _l('Partners',1)?>', '']
        ];
		dhxlSCGridsEditorPro.tbCustomFields.addButtonSelect("type", 0, "<?php echo _l('Catalog:')?> <?php echo _l('Products grids')?>", opts, "lib/img/table_go.png", "lib/img/table_go.png",false,true);
		dhxlSCGridsEditorPro.tbCustomFields.setItemToolTip('type','<?php echo _l('Grid type',1)?>');
		dhxlSCGridsEditorPro.tbCustomFields.attachEvent("onClick",
			function(id){
			if (id=='type_products')
			{
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_products');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Products grids')?>");
				pro_type_selected = "type_products";
				loadProductFields();
				displayCustomFields();
			}
			else if (id=='type_combinations')
			{
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_combinations');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Combinations grid')?>");
				pro_type_selected = "type_combinations";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_combinationmultiproduct')
			{
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_combinationmultiproduct');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Multi-product combinations')?>");
				pro_type_selected = "type_combinationmultiproduct";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_customers')
			{
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_customers');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Customers:')?> <?php echo _l('Customers grids')?>");
				pro_type_selected = "type_customers";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_orders')
			{
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_orders');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Orders:')?> <?php echo _l('Orders grids')?>");
				pro_type_selected = "type_orders";
				loadCommunFields();
				displayCustomFields();
			}
            else if (id=='type_productimport')
            {
                dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_productimport');
                dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Product import')?>");
                pro_type_selected = "type_productimport";
                loadImportFields();
                displayCustomFields();
            }
            else if (id=='type_customersimport')
            {
                dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_customersimport');
                dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Customers import')?>");
                pro_type_selected = "type_customersimport";
                loadCustomersImportFields();
                displayCustomFields();
            }
			else if (id=='type_productexport')
			{
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_productexport');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Product export')?>");
				pro_type_selected = "type_productexport";
				loadExportFields();
				displayCustomFields();
			}
			else if (id=='type_productsort')
			{
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_productsort');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Products positions')?>");
				pro_type_selected = "type_productsort";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_msproduct')
			{
				
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_msproduct');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('MS - products information')?>");
				pro_type_selected = "type_msproduct";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_mscombination')
			{
				
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_mscombination');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('MS - combinations')?>");
				pro_type_selected = "type_mscombination";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_image')
			{
				
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_image');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Product images')?>");
				pro_type_selected = "type_image";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_propspeprice')
			{
				
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_propspeprice');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Properties - specific prices')?>");
				pro_type_selected = "type_propspeprice";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_winspeprice')
			{
				
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_winspeprice');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Window - specific prices')?>");
				pro_type_selected = "type_winspeprice";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_propsupplier')
			{
				
				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_propsupplier');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', "<?php echo _l('Catalog:')?> <?php echo _l('Suppliers')?>");
				pro_type_selected = "type_propsupplier";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_gmapartner')
			{

				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_gmapartner');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', '<?php echo _l('Addons:',1)?> <?php echo _l('Affiliation program',1)?> - <?php echo _l('Partners',1)?>');
				pro_type_selected = "type_gmapartner";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_cms')
			{

				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_cms');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', '<?php echo _l('CMS:',1)?> <?php echo _l('CMS',1)?>');
				pro_type_selected = "type_cms";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='type_categories')
			{

				dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_categories');
				dhxlSCGridsEditorPro.tbCustomFields.setItemText('type', '<?php echo _l('Catalog:',1)?> <?php echo _l('Categories',1)?>');
				pro_type_selected = "type_categories";
				loadCommunFields();
				displayCustomFields();
			}
			else if (id=='add')
			{
				var name = prompt('<?php echo _l('Please enter ID field', 1)?>',"");

				if (name!=undefined && name!=null && name!="")
				{
					if(pro_type_selected!="type_productimport" && pro_type_selected!="type_productexport" && pro_type_selected!="type_customersimport")
					{
						$.post("index.php?ajax=1&act=all_win-gridseditorpro_fields_update&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"action":"insert","type":pro_type_selected,"name":name},function(data){
							displayCustomFields();
						});
					}
					else
					{
						var newId = new Date().getTime();
						newRow=new Array(name,name);
						dhxlSCGridsEditorPro.gridCustomFields.addRow(newId,newRow);
						
						var fields = new Array();
						var i = 0;
						dhxlSCGridsEditorPro.gridCustomFields.forEachRow(function(rId){
							fields[i] = new Array();
							dhxlSCGridsEditorPro.gridCustomFields.forEachCell(rId,function(cellObj,ind){
								fields[i][ind] = dhxlSCGridsEditorPro.gridCustomFields.cells(rId,ind).getValue();
							});
							i++;
						});
	
						$.post("index.php?ajax=1&act=all_win-gridseditorpro_fields_update&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"action":"update","type":pro_type_selected,"fields":fields},function(data){
						});
					}
				} 
				
			}
			else if (id=='delete')
			{
				if(confirm('<?php echo _l('Are you sure that you want to delete this field?',1)?>'))
				{
					var ids = dhxlSCGridsEditorPro.gridCustomFields.getSelectedRowId();
					if(pro_type_selected!="type_productimport" && pro_type_selected!="type_productexport" && pro_type_selected!="type_customersimport")
					{
						$.post("index.php?ajax=1&act=all_win-gridseditorpro_fields_update&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"action":"delete","type":pro_type_selected,"ids":ids},function(data){
							displayCustomFields();
						});
					}
					else
					{
						ids=ids.split(',');
						$.each(ids, function(num, rId){
							dhxlSCGridsEditorPro.gridCustomFields.deleteRow(rId);
						});
						
						var fields = new Array();
						var i = 0;
						dhxlSCGridsEditorPro.gridCustomFields.forEachRow(function(rId){
							fields[i] = new Array();
							dhxlSCGridsEditorPro.gridCustomFields.forEachCell(rId,function(cellObj,ind){
								fields[i][ind] = dhxlSCGridsEditorPro.gridCustomFields.cells(rId,ind).getValue();
							});
							i++;
						});
		
						$.post("index.php?ajax=1&act=all_win-gridseditorpro_fields_update&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"action":"update","type":pro_type_selected,"fields":fields},function(data){
						});
					}
				}
			}
		});
	
	
		dhxlSCGridsEditorPro.gridCustomFields=dhxlSCGridsEditorPro.cells('a').attachGrid();
		dhxlSCGridsEditorPro.gridCustomFields.setImagePath("lib/js/imgs/");
		dhxlSCGridsEditorPro.gridCustomFields.enableSmartRendering(false);
		dhxlSCGridsEditorPro.gridCustomFields.enableMultiselect(false);

		dhxlSCGridsEditorPro.gridCustomFields.attachEvent("onRowSelect", function(id,ind){
			pro_field_selected=id;
			if(pro_type_selected!="type_productimport" && pro_type_selected!="type_productexport" && pro_type_selected!="type_customersimport")
				displayAdvProperties(pro_advprop_selected);
		});
		dhxlSCGridsEditorPro.gridCustomFields.attachEvent("onClick", function(id,ind){
			pro_field_selected=id;
			if(pro_type_selected!="type_productimport" && pro_type_selected!="type_productexport" && pro_type_selected!="type_customersimport")
				displayAdvProperties(pro_advprop_selected);
		});
		dhxlSCGridsEditorPro.gridCustomFields.attachEvent("onEditCell", function(stage,rId,cInd,nValue,oValue){
			idxName=dhxlSCGridsEditorPro.gridCustomFields.getColIndexById('name');
			idxType=dhxlSCGridsEditorPro.gridCustomFields.getColIndexById('celltype');
			idxTable=dhxlSCGridsEditorPro.gridCustomFields.getColIndexById('table');
			idxRefreshCombi=dhxlSCGridsEditorPro.gridCustomFields.getColIndexById('refreshcombi');
			if(stage==2 && nValue!=oValue)
			{
				var name = rId;

				if(pro_type_selected!="type_productimport" && pro_type_selected!="type_productexport" && pro_type_selected!="type_customersimport")
				{
					var value_field = "";
					if(cInd==idxName)
						value_field = "name";
					else if(cInd==idxType)
						value_field = "celltype";
					else if(cInd==idxTable)
						value_field = "table";
					else if(cInd==idxRefreshCombi)
						value_field = "refreshcombi";
					
					if (name!=undefined && name!=null && name!="" && value_field!="")
					{
						$.post("index.php?ajax=1&act=all_win-gridseditorpro_fields_update&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"action":"update","type":pro_type_selected,"name":name,"field":rId,"value":value_field,"newvalue":nValue},function(data){
							displayCustomFields();
						});
					}
				}
				else if(pro_type_selected=="type_productexport" || pro_type_selected=="type_productimport" || pro_type_selected=="type_customersimport")
				{
					var fields = new Array();
					var i = 0;
					dhxlSCGridsEditorPro.gridCustomFields.forEachRow(function(rId){
						fields[i] = new Array();
						dhxlSCGridsEditorPro.gridCustomFields.forEachCell(rId,function(cellObj,ind){
							fields[i][ind] = dhxlSCGridsEditorPro.gridCustomFields.cells(rId,ind).getValue();
						});
						i++;
					});

					$.post("index.php?ajax=1&act=all_win-gridseditorpro_fields_update&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"action":"update","type":pro_type_selected,"fields":fields},function(data){
					});
				}
			}
			return true;
		});

		dhxlSCGridsEditorPro.tbCustomFields.setListOptionSelected('type','type_products');
		displayCustomFields();
		
		// Propri�t�s avanc�es du champ
		dhxlSCGridsEditorPro.cells('b').setText("<?php echo _l('Advanced properties') ?>");
	
		dhxlSCGridsEditorPro.tbAdvProp=dhxlSCGridsEditorPro.cells('b').attachToolbar();
		dhxlSCGridsEditorPro.tbAdvProp.addButton('save',100,'','lib/img/page_save.png','lib/img/page_save.png');
		dhxlSCGridsEditorPro.tbAdvProp.setItemToolTip('save','<?php echo _l('Save',1)?>');
		dhxlSCGridsEditorPro.tbAdvProp.addButton("help", 0, "", "lib/img/help.png", "lib/img/help.png");
		dhxlSCGridsEditorPro.tbAdvProp.setItemToolTip('help','<?php echo _l('Help')?>');


		var opts = [['select_options', 'obj', '<?php echo _l('Select options',1)?>', ''],
					['SQLSelectDataSelect', 'obj', 'SQL Select', ''],
					['SQLSelectDataLeftJoin', 'obj', 'SQL Left join', ''],
					['rowData', 'obj', 'PHP Get Row data', ''],
					['afterGetRows', 'obj', 'Grid JS afterGetRows', ''],
					['onBeforeUpdate', 'obj', 'Grid JS onBeforeUpdate', ''],
					['onEditCell', 'obj', 'Grid JS onEditCell', ''],
					['onAfterUpdate', 'obj', 'Grid JS onAfterUpdate', ''],
					['definition', 'obj', 'PHP definition', ''],
					['onBeforeUpdateSQL', 'obj', 'PHP onBeforeUpdateSQL', ''],
					['onAfterUpdateSQL', 'obj', 'PHP onAfterUpdateSQL', '']
					];

		var opts_pdt = [['select_options', 'obj', '<?php echo _l('Select options',1)?>', ''],
					['SQLSelectDataSelect', 'obj', 'SQL Select', ''],
					['SQLSelectDataLeftJoin', 'obj', 'SQL Left join', ''],
					['SQLSelectDataWhere', 'obj', 'SQL Where', ''],
					['rowData', 'obj', 'PHP Get Row data', ''],
					['afterGetRows', 'obj', 'Grid JS afterGetRows', ''],
					['onBeforeUpdate', 'obj', 'Grid JS onBeforeUpdate', ''],
					['onEditCell', 'obj', 'Grid JS onEditCell', ''],
					['onAfterUpdate', 'obj', 'Grid JS onAfterUpdate', ''],
					['definition', 'obj', 'PHP definition', ''],
					['onBeforeUpdateSQL', 'obj', 'PHP onBeforeUpdateSQL', ''],
					['onAfterUpdateSQL', 'obj', 'PHP onAfterUpdateSQL', '']
					];

        var opts_customersimport = [['importProcessCustomer', 'obj', '<?php echo _l('Import process',1)?>', ''],
            ['importProcessCustomerAfter', 'obj', '<?php echo _l('Import process end line',1)?>', ''],
            ['importProcessAfterCreateAll', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('After import process',1)?>', ''],
            ['importMappingPrepareGrid', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Mapping',1)?> - <?php echo _l('Set options background color',1)?>', ''],
            ['importMappingCheckGrid', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Mapping',1)?> - <?php echo _l('Check options before import',1)?>', ''],
            ['importMappingFillCombo', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Mapping',1)?> - <?php echo _l('Fill options select',1)?>', '']

        ];

        var opts_import = [['importProcessProduct', 'obj', '<?php echo _l('Import process',1)?>', ''],
            ['importProcessCombination', 'obj', '<?php echo _l('Import combinations process',1)?>', ''],
            ['definitionForLangField', 'obj', '<?php echo _l('Selectable language',1)?>', ''],
            ['definitionForOptionField', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Selectable option',1)?>', ''],
            ['importMappingLoadMappingOption', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Mapping',1)?> - <?php echo _l('Set options when loading mapping',1)?>', ''],
            ['importMappingPrepareGrid', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Mapping',1)?> - <?php echo _l('Set options background color',1)?>', ''],
            ['importMappingCheckGrid', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Mapping',1)?> - <?php echo _l('Check options before import',1)?>', ''],
            ['importMappingFillCombo', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Mapping',1)?> - <?php echo _l('Fill options select',1)?>', ''],
            ['importProcessIdentifier', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Customized identifier',1)?>', ''],
            ['importProcessImageUpdate', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Import images process',1)?>', ''],
            ['importProcessInitRowVars', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Before import process',1)?>', ''],
            ['importProcessAfterCreateAll', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('After import process',1)?>', '']
        ];
		
		var opts_export = [['exportProcessProduct', 'obj', '<?php echo _l('Export process',1)?>', ''],
		           	['definitionLang', 'obj', '<?php echo _l('Selectable language',1)?>', ''],					
					['exportProcessInitRowVars', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Before export process',1)?>', ''],
					['addInCombiFields', 'obj', '<?php echo _l('Advanced',1)?> - <?php echo _l('Combinations fields',1)?>', '']
					];
		dhxlSCGridsEditorPro.tbAdvProp.addButtonSelect("adv_properties", 0, "<?php echo _l('Advanced properties')._l(':')?> <?php echo _l('Select options')?>", opts_pdt, "lib/img/table_go.png", "lib/img/table_go.png",false,true);
		dhxlSCGridsEditorPro.tbAdvProp.setItemToolTip('adv_properties','<?php echo _l('Advanced properties',1)?>');
		dhxlSCGridsEditorPro.tbAdvProp.attachEvent("onClick", function(id){
			$.each(opts,function(num, vars){
				if (id==vars[0])
				{
					dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties', vars[0]);
					dhxlSCGridsEditorPro.tbAdvProp.setItemText('adv_properties', "<?php echo _l('Advanced properties')._l(':')?> "+vars[2]);
					pro_advprop_selected = vars[0];
					displayAdvProperties(vars[0]);
				}
			});	
			$.each(opts_pdt,function(num, vars){
				if (id==vars[0])
				{
					dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties', vars[0]);
					dhxlSCGridsEditorPro.tbAdvProp.setItemText('adv_properties', "<?php echo _l('Advanced properties')._l(':')?> "+vars[2]);
					pro_advprop_selected = vars[0];
					displayAdvProperties(vars[0]);
				}
			});	
			$.each(opts_export,function(num, vars){
				if (id==vars[0])
				{
					dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties', vars[0]);
					dhxlSCGridsEditorPro.tbAdvProp.setItemText('adv_properties', "<?php echo _l('Advanced properties')._l(':')?> "+vars[2]);
					pro_advprop_selected = vars[0];
					displayAdvProperties(vars[0]);
				}
			});
            $.each(opts_import,function(num, vars){
                if (id==vars[0])
                {
                    dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties', vars[0]);
                    dhxlSCGridsEditorPro.tbAdvProp.setItemText('adv_properties', "<?php echo _l('Advanced properties')._l(':')?> "+vars[2]);
                    pro_advprop_selected = vars[0];
                    displayAdvProperties(vars[0]);
                }
            });
            $.each(opts_customersimport,function(num, vars){
                if (id==vars[0])
                {
                    dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties', vars[0]);
                    dhxlSCGridsEditorPro.tbAdvProp.setItemText('adv_properties', "<?php echo _l('Advanced properties')._l(':')?> "+vars[2]);
                    pro_advprop_selected = vars[0];
                    displayAdvProperties(vars[0]);
                }
            });
            if (id=='save')
			{
				var id = dhxlSCGridsEditorPro.gridCustomFields.getSelectedRowId();
				var field_value = dhxlSCGridsEditorPro._advPropertiesLayout.cells('a').getFrame().contentWindow.getFieldValue();
				$.post("index.php?ajax=1&act=all_win-gridseditorpro_prop_update&id_lang="+SC_ID_LANG+"&"+new Date().getTime(),{"action":"update","type":pro_type_selected,"id":id,"field":pro_advprop_selected,"field_value":field_value},function(data){
					if(pro_advprop_selected=="afterGetRows")
						dhtmlx.message({text:'<?php echo _l('You need to refresh Store Commander to use the new settings.',1)?>',type:'error'});
				});
			}
			if (id=='help')
			{
<?php
	if ($user_lang_iso=='fr')
	{
?>
				window.open('http://www.storecommander.com/redir.php?dest=854954');
<?php
	}else{
?>
				window.open('http://www.storecommander.com/redir.php?dest=854983');
<?php
	}
?>
			}
		});
		
		displayAdvProperties('');
			
	//#####################################
	//############ Load functions
	//#####################################

	function displayCustomFields()
	{
		dhxlSCGridsEditorPro.gridCustomFields.clearAll(true);
		dhxlSCGridsEditorPro.gridCustomFields.load("index.php?ajax=1&act=all_win-gridseditorpro_fields_get&id_lang="+SC_ID_LANG+"&type="+pro_type_selected+"&"+new Date().getTime(),function(){});
	}
	
	function displayAdvProperties(property)
	{
		dhxlSCGridsEditorPro._advPropertiesLayout = dhxlSCGridsEditorPro.cells('b').attachLayout('1C');
		dhxlSCGridsEditorPro._advPropertiesLayout.cells('a').hideHeader();
		dhxlSCGridsEditorPro._advPropertiesLayout.cells('a').attachURL('index.php?ajax=1&act=all_win-gridseditorpro_prop_get&type='+pro_type_selected+'&field='+pro_field_selected+'&prop='+property+"&"+new Date().getTime());
	}

	function clearFields()
	{
		dhxlSCGridsEditorPro.tbAdvProp.forEachListOption('adv_properties', function(optionId){
			dhxlSCGridsEditorPro.tbAdvProp.removeListOption('adv_properties', optionId);
		});	
	}
	function loadCommunFields()
	{
		clearFields();
		$.each(opts,function(num, vars){
			if(num==0)
			{
				dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties','select_options');
				dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties', vars[0]);
				dhxlSCGridsEditorPro.tbAdvProp.setItemText('adv_properties', "<?php echo _l('Advanced properties')._l(':')?> "+vars[2]);
				pro_advprop_selected = vars[0];
				displayAdvProperties(vars[0]);
			}
			dhxlSCGridsEditorPro.tbAdvProp.addListOption('adv_properties', vars[0], (num*1+1), "button", vars[2], null);
		});	
	}
	function loadProductFields()
	{
		clearFields();
		$.each(opts_pdt,function(num, vars){
			if(num==0)
			{
				dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties','select_options');
				dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties', vars[0]);
				dhxlSCGridsEditorPro.tbAdvProp.setItemText('adv_properties', "<?php echo _l('Advanced properties')._l(':')?> "+vars[2]);
				pro_advprop_selected = vars[0];
				displayAdvProperties(vars[0]);
			}
			dhxlSCGridsEditorPro.tbAdvProp.addListOption('adv_properties', vars[0], (num*1+1), "button", vars[2], null);
		});	
	}
	function loadExportFields()
	{
		clearFields();
		$.each(opts_export,function(num, vars){
			if(num==0)
			{
				dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties', vars[0]);
				dhxlSCGridsEditorPro.tbAdvProp.setItemText('adv_properties', "<?php echo _l('Advanced properties')._l(':')?> "+vars[2]);
				pro_advprop_selected = vars[0];
				displayAdvProperties(vars[0]);
			}
			dhxlSCGridsEditorPro.tbAdvProp.addListOption('adv_properties', vars[0], (num*1+1), "button", vars[2], null);
		});	
	}
    function loadImportFields()
    {
        clearFields();
        $.each(opts_import,function(num, vars){
            if(num==0)
            {
                dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties', vars[0]);
                dhxlSCGridsEditorPro.tbAdvProp.setItemText('adv_properties', "<?php echo _l('Advanced properties')._l(':')?> "+vars[2]);
                pro_advprop_selected = vars[0];
                displayAdvProperties(vars[0]);
            }
            dhxlSCGridsEditorPro.tbAdvProp.addListOption('adv_properties', vars[0], (num*1+1), "button", vars[2], null);
        });
    }
    function loadCustomersImportFields()
    {
        clearFields();
        $.each(opts_customersimport,function(num, vars){
            if(num==0)
            {
                dhxlSCGridsEditorPro.tbAdvProp.setListOptionSelected('adv_properties', vars[0]);
                dhxlSCGridsEditorPro.tbAdvProp.setItemText('adv_properties', "<?php echo _l('Advanced properties')._l(':')?> "+vars[2]);
                pro_advprop_selected = vars[0];
                displayAdvProperties(vars[0]);
            }
            dhxlSCGridsEditorPro.tbAdvProp.addListOption('adv_properties', vars[0], (num*1+1), "button", vars[2], null);
        });
    }
</script>
