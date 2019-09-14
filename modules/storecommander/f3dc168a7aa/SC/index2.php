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

$sc_alerts= array();

require_once('init_sc.php');

$ajax = Tools::getValue('ajax', 0);


// mode ajax
if ($ajax)
{
    if (SC_TOOLS) {
        foreach ($sc_tools_list AS $tool) {
            if($tool!="pmcachemanager")
                if (file_exists(SC_TOOLS_DIR . $tool . '/hookStartAction.php'))
                    require_once(SC_TOOLS_DIR . $tool . '/hookStartAction.php');
        }
    }

    $action = Tools::getValue('act');
    $panel = Tools::getValue('p');
    $xml = Tools::getValue('x');
    if ($xml) {
        $action = $xml;
    }
    if ($panel) {
        $action = $panel;
    }
    if ($action) {

        // DHTMLX4 compatibility
        if (strpos($action, '_update') !== false && isset($_POST['ids'])) {
            $str = str_replace('.', '_', $_POST['ids']) . '_';
            foreach ($_POST as $k => $val) {
                if (strpos($k, $str) !== false) {
                    $_POST[substr($k, strlen($str), 1000)] = $val;
                }
            }
        }

        if ($ajax == 1) {
            $act = explode('_', $action);
            $overridePrefix = '';
            if (file_exists(SC_TOOLS_DIR . 'lib/' . $act[0] . '/' . $act[1])) {
                $overridePrefix = SC_TOOLS_DIR;
            }
            ob_start("cleanXMLContent");
            if (file_exists($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $act[0] . '_' . $act[1] . '_tools.php')) {
                require_once($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $act[0] . '_' . $act[1] . '_tools.php');
            }
            if (file_exists($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $action . '.php')) {
                require_once($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $action . '.php');
            } elseif (file_exists($overridePrefix . 'lib/' . $act[0] . '/' . $action . '.php')) {
                require_once($overridePrefix . 'lib/' . $act[0] . '/' . $action . '.php');
            } elseif (file_exists($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $act[2] . '/' . $action . '.php')) {
                require_once($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $act[2] . '/' . $action . '.php');
            }
            else
            {
                $overridePrefix = '';
                if (file_exists($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $act[0] . '_' . $act[1] . '_tools.php')) {
                    require_once($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $act[0] . '_' . $act[1] . '_tools.php');
                }
                if (file_exists($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $action . '.php')) {
                    require_once($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $action . '.php');
                } elseif (file_exists($overridePrefix . 'lib/' . $act[0] . '/' . $action . '.php')) {
                    require_once($overridePrefix . 'lib/' . $act[0] . '/' . $action . '.php');
                } elseif (file_exists($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $act[2] . '/' . $action . '.php')) {
                    require_once($overridePrefix . 'lib/' . $act[0] . '/' . $act[1] . '/' . $act[2] . '/' . $action . '.php');
                }
            }
            ob_end_flush();
        } elseif ($ajax == 2) {
            require_once(SC_TOOLS_DIR . $action . '.php');
        }
        exit();
    }
    if ($panel) { // useless but kept for old extension compatibility
        if ($ajax == 1) {
            require_once('lib/panel/' . $panel . '.php');
        } elseif ($ajax == 2) {
            require_once(SC_TOOLS_DIR . $panel . '.php');
        }
        exit();
    }
    if ($xml) { // useless but kept for old extension compatibility
        if ($ajax == 1) {
            require_once('lib/xml/' . $xml . '.php');
        } elseif ($ajax == 2) {
            require_once(SC_TOOLS_DIR . $xml . '.php');
        }
        exit();
    }

}else{


$sql = "SELECT COUNT(*) FROM " . _DB_PREFIX_ . "product";
$SC_SHOP_PRODUCTSCOUNT = Db::getInstance()->getValue($sql);

// récupération des hooks utilisés en cache
$sql = "SELECT *
        FROM " . _DB_PREFIX_ . "hook_module hm
        LEFT JOIN " . _DB_PREFIX_ . "hook h ON h.id_hook = hm.id_hook";
$res = Db::getInstance()->executeS($sql);
$cached = array();
foreach($res as $data) {
    if(!empty($data['name'])) {
        if(SCMS) {
            $cached[$data['id_shop']][strtolower($data['name'])] = $data['name'];
        } else {
            $cached[strtolower($data['name'])] = $data['name'];
        }
    }
}
Configuration::updateValue('SC_HOOK_MODULE',serialize($cached));


// mode classic
checkDB();
require_once(SC_DIR . 'lib/php/maintenance.php');
runMaintenance();

require_once(SC_DIR . 'lib/php/menu.php');
$page = Tools::getValue('page', 'cat_tree');
$title ='';

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php
        switch ($page){
            case 'cat_tree':
                $title = 'Catalog';
                break;
            case 'cus_tree':
                $title ='Customer';
                break;
            case 'ord_tree':
                $title= 'Order';
                break;
            case 'cusm_tree':
                $title = 'Support';
                break;
            case 'cms_tree':
                $title = 'CMS';
                break;
            case 'man_tree':
                $title = 'Manufacturers';
                break;
            default:
                $title = 'Store Commander';
                break;
        }
    ?>
    <title>
        <?php echo _l($title); ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="icon" href="lib/img/sc_only_red.png" />
    <link type="text/css" rel="stylesheet" href="<?php echo SC_CSSDHTMLX; ?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo SC_CSSSTYLE; ?>"/>
    <link type="text/css" rel="stylesheet" href="lib/js/skins/message_default_02.css"/>
    <link type="text/css" rel="stylesheet" href="lib/css/jquery.autocomplete.css"/>
    <script type="text/javascript" src="<?php echo SC_JSDHTMLX; ?>"></script>
    <script type="text/javascript" src="lib/js/message.js"></script>
    <script type="text/javascript" src="<?php echo SC_JQUERY; ?>"></script>
    <script type="text/javascript" src="lib/js/jquery.cokie.js"></script>
    <script type="text/javascript" src="<?php echo SC_JSFUNCTIONS; ?>"></script>
    <script type="text/javascript" src="lib/js/jquery.autocomplete.js"></script>
    <link rel="icon" type="image/vnd.microsoft.icon" href="/img/favicon.ico"/>
    <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico"/>

    <script src="https://clippingmagic.com/api/v1/ClippingMagic.js" type="text/javascript"></script>
    <script type="text/javascript">
        ClippingMagic.initialize({apiId: <?php echo CutOut::getApiId(); ?>});
    </script>
</head>
<body>
<script type="text/javascript">
    var isIPAD = (navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/Android/i)) != null;
    var mustOpenBrowserTab = isIPAD || <?php echo (_s('APP_FORCE_OPEN_BROWSER_TAB')?1:0); ?>;
    SC_ID_LANG =<?php echo $sc_agent->id_lang;?>;
    SC_PAGE = '<?php echo $page;?>';
    SCMS =<?php echo (SCMS?1:0);?>;
    var lang_setting_disable_notice = '<?php echo _l('Do you want to disable this notice ?',1); ?>';
    var lang_setting_disable_tip = '<?php echo _l('Do you want to disable this tip ?',1); ?>';
    var lang_disable_tips = '<?php echo _l('Do you want to disable tips ?',1); ?>';
    var dhxWins = new dhtmlXWindows();
    dhtmlXWindowsCell.prototype.setIcon = function (icon) {
        this.wins.w[this._idd].hdr.firstChild.style.backgroundImage = "url(" + icon + ")";
        this.wins._winAdjustTitle(this._idd);
    };
    $(document).ready(function () {

        <?php require_once ('start-tips-notice.php'); ?>

        document.onselectstart = new Function("return false;");
    });

    <?php if(SCMS) { ?>
    $(window).on('focus', function() {
        checkIdShopBetweenBrowserTabs();
    });
    <?php } ?>

    <?php
        UISettings::loadJS($page);
    ?>

    var layoutStatusText = "";
    var updateQueueLimit = '<?php
	$nb = _s("APP_UPDATEQUEUE_LIMIT");
	if(empty($nb))
		{$nb = 20;}
	echo $nb;
	?>';
    var lang_confirmclose = '<?php echo _l('Multiple actions are currently running. Do you really want to close?',1)?>';
    var lang_queuetasks = '<?php echo _l('Tasks',1)?>';
    var lang_queuetaskswindow = '<?php echo _l('Tasks error logs',1)?>';
    var lang_queueerror_1 = '<?php echo _l('An error has occured:',1)?>';
    var lang_queueerror_2 = '<?php echo _l('Check the logs to see the modification that triggered the error as well as other that could not be applied',1)?>';
    var lang_queueerror_3 = '<?php echo _l('See logs',1)?>';
    var lang_queueerror_4 = '<?php echo _l('An error has occured when inserting',1)?>';
    var lang_settings = '<?php echo _l('Settings', 1)?>';
    var lang_refresh_SC = '<?php echo _l('You need to refresh Store Commander to use the new settings.', 1)?>';
    <?php
        $month_full = array(_l("January"), _l("February"), _l("March"), _l("April"), _l("May"), _l("June"), _l("July"), _l("August"), _l("September"), _l("October"), _l("November"), _l("December"));
        $month_short = array(_l("Jan"), _l("Feb"), _l("Mar"), _l("Apr"), _l("May"), _l("Jun"), _l("Jul"), _l("Aug"), _l("Sep"), _l("Oct"), _l("Nov"), _l("Dec"));
        $day_full = array(_l("Sunday"), _l("Monday"), _l("Tuesday"), _l("Wednesday"), _l("Thursday"), _l("Friday"), _l("Saturday"));
        $day_short = array(_l("Sun."), _l("Mon."), _l("Tue."), _l("Wed."), _l("Thu."), _l("Fri."), _l("Sat."));
    ?>
    var lang_calendar = {
		dateformat: "%Y-%m-%d",
		monthesFNames: ["<?php echo implode('","',$month_full); ?>"],
		monthesSNames: ["<?php echo implode('","',$month_short); ?>"],
		daysFNames: ["<?php echo implode('","',$day_full); ?>"],
		daysSNames: ["<?php echo implode('","',$day_short); ?>"],
		weekstart: 1
	}

    var weServicesProject = null;
    function loadWindoweServicesProject(filter)
    {
        var filter_url = "";
        if(filter!=undefined && filter!=null && filter!="" && filter!=0)
            filter_url = "&filter_type="+filter;

        if (!dhxWins.isWindow('weServicesProject'))
        {
            weServicesProject = dhxWins.createWindow('weServicesProject', 50, 50, $(window).width()-75, $(window).height()-75);
            weServicesProject.setIcon('lib/img/ruby.png','../../../lib/img/ruby.png');
            weServicesProject.setText('<?php echo _l('e-Services', 1)." - "._l('Managing your projects', 1); ?>');
            $.get('index.php?ajax=1&act=all_fizz_win-project_init'+filter_url,function(data){
                $('#jsExecute').html(data);
            });
        }else{
            weServicesProject.show();
            if(filter!=undefined && filter!=null && filter!="" && filter!=0)
                eSP_filterByType(filter);
        }
        weServicesProject.attachEvent('onClose', function(win){
            weServicesProject.hide();
            return false;
        });
    }

    function checkIdShopBetweenBrowserTabs()
    {
        let current_page = "<?php echo Tools::getValue('page', 'cat_tree');?>";
        var cookie_selected_shop = $.cookie('sc_shop_selected');
        var current_selected_shop = 0;
        switch(current_page) {
            case 'cat_tree':
                current_selected_shop = cat_shoptree.getSelectedItemId();
                break;
            case 'ord_tree':
                current_selected_shop = ord_shoptree.getSelectedItemId();
                break;
            case 'cus_tree':
                current_selected_shop = cus_shoptree.getSelectedItemId();
                break;
            case 'cusm_tree':
                current_selected_shop = cusm_shoptree.getSelectedItemId();
                break;
            case 'cms_tree':
                current_selected_shop = cms_shoptree.getSelectedItemId();
                break;
            case 'man_tree':
                current_selected_shop = man_shoptree.getSelectedItemId();
                break;
        }
        if(current_selected_shop > 0) {
            if(cookie_selected_shop !== current_selected_shop) {
                dhtmlx.message({text:"<?php echo _l('Not advised: another tab is open and enabled on a different shop. Reload the page.',1);?>",type:'error',expire:10000});
            }
        }
    }
