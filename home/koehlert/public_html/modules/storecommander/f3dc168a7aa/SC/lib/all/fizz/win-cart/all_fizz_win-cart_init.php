<?php
if (!isTable('sc_fizz_cart'))
{
    $sql="
    CREATE TABLE `"._DB_PREFIX_."sc_fizz_cart` (
      `id_fizz_cart` int(11) NOT NULL AUTO_INCREMENT,
      `product` varchar(255) NOT NULL,
      `quantity` int(11) NOT NULL DEFAULT '1',
		PRIMARY KEY (`id_fizz_cart`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
    Db::getInstance()->Execute($sql);
}
?><script type="text/javascript">
    // INIT
    var selected_funnel = "all";
    var selected_section = "all";
    var selected_display = false;

    var funnel_list = {};
    var section_list = {};
    var eServices_list = {};
    <?php
    require_once (dirname(__FILE__)."/eservices_list.php");
    foreach ($funnel_list as $key=>$name)
        echo 'funnel_list[\''.$key.'\']=\''.$name.'\';'."\n";
    foreach ($section_list as $key=>$name)
        echo 'section_list[\''.$key.'\']=\''.$name.'\';'."\n";
    phpToJs($eServices_list, "eServices_list");
    ?>

    // FUNCTIONS
    function geteServices(funnel,section, display,number)
    {
        if(display==undefined)
            display = false;
        if(number==undefined)
            number = false;

        if(number)
            var services = 0;
        else
            var services = new Object();

        for (var index in eServices_list) {
            if (eServices_list.hasOwnProperty(index))
            {
                var eService = eServices_list[index];
                if(display==false || (display==true && eService.display==1))
                {
                    var groups = eService.groups;

                    for (var i in groups)
                    {
                        if (groups.hasOwnProperty(i))
                        {
                            group = groups[i];
                            if (funnel != undefined && funnel != null && funnel != "" && funnel != 0 && section != undefined && section != null && section != "" && section != 0)
                            {
                                if ((funnel == group.funnel || funnel=="all") && (section == group.section || section=="all"))
                                {
                                    if(number)
                                        services = services*1 + 1;
                                    else
                                        services[index] = index;
                                }
                            }
                            else if (funnel != undefined && funnel != null && funnel != "" && funnel != 0)
                            {
                                if (funnel == group.funnel || funnel=="all")
                                {
                                    if(number)
                                        services = services*1 + 1;
                                    else
                                        services[index] = index;
                                }
                            }
                            else if (section != undefined && section != null && section != "" && section != 0)
                            {
                                if (section == group.section || section=="all")
                                {
                                    if(number)
                                        services = services*1 + 1;
                                    else
                                        services[index] = index;
                                }
                            }
                        }
                    }
                }
            }
        }
        return services;
    }

    function getSectionsByFunnel(funnel)
    {
        var sections = new Object();
        if(funnel!=undefined && funnel!=null && funnel!=0 && funnel!="")
        {
            var eServices = geteServices(funnel,"all",selected_display);
            for (var index in eServices)
            {
                if (eServices.hasOwnProperty(index))
                {
                    var eService = eServices_list[index];

                    var groups = eService.groups;
                    for (var i in groups)
                    {
                        if (groups.hasOwnProperty(i))
                        {
                            group = groups[i];
                            if(funnel == group.funnel || funnel=="all")
                                sections[group.section] = section_list[group.section];
                        }
                    }
                }
            }
        }
        return sections;
    }

    function loadFunnel(funnel)
    {
        if(funnel!=undefined && funnel!=null && funnel!=0 && funnel!="")
        {
            cell_listeServices.detachObject();
            sidebar_listeServices = null;
            sidebar_listeServices = cell_listeServices.attachSidebar({
                template: "text",
                width: 200
            });
            sidebar_listeServices.attachEvent("onSelect", function(id, lastId){
                selected_section = id;
                //sidebar_listeServices.cells(id).detachObject();

                var funnel = null;
                if(selected_funnel!=undefined && selected_funnel!=null && selected_funnel!="" && selected_funnel!=0)
                    funnel = selected_funnel;

                var patt = new RegExp("_all");
                if(patt.test(id))
                {
                    var id = id.replace("_all","");
                }

                loadDataView(funnel,id);
            });


            selected_funnel = funnel;
            var sections = getSectionsByFunnel(funnel);

            var nb_eServices = geteServices(funnel,"all", selected_display,true);
            var sidebar_listeServices_items = [{id: funnel+"_all", text: "<?php echo _l("All"); ?>", selected: true/*, bubble: nb_eServices*/}];
            for (var i in sections) {
                if (sections.hasOwnProperty(i)) {
                    var nb_eServices = geteServices(funnel,i, selected_display,true);
                    sidebar_listeServices_items[sidebar_listeServices_items.length] = {id: i, text: section_list[i]/*, bubble: nb_eServices*/};
                }
            }
            sidebar_listeServices.loadStruct({items:sidebar_listeServices_items}, function(){
                var funnel = null;
                if(selected_funnel!=undefined && selected_funnel!=null && selected_funnel!="" && selected_funnel!=0)
                    funnel = selected_funnel;

                loadDataView(funnel,"all");
            });

            if(funnel!="all")
                cell_listeServices.setText('<?php echo _l('Addons and services', 1); ?>: '+funnel_list[funnel]);
            else
                cell_listeServices.setText('<?php echo _l('Addons and services', 1); ?>');
        }
    }

    function loadDataView(funnel,section)
    {
        var cell_name = section;
        if(section=="all")
            cell_name = funnel+"_"+section;
        sidebar_listeServices.cells(cell_name).detachObject();
        sidebar_listeServices.cells(cell_name).detachToolbar();
        dataview_listeServices = null;
        toolbar_listeServices = null;

        dataview_listeServices = sidebar_listeServices.cells(cell_name).attachDataView({
            type:{
                template:"<img src='lib/img/lego.png' alt='#Name#' title='#Name#' style='float: left; margin-right: 10px; margin-bottom: 30px;' /><strong style='font-size: 14px;'>#Name#</strong>#Subtitle#<br/><span style='font-size: 14px;line-height: 30px;'>#Price#</span>",
                height:75, padding:10, margin:2, border:1
            },
            autowidth:2
        });

        var eServices = geteServices(funnel,section,selected_display);

        var content_listeServices = [];
        for (var index in eServices) {
            if (eServices.hasOwnProperty(index)) {
                var eService = eServices_list[index];
                if(eService.buyable!=undefined && eService.buyable==1)
                {
                    var price = eService["price"];
                    if(eService["currency"]=="euro")
                        price += "€";
                    else if(eService["currency"]=="fizz")
                        price += ' <img src="lib/img/fizz.png" alt="Fizz" title="Fizz" style="margin-bottom: -3px;" />';
                }
                else
                    var price = "-";
                var subtitle = "";
                if(eService.subtitle!=undefined && eService.subtitle!="")
                    subtitle = "<br/>"+eService.subtitle;
                content_listeServices[content_listeServices.length] = {
                    id: index,
                    Name:eService["name"],
                    Price:price,
                    ID:index,
                    Subtitle:subtitle,
                };
            }
        }

        dataview_listeServices.parse(content_listeServices,"json");

        dataview_listeServices.attachEvent("onAfterSelect", function (id){
            col_eServicesRight.expand();
            col_eServicesRight.progressOn();
            col_eServicesRight.attachURL('index.php?ajax=1&act=all_fizz_win-cart_prop&id_eService='+id);
        });

        toolbar_listeServices = sidebar_listeServices.cells(cell_name).attachToolbar();
        toolbar_listeServices.addButton("in_cart", 100, "", "lib/img/cart_add.png", "lib/img/cart_add.png");
        toolbar_listeServices.setItemToolTip('in_cart','<?php echo _l('Add all selected e-Services in cart')?>');
        toolbar_listeServices.addButtonTwoState("display_available", 100, "", "lib/img/eye.png", "lib/img/eye.png");
        toolbar_listeServices.setItemToolTip('display_available','<?php echo _l('Show available e-Services only for your shop')?>');
        if(selected_display==true)
            toolbar_listeServices.setItemState('display_available', true);

        toolbar_listeServices.attachEvent("onClick",function(id){
            if(id=="in_cart")
            {
                var ids = dataview_listeServices.getSelected();
                if(ids!=undefined && ids!=null && ids!=0 && ids!="")
                {
                    var is_array = Array.isArray(ids);
                    if(is_array)
                    {
                        var tmp = "";
                        $(ids).each(function(index, id) {
                            var eService = eServices_list[id];
                            if(eService.buyable!=undefined && eService.buyable==1)
                            {
                                if(tmp!="")
                                    tmp +=",";
                                tmp +=id;
                            }
                        });
                        ids = tmp;
                    }
                    else
                    {
                        var eService = eServices_list[ids];
                        if(eService.buyable==undefined || eService.buyable==0)
                            ids = "";
                    }
                    if(ids!="")
                    {
                        $.post('index.php?ajax=1&act=all_fizz_win-cart_addcart', {products: ids}, function( data ) {
                            cell_eServicesPayment.expand();
                            cell_eServicesPayment.attachURL('index.php?ajax=1&act=all_fizz_win-cart_cart');
                        });
                    }
                }
            }
        });
        toolbar_listeServices.attachEvent("onStateChange", function(id,state){
            if (id=='display_available'){
                if (state) {
                    selected_display=true;
                }else{
                    selected_display=false;
                }
                loadFunnel(selected_funnel);
            }
        });
    }

    // LAYOUT
    dhxleServices_layout=weServices.attachLayout("3W");

    /*var cell_funel = dhxleServices_layout.cells('a');
    cell_funel.hideHeader();
    cell_funel.setWidth("250");
    cell_funel.fixSize(true, false);
    cell_funel.attachURL('index.php?ajax=1&act=all_fizz_win-cart_funnel');*/
    var col_eServicesLeft = dhxleServices_layout.cells('a');
    col_eServicesLeft.showHeader();
    col_eServicesLeft.setWidth("280");
    col_eServicesLeft.fixSize(true, false);
    var col_eServicesLeft_layout = col_eServicesLeft.attachLayout("2E");
    // FUNNEL
    var cell_funel =  col_eServicesLeft_layout.cells('a');
    cell_funel.hideHeader();
    cell_funel.attachURL('index.php?ajax=1&act=all_fizz_win-cart_funnel');

    // WALLET
    var cell_wallet =  col_eServicesLeft_layout.cells('b');
    cell_wallet.hideHeader();
    cell_wallet.setHeight("80");
    cell_wallet.fixSize(true, true);
    cell_wallet.attachURL('index.php?ajax=1&act=all_fizz_win-cart_wallet');

    var col_eServicesCenter = dhxleServices_layout.cells('b');
    col_eServicesCenter.hideHeader();
    var col_eServicesCenter_layout =col_eServicesCenter.attachLayout("2E");
    // LIST
    var cell_listeServices =  col_eServicesCenter_layout.cells('a');
    cell_listeServices.setText('<?php echo _l('Addons and services', 1); ?>');

    var dataview_listeServices = null;
    var toolbar_listeServices = null;
    var sidebar_listeServices = null;

    loadFunnel("all");

    // CART
    var cell_eServicesPayment =  col_eServicesCenter_layout.cells('b');
    cell_eServicesPayment.setText('<?php echo _l('Your cart', 1); ?>');
    <?php
    $sql="SELECT * FROM `"._DB_PREFIX_."sc_fizz_cart`";
    $cart = Db::getInstance()->ExecuteS($sql);
    if(empty($cart))
        echo 'cell_eServicesPayment.collapse();';
    ?>
    cell_eServicesPayment.attachURL('index.php?ajax=1&act=all_fizz_win-cart_cart');

    // RIGHT
    var col_eServicesRight = dhxleServices_layout.cells('c');
    col_eServicesRight.setText('<?php echo _l('Information', 1); ?>');
    col_eServicesRight.collapse();


</script>