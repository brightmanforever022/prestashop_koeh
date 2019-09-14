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

$id_lang=(int)Tools::getValue('id_lang');
$id_carrier=(int)Tools::getValue('id_carrier',0);
$delay=Tools::getValue('delay');

if($id_carrier) {

    $sql = 'UPDATE '._DB_PREFIX_.'carrier_lang 
            SET delay = "'.pSQL($delay).'" 
            WHERE id_carrier = '.(int)$id_carrier.' 
            AND id_lang = '.(int)$id_lang;
    if(version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
        $sql .= ' AND id_shop = '.(int)SCI::getSelectedShop();
    }
    if(Db::getInstance()->execute($sql)) {
        die('OK');
    } else {
        die('KO');
    }
}
