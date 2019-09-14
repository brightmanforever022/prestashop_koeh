<?php
// Wheelronix Ltd. development team
// site: http://www.wheelronix.com
// mail: info@wheelronix.com

/**
 * Service script returns order_id if product with given sku presents in order and is not yet shipped. 
 * In case if there is no such not shipped products script returns 0
 * Expects request parameter sku
 */

require '../../config/config.inc.php';

echo intval(Db::getInstance()->getValue('select id_order from '._DB_PREFIX_.'order_detail where shipped=0 '
        . 'and product_supplier_reference = \''. addslashes($_REQUEST['sku']).'\''));