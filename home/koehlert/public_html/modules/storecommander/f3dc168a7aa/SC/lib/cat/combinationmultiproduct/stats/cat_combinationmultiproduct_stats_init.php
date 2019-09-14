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
$subprop_name = 'combinationmultiproduct_stats';
$subprop_title = _l('Stats',1);
$icon = 'chart_curve.png';
?>

// INIT TOOLBAR
prop_tb.attachEvent("onClick", function setPropertiesPanel_combinationmultiproduct(id){
    if (id=='combinationmultiproduct')
	{
		prop_tb.combimulprd_subproperties_tb.addListOption('combimulprdSubProperties', '<?php echo $subprop_name; ?>', 9, "button", '<?php echo $subprop_title; ?>', "lib/img/<?php echo $icon; ?>");


        prop_tb.combimulprd_subproperties_tb.attachEvent("onClick", function(id){
			if(id=="<?php echo $subprop_name; ?>")
			{
				hideCombinationMultiProduct_SubpropertiesItems();
				prop_tb.combimulprd_subproperties_tb.setItemText('combimulprdSubProperties', '<?php echo $subprop_title; ?>');
				prop_tb.combimulprd_subproperties_tb.setItemImage('combimulprdSubProperties', 'lib/img/<?php echo $icon; ?>');
				actual_subproperties = "<?php echo $subprop_name; ?>";
				initCombinationMultiProductStats();
			}
		});

		prop_tb._combinationmultiproductGrid.attachEvent("onRowSelect", function(id,ind){
			if (!prop_tb._combinationmultiproductLayout.cells('b').isCollapsed())
			{
				if(actual_subproperties == "<?php echo $subprop_name; ?>"){
			 		getCombinationMultiProductStats();
				}
			}
		});


        prop_tb.combimulprd_subproperties_tb.addButton("stats_refresh", 100, "", "lib/img/arrow_refresh.png", "lib/img/arrow_refresh.png");
        prop_tb.combimulprd_subproperties_tb.setItemToolTip('stats_refresh','<?php echo _l('Refresh',1)?>');
        var options_stats_text_lang = {
            'product_quantity':"<?php echo _l('Total amount of combinations sold')?>",
            'product_total_price':"<?php echo _l('Total sales tax excl.')?>"
        };
        var options_stats_view = [
            ['product_quantity', 'obj', options_stats_text_lang['product_quantity'], ''],
            ['product_total_price', 'obj', options_stats_text_lang['product_total_price'], '']
        ];
        prop_tb.combimulprd_subproperties_tb.addButtonSelect('options_view',100,'<?php echo _l('Total amount of combinations sold')?>',options_stats_view,'lib/img/flag_blue.png','lib/img/flag_blue.png',false,true);

        prop_tb.combimulprd_subproperties_tb.attachEvent("onClick", function(id){
            if (id=='stats_refresh'){
                getCombinationMultiProductStats();
            }
            if (id=='product_quantity'){
                options_stats_view_selected = 0;
                prop_tb.combimulprd_subproperties_tb.setItemText('options_view', options_stats_text_lang[id]);
                getCombinationMultiProductStats();
            }
            if (id=='product_total_price'){
                options_stats_view_selected = 1;
                prop_tb.combimulprd_subproperties_tb.setItemText('options_view', options_stats_text_lang[id]);
                getCombinationMultiProductStats();
            }
        });
    }
});

// INIT GRID
function initCombinationMultiProductStats() {
    hideCombinationMultiProduct_SubpropertiesItems();
    prop_tb.combimulprd_subproperties_tb.showItem('stats_refresh');
    prop_tb.combimulprd_subproperties_tb.showItem('options_view');
    prop_tb._combinationmultiproductLayout.cells('b').setWidth(680);
    prop_tb._combinationsMultiProductStatLayout = prop_tb._combinationmultiproductLayout.cells('b').attachLayout('1C');
    prop_tb._combinationsMultiProductStatLayout.cells('a').hideHeader();
    var options_stats_view_selected = 0;
    getCombinationMultiProductStats();
}

// FUNCTIONS
function getCombinationMultiProductStats(){
    prop_tb._combinationsMultiProductStatLayout.cells('a').attachURL('index.php?ajax=1&act=cat_combinationmultiproduct_stats_get&stat_view='+options_stats_view_selected+'&id_product_attribute='+prop_tb._combinationmultiproductGrid.getSelectedRowId(),true);
}