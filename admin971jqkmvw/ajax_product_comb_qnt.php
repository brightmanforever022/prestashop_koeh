<?php
/*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
if (!defined('_PS_ADMIN_DIR_')) {
    define('_PS_ADMIN_DIR_', getcwd());
}
include(_PS_ADMIN_DIR_.'/../config/config.inc.php');
/* Getting cookie or logout */
require_once(_PS_ADMIN_DIR_.'/init.php');

$query = Tools::getValue('q', false);
if (!$query or $query == '' or strlen($query) < 1) {
    die();
}
$orderId = intval( Tools::getValue('id_order') );

$productSql = '
	SELECT *
	FROM `'._DB_PREFIX_.'product_attribute` pa
	'.Shop::addSqlAssociation('product_attribute', 'pa').'
	WHERE pa.supplier_reference = "'. pSQL($query) .'"
';
$productData = Db::getInstance()->getRow($productSql);


if( $productData == false ){
	die;
}

$product = new Product($productData['id_product']);

$combinations = $product->getAttributeCombinations($context->language->id);
$sizeQnt = array();
$reqSize = null;
foreach($combinations as $comb){
    $sizeQnt[ $comb['attribute_name'] ] = $comb['quantity'];
	if($comb['supplier_reference'] == $query){
        $reqSize = $comb['attribute_name'];
	}
}
ksort($sizeQnt);

$productNotShippedOrderStatusExclude = array(
    intval(Configuration::get('PS_OS_CANCELED')),
    intval(Configuration::get('PS_OS_SHIPPING'))
);
$productNotShippedOrdersQuery = '
    SELECT
        od.id_order,
        osl.`name` AS `order_state_name`,
        c.company,
        (od.`product_quantity` - od.`product_quantity_return` - od.`product_quantity_refunded` - od.`product_quantity_reinjected` - od.shipped) 
            AS product_not_shipped_quantity
    FROM `'._DB_PREFIX_.'order_detail` od
    INNER JOIN `'._DB_PREFIX_.'orders` o ON o.id_order = od.id_order
    INNER JOIN `'._DB_PREFIX_.'customer` c ON c.id_customer = o.id_customer
    LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = o.`current_state`)
    LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)Context::getContext()->language->id.')
    WHERE od.`product_id` = '. intval($productData['id_product']) .'
        AND od.product_attribute_id = '. intval($productData['id_product_attribute']) .'
        AND o.`current_state` NOT IN('.implode(',',$productNotShippedOrderStatusExclude).')
        AND o.id_order != '. $orderId .'
    HAVING product_not_shipped_quantity > 0
';
$productNotShippedOrdersList = Db::getInstance()->executeS($productNotShippedOrdersQuery);

echo '<style type="text/css">.table-stocks{border-radius:0;}</style>';
echo '<table style="width:100%;" ><tr>
        <td style="width:25%;height:300px;vertical-align:top;">';
echo '<table class="table table-stocks" style="width:100%;height:300px;">';
echo '<caption><b>Aktueller Bestand</b></caption>';
echo '<tr><td><b>Größe</b></td><td><b>Menge</b></td></tr>';
foreach($sizeQnt as $name => $qnt ){
	echo '<tr style="'. ($reqSize == $name ? 'font-weight:bold;' : '') .'"><td>'. $name .'</td><td>'. $qnt .'</td></tr>';
}
echo '<tr><td></td><td></td></tr>';
echo '</table></td><td style="width:50%;height:300px;vertical-align:top;">';


$expDelUrl = 'https://www.vipdress.de/admin123/index_service.php/supplier_orders/show_supplier_orders_by_sku_ext/'
	. rawurlencode($query);
echo $resp = Tools::file_get_contents($expDelUrl);

echo '</td>';

echo '<td style="width:25%;height:300px;vertical-align:top;">';
// not shipped products table start
echo '<table class="table table-stocks" >
    <caption><b>Reserved in other orders</b></caption>
    <tr><td>Order</td><td>Menge</td><td>Status</td><td>Company</td></tr>
';
foreach($productNotShippedOrdersList as $productNotShippedOrderData){
    echo '<tr>
        <td>'.$productNotShippedOrderData['id_order'].'</td>
        <td>'. $productNotShippedOrderData['product_not_shipped_quantity'] .'</td>
        <td>'. $productNotShippedOrderData['order_state_name'] .'</td>
        <td>'. $productNotShippedOrderData['company'] .'</td>
    </tr>';
}
echo '</table>';
// not shipped products table end

echo '</td>';

echo '</tr></table>';
die;

