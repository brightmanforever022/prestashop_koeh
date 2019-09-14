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

$grids = array();
$grids['grid_feedbiz_option'] = 'language_iso,id_product,id_product_attribute,name,attribute_name,force,disable,price_inc_tax,price,shipping,text';
$grids['grid_feedbiz_amazon_option'] = 'region,id_product,id_product_attribute,name,attribute_name,force,disable,price_inc_tax,price,shipping,text,nopexport,noqexport,fba,fba_value,latency,asin1,asin2,asin3,bullet_point1,bullet_point2,bullet_point3,bullet_point4,bullet_point5,shipping_type,gift_wrap,gift_message,browsenode,repricing_min,repricing_max,repricing_gap,shipping_group';
$grids['grid_feedbiz_cdiscount_option'] = 'region,id_product,id_product_attribute,name,attribute_name,force,disable,price_inc_tax,price,price_up,price_down,shipping,shipping_delay,clogistique,valueadded,text';