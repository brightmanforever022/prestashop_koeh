<?php
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');

if (!class_exists('TACartReminder')) {
    include(dirname(__FILE__).'/tacartreminder.php');
}

$tacartreminder = Module::getInstanceByName('tacartreminder');

$cart = new Cart(10074);

$cart_products_html = TACartReminderTools::getContentCart($cart);

echo $cart_products_html;