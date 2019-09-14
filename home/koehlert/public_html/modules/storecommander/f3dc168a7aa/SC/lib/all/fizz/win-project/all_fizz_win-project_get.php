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

$display_archived=Tools::getValue('display_archived',0);
$id_lang=intval(Tools::getValue('id_lang'));


function getProjects()
{
    global $id_lang, $display_archived,$spbas,$status,$types,$status_color,$status_stripes;
    $projects = array();

    $wallet = Configuration::get("SC_WALLET_AMOUNT");

    $headers = array();
    $posts = array();
    $posts["KEY"] = "gt789zef132kiy789u13v498ve15nhry98";
    $posts["LICENSE"] = "#";
    $posts["URLCALLING"] = "#";
    if(defined("IS_SUBS") && IS_SUBS=="1")
        $posts["SUBSCRIPTION"] = "1";
    $ret = makeCallToOurApi("Fizz/Project/GetAll",$headers,$posts, true);
    if (!empty($ret['code']) && $ret['code'] == "200")
    {
        $projects = $ret['project'];
    }

    foreach ($projects as $project)
    {
        if(empty($display_archived) && $project["status"]=="999")
            continue;

        if($project['status']<5)
            $project['amount'] = "-";

        $items = trim($project['list_items'],"-");
        $items = explode("-",$items);

        if($project['type']=="cutout" && !empty($project['list_items']))
        {
            $project['amount'] = CutOut::getPrice(count($items));
        }

        $color_amount = '';
        if(!empty($project['amount']) && $project['amount']!="-")
        {
            $colored = false;
            if($project['type']=="dixit")
            {
                if(in_array($project['amount'], array("4","7","8","9","107","109","113")))
                    $colored = true;
            }
            else
                $colored = true;
            if($colored)
            {
                if($project['amount']>$wallet)
                    $color_amount = " bgColor='#ff0000'";
                elseif($project['amount']<=$wallet)
                    $color_amount = " bgColor='#82C46C'";
            }
        }

        echo "<row id=\"".$project['id_project']."\">";
        echo 		"<cell>".(int)$project['id_project']."</cell>";
        echo 		"<cell><![CDATA[".$project['type']."]]></cell>";
        echo 		"<cell><![CDATA[".$project['name']."]]></cell>";
        echo 		"<cell class='".(!empty($status_stripes[$project['status']])?"stripes":"")."' style='background-color:".$status_color[$project['status']]."'>".$project['status']."</cell>";
        echo 		"<cell ".$color_amount."><![CDATA[".$project['amount']."]]></cell>";
        echo 		"<cell><![CDATA[".formatDateTimeToDisplay($project['date_add'])."]]></cell>";
        echo 		"<cell><![CDATA[".formatDateTimeToDisplay($project['date_upd'])."]]></cell>";
        echo "</row>";
    }

}

if(stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
        header("Content-type: application/xhtml+xml");
}else{
        header("Content-type: text/xml");
}
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
?>
<rows>
<head>
<beforeInit>
<call command="attachHeader"><param><![CDATA[#numeric_filter,#select_filter,#text_filter,#select_filter,#numeric_filter,#text_filter,#text_filter]]></param></call>
</beforeInit>
<column id="id_project" width="40" type="ro" align="right" sort="str"><?php echo _l('ID')?></column>
<column id="type" width="120" type="coro" align="left" sort="str"><?php echo _l('Type')?>
    <?php foreach ($types as $key=>$value){echo '<option value="'.$key.'">'.$value.'</option>';} ?>
</column>
<column id="name" width="200" type="ro" align="left" sort="str"><?php echo _l('Name')?></column>
<column id="status" width="160" type="coro" align="left" sort="str"><?php echo _l('Status')?>
    <?php foreach ($status as $key=>$value){echo '<option value="'.$key.'">'.$value.'</option>';} ?>
</column>
<column id="amount" width="80" type="ro" align="right" sort="int"><?php echo _l('Amount (Fizz)')?></column>
<column id="date_add" width="120" type="ro" align="left" sort="int"><?php echo _l('Date add')?></column>
<column id="date_upd" width="120" type="ro" align="left" sort="int"><?php echo _l('Date update')?></column>
</head>
<?php
	echo '<userdata name="uisettings">'.uisettings::getSetting('fizz_projects').'</userdata>'."\n";
	getProjects();
	//echo '</rows>';
?>
</rows>