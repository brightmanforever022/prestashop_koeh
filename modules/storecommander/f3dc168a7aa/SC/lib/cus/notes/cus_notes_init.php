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
if (version_compare(_PS_VERSION_, '1.4.0.2', '>=') && _r("GRI_CUS_PROPERTIES_GRID_NOTES")) {
    $subprop_name = 'notes';
    $subprop_title = _l('Notes', 1);
    $icon = 'chart_curve.png';
?>
    prop_tb.addListOption('panel', '<?php echo $subprop_name; ?>', 3, "button", '<?php echo $subprop_title ?>', "lib/img/<?php echo $icon ?>");
    allowed_properties_panel[allowed_properties_panel.length] = "<?php echo $subprop_name; ?>";
    prop_tb.addButton("notes_refresh", 100, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
    prop_tb.setItemToolTip('notes_refresh','<?php echo _l('Refresh', 1) ?>');
    prop_tb.addButton("notes_save", 100, "", "lib/img/page_save.png", "lib/img/page_save.png");
    prop_tb.setItemToolTip('notes_save','<?php echo _l('Save', 1) ?>');

    needinitNotes = 1;
    function initNotes(){
        if (needinitNotes)
        {
            prop_tb._notesLayout = dhxLayout.cells('b').attachLayout('1C');
            prop_tb._notesLayout.cells('a').hideHeader();
            dhxLayout.cells('b').showHeader();
            needinitNotes=0;
        }
    }


    function setPropertiesPanel_Notes(id){
        if (id=='<?php echo $subprop_name; ?>')
        {
            if(lastCustomerSelID!=undefined && lastCustomerSelID!="")
            {
                idxLastname=cus_grid.getColIndexById('lastname');
                idxFirstname=cus_grid.getColIndexById('firstname');
                dhxLayout.cells('b').setText('<?php echo _l('Properties', 1) . ' ' . _l('of', 1) ?> '+cus_grid.cells(lastCustomerSelID,idxFirstname).getValue()+" "+cus_grid.cells(lastCustomerSelID,idxLastname).getValue());
            }
            hidePropTBButtons();
            prop_tb.showItem('notes_refresh');
            prop_tb.showItem('notes_save');
            prop_tb.setItemText('panel', '<?php echo $subprop_title ?>');
            prop_tb.setItemImage('panel', 'lib/img/<?php echo $icon ?>');
            needinitNotes = 1;
            initNotes();
            propertiesPanel='<?php echo $subprop_name; ?>';
            if (lastCustomerSelID!=0)
            {
                displayNotes();
            }
        }
        if (id=='notes_refresh')
        {
            displayNotes();
        }
        if (id=='notes_save')
        {
            let note_content = $('#note_textarea').val();
            $.post('index.php?ajax=1&act=cus_notes_update',{id_customer:customers_id,content:note_content},function(data)
            {
                if(data == 'OK') {
                    dhtmlx.message({text:'<?php echo _l('Note saved'); ?>',type:'success',expire:5000});
                    displayNotes();
                } else {
                    dhtmlx.message({text:'<?php echo _l('Error'); ?>',type:'error',expire:5000});
                }
            });
        }
    }
    prop_tb.attachEvent("onClick", setPropertiesPanel_Notes);


    function displayNotes()
    {
        if(gridView!="grid_address") {
            customers_id = lastCustomerSelID;
        } else {
            idxIdCustomer = cus_grid.getColIndexById('id_customer');
            customers_id = cus_grid.cells(lastCustomerSelID,idxIdCustomer).getValue();
        }
        $.post('index.php?ajax=1&act=cus_notes_get',{id_customer:customers_id},function(data)
        {
            prop_tb._notesLayout.cells('a').attachHTMLString('<textarea id="note_textarea" style="resize: none;box-sizing: border-box;width: 100%;height: 100%;">'+data+'</textarea>');
        });
    }


    cus_grid.attachEvent("onRowSelect",function (id_product){
        if (propertiesPanel=='<?php echo $subprop_name; ?>' && !dhxLayout.cells('b').isCollapsed()){
            displayNotes();
        }
    });
<?php
}
?>