<?php

require '../../config/config.inc.php';

$orderStatusCancelled = Configuration::get('PS_OS_CANCELED');
$orderStatusShipped = Configuration::get('PS_OS_SHIPPING');
$adminEmail = 'info@koehlert.com';

$query = '
    SELECT oi.id_order_invoice, o.id_order, o.id_customer,
        IFNULL((SELECT SUM(od.product_quantity-od.product_quantity_refunded-od.product_quantity_return) 
            FROM '._DB_PREFIX_.'order_detail od WHERE od.id_order = o.id_order), 0) AS tobe_shipped,
        IFNULL((SELECT SUM(od.shipped) 
            FROM '._DB_PREFIX_.'order_detail od WHERE od.id_order = o.id_order AND od.shipped >0), 0) AS already_shipped
    
    FROM `'._DB_PREFIX_.'orders` o 
    INNER JOIN `'._DB_PREFIX_.'order_invoice` oi ON o.id_order = oi.id_order
    WHERE
        oi.reminder_state = '. OrderInvoice::Reminder3Sent .'
        AND oi.paid = 0
        AND o.current_state NOT IN('. $orderStatusCancelled .','. $orderStatusShipped .')
    GROUP BY o.id_order
';


$ordersList = Db::getInstance()->executeS($query);

$customersList = array();

foreach( $ordersList as $orderData ){
    // skip if shipped what is ordered
    if( intval($orderData['tobe_shipped']) == intval($orderData['already_shipped']) ){
        continue;
    }
    
    if( !isset( $customersList[ $orderData['id_customer'] ] ) ){
        $customersList[ $orderData['id_customer'] ] = array();
    }
    
    $customersList[ $orderData['id_customer'] ][] = $orderData;
}

$notificationHtml = '<p>
    Rules for this list:<br>
    - Invoice is not paid<br> 
    - 3. Reminder is sent for the invoice<br>
    - Order has not shipped dresses<br>
    - Order is not Shipped or Cancelled<br>
</p>';

foreach( $customersList as $customerId => $customerOrders ){
    $customer = new Customer($customerId);
    
    $notificationHtml .= '<h3>'. $customer->lastname .' '. $customer->firstname .'</h3>';
    $customerOrdersHtml = '';
    foreach( $customerOrders as $customerOrderData ){
        $customerOrdersHtml .= '<li>'
            . '<a href="https://www.koehlert.com/admin1234/index.php?controller=AdminOrders&vieworder&id_order='.$customerOrderData['id_order'].'">'
            .'#'. $customerOrderData['id_order'] 
            .'</a></li>'
        ;
    }
    $notificationHtml .= '<ol>'. $customerOrdersHtml .'</ol>';
}


$mailHeaders  = 'MIME-Version: 1.0' . "\r\n";
$mailHeaders .= 'Content-type: text/html; charset=utf-8' . "\r\n";

mail($adminEmail, 'Achtung: Bitte nicht zahlendem Kunden offene Bestellungen berechnen', 
    $notificationHtml, $mailHeaders);
