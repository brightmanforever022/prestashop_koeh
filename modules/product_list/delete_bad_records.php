<?php

// Wheelronix Ltd. development team
  // site: http://www.wheelronix.com
  // mail: info@wheelronix.com
  
/**
 * Should be called by cron. Deletes wrong records from db appear due buf in SC (i think).
 */

define('_PS_MODE_DEV_', true);
require '../../config/config.inc.php';

Db::getInstance()->execute('delete from '._DB_PREFIX_.'product_attribute where id_product=0');
Db::getInstance()->execute('delete from '._DB_PREFIX_.'product_supplier where id_product=0');
Db::getInstance()->execute('delete from '._DB_PREFIX_.'stock_available where id_product=0');