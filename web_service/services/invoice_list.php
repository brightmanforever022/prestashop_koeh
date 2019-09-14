<?php

function getInvoiceList()
{
    global $conn;
    
    $response = array(
        'success' => false,
        'status' => false,
        'message' => '',
        'data' => array()
    );

    $orderId = intval(@$_POST['order_id']);
    
    $order = new Order($orderId);
    if( empty($order->id) ){
        $response['message'] = 'Order not found';
        return $response;
    }
    
    $dbQuery = new DbQuery();
    $dbQuery->select('oi.*, bai.name AS template_name')
        ->from('order_invoice', 'oi')
        ->leftJoin('ba_prestashop_invoice', 'bai', 'bai.id = oi.template_id AND bai.id_lang = '. $order->id_lang)
        ->where('oi.id_order = '. $order->id)
        ->where('number > 0')
    ;
    
    $order_invoices = Db::getInstance()->executeS($dbQuery);
    
    foreach($order_invoices as $orderInvoice){
        
        foreach( $orderInvoice as &$invValue ){
            if(!is_string($invValue)){
                continue;
            }
            $invValue = utf8_encode($invValue);
        }
        unset($invValue);
        
        $response['data'][] = $orderInvoice;
    }
    
    $response['success'] = true;
    $response['status'] = true;
    
    return $response;
}