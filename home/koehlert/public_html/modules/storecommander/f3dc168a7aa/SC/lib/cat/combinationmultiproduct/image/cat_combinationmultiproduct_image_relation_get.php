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

	$id_image=intval(Tools::getValue('id_image'));
	
	$sql = '
	SELECT pa.id_product,pai.id_product_attribute
	FROM `'._DB_PREFIX_.'product_attribute_image` pai
    LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON pa.id_product_attribute = pai.id_product_attribute
	WHERE pai.`id_image` = '.(int)$id_image;
	$res=Db::getInstance()->ExecuteS($sql);

	$return = array();
	
	foreach($res AS $val)
	{
		$return[] = (int)$val['id_product'].'_'.$val['id_product_attribute'];
	}

	echo implode(',',$return);