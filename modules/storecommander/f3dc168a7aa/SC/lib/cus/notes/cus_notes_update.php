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

$id_customer=(int)Tools::getValue('id_customer',0);
$content=Tools::getValue('content',null);

if($id_customer > 0) {
    $sql = 'UPDATE ' . _DB_PREFIX_ . 'customer 
            SET note="'.pSQL($content).'" 
            WHERE id_customer = ' . (int)$id_customer;
    if(!Db::getInstance()->execute($sql)) {
        die('KO');
    }
}
die('OK');