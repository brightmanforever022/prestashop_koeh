<?php

require_once 'services/shipping_labels.php';

function createInvoice()
{
    global $conn;
    $invoice_print_folder = 'invoices_print';
    
    $response = array(
        'success' => false,
        'status' => false,
        'message' => '',
        'data' => array()
    );
    
    $orderPackageId = intval(@$_POST['id_order_package']);
    $invoiceTemplateId = intval(@$_POST['id_invoice_template']);
    $templateType = intval(@$_POST['template_type']);// 1 - invoice, 2 - delivery slip
    if($templateType == 0){
        $templateType = 1;
    }
    $employeeId = intval(@$_POST['id_employee']);
    
    if( !isset($_POST['shipping_label_print']) ){
        $shippingLabelPrintNumber = 1;
    }
    else{
        $shippingLabelPrintNumber = intval($_POST['shipping_label_print']);
    }
    
    
    Context::getContext()->employee = new Employee($employeeId);
    
    $orderPackage = new OrderPackage($orderPackageId);
    if( empty($orderPackage->id) ){
        $response['message'] = 'Order package not found';
        return $response;
    }
    
    $order = new Order($orderPackage->id_order);
    if( empty($order->id) ){
        $response['message'] = 'Order not found';
        return $response;
    }
    $_REQUEST['id_order'] = $order->id;// this is needed just for error message
    
    if( !in_array($templateType, array(1,2)) ){
        $response['message'] = 'Invalid template type';
        return $response;
    }
    
    if( $templateType == 1 ){
        $invoiceTemplate = Db::getInstance()->getRow('
            SELECT *
            FROM `'._DB_PREFIX_.'ba_prestashop_invoice`
            WHERE id = '. $invoiceTemplateId .'
        ');
        if( !is_array($invoiceTemplate) || empty($invoiceTemplate['id']) ){
            $response['message'] = 'Invoice template not found';
            return $response;
        }
    }
    elseif( $templateType == 2 ){
        $invoiceTemplate = Db::getInstance()->getRow('
            SELECT *
            FROM `'._DB_PREFIX_.'ba_prestashop_delivery_slip`
            WHERE id = '. $invoiceTemplateId .'
        ');
        if( !is_array($invoiceTemplate) || empty($invoiceTemplate['id']) ){
            $response['message'] = 'Delivery slip template not found';
            return $response;
        }
    }
    
    $packageDetails = Db::getInstance()->executeS('
        SELECT id_order_detail
        FROM `'._DB_PREFIX_.'order_package_detail`
        WHERE id_order_package = '. $orderPackage->id .'
    ');
    if( !is_array($packageDetails) || !count($packageDetails) ){
        $response['message'] = 'Package list does not contain details';
        return $response;
    }
    
    $productIds = array();
    foreach($packageDetails as $packageDetail){
        $productIds[] = $packageDetail['id_order_detail'];
    }
    
    $isDelivery = ($templateType == 2);
    $useOnlyShippedProducts = intval( !$isDelivery );
    
    try{
        $orderInvoiceId = $order->addInvoice($isDelivery, $invoiceTemplateId, $productIds, $useOnlyShippedProducts);
    }
    catch(Exception $e){
        $response['message'] = 'Invoice/delivery slip not created: '. $e->getMessage();
        return $response;
    }
    
    $orderInvoice = new OrderInvoice($orderInvoiceId);
    if( empty($orderInvoice->id) ){
        $response['message'] = 'Order invoice not found';
        return $response;
    }
    
    $invoicePrintPath =
        _PS_ROOT_DIR_
        . DIRECTORY_SEPARATOR . $invoice_print_folder
        . DIRECTORY_SEPARATOR . $orderInvoice->getInvoiceFileName()
    ;
    $invoicePdfUrl = 'https://www.koehlert.com/'. $invoice_print_folder . '/'. $orderInvoice->getInvoiceFileName();
    
    $copied = copy($orderInvoice->getInvoiceFilePath(), $invoicePrintPath);
    if( !$copied ){
        $response['message'] = 'Invoice not copied';
        return $response;
    }

    if( $shippingLabelPrintNumber ){
        $shippingLabelsPrint = new KoehlertWebServiceShippingLabel();
        if( !$shippingLabelsPrint->add($order->id, $order->id_address_delivery, $shippingLabelPrintNumber) ){
            $response['message'] = 'Shipping label for print not added';
            return $response;
        }
    }
    
    $response['success'] = true;
    $response['status'] = true;
    $response['data']['id_order_invoice'] = $orderInvoiceId;
    $response['data']['order_invoice_pdf_url'] = $invoicePdfUrl;
    
    return $response;
}
