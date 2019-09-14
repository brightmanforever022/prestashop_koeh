<?php

	$id_lang=2;
	$id_partner=intval(Tools::getValue('gr_id',0));
	$name = "";
	$code = "";
	$action=(Tools::getValue('action',""));

	if(isset($_POST["!nativeeditor_status"]) && trim($_POST["!nativeeditor_status"])=="inserted"){
		$code = SCAffPartner::getNewCode();
		$sql="INSERT INTO "._DB_PREFIX_."scaff_partner (customer_id,code,percent_comm,coupon_percent_comm,duration,mode,date_add) VALUES (0,'".$code."','20','0','0','unlimited','".date("Y-m-d H:i:s")."')";
		Db::getInstance()->Execute($sql);
		$newId = Db::getInstance()->Insert_ID();
		$action = "insert";
		$name = "/";
		
	}elseif(isset($_POST["!nativeeditor_status"]) && trim($_POST["!nativeeditor_status"])=="updated"){
		$fields=array('customer_id','code','percent_comm','mode','duration','note','coupon_code','coupon_percent_comm','date_add','active','ppa');
		$todo=array();
		
		$scaffpartner = new SCAffPartner(intval($id_partner));
		
		foreach($fields AS $field)
		{
			if (isset($_POST[$field]))
			{
				$val=Tools::getValue($field);

                if($field=="code")
                {
                    $exist = SCAffPartner::getFromCode($val);
                    if(!empty($exist["id_partner"]))
                    {
                        $code = $scaffpartner->code;
                        continue;
                    }
                }
                if($field=="coupon_code")
                {
                    $remove_coupons=Tools::getValue("remove_coupons", "0");
                    if(!empty($remove_coupons) && !empty($scaffpartner->coupon_code))
                    {
                        $id_cart_rule = CartRule::getIdByCode($scaffpartner->coupon_code);
                        $cart_rule = new CartRule((int)$id_cart_rule);
                        $cart_rule->delete();
                    }
                }

				if($field=="ppa")
				{
					if(empty($val))
						$todo[]="ppa_date='0000-00-00'";
					else
						$todo[]="ppa_date='".pSQL(date("Y-m-d"))."'";

                    $sql = "UPDATE "._DB_PREFIX_."customer SET 
                        scaff_partner_id='".(int)$id_partner."',
                        scaff_partner_status = 'active',
                        scaff_partner_date_add = '".date("Y-m-d H:i:s")."',
                        scaff_partner_mode = 'unlimited'
                    WHERE id_customer=".intval($scaffpartner->customer_id);
                    Db::getInstance()->Execute($sql);

                    $scaff_ppa_customergroup = Configuration::get('SC_AFFILIATION_PPA_CUSTOMER_GROUP');
                    if(!empty($scaff_ppa_customergroup))
                    {
                        if(empty($val))
                        {
                            $sql="DELETE FROM "._DB_PREFIX_."customer_group WHERE id_customer=".intval($scaffpartner->customer_id)." AND id_group=".intval($scaff_ppa_customergroup);
                            Db::getInstance()->Execute($sql);
                        }
                        else
                        {
                            $sql="INSERT INTO "._DB_PREFIX_."customer_group (`id_customer`, `id_group`) 
							VALUES ('".intval($scaffpartner->customer_id)."','".intval($scaff_ppa_customergroup)."')";
                            Db::getInstance()->Execute($sql);
                        }
                    }
				}
				
				$todo[]=$field."='".psql(html_entity_decode( $val ))."'";
				
				if($field=="code" || $field=="percent_comm" || $field=="mode" || $field=="duration")
				{
					$sql="INSERT INTO "._DB_PREFIX_."scaff_history (`id_partner`, `name`, `value`, `old_value`, `date_add`) 
							VALUES ('".intval($id_partner)."','".pSQL($field)."','".psql(html_entity_decode( $val ))."','".pSQL($scaffpartner->{$field})."','".date("Y-m-d H:i:s")."')";
					Db::getInstance()->Execute($sql);
				}
			}
		}
		if (count($todo))
		{
			$sql = "UPDATE "._DB_PREFIX_."scaff_partner SET ".join(' , ',$todo)." WHERE id_partner=".intval($id_partner);
			Db::getInstance()->Execute($sql);
		}
		$newId = $_POST["gr_id"];
		$action = "update";
		
		$sql="SELECT c.* 
				FROM "._DB_PREFIX_."customer c
					INNER JOIN "._DB_PREFIX_."scaff_partner p ON c.id_customer = p.customer_id
				WHERE id_partner=".intval($id_partner);
		$customer = Db::getInstance()->getRow($sql);
		if(!empty($customer["firstname"]) || !empty($customer["lastname"]))
		{
			$name = $customer["firstname"]." ".$customer["lastname"];
		}

        SC_Ext::readCustomGMAPartnerGridConfigXML("onAfterUpdateSQL");
		
	}elseif(isset($_POST["!nativeeditor_status"]) && trim($_POST["!nativeeditor_status"])=="deleted"){

		$sql="DELETE FROM "._DB_PREFIX_."scaff_partner WHERE id_partner=".intval($id_partner);
		Db::getInstance()->Execute($sql);

		$newId = $_POST["gr_id"];
		$action = "delete";
	}
	elseif($action=="reset_ppa")
	{
		$sql = "UPDATE "._DB_PREFIX_."scaff_partner SET ppa=0, ppa_date='0000-00-00'";
		Db::getInstance()->Execute($sql);
        
        $scaff_ppa_customergroup = Configuration::get('SC_AFFILIATION_PPA_CUSTOMER_GROUP');
        if(!empty($scaff_ppa_customergroup))
        {
            if(empty($val))
            {
                $sql="DELETE FROM "._DB_PREFIX_."customer_group WHERE id_group=".intval($scaff_ppa_customergroup);
                Db::getInstance()->Execute($sql);
            }
        }
	}
	
	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	 		header("Content-type: application/xhtml+xml"); } else {
	 		header("Content-type: text/xml");
	}
	echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"); 
	echo '<data>';
	echo "<action type='".$action."' sid='".$_POST["gr_id"]."' tid='".$newId."' name='".$name."' code='".$code."'/>";
	echo ($debug && isset($sql) ? '<sql><![CDATA['.$sql.']]></sql>':'');
	echo ($debug && isset($sql2) ? '<sql><![CDATA['.$sql2.']]></sql>':'');
	echo ($debug && isset($sql3) ? '<sql><![CDATA['.$sql3.']]></sql>':'');
	echo '</data>';
