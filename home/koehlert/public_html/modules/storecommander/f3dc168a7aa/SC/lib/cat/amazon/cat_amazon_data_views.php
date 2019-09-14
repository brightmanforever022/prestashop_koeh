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

$grids = 'region,id_product,id_product_attribute,disable,name,attribute_name,bullet_point1,bullet_point2,bullet_point3,bullet_point4,bullet_point5,text,asin1,asin2,asin3,amazon_price,price_rule,price,price_inc_tax,force,latency,gift_wrap,gift_message,shipping,shipping_type,browsenode';
if(!empty($alternate_fields_enable)) {
    $grids .=',alternative_title,alternative_description';
}