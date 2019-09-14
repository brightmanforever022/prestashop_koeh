<?php
// Wheelronix Ltd. development team
// site: http://www.wheelronix.com

//define('_PS_MODE_DEV_', true);
require '../../config/config.inc.php';
$module = Module::getInstanceByName('productsort');
$module->sortProducts();