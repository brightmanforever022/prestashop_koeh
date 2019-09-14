<?php

require realpath(dirname(__FILE__)) . '/../../config/config.inc.php';

khlcart_remove_carts();

/**
 * This function deletes empty carts since 1 day and abandoned carts since 10 days
 */
function khlcart_remove_carts()
{
    $query = '
        SELECT c.*, o.id_order
        FROM '._DB_PREFIX_.'cart c
        LEFT JOIN '._DB_PREFIX_.'orders o ON o.id_cart = c.id_cart
        HAVING ISNULL(o.id_order)
    ';
    
    $abandonedCartsList = Db::getInstance()->executeS($query);
    
    $today = new DateTime();
    $context = Context::getContext();
    
    foreach($abandonedCartsList as $abandonedCartData){
        $cartDateUpdate = new DateTime($abandonedCartData['date_upd']);
        $cartUpdatedInterval = $cartDateUpdate->diff($today, true);
        
        
        $cart = new Cart(intval($abandonedCartData['id_cart']));
        $cartTotal = $cart->getOrderTotal(false, Cart::ONLY_PRODUCTS);

        if( ($cartUpdatedInterval->days >= 1) && ($cartTotal == 0) ){
            $cart->delete();
            continue;
        }
        
        if( $cartUpdatedInterval->days >= 10 ){
            $cart->delete();
            continue;
        }
    }
}