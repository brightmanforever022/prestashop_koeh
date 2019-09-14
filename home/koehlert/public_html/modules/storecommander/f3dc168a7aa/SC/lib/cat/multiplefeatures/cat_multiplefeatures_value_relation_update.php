<?php

$action=Tools::getValue('action','0');
$id_feature = intval(Tools::getValue('id_feature',0));
$id_feature_value = intval(Tools::getValue('id_feature_value',0));
$value = Tools::getValue('value','');
$product_list = Tools::getValue('product_list','0');

$hasPosition = false;
if(isField("position", "feature_product"))
	$hasPosition = true;

	if ($action=='update' && $id_feature>0)
	{
		$position = Tools::getValue('position','0');
		$product_listarray = explode(',',$product_list);
		
		$sql = "DELETE FROM "._DB_PREFIX_."feature_product WHERE id_feature=".(int)$id_feature." AND id_feature_value=".(int)$id_feature_value." AND id_product IN (".psql($product_list).")";
		Db::getInstance()->Execute($sql);

		$sql = 'SELECT fv.id_feature_value
						FROM `'._DB_PREFIX_.'feature_value` fv
							INNER JOIN `'._DB_PREFIX_.'feature_product` fp ON (fv.id_feature_value=fp.id_feature_value)
						WHERE fv.custom = 1
							AND fv.id_feature = "'.(int)$id_feature.'"
							AND fp.id_product IN ('.psql($product_list).')';
		$to_deletes = Db::getInstance()->ExecuteS($sql);
		foreach($to_deletes as $to_delete)
		{
			$sql = 'DELETE FROM '._DB_PREFIX_.'feature_value_lang WHERE id_feature_value = "'.(int)$to_delete["id_feature_value"].'"';
			Db::getInstance()->Execute($sql);
			
			$sql = 'DELETE FROM '._DB_PREFIX_.'feature_product WHERE id_feature_value = "'.(int)$to_delete["id_feature_value"].'"';
			Db::getInstance()->Execute($sql);
			
			$sql = 'DELETE FROM '._DB_PREFIX_.'feature_value WHERE id_feature_value = "'.(int)$to_delete["id_feature_value"].'"';
			Db::getInstance()->Execute($sql);
		}

        if($value==0) {
            foreach($product_listarray as $product) {
                addToHistory('cat_prop_multiplefeature', 'modification', 'feature_value', $product, (int)Configuration::get('PS_LANG_DEFAULT'), 'feature_product', null, (int)$id_feature_value,(int)SCI::getSelectedShop());
            }
        }

		$sqlstr = '';
		foreach($product_listarray AS $id_product)
		{
			if($hasPosition)
            {
                if ($id_product!=0)
                    $sqlstr.='('.(int)$id_feature.','.(int)$id_product.','.(int)$id_feature_value.','.(int)$position.'),';
            }
			else
            {
                if ($id_product!=0)
                    $sqlstr.='('.(int)$id_feature.','.(int)$id_product.','.(int)$id_feature_value.'),';
            }
		}
		$sqlstr = trim($sqlstr,',');
		if ($value==1 && $sqlstr!='')
		{
			if($hasPosition)
				$sql = "INSERT INTO `"._DB_PREFIX_."feature_product` (id_feature,id_product,id_feature_value,position) VALUES ".psql($sqlstr);
			else
				$sql = "INSERT INTO `"._DB_PREFIX_."feature_product` (id_feature,id_product,id_feature_value) VALUES ".psql($sqlstr);
			Db::getInstance()->Execute($sql);
			foreach($product_listarray AS $id_product) {
                addToHistory('cat_prop_multiplefeature', 'modification', 'feature_value', $id_product, (int)Configuration::get('PS_LANG_DEFAULT'), 'feature_product', $id_feature_value, null,(int)SCI::getSelectedShop());
            }
		}

        foreach($product_listarray AS $id_product)
        {
            if (_s('APP_COMPAT_HOOK') && !_s('APP_COMPAT_EBAY'))
            {
                $product = new Product(intval($id_product));
                SCI::hookExec('updateProduct', array('id_product' => (int)$product->id,'product' => $product));
            }
        }
	}
	elseif($action=='add_custom' && $id_feature>0)
	{
		$id_product = intval(Tools::getValue('id_product','0'));
		$iso = (Tools::getValue('iso','0'));
		$lang = 0;
		if(!empty($iso))
			$lang = Language::getIdByIso($iso);
		
		if(!empty($id_product) && !empty($lang))
		{
			// DELETE			
			$sql = 'SELECT fv.id_feature_value
						FROM `'._DB_PREFIX_.'feature_value` fv
							INNER JOIN `'._DB_PREFIX_.'feature_product` fp ON (fv.id_feature_value=fp.id_feature_value)
						WHERE fv.custom = 1
							AND fv.id_feature = "'.(int)$id_feature.'"
							AND fp.id_product = "'.intval($id_product).'"';
			$to_deletes = Db::getInstance()->ExecuteS($sql);
			$id_feature_value = 0;
			foreach($to_deletes as $to_delete)
			{
				$sql = 'DELETE FROM '._DB_PREFIX_.'feature_value_lang WHERE id_feature_value = "'.(int)$to_delete["id_feature_value"].'" AND id_lang="'.(int)$lang.'"';
				Db::getInstance()->Execute($sql);
				$id_feature_value = $to_delete["id_feature_value"];
			}
			
			$sql = "DELETE FROM "._DB_PREFIX_."feature_product WHERE id_feature=".(int)$id_feature." AND id_product = '".intval($id_product)."'";
			if(!empty($id_feature_value))
				$sql .= " AND id_feature_value != '".$id_feature_value."'";
			Db::getInstance()->Execute($sql);
			
			// INSERT
			if(!empty($value))
			{
				if(empty($id_feature_value))
				{
					$sql = "INSERT INTO `"._DB_PREFIX_."feature_value` (id_feature,custom) 
							VALUES ('".(int)$id_feature."','1')";
					Db::getInstance()->Execute($sql);
					$id_feature_value = Db::getInstance()->Insert_ID();
					
					$sql = "INSERT INTO `"._DB_PREFIX_."feature_product` (id_feature,id_product,id_feature_value) 
							VALUES ('".(int)$id_feature."','".(int)$id_product."','".(int)$id_feature_value."')";
					Db::getInstance()->Execute($sql);
                    addToHistory('cat_prop_multiplefeature', 'modification', 'feature_value_custom', $id_product, (int)Configuration::get('PS_LANG_DEFAULT'), 'feature_product', $id_feature_value, null,(int)SCI::getSelectedShop());
                }
				if(!empty($id_feature_value))
				{
					$sql = "INSERT INTO `"._DB_PREFIX_."feature_value_lang` (id_feature_value,id_lang,value)
						VALUES ('".(int)$id_feature_value."','".(int)$lang."','".pSQL($value)."')";
					Db::getInstance()->Execute($sql);
				}
			} else {
                addToHistory('cat_prop_multiplefeature', 'modification', 'feature_value_custom', $id_product, (int)Configuration::get('PS_LANG_DEFAULT'), 'feature_product', null, $id_feature_value,(int)SCI::getSelectedShop());
            }

            if (_s('APP_COMPAT_HOOK') && !_s('APP_COMPAT_EBAY'))
            {
                $product = new Product(intval($id_product));
                SCI::hookExec('updateProduct', array('id_product' => (int)$product->id,'product' => $product));
            }
		}
	}
	elseif($action=='position' && $id_feature>0 && $hasPosition)
	{
		$positions = Tools::getValue('positions');
		$product_listarray = explode(',',$product_list);
		if(!empty($positions) && count($positions)>0 && !empty($product_listarray) && count($product_listarray)>0)
		{
			foreach($product_listarray as $product)
			{
				foreach($positions as $position=>$id_feature_value)
				{
					if(!empty($id_feature_value))
					{
						$sql2="	SELECT id_feature_value
						FROM "._DB_PREFIX_."feature_product
						WHERE id_product = '".(int)$product."'
							AND id_feature_value = '".(int)$id_feature_value."'";
						$exist = Db::getInstance()->ExecuteS($sql2);
						if(!empty($exist[0]["id_feature_value"]))
						{
							$sql = "UPDATE `"._DB_PREFIX_."feature_product` SET position='".(int)$position."'
							WHERE id_product = '".(int)$product."'
								AND id_feature_value = '".(int)$id_feature_value."'";
							Db::getInstance()->Execute($sql);
						}
					}
				}

                if (_s('APP_COMPAT_HOOK') && !_s('APP_COMPAT_EBAY'))
                {
                    $product = new Product(intval($id_product));
                    SCI::hookExec('updateProduct', array('id_product' => (int)$product->id,'product' => $product));
                }
			}
		}
	}
	else
	{
		$id_feature_values = Tools::getValue('id_feature_values','0');
        $product_listarray = explode(',',$product_list);
		if ($action=='mass_used' && !empty($id_feature_values))
		{
			$sql = "DELETE FROM "._DB_PREFIX_."feature_product WHERE id_feature=".(int)$id_feature." AND id_feature_value IN (".pSQL($id_feature_values).") AND id_product IN (".pSQL($product_list).")";
			Db::getInstance()->Execute($sql);
            if($value==0) {
                $expl_id_feature_value = explode(',',$id_feature_values);
                foreach($product_listarray as $product) {
                    foreach($expl_id_feature_value as $id_fv){
                        addToHistory('cat_prop_multiplefeature', 'modification', 'feature_value', $product, (int)Configuration::get('PS_LANG_DEFAULT'), 'feature_product', null, $id_fv,(int)SCI::getSelectedShop());
                    }
                }
            }
			$sql = 'SELECT fv.id_feature_value
							FROM `'._DB_PREFIX_.'feature_value` fv
								INNER JOIN `'._DB_PREFIX_.'feature_product` fp ON (fv.id_feature_value=fp.id_feature_value)
							WHERE fv.custom = 1
								AND fv.id_feature = "'.(int)$id_feature.'"
								AND fp.id_product IN ('.psql($product_list).')';
			$to_deletes = Db::getInstance()->ExecuteS($sql);
			foreach($to_deletes as $to_delete)
			{
				$sql = 'DELETE FROM '._DB_PREFIX_.'feature_value_lang WHERE id_feature_value = "'.(int)$to_delete["id_feature_value"].'"';
				Db::getInstance()->Execute($sql);
				
				$sql = 'DELETE FROM '._DB_PREFIX_.'feature_product WHERE id_feature_value = "'.(int)$to_delete["id_feature_value"].'"';
				Db::getInstance()->Execute($sql);
				
				$sql = 'DELETE FROM '._DB_PREFIX_.'feature_value WHERE id_feature_value = "'.(int)$to_delete["id_feature_value"].'"';
				Db::getInstance()->Execute($sql);
			}
			
			if($value==1)
			{
				$feature_value_listarray = explode(',',$id_feature_values);
				$product_listarray = explode(',',$product_list);
				foreach($feature_value_listarray as $feature_value)
				{
					if(!empty($feature_value))
					{						
						foreach($product_listarray as $product)
						{
							if(!empty($product))
							{
								$sql = "INSERT INTO `"._DB_PREFIX_."feature_product` (id_feature,id_product,id_feature_value)
									VALUES ('".(int)$id_feature."','".(int)$product."','".(int)$feature_value."')";
								Db::getInstance()->Execute($sql);
                                addToHistory('cat_prop_multiplefeature', 'modification', 'feature_value', $product, (int)Configuration::get('PS_LANG_DEFAULT'), 'feature_product', $feature_value, null,(int)SCI::getSelectedShop());

                                if (_s('APP_COMPAT_HOOK') && !_s('APP_COMPAT_EBAY'))
                                {
                                    $product = new Product(intval($id_product));
                                    SCI::hookExec('updateProduct', array('id_product' => (int)$product->id,'product' => $product));
                                }
							}
						}
					}
				}
			}
		}
	}
    if(!empty($product_list)) {
        $sql = "UPDATE "._DB_PREFIX_."product SET date_upd = '".pSQL(date("Y-m-d H:i:s"))."' WHERE id_product IN (".pSQL($product_list).");";
        if(version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
            $sql .= "UPDATE "._DB_PREFIX_."product_shop SET date_upd = '".pSQL(date("Y-m-d H:i:s"))."' WHERE id_product IN (".pSQL($product_list).") AND id_shop IN (".pSQL(SCI::getSelectedShopActionList(true)).")";
        }
        Db::getInstance()->Execute($sql);
    }
