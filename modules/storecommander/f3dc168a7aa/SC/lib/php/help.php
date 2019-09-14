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

$helpLink=array();

$helpLink['fr']['home']='2015032302';
$helpLink['en']['home']='2015032301';

$helpLink['fr']['homedoc']='2016061712';
$helpLink['en']['homedoc']='2016061711';

$helpLink['fr']['history']='2017021418';
$helpLink['en']['history']='2017021417';

$helpLink['fr']['massupdate_round_price_help']='201311272';
$helpLink['en']['massupdate_round_price_help']='201311271';

$helpLink['fr']['cat_win-catimport_check']='2014080702';
$helpLink['en']['cat_win-catimport_check']='2014080701';

$helpLink['fr']['cat_win-catimport_init']='2014080702';
$helpLink['en']['cat_win-catimport_init']='2014080701';

$helpLink['fr']['cat_win-import_check']='2014080702';
$helpLink['en']['cat_win-import_check']='2014080701';

$helpLink['fr']['cat_win-import_init']='2014080702';
$helpLink['en']['cat_win-import_init']='2014080701';

$helpLink['fr']['cat_win-import_create_view']='2015032302';
$helpLink['en']['cat_win-import_create_view']='2015032301';

$helpLink['fr']['all_win-fixmyprestashop']='2019050601';
$helpLink['en']['all_win-fixmyprestashop']='2019050602';

function getHelpLink($page)
{
	global $helpLink,$user_lang_iso;

	$global_link = 'https://www.storecommander.com/redir.php?dest=';

	if (!sc_array_key_exists($page,$helpLink['en'])){
	    $page='home';
    }
	if ($user_lang_iso=='fr')
	{
		return $global_link.$helpLink['fr'][$page];
	}else{
		return $global_link.$helpLink['en'][$page];
	}
}