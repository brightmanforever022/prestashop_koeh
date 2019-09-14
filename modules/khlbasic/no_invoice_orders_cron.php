<?php

require realpath(dirname(__FILE__)) . '/../../config/config.inc.php';
require_once _PS_MODULE_DIR_ . 'ba_prestashop_invoice/ba_prestashop_invoice.php';
include_once(_PS_SWIFT_DIR_.'Swift.php');
include_once(_PS_SWIFT_DIR_.'Swift/Connection/SMTP.php');
include_once(_PS_SWIFT_DIR_.'Swift/Connection/NativeMail.php');
include_once(_PS_SWIFT_DIR_.'Swift/Plugin/Decorator.php');

$context = Context::getContext();
$adminEmail = 'info@koehlert.com';

$query = '
    SELECT o.id_order, o.date_add, c.company, c.firstname, c.lastname, ic.invoice_count
    FROM '._DB_PREFIX_.'orders o
    INNER JOIN '._DB_PREFIX_.'customer c ON c.id_customer = o.id_customer
    LEFT JOIN ( 
        SELECT COUNT(oi.id_order_invoice) AS invoice_count, oi.id_order
        FROM '._DB_PREFIX_.'order_invoice oi
        INNER JOIN '._DB_PREFIX_.'ba_prestashop_invoice bai ON bai.id = oi.template_id
        WHERE oi.number > 0
            AND bai.payment_type != '. (BaOrderInvoice::PAYMENT_TYPE_ORDER_CONFIRM) .'
        GROUP BY oi.id_order
    ) ic ON ic.id_order = o.id_order
    WHERE 
        o.current_state NOT IN(6,15,18,19)
        AND o.id_customer != 31
        AND DATEDIFF(NOW(), o.date_add) > 5
        AND ( ISNULL(ic.invoice_count) OR ic.invoice_count = 0 )
        AND o.ignore_no_invoice_note = 0
    ORDER BY o.date_add DESC
';

$orderNoInvoiceList = Db::getInstance()->executeS($query);


if( !is_array($orderNoInvoiceList) || !count($orderNoInvoiceList) ){
    die;
}

$tools = new Tools();
$centralServerUrlConfig = $tools->getCentralServerUrl();
$notAvailForShip = array();
$orderNotifyAboutList = array();
foreach($orderNoInvoiceList as $orderNoInvoice){
    
    $hasAvailableForShipping = false;
    $orderProducts = OrderDetail::getList($orderNoInvoice['id_order']);
    
    $serviceUrl = $centralServerUrlConfig['serverUrl'] 
        . 'admin123/index_service.php/dbk_ext_shop_delivery/get_stock_status_koehlert/'
        . $orderNoInvoice['id_order']
    ;
    $orderStockStatusResp = file_get_contents($serviceUrl,  false, stream_context_create($centralServerUrlConfig['fgcOptions']));
    $orderStockStatus = json_decode($orderStockStatusResp, true);
    
    foreach( $orderProducts as $orderProduct ){
        $productActualQuantity = $orderProduct['product_quantity'] 
            - $orderProduct['product_quantity_return']
            - $orderProduct['product_quantity_refunded']
            - $orderProduct['product_quantity_reinjected']
        ;
        if( $productActualQuantity <= 0 ){
            continue;
        }
        
        if( isset($orderStockStatus[$orderProduct['product_supplier_reference']]) 
            && ($orderStockStatus[ $orderProduct['product_supplier_reference'] ]['avForCur'] > 0) 
        ){
            $hasAvailableForShipping = true;
        }
    }
    
    if( !$hasAvailableForShipping ){
        $notAvailForShip[] = $orderNoInvoice['id_order'];
        continue;
    }
    
    $orderNotifyAboutList[] = $orderNoInvoice;
    
}

if( !count($orderNotifyAboutList) ){
    die;
}

$orderBaseUrl = 'https://www.koehlert.com/admin1234/index.php?controller=AdminOrders&vieworder&id_order=';
$notificationHtml = '';
$notificationHtml .= '<p>Following orders are older than 5 days and no invoice was created. Please check
and create invoices urgently.</p>';
$notificationHtml .= '<ul>';
foreach($orderNotifyAboutList as $orderNotifyAbout){
    $notificationHtml .= '<li>'
        .'<a href="'. $orderBaseUrl . $orderNotifyAbout['id_order'] .'">#'. $orderNotifyAbout['id_order'] .'</a>'
        . ' - ' . Tools::displayDate($orderNotifyAbout['date_add'])
        . ' - ' . $orderNotifyAbout['company'] .', '. $orderNotifyAbout['firstname'] .' '. $orderNotifyAbout['lastname']
        .'</li>'
    ;
            
}
$notificationHtml .= '</ul>';

$subject = 'Attention: No invoices created longer than 5 days';
$to_list = new Swift_RecipientList();
$to_list->addTo($adminEmail);
$connection = new Swift_Connection_NativeMail();
$swift = new Swift($connection, 'www.koehlert.com');
$message = new Swift_Message($subject);
$message->setCharset('utf-8');
/* Set Message-ID - getmypid() is blocked on some hosting */
//$message->setId(Mail::generateId());
$message->headers->setEncoding('Q');

$message->attach(new Swift_Message_Part($notificationHtml, 'text/html', '8bit', 'utf-8'));

$send = $swift->send($message, $to_list, new Swift_Address($adminEmail, $adminEmail));
$swift->disconnect();
