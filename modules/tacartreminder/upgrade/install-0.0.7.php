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
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_0_0_7($object, $install = false)
{
    $result = false;
    if (($object->active || $install)) {
        $result = true;
        $result &= (bool)Db::getInstance()->Execute(
            '
		ALTER TABLE `'._DB_PREFIX_.'ta_cartreminder_mail_template_lang`
						ADD COLUMN `title` VARCHAR(255) NULL AFTER `subject`'
        );
        $result &= (bool)Db::getInstance()->Execute(
            '
		UPDATE `'._DB_PREFIX_.'ta_cartreminder_mail_template_lang` mtl
			SET mtl.`title` = mtl.`subject`'
        );
    }

    return $result;
}
