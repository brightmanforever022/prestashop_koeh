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
$grids='id_partner,active,customer_id,id_lang,email,name,company,code,percent_comm,coupon_code,coupon_percent_comm,mode,duration,quantity,total_gained,total_payments,total_to_pay,total_invoiced,note,ppa,ppa_date,date_add';

if(SCMS)
    $grids='id_partner,id_shop,active,customer_id,id_lang,email,name,company,code,percent_comm,coupon_code,coupon_percent_comm,mode,duration,quantity,total_gained,total_payments,total_to_pay,total_invoiced,note,ppa,ppa_date,date_add';