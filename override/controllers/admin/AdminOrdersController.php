<?php

require_once _PS_TOOL_DIR_ . 'php_excel/PHPExcel.php';
include_once _PS_MODULE_DIR_ .'ba_prestashop_invoice/ba_prestashop_invoice.php';
include_once _PS_MODULE_DIR_ .'ba_prestashop_invoice/includes/baorderinvoice.php';
include_once _PS_MODULE_DIR_ .'shopcomments/classes/ShopComment.php';

class AdminOrdersController extends AdminOrdersControllerCore
{
    function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'order';
        $this->className = 'Order';
        $this->lang = false;
        $this->addRowAction('view');
        $this->explicitSelect = true;
        $this->allow_export = true;
        $this->deleted = false;
        $this->context = Context::getContext();

        $this->_select = '
		a.id_currency, a.id_customer, a.current_state, a.status_date_due,
		a.id_order AS id_pdf,
		CONCAT(LEFT(c.`firstname`, 1), \'. \', c.`lastname`) AS `customer`, c.postcode AS `postcode`,
		osl.`name` AS `osname`, os.`color`,
		IF((SELECT so.id_order FROM `'._DB_PREFIX_.'orders` so WHERE so.id_customer = a.id_customer AND so.id_order < a.id_order LIMIT 1) > 0, 0, 1) as new,
		country_lang.name as cname,
		IF(a.valid, 1, 0) badge_success, a.current_state<>'.Configuration::get('PS_OS_CANCELED').' 
		and (select count(od.id_order_detail)>0 
		    from '._DB_PREFIX_.'order_detail od 
		    inner join '._DB_PREFIX_.'stock_available sa 
                on od.product_id=sa.id_product and sa.id_product_attribute=od.product_attribute_id 
            where 
		        od.shipped < (od.product_quantity-od.product_quantity_refunded-od.product_quantity_return) 
		        and sa.physical_quantity > 0 
		        and od.id_order=a.id_order
		) as may_be_shipped,
        c.address1 AS customer_address1, c.address2 AS customer_address2, c.city AS customer_city,
        c.ship_by_invoice,
		c.credit_limit AS customer_credit_limit,
        IFNULL((SELECT SUM(od.product_quantity-od.product_quantity_refunded-od.product_quantity_return) 
            FROM prs_order_detail od WHERE od.id_order=a.id_order), 0) AS tobe_shipped,
        IFNULL((SELECT SUM(od.shipped) 
            FROM prs_order_detail od WHERE od.id_order=a.id_order AND od.shipped >0), 0) AS already_shipped
        ';

        $this->_join = '
		LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = a.`id_customer`)
		INNER JOIN `'._DB_PREFIX_.'address` address ON address.id_address = a.id_address_delivery
		INNER JOIN `'._DB_PREFIX_.'country` country ON address.id_country = country.id_country
		INNER JOIN `'._DB_PREFIX_.'country_lang` country_lang ON (country.`id_country` = country_lang.`id_country` AND country_lang.`id_lang` = '.(int)$this->context->language->id.')
		LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = a.`current_state`)
		LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)$this->context->language->id.')
        ';

        // overdued invoices
        $overduedRemindersSubquery = '
            SELECT id_customer
            FROM '._DB_PREFIX_.'order_invoice oi
            INNER JOIN '. _DB_PREFIX_.'orders o ON o.id_order=oi.id_order
            INNER JOIN `'._DB_PREFIX_.'ba_prestashop_invoice` bai 
                ON oi.template_id = bai.id 
                    AND bai.payment_type != '. (BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP) .'
            WHERE oi.paid = 0
                AND oi.number > 0
                AND o.current_state != '. intval(Configuration::get('PS_OS_CANCELED')) .'
                AND (
                    (oi.due_date > 0 AND oi.due_date < NOW()) 
                    OR
                    (oi.reminder_state BETWEEN '. OrderInvoice::Reminder1Sent .' AND '. OrderInvoice::Reminder3Sent .')
                )
            GROUP BY id_customer
        ';
        $this->_select .= ', odi.id_customer AS has_overdued_invoices';
        $this->_join .= ' LEFT JOIN ('. $overduedRemindersSubquery .') odi ON odi.id_customer = a.id_customer ';
        // overdued invoices end
        
        // Customers that has Inkasso reminder state of the invoice
        $this->_select .= ', cst_ink.id_customer AS customer_inkasso';
        $this->_join .= '
    		LEFT JOIN (
    		    SELECT o.id_customer
    		    FROM '._DB_PREFIX_.'order_invoice oi
    		    LEFT JOIN '._DB_PREFIX_.'orders o ON o.id_order = oi.id_order
    		    WHERE oi.reminder_state = '. OrderInvoice::ReminderInkasso .'
    		        AND oi.paid = 0
    		    GROUP BY o.id_customer
    		) AS cst_ink ON cst_ink.id_customer = a.id_customer
        ';
        
        $this->_orderBy = 'id_order';
        $this->_orderWay = 'DESC';
        $this->_use_found_rows = true;

        $statuses = OrderState::getOrderStates((int)$this->context->language->id);
        foreach ($statuses as $status) {
            $this->statuses_array[$status['id_order_state']] = $status['name'];
        }
        
        $this->fields_list = array(
            'id_order' => array(
                'title' => $this->l('ID'),
                'align' => 'text-center',
                'class' => 'fixed-width-xs'
            ),
            'id_customer' => array(
                'title' => $this->l('Cust. ID'),
                'filter_key' => 'a!id_customer',
                'filter_type' => 'int',
            ),
            'reference' => array(
                'title' => $this->l('Reference')
            ),
            'may_be_shipped' => array(
                'title' => $this->l('May be shipped'),
                'align' => 'text-center',
                'callback' => 'showMayBeShipped',
                'type' => 'bool',
                'orderby' => false,
                //'search' => false,
                'remove_onclick' => true,
                'havingFilter' => true
            ),
            'ship_by_invoice' => array(
                'title' => $this->l('Ship by Invoice'),
                'align' => 'text-center',
                'type' => 'bool',
                //'tmpTableFilter' => true,
                'orderby' => false,
                'callback' => 'printShipByInvoice',
                //'filter_key' => 'c!ship_by_invoice'
            ),
            'customer' => array(
                'title' => $this->l('Customer'),
                'havingFilter' => true,
            ),
        );

        if (Configuration::get('PS_B2B_ENABLE')) {
            $this->fields_list = array_merge($this->fields_list, array(
                'company' => array(
                    'title' => $this->l('Company'),
                    'filter_key' => 'c!company'
                ),
            ));
        }

        $this->fields_list = array_merge($this->fields_list, array(
            'total_paid_tax_excl' => array(
                'title' => $this->l('Total'),
                'align' => 'text-right',
                'type' => 'price',
                'currency' => true,
                'callback' => 'setOrderCurrency',
                'badge_success' => true
            ),
            /*'payment' => array(
                'title' => $this->l('Payment')
            ),*/
            'tobe_shipped' => array(
                'title' => $this->l('Already shipped'),
                'callback' => 'listTobeShipped',
                'type' => 'select',
                'list' => array(
                    '0' => $this->l('No'),
                    '1' => $this->l('Yes')
                ),
                'filter_key' => 'already_shipped',
                'havingFilter' => true,
            ),
            'osname' => array(
                'title' => $this->l('Status'),
                'search' => false,
                'color' => 'color',
                //'list' => $this->statuses_array,
                //'filter_key' => 'os!id_order_state',
                //'filter_type' => 'int',
                //'order_key' => 'osname',
                'order_key' => 'a!status_date_due',
                'callback' => 'showOrderState'
            ),
            'date_add' => array(
                'title' => $this->l('Date'),
                'align' => 'text-right',
                'type' => 'datetime',
                'filter_key' => 'a!date_add'
            ),
        ));

        if (Country::isCurrentlyUsed('country', true)) {
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
			SELECT DISTINCT c.id_country, cl.`name`
			FROM `'._DB_PREFIX_.'orders` o
			'.Shop::addSqlAssociation('orders', 'o').'
			INNER JOIN `'._DB_PREFIX_.'address` a ON a.id_address = o.id_address_delivery
			INNER JOIN `'._DB_PREFIX_.'country` c ON a.id_country = c.id_country
			INNER JOIN `'._DB_PREFIX_.'country_lang` cl ON (c.`id_country` = cl.`id_country` AND cl.`id_lang` = '.(int)$this->context->language->id.')
			ORDER BY cl.name ASC');

            $country_array = array();
            foreach ($result as $row) {
                $country_array[$row['id_country']] = $row['name'];
            }

            $part1 = array_slice($this->fields_list, 0, 3);
            $part2 = array_slice($this->fields_list, 3);
            $part1['cname'] = array(
                'title' => $this->l('Country'),
                'type' => 'select',
                'list' => $country_array,
                'filter_key' => 'country!id_country',
                'filter_type' => 'multiint',
                'order_key' => 'cname',
                'multiple' => true,
                'class' => 'country_select',
                'width' => 100
            );
            $this->fields_list = array_merge($part1, $part2);
        }

        $this->shopLinkType = 'shop';
        $this->shopShareDatas = Shop::SHARE_ORDER;

        if (Tools::isSubmit('id_order')) {
            // Save context (in order to apply cart rule)
            $order = new Order((int)Tools::getValue('id_order'));
            $this->context->cart = new Cart($order->id_cart);
            $this->context->customer = new Customer($order->id_customer);
        }

        // add bulk actions
        $this->bulk_actions = array(
            'updateOrderStatus' => array('text' => $this->l('Change Order Status'), 'icon' => 'icon-refresh')
        );

        AdminController::__construct();
        
        $this->bulk_actions['orderdedProductsReport'] = array('text' => $this->l('Generate ordered products list'), 'icon' => 'icon-road', 
            'targetBlank'=>1);
        $this->bulk_actions['htmlShippingInfo'] = array('text' => $this->l('Export pdf shipping info'), 'icon' => 'icon-road');
        $this->bulk_actions['soldAndSalesStats'] = array(
            'text' => 'Sold and Sales statistics',
        );
        $this->bulk_actions['exportXls'] = array(
            'text' => $this->l('Export to Excel'),
            'icon' => 'icon-export',
        );

        // workaround for profiles that does not have 'edit' permissions, but have 'view' permissions 
        $actionTreatAsViewList = array('submitBulksoldAndSalesStatsorder', 'submitBulkexportXlsorder');
        foreach($actionTreatAsViewList as $actionTreatAsView){
            if( in_array($actionTreatAsView, array_keys($_GET)) && ($this->tabAccess['view'] == 1) && ($this->tabAccess['edit'] == '0')){
                $this->tabAccess['edit'] = '1';
            }
        }

        $this->fields_list['reference']['filter_key'] = 'a!reference';
        $this->fields_list['total_paid_tax_excl']['filter_key'] = 'a!total_paid_tax_excl';
        //$this->_select = ' distinct ';
        $this->_group = ' group by a.id_order';
        
        $postcodeStarts = array();
        for($i = 0; $i < 10; $i++){
            $postcodeStarts[] = $i;
        }
        $this->context->smarty->assign('postcode_options', $postcodeStarts);
        
        $orderTypesList = Db::getInstance()->executeS('
            SELECT id_order_type, `name`
            FROM `'._DB_PREFIX_.'order_type`
            ORDER BY `default` DESC, `name` ASC
        ');
        $orderTypes = array();
        foreach($orderTypesList as $orderType){
            $orderTypes[ $orderType['id_order_type'] ] = $orderType['name'];
        }
        
        $overduedFilterOptions = array(
            '0' => 'Show all',
            '1' => 'Hide red customers',
            '2' => 'Show only red customers'
        );
        
        $suppliersFilterOptions = array();
        foreach( Supplier::getSuppliers(false, $this->context->language->id, true) as $supplier ){
            $suppliersFilterOptions[ $supplier['id_supplier'] ] = $supplier['name']; 
        }

        $this->context->smarty->assign(array(
            'order_types' => $orderTypes, 
            'order_type_selected' => @$_POST['id_order_type'],
            'order_statuses' => $this->statuses_array,
            'order_statuses_selected' => @$_POST['id_order_statuses'],
            'overdued_filter_options' => $overduedFilterOptions,
            'overdued_filter_selected' => 0,
            'supplier_filter_options' => $suppliersFilterOptions,
            'supplier_filter_selected' => array()
        ));
    }
    
    public function showOrderState($value, $row)
    {
        $order_state_date_due = strtotime($row['status_date_due']);
        if( $order_state_date_due && ($order_state_date_due > 0) ){
            return $value .' ('. date('d.m.Y', $order_state_date_due) .')';
        }
        else{
            return $value;
        }
    }
    
    public function printShipByInvoice($value, $row)
    {
        return $value == '0' ? $this->l('No') : $this->l('Yes');
    }
    
    public function listTobeShipped($value, $row)
    {
        return intval($row['already_shipped']) .'/'. intval($row['tobe_shipped']);
    }
    
    public function renderForm()
    {
        $orderTypes = Db::getInstance()->executeS('
            SELECT id_order_type, `name`
            FROM `'._DB_PREFIX_.'order_type`
            ORDER BY `default` DESC, `name` ASC
        ');
        
        $this->context->smarty->assign(array(
            'order_types' => $orderTypes
        ));
        
        parent::renderForm();
    }
    
    
    public function processBulkExportXls()
    {
        if( !is_array($this->boxes) || empty($this->boxes)){
            Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
        }
        if (ob_get_level() && ob_get_length() > 0) {
            ob_clean();
        }
        
        $this->_where .= ' AND a.`id_order` IN ('. implode(',', $this->boxes) .')';
        
        $this->getList($this->context->language->id, null, null, 0, false);
        if (!count($this->_list)) {
            return;
        }
        
        $fields_list = array(
            'id_order' => 'Order ID',
            'date_add' => 'Date',
            'cname' => 'Country',
            'postcode' => 'Postal code',
            'customer_city' => 'City',
            'customer_address1' => 'Address 1',
            'customer_address2' => 'Address 2',
            'company' => 'Company',
            'customer' => 'Customer name',
            'total_paid_tax_excl' => 'Order total'
        );
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()
        ->setCreator($this->context->shop->name .' ('. $this->context->shop->domain .')')
        ->setLastModifiedBy($this->context->shop->name.' ('. $this->context->shop->domain .')')
        ->setTitle("Orders")
        ;
        
        $objPHPExcel->setActiveSheetIndex(0);
        $rowNumber = 0;
        $rowNumber++;
        $colCharNum = ord('A');
        foreach($fields_list as $fieldKey => $fieldTitle){
            $objPHPExcel
            ->getActiveSheet()
            ->setCellValue( (chr($colCharNum++).$rowNumber), $fieldTitle)
            ;
        }
        
        foreach($this->_list as $dbRec){
            $rowNumber++;
            $colCharNum = ord('A');
        
            foreach($fields_list as $fieldKey => $fieldTitle){
                $value = $dbRec[$fieldKey];
                if( $fieldKey == 'total_paid_tax_excl' ){
                    $value = number_format($value, 2, ',', '.');
                }
                if( $fieldKey == 'date_add' ){
                    $value = Tools::displayDate($value);
                }
                
                $objPHPExcel
                ->getActiveSheet()
                ->setCellValue( (chr($colCharNum++).$rowNumber), $value)
                ;
            }
        }
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Orders');
        
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$this->table.'_'.date('Y-m-d_His').'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
        
    }
    
    public function processBulkSoldAndSalesStats()
    {
        $categoriesCountable = array(12,13,20,34,35,36,37);
        $customersIgnore = array(31,39,192,270,364,452,800,842,833,830,829);
        $productSplRefWordIgnoreRegex = '#position|transport#i';
        
        $stats = array(
            'products_count' => 0,
            'total_paid' => 0,
            'total_paid_not_shipped' => 0,
            'products_shipped' => 0,
            'products_not_shipped' => 0,
            // 
            'products_not_counted' => 0,
            'products_not_counted_list' => array()
        );
        
        $this->_filter .= ' AND a.current_state != '. intval(Configuration::get('PS_OS_CANCELED'));
        
        $this->getList($this->context->language->id, null, null, 0, false);
        
        foreach($this->_list as $orderData){
            if( in_array( intval($orderData['id_customer']), $customersIgnore) ){
                continue;
            }
            
            $order = new Order($orderData['id_order']);
            $orderDetails = $order->getProductsDetail();

            foreach($orderDetails as $orderDetail){
                // ignore matched products completely
                if( preg_match($productSplRefWordIgnoreRegex, $orderDetail['product_supplier_reference']) ){
                    continue;
                }
                
                $productCategories = Product::getProductCategories($orderDetail['product_id']);
                $productCategories = array_filter($productCategories, function($val){
                    return intval($val);
                });
                
                // ignore products not in defined categories
                if( count( array_intersect($categoriesCountable, $productCategories) ) == 0 ){
                    $stats['products_not_counted'] += 
                        $orderDetail['product_quantity']
                        - $orderDetail['product_quantity_refunded']
                        - $orderDetail['product_quantity_return']
                        - $orderDetail['product_quantity_reinjected']
                    ;
                    $stats['products_not_counted_list'][] = $orderDetail['supplier_reference'];
                    continue;
                }
                $detailRealQuantity = $orderDetail['product_quantity']
                    - $orderDetail['product_quantity_refunded']
                    - $orderDetail['product_quantity_return']
                    - $orderDetail['product_quantity_reinjected'];
                $stats['products_count'] += $detailRealQuantity;
                
                $stats['total_paid'] += $orderDetail['unit_price_tax_excl'] * $detailRealQuantity;
                //$orderDetailsTotal += $orderDetail['unit_price_tax_excl'] * $detailRealQuantity;
                
                $stats['products_not_shipped'] += intval($orderDetail['product_quantity']-$orderDetail['shipped']);
                if( $orderDetail['shipped'] ){
                    $stats['products_shipped'] += intval($orderDetail['shipped']);
                }
                else{
                    $stats['total_paid_not_shipped'] += floatval($orderDetail['total_price_tax_excl']);
                }
            }
            //$stats['products_not_counted_list'][] = $orderData['id_order']. ' - '. $orderDetailsTotal;
        }
        
        $categoriesCountableNoteText = 'Categories counted: ';
        foreach($categoriesCountable as $categoryCountable){
            $category = new Category($categoryCountable, $this->context->language->id);
            
            $categoriesCountableNoteText .= $category->name .', ';
        }
        $categoriesCountableNoteText = trim($categoriesCountableNoteText, ', ');
        
        $customersIgnoreNoteText = 'Customer\'s orders ignored: ';
        foreach( $customersIgnore as $customerIgnore ){
            $customer = new Customer($customerIgnore);
            if( empty($customer->id) ){
                continue;
            }
            $customersIgnoreNoteText .= $customer->lastname .' '. $customer->firstname .', ';
        }
        $customersIgnoreNoteText = trim($customersIgnoreNoteText, ', ');
        
        $this->content = 
            '<div class="panel">'.
            '<h2>Sold dresses: '. $stats['products_count'] .
            '<br>Shipped dresses: '. $stats['products_shipped'] .
            '<br>Not shipped dresses: '. $stats['products_not_shipped'] .
            '<br>Sales Revenue for sold dresses: '. Tools::displayPrice($stats['total_paid']) .
            '<br>Sales Revenue for not shipped dresses: '. Tools::displayPrice($stats['total_paid_not_shipped'])
            .'</h2>'
            . '<p class="text-muted">"Cancelled" orders not counted</p>'
            . '<h4>Sold but not counted due to category: '. $stats['products_not_counted'] 
            . ' <a href="#" onclick="$(\'#productsNotCountedList\').show()">Show</a>'
            .'</h4>'

            . '<pre id="productsNotCountedList" style="display:none">'. implode("\n", $stats['products_not_counted_list']) .'</pre>'
            . '<p class="text-muted">'.$categoriesCountableNoteText
                .'<br>'
                .$customersIgnoreNoteText
            .'</p>'.
        '</div>' . $this->content;
    }
    
    public function renderView()
    {
        $order = new Order(Tools::getValue('id_order'));
        if (!Validate::isLoadedObject($order)) {
            $this->errors[] = Tools::displayError('The order cannot be found within your database.');
        }

        $customer = new Customer($order->id_customer);
        
        if( !EmployeeArea::isCustomerInEmployeeArea($this->context->employee->id, $customer->id) ){
            $this->errors[] = Tools::displayError('This customer is not within your area.');
            return;
        }
        
        $carrier = new Carrier($order->id_carrier);
        $products = $this->getProducts($order);
        $currency = new Currency((int)$order->id_currency);
        // Carrier module call
        $carrier_module_call = null;
        if ($carrier->is_module) {
            $module = Module::getInstanceByName($carrier->external_module_name);
            if (method_exists($module, 'displayInfoByCart')) {
                $carrier_module_call = call_user_func(array($module, 'displayInfoByCart'), $order->id_cart);
            }
        }

        // Retrieve addresses information
        $addressInvoice = new Address($order->id_address_invoice, $this->context->language->id);
        if (Validate::isLoadedObject($addressInvoice) && $addressInvoice->id_state) {
            $invoiceState = new State((int)$addressInvoice->id_state);
        }

        if ($order->id_address_invoice == $order->id_address_delivery) {
            $addressDelivery = $addressInvoice;
            if (isset($invoiceState)) {
                $deliveryState = $invoiceState;
            }
        } else {
            $addressDelivery = new Address($order->id_address_delivery, $this->context->language->id);
            if (Validate::isLoadedObject($addressDelivery) && $addressDelivery->id_state) {
                $deliveryState = new State((int)($addressDelivery->id_state));
            }
        }

        $this->toolbar_title = sprintf($this->l('Order #%1$d (%2$s) - %3$s %4$s'), $order->id, $order->reference, $customer->firstname, $customer->lastname);
        if (Shop::isFeatureActive()) {
            $shop = new Shop((int)$order->id_shop);
            $this->toolbar_title .= ' - '.sprintf($this->l('Shop: %s'), $shop->name);
        }

        // gets warehouses to ship products, if and only if advanced stock management is activated
        $warehouse_list = null;

        $order_details = $order->getOrderDetailList();
        foreach ($order_details as $order_detail) {
            $product = new Product($order_detail['product_id']);

            if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')
                && $product->advanced_stock_management) {
                $warehouses = Warehouse::getWarehousesByProductId($order_detail['product_id'], $order_detail['product_attribute_id']);
                foreach ($warehouses as $warehouse) {
                    if (!isset($warehouse_list[$warehouse['id_warehouse']])) {
                        $warehouse_list[$warehouse['id_warehouse']] = $warehouse;
                    }
                }
            }
        }

        $payment_methods = array();
        foreach (PaymentModule::getInstalledPaymentModules() as $payment) {
            $module = Module::getInstanceByName($payment['name']);
            if (Validate::isLoadedObject($module) && $module->active) {
                $payment_methods[] = $module->displayName;
            }
        }

        // display warning if there are products out of stock
        $display_out_of_stock_warning = false;
        $current_order_state = $order->getCurrentOrderState();
        if (Configuration::get('PS_STOCK_MANAGEMENT') && (!Validate::isLoadedObject($current_order_state) || ($current_order_state->delivery != 1 && $current_order_state->shipped != 1))) {
            $display_out_of_stock_warning = true;
        }

        // reading stock status/priority info
        if( $this->context->shop->domain == 'www.koehlert.com' ){
            $serviceUrl = 'https://www.vipdress.de/admin123/index_service.php/dbk_ext_shop_delivery/get_stock_status_koehlert/';
            $stockStatus = file_get_contents($serviceUrl.$order->id);
        }
        elseif( $this->context->shop->domain == 'nsweb.server' ){
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            $serviceUrl = 'http://nsweb.server/vipdress/admin123/index_service.php/dbk_ext_shop_delivery/get_stock_status_koehlert/';
            $stockStatus = file_get_contents($serviceUrl.$order->id,  false, stream_context_create($arrContextOptions));
        }
        else
        {
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            $serviceUrl = 'https://dmitri.wheel/vipdress.de1/admin123/index_service.php/dbk_ext_shop_delivery/get_stock_status_koehlert/';
            $stockStatus = file_get_contents($serviceUrl.$order->id,  false, stream_context_create($arrContextOptions));
        }
        
        $stockStatus = json_decode($stockStatus, true);
                
        // products current stock (from stock_available)
        foreach ($products as &$product) {
            // Get total customized quantity for current product
            $customized_product_quantity = 0;

            if (is_array($product['customizedDatas'])) {
                foreach ($product['customizedDatas'] as $customizationPerAddress) {
                    foreach ($customizationPerAddress as $customizationId => $customization) {
                        $customized_product_quantity += (int)$customization['quantity'];
                    }
                }
            }

            // stock status data from central store/vipdress
            if (isset($stockStatus[$product['product_supplier_reference']]))
            {
                $product['avForCur'] = $stockStatus[$product['product_supplier_reference']]['avForCur'];
                $product['dbkShopsQty'] = $stockStatus[$product['product_supplier_reference']]['dbkShopsQty'];
                if (isset($stockStatus[$product['product_supplier_reference']]['expDelivery']))
                {
                    $product['expDelivery'] = $stockStatus[$product['product_supplier_reference']]['expDelivery'];
                }
            }
            
            $product['customized_product_quantity'] = $customized_product_quantity;
            $product['current_stock'] = StockAvailable::getQuantityAvailableByProduct($product['product_id'], $product['product_attribute_id'], $product['id_shop']);
            $resume = OrderSlip::getProductSlipResume($product['id_order_detail']);
            $product['quantity_refundable'] = $product['product_quantity'] - $resume['product_quantity'];
            $product['amount_refundable'] = $product['total_price_tax_excl'] - $resume['amount_tax_excl'];
            $product['amount_refundable_tax_incl'] = $product['total_price_tax_incl'] - $resume['amount_tax_incl'];
            $product['amount_refund'] = Tools::displayPrice($resume['amount_tax_incl'], $currency);
            $product['refund_history'] = OrderSlip::getProductSlipDetail($product['id_order_detail']);
            $product['return_history'] = OrderReturn::getProductReturnDetail($product['id_order_detail']);

            // if the current stock requires a warning
            if ($product['current_stock'] == 0 && $display_out_of_stock_warning) {
                $this->displayWarning($this->l('This product is out of stock: ').' '.$product['product_name']);
            }
            if ($product['id_warehouse'] != 0) {
                $warehouse = new Warehouse((int)$product['id_warehouse']);
                $product['warehouse_name'] = $warehouse->name;
                $warehouse_location = WarehouseProductLocation::getProductLocation($product['product_id'], $product['product_attribute_id'], $product['id_warehouse']);
                if (!empty($warehouse_location)) {
                    $product['warehouse_location'] = $warehouse_location;
                } else {
                    $product['warehouse_location'] = false;
                }
            } else {
                $product['warehouse_name'] = '--';
                $product['warehouse_location'] = false;
            }
        }

        $gender = new Gender((int)$customer->id_gender, $this->context->language->id);

        $history = $order->getHistory($this->context->language->id);

        foreach ($history as &$order_state) {
            $order_state['text-color'] = Tools::getBrightness($order_state['color']) < 128 ? 'white' : 'black';
        }
        
        $customerComments = ShopComment::getCustomerComments($customer->id, 1);
        
        $orderPackagesQuery = '
            SELECT op.*, CONCAT_WS(" ", e.lastname, e.firstname) AS employee_name
            FROM `'._DB_PREFIX_.'order_package` op
            INNER JOIN `'._DB_PREFIX_.'employee` e ON e.id_employee = op.id_employee
            WHERE
                op.`id_order` = '. intval($order->id) .'
            ORDER BY `date_add` ASC
        ';
        $orderPackages = Db::getInstance()->executeS($orderPackagesQuery);
        
        $suggestedInvoiceTemplates = InvoiceSuggester::guessTemplates($customer, $order);
        $suggestedInvoiceTemplatesSimple = array_map(function($subarr){
            return $subarr['template_id'];
        }, $suggestedInvoiceTemplates);
        
        // Smarty assign
        require_once _PS_MODULE_DIR_.'ba_prestashop_invoice/includes/BaTemplateCategory.php';
        
        $ignoreNoInvoiceComment = array();
        if( $order->ignore_no_invoice_note ){
            $ignoreNoInvoiceComment = ShopComment::getOrderIgnoreNoInvoiceComment($order->id);
        }
        
        $this->tpl_view_vars = array(
            'ignoreNoInvoiceComment' => $ignoreNoInvoiceComment,
            'invoiceTemplates' => BaTemplateCategory::getTemplatesByCountry($customer->id_country),
            'suggestedInvoiceTemplates' => $suggestedInvoiceTemplatesSimple,
            'order' => $order,
            'cart' => new Cart($order->id_cart),
            'customer' => $customer,
            'gender' => $gender,
            'customer_addresses' => $customer->getAddresses($this->context->language->id),
            'addresses' => array(
                'delivery' => $addressDelivery,
                'deliveryState' => isset($deliveryState) ? $deliveryState : null,
                'invoice' => $addressInvoice,
                'invoiceState' => isset($invoiceState) ? $invoiceState : null
            ),
            'customerStats' => $customer->getStats(),
            'products' => $products,
            'discounts' => $order->getCartRules(),
            'orders_total_paid_tax_incl' => $order->getOrdersTotalPaid(), // Get the sum of total_paid_tax_incl of the order with similar reference
            'total_paid' => $order->getTotalPaid(),
            'returns' => OrderReturn::getOrdersReturn($order->id_customer, $order->id),
            'customer_thread_message' => CustomerThread::getCustomerMessages($order->id_customer, null, $order->id),
            'orderMessages' => OrderMessage::getOrderMessages($order->id_lang),
            'messages' => Message::getMessagesByOrderId($order->id, true),
            'carrier' => new Carrier($order->id_carrier),
            'history' => $history,
            'states' => OrderState::getOrderStates($this->context->language->id),
            'paymentStatuses' => OrderPaymentStatus::getStatuses(),
            'warehouse_list' => $warehouse_list,
            'sources' => ConnectionsSource::getOrderSources($order->id),
            'currentState' => $order->getCurrentOrderState(),
            'currency' => new Currency($order->id_currency),
            'currencies' => Currency::getCurrenciesByIdShop($order->id_shop),
            'previousOrder' => $order->getPreviousOrderId(),
            'nextOrder' => $order->getNextOrderId(),
            'current_index' => self::$currentIndex,
            'carrierModuleCall' => $carrier_module_call,
            'iso_code_lang' => $this->context->language->iso_code,
            'id_lang' => $this->context->language->id,
            'can_edit' => ($this->tabAccess['edit'] == 1),
            'current_id_lang' => $this->context->language->id,
            'invoices_collection' => $order->getInvoicesCollection(),
            'not_paid_invoices_collection' => $order->getNotPaidInvoicesCollection(),
            'payment_methods' => $payment_methods,
            'invoice_management_active' => Configuration::get('PS_INVOICE', null, null, $order->id_shop),
            'display_warehouse' => (int)Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT'),
            'HOOK_CONTENT_ORDER' => Hook::exec('displayAdminOrderContentOrder', array(
                'order' => $order,
                'products' => $products,
                'customer' => $customer)
            ),
            'HOOK_CONTENT_SHIP' => Hook::exec('displayAdminOrderContentShip', array(
                'order' => $order,
                'products' => $products,
                'customer' => $customer)
            ),
            'HOOK_TAB_ORDER' => Hook::exec('displayAdminOrderTabOrder', array(
                'order' => $order,
                'products' => $products,
                'customer' => $customer)
            ),
            'HOOK_TAB_SHIP' => Hook::exec('displayAdminOrderTabShip', array(
                'order' => $order,
                'products' => $products,
                'customer' => $customer)
            ),
            'customer_comments' => $customerComments,
            'order_packages' => $orderPackages,
            'customer_credit_limit_controller' => $this->context->link->getAdminLink('AdminCustomerCreditLimitHistory'),
            'customer_invoices_unpaid_amount' => $customer->getInvoicesUnpaidTotalAmount(false),
            'customer_overdue_invoices_unpaid_amount' => $customer->getInvoicesUnpaidTotalAmount(true),
            'customer_credit_limit_history_list' => $customer->getCreditLimitHistoryList(),
            'customer_has_inkasso_invoice' => $customer->hasInkassoInvoice()
        );

        return AdminController::renderView();
    }
    
    public function ajaxProcessCheckCustomerCreditLimit()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'credit_limit' => 0,
            'credit_limit_exceeded' => null
        );
        
        if( is_null($this->object) ){
            $this->loadObject();
        }
        
        $productIds = array();
        $orderPackageId = intval($_POST['id_order_package']);
        
        if($orderPackageId > 0){
            // get details from package list
            $packageDetails = Db::getInstance()->executeS('
                    SELECT id_order_detail
                    FROM `'._DB_PREFIX_.'order_package_detail`
                    WHERE id_order_package = '. $orderPackageId .'
                ');
            if( !is_array($packageDetails) || !count($packageDetails) ){
                $this->errors[] = 'Package list does not contain details';
                return;
            }
        
            foreach($packageDetails as $packageDetail){
                $productIds[] = $packageDetail['id_order_detail'];
            }
        }
        else{
            // prepare values from manual details select
            $productIds = explode(',', $_REQUEST['product_ids']);
        
        }
        
        array_walk($productIds, function (&$value){ $value = intval($value); });
        $templateId = $_REQUEST['template_type']==1?intval($_REQUEST['invoice_template_id']):intval($_REQUEST['delivery_template_id']);
        try{
            $invoiceSumToPay = $this->object->addInvoice(intval($_REQUEST['template_type'])==2, $templateId, $productIds, $_POST['shipped_products_only'], true);
        }
        catch(Exception $e){
            //$this->errors[] = $e->getMessage();
            $responseData['success'] = false;
            $responseData['message'] = $e->getMessage();
        }
        
        $customer = new Customer( $this->object->id_customer );
        
        $customerInvoicesUnpaidTotalAmount = $customer->getInvoicesUnpaidTotalAmount();
        
        $responseData['credit_limit'] = $customer->credit_limit;

        if( ($customerInvoicesUnpaidTotalAmount + $invoiceSumToPay) > $customer->credit_limit ){
            $responseData['credit_limit_exceeded'] = true;
        }
        else{
            $responseData['credit_limit_exceeded'] = false;
        }
        
        echo json_encode($responseData);die;
    }
    
    function postProcess()
    {
        // process additional actions
        if (isset($_REQUEST['submitResetorder']))
        {
            unset($_REQUEST['orders_search']);
        }
        
        // If id_order is sent, we instanciate a new Order object
        if (Tools::isSubmit('id_order') && Tools::getValue('id_order') > 0) {
            $order = new Order(Tools::getValue('id_order'));
            if (!Validate::isLoadedObject($order)) {
                $this->errors[] = Tools::displayError('The order cannot be found within your database.');
            }
            ShopUrl::cacheMainDomainForShop((int)$order->id_shop);
        }
        
        if (Tools::isSubmit('submitBulkorderdedProductsReportorder'))
        {
            $orderIds = Tools::getValue('orderBox', []);
            if (count($orderIds))
            {
                array_walk($orderIds, function(&$item, $key){ $item = intval($item); });
                $products = Db::getInstance()->executeS('select id_image, sum(product_quantity) as quantity, product_name, '
                        . 'product_supplier_reference from ' . _DB_PREFIX_ . 'order_detail od left join ' . _DB_PREFIX_ . 'image_shop i on '
                        . 'od.product_id=i.id_product and od.id_shop=i.id_shop and cover=1 where id_order in (' . implode(',', $orderIds) .
                        ') group by product_id, product_attribute_id order by product_supplier_reference');
                $link = $this->context->link;
                array_walk($products, function(&$item, $key) use($link)
                {
                    $item['imageLink'] = $link->getImageLink($item['product_name'], $item['id_image'], 'cart_default');
                    $item['size'] = trim(substr($item['product_name'], strrpos($item['product_name'], ':')+1));
                });
            }
            else
            {
                $products = [];
            }
            $this->context->smarty->assign('products', $products);
            echo $this->createTemplate('supplier_order.tpl')->fetch();
            exit;
        }
        elseif (Tools::isSubmit('submitBulkhtmlShippingInfoorder'))
        {
            $orderIds = Tools::getValue('orderBox', []);
            if (count($orderIds))
            {
                array_walk($orderIds, function(&$item, $key){ $item = intval($item); });
                ShippingExporter::exportPdfInfo($orderIds);
            }
            else
            {
                echo Tools::displayError('No orders selected');
            }
            exit;
        }
        elseif (Tools::isSubmit('submitAddInvoice'))
        {
            $productIds = array();
            $orderPackageId = intval($_POST['id_order_package']);
            
            if($orderPackageId > 0){
                // get details from package list
                $packageDetails = Db::getInstance()->executeS('
                    SELECT id_order_detail
                    FROM `'._DB_PREFIX_.'order_package_detail`
                    WHERE id_order_package = '. $orderPackageId .'
                ');
                if( !is_array($packageDetails) || !count($packageDetails) ){
                    $this->errors[] = 'Package list does not contain details';
                    return;
                }
                
                foreach($packageDetails as $packageDetail){
                    $productIds[] = $packageDetail['id_order_detail'];
                }
            }
            else{
                // prepare values from manual details select
                $productIds = explode(',', $_REQUEST['product_ids']);
                
            }
            
            array_walk($productIds, function (&$value){ $value = intval($value); });
            $templateId = $_REQUEST['template_type']==1?intval($_REQUEST['invoice_template_id']):intval($_REQUEST['delivery_template_id']);
            $orderInvoiceId = null;
            try{
                $orderInvoiceId = $order->addInvoice(intval($_REQUEST['template_type'])==2, $templateId, $productIds, intval($_REQUEST['shipped_products_only']));
            }
            catch(Exception $e){
                $this->errors[] = $e->getMessage();
                return;
            }
            
            $printNow = (int)Tools::getValue('print_now', 0);
            if($printNow){
                $orderInvoice = new OrderInvoice($orderInvoiceId);
                $printInvoiceFilePath = INVOICES_PRINT_FOLDER . $orderInvoice->getInvoiceFileName();
                copy( $orderInvoice->getInvoiceFilePath(), $printInvoiceFilePath );
            }
            
            Tools::redirectAdmin(self::$currentIndex.'&id_order='.$order->id.'&vieworder&conf=4&token='.$this->token.'#documents');
        }
        elseif (Tools::isSubmit('submitSetInvoiceText'))
        {
            $order->invoice_txt = trim(Tools::getValue('invoice_txt'));
            $order->save();
            Tools::redirectAdmin(self::$currentIndex.'&id_order='.$order->id.'&vieworder&conf=4&token='.$this->token.'#documents');
        }
        elseif (Tools::isSubmit('submitCancelOrderPackage'))
        {
            $orderPackage = new OrderPackage(intval($_POST['order_package_id']));
            if (Validate::isLoadedObject($orderPackage))
            {
                $orderPackage->cancelled = 1;
                $orderPackage->update();
                if (empty($_POST['just_mark']))
                {
                    // change shipped quantity
                    $opDetails = $orderPackage->getGluedDetailsList();
                    foreach ($opDetails as $opDetail)
                    {
                        $orderDetail = new OrderDetail($opDetail['id_order_detail']);
                        if (Validate::isLoadedObject($orderDetail))
                        {
                            $orderDetail->decreaseShippedQty($this->context->employee->id, $opDetail['quantity']);
                        }
                    }
                }
            }
            Tools::redirectAdmin(self::$currentIndex.'&id_order='.$order->id.'&vieworder&conf=4&token='.$this->token.'#documents');
        }
        elseif(Tools::isSubmit('submitDeleteInvoice'))
        {
            if (strtolower($this->context->cookie->email) == 'info@vipdress.de') {
                $orderInvoice = new OrderInvoice(intval($_REQUEST['order_invoice_id']));
                $orderInvoice->delete();
                Tools::redirectAdmin(self::$currentIndex.'&id_order='.$_REQUEST['id_order'].'&vieworder&conf=4&token='.$this->token.'#documents');
            } else {
                $this->errors[] = Tools::displayError('You do not have permission to delete this invoice.');
                // Tools::redirectAdmin(self::$currentIndex.'&id_order='.$_REQUEST['id_order'].'&vieworder&conf=4&token='.$this->token.'#documents');
                AdminController::postProcess();
                return;
            }
        }
        elseif(Tools::isSubmit('submitDeleteSlip'))
        {
            $orderSlip = new OrderSlip(intval($_REQUEST['order_slip_id']));
            $orderSlip->delete();
            Tools::redirectAdmin(self::$currentIndex.'&id_order='.$_REQUEST['id_order'].'&vieworder&conf=4&token='.$this->token.'#documents');
        }
        elseif (Tools::isSubmit('submitDeleteVoucher') && isset($order))
        {
            if ($this->tabAccess['edit'] === '1')
            {
                $order_cart_rule = new OrderCartRule(Tools::getValue('id_order_cart_rule'));
                if (Validate::isLoadedObject($order_cart_rule) && $order_cart_rule->id_order == $order->id)
                {
                    if ($order_cart_rule->id_order_invoice)
                    {
                        $order_invoice = new OrderInvoice($order_cart_rule->id_order_invoice);
                        if (Validate::isLoadedObject($order_invoice))
                        {
                            // due we added delete of order invoices, order invoice may not exist, so we don't generate exception
                            // Update amounts of Order Invoice
                            $order_invoice->total_discount_tax_excl -= $order_cart_rule->value_tax_excl;
                            $order_invoice->total_discount_tax_incl -= $order_cart_rule->value;

                            $order_invoice->total_paid_tax_excl += $order_cart_rule->value_tax_excl;
                            $order_invoice->total_paid_tax_incl += $order_cart_rule->value;

                            // Update Order Invoice
                            $order_invoice->update();
                        }
                    }

                    // Update amounts of order
                    $order->total_discounts -= $order_cart_rule->value;
                    $order->total_discounts_tax_incl -= $order_cart_rule->value;
                    $order->total_discounts_tax_excl -= $order_cart_rule->value_tax_excl;

                    $order->total_paid += $order_cart_rule->value;
                    $order->total_paid_tax_incl += $order_cart_rule->value;
                    $order->total_paid_tax_excl += $order_cart_rule->value_tax_excl;

                    // Delete Order Cart Rule and update Order
                    $order_cart_rule->delete();
                    $order->update();
                    Tools::redirectAdmin(self::$currentIndex . '&id_order=' . $order->id . '&vieworder&conf=4&token=' . $this->token);
                }
                else
                {
                    $this->errors[] = Tools::displayError('You cannot edit this cart rule.');
                }
            }
            else
            {
                $this->errors[] = Tools::displayError('You do not have permission to edit this.');
            }
            AdminController::postProcess();
            return;
        }
        /* Cancel product from order */
        elseif (Tools::isSubmit('cancelProduct') && isset($order))
        {
            if ($this->tabAccess['delete'] === '1')
            {
                if (!Tools::isSubmit('id_order_detail') && !Tools::isSubmit('id_customization'))
                {
                    $this->errors[] = Tools::displayError('You must select a product.');
                }
                elseif (!Tools::isSubmit('cancelQuantity') && !Tools::isSubmit('cancelCustomizationQuantity'))
                {
                    $this->errors[] = Tools::displayError('You must enter a quantity.');
                }
                else
                {
                    $productList = Tools::getValue('id_order_detail');
                    if ($productList)
                    {
                        $productList = array_map('intval', $productList);
                    }

                    $customizationList = Tools::getValue('id_customization');
                    if ($customizationList)
                    {
                        $customizationList = array_map('intval', $customizationList);
                    }

                    $qtyList = Tools::getValue('cancelQuantity');
                    if ($qtyList)
                    {
                        $qtyList = array_map('intval', $qtyList);
                    }

                    $customizationQtyList = Tools::getValue('cancelCustomizationQuantity');
                    if ($customizationQtyList)
                    {
                        $customizationQtyList = array_map('intval', $customizationQtyList);
                    }

                    $full_product_list = $productList;
                    $full_quantity_list = $qtyList;

                    if ($customizationList)
                    {
                        foreach ($customizationList as $key => $id_order_detail)
                        {
                            $full_product_list[(int) $id_order_detail] = $id_order_detail;
                            if (isset($customizationQtyList[$key]))
                            {
                                $full_quantity_list[(int) $id_order_detail] += $customizationQtyList[$key];
                            }
                        }
                    }

                    if ($productList || $customizationList)
                    {
                        if ($productList)
                        {
                            $id_cart = Cart::getCartIdByOrderId($order->id);
                            $customization_quantities = Customization::countQuantityByCart($id_cart);

                            foreach ($productList as $key => $id_order_detail)
                            {
                                $qtyCancelProduct = abs($qtyList[$key]);
                                if (!$qtyCancelProduct)
                                {
                                    $this->errors[] = Tools::displayError('No quantity has been selected for this product.');
                                }

                                $order_detail = new OrderDetail($id_order_detail);
                                $customization_quantity = 0;
                                if (array_key_exists($order_detail->product_id, $customization_quantities) && array_key_exists($order_detail->product_attribute_id, $customization_quantities[$order_detail->product_id]))
                                {
                                    $customization_quantity = (int) $customization_quantities[$order_detail->product_id][$order_detail->product_attribute_id];
                                }

                                if (($order_detail->product_quantity - $customization_quantity - $order_detail->product_quantity_refunded - $order_detail->product_quantity_return) < $qtyCancelProduct)
                                {
                                    $this->errors[] = Tools::displayError('An invalid quantity was selected for this product.');
                                }
                            }
                        }
                        if ($customizationList)
                        {
                            $customization_quantities = Customization::retrieveQuantitiesFromIds(array_keys($customizationList));

                            foreach ($customizationList as $id_customization => $id_order_detail)
                            {
                                $qtyCancelProduct = abs($customizationQtyList[$id_customization]);
                                $customization_quantity = $customization_quantities[$id_customization];

                                if (!$qtyCancelProduct)
                                {
                                    $this->errors[] = Tools::displayError('No quantity has been selected for this product.');
                                }

                                if ($qtyCancelProduct > ($customization_quantity['quantity'] - ($customization_quantity['quantity_refunded'] + $customization_quantity['quantity_returned'])))
                                {
                                    $this->errors[] = Tools::displayError('An invalid quantity was selected for this product.');
                                }
                            }
                        }

                        if (!count($this->errors) && $productList)
                        {
                            $ignoreVoucher = false;
                            if ((int) Tools::getValue('refund_total_voucher_off') == 0)
                            {
                                $ignoreVoucher = true;
                            }
                            // Generate credit slip
                            if (Tools::isSubmit('generateCreditSlip') && !count($this->errors))
                            {
                                $product_list = array();
                                $amount = $order_detail->unit_price_tax_incl * $full_quantity_list[$id_order_detail];

                                $totalReturnAmount = 0;
                                $choosen = false;
                                if ((int) Tools::getValue('refund_total_voucher_off') == 2)
                                {
                                    $choosen = true;
                                    $totalReturnAmount = (float) Tools::getValue('refund_total_voucher_choose');
                                    $amount = $totalReturnAmount/count($productList);
                                }
                                foreach ($productList as $key => $id_order_detail)
                                {
                                    $order_detail = new OrderDetail((int) $id_order_detail);
                                    if ((int) Tools::getValue('refund_total_voucher_off') == 1)
                                    {
                                        $voucherPartTe = $order->total_discounts_tax_excl*$order_detail->unit_price_tax_excl*$qtyList[$key]
                                                /$order->total_paid_tax_excl;
                                        $voucherPartTi = $order->total_discounts_tax_incl*$order_detail->unit_price_tax_incl*$qtyList[$key]
                                                /$order->total_paid_tax_incl;
                                        $amount = Tools::ps_round($order_detail->unit_price_tax_incl * $full_quantity_list[$id_order_detail] - $voucherPartTi, 2);
                                        $unitPrice = $order_detail->unit_price_tax_excl - $order->total_discounts_tax_excl*$order_detail->unit_price_tax_excl/
                                                $order->total_products;
                                        $returnVoucherTotal += $voucherPartTe;
                                    }
                                    elseif(!$choosen)
                                    {
                                        $amount = $order_detail->unit_price_tax_incl * $full_quantity_list[$id_order_detail];
                                    }
                                    
                                    $product_list[$id_order_detail] = array(
                                        'id_order_detail' => $id_order_detail,
                                        'quantity' => $qtyList[$key],
                                        'unit_price' => isset($unitPrice)? $unitPrice : $order_detail->unit_price_tax_excl,
                                        'amount' => $amount,
                                    );
                                    if(!$choosen)
                                    {
                                        $totalReturnAmount += $amount;
                                    }
                                }
                                
                                $shipping = Tools::isSubmit('shippingBack') ? null : false;

                                if (!OrderSlip::create($order, $product_list, $shipping, $totalReturnAmount, $choosen))
                                {
                                    $this->errors[] = Tools::displayError('A credit slip cannot be generated. ');
                                }
                                else
                                {
                                    Hook::exec('actionOrderSlipAdd', array('order' => $order, 'productList' => $full_product_list, 'qtyList' => $full_quantity_list), null, false, true, false, $order->id_shop);
                                }
                            }
                            foreach ($productList as $key => $id_order_detail)
                            {
                                $qty_cancel_product = abs($qtyList[$key]);
                                $order_detail = new OrderDetail((int) ($id_order_detail));

                                if (!$order->hasBeenDelivered() || ($order->hasBeenDelivered() && Tools::isSubmit('reinjectQuantities')) && $qty_cancel_product > 0)
                                {
                                    $this->reinjectQuantity($order_detail, $qty_cancel_product);
                                }

                                // Delete product
                                $order_detail = new OrderDetail((int) $id_order_detail);
                                if (!$order->deleteProduct($order, $order_detail, $qty_cancel_product, $ignoreVoucher))
                                {
                                    $this->errors[] = Tools::displayError('An error occurred while attempting to delete the product.') . ' <span class="bold">' . $order_detail->product_name . '</span>';
                                }

                                // Update weight SUM
                                $order_carrier = new OrderCarrier((int) $order->getIdOrderCarrier());
                                if (Validate::isLoadedObject($order_carrier))
                                {
                                    $order_carrier->weight = (float) $order->getTotalWeight();
                                    if ($order_carrier->update())
                                    {
                                        $order->weight = sprintf("%.3f " . Configuration::get('PS_WEIGHT_UNIT'), $order_carrier->weight);
                                    }
                                }

                                if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') && StockAvailable::dependsOnStock($order_detail->product_id))
                                {
                                    StockAvailable::synchronize($order_detail->product_id);
                                }
                                Hook::exec('actionProductCancel', array('cancelQty'=>$qty_cancel_product, 'sku'=>$order_detail->product_supplier_reference,
                                    'order' => $order, 'id_order_detail' => (int) $id_order_detail), null, false, true, false, $order->id_shop);
                            }
                        }
                        if (!count($this->errors) && $customizationList)
                        {
                            foreach ($customizationList as $id_customization => $id_order_detail)
                            {
                                $order_detail = new OrderDetail((int) ($id_order_detail));
                                $qtyCancelProduct = abs($customizationQtyList[$id_customization]);
                                if (!$order->deleteCustomization($id_customization, $qtyCancelProduct, $order_detail))
                                {
                                    $this->errors[] = Tools::displayError('An error occurred while attempting to delete product customization.') . ' ' . $id_customization;
                                }
                            }
                        }
                        // E-mail params
                        if ((Tools::isSubmit('generateCreditSlip') || Tools::isSubmit('generateDiscount')) && !count($this->errors))
                        {
                            $customer = new Customer((int) ($order->id_customer));
                            $params['{lastname}'] = $customer->lastname;
                            $params['{firstname}'] = $customer->firstname;
                            $params['{id_order}'] = $order->id;
                            $params['{order_name}'] = $order->getUniqReference();
                            @Mail::Send((int) $order->id_lang, 'credit_slip', Mail::l('New credit slip regarding your order', 
                                    (int) $order->id_lang), $params, $customer->email, $customer->firstname . ' ' . $customer->lastname, 
                                    null, null, null, null, _PS_MAIL_DIR_, true, (int) $order->id_shop);
                        }

                        // Generate voucher
                        if (Tools::isSubmit('generateDiscount') && !count($this->errors))
                        {
                            $cartrule = new CartRule();
                            $language_ids = Language::getIDs((bool) $order);
                            $cartrule->description = sprintf($this->l('Credit card slip for order #%d'), $order->id);
                            foreach ($language_ids as $id_lang)
                            {
                                // Define a temporary name
                                $cartrule->name[$id_lang] = 'V0C' . (int) ($order->id_customer) . 'O' . (int) ($order->id);
                            }
                            // Define a temporary code
                            $cartrule->code = 'V0C' . (int) ($order->id_customer) . 'O' . (int) ($order->id);

                            $cartrule->quantity = 1;
                            $cartrule->quantity_per_user = 1;
                            // Specific to the customer
                            $cartrule->id_customer = $order->id_customer;
                            $now = time();
                            $cartrule->date_from = date('Y-m-d H:i:s', $now);
                            $cartrule->date_to = date('Y-m-d H:i:s', $now + (3600 * 24 * 365.25)); // 1 year 
                            $cartrule->active = 1;

                            $products = $order->getProducts(false, $full_product_list, $full_quantity_list);

                            $total = 0;
                            foreach ($products as $product)
                            {
                                $total += $product['unit_price_tax_incl'] * $product['product_quantity'];
                            }

                            if (Tools::isSubmit('shippingBack'))
                            {
                                $total += $order->total_shipping;
                            }

                            if ((int) Tools::getValue('refund_total_voucher_off') == 1)
                            {
                                $total -= (float) Tools::getValue('order_discount_price');
                            }
                            elseif ((int) Tools::getValue('refund_total_voucher_off') == 2)
                            {
                                $total = (float) Tools::getValue('refund_total_voucher_choose');
                            }

                            $cartrule->reduction_amount = $total;
                            $cartrule->reduction_tax = true;
                            $cartrule->minimum_amount_currency = $order->id_currency;
                            $cartrule->reduction_currency = $order->id_currency;

                            if (!$cartrule->add())
                            {
                                $this->errors[] = Tools::displayError('You cannot generate a voucher.');
                            }
                            else
                            {
                                // Update the voucher code and name
                                foreach ($language_ids as $id_lang)
                                {
                                    $cartrule->name[$id_lang] = 'V' . (int) ($cartrule->id) . 'C' . (int) ($order->id_customer) . 'O' . $order->id;
                                }
                                $cartrule->code = 'V' . (int) ($cartrule->id) . 'C' . (int) ($order->id_customer) . 'O' . $order->id;
                                if (!$cartrule->update())
                                {
                                    $this->errors[] = Tools::displayError('You cannot generate a voucher.');
                                }
                                else
                                {
                                    $currency = $this->context->currency;
                                    $params['{voucher_amount}'] = Tools::displayPrice($cartrule->reduction_amount, $currency, false);
                                    $params['{voucher_num}'] = $cartrule->code;
                                    @Mail::Send((int) $order->id_lang, 'voucher', sprintf(Mail::l('New voucher for your order #%s', (int) $order->id_lang), $order->reference), $params, $customer->email, $customer->firstname . ' ' . $customer->lastname, null, null, null, null, _PS_MAIL_DIR_, true, (int) $order->id_shop);
                                }
                            }
                        }
                    } else {
                        $this->errors[] = Tools::displayError('No product or quantity has been selected.');
                    }

                    // Redirect if no errors
                    if (!count($this->errors)) {
                        Tools::redirectAdmin(self::$currentIndex.'&id_order='.$order->id.'&vieworder&conf=31&token='.$this->token);
                    }
                }
            } else {
                $this->errors[] = Tools::displayError('You do not have permission to delete this.');
            }
            return AdminController::postProcess();
        }
        /* Add a new message for the current order and send an e-mail to the customer if needed */
        elseif (Tools::isSubmit('submitMessage') && isset($order)) {
            if ($this->tabAccess['view'] === '1') {
                $customer = new Customer(Tools::getValue('id_customer'));
                if (!Validate::isLoadedObject($customer)) {
                    $this->errors[] = Tools::displayError('The customer is invalid.');
                } elseif (!Tools::getValue('message')) {
                    $this->errors[] = Tools::displayError('The message cannot be blank.');
                } else {
                    /* Get message rules and and check fields validity */
                    $rules = call_user_func(array('Message', 'getValidationRules'), 'Message');
                    foreach ($rules['required'] as $field) {
                        if (($value = Tools::getValue($field)) == false && (string)$value != '0') {
                            if (!Tools::getValue('id_'.$this->table) || $field != 'passwd') {
                                $this->errors[] = sprintf(Tools::displayError('field %s is required.'), $field);
                            }
                        }
                    }
                    foreach ($rules['size'] as $field => $maxLength) {
                        if (Tools::getValue($field) && Tools::strlen(Tools::getValue($field)) > $maxLength) {
                            $this->errors[] = sprintf(Tools::displayError('field %1$s is too long (%2$d chars max).'), $field, $maxLength);
                        }
                    }
                    foreach ($rules['validate'] as $field => $function) {
                        if (Tools::getValue($field)) {
                            if (!Validate::$function(htmlentities(Tools::getValue($field), ENT_COMPAT, 'UTF-8'))) {
                                $this->errors[] = sprintf(Tools::displayError('field %s is invalid.'), $field);
                            }
                        }
                    }

                    if (!count($this->errors)) {
                        //check if a thread already exist
                        $id_customer_thread = CustomerThread::getIdCustomerThreadByEmailAndIdOrder($customer->email, $order->id);
                        if (!$id_customer_thread) {
                            $customer_thread = new CustomerThread();
                            $customer_thread->id_contact = 0;
                            $customer_thread->id_customer = (int)$order->id_customer;
                            $customer_thread->id_shop = (int)$this->context->shop->id;
                            $customer_thread->id_order = (int)$order->id;
                            $customer_thread->id_lang = (int)$this->context->language->id;
                            $customer_thread->email = $customer->email;
                            $customer_thread->status = 'open';
                            $customer_thread->token = Tools::passwdGen(12);
                            $customer_thread->add();
                        } else {
                            $customer_thread = new CustomerThread((int)$id_customer_thread);
                        }

                        $customer_message = new CustomerMessage();
                        $customer_message->id_customer_thread = $customer_thread->id;
                        $customer_message->id_employee = (int)$this->context->employee->id;
                        $customer_message->message = Tools::getValue('message');
                        $customer_message->private = Tools::getValue('visibility');

                        if (!$customer_message->add()) {
                            $this->errors[] = Tools::displayError('An error occurred while saving the message.');
                        } elseif ($customer_message->private) {
                            Tools::redirectAdmin(self::$currentIndex.'&id_order='.(int)$order->id.'&vieworder&conf=11&token='.$this->token);
                        } else {
                            $message = $customer_message->message;
                            if (Configuration::get('PS_MAIL_TYPE', null, null, $order->id_shop) != Mail::TYPE_TEXT) {
                                $message = Tools::nl2br($customer_message->message);
                            }

                            $varsTpl = array(
                                '{lastname}' => $customer->lastname,
                                '{firstname}' => $customer->firstname,
                                '{id_order}' => $order->id,
                                '{order_name}' => $order->getUniqReference(),
                                '{message}' => $message
                            );
                            // add subject adn file attachment
                            $subject = Tools::getValue('subject');
                            $fileAttachment = null;
                            if (!empty($_REQUEST['attach_invoice_id']))
                            {
                                foreach( $_REQUEST['attach_invoice_id'] as $attach_invoice_id ){
                                    $invoice = new OrderInvoice(intval($attach_invoice_id), $order->id_lang);
                                    if (Validate::isLoadedObject($invoice))
                                    {
                                        $pdfFileContent = null;
                                        if (file_exists($invoice->getInvoiceFilePath()))
                                        {
                                            $pdfFileContent = file_get_contents($invoice->getInvoiceFilePath());
                                        }
                                        else
                                        {
                                            $pdf = new PDF($invoice, $invoice->delivery_number?PDF::TEMPLATE_DELIVERY_SLIP:PDF::TEMPLATE_INVOICE, 
                                                    Context::getContext()->smarty);
                                            $pdfFileContent = $pdf->render('S');
                                            // save file
                                            file_put_contents($invoice->getInvoiceFilePath(), $pdfFileContent);
                                        }
                                        $fileAttachment[] = [
                                            'mime'=>'application/pdf', 
                                            'name'=>$invoice->getInvoiceFileName(), 
                                            'content'=>$pdfFileContent
                                        ];
                                    }
                                }
                            }
                            
                            if (!empty($_REQUEST['to']))
                            {
                                $to = explode(',', $_REQUEST['to']);
                            }
                            else
                            {
                                $to = $customer->email;
                            }
                            $emailSubject = !empty($subject) ? $subject : Mail::l('New message regarding your order', (int)$order->id_lang);
                            $emailSubject .= ' - '. $order->id;
                            if (@Mail::Send((int)$order->id_lang, 'order_merchant_comment',
                                $emailSubject, $varsTpl, $to,
                                $customer->firstname.' '.$customer->lastname, null, null, $fileAttachment, null, _PS_MAIL_DIR_, true, (int)$order->id_shop)) {
                                Tools::redirectAdmin(self::$currentIndex.'&id_order='.$order->id.'&vieworder&conf=11'.'&token='.$this->token);
                            }
                        }
                        $this->errors[] = Tools::displayError('An error occurred while sending an email to the customer.');
                    }
                }
            } else {
                $this->errors[] = Tools::displayError('You do not have permission to delete this.');
            }
            return AdminController::postProcess();
        }
        elseif (Tools::isSubmit('submitAddOrder') && ($id_cart = Tools::getValue('id_cart')) &&
            ($module_name = Tools::getValue('payment_module_name')) &&
            ($id_order_state = Tools::getValue('id_order_state')) && Validate::isModuleName($module_name)) {
            if ($this->tabAccess['add'] === '1') {
                if (!Configuration::get('PS_CATALOG_MODE')) {
                    $payment_module = Module::getInstanceByName($module_name);
                } else {
                    $payment_module = new BoOrder();
                }

                $cart = new Cart((int)$id_cart);
                Context::getContext()->currency = new Currency((int)$cart->id_currency);
                Context::getContext()->customer = new Customer((int)$cart->id_customer);
                $cart->id_lang = Context::getContext()->customer->id_lang;
                $cart->update();

                $bad_delivery = false;
                if (($bad_delivery = (bool)!Address::isCountryActiveById((int)$cart->id_address_delivery))
                    || !Address::isCountryActiveById((int)$cart->id_address_invoice)) {
                    if ($bad_delivery) {
                        $this->errors[] = Tools::displayError('This delivery address country is not active.');
                    } else {
                        $this->errors[] = Tools::displayError('This invoice address country is not active.');
                    }
                } else {
                    $employee = new Employee((int)Context::getContext()->cookie->id_employee);
                    $extra_vars = array();
                    if( !empty($_POST['id_order_type']) ){
                        $extra_vars['id_order_type'] = intval($_POST['id_order_type']);
                    }
                    
                    if( !empty($_POST['cart_product_name']) ){
                        $extra_vars['custom_product_name'] = array();
                        foreach($_POST['cart_product_name'] as $cartProductKey => $cartProductName){
                            $cartProductIds = explode('_', $cartProductKey);
                            $extra_vars['custom_product_name'][] = array(
                                'id_product' => $cartProductIds[0],
                                'id_product_attribute' => $cartProductIds[1],
                                'name' => $cartProductName
                            );
                        }
                    }
                    
                    $payment_module->validateOrder(
                        (int)$cart->id, (int)$id_order_state,
                        $cart->getOrderTotal(true, Cart::BOTH), $payment_module->displayName, $this->l('Manual order -- Employee:').' '.
                        substr($employee->firstname, 0, 1).'. '.$employee->lastname, $extra_vars, null, false, $cart->secure_key
                    );
                    if ($payment_module->currentOrder) {
                        Tools::redirectAdmin(self::$currentIndex.'&id_order='.$payment_module->currentOrder.'&vieworder'.'&token='.$this->token);
                    }
                }
            } else {
                $this->errors[] = Tools::displayError('You do not have permission to add this.');
            }
        }
        elseif( isset($_POST['submitIdOrderType']) && !empty($order->id) ){

            $order->id_order_type = $_POST['id_order_type'];
            
            $order->update();
            
            Tools::redirectAdmin(self::$currentIndex.'&id_order='.$order->id.'&vieworder&token='.$this->token);
        }
        /* Change order status, add a new entry in order history and send an e-mail to the customer if needed */
        elseif (Tools::isSubmit('submitState') && isset($order)) {
            unset($_POST['submitState']);
            if ($this->tabAccess['edit'] === '1') {
                $order_state = new OrderState(Tools::getValue('id_order_state'));
                $order_state_due_date = Tools::getValue('order_state_due_date');
                if( !empty($order_state_due_date) ){
                    $order_state_due_date = strtotime($order_state_due_date);
                }

                if (!Validate::isLoadedObject($order_state)) {
                    $this->errors[] = Tools::displayError('The new order status is invalid.');
                }
                elseif( intval($order_state->need_date) && (is_null($order_state_due_date) || !$order_state_due_date) ){
                    $this->errors[] = Tools::displayError('Order status due date not set.');
                }
                else {
                    $current_order_state = $order->getCurrentOrderState();
                    if ($current_order_state->id != $order_state->id) {
                        // Create new OrderHistory
                        $history = new OrderHistory();
                        $history->id_order = $order->id;
                        $history->id_employee = (int)$this->context->employee->id;
                        
                        /*if( intval($order_state->need_date) && $order_state_due_date){
                            $history->date_due = date('Y-m-d', $order_state_due_date);
                        }*/
        
                        $use_existings_payment = false;
                        if (!$order->hasInvoice()) {
                            $use_existings_payment = true;
                        }
                        $history->changeIdOrderState((int)$order_state->id, $order, $use_existings_payment);
        
                        $carrier = new Carrier($order->id_carrier, $order->id_lang);
                        $templateVars = array();
                        if ($history->id_order_state == Configuration::get('PS_OS_SHIPPING') && $order->shipping_number) {
                            $templateVars = array('{followup}' => str_replace('@', $order->shipping_number, $carrier->url));
                        }
        
                        // Save all changes
                        if ($history->addWithemail(true, $templateVars)) {
                            // synchronizes quantities if needed..
                            if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
                                foreach ($order->getProducts() as $product) {
                                    if (StockAvailable::dependsOnStock($product['product_id'])) {
                                        StockAvailable::synchronize($product['product_id'], (int)$product['id_shop']);
                                    }
                                }
                            }
                            
                            if( intval($order_state->need_date) && $order_state_due_date){
                                $order->status_date_due = date('Y-m-d', $order_state_due_date);
                                $order->update();
                            }
        
                            Tools::redirectAdmin(self::$currentIndex.'&id_order='.(int)$order->id.'&vieworder&token='.$this->token);
                        }
                        $this->errors[] = Tools::displayError('An error occurred while changing order status, or we were unable to send an email to the customer.');
                    } else {
                        $this->errors[] = Tools::displayError('The order has already been assigned this status.');
                    }
                }
            } else {
                $this->errors[] = Tools::displayError('You do not have permission to edit this.');
            }
        }
        elseif(Tools::isSubmit('getSmartShippingList'))
        {
            if (isset($_REQUEST['order_id']) && is_array($_REQUEST['order_id']))
            {
                $orderIds = $_REQUEST['order_id'];
                array_walk($orderIds, function (&$val, $i){ $val = intval($val); } );
            }
            else
            {
                $orderIds = [];
            }
            ShippingExporter::getSmartShippingList($orderIds);
            exit;
        }
        
        parent::postProcess();
    }
    
    public function ajaxProcessChangeCurrentStateDueDate()
    {
        $responseData = array(
            'success' => false,
            'data' => array(),
            'messages' => array()
        );
        $id_order = intval($_GET['id_order']);
        $date_due = $_POST['date_due'];
        
        $order = new Order($id_order);
        if (!Validate::isLoadedObject($order)) {
            $responseData['messages'][] = 'Order not loaded';
            echo json_encode($responseData);
            die;
        }
        
        $date_due = strtotime($date_due);
        if( is_null($date_due) || !$date_due ){
            $responseData['messages'][] = 'Invalid date';
            echo json_encode($responseData);
            die;
        }
        
        $order->status_date_due = date('Y-m-d', $date_due);
        
        try{
            $order->save();
        }
        catch(Exception $e){
            $responseData['messages'][] = $e->getMessage();
            echo json_encode($responseData);
            die;
        }

        $responseData['data']['status_date_due'] = $order->status_date_due;
        $responseData['data']['status_date_due_formatted'] = Tools::displayDate($order->status_date_due);
        
        $responseData['success'] = true;
        
        echo json_encode($responseData);
        die;
        
    }
    
    function ajaxProcessToggleStockState()
    {
        $orderDetail = new OrderDetail((int)Tools::getValue('id'));
        if (!Validate::isLoadedObject($orderDetail)) {
            die(Tools::jsonEncode(array(
                'error' => Tools::displayError('The order detail object cannot be loaded.')
            )));
        }
        
        $orderDetail->in_stock = $orderDetail->in_stock?0:1;
        $orderDetail->update();
        die(Tools::jsonEncode(array(
                'error' => 0,
                'inStock' => $orderDetail->in_stock
            )));
    }
    
    
    function ajaxProcessToggleInvoicePaidState()
    {
        $invoice = new OrderInvoice((int)Tools::getValue('id'));
        if (!Validate::isLoadedObject($invoice)) {
            die(Tools::jsonEncode(array(
                'error' => Tools::displayError('The invoice object cannot be loaded.')
            )));
        }
        
        die(Tools::jsonEncode(array(
                'error' => 0,
                'paid' => $invoice->toggleInvoicePaidState()
            )));
    }
    
    
    function ajaxProcessSetInvoiceSumToPay()
    {
        $invoice = new OrderInvoice((int)Tools::getValue('id'));
        if (!Validate::isLoadedObject($invoice)) {
            die(Tools::jsonEncode(array(
                'error' => Tools::displayError('The invoice object cannot be loaded.')
            )));
        }
        
        $invoice->sum_paid = floatval(Tools::getValue('amount'));
        $invoice->update();
        die(Tools::jsonEncode(array(
                'error' => 0,
            )));
    }
    
    
    function ajaxProcessSetInvoiceDueDate()
    {
        $invoice = new OrderInvoice((int)Tools::getValue('id'));
        if (!Validate::isLoadedObject($invoice)) {
            die(Tools::jsonEncode(array(
                'error' => Tools::displayError('The invoice object cannot be loaded.')
            )));
        }
        
        $invoice->due_date = date('Y-m-d', strtotime(trim(Tools::getValue('dueDate'))));
        
        $invoice->update();
        die(Tools::jsonEncode(array(
                'error' => 0,
            )));
    }
    
    function ajaxProcessSaveShippedNum()
    {
        $orderDetail = new OrderDetail((int)Tools::getValue('id'));
        if (!Validate::isLoadedObject($orderDetail)) {
            die(Tools::jsonEncode(array(
                'error' => Tools::displayError('The order detail object cannot be loaded.')
            )));
        }
        // check shipped num
        $input = trim(Tools::getValue('num'));
        $shippedNum = intval($input);
        if (strval($shippedNum) != $input || $shippedNum<0)
        {
            die(Tools::jsonEncode(array(
                'error' => Tools::displayError('Positive integer number expected.')
            )));
        }
        $shippedNumMax = $orderDetail->product_quantity-$orderDetail->product_quantity_refunded-$orderDetail->product_quantity_return;
        if ($shippedNum > $shippedNumMax)
        {
            die(Tools::jsonEncode(array(
                'error' => Tools::displayError('Number of shipped products should not be more than').' '.$shippedNumMax
            )));
        }
        
        $orderDetail->shipped = $shippedNum;
                
        $orderDetail->shipped_employee_id = $this->context->employee->id;
        $orderDetail->shipped_date = date('Y-m-d H:i:s');
        $orderDetail->update();
        // send notification to central store
        $orderDetail->reportShippedNumChanged();
        
        $order = new Order($orderDetail->id_order);
        
        $this->sendChangedNotification($order);
        
        /*$productStockPhysical = StockAvailable::getPhysicalQuantityAvailableByProduct(
            $orderDetail->product_id, $orderDetail->product_attribute_id
        );
        
        die(Tools::jsonEncode(array(
            'error' => 0,
            'shipped' => $orderDetail->shipped,
            'quantity_physical' => $productStockPhysical
        )));*/
        
        $products = $this->getProducts($order);
        $product = $products[$orderDetail->id];
        $resume = OrderSlip::getProductSlipResume($orderDetail->id);
        $product['quantity_refundable'] = $product['product_quantity'] - $resume['product_quantity'];
        $product['amount_refundable'] = $product['total_price_tax_excl'] - $resume['amount_tax_excl'];
        $product['amount_refund'] = Tools::displayPrice($resume['amount_tax_incl']);
        $product['refund_history'] = OrderSlip::getProductSlipDetail($orderDetail->id);
        if ($product['id_warehouse'] != 0) {
            $warehouse = new Warehouse((int)$product['id_warehouse']);
            $product['warehouse_name'] = $warehouse->name;
            $warehouse_location = WarehouseProductLocation::getProductLocation($product['product_id'], $product['product_attribute_id'], $product['id_warehouse']);
            if (!empty($warehouse_location)) {
                $product['warehouse_location'] = $warehouse_location;
            } else {
                $product['warehouse_location'] = false;
            }
        } else {
            $product['warehouse_name'] = '--';
            $product['warehouse_location'] = false;
        }
        
        $this->context->smarty->assign(array(
            'product' => $product,
            'order' => $order,
            'currency' => new Currency($order->id_currency),
            'can_edit' => $this->tabAccess['edit'],
            //'invoices_collection' => $invoice_collection,
            'current_id_lang' => Context::getContext()->language->id,
            'link' => Context::getContext()->link,
            'current_index' => self::$currentIndex,
            'display_warehouse' => (int)Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')
        ));
        
        if (is_array(Tools::getValue('product_quantity'))) {
            $view = $this->createTemplate('_customized_data.tpl')->fetch();
        } else {
            $view = $this->createTemplate('_product_line.tpl')->fetch();
        }
        
        die(Tools::jsonEncode(array(
            'error' => 0,
            'view' => $view,
            'can_edit' => $this->tabAccess['add'],
            'order' => $order,
        )));
        
    }
    
    
    function ajaxProcessShowOrderPackage()
    {
        // reading order package contents
        $orderPackage = new OrderPackage(intval($_REQUEST['id']));
        if (Validate::isLoadedObject($orderPackage))
        {
            $opDetails = $orderPackage->getGluedDetailsList(true);
            $employee = new Employee($orderPackage->id_employee);
        }
        else
        {
            die('Package not found');
        }
        
        $this->context->smarty->assign(array('opDetails'=>$opDetails, 'orderPackage'=>$orderPackage, 
            'employeeName'=>$employee->firstname.' '.$employee->lastname));
        die($this->createTemplate('order_package_details.tpl')->fetch());
    }
    
    
    public function ajaxProcessSearchProducts()
    {
        Context::getContext()->customer = new Customer((int)Tools::getValue('id_customer'));
        $currency = new Currency((int)Tools::getValue('id_currency'));
        
        $query = Tools::getValue('product_search');
        $sql = new DbQuery();
        $sql->select('p.`id_product`, pl.`name`, p.`ean13`, p.`upc`, p.`active`, p.`reference`, 
            m.`name` AS manufacturer_name, stock.`quantity`, product_shop.advanced_stock_management, 
            p.`customizable`, pl.link_rewrite, i.id_image, p.stock_clearance
        ');
        $sql->from('product', 'p');
        $sql->join(Shop::addSqlAssociation('product', 'p'));
        $sql->leftJoin('product_lang', 'pl', '
			p.`id_product` = pl.`id_product`
			AND pl.`id_lang` = '.(int)$this->context->language->id.Shop::addSqlRestrictionOnLang('pl')
            );
        $sql->leftJoin('manufacturer', 'm', 'm.`id_manufacturer` = p.`id_manufacturer`');
        $sql->leftJoin('image', 'i', 'i.id_product = p.id_product AND i.`cover` = 1');
        
        /*
        pl.`name` LIKE \'%'.pSQL($query).'%\'
		OR p.`ean13` LIKE \'%'.pSQL($query).'%\'
		OR p.`upc` LIKE \'%'.pSQL($query).'%\'
		OR p.`reference` LIKE \'%'.pSQL($query).'%\'
		OR p.`supplier_reference` LIKE \'%'.pSQL($query).'%\'
		OR        
        */
        $where = ' EXISTS(
            SELECT * 
            FROM `'._DB_PREFIX_.'product_supplier` sp 
            WHERE sp.`id_product` = p.`id_product` 
                AND `product_supplier_reference` LIKE \'%'.pSQL($query).'%\'
        )';
        
        $sql->orderBy('pl.`name` ASC');
        
        if (Combination::isFeatureActive()) {
            /*
            pa.`reference` LIKE \'%'.pSQL($query).'%\'
   			OR pa.`ean13` LIKE \'%'.pSQL($query).'%\'
   			OR pa.`upc` LIKE \'%'.pSQL($query).'%\')

            */
            $where .= ' OR EXISTS(
                SELECT * 
                FROM `'._DB_PREFIX_.'product_attribute` `pa` 
                WHERE pa.`id_product` = p.`id_product` 
                    AND pa.`supplier_reference` LIKE \'%'.pSQL($query).'%\'
            )';
        }
        $sql->where($where);
        $sql->join(Product::sqlStock('p', 0));
        
        $result = Db::getInstance()->executeS($sql);
        
        $products = array();
        foreach ($result as $row) {
            $row['price_tax_incl'] = Product::getPriceStatic($row['id_product'], true, null, 2);
            $row['price_tax_excl'] = Product::getPriceStatic($row['id_product'], false, null, 2);
            $products[] = $row;
        }
        
        
        //if ($products = Product::searchByName((int)$this->context->language->id, pSQL(Tools::getValue('product_search')))) {
        if( is_array($products) && count($products) ){
            foreach ($products as &$product) {
                // Formatted price
                $product['formatted_price'] = Tools::displayPrice(Tools::convertPrice($product['price_tax_incl'], $currency), $currency);
                // Concret price
                $product['price_tax_incl'] = Tools::ps_round(Tools::convertPrice($product['price_tax_incl'], $currency), 2);
                $product['price_tax_excl'] = Tools::ps_round(Tools::convertPrice($product['price_tax_excl'], $currency), 2);
                $productObj = new Product((int)$product['id_product'], false, (int)$this->context->language->id);
                $product['name'] = $productObj->supplier_reference.' - '.$product['name'];
                $product['supplier_reference'] = ProductSupplier::getProductSupplierReference($productObj->id, 0, $productObj->id_supplier);
                $combinations = array();
                $attributes = $productObj->getAttributesGroups((int)$this->context->language->id, $productObj->id_supplier);

                // Tax rate for this customer
                if (Tools::isSubmit('id_address')) {
                    $product['tax_rate'] = $productObj->getTaxesRate(new Address(Tools::getValue('id_address')));
                }

                $product['warehouse_list'] = array();

                foreach ($attributes as $attribute) {
                    if (!isset($combinations[$attribute['id_product_attribute']]['attributes'])) {
                        $combinations[$attribute['id_product_attribute']]['attributes'] = '';
                    }
                    $combinations[$attribute['id_product_attribute']]['supplier_reference'] = $attribute['product_supplier_reference'];
                    $combinations[$attribute['id_product_attribute']]['attributes'] .= $attribute['attribute_name'].' - ';
                    $combinations[$attribute['id_product_attribute']]['id_product_attribute'] = $attribute['id_product_attribute'];
                    $combinations[$attribute['id_product_attribute']]['default_on'] = $attribute['default_on'];
                    if (!isset($combinations[$attribute['id_product_attribute']]['price'])) {
                        $price_tax_incl = Product::getPriceStatic((int)$product['id_product'], true, $attribute['id_product_attribute']);
                        $price_tax_excl = Product::getPriceStatic((int)$product['id_product'], false, $attribute['id_product_attribute']);
                        $combinations[$attribute['id_product_attribute']]['price_tax_incl'] = Tools::ps_round(Tools::convertPrice($price_tax_incl, $currency), 2);
                        $combinations[$attribute['id_product_attribute']]['price_tax_excl'] = Tools::ps_round(Tools::convertPrice($price_tax_excl, $currency), 2);
                        $combinations[$attribute['id_product_attribute']]['formatted_price'] = Tools::displayPrice(Tools::convertPrice($price_tax_excl, $currency), $currency);
                    }
                    if (!isset($combinations[$attribute['id_product_attribute']]['qty_in_stock'])) {
                        $combinations[$attribute['id_product_attribute']]['qty_in_stock'] = StockAvailable::getQuantityAvailableByProduct((int)$product['id_product'], $attribute['id_product_attribute'], (int)$this->context->shop->id);
                    }

                    if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') && (int)$product['advanced_stock_management'] == 1) {
                        $product['warehouse_list'][$attribute['id_product_attribute']] = Warehouse::getProductWarehouseList($product['id_product'], $attribute['id_product_attribute']);
                    } else {
                        $product['warehouse_list'][$attribute['id_product_attribute']] = array();
                    }

                    $product['stock'][$attribute['id_product_attribute']] = Product::getRealQuantity($product['id_product'], $attribute['id_product_attribute']);
                }

                if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') && (int)$product['advanced_stock_management'] == 1) {
                    $product['warehouse_list'][0] = Warehouse::getProductWarehouseList($product['id_product']);
                } else {
                    $product['warehouse_list'][0] = array();
                }

                $product['stock'][0] = StockAvailable::getQuantityAvailableByProduct((int)$product['id_product'], 0, (int)$this->context->shop->id);

                foreach ($combinations as &$combination) {
                    $combination['attributes'] = rtrim($combination['attributes'], ' - ');
                }
                $product['combinations'] = $combinations;

                if ($product['customizable']) {
                    $product_instance = new Product((int)$product['id_product']);
                    $product['customization_fields'] = $product_instance->getCustomizationFields($this->context->language->id);
                }

                $product['image_link'] = Context::getContext()->link->
                    getImageLink($product['link_rewrite'], intval($product['id_image']), 'small_default');
                
                $product['cstmr_main_excluded'] = false;// customer can order
                $customerMainExcludBuy = CustomerMainToExcl::getCustomerAbleToBuyProduct($this->context->customer->id, intval($product['id_product']));
                if(!$customerMainExcludBuy['allowed']){
                    $product['cstmr_main_excluded'] = true;// admin must receive warning
                    $dominatNames = '';
                    foreach($customerMainExcludBuy['data']['dominants'] as $dominantData){
                        $dominatNames .= '"'. $dominantData['customer']->company .'", ';
                    }
                    $product['cstmr_main_excluded_message'] = sprintf( $this->l(
                        'Attention: This dress is protected in this area and is bought by shop %s within last 6 monthes. Do you still want to add it to order?'
                        ), $dominatNames)
                    ;
                }
                
            }
            unset($product);

            $to_return = array(
                'products' => $products,
                'found' => true
            );
        } else {
            $to_return = array('found' => false);
        }

        $this->content = Tools::jsonEncode($to_return);
    }
    
    
    
    function processFilter()
    {
        parent::processFilter();
        
        $this->_join .= ' INNER JOIN `'._DB_PREFIX_.'order_detail` od ON a.id_order = od.id_order ';
        
        if(!empty($_REQUEST['orders_search']))
        {
            $scfg = isset($_REQUEST['scfg']) && is_array($_REQUEST['scfg'])?$_REQUEST['scfg']:array();
            $search = trim($_REQUEST['orders_search']);
            $this->_join .= ' left join '._DB_PREFIX_.
                    'address ia on a.id_address_invoice=ia.id_address left join '._DB_PREFIX_.'order_slip oslp on a.id_order=oslp.id_order ';
            
            if (!empty($scfg['supplier_name']))
            {
               $this->_join .= ' left join '._DB_PREFIX_.'product p on p.id_product=od.product_id left join '._DB_PREFIX_.
                    'supplier sup on p.id_supplier=sup.id_supplier';
            }

            if (!empty($scfg['invoice_id']))
            {
                $this->_join .= ' left join '._DB_PREFIX_.'order_invoice oi on a.id_order=oi.id_order';
            }
            
            if (preg_match('/^#?[A-Z]{2}(\d{6})$/i', $search, $matches))
            {
                $possibleInvoice = $matches[1];
            }
            else
            {
                $possibleInvoice = '';
            }

            // check if integer is searched
            if (preg_match('/^\d+$/', $search))
            {
                $search = pSQL($search);
                $this->_filter .= ' and (0 ' . (!empty($scfg['customer_name']) ? " or c.firstname like '%$search%' or c.lastname like '%$search%' or address.lastname like " .
                                "'%$search%' or address.firstname like '%$search%' or ia.lastname like '%$search%' or ia.firstname like '%$search%'" : '') .
                        (!empty($scfg['customer_email']) ? " or c.email like '%$search%'" : '') .
                        (!empty($scfg['customer_address']) ? " or address.address1 like '%$search%' or address.address2 like '%$search%' or address.city like '%$search%' " .
                                "or address.postcode like '%$search%' or ia.address1 like '%$search%'" .
                                " or ia.address2 like '%$search%' or ia.city like '%$search%' or ia.postcode like '%$search%'" : '') .
                        (!empty($scfg['customer_phone']) ? " or address.phone like '%$search%' or address.phone_mobile like '%$search%' or ia.phone like '%$search%' " .
                                "or ia.phone_mobile like '%$search%'" : '') .
                        (!empty($scfg['order_id']) ? " or a.id_order='$search'" : '') .
                        (!empty($scfg['product_name']) || !empty($scfg['supplier_reference']) || !empty($scfg['product_id']) ?
                                " or a.id_order in (select id_order from " . _DB_PREFIX_ . "order_detail where 0" .
                                (!empty($scfg['product_name']) ? " or product_name like '%$search%'" : '') .
                                (!empty($scfg['supplier_reference']) ? " or product_supplier_reference like '%$search%' " : '') .
                                (!empty($scfg['product_id']) ? " or product_id='$search'" : '') . ')' : '') .
                       // (!empty($scfg['tracking_number']) ? " or tn.number like '%$search%'" : '') .
                        (!empty($scfg['invoice_id']) ? " or a.invoice_number=$search or oslp.id_order_slip=$search or oi.number=$search"
                        . " or oi.delivery_number=$search" : '') . ')'
                ;
            }
            else
            {
                $search = pSQL($search);
                $this->_join .= ' left join '._DB_PREFIX_ . 'country_lang aic on aic.id_country=ia.id_country and aic.id_lang=' . 
                        $this->context->cookie->id_lang;

                $this->_filter .= " and (0 " .
                        (!empty($scfg['customer_name']) ? " or c.firstname like '%$search%' or c.lastname like '%$search%' or address.lastname like '%$search%' or address.firstname" .
                                " like '%$search%' or ia.lastname like '%$search%' or ia.firstname like '%$search%'" : '') .
                        (!empty($scfg['customer_email']) ? " or c.email like '%$search%'" : '') .
                        (!empty($scfg['customer_address']) ? " or address.address1 like '%$search%' or address.address2 like '%$search%' or address.city like '%$search%' " .
                                "or address.postcode like '%$search%' or ia.address1 like '%$search%'" .
                                " or ia.address2 like '%$search%' or ia.city like '%$search%' or ia.postcode like '%$search%'" : '') .
// (!empty($scfg['customer_phone'])?" or address.phone like '%$search%' or address.phone_mobile like '%$search%' ".
//  "or ia.phone like '%$search%' or ia.phone_mobile like '%$search%'":'').
                        
                        (!empty($scfg['product_name']) || !empty($scfg['supplier_reference']) ? " or a.id_order in (select id_order" .
                                " from " . _DB_PREFIX_ . "order_detail where 0 " .
                                (!empty($scfg['product_name']) ? " or product_name like '%$search%'" : '') .
                                (!empty($scfg['supplier_reference']) ? " or product_supplier_reference like '%$search%' " : '') . ')' : '') .
                        (!empty($scfg['supplier_name']) ? " or sup.name like '%$search%'" : '') .
                        //(!empty($scfg['tracking_number']) ? " or tn.number like '%$search%'" : '') .
                        (!empty($scfg['country_name']) ? " or country_lang.name like '%$search%' or aic.name like '%$search%'" : '') .
                        ($possibleInvoice && !empty($scfg['invoice_id']) ? " or a.invoice_number=$possibleInvoice or oslp.id_order_slip="
                        . "$possibleInvoice or oi.number=$possibleInvoice  or oi.delivery_number=$possibleInvoice" : '') .
                    (!empty($scfg['company_name']) ? 
                        " OR c.company LIKE '%$search%' OR address.company LIKE '%$search%' OR ia.company LIKE '%$search%'" 
                        : '').
                ')';
                if( !empty($scfg['notes']) ){
                    $this->_filter = rtrim($this->_filter, ')');
                    $this->_filter .= '
                        OR a.id_order IN (
                            SELECT id_order
                            FROM `'._DB_PREFIX_.'customer_thread` ct
                            INNER JOIN `'._DB_PREFIX_.'customer_message` cm ON cm.id_customer_thread = ct.id_customer_thread
                            WHERE ct.id_order > 0
                                AND cm.message LIKE "%'. psql($search) .'%"
                            GROUP BY ct.id_order
                        )
                        OR a.id_order IN (
                            SELECT id_order
                            FROM `'._DB_PREFIX_.'order_detail`
                            WHERE note LIKE "%'. psql($search) .'%"
                                OR note_private LIKE "%'. psql($search) .'%"
                            GROUP BY id_order
                        )
                        OR a.id_customer IN (
                            SELECT reference_id AS id_customer
                            FROM `'._DB_PREFIX_.'shop_comment`
                            WHERE `reference_type` = 1
                                AND message LIKE "%'. psql($search) .'%"
                            GROUP BY reference_id
                        )
                    ';
                    $this->_filter .= ')';
                }
            }
            //echo $this->_join.'<br>'.$this->_filter;
        }
        
        $postcodeSearch = @$_POST['postcode_starts'];
        if( is_array($postcodeSearch) && count($postcodeSearch) ){
            $this->_filter .= '
                    AND c.id_country = 1
                    AND (
                ';
            $_firstAdded = false;
            foreach($postcodeSearch as $postcodeStarts){
                $postcodeStarts = intval($postcodeStarts);
                if($postcodeStarts === false){
                    continue;
                }

                $this->_filter .= ($_firstAdded ? ' OR ' : '').
                ' c.postcode LIKE "'. strval($postcodeStarts) .'%"';
                $_firstAdded = true;
            }
            $this->_filter .= ')';
        }
        
        
        if( !empty($_POST['id_order_type']) ){
            $orderTypeIds = $_POST['id_order_type'];
            $orderTypeIds = array_filter($orderTypeIds, function($value){
                return intval($value);
            });
            $this->_filter .= ' AND a.id_order_type IN('. implode(',', $orderTypeIds) .')';
        }
        
        if( !empty($_POST['can_be_shipped_only']) ){
            $orderIds = ShippingExporter::getShippingPossibleOrdersList();
            if (count($orderIds))
            {
                $this->_filter .= ' AND a.id_order IN('. implode(',', $orderIds) .')';
            }
            else
            {
                $this->_filter .= ' AND 0';
            }
        }
        
        if( !empty($_POST['noship_paid30_shipinvoice']) ){
            $invoiceType30 = BaOrderInvoice::PAYMENT_TYPE_30;
            $this->_join .= '
                INNER JOIN `'._DB_PREFIX_.'order_detail` ns_od ON ns_od.id_order = a.id_order
                LEFT JOIN `'._DB_PREFIX_.'order_invoice` i3p_oi ON i3p_oi.id_order = a.id_order
                LEFT JOIN `'._DB_PREFIX_.'ba_prestashop_invoice` i3p_bai ON i3p_bai.id = i3p_oi.template_id
                    
            ';
            $this->_filter .= '
                AND a.current_state != '. intval(Configuration::get('PS_OS_CANCELED')) .'
                AND ns_od.shipped < (ns_od.product_quantity - ns_od.product_quantity_refunded - ns_od.product_quantity_return - ns_od.product_quantity_reinjected)
                AND ( (i3p_bai.payment_type IN ('.$invoiceType30.','.(BaOrderInvoice::PAYMENT_TYPE_PREPAY).') AND i3p_oi.paid = 1)
                    OR c.ship_by_invoice = 1 )
            ';
            
            $search = trim($_REQUEST['orders_search']);
            if( !empty($search) ){
                $this->_join .= '
                    INNER JOIN `'._DB_PREFIX_.'product_attribute` ns_pa ON ns_pa.id_product = ns_od.product_id
                        AND ns_pa.id_product_attribute = ns_od.product_attribute_id
                ';
                $this->_filter .= ' AND ns_pa.`supplier_reference` LIKE "%'. pSQL($search) .'%"';
            }
        }
        else{
            if( isset($_POST['not_shipped']) ){
                $this->_join .= '
                    INNER JOIN `'._DB_PREFIX_.'order_detail` ns_od ON ns_od.id_order = a.id_order
                ';
                
                $this->_filter .= '
                    AND a.current_state != '. intval(Configuration::get('PS_OS_CANCELED')) .'
                    AND ns_od.shipped < (ns_od.product_quantity - ns_od.product_quantity_refunded - ns_od.product_quantity_return - ns_od.product_quantity_reinjected) 
                ';
            
                $search = trim($_REQUEST['orders_search']);
                if( !empty($search) ){
                    $this->_join .= '
                        INNER JOIN `'._DB_PREFIX_.'product_attribute` ns_pa ON ns_pa.id_product = ns_od.product_id
                            AND ns_pa.id_product_attribute = ns_od.product_attribute_id
                            AND ns_pa.`supplier_reference` LIKE "%'. pSQL($search) .'%"
                    ';
                }
            }
            $invoiceType30 = null;
            if( class_exists('BaOrderInvoice') ){
                $invoiceType30 = BaOrderInvoice::PAYMENT_TYPE_30;
            }
            $invoice30Paid = intval(@$_POST['invoice_30_paid']);
            
            if( $invoice30Paid && $invoiceType30 ){
                $this->_join .= '
                    LEFT JOIN `'._DB_PREFIX_.'order_invoice` i3p_oi ON i3p_oi.id_order = a.id_order
                    LEFT JOIN `'._DB_PREFIX_.'ba_prestashop_invoice` i3p_bai ON i3p_bai.id = i3p_oi.template_id
                ';
                $this->_where .= '
                    AND i3p_bai.payment_type = '. $invoiceType30 .'
                    AND i3p_oi.paid = 1
                ';
            }
            
            if( !empty($_POST['ship_by_invoice']) ){
                $this->_filter .= ' AND c.ship_by_invoice = 1';
            }
            
            if( !empty($_POST['invoice_prepay_paid']) ){
                $this->_join .= '
                    LEFT JOIN `'._DB_PREFIX_.'order_invoice` ipp_oi ON ipp_oi.id_order = a.id_order
                    LEFT JOIN `'._DB_PREFIX_.'ba_prestashop_invoice` ipp_bai ON ipp_bai.id = ipp_oi.template_id
                ';
                $this->_where .= '
                    AND ipp_bai.payment_type = '. (BaOrderInvoice::PAYMENT_TYPE_PREPAY) .'
                    AND ipp_oi.paid = 1
                ';
                
            }
        }
        
        
        if( !empty($_POST['id_order_statuses']) ){
            $orderStatusesIds = $_POST['id_order_statuses'];
            $orderStatusesIds = array_filter($orderStatusesIds, function($value){
                return intval($value);
            });
            $this->_filter .= ' AND a.current_state IN('. implode(',', $orderStatusesIds) .')';
        }
        
        if( isset($_POST['orderFilter_already_shipped']) ){
            if( $_POST['orderFilter_already_shipped'] == '1' ){
                $this->_filterHaving = preg_replace("#`already_shipped` = '1'#", '`already_shipped` = `tobe_shipped`', $this->_filterHaving);
            }
            elseif( $_POST['orderFilter_already_shipped'] == '0' ){
                $this->_filterHaving = preg_replace("#`already_shipped` = '0'#", '`already_shipped` < `tobe_shipped`', $this->_filterHaving);
            }
        }
        
        if( !empty($_POST['overdued_customers']) ){
            $shippedStatusId = Configuration::get('PS_OS_SHIPPING');
            if( $_POST['overdued_customers'] == '1' ){
                if( strlen($this->_filterHaving) ){
                    $this->_filterHaving .= ' AND ';
                }
                $this->_filterHaving .= ' ISNULL(has_overdued_invoices)';
            }
            elseif( $_POST['overdued_customers'] == '2' ){
                if( strlen($this->_filterHaving) ){
                    $this->_filterHaving .= ' AND ';
                }
                $this->_filterHaving .= ' (has_overdued_invoices > 0) ';
            }
            $this->context->smarty->assign('overdued_filter_selected', intval($_POST['overdued_customers']));
        }
        
        if( isset($_POST['id_supplier']) ){
            $supplierIds = array_map(function($sid){
                return intval($sid);
            }, $_POST['id_supplier']);
            
            if( count($supplierIds) ){
                $this->_join .= '
                    INNER JOIN '._DB_PREFIX_.'product p_s ON p_s.id_product = od.product_id
                ';
                $this->_filter .= ' AND p_s.id_supplier IN('. implode(',', $supplierIds) .')';
                
                $this->context->smarty->assign(array(
                    'supplier_filter_selected' => $supplierIds
                ));
            }
        }
    }
    
    /**
     * @param Order $order
     * @return array
     */
    protected function getProducts($order)
    {
        $products = $order->getProducts();
        
        // preapre employees
        $employeesList = Employee::getEmployees(false);
        $employees = [];
        foreach ($employeesList as $employee)
        {
            $employees[$employee['id_employee']] = $employee['firstname'].' '.$employee['lastname'].' ('.$employee['id_employee'].')';
        }

        foreach ($products as &$product) {
            // add information about who set shipped status
            if ($product['shipped_employee_id'])
            {
                $product['who_shipped'] = $employees[$product['shipped_employee_id']].', '.Tools::displayDate($product['shipped_date'], null, true);
            }
            
            if ($product['image'] != null) {
                
                $name = 'product_mini_'.$product['image']->id.(int)$product['product_id'].(isset($product['product_attribute_id']) ? '_'.(int)$product['product_attribute_id'] : '').'.jpg';
                // generate image cache, only for back office
                $product['image_tag'] = ImageManager::thumbnail(_PS_IMG_DIR_.'p/'.$product['image']->getExistingImgPath().'.jpg', $name, 45, 'jpg');
                // add big image src
                $productImageBigSrc = $this->context->shop->getBaseURL() .
                    'img/p/'. $product['image']->getExistingImgPath() . '-large_default.jpg';
                $product['image_tag'] = str_replace('/>', 'data-srcbig="'.$productImageBigSrc.'"', $product['image_tag']);
                if (file_exists(_PS_TMP_IMG_DIR_.$name)) {
                    $product['image_size'] = getimagesize(_PS_TMP_IMG_DIR_.$name);
                } else {
                    $product['image_size'] = false;
                }
            }
            
            $product['physical_stock'] = StockAvailable::getPhysicalQuantityByProduct(
                $product['product_id'], $product['product_attribute_id'], (int)$this->context->shop->id);
            
            $product['note_employee_n_date'] = null;
            if( !empty($product['note']) && !empty($product['note_employee_id']) ){
                $product['note_employee_n_date'] = $employees[$product['note_employee_id']].', '.Tools::displayDate($product['note_date'], null, true);
            }
        }

        ksort($products);

        return $products;
    }
    
    
    protected function reinjectQuantity($order_detail, $qty_cancel_product, $delete = false)
    {
        //parent::reinjectQuantity($order_detail, $qty_cancel_product, $delete);
        
        $quantity_to_reinject = $qty_cancel_product;

        // @since 1.5.0 : Advanced Stock Management
        $product_to_inject = new Product($order_detail->product_id, false, (int)$this->context->language->id, (int)$order_detail->id_shop);
        
        $product = new Product($order_detail->product_id, false, (int)$this->context->language->id, (int)$order_detail->id_shop);
        
        if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') && $product->advanced_stock_management && $order_detail->id_warehouse != 0) {
            $manager = StockManagerFactory::getManager();
            $movements = StockMvt::getNegativeStockMvts(
                $order_detail->id_order,
                $order_detail->product_id,
                $order_detail->product_attribute_id,
                $quantity_to_reinject
                );
            $left_to_reinject = $quantity_to_reinject;
            foreach ($movements as $movement) {
                if ($left_to_reinject > $movement['physical_quantity']) {
                    $quantity_to_reinject = $movement['physical_quantity'];
                }
        
                $left_to_reinject -= $quantity_to_reinject;
                if (Pack::isPack((int)$product->id)) {
                    // Gets items
                    if ($product->pack_stock_type == 1 || $product->pack_stock_type == 2 || ($product->pack_stock_type == 3 && Configuration::get('PS_PACK_STOCK_TYPE') > 0)) {
                        $products_pack = Pack::getItems((int)$product->id, (int)Configuration::get('PS_LANG_DEFAULT'));
                        // Foreach item
                        foreach ($products_pack as $product_pack) {
                            if ($product_pack->advanced_stock_management == 1) {
                                $manager->addProduct(
                                    $product_pack->id,
                                    $product_pack->id_pack_product_attribute,
                                    new Warehouse($movement['id_warehouse']),
                                    $product_pack->pack_quantity * $quantity_to_reinject,
                                    null,
                                    $movement['price_te'],
                                    true
                                    );
                            }
                        }
                    }
                    if ($product->pack_stock_type == 0 || $product->pack_stock_type == 2 ||
                        ($product->pack_stock_type == 3 && (Configuration::get('PS_PACK_STOCK_TYPE') == 0 || Configuration::get('PS_PACK_STOCK_TYPE') == 2))) {
                            $manager->addProduct(
                                $order_detail->product_id,
                                $order_detail->product_attribute_id,
                                new Warehouse($movement['id_warehouse']),
                                $quantity_to_reinject,
                                null,
                                $movement['price_te'],
                                true
                                );
                        }
                } else {
                    $manager->addProduct(
                        $order_detail->product_id,
                        $order_detail->product_attribute_id,
                        new Warehouse($movement['id_warehouse']),
                        $quantity_to_reinject,
                        null,
                        $movement['price_te'],
                        true
                        );
                }
            }
        
            $id_product = $order_detail->product_id;
            if ($delete) {
                $order_detail->delete();
            }
            StockAvailable::synchronize($id_product);
        } elseif ($order_detail->id_warehouse == 0) {
            StockAvailable::updateQuantity(
                $order_detail->product_id,
                $order_detail->product_attribute_id,
                $quantity_to_reinject,
                $order_detail->id_shop
                );
        
            if ($delete) {
                $order_detail->delete();
            }
        } else {
            $this->errors[] = Tools::displayError('This product cannot be re-stocked.');
        }
        
        
        if (count($this->errors)==0)
        {
            // add message to msss client
            $msss_client = ModuleCore::getInstanceByName('msss_client');
            // report stock update 
            $msss_client->scheduleStockUpdateById($order_detail->product_id, $order_detail->product_attribute_id,
                        $qty_cancel_product, $order_detail->id_order);
            $msss_client->sendMessagesToServerParallel();
        }
    }
    
    
    public function setMedia()
    {
        parent::setMedia();

        if( $this->tabAccess['edit'] == 1 ){
            $this->addJS(_PS_JS_DIR_.'admin/order_invoices.js');
        }
        
        if ($this->tabAccess['view'] == 1 && $this->display == 'view') {
            $this->addJS(_PS_JS_DIR_.'admin/orders_view.js');
        }
        
        $this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/cluetip/jquery.cluetip.js');
        $this->context->controller->addCss(__PS_BASE_URI__.'js/jquery/plugins/cluetip/jquery.cluetip.css');
        
        $this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.js');
        $this->context->controller->addCss(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.css');
        
    }
    
    
    public function showMayBeShipped($mayBeShipped, $row)
    {
        if ($mayBeShipped)
        {
            return '<i class="icon-truck"></i>';
        }
    }
    
    
    public function ajaxProcessAddProductOnOrder()
    {
        // Load object
        $order = new Order((int)Tools::getValue('id_order'));
        if (!Validate::isLoadedObject($order)) {
            die(Tools::jsonEncode(array(
                'result' => false,
                'error' => Tools::displayError('The order object cannot be loaded.')
            )));
        }

        $old_cart_rules = Context::getContext()->cart->getCartRules();

        if ($order->hasBeenShipped()) {
            die(Tools::jsonEncode(array(
                'result' => false,
                'error' => Tools::displayError('You cannot add products to delivered orders. ')
            )));
        }

        $product_informations = $_POST['add_product'];
        if (isset($_POST['add_invoice'])) {
            $invoice_informations = $_POST['add_invoice'];
        } else {
            $invoice_informations = array();
        }
        $product = new Product($product_informations['product_id'], false, $order->id_lang);
        if (!Validate::isLoadedObject($product)) {
            die(Tools::jsonEncode(array(
                'result' => false,
                'error' => Tools::displayError('The product object cannot be loaded.')
            )));
        }

        if (isset($product_informations['product_attribute_id']) && $product_informations['product_attribute_id']) {
            $combination = new Combination($product_informations['product_attribute_id']);
            if (!Validate::isLoadedObject($combination)) {
                die(Tools::jsonEncode(array(
                'result' => false,
                'error' => Tools::displayError('The combination object cannot be loaded.')
            )));
            }
        }

        // Total method
        $total_method = Cart::BOTH_WITHOUT_SHIPPING;

        // Create new cart
        $cart = new Cart();
        $cart->id_shop_group = $order->id_shop_group;
        $cart->id_shop = $order->id_shop;
        $cart->id_customer = $order->id_customer;
        $cart->id_carrier = $order->id_carrier;
        $cart->id_address_delivery = $order->id_address_delivery;
        $cart->id_address_invoice = $order->id_address_invoice;
        $cart->id_currency = $order->id_currency;
        $cart->id_lang = $order->id_lang;
        $cart->secure_key = $order->secure_key;

        // Save new cart
        $cart->add();

        // Save context (in order to apply cart rule)
        $this->context->cart = $cart;
        $this->context->customer = new Customer($order->id_customer);

        // always add taxes even if there are not displayed to the customer
        $use_taxes = true;

        $initial_product_price_tax_incl = Product::getPriceStatic($product->id, $use_taxes, isset($combination) ? $combination->id : null, 2, null, false, true, 1,
            false, $order->id_customer, $cart->id, $order->{Configuration::get('PS_TAX_ADDRESS_TYPE', null, null, $order->id_shop)});

        // Creating specific price if needed
        if ($product_informations['product_price_tax_incl'] != $initial_product_price_tax_incl) {
            $specific_price = new SpecificPrice();
            $specific_price->id_shop = 0;
            $specific_price->id_shop_group = 0;
            $specific_price->id_currency = 0;
            $specific_price->id_country = 0;
            $specific_price->id_group = 0;
            $specific_price->id_customer = $order->id_customer;
            $specific_price->id_product = $product->id;
            if (isset($combination)) {
                $specific_price->id_product_attribute = $combination->id;
            } else {
                $specific_price->id_product_attribute = 0;
            }
            $specific_price->price = $product_informations['product_price_tax_excl'];
            $specific_price->from_quantity = 1;
            $specific_price->reduction = 0;
            $specific_price->reduction_type = 'amount';
            $specific_price->reduction_tax = 0;
            $specific_price->from = '0000-00-00 00:00:00';
            $specific_price->to = '0000-00-00 00:00:00';
            $specific_price->add();
        }

        // Add product to cart
        $update_quantity = $cart->updateQty($product_informations['product_quantity'], $product->id, isset($product_informations['product_attribute_id']) ? $product_informations['product_attribute_id'] : null,
            isset($combination) ? $combination->id : null, 'up', 0, new Shop($cart->id_shop));

        if ($update_quantity < 0) {
            // If product has attribute, minimal quantity is set with minimal quantity of attribute
            $minimal_quantity = ($product_informations['product_attribute_id']) ? Attribute::getAttributeMinimalQty($product_informations['product_attribute_id']) : $product->minimal_quantity;
            die(Tools::jsonEncode(array('error' => sprintf(Tools::displayError('You must add %d minimum quantity', false), $minimal_quantity))));
        } elseif (!$update_quantity) {
            die(Tools::jsonEncode(array('error' => Tools::displayError('You already have the maximum quantity available for this product.', false))));
        }

        /*
        if ($product_informations['invoice'])
        {
            // create a new invoice
            $order_invoice = new OrderInvoice();
            // If we create a new invoice, we calculate shipping cost
            $total_method = Cart::BOTH;
            // Create Cart rule in order to make free shipping
            if (isset($invoice_informations['free_shipping']) && $invoice_informations['free_shipping'])
            {
                $cart_rule = new CartRule();
                $cart_rule->id_customer = $order->id_customer;
                $cart_rule->name = array(
                    Configuration::get('PS_LANG_DEFAULT') => $this->l('[Generated] CartRule for Free Shipping')
                );
                $cart_rule->date_from = date('Y-m-d H:i:s', time());
                $cart_rule->date_to = date('Y-m-d H:i:s', time() + 24 * 3600);
                $cart_rule->quantity = 1;
                $cart_rule->quantity_per_user = 1;
                $cart_rule->minimum_amount_currency = $order->id_currency;
                $cart_rule->reduction_currency = $order->id_currency;
                $cart_rule->free_shipping = true;
                $cart_rule->active = 1;
                $cart_rule->add();

                // Add cart rule to cart and in order
                $cart->addCartRule($cart_rule->id);
                $values = array(
                    'tax_incl' => $cart_rule->getContextualValue(true),
                    'tax_excl' => $cart_rule->getContextualValue(false)
                );
                $order->addCartRule($cart_rule->id, $cart_rule->name[Configuration::get('PS_LANG_DEFAULT')], $values);
            }

            $order_invoice->id_order = $order->id;
            if ($order_invoice->number)
            {
                Configuration::updateValue('PS_INVOICE_START_NUMBER', false, false, null, $order->id_shop);
            }
            else
            {
                $order_invoice->number = Order::getLastInvoiceNumber() + 1;
            }

            $invoice_address = new Address((int) $order->{Configuration::get('PS_TAX_ADDRESS_TYPE', null, null, $order->id_shop)});
            $carrier = new Carrier((int) $order->id_carrier);
            $tax_calculator = $carrier->getTaxCalculator($invoice_address);

            $order_invoice->total_paid_tax_excl = Tools::ps_round((float) $cart->getOrderTotal(false, $total_method), 2);
            $order_invoice->total_paid_tax_incl = Tools::ps_round((float) $cart->getOrderTotal($use_taxes, $total_method), 2);
            $order_invoice->total_products = (float) $cart->getOrderTotal(false, Cart::ONLY_PRODUCTS);
            $order_invoice->total_products_wt = (float) $cart->getOrderTotal($use_taxes, Cart::ONLY_PRODUCTS);
            $order_invoice->total_shipping_tax_excl = (float) $cart->getTotalShippingCost(null, false);
            $order_invoice->total_shipping_tax_incl = (float) $cart->getTotalShippingCost();

            $order_invoice->total_wrapping_tax_excl = abs($cart->getOrderTotal(false, Cart::ONLY_WRAPPING));
            $order_invoice->total_wrapping_tax_incl = abs($cart->getOrderTotal($use_taxes, Cart::ONLY_WRAPPING));
            $order_invoice->shipping_tax_computation_method = (int) $tax_calculator->computation_method;

            // Update current order field, only shipping because other field is updated later
            $order->total_shipping += $order_invoice->total_shipping_tax_incl;
            $order->total_shipping_tax_excl += $order_invoice->total_shipping_tax_excl;
            $order->total_shipping_tax_incl += ($use_taxes) ? $order_invoice->total_shipping_tax_incl : $order_invoice->total_shipping_tax_excl;

            $order->total_wrapping += abs($cart->getOrderTotal($use_taxes, Cart::ONLY_WRAPPING));
            $order->total_wrapping_tax_excl += abs($cart->getOrderTotal(false, Cart::ONLY_WRAPPING));
            $order->total_wrapping_tax_incl += abs($cart->getOrderTotal($use_taxes, Cart::ONLY_WRAPPING));
            $order_invoice->add();

            $order_invoice->saveCarrierTaxCalculator($tax_calculator->getTaxesAmount($order_invoice->total_shipping_tax_excl));

            $order_carrier = new OrderCarrier();
            $order_carrier->id_order = (int) $order->id;
            $order_carrier->id_carrier = (int) $order->id_carrier;
            $order_carrier->id_order_invoice = (int) $order_invoice->id;
            $order_carrier->weight = (float) $cart->getTotalWeight();
            $order_carrier->shipping_cost_tax_excl = (float) $order_invoice->total_shipping_tax_excl;
            $order_carrier->shipping_cost_tax_incl = ($use_taxes) ? (float) $order_invoice->total_shipping_tax_incl : (float) $order_invoice->total_shipping_tax_excl;
            $order_carrier->add();
        }
         * 
         */

        // Create Order detail information
        $order_detail = new OrderDetail();
        $order_detail->createList($order, $cart, $order->getCurrentOrderState(), $cart->getProducts(), (isset($order_invoice) ? $order_invoice->id : 0), $use_taxes, (int)Tools::getValue('add_product_warehouse'));

        // update totals amount of order
        $order->total_products += (float)$cart->getOrderTotal(false, Cart::ONLY_PRODUCTS);
        $order->total_products_wt += (float)$cart->getOrderTotal($use_taxes, Cart::ONLY_PRODUCTS);

        $order->total_paid += Tools::ps_round((float)($cart->getOrderTotal(true, $total_method)), 2);
        $order->total_paid_tax_excl += Tools::ps_round((float)($cart->getOrderTotal(false, $total_method)), 2);
        $order->total_paid_tax_incl += Tools::ps_round((float)($cart->getOrderTotal($use_taxes, $total_method)), 2);

        if (isset($order_invoice) && Validate::isLoadedObject($order_invoice)) {
            $order->total_shipping = $order_invoice->total_shipping_tax_incl;
            $order->total_shipping_tax_incl = $order_invoice->total_shipping_tax_incl;
            $order->total_shipping_tax_excl = $order_invoice->total_shipping_tax_excl;
        }
        // discount
        $order->total_discounts += (float)abs($cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS));
        $order->total_discounts_tax_excl += (float)abs($cart->getOrderTotal(false, Cart::ONLY_DISCOUNTS));
        $order->total_discounts_tax_incl += (float)abs($cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS));

        // Save changes of order
        $order->update();

        // Update weight SUM
        $order_carrier = new OrderCarrier((int)$order->getIdOrderCarrier());
        if (Validate::isLoadedObject($order_carrier)) {
            $order_carrier->weight = (float)$order->getTotalWeight();
            if ($order_carrier->update()) {
                $order->weight = sprintf("%.3f ".Configuration::get('PS_WEIGHT_UNIT'), $order_carrier->weight);
            }
        }

        // Update Tax lines
        $order_detail->updateTaxAmount($order);

        // Delete specific price if exists
        if (isset($specific_price)) {
            $specific_price->delete();
        }

        $products = $this->getProducts($order);

        // Get the last product
        $product = end($products);
        $resume = OrderSlip::getProductSlipResume((int)$product['id_order_detail']);
        $product['quantity_refundable'] = $product['product_quantity'] - $resume['product_quantity'];
        $product['amount_refundable'] = $product['total_price_tax_excl'] - $resume['amount_tax_excl'];
        $product['amount_refund'] = Tools::displayPrice($resume['amount_tax_incl']);
        $product['return_history'] = OrderReturn::getProductReturnDetail((int)$product['id_order_detail']);
        $product['refund_history'] = OrderSlip::getProductSlipDetail((int)$product['id_order_detail']);
        if ($product['id_warehouse'] != 0) {
            $warehouse = new Warehouse((int)$product['id_warehouse']);
            $product['warehouse_name'] = $warehouse->name;
            $warehouse_location = WarehouseProductLocation::getProductLocation($product['product_id'], $product['product_attribute_id'], $product['id_warehouse']);
            if (!empty($warehouse_location)) {
                $product['warehouse_location'] = $warehouse_location;
            } else {
                $product['warehouse_location'] = false;
            }
        } else {
            $product['warehouse_name'] = '--';
            $product['warehouse_location'] = false;
        }

        // Get invoices collection
        $invoice_collection = $order->getInvoicesCollection();

        $invoice_array = array();
        foreach ($invoice_collection as $invoice) {
            /** @var OrderInvoice $invoice */
            $invoice->name = $invoice->getInvoiceNumberFormatted(Context::getContext()->language->id, (int)$order->id_shop);
            $invoice_array[] = $invoice;
        }

        // Assign to smarty informations in order to show the new product line
        $this->context->smarty->assign(array(
            'product' => $product,
            'order' => $order,
            'currency' => new Currency($order->id_currency),
            'can_edit' => $this->tabAccess['edit'],
            'invoices_collection' => $invoice_collection,
            'current_id_lang' => Context::getContext()->language->id,
            'link' => Context::getContext()->link,
            'current_index' => self::$currentIndex,
            'display_warehouse' => (int)Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT'),
            'orderDocumentsOnlyTable' => true
        ));

        // send notification to CK
        if (count($this->errors)==0)
        {
            // add message to msss client
            $msss_client = ModuleCore::getInstanceByName('msss_client');
            // report stock update 
            $msss_client->scheduleStockUpdateById($product_informations['product_id'], $product_informations['product_attribute_id'],
                        -$product_informations['product_quantity'], $order->id);
            $msss_client->sendMessagesToServerParallel();
        }
        
        $this->sendChangedNotification($order);
        $new_cart_rules = Context::getContext()->cart->getCartRules();
        sort($old_cart_rules);
        sort($new_cart_rules);
        $result = array_diff($new_cart_rules, $old_cart_rules);
        $refresh = false;

        $res = true;
        foreach ($result as $cart_rule) {
            $refresh = true;
            // Create OrderCartRule
            $rule = new CartRule($cart_rule['id_cart_rule']);
            $values = array(
                    'tax_incl' => $rule->getContextualValue(true),
                    'tax_excl' => $rule->getContextualValue(false)
                    );
            $order_cart_rule = new OrderCartRule();
            $order_cart_rule->id_order = $order->id;
            $order_cart_rule->id_cart_rule = $cart_rule['id_cart_rule'];
            $order_cart_rule->id_order_invoice = $order_invoice->id;
            $order_cart_rule->name = $cart_rule['name'];
            $order_cart_rule->value = $values['tax_incl'];
            $order_cart_rule->value_tax_excl = $values['tax_excl'];
            $res &= $order_cart_rule->add();

            $order->total_discounts += $order_cart_rule->value;
            $order->total_discounts_tax_incl += $order_cart_rule->value;
            $order->total_discounts_tax_excl += $order_cart_rule->value_tax_excl;
            $order->total_paid -= $order_cart_rule->value;
            $order->total_paid_tax_incl -= $order_cart_rule->value;
            $order->total_paid_tax_excl -= $order_cart_rule->value_tax_excl;
        }

        // Update Order
        $res &= $order->update();

        die(Tools::jsonEncode(array(
            'result' => true,
            'view' => $this->createTemplate('_product_line.tpl')->fetch(),
            'can_edit' => $this->tabAccess['add'],
            'order' => $order,
            'invoices' => $invoice_array,
            'documents_html' => $this->createTemplate('_documents.tpl')->fetch(),
            'shipping_html' => $this->createTemplate('_shipping.tpl')->fetch(),
            'discount_form_html' => $this->createTemplate('_discount_form.tpl')->fetch(),
            'refresh' => $refresh
        )));
    }
    
    
    public function ajaxProcessDeleteProductLine()
    {
        $res = true;

        $order_detail = new OrderDetail((int)Tools::getValue('id_order_detail'));
        $order = new Order((int)Tools::getValue('id_order'));

        $this->doDeleteProductLineValidation($order_detail, $order);

        // Update Order
        $order->total_paid -= $order_detail->total_price_tax_incl;
        $order->total_paid_tax_incl -= $order_detail->total_price_tax_incl;
        $order->total_paid_tax_excl -= $order_detail->total_price_tax_excl;
        $order->total_products -= $order_detail->total_price_tax_excl;
        $order->total_products_wt -= $order_detail->total_price_tax_incl;

        $res &= $order->update();

        // Reinject quantity in stock
        $this->reinjectQuantity($order_detail, $order_detail->product_quantity, true);

        // Update weight SUM
        $order_carrier = new OrderCarrier((int)$order->getIdOrderCarrier());
        if (Validate::isLoadedObject($order_carrier)) {
            $order_carrier->weight = (float)$order->getTotalWeight();
            $res &= $order_carrier->update();
            if ($res) {
                $order->weight = sprintf("%.3f ".Configuration::get('PS_WEIGHT_UNIT'), $order_carrier->weight);
            }
        }

        if (!$res) {
            die(Tools::jsonEncode(array(
                'result' => $res,
                'error' => Tools::displayError('An error occurred while attempting to delete the product line.')
            )));
        }

        // Get invoices collection
        $invoice_collection = $order->getInvoicesCollection();

        $invoice_array = array();
        foreach ($invoice_collection as $invoice) {
            /** @var OrderInvoice $invoice */
            $invoice->name = $invoice->getInvoiceNumberFormatted(Context::getContext()->language->id, (int)$order->id_shop);
            $invoice_array[] = $invoice;
        }

        // Assign to smarty informations in order to show the new product line
        $this->context->smarty->assign(array(
            'order' => $order,
            'currency' => new Currency($order->id_currency),
            'invoices_collection' => $invoice_collection,
            'current_id_lang' => Context::getContext()->language->id,
            'link' => Context::getContext()->link,
            'current_index' => self::$currentIndex,
            'orderDocumentsOnlyTable' => true
        ));

        $this->sendChangedNotification($order);

        die(Tools::jsonEncode(array(
            'result' => $res,
            'order' => $order,
            'invoices' => $invoice_array,
            'documents_html' => $this->createTemplate('_documents.tpl')->fetch(),
            'shipping_html' => $this->createTemplate('_shipping.tpl')->fetch()
        )));
    }
    
    public function ajaxProcessEditProductOnOrder()
    {
        // Return value
        $res = true;
    
        $order = new Order((int)Tools::getValue('id_order'));
        $order_detail = new OrderDetail((int)Tools::getValue('product_id_order_detail'));
        /*if (Tools::isSubmit('product_invoice')) {
            $order_invoice = new OrderInvoice((int)Tools::getValue('product_invoice'));
        }*/
    
        // Check fields validity
        $this->doEditProductValidation($order_detail, $order, isset($order_invoice) ? $order_invoice : null);
    
        // If multiple product_quantity, the order details concern a product customized
        $product_quantity = 0;
        if (is_array(Tools::getValue('product_quantity'))) {
            foreach (Tools::getValue('product_quantity') as $id_customization => $qty) {
                // Update quantity of each customization
                Db::getInstance()->update('customization', array('quantity' => (int)$qty), 'id_customization = '.(int)$id_customization);
                // Calculate the real quantity of the product
                $product_quantity += $qty;
            }
        } else {
            $product_quantity = intval( Tools::getValue('product_quantity') );
        }
    
        $product_price_tax_incl = Tools::ps_round(Tools::getValue('product_price_tax_incl'), 2);
        $product_price_tax_excl = Tools::ps_round(Tools::getValue('product_price_tax_excl'), 2);
        $total_products_tax_incl = $product_price_tax_incl * $product_quantity;
        $total_products_tax_excl = $product_price_tax_excl * $product_quantity;
    
        // Calculate differences of price (Before / After)
        $diff_price_tax_incl = $total_products_tax_incl - $order_detail->total_price_tax_incl;
        $diff_price_tax_excl = $total_products_tax_excl - $order_detail->total_price_tax_excl;
    
        // Apply change on OrderInvoice
        if (isset($order_invoice)) {
            // If OrderInvoice to use is different, we update the old invoice and new invoice
            if ($order_detail->id_order_invoice != $order_invoice->id) {
                $old_order_invoice = new OrderInvoice($order_detail->id_order_invoice);
                // We remove cost of products
                $old_order_invoice->total_products -= $order_detail->total_price_tax_excl;
                $old_order_invoice->total_products_wt -= $order_detail->total_price_tax_incl;
    
                $old_order_invoice->total_paid_tax_excl -= $order_detail->total_price_tax_excl;
                $old_order_invoice->total_paid_tax_incl -= $order_detail->total_price_tax_incl;

                $res &= $old_order_invoice->update();
    
                $order_invoice->total_products += $order_detail->total_price_tax_excl;
                $order_invoice->total_products_wt += $order_detail->total_price_tax_incl;
    
                $order_invoice->total_paid_tax_excl += $order_detail->total_price_tax_excl;
                $order_invoice->total_paid_tax_incl += $order_detail->total_price_tax_incl;
    
                $order_detail->id_order_invoice = $order_invoice->id;
            }
        }
    
        if ($diff_price_tax_incl != 0 && $diff_price_tax_excl != 0) {
            $order_detail->unit_price_tax_excl = $product_price_tax_excl;
            $order_detail->unit_price_tax_incl = $product_price_tax_incl;
    
            $order_detail->total_price_tax_incl += $diff_price_tax_incl;
            $order_detail->total_price_tax_excl += $diff_price_tax_excl;
    
            if (isset($order_invoice)) {
                // Apply changes on OrderInvoice
                $order_invoice->total_products += $diff_price_tax_excl;
                $order_invoice->total_products_wt += $diff_price_tax_incl;
    
                $order_invoice->total_paid_tax_excl += $diff_price_tax_excl;
                $order_invoice->total_paid_tax_incl += $diff_price_tax_incl;
            }
    
            // Apply changes on Order
            $order = new Order($order_detail->id_order);
            $order->total_products += $diff_price_tax_excl;
            $order->total_products_wt += $diff_price_tax_incl;
    
            $order->total_paid += $diff_price_tax_incl;
            $order->total_paid_tax_excl += $diff_price_tax_excl;
            $order->total_paid_tax_incl += $diff_price_tax_incl;
    
            $res &= $order->update();
        }
    
        $old_quantity = $order_detail->product_quantity;
    
        $order_detail->product_quantity = $product_quantity;
        $order_detail->reduction_percent = 0;
    
        // update taxes
        $res &= $order_detail->updateTaxAmount($order);
    
        // Save order detail
        $res &= $order_detail->update();
    
        // Update weight SUM
        $order_carrier = new OrderCarrier((int)$order->getIdOrderCarrier());
        if (Validate::isLoadedObject($order_carrier)) {
            $order_carrier->weight = (float)$order->getTotalWeight();
            $res &= $order_carrier->update();
            if ($res) {
                $order->weight = sprintf("%.3f ".Configuration::get('PS_WEIGHT_UNIT'), $order_carrier->weight);
            }
        }

        // Save order invoice
        if (isset($order_invoice)) {
            $res &= $order_invoice->update();
        }
    
        // Update product available quantity
        //StockAvailable::updateQuantity($order_detail->product_id, $order_detail->product_attribute_id, ($old_quantity - $order_detail->product_quantity), $order->id_shop);
        
        /**
         * Override which must correct stock manipulations
         */
        $this->reinjectQuantity($order_detail, ($old_quantity - $order_detail->product_quantity), false);
    
        $products = $this->getProducts($order);
        // Get the last product
        $product = $products[$order_detail->id];
        $resume = OrderSlip::getProductSlipResume($order_detail->id);
        $product['quantity_refundable'] = $product['product_quantity'] - $resume['product_quantity'];
        $product['amount_refundable'] = $product['total_price_tax_excl'] - $resume['amount_tax_excl'];
        $product['amount_refund'] = Tools::displayPrice($resume['amount_tax_incl']);
        $product['refund_history'] = OrderSlip::getProductSlipDetail($order_detail->id);
        if ($product['id_warehouse'] != 0) {
            $warehouse = new Warehouse((int)$product['id_warehouse']);
            $product['warehouse_name'] = $warehouse->name;
            $warehouse_location = WarehouseProductLocation::getProductLocation($product['product_id'], $product['product_attribute_id'], $product['id_warehouse']);
            if (!empty($warehouse_location)) {
                $product['warehouse_location'] = $warehouse_location;
            } else {
                $product['warehouse_location'] = false;
            }
        } else {
            $product['warehouse_name'] = '--';
            $product['warehouse_location'] = false;
        }
    
        // Get invoices collection
        $invoice_collection = $order->getInvoicesCollection();
    
        $invoice_array = array();
        foreach ($invoice_collection as $invoice) {
            /** @var OrderInvoice $invoice */
            $invoice->name = $invoice->getInvoiceNumberFormatted(Context::getContext()->language->id, (int)$order->id_shop);
            $invoice_array[] = $invoice;
        }
    
        // Assign to smarty informations in order to show the new product line
        $this->context->smarty->assign(array(
            'product' => $product,
            'order' => $order,
            'currency' => new Currency($order->id_currency),
            'can_edit' => $this->tabAccess['edit'],
            'invoices_collection' => $invoice_collection,
            'current_id_lang' => Context::getContext()->language->id,
            'link' => Context::getContext()->link,
            'current_index' => self::$currentIndex,
            'display_warehouse' => (int)Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')
        ));
    
        if (!$res) {
            die(Tools::jsonEncode(array(
                'result' => $res,
                'error' => Tools::displayError('An error occurred while editing the product line.')
            )));
        }
    
    
        if (is_array(Tools::getValue('product_quantity'))) {
            $view = $this->createTemplate('_customized_data.tpl')->fetch();
        } else {
            $view = $this->createTemplate('_product_line.tpl')->fetch();
        }
    
        $this->sendChangedNotification($order);
    
        die(Tools::jsonEncode(array(
            'result' => $res,
            'view' => $view,
            'can_edit' => $this->tabAccess['add'],
            'invoices_collection' => $invoice_collection,
            'order' => $order,
            'invoices' => $invoice_array,
            'documents_html' => $this->createTemplate('_documents.tpl')->fetch(),
            'shipping_html' => $this->createTemplate('_shipping.tpl')->fetch(),
            'customized_product' => is_array(Tools::getValue('product_quantity'))
        )));
    }
    
    public function ajaxProcessEditDetailNote()
    {
        $responseData = array(
            'success' => false,
            'form' => null,
            'message' => '',
            'data' => array()
        );
        
        $order = new Order((int)Tools::getValue('id_order'));
        $object = new OrderDetail((int)Tools::getValue('id_order_detail'));
        
        $fields_form = array(
            'form' => array(
                'error' => false,
                'id_form' => 'orderDetailNote',
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Note public'),
                        'name' => 'note',
                        //'required' => true,
                        'rows' => '5',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Note private'),
                        'name' => 'note_private',
                        //'required' => true,
                        'rows' => '5',
                    ),
                )
            )
        );
        
        $fields_value = array(
            'note' => $object->note,
            'note_private' => $object->note_private
        );
        
        
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
            
            $noteValue = strip_tags( trim($_POST['note']) );
            $notePrivateValue = strip_tags( trim($_POST['note_private']) );
            
            if(! ($error = $object->validateField('note', $noteValue)) ){
                $this->errors['note'] = $error;
            }
            if(! ($error = $object->validateField('note_private', $notePrivateValue)) ){
                $this->errors['note_private'] = $error;
            }
            
            
            if( !count($this->errors) ){
                $object->note = $noteValue;
                $object->note_private = $notePrivateValue;
                
                $object->note_date = date('Y-m-d H:i:s');
                $object->note_employee_id = $this->context->employee->id;
                
                try{
                    $object->save();
                }
                catch (Exception $e){
                    //print_r($object);
                    $responseData['message'] = $e->getMessage();
                    
                    echo json_encode($responseData);
                    die;
                }
                
                $responseData['success'] = true;
                $responseData['data'] = $object;
                echo json_encode($responseData);
                die;
            }
            else{
                $fields_value['note'] = $noteValue;
                $fields_value['note_private'] = $notePrivateValue;
                
                $fields_form['form']['error'] = '<ul><li>' . implode('</li><li>', $this->errors) .'</li></ul>';
            }
        }
        $helper = new HelperForm();
        $this->setHelperDisplay($helper);
        $helper->id_form = 'orderDetailNote';
        $helper->submit_action = '';
        
        $helper->show_cancel_button = false;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminOrders') .'&action=edit_detail_note&ajax=1&id_order='. $order->id .'&id_order_detail='.$object->id;
        
        $helper->tpl_vars = $this->getTemplateFormVars();
        $helper->fields_value = $fields_value;
        $form = $helper->generateForm(array($fields_form));
        
        $responseData['success'] = true;
        $responseData['form'] = $form;
        
        echo json_encode($responseData);
        die;
    }
    
    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false)
    {
        
        // restrict list of allowed orders
        $employeeAreas = EmployeeArea::getEmployeeCountries($this->context->employee->id, $this->context->employee->id_lang);
        if( is_array($employeeAreas) && count($employeeAreas) ){
            EmployeeArea::setListSqlConditions('c', $this->context->employee->id, array(
                'select' => &$this->_select,
                'join' => &$this->_join,
                'where' => &$this->_where,
                'orderBy' => &$this->_orderBy,
                'orderWay' => &$this->_orderWay,
                'groupBy' => &$this->_group,
                'having' => &$this->_filterHaving
            ));
        }
        
        // reading list
        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);
        
        foreach($this->_list as &$order)
        {
            if( intval($order['customer_inkasso']) ){
                if (empty($order['class'])){
                    $order['class'] = 'inkassoCustomer';
                }
                else{
                    $order['class'] .= ' inkassoCustomer';
                }
            }
            else{
                $hasNotPaidInvoice = false;
                if( intval($order['has_overdued_invoices']) ){
                    $hasNotPaidInvoice = true;
                    if (empty($order['class'])){
                        $order['class'] = 'notPaidInvoice';
                    }
                    else{
                        $order['class'] .= ' notPaidInvoice';
                    }
                    
                }
                
                if(!$hasNotPaidInvoice){
                    // find amount of unpaid invoices of customer, and mark invoice if amount is higher then credit limit
                    $unpaidQuery = '
                        SELECT SUM(oi.sum_to_pay) as unpaid_amount
                        FROM `'._DB_PREFIX_.'order_invoice` oi
                        INNER JOIN `'._DB_PREFIX_.'orders` o ON o.id_order = oi.id_order
                        INNER JOIN `'._DB_PREFIX_.'ba_prestashop_invoice` bai 
                            ON oi.template_id = bai.id 
                            AND bai.payment_type != '. (BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP) .'
    
                        WHERE 
                            o.id_customer = '. intval($order['id_customer']) .'
                            AND oi.number > 0
                            AND oi.paid = 0
                            AND o.current_state != '. intval(Configuration::get('PS_OS_CANCELED')) .'
                        GROUP BY o.id_customer
                    ';
                    $unpaidAmount = Db::getInstance()->getValue($unpaidQuery);
                    $unpaidAmount = floatval($unpaidAmount);
                    if( $unpaidAmount > $order['customer_credit_limit'] ){
                        if( empty($order['class']) ){
                            $order['class'] = 'cstCredLmtOver';
                        }
                        else{
                            $order['class'] .= ' cstCredLmtOver';
                        }
                    }
                }
            }
        }
        
    }

    public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();
        
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['sale_stats'] = array(
                'href' => $this->context->link->getAdminLink('AdminSalesStats'),
                'desc' => $this->l('Detailed statistics', null, null, false),
                'icon' => 'process-icon-stats'
            );
            
            $this->page_header_toolbar_btn['orders_stats'] = array(
                'href' => 'javascript:sendBulkAction($("#form-order"),"submitBulksoldAndSalesStatsorder",0)',
                'desc' => $this->l('Statistics show', null, null, false),
                'icon' => 'process-icon-stats'
            );
        }
        
    }

    public function ajaxProcessAddShippingLabelPrint()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        $id_order = (int)Tools::getValue('id_order');
        $id_address = (int)Tools::getValue('id_address');
        $labelsNumber = (int)Tools::getValue('number');
        
        if( !$labelsNumber ){
            $responseData['success'] = false;
            $responseData['message'] = 'Invalid labels number';
            echo json_encode($responseData);
            die;
        }
        
        $shippingLabelPrintData = array(
            'id_order' => $id_order,
            'id_address' => $id_address,
            'number' => $labelsNumber,
            'status' => 0,
            'date_upd' => array(
                'type' => 'sql',
                'value' => 'NOW()'
            )
            
        );
        
        try{
            Db::getInstance()->insert('shipping_label_print', $shippingLabelPrintData);
        }
        catch(Exception $e){
            $responseData['success'] = false;
            $responseData['message'] = Db::getInstance()->getMsgError();
            echo json_encode($responseData);
            die;
        }
        
        $responseData['success'] = true;
        
        echo json_encode($responseData);
        die;
    }

    public function ajaxProcessSetIgnoreNoInvoiceNote()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        $id_order = (int)Tools::getValue('id_order');
        $ignore = Tools::getValue('ignore', null);
        $comment = Tools::getValue('comment');
        
        $comment = trim( $comment );
        
        if( !$id_order || is_null($ignore) || !strlen($comment) ){
            $responseData['message'] = 'Invalid parameters';
            echo json_encode($responseData);
            die;
        }
        
        $ignore = ($ignore == 'true' ? true : false);
        
        $order = new Order($id_order);
        if( !Validate::isLoadedObject($order) ){
            $responseData['message'] = 'Order not found';
            echo json_encode($responseData);
            die;
        }
        
        if( $ignore ){
            $order->ignore_no_invoice_note = 1;
        }
        else{
            $order->ignore_no_invoice_note = 0;
        }
        
        $order->save();
        
        if( $ignore ){
            $shopComment = new ShopComment();
            $shopComment->employee_id = $this->context->employee->id;
            $shopComment->reference_type = ShopComment::REFERENCE_TYPE_ORDER_IGNORE_NO_INVOICE;
            $shopComment->reference_id = $order->id;
            $shopComment->status = 1;
            $shopComment->date_created = date('Y-m-d H:i:s');
            $shopComment->message = $comment;
            
            try{
                $shopComment->add();
            }
            catch( Exception $e ){
                $responseData['message'] = $e->getMessage();
                echo json_encode($responseData);
                die;
            }
            
            $responseData['data']['comment'] = $shopComment->message;
        }
        
        $responseData['success'] = true;
        $responseData['data']['id_order'] = $order->id;
        $responseData['data']['ignore'] = (int)$ignore;
        $employee = new EmployeeCore( $shopComment->employee_id );
        $responseData['data']['employee'] = $employee->firstname .' '. $employee->lastname;
        
        echo json_encode($responseData);
        die;
        
    }
}
