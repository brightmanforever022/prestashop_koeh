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

	$cart_rule_ids = Tools::getValue('ids');
	$id_lang = (int)Tools::getValue('id_lang');

	function getRowsFromDB()
    {
		global $cart_rule_ids,$id_lang;

		$sql = "SELECT ocr.id_order_cart_rule, ocr.name as cart_rule_name, ocr.value, o.id_order, o.reference, o.date_add, osl.name as status, c.id_customer, c.email, c.lastname,c.firstname
                FROM "._DB_PREFIX_."cart_rule cr
                RIGHT JOIN "._DB_PREFIX_."order_cart_rule ocr ON (ocr.id_cart_rule = cr.id_cart_rule)
                LEFT JOIN "._DB_PREFIX_."orders o ON (o.id_order = ocr.id_order)
                LEFT JOIN "._DB_PREFIX_."customer c ON (c.id_customer = o.id_customer)
                LEFT JOIN "._DB_PREFIX_."order_state_lang osl ON (osl.id_order_state = o.current_state AND osl.id_lang = ".(int)$id_lang.")
                WHERE cr.id_cart_rule IN (".pSQL($cart_rule_ids).")";
		$res=Db::getInstance()->ExecuteS($sql);

		$xml='';
		foreach ($res AS $ocr)
		{
			$xml .= "<row id='".$ocr['id_order_cart_rule']."'>";
            $xml .= "<cell>".$ocr['id_order']."</cell>";
            $xml .= "<cell><![CDATA[".$ocr['cart_rule_name']."]]></cell>";
            $xml .= "<cell>".$ocr['value']."</cell>";
            $xml .= "<cell><![CDATA[".$ocr['reference']."]]></cell>";
            $xml .= "<cell><![CDATA[".$ocr['date_add']."]]></cell>";
            $xml .= "<cell><![CDATA[".$ocr['status']."]]></cell>";
            $xml .= "<cell>".$ocr['id_customer']."</cell>";
            $xml .= "<cell><![CDATA[".$ocr['email']."]]></cell>";
            $xml .= "<cell><![CDATA[".$ocr['lastname']."]]></cell>";
            $xml .= "<cell><![CDATA[".$ocr['firstname']."]]></cell>";
			$xml .= "</row>";
		}
		return $xml;
	}

	$xml=getRowsFromDB();

	//XML HEADER
	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	 		header("Content-type: application/xhtml+xml");
	} else {
	 		header("Content-type: text/xml");
	}
	echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
?>
<rows id="0">
    <head>
        <column id="id_order" width="80" type="ro" align="left" sort="str"><?php echo _l('id_order')?></column>
        <column id="cart_rule_name" width="120" type="ro" align="left" sort="str"><?php echo _l('Name')?></column>
        <column id="value" width="100" type="ro" align="left" sort="str"><?php echo _l('Cart rule amount tax incl.')?></column>
        <column id="reference" width="80" type="ro" align="left" sort="str"><?php echo _l('Reference')?></column>
        <column id="date_add" width="80" type="ro" align="left" sort="str"><?php echo _l('Creation date')?></column>
        <column id="status" width="120" type="ro" align="left" sort="str"><?php echo _l('Status')?></column>
        <column id="id_customer" width="80" type="ro" align="left" sort="str"><?php echo _l('id_customer')?></column>
        <column id="email" width="120" type="ro" align="left" sort="str"><?php echo _l('Email')?></column>
        <column id="lastname" width="120" type="ro" align="left" sort="str"><?php echo _l('Lastname')?></column>
        <column id="firstname" width="120" type="ro" align="left" sort="str"><?php echo _l('Firstname')?></column>
    </head>
    <?php
        echo '<userdata name="uisettings">'.uisettings::getSetting('ord_prop_orderdetail_grid').'</userdata>'."\n";
        echo $xml;
    ?>
</rows>