</script>
<?php

switch ($page) {
    case 'cat_tree':
        include_once('lib/cat/cat_tree.php');
        require_once("lib/cat/cat_grid.php");
        require_once('lib/cat/cat_prop.php');
        if(file_exists(SC_TOOLS_DIR.'lib/cat/quicksearch/cat_quicksearch.php')) {
            require_once(SC_TOOLS_DIR.'lib/cat/quicksearch/cat_quicksearch.php');
        } else {
            require_once('lib/cat/quicksearch/cat_quicksearch.php');
        }
        break;
    case 'ord_tree':
        include_once('lib/ord/ord_tree.php');
        require_once("lib/ord/ord_grid.php");
        require_once('lib/ord/ord_prop.php');
        break;
    case 'cus_tree':
        include_once('lib/cus/cus_tree.php');
        require_once("lib/cus/cus_grid.php");
        require_once('lib/cus/cus_prop.php');
        break;
    case 'cusm_tree':
        include_once('lib/cusm/cusm_tree.php');
        require_once("lib/cusm/cusm_grid.php");
        require_once('lib/cusm/cusm_prop.php');
        break;
    case 'cms_tree':
        include_once('lib/cms/cms_tree.php');
        require_once("lib/cms/cms_grid.php");
        require_once('lib/cms/cms_prop.php');
        break;
    case 'man_tree':
        include_once('lib/man/man_tree.php');
        require_once("lib/man/man_grid.php");
        require_once('lib/man/man_prop.php');
        break;
}

require_once('lib/all/win-quickexport/all_win-quickexport_init.php');
require_once('lib/all/win-help/all_win-help_init.php');

?>
<div id="jsExecute"></div>
<?php

if(KAI9DF4==1)
    require_once('lib/core/core_trialtime.php');
else
{
    if(defined("OPEN_UPDATE_WINDOW") && OPEN_UPDATE_WINDOW=="1")
    {
        ?>
        <script type="application/javascript">
            if (!dhxWins.isWindow('wCoreUpdate'))
            {
                wCoreUpdate = dhxWins.createWindow('wCoreUpdate', 50, 50, 900, $(window).height()-75);
                wCoreUpdate.setIcon('lib/img/cog_edit.png','../../../lib/img/cog_edit.png');
                wCoreUpdate.setText('<?php echo _l('Store Commander update', 1); ?>');
                wCoreUpdate.attachURL('index.php?ajax=1&act=core_update');
                wCoreUpdate.setModal(true);
            }else{
                wCoreUpdate.show();
            }
        </script>
        <?php
    }

}

if(!empty($sc_alerts) && count($sc_alerts)>0) { ?>
<script type="application/javascript">
    $( document ).ready(function() {
        dhtmlx.message({text:'<?php echo str_replace("'", "\'", implode("<br/><br/>", $sc_alerts)); ?>',type:'error',expire:-1});
    });
</script>

<?php }

$sql = "SELECT count(pm.id_module) 
        FROM " . _DB_PREFIX_ . "module AS pm INNER JOIN " . _DB_PREFIX_ . "hook_module AS hm ON (pm.id_module = hm.id_module) INNER JOIN " . _DB_PREFIX_ . "hook AS h ON (hm.id_hook = h.id_hook)
        WHERE h.name = 'actionProductUpdate' AND pm.active = 1 AND (LOWER(pm.name) = 'advsearch' OR LOWER(pm.name) = 'pm_advancedsearch4' OR LOWER(pm.name) = 'shoppingflux' OR LOWER(pm.name) = 'ebay' OR LOWER(pm.name) = 'mailchimpintegration') ";
$res = Db::getInstance()->getValue($sql);

if (_s('APP_FOULEFACTORY') && SCI::getFFActive()) { ?>
    <script type="application/javascript">
        function showWCatFoulefactory()
        {
            if (!dhxWins.isWindow('wCatFoulefactory'))
            {
                wCatFoulefactory = dhxWins.createWindow('wCatFoulefactory', 50, 50, 940, $(window).height()-75);
                wCatFoulefactory.setIcon('lib/img/foulefactory_icon.png','../../../lib/img/foulefactory_icon.png');
                wCatFoulefactory.setText('<?php echo _l('FouleFactory', 1); ?>'); //  and cancel modifications
                $.get('index.php?ajax=1&act=cat_win-foulefactory_init&id_lang='+SC_ID_LANG,function(data){
                    $('#jsExecute').html(data);
                });
            }
            else
            {
                wCatFoulefactory.show();
                $.get('index.php?ajax=1&act=cat_win-foulefactory_init&id_lang='+SC_ID_LANG,function(data){
                    $('#jsExecute').html(data);
                });
            }
        }
    </script>
<?php }

if (_s('CAT_NOTICE_HOOKACTIONPRODUCTUPDATE') && $res >= 1)
{
    $message = _l('Some modules installed on your shop are misconfigured which affects Store Commander performances.',1).' <a href="http://www.storecommander.com/support/'.($user_lang_iso=='fr'?'fr/problemes-connus-et-solutions/784-probleme-les-modifications-de-produits-ne-sont-pas-validees.html':'en/known-issues-amp-solutions/784-problem-modifications-are-not-being-applied.html').'" target="_blank">'. _l('Read more',1) . "</a><br/><a href=\"javascript:disableThisNotice(\'CAT_NOTICE_HOOKACTIONPRODUCTUPDATE\');\">"._l('Disable this notice',1).'</a>';
    ?>
    <script>
        dhtmlx.message
        ({
            type: 'error',
            text: '<?php echo $message; ?>',
            expire: 10000
        });

    </script>
    <?php   
}
if (_s('CAT_NOTICE_PSVERSIONUPDATE') && (version_compare(_PS_VERSION_, '1.7.1.0', '>=') && version_compare(_PS_VERSION_, '1.7.2.3', '<=')))
{
    $message = _l('Your Prestashop version need to be uptaded. We strongly advise you to upgrade.',1).' <a href="http://build.prestashop.com/news/prestashop-1-7-2-4-maintenance-release/" target="_blank">'._l('Read more',1)."</a><br/><a href=\"javascript:disableThisNotice(\'CAT_NOTICE_PSVERSIONUPDATE\');\">"._l('Disable this notice',1).'</a>';
    ?>
    <script>
        dhtmlx.message
        ({
            type: 'error',
            text: '<?php echo $message; ?>',
            expire: 10000
        });

    </script>
    <?php
}
if(!ini_get('allow_url_fopen') )
{
    $message = _l('allow_url_fopen is disabled. We strongly advise you to enable it.',1) .' ' . _l('To stop this alert: SC  > Tools > Settings > Section: Notice.',1);
    ?>
    <script>
    dhtmlx.message
    ({
            type: 'error',
            text: '<?php echo $message; ?>',
            expire: 10000
        });

    </script>
     <?php
}
include('lib/all/win-trends/all_win-trends_loop.php');
?>
</body>
</html>
<?php
} // end mode classic
