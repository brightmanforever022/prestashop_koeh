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
<script type="text/javascript">
    dhxlOrdFilterFromTo = wOrdFilterFromTo.attachLayout("1C");
    dhxlOrdFilterFromTo.cells('a').hideHeader();
<?php
    $invoice = Tools::getValue('inv',null);
    $iso_lang = Language::getIsoById((int)$sc_agent->id_lang);
    if($iso_lang == 'fr') {
        ## Traductions
        $month_full = array(_l("January"), _l("February"), _l("March"), _l("April"), _l("May"), _l("June"), _l("July"), _l("August"), _l("September"), _l("October"), _l("November"), _l("December"));
        $month_short = array(_l("Jan"), _l("Feb"), _l("Mar"), _l("Apr"), _l("May"), _l("Jun"), _l("Jul"), _l("Aug"), _l("Sep"), _l("Oct"), _l("Nov"), _l("Dec"));
        $day_full = array(_l("Sunday"), _l("Monday"), _l("Tuesday"), _l("Wednesday"), _l("Thursday"), _l("Friday"), _l("Saturday"));
        $day_short = array(_l("Sun."), _l("Mon."), _l("Tue."), _l("Wed."), _l("Thu."), _l("Fri."), _l("Sat."));
        $quarter = array(_l("Q1"), _l("Q2"), _l("Q3"), _l("Q4"));
        echo 'var month_full_arr = ["' . implode('","', $month_full) . '"];' . "\n";
        echo 'var month_short_arr = ["' . implode('","', $month_short) . '"];' . "\n";
        echo 'var day_full_arr = ["' . implode('","', $day_full) . '"];' . "\n";
        echo 'var day_short_arr = ["' . implode('","', $day_short) . '"];' . "\n";
        echo 'var quarter_arr = ["' . implode('","', $quarter) . '"];' . "\n";
?>
    dhtmlXCalendarObject.prototype.langData["fr"] = {
        dateformat: '%Y-%m-%d %H:%i:%s',
        monthesFNames: month_full_arr,
        monthesSNames: month_short_arr,
        daysFNames: day_full_arr,
        daysSNames: day_short_arr,
        weekstart: 1,
        weekname: "w",
        today: "<?php echo _l('Today');?>",
        clear: "<?php echo _l('Reset');?>"
    };
    dhtmlXCalendarObject.prototype.lang = "fr";
<?php
    }
?>

    let block_width= 300;
    let date_form = [
        {type: "settings", offsetLeft:0, position: "label-left", labelWidth: 30, inputWidth: 200, labelAlign: "left"},
        {type: "block",offsetLeft:0,width: block_width,list:[
            {
                type: "calendar",
                name: "from",
                label: "<?php echo _l('From')?>",
                enableTime: true,
                enableTodayButton: true,
                calendarPosition: "right"
            },
        ]},
        {type: "block",offsetLeft:0,width: block_width,list:[
            {
                type: "calendar",
                name: "to",
                label: "<?php echo _l('To')?>",
                enableTime: true,
                enableTodayButton: true,
                calendarPosition: "right"
            },
            {type: "button", offsetLeft:30, name: "submit", value: "<?php echo _l('Submit',1)?>"},
        ]},
        {type: "block",offsetTop:20,width: block_width,list:[
                {
                    type: "calendar",
                    name: "entire_day",
                    dateFormat: "%Y-%m-%d",
                    label: "<?php echo _l('The')?>",
                    enableTime: false,
                    enableTodayButton: true,
                    calendarPosition: "right"
                },
            ]},
    ];

    let date_filter_form = dhxlOrdFilterFromTo.cells('a').attachForm(date_form);
    let format_info = '<?php echo _l('yyyy-mm-dd h:m:s'); ?>';
    date_filter_form.getInput("from").setAttribute("autocomplete","off");
    date_filter_form.getInput("from").setAttribute("placeholder",format_info);
    date_filter_form.getInput("to").setAttribute("autocomplete","off");
    date_filter_form.getInput("to").setAttribute("placeholder",format_info);
    date_filter_form.getInput("entire_day").setAttribute("autocomplete","off");
    date_filter_form.getInput("entire_day").setAttribute("placeholder",format_info);
    var calendar_from = date_filter_form.getCalendar("from");
    var calendar_to = date_filter_form.getCalendar("to");
    var calendar_entire_day = date_filter_form.getCalendar("entire_day");
    date_filter_form.attachEvent("onButtonClick", function (id) {
        if(id=='submit') {
            let date_from = date_filter_form.getItemValue('from');
            let date_to = date_filter_form.getItemValue('to');
            if ((date_from == "" || date_from== null)
                || (date_to == "" || date_to== null)) {
                parent.dhtmlx.message({
                    text: '<?php echo _l('You must write the two dates.', 1)?>',
                    type: 'error',
                    expire: 10000
                });
            } else if (date_to < date_from) {
                parent.dhtmlx.message({
                    text: '<?php echo _l('Your dates are wrong.', 1)?>',
                    type: 'error',
                    expire: 10000
                });
            } else {
                filteringGrid();
            }
        }
    });
    date_filter_form.attachEvent("onChange", function (id) {
        if(id=='entire_day'){
            let entire_day= date_filter_form.getItemValue('entire_day',true);
            let entire_day_from = entire_day+" 00:00:00";
            let entire_day_to = entire_day+" 23:59:59";
            filteringGrid(entire_day_from,entire_day_to);
        }
    });

    function filteringGrid(dt_from = '', dt_to = '')
    {
        var date_from = dt_from;
        if(dt_from == '') {
            date_from = calendar_from.getFormatedDate("%Y-%m-%d %H:%i:%s");
        }
        var date_to = dt_to;
        if(dt_to == '') {
            date_to = calendar_to.getFormatedDate("%Y-%m-%d %H:%i:%s");
        }
<?php if(!empty($invoice)) { ?>
        $.cookie('sc_ord_inv_fromto_dates',date_from+"_"+date_to, { expires: 60 });
        parent.periodselection = "inv_from_to_"+date_from+"_"+date_to;
        $.cookie('sc_ord_periodselection',parent.periodselection, { expires: 60 });
        parent.ord_filter.setItemText('inv_from_to','<?php echo _l('Inv from'); ?> '+date_from+" <?php echo _l('to'); ?> "+date_to);
<?php } else { ?>
        $.cookie('sc_ord_fromto_dates',date_from+"_"+date_to, { expires: 60 });
        parent.periodselection = "from_to_"+date_from+"_"+date_to;
        $.cookie('sc_ord_periodselection',parent.periodselection, { expires: 60 });
        parent.ord_filter.setItemText('from_to','<?php echo _l('Ord from'); ?> '+date_from+" <?php echo _l('to'); ?> "+date_to);
<?php } ?>
       parent.displayOrders();
        calendar_from.hide();
        calendar_to.hide();
        calendar_entire_day.hide();
       parent.wOrdFilterFromTo.hide();
    }
</script>