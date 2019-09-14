<?php
/**
 * Cart Reminder
 *
 *    @author    EIRL Timactive De Véra
 *    @copyright Copyright (c) TIMACTIVE 2015 -EIRL Timactive De Véra
 *    @license   Commercial license
 *    @category pricing_promotion
 *    @version 1.1.0
 *
 *************************************
 **         CART REMINDER            *
 **          V 1.0.0                 *
 *************************************
 *  _____ _            ___       _   _
 * |_   _(_)          / _ \     | | (_)
 *   | |  _ _ __ ___ / /_\ \ ___| |_ ___   _____
 *   | | | | '_ ` _ \|  _  |/ __| __| \ \ / / _ \
 *   | | | | | | | | | | | | (__| |_| |\ V /  __/
 *   \_/ |_|_| |_| |_\_| |_/\___|\__|_| \_/ \___|
 *
 * +
 * + Languages: EN, FR
 * + PS version: 1.5,1.6
 * Cron use remind all abandonned cart
 */

ini_set('memory_limit', '600M');
if (function_exists('set_time_limit')) {
    @set_time_limit(1200);
}
if (!file_exists(dirname(__FILE__).'/../../config/config.inc.php')) {
    include(dirname(__FILE__).'/../../workspacephp/ps17/config/config.inc.php');
    include(dirname(__FILE__).'/../../workspacephp/ps17/init.php');
} else {
    include(dirname(__FILE__).'/../../config/config.inc.php');
    include(dirname(__FILE__).'/../../init.php');
}
/* test if class if already load */
if (!class_exists('TACartReminder')) {
    include(dirname(__FILE__).'/tacartreminder.php');
}
$tacartreminder = Module::getInstanceByName('tacartreminder');
if ($tacartreminder && $tacartreminder->active) {
    if ($token = Tools::getValue('token')) {
        //need xhprof extension @source "http://php.net/manual/fr/book.xhprof.php"
        $performance_audit = (bool)((int)Tools::getValue('performance_audit', 0));
        $tacartreminder->setPerformanceAudit($performance_audit);
        if (trim($token) == trim(Configuration::get('TA_CARTR_TOKEN'))) {
            TACartReminder::launchBatchAllShops();
        } else {
            $tacartreminder->loglongline('Not a valid token');
        }
    } else {
        $tacartreminder->loglongline('Token is required');
    }
    die('OK');
} else {
    die('Smart Cart reminder is disabled');
}
