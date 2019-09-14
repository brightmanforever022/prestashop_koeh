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
 **          V 1.0.2                 *
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
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_0_2($object, $install = false)
{
    $result = false;
    if (($object->active || $install)) {
        $result = true;
        if (!Configuration::updateValue('TA_CARTR_CODE_FORMAT', 'LLLNLNLNLNLNLNLNLNLL') ||
            !Configuration::updateValue('TA_CARTR_AUTO_ADD_CR', 0)
        ) {
            $result = false;
        }
    }

    return $result;
}
