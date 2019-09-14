<?php
$funnel_list = array(
    "acquisition"=>_l("Acquisition"),
    "activation"=>_l("Activation"),
    "revenue"=>_l("Revenue"),
    "retention"=>_l("Retention"),
    "recommendation"=>_l("Recommendation"),
    "productivity"=>_l("Productivity")
);
$section_list = array(
    "seo"=>_l("SEO"),
    "product_page_enhancement"=>_l("Product page enhancement"),
    "master_sc"=>_l("Master Store Commander"),
    "renew_sc"=>_l("Renew Store Commander"),
    "upgrade_sc_solo_ms"=>_l("Upgrade SC SOLO to SC Multistore"),
    "sc"=>_l("Store Commander"),
    "addon"=>_l("Addons"),
    "services"=>_l("Services"),
    "marketplaces"=>_l("MarketPlaces"),
);

$eServices_list = array();
$eServices_list["ukoo_product_compatibility"] = array(
    "name"=>_l('Ukoo Product Compatibilities')." *",
    "subtitle"=>_l('Associate parts to the right product in bulk'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>299,
    "currency"=>"euro",
    "id_product"=>"1378",
    "groups" => array(
        array("funnel"=>'activation', 'section'=>'product_page_enhancement')
    ),
    "display" => displayUkoo(),
    "buyable" => 1
);
$eServices_list["pm_multiple_features"] = array(
    "name"=>_l('PM Multiple features')." *",
    "subtitle"=>_l('Add multiple features on a product'),
    "active"=>activeMultipleFeatures(),
    "max_qty"=>1,
    "price"=>29,
    "currency"=>"euro",
    "id_product"=>"460",
    "groups" => array(
        array("funnel"=>'activation', 'section'=>'product_page_enhancement')
    ),
    "display" => displayMultipleFeatures(),
    "buyable" => 1,
);
$eServices_list["segmentation"] = array(
    "name"=>_l('Segmentation'),
    "subtitle"=>_l('Segment customers/orders/products for a targetted process'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>129,
    "currency"=>"euro",
    "id_product"=>"504",
    "groups" => array(
        array("funnel"=>'retention', 'section'=>'addon')
    ),
    "display" => displayExtension("Segmentation"),
    "buyable" => 1,
);
$eServices_list["ge"] = array(
    "name"=>_l('Interface customization'),
    "subtitle"=>_l('Customize SC grids'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>29,
    "currency"=>"euro",
    "id_product"=>"481",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'addon')
    ),
    "display" => displayExtension("GridEditor"),
    "buyable" => 1,
);
$eServices_list["gep"] = array(
    "name"=>_l('Interface customization Pro'),
    "subtitle"=>_l('Customize SC grids with information related to your activity'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>99,
    "currency"=>"euro",
    "id_product"=>"482",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'addon')
    ),
    "display" => displayExtension("GridEditorPro"),
    "buyable" => 1,
);
$eServices_list["gep_upgrade"] = array(
    "name"=>_l('Interface customization Pro')." - "._l('Upgrade'),
    "subtitle"=>_l('Customize SC grids with information related to your activity'),
    "active"=>activeGridEditorProUpgrade(),
    "max_qty"=>1,
    "price"=>70,
    "currency"=>"euro",
    "id_product"=>"488",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'addon')
    ),
    "display" => 1,
    "buyable" => 1,
);
$eServices_list["fix_my_ps"] = array(
    "name"=>_l('FixMyPrestaShop'),
    "subtitle"=>_l('Easily identify and fix technical issues on your store'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>49,
    "currency"=>"euro",
    "id_product"=>"392",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'addon')
    ),
    "display" => displayExtension("FixMyPrestashop"),
    "buyable" => 1,
);
/*$eServices_list["upgrade_solo_ms"] = array(
    "name"=>_l('SC Solo to SC Multistores'),
    "active"=>activeUpgradeSoloMs(),
    "max_qty"=>1,
    "price"=>250,
    "currency"=>"euro",
    "id_product"=>"273",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'sc')
    ),
    "display" => 1,
    "buyable" => 1,
);
$eServices_list["renew_12months_solo"] = array(
    "name"=>_l('12 months support and updates'),
    "subtitle"=>_l('Always save on productivity with Store Commander'),
    "active"=>activeForSolo(),
    "max_qty"=>1,
    "price"=>99,
    "currency"=>"euro",
    "id_product"=>"295",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'sc')
    ),
    "display" => 1,
    "buyable" => 1,
);
$eServices_list["renew_12months_ms"] = array(
    "name"=>_l('12 months support and updates'),
    "subtitle"=>_l('Always save on productivity with Store Commander'),
    "active"=>activeForMS(),
    "max_qty"=>1,
    "price"=>199,
    "currency"=>"euro",
    "id_product"=>"297",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'sc')
    ),
    "display" => 1,
    "buyable" => 1,
);*/
$eServices_list["tinypng"] = array(
    "name"=>'TinyPNG',
    "subtitle"=>_l('Compress images loaded in SC to speed up the display on your site'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>29,
    "currency"=>"euro",
    "id_product"=>"1435",
    "groups" => array(
        array("funnel"=>'acquisition', 'section'=>'seo')
    ),
    "display" => displayExtension("TinyPNG"),
    "buyable" => 1,
);
$eServices_list["amazon"] = array(
    "name"=>_l('Amazon')." *",
    "subtitle"=>_l('Setup your exports for Amazon'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>99,
    "currency"=>"euro",
    "id_product"=>"1466",
    "groups" => array(
        array("funnel"=>'acquisition', 'section'=>'marketplaces')
    ),
    "display" => displayAmazon(),
    "buyable" => 1
);
$eServices_list["feedbiz"] = array(
    "name"=>_l('FeedBiz')." *",
    "subtitle"=>_l('Setup your exports for Amazon via FeedBiz'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>99,
    "currency"=>"euro",
    "id_product"=>"1467",
    "groups" => array(
        array("funnel"=>'acquisition', 'section'=>'marketplaces')
    ),
    "display" => displayFeedBiz(),
    "buyable" => 1
);
$eServices_list["cdiscount"] = array(
    "name"=>_l('Cdiscount')." *",
    "subtitle"=>_l('Setup your exports for Cdiscount'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>99,
    "currency"=>"euro",
    "id_product"=>"1468",
    "groups" => array(
        array("funnel"=>'acquisition', 'section'=>'marketplaces')
    ),
    "display" => displayCdiscount(),
    "buyable" => 1
);

/*
 * MODULES
 */
$eServices_list["CatalogPDF"] = array(
    "name"=>_l('PDF Catalog Module'),
    "subtitle"=>_l('Post your offers on paper or PDF format'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>99,
    "currency"=>"euro",
    "id_product"=>"308",
    "groups" => array(
        array("funnel"=>'activation', 'section'=>'addon')
    ),
    "display" => activeModule("scpdfcatalog"),
    "buyable" => 1,
);

$eServices_list["ExportCustomers"] = array(
    "name"=>_l('Customer Export Pro Module'),
    "subtitle"=>_l('Target and optimize marketing actions'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>29,
    "currency"=>"euro",
    "id_product"=>"480",
    "groups" => array(
        array("funnel"=>'activation', 'section'=>'addon')
    ),
    "display" => activeModule("scexportcustomers"),
    "buyable" => 1,
);

$eServices_list["ExportOrders"] = array(
    "name"=>_l('Order Export Pro Module'),
    "subtitle"=>_l('Prepare data for your accountant quickly'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>49,
    "currency"=>"euro",
    "id_product"=>"440",
    "groups" => array(
        array("funnel"=>'activation', 'section'=>'addon')
    ),
    "display" => activeModule("scquickaccounting"),
    "buyable" => 1,
);

$eServices_list["Affiliation"] = array(
    "name"=>_l('Affiliation program'),
    "subtitle"=>_l('Create an affiliation campaign'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>199,
    "currency"=>"euro",
    "id_product"=>"428",
    "groups" => array(
        array("funnel"=>'acquisition', 'section'=>'addon')
    ),
    "display" => activeModule("scaffiliation"),
    "buyable" => 1,
);

$eServices_list["Terminator"] = array(
    "name"=>_l('Database cleaning and optimization'),
    "subtitle"=>_l('Cleanup your shop to keep good performances'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>29,
    "currency"=>"euro",
    "id_product"=>"307",
    "groups" => array(
        array("funnel"=>'activation', 'section'=>'addon')
    ),
    "display" => activeModule("scterminator"),
    "buyable" => 1,
);

/*
 * FIZZ
 */
$eServices_list["10_fizz"] = array(
    "name"=>_l('Pack of 10 Fizz'),
    "subtitle"=>_l('You can cut out 50 images with so many fizz'),
    "active"=>1,
    "max_qty"=>999999999999999999,
    "price"=>15,
    "currency"=>"euro",
    "id_product"=>"1440",
    "groups" => array(
        array("funnel"=>'acquisition', 'section'=>'services'),
        array("funnel"=>'activation', 'section'=>'services'),
        array("funnel"=>'revenue', 'section'=>'services'),
        array("funnel"=>'retention', 'section'=>'services'),
        array("funnel"=>'recommendation', 'section'=>'services'),
        array("funnel"=>'productivity', 'section'=>'services')
    ),
    "display" => 1,
    "buyable" => 1,
);

$eServices_list["100_fizz"] = array(
    "name"=>_l('Pack of 100 Fizz'),
    "subtitle"=>_l('You can cut out 500 images with so many fizz'),
    "active"=>1,
    "max_qty"=>999999999999999999,
    "price"=>130,
    "currency"=>"euro",
    "id_product"=>"1441",
    "groups" => array(
        array("funnel"=>'acquisition', 'section'=>'services'),
        array("funnel"=>'activation', 'section'=>'services'),
        array("funnel"=>'revenue', 'section'=>'services'),
        array("funnel"=>'retention', 'section'=>'services'),
        array("funnel"=>'recommendation', 'section'=>'services'),
        array("funnel"=>'productivity', 'section'=>'services')
    ),
    "display" => 1,
    "buyable" => 1,
);

$eServices_list["500_fizz"] = array(
    "name"=>_l('Pack of 500 Fizz'),
    "subtitle"=>_l('You can cut out 2 500 images with so many fizz'),
    "active"=>1,
    "max_qty"=>999999999999999999,
    "price"=>600,
    "currency"=>"euro",
    "id_product"=>"1442",
    "groups" => array(
        array("funnel"=>'acquisition', 'section'=>'services'),
        array("funnel"=>'activation', 'section'=>'services'),
        array("funnel"=>'revenue', 'section'=>'services'),
        array("funnel"=>'retention', 'section'=>'services'),
        array("funnel"=>'recommendation', 'section'=>'services'),
        array("funnel"=>'productivity', 'section'=>'services')
    ),
    "display" => 1,
    "buyable" => 1,
);

$eServices_list["2000_fizz"] = array(
    "name"=>_l('Pack of 2000 Fizz'),
    "subtitle"=>_l('You can cut out 10 000 images with so many fizz'),
    "active"=>1,
    "max_qty"=>999999999999999999,
    "price"=>2200,
    "currency"=>"euro",
    "id_product"=>"1443",
    "groups" => array(
        array("funnel"=>'acquisition', 'section'=>'services'),
        array("funnel"=>'activation', 'section'=>'services'),
        array("funnel"=>'revenue', 'section'=>'services'),
        array("funnel"=>'retention', 'section'=>'services'),
        array("funnel"=>'recommendation', 'section'=>'services'),
        array("funnel"=>'productivity', 'section'=>'services')
    ),
    "display" => 1,
    "buyable" => 1,
);

/*
 * SERVICES
 */

$eServices_list["images_cutout"] = array(
    "name"=>_l('Cut out images'),
    "subtitle"=>_l('Number of images you can cut out:').' '.floor(Configuration::get("SC_WALLET_AMOUNT")/0.2),
    "active"=>1,
    "max_qty"=>0,
    "price"=>0.20,
    "currency"=>"fizz",
    "id_product"=>"1444",
    "groups" => array(
        array("funnel"=>'activation', 'section'=>'product_page_enhancement')
    ),
    "display" => 1,
    "buyable" => 0,
);

$eServices_list["dixit_product"] = array(
    "name"=>_l('Human translation of your product pages'),
    "subtitle"=>_l('Number of words that you can translate:').' '.floor(Configuration::get("SC_WALLET_AMOUNT")/0.06),
    "active"=>1,
    "max_qty"=>0,
    "price"=>0.06,
    "currency"=>"fizz",
    "id_product"=>"1553",
    "groups" => array(
        array("funnel"=>'activation', 'section'=>'product_page_enhancement')
    ),
    "display" => 1,
    "buyable" => 0,
);

/*
 * INFOS
 */
$eServices_list["add_field_gep"] = array(
    "name"=>_l('Add a new field in SC with Grid Editor Pro')." *",
    "active"=>1,
    "max_qty"=>99999,
    "price"=>70,
    "currency"=>"euro",
    "id_product"=>"80",
    "groups" => array(
        array("funnel"=>'activation', 'section'=>'product_page_enhancement'),
        array("funnel"=>'productivity', 'section'=>'master_sc')
    ),
    "display" => displayAddFieldGep(),
    "buyable" => 0,
);

$eServices_list["training_sc_solo"] = array(
    "name"=>_l('Initiation Training for Store Commander Solo'),
    "active"=>activeForSolo(),
    "max_qty"=>1,
    "price"=>199,
    "currency"=>"euro",
    "id_product"=>"95",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'master_sc')
    ),
    "display" => 1,
    "buyable" => 0,
);
$eServices_list["training_sc_ms"] = array(
    "name"=>_l('Initiation Training for Store Commander Multistore'),
    "active"=>activeForMS(),
    "max_qty"=>1,
    "price"=>299,
    "currency"=>"euro",
    "id_product"=>"572",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'master_sc')
    ),
    "display" => 1,
    "buyable" => 0,
);
$eServices_list["training_sc_import"] = array(
    "name"=>_l('CSV Import Training'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>199,
    "currency"=>"euro",
    "id_product"=>"124",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'master_sc')
    ),
    "display" => 1,
    "buyable" => 0,
);
$eServices_list["training_sc_export"] = array(
    "name"=>_l('CSV Export Training'),
    "active"=>1,
    "max_qty"=>1,
    "price"=>99,
    "currency"=>"euro",
    "id_product"=>"452",
    "link" => "",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'master_sc')
    ),
    "display" => 1,
    "buyable" => 0,
);

/*
 * PUBS
 */
$eServices_list["seo_action_plan"] = array(
    "name"=>_l('SEO action plan'),
    "active"=>displayForLang("fr"),
    "max_qty"=>1,
    "price"=>null,
    "currency"=>null,
    "id_product"=>"1533",
    "link" => "http://go.storecommander.com/e-Services-SEO-Audit.html",
    "groups" => array(
        array("funnel"=>'acquisition', 'section'=>'seo')
    ),
    "display" => 1,
    "buyable" => 0,
);

$eServices_list["product_photo_shoot"] = array(
    "name"=>_l('Product photo shoot in HD'),
    "active"=>displayForLang("fr"),
    "max_qty"=>1,
    "price"=>null,
    "currency"=>null,
    "id_product"=>"1502",
    "link" => "http://go.storecommander.com/e-Services-Photos-Produits.html",
    "groups" => array(
        array("funnel"=>'activation', 'section'=>'product_page_enhancement')
    ),
    "display" => 1,
    "buyable" => 0,
);

/*
 * NON ACTIFS
 */
$eServices_list["optimatisation_seo"] = array(
    "name"=>_l('Optimatisation SEO'),
    "active"=>0,
    "max_qty"=>999999999999999999,
    "price"=>0,
    "currency"=>"",
    "id_product"=>"481",
    "groups" => array(
        array("funnel"=>'productivity', 'section'=>'addon')
    ),
    "display" => 0,
    "buyable" => 0,
);
/*
 * FUNCTIONS
 */
function phpToJs($array, $name)
{
    foreach ($array as $key=>$values)
    {
        if(!isset($values['active']) || (isset($values['active']) && !empty($values['active'])))
        {
            echo $name.'[\''.$key.'\']={'."\n";
            _phpToJs($values);
            echo '};'."\n";
        }
    }
}
function _phpToJs($array)
{
    foreach ($array as $key=>$value)
    {
        if(!is_array($value))
            echo $key.':\''.str_replace("'","\'",$value).'\','."\n";
        else
        {
            echo $key.':{'."\n";
            _phpToJs($value);
            echo '},'."\n";
        }
    }
}
function displayUkoo()
{
    return (SCI::moduleIsInstalled('ukoocompat') && (!defined("SC_UkooProductCompat_ACTIVE") || SC_UkooProductCompat_ACTIVE!="1") ?1:0);
}
function displayAmazon()
{
    return (SCI::moduleIsInstalled('amazon') && (!defined("SC_Amazon_ACTIVE") || SC_Amazon_ACTIVE!="1") ?1:0);
}
function displayFeedBiz()
{
    return (SCI::moduleIsInstalled('feedbiz') && (!defined("SC_FeedBiz_ACTIVE") || SC_FeedBiz_ACTIVE!="1") ?1:0);
}
function displayCdiscount()
{
    return (SCI::moduleIsInstalled('cdiscount') && (!defined("SC_Cdiscount_ACTIVE ") || SC_Cdiscount_ACTIVE !="1") ?1:0);
}
function displayMultipleFeatures()
{
    return (
        (version_compare(_PS_VERSION_, '1.5.0.0', '<') || Feature::isFeatureActive())
        && SCI::moduleIsInstalled('pm_multiplefeatures')
        && (!defined("SC_MultiplesFeatures_ACTIVE") || SC_MultiplesFeatures_ACTIVE!="1")
    ?1:0);
}
function activeMultipleFeatures()
{
    return (version_compare(_PS_VERSION_, '1.7.3.0', '>=')?0:1);
}
function activeGridEditorProUpgrade()
{
    $return = 0;
    if(defined("SC_GridEditor_ACTIVE") && SC_GridEditor_ACTIVE=="1" && (!defined("SC_GridEditorPro_ACTIVE") || SC_GridEditorPro_ACTIVE!="1"))
        $return = 1;
    return $return;
}
function displayExtension($name)
{
    return (!defined("SC_".$name."_ACTIVE") || !constant("SC_".$name."_ACTIVE")?1:0);
}
function displayAddFieldGep()
{
    return (defined("SC_GridEditorPro_ACTIVE") && SC_GridEditorPro_ACTIVE=="1"?1:0);
}
function activeUpgradeSoloMs()
{
    $return = 0;
    $license_key = SCI::getConfigurationValue('SC_LICENSE_KEY', '');
    if(!empty($license_key))
    {
        $lica = explode('-', $license_key);
        if (count($lica) == 4) {
            $lic = $lica[0] . $lica[1] . $lica[2];
        } else {
            $lic = $lica[0];
        }
        if($lic=='SCPSSOLO')
            $return = 1;
    }
    return $return;
}
function activeForSolo()
{
    $return = 0;
    $license_key = SCI::getConfigurationValue('SC_LICENSE_KEY', '');
    if(!empty($license_key))
    {
        $lica = explode('-', $license_key);
        if (count($lica) == 4) {
            $lic = $lica[0] . $lica[1] . $lica[2];
        } else {
            $lic = $lica[0];
        }
        if($lic=='SCPSSOLO')
            $return = 1;
    }
    return $return;
}
function activeForMS()
{
    $return = 0;
    $license_key = SCI::getConfigurationValue('SC_LICENSE_KEY', '');
    if(!empty($license_key))
    {
        $lica = explode('-', $license_key);
        if (count($lica) == 4) {
            $lic = $lica[0] . $lica[1] . $lica[2];
        } else {
            $lic = $lica[0];
        }
        if($lic=='SCPSULTD')
            $return = 1;
    }
    return $return;
}
function activeModule($module)
{
    $return = 0;
    if(!empty($module))
    {
        $dir = SC_DIR.'../../../'.$module;
        if(!file_exists($dir))
            $return = 1;
    }
    return $return;
}

function displayForLang($lang)
{
    global $sc_agent;
    $iso = strtolower(Language::getIsoById($sc_agent->id_lang));
    $lang = strtolower($lang);
    return ($lang==$iso?1:0);
}