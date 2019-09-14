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
$action = Tools::getValue('action',null);

if(!empty($action)) {
    switch($action) {
        case 'disable':
            $id_employee = Tools::getValue('employee', null);
            if(!empty($id_employee)) {
                $tip_setting = (array)json_decode(SCI::getConfigurationValue('SC_TIP_LAST_READED'),true);
                $tip_setting[$id_employee]['disable'] = true;
                if (version_compare(_PS_VERSION_, '1.5.0.1', '>=')) {
                    Configuration::updateGlobalValue('SC_TIP_LAST_READED',json_encode($tip_setting));
                } else {
                    Configuration::updateValue('SC_TIP_LAST_READED',json_encode($tip_setting));
                }
                die(_l('Tips disabled',1));
            }
            break;
    }
}
