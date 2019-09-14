<?php

include('core/constant.php');
include('core/db.php');
include(__DIR__ . '/../config/config.inc.php');
//include(__DIR__ . '/../config/init.php');

Context::getContext()->cookie->stopCookie();

$file = null;
if( !empty($_GET['acc_key']) && ($_GET['acc_key'] == SERVICE_ACCESS_KEY) ){
    
    $error = 'Invalid web service';
    
    if( isset($_GET['web_service']) && !empty($_GET['web_service']) ){
        $file = $_GET['web_service'];
    }
    if( is_null($file) && !empty($_POST['web_service'])) {
        $file = $_POST['web_service'];
    }
}
elseif( isset($_GET['web_service']) && ($_GET['web_service'] == 'shipping_labels') ){
    $file = $_GET['web_service'];
}
else{
    $error = 'Invalid key';
}
switch ($file) {

    case 'products':
        include('services/products.php');
        $result = getProducts();
        break;
    case 'orders':
        include('services/orders.php');
        $result = getOrders();
        break;
    case 'sizes':
        include('services/size.php');
        $result = getAllSizes();
        break;
    case 'supplier':
        include('services/supplier.php');
        $result = getSupplier();
        break;
    case 'orderdetail':
        include('services/order_details.php');
        $result = getOrderDetails();
        break;
    case 'languages':
        include('services/language.php');
        $result = getAllLanguages();
        break;
    case 'orderstates':
        include('services/order_states.php');
        $result = getAllStates();	
        break;
    case 'currency':
        include('services/currency.php');
        $result = getCurrency();	
        break;
    case 'updateorderstates':
        include('services/update_order_state.php');
        $result = updateOrderState();	
        break;
    case 'sale_stats_daily':
    case 'sale_stats_weekly':
    case 'sale_stats_monthly':
        include('services/sale_stats.php');
        $result = getSaleStats();
        break;
    case 'photos':
        include 'services/photos.php';
        $result = getPhotos();
        break;
    case 'invoice_templates':
        include 'services/invoice_templates.php';
        $result = getInvoiceTemplates();
        break;
    case 'invoice_create':
        include 'services/invoice_create.php';
        $result = createInvoice();
        break;
    case 'invoice_list':
        include 'services/invoice_list.php';
        $result = getInvoiceList();
        break;
    case 'shipping_labels':
        include 'services/shipping_labels.php';
        
        $shippingLabelsPrint = new KoehlertWebServiceShippingLabel();
        if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
            $result = $shippingLabelsPrint->listing(true);
        }
        elseif( $_SERVER['REQUEST_METHOD'] == 'POST' ){
            $data = array(
                'id_shipping_label_print' => $_POST['id_shipping_label_print'],
                'processed' => $_POST['processed']
            );
            $result = $shippingLabelsPrint->update($data);
        }
        
        break;
    case 'shipping_labels_create':
        include 'services/shipping_labels.php';
        $shippingLabelsPrint = new KoehlertWebServiceShippingLabel();
        $result = $shippingLabelsPrint->create();
        break;
    default:
        $result['status'] = false;
        $result['message'] = $error;
        $result['data'] = [];
}

if( $result['status'] != true ){
    $log = "Error: ";
    if( isset($result['_error_private']) ){
        $log .= $result['_error_private'] ."\n";
        unset($result['_error_private']);
    }
    else{
        $log .= $result['message'] ."\n";
    }
    
    $log .= "Parameters:\n";
    foreach( $_REQUEST as $name => $value ){
        if( is_array($value) ){
            $log .= "$name\n";
            foreach($value as $subKey => $subVal){
                $log .= "    $subKey = $subVal\n";
            }
        }
        else{
            $log .= "$name = $value \n";
        }
    }
    $log .= "\n-------------------\n";
    $log .= "IP: {$_SERVER['REMOTE_ADDR']}\n";
    $log .= "Client: {$_SERVER['HTTP_USER_AGENT']}\n";
    
    mail('christian@koehlert.com', 'Koehlert.com web_service API error', $log);
    
    $log = 'web_service: ' . $log;
    PrestaShopLoggerCore::addLog($log, 3);
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
