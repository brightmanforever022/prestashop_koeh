<?php

class KhlordsrvOrdersModuleFrontController extends ModuleFrontController
{
    const INVOICE_TEMPLATE_ID = 48;
    const INVOICES_DIRECTORY = 'invoices_print';
    
    public function postProcess()
    {
        $action = Tools::getValue('action');
        
        switch($action){
            case 'create':
            case 'get':
                $this->processCommand($action);
                break;
            
            case 'help':
                $this->content_only = true;
                $this->display_header = false;
                $this->display_footer = false;
                
                return $this->setTemplate('doc.tpl');
                break;
            case 'help_app':
                $this->content_only = true;
                $this->display_header = false;
                $this->display_footer = false;
            
                return $this->setTemplate('doc_app.tpl');
                break;
                
            default:
                break;
        }
    }
    
    public function processCommand($action)
    {
        $this->ajax = true;
        
        $responseData = array(
            'success' => false,
            'data' => array(),
            'message' => ''
        );
        
        $authenticated = false;
        $customerId = null;
        
        if( isset($_GET['auth_key']) ){
            try{
                $customerId = $this->authenticateByAuthKey();
                $authenticated = true;
            }
            catch(Exception $e){
                PrestaShopLoggerCore::addLog(__CLASS__ .', '. $e->getMessage() . $e->getTraceAsString(), 3);
                $responseData['message'] = $e->getMessage();
            }
            
        }
        elseif( isset($_GET['ws_key']) ){
        $authenticated = true;
            /*try{
                $this->authenticateByWsKey();
                $authenticated = true;
            }
            catch(Exception $e){
                PrestaShopLoggerCore::addLog(__CLASS__ .', '. $e->getMessage() . $e->getTraceAsString(), 3);
                $responseData['message'] = $e->getMessage();
            }*/
        }
        else{
            PrestaShopLoggerCore::addLog(__CLASS__ .', '. 'Not authenticated (111)', 3);
            $responseData['message'] = 'Not authenticated (111)';
        }
        
        
        
        if( $authenticated ){
            $customer = null;
            if($customerId){
                $customer = new Customer($customerId);
            }
            //var_dump($_SERVER['REQUEST_METHOD']);
            if( $action == 'create' ){
                try{
                    $newOrderId = $this->createOrder($customer);
                    $responseData['data'] = $this->getOrder($customer, $newOrderId);
                    $responseData['success'] = true;
                    
                    // log request
                    $logMessage = 'Request URI: '. $_SERVER['REQUEST_URI'] . PHP_EOL;
                    $logMessage .= 'Request body: '. file_get_contents('php://input');;
                    $logMessage .= 'Response body: '. print_r($responseData['data'], true);
                    PrestaShopLogger::addLog($logMessage);
                    
                }
                catch (Exception $e){
                    PrestaShopLoggerCore::addLog(__CLASS__ .', '. $e->getMessage() . $e->getTraceAsString(), 3);
                    $responseData['message'] = $e->getMessage();
                    $responseData['success'] = false;
                }
            }
            elseif( $action == 'get' ){
                $id_order = intval($_GET['order_id']);
                try{
                    $responseData['data'] = $this->getOrder($customer, $id_order);
                    $responseData['success'] = true;
                }
                catch (Exception $e){
                    PrestaShopLoggerCore::addLog(__CLASS__ .', '. $e->getMessage() . $e->getTraceAsString(), 3);
                    $responseData['message'] = $e->getMessage();
                    $responseData['success'] = false;
                }
                
            }
        }
        
        echo json_encode($responseData);
    }
    
    protected function authenticateByWsKey()
    {
        if( empty($_GET['ws_key']) ){
            throw new Exception('Not authenticated (121)');
        }
        
        $wsKey = $_GET['ws_key'];
        
        if( (strlen($wsKey) != 32) || !preg_match('#^[A-Z0-9]*$#', $wsKey) ){
            throw new Exception('Not authenticated (122)');
        }
        
        $ws_key_found = Db::getInstance()->getRow('
            SELECT *
            FROM `'._DB_PREFIX_.'webservice_account`
            WHERE active = 1 AND `key` = "'. pSQL($wsKey) .'"
        ');
        
        if( !is_array($ws_key_found) || empty($ws_key_found['id_webservice_account']) ){
            throw new Exception('Not authenticated (123)');
        }
        
        return true;
    }
    
    protected function authenticateByAuthKey()
    {
        if( empty($_GET['auth_key']) ){
            throw new Exception('Not authenticated (111)');
        }
        
        $authKey = $_GET['auth_key'];
        
        if( (strlen($authKey) != 32) || !preg_match('#^[A-Z0-9]*$#', $authKey) ){
            throw new Exception('Not authenticated (112)');
        }
        
        $authedCustomer = Db::getInstance()->getRow('
            SELECT * FROM `'. _DB_PREFIX_ .'customer` WHERE order_create_key = "'. pSQL($authKey) .'"
        ');
        
        if( empty($authedCustomer) || empty($authedCustomer['id_customer'])){
            throw new Exception('Not authenticated (113)');
        }
        
        return (int)$authedCustomer['id_customer'];
    }
    
    /**
     * 
     * @param CustomerCore $customer
     * @throws Exception
     */
    protected function createOrder($customer)
    {
        $input = file_get_contents('php://input');
        
        $postData = json_decode($input, true);
        
        if( $_SERVER['REQUEST_METHOD'] != 'POST' ){
            throw new Exception('Invalid request');
        }
        
        if( !is_array($postData) || empty($postData['products']) ){
            throw new Exception('Empty request');
        }
        
        if( is_null($customer) ){
            if( !isset($postData['customer_id']) ){
                throw new Exception('Customer can not be found');
            }
            else{
                $customer = new Customer( intval($postData['customer_id']) );
                if( !$customer->id ){
                    throw new Exception('Customer not found');
                }
            }
        }
        
        $employee = null;
        // find staff if its ID sent. some apps will not send it
        if( isset($postData['employee_id']) ){
            $employee = new Employee(intval($postData['employee_id']));
            if( empty($employee->id) ){
                throw new Exception('Employee not found (210)');
            }
        }
        
        
        $paymentModuleName = 'bankwire';
        $orderStateId = intval( Configuration::get('PS_OS_BANKWIRE') );
        
        $languageDefaultId = intval(Configuration::get('PS_LANG_DEFAULT'));
        $currencyDefaultId = intval( Configuration::get('PS_CURRENCY_DEFAULT') );
        $carriers = Carrier::getCarriers($languageDefaultId, true, false);
        
        $carrier = $carriers[0];
        
        $customerAddresses = $customer->getAddresses($languageDefaultId);
        
        // Create new cart
        $cart = new Cart();
        $cart->id_shop_group = intval($this->context->shop->id_shop_group);
        $cart->id_shop = intval($this->context->shop->id);
        $cart->id_customer = intval($customer->id);
        $cart->id_carrier = intval($carrier['id_carrier']);
        $cart->id_address_delivery = $customerAddresses[0]['id_address'];
        $cart->id_address_invoice = $customerAddresses[0]['id_address'];
        $cart->id_currency = $currencyDefaultId;
        $cart->id_lang = intval($customer->id_lang);
        $cart->secure_key = $customer->secure_key;
        
        // Save new cart
        $cart->add();
        
        foreach($postData['products'] as $requestProductData){
            
            $supplier_reference = null;
            $ean13 = null;
            /**
             * @var DbQueryCore $query
             */
            $query = new DbQuery();
            $query->select('p.id_product, pa.id_product_attribute, pa.supplier_reference')
                ->from('product', 'p')
                ->innerJoin('product_shop', 'ps', 'ps.id_product = p.id_product')
                ->innerJoin('product_attribute', 'pa', 'pa.id_product = p.id_product')
                ->where('ps.id_shop = '. intval($this->context->shop->id) )
            ;
            
            if(!empty($requestProductData['supplier_reference'])){
                $supplier_reference = trim($requestProductData['supplier_reference']);
                $supplier_reference = preg_replace('#[^a-z0-9\-\s_&]#i', '', $supplier_reference);
            }
            if( !empty($requestProductData['ean13']) ){
                $ean13 = trim( $requestProductData['ean13'] );
                $ean13 = preg_replace('#[^0-9]#', '', $ean13);
            }
            
            if( !empty($supplier_reference) ){
                $query->where('pa.supplier_reference LIKE "'. pSQL($supplier_reference) .'"');
            }
            elseif( !empty($ean13) ){
                $query->where('pa.ean13 LIKE "'. pSQL($ean13) .'"');
            }
            else{
                continue;
            }

            $productData = Db::getInstance()->getRow($query);
            
            if( is_array($productData) && !empty($productData['id_product']) ){
                $cart->updateQty(intval($requestProductData['quantity']), $productData['id_product'], 
                    $productData['id_product_attribute']);
            }
        }
        
        if(!$cart->nbProducts()){
            throw new Exception('Order can not be created (202)');
        }
        
        $paymentModule = Module::getInstanceByName($paymentModuleName);
        
        Context::getContext()->currency = new Currency((int)$cart->id_currency);
        Context::getContext()->customer = new Customer((int)$cart->id_customer);
        
        $orderMessage = 'Kundenbestellung über API';
        if( !empty($employee->id) ){
            $orderMessage .= ' durch Mitarbeiter '. $employee->firstname .' '. $employee->lastname;
        }
        if( !empty($postData['note']) ){
            $orderMessage .= PHP_EOL . ' --------------- '. PHP_EOL . $postData['note'];
        }
        
        $paymentModule->validateOrder(
            (int)$cart->id, $orderStateId,
            $cart->getOrderTotal(true, Cart::BOTH), $paymentModule->displayName, 
            null, array(), null, false, $cart->secure_key
        );
        
        if( !$paymentModule->currentOrder ){
            throw new Exception('Order was not created (201)');
        }
        
        $order = new Order($paymentModule->currentOrder);
        
        if( !$order->id || !$order->getProductsCount() ){
            throw new Exception('Order was not created (206)');
        }
        
        // add private message to the order
        $id_customer_thread = CustomerThread::getIdCustomerThreadByEmailAndIdOrder($customer->email, $order->id);
        if (!$id_customer_thread) {
            $customer_thread = new CustomerThread();
            $customer_thread->id_contact = 0;
            $customer_thread->id_customer = (int)$order->id_customer;
            $customer_thread->id_shop = (int)$this->context->shop->id;
            $customer_thread->id_order = (int)$order->id;
            $customer_thread->id_lang = (int)$order->id_lang;
            $customer_thread->email = $customer->email;
            $customer_thread->status = 'open';
            $customer_thread->token = Tools::passwdGen(12);
            try {
                $customer_thread->add();
            }
            catch (Exception $e) {
                
            }
            
        } else {
            $customer_thread = new CustomerThread((int)$id_customer_thread);
        }
        
        if( Validate::isLoadedObject($customer_thread) ){
            $customer_message = new CustomerMessage();
            $customer_message->id_customer_thread = $customer_thread->id;
            $customer_message->id_employee = (!is_null($employee) ? $employee->id : 1);
            $customer_message->message = $orderMessage;
            $customer_message->private = 1;
    
            try {
                $customer_message->add();
            }
            catch (Exception $e) {
                // this is not critical
            }
        }
        // set ID of staff who created order
        if( !is_null($employee) ){
            $order->id_employee_add = $employee->id;
        }
        
        if( isset($postData['order_type_id']) && ( intval($postData['order_type_id']) > 0 ) ){
            $order->id_order_type = intval($postData['order_type_id']);
        }
        
        try {
            $order->update();
        } 
        catch (Exception $e) {
            // this is not critical
        }
        
        $orderDetailsId = array();
        foreach( $order->getProductsDetail() as $orderProductDetail ){
            $orderDetailsId[] = $orderProductDetail['id_order_detail'];
        }
        
        $orderInvoiceId = $order->addInvoice(false, self::INVOICE_TEMPLATE_ID, $orderDetailsId);
        
        $orderInvoice = new OrderInvoice($orderInvoiceId);
        $invoicePrintPath = 
            _PS_ROOT_DIR_ 
            . DIRECTORY_SEPARATOR . self::INVOICES_DIRECTORY
            . DIRECTORY_SEPARATOR . $orderInvoice->getInvoiceFileName()
        ;
        
        copy($orderInvoice->getInvoiceFilePath(), $invoicePrintPath);
        
        return $order->id;
    }

    protected function getOrder($customer, $id_order)
    {
        $order = new Order($id_order);
        
        if( empty($order->id) ){
            throw new Exception('Not found (301)');
        }
        
        if( !is_null($customer) && ($order->id_customer != $customer->id) ){
            throw new Exception('Not allowed (305)');
        }

        $orderData = array();
        $orderData['id'] = $order->id;
        $orderData['order_type_id'] = $order->id_order_type;
        $orderData['total_products_tax_excl'] = Tools::ps_round($order->getTotalProductsWithoutTaxes(), 6); 
        $orderData['total_products_tax_incl'] = Tools::ps_round($order->getTotalProductsWithTaxes(), 6);
        $orderData['total_shipping_tax_excl'] = Tools::ps_round($order->total_shipping_tax_excl, 6);
        $orderData['total_shipping_tax_incl'] = Tools::ps_round($order->total_shipping_tax_incl, 6);
        $orderData['total_discounts_tax_excl'] = Tools::ps_round($order->total_discounts_tax_excl, 6);
        $orderData['total_discounts_tax_incl'] = Tools::ps_round($order->total_discounts_tax_incl, 6);
        $orderData['total_order_tax_excl'] = Tools::ps_round($order->total_paid_tax_excl, 6);
        $orderData['total_order_tax_incl'] = Tools::ps_round($order->total_paid_tax_incl, 6);
        
        if( !empty($order->id_employee_add) ){
            $employee = new Employee($order->id_employee_add);
            if( !empty($employee->id) ){
                $orderData['employee_add_id'] = $employee->id;
                $orderData['employee_add_name'] = $employee->firstname .' '. $employee->lastname;
            }
        }
        
        $orderData['invoices'] = array();
        foreach( $order->getInvoicesCollection() as $orderInvoice ){
            if( ($orderInvoice->number > 0) && ($orderInvoice->template_id == self::INVOICE_TEMPLATE_ID) ){
                $orderData['invoices'][] = array(
                    'id' => $orderInvoice->id,
                    'number' => $orderInvoice->getInvoiceNumberFormatted($this->context->language->id, $order->id_shop),
                    'url' =>
                        rtrim($this->context->shop->getBaseURL(), '/')
                        . '/'. self::INVOICES_DIRECTORY
                        . '/'. $orderInvoice->getInvoiceFileName()
                );
            }
        }
        
        $orderData['products'] = array();
        foreach( $order->getProducts() as $orderDetail){
            $orderData['products'][] = array(
                'name' => $orderDetail['product_name'],
                'supplier_reference' => $orderDetail['product_supplier_reference'],
                'ean13' => $orderDetail['product_ean13'],
                'quantity' => $orderDetail['product_quantity'],
                'price_tax_excl' => Tools::ps_round($orderDetail['product_price'], 6),
                'total_tax_excl' => Tools::ps_round($orderDetail['total_price_tax_excl'], 6),
                'total_tax_incl' => Tools::ps_round($orderDetail['total_price_tax_incl'], 6)
            );
        }
        
        return $orderData;
    }
}