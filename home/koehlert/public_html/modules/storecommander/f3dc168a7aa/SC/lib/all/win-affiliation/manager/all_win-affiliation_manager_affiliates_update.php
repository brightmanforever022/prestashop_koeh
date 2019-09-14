<?php

	$id_lang=2;
	$id_customer=intval(Tools::getValue('gr_id',0));
	$action=(Tools::getValue('action'));
	
	if(isset($_POST["!nativeeditor_status"]) && trim($_POST["!nativeeditor_status"])=="updated"){
		$fields=array('scaff_partner_status','scaff_partner_mode','scaff_partner_duration','scaff_partner_date_add');
		$todo=array();
		foreach($fields AS $field)
		{
			if (isset($_POST[$field]))
			{
				$val=Tools::getValue($field);
				if($field=="scaff_partner_duration" && $val=="0000-00-00")
					$todo[]=$field."=NULL";
				else
					$todo[]=$field."='".pSQL(html_entity_decode( $val ))."'";
			}
		}
		if (count($todo))
		{
			$sql = "UPDATE "._DB_PREFIX_."customer SET ".join(' , ',$todo)." WHERE id_customer=".intval($id_customer);
			Db::getInstance()->Execute($sql);
		}
		$newId = $_POST["gr_id"];
		$action = "update";
		
	}elseif(isset($_POST["!nativeeditor_status"]) && trim($_POST["!nativeeditor_status"])=="deleted"){

		$sql = "UPDATE "._DB_PREFIX_."customer SET 
					scaff_partner_id = NULL,
					scaff_partner_date_add = NULL,
					scaff_partner_status = NULL,
					scaff_partner_mode = NULL,
					scaff_partner_duration = NULL
				WHERE id_customer=".intval($id_customer);
		Db::getInstance()->Execute($sql);

		$newId = $_POST["gr_id"];
		$action = "delete";
	}
	elseif($action=="add_affiliate")
	{
		ini_set("display_errors", "1");
		$value=(Tools::getValue('value'));
		$partner_id=intval(Tools::getValue('partner_id'));
		if(!empty($value) && !empty($partner_id))
		{
			$partner = new SCAffPartner((int)($partner_id));
			$partnerCustomer = new Customer((int)$partner->customer_id);
			
			$where = "";
			if(is_numeric($value))
				$where = " id_customer = '".intval($value)."' ";
			else
				$where = " email = '".pSQL($value)."' ";
			
			$sql = "SELECT id_customer
					FROM "._DB_PREFIX_."customer
					WHERE ".$where."
					".(SCMS?" AND id_shop = '".intval($partnerCustomer->id_shop)."'":"");
			$res=Db::getInstance()->ExecuteS($sql);
			if(!empty($res[0]["id_customer"]))
			{
				Customer::customerSetAffiliate(intval($res[0]["id_customer"]), intval($partner_id));
			}
		}
	}
	
	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	 		header("Content-type: application/xhtml+xml"); } else {
	 		header("Content-type: text/xml");
	}
	echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"); 
	echo '<data>';
	echo "<action type='".$action."' sid='".$_POST["gr_id"]."' tid='".$newId."'/>";
	echo ($debug && isset($sql) ? '<sql><![CDATA['.$sql.']]></sql>':'');
	echo ($debug && isset($sql2) ? '<sql><![CDATA['.$sql2.']]></sql>':'');
	echo ($debug && isset($sql3) ? '<sql><![CDATA['.$sql3.']]></sql>':'');
	echo '</data>';
