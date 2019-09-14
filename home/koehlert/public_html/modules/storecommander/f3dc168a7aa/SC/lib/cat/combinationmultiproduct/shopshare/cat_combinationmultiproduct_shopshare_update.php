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


$idlist=Tools::getValue('idlist','');
$idlist_arr=explode(',',$idlist);
foreach($idlist_arr AS $row)
{
    list($id_product,$id_product_attribute) = explode('_',$row);
    $list['id_product_attribute_list'][] = (int)$id_product_attribute;
    $list['id_product_list'][] = (int)$id_product;
}
$list['id_product_list'] = array_unique($list['id_product_list']);

$action=Tools::getValue('action','');
$id_lang=Tools::getValue('id_lang','0');
$id_shop=Tools::getValue('id_shop','0');
$value=Tools::getValue('value','0');

$multiple = false;
if(count($idlist_arr) > 1) {
    $multiple = true;
}

$ids = $list['id_product_attribute_list'];

if($action!='' && !empty($id_shop) && !empty($idlist))
{
	switch($action)
	{
		// Modification de present pour le shop passé en params
		// pour une ou plusieurs déclinaisons passées en params
		case 'present':
			if($value=="true")
				$value = 1;
			else
				$value = 0;
			
			foreach($ids as $id)
			{
				if($value=="1")
				{
					$sql_in_shop ="SELECT COUNT(id_product_attribute)
						FROM "._DB_PREFIX_."product_attribute_shop
						WHERE id_product_attribute = ".(int)$id."
                        AND id_shop = ".(int)$id_shop;
					$in_shop = Db::getInstance()->getValue($sql_in_shop);
					if($in_shop == 0)
					{
						$sql_ref_shop ="SELECT id_shop
						FROM "._DB_PREFIX_."product_attribute_shop
						WHERE id_product_attribute = '".(int)$id."'
                        AND id_shop != ".(int)$id_shop."
                        AND id_shop > 0";
						$ref_shop = Db::getInstance()->getRow($sql_ref_shop);
						if(!empty($ref_shop["id_shop"]))
						{
							$new = new Combination($id, null, (int)$ref_shop["id_shop"]);
							$new->id_shop_list = array($id_shop);
							$new->save();
						}
					}
				}
				elseif(empty($value))
				{
					$sql_in_shop ="SELECT id_product_attribute
						FROM "._DB_PREFIX_."product_attribute_shop
						WHERE id_product_attribute = ".(int)$id."
                        AND id_shop = ".(int)$id_shop;
					$in_shop = Db::getInstance()->ExecuteS($sql_in_shop);
					if(!empty($in_shop[0]["id_product_attribute"]))
					{
						$sql = 'DELETE FROM `'._DB_PREFIX_.'product_attribute_shop`
						        WHERE id_product_attribute = '.(int)$id.' 
						        AND id_shop = '.(int)$id_shop;
						Db::getInstance()->execute($sql);
					}
				}
			}
		break;
		// Modification de present 
		// pour un ou plusieurs shops passés en params
		// pour un ou plusieurs products passés en params
		case 'mass_present':
			if($value=="true")
				$value = 1;
			else
				$value = 0;
			
			$shops  = explode(",", $id_shop);
			foreach($shops as $id_shop)
			{
				foreach($ids as $id)
				{
					if($value=="1")
					{
						$sql_in_shop ="SELECT pas.id_product_attribute,p.id_shop_default
							FROM "._DB_PREFIX_."product_attribute_shop pas
							LEFT JOIN "._DB_PREFIX_."product p ON p.id_product = pas.id_product
							WHERE pas.id_product_attribute = ".(int)$id."
                            AND pas.id_shop = ".(int)$id_shop;
						$in_shop = Db::getInstance()->getRow($sql_in_shop);
						if(empty($in_shop["id_product_attribute"]))
						{
							$new = new Combination($id, null, $in_shop["id_shop_default"]);
							$new->id_shop_list = array($id_shop);
							$new->save();
						}
					}
					elseif(empty($value))
					{
						$sql_in_shop ="SELECT id_product_attribute
							FROM "._DB_PREFIX_."product_attribute_shop
							WHERE id_product_attribute = ".(int)$id."
							AND id_shop = ".(int)$id_shop;
						$in_shop = Db::getInstance()->getRow($sql_in_shop);
						if(!empty($in_shop["id_product_attribute"]))
						{
							$sql = 'DELETE FROM `'._DB_PREFIX_.'product_attribute_shop`
							        WHERE id_product_attribute = '.(int)$id.' 
							        AND  id_shop = '.(int)$id_shop;
							Db::getInstance()->execute($sql);
						}
					}
				}
			}
		break;
	}

	if(!empty($list['id_product_list'])) {
	    foreach($list['id_product_list'] as $id_product) {
            ExtensionPMCM::clearFromIdsProduct($id_product);
        }
    }
}