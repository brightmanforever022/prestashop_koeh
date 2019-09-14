<?php

require_once _PS_MODULE_DIR_ .'ba_prestashop_invoice/ba_prestashop_invoice.php';
require_once _PS_MODULE_DIR_ .'ba_prestashop_invoice/includes/baorderinvoice.php';

class OrderInvoice extends OrderInvoiceCore
{
    const InvoiceFolderPath = _PS_ROOT_DIR_.'/invoices/';
    const InvoiceFolderUrl = __PS_BASE_URI__.'invoices/';
    const InvoiceReminderFolderUrl = __PS_BASE_URI__.'invoices/reminders/';
    const InvoiceReminderFolderPath = _PS_ROOT_DIR_.'/invoices/reminders/';
    
    const ReminderNotSent = 0;
    const Reminder1Sent = 1;
    const Reminder2Sent = 2;
    const Reminder3Sent = 3;
    const ReminderInkasso = 4;
    const ReminderInkasSccs = 5;
    const ReminderCredit = 10;// reminder should be never sent, this is credit invoice
    
    const AdminReminderEmailNotSent = 0;
    const AdminReminder1EmailSent = 1;
    const AdminReminder2EmailSent = 2;
    const AdminReminder3EmailSent = 3;
    
    public $template_id;
    public $due_date;
    public $paid;
    public $sum_to_pay;
    public $sum_paid;
    public $payment_date;
    public $comment;
    public $id_employee;
    public $admin_email_sent;
    public $reminder_state;
    public $reminder_date;
    public $paid_id_employee;
    public $shipped_products_only;

    public static $definition = array(
        'table' => 'order_invoice',
        'primary' => 'id_order_invoice',
        'fields' => array(
            'id_order' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'number' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'delivery_number' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'delivery_date' =>            array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
            'total_discount_tax_excl' =>array('type' => self::TYPE_FLOAT),
            'total_discount_tax_incl' =>array('type' => self::TYPE_FLOAT),
            'total_paid_tax_excl' =>    array('type' => self::TYPE_FLOAT),
            'total_paid_tax_incl' =>    array('type' => self::TYPE_FLOAT),
            'total_products' =>            array('type' => self::TYPE_FLOAT),
            'total_products_wt' =>        array('type' => self::TYPE_FLOAT),
            'total_shipping_tax_excl' =>array('type' => self::TYPE_FLOAT),
            'total_shipping_tax_incl' =>array('type' => self::TYPE_FLOAT),
            'shipping_tax_computation_method' => array('type' => self::TYPE_INT),
            'total_wrapping_tax_excl' =>array('type' => self::TYPE_FLOAT),
            'total_wrapping_tax_incl' =>array('type' => self::TYPE_FLOAT),
            'shop_address' =>        array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'size' => 1000),
            'invoice_address' =>        array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'size' => 1000),
            'delivery_address' =>        array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'size' => 1000),
            'note' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 65000),
            'date_add' =>                array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'template_id' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'due_date' =>                array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
            'paid' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'sum_to_pay' =>            array('type' => self::TYPE_FLOAT),
            'sum_paid' =>            array('type' => self::TYPE_FLOAT),
            'payment_date' =>          array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
            'comment' =>        array('type' => self::TYPE_STRING),
            'id_employee' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'reminder_state' => array('type' => self::TYPE_INT),
            'reminder_date' =>          array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
            //'admin_email_sent' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'paid_id_employee' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'shipped_products_only' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
        ),
    );
    
    protected static $invoiceIdDefault=[];
    protected static $deliveryIdDefault=[];
    protected static $invoiceNames=[];
    protected static $deliveryNames=[];
    
    
    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);
        $this->checkAndSetDefaultTemplateId();
    }
    
    public function hydrate(array $data, $id_lang = null)
    {
        parent::hydrate($data, $id_lang);
        $this->checkAndSetDefaultTemplateId();
    }

    function checkAndSetDefaultTemplateId()
    {
        if (!$this->template_id && $this->id_order)
        {
            if (!$id_lang)
            {
                // read id lang from order
                $id_lang = Db::getInstance()->getValue('select id_lang from '._DB_PREFIX_.'orders where id_order='.$this->id_order);
            }
            if ($this->delivery_number != 0)
            {
                $this->template_id = self::getDefaultDeliveryTemplateId($id_lang);
            }
            else
            {
                $this->template_id = self::getDefaultInvoiceTemplateId($id_lang);
            }
            //$this->update();
        }
    }
    
    public function add($autodate = true, $null_values = false)
    {
        if( !empty($this->template_id) ){
            $templateQuery = '
                SELECT * 
                FROM '._DB_PREFIX_.'ba_prestashop_invoice 
                WHERE id = '. intval($this->template_id) 
            ;
            $templateRow = Db::getInstance()->getRow($templateQuery);
            if( is_array($templateRow) && !empty($templateRow['id']) ){
                
                if( $templateRow['payment_type'] == BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP ){
                    $this->reminder_state = self::ReminderCredit;
                }
                
                $order = new Order($this->id_order);
                $customer = new Customer($order->id_customer);
                $invoice_address = new Address((int)$order->id_address_invoice);
                $delivery_address = new Address((int)$order->id_address_delivery);
                
                if( ($templateRow['require_vat'] == 1)
                    && (empty($customer->siret)
                        || empty($invoice_address->vat_number)
                        || empty($delivery_address->vat_number))
                ){
                    throw new PrestaShopException(Tools::displayError(
                        'VAT ID required for this invoice template, but customer data does not contain it.'
                    ));
                }
            }
        }
        
        if( !empty($this->sum_to_pay) ){
            $this->sum_paid = $this->sum_to_pay;
        }
        
        return parent::add($autodate, $null_values);
    }
    
    public function getTemplateName($langId)
    {
        self::readTemplates();
        
        // set default template id it was not already set
        if (!$this->template_id)
        {
            if ($this->is_delivery)
            {
                $this->template_id = self::getDefaultDeliveryTemplateId($langId);
            }
            else
            {
                $this->template_id = self::getDefaultInvoiceTemplateId($langId);
            }
        }
        
        if (isset($this->is_delivery) && $this->is_delivery)
        {
            // it is delivery slip
            return self::$deliveryNames[$this->template_id].' ('.$this->template_id.')';
        }
        else
        {
            return self::$invoiceNames[$this->template_id].' ('.$this->template_id.')';
        }
    }

    
    protected static function readTemplates()
    {
        if (count(self::$invoiceIdDefault) == 0)
        {
            // reading names and set default ids
            $templates = Db::getInstance()->executeS('select id, name, status, id_lang from ' . _DB_PREFIX_ . 'ba_prestashop_invoice');
            foreach ($templates as $template)
            {
                if ($template['status'])
                {
                    self::$invoiceIdDefault[$template['id_lang']] = $template['id'];
                }
                self::$invoiceNames[$template['id']] = $template['name'];
            }

            $templates = Db::getInstance()->executeS('select id, name, status, id_lang from ' . _DB_PREFIX_ . 'ba_prestashop_delivery_slip');
            foreach ($templates as $template)
            {
                if ($template['status'])
                {
                    self::$deliveryIdDefault[$template['id_lang']] = $template['id'];
                }
                self::$deliveryNames[$template['id']] = $template['name'];
            }
        }
    }

    
    static function getDefaultInvoiceTemplateId($langId)
    {
        self::readTemplates();
        return self::$invoiceIdDefault[$langId];
    }
    
    static function getDefaultDeliveryTemplateId($langId)
    {
        self::readTemplates();
        return self::$deliveryIdDefault[$langId];
    }
        
    static function getDeliveryTemplateNames()
    {
        self::readTemplates();
        return self::$deliveryNames;
    }
    
    static function getInvoiceTemplateNames()
    {
        self::readTemplates();
        return self::$invoiceNames;
    }
    
    function getProductIds()
    {
        $products = Db::getInstance()->executeS('select order_detail_id from '._DB_PREFIX_.'order_invoice_product where order_invoice_id='.
                $this->id);
        $result = [];
        foreach($products as $product)
        {
            $result[]= $product['order_detail_id'];
        }
        return $result;
    }
    
    
    /**
     * Sets list of order details included in invoice. Method for "all" products
     * @param array $orderDetailIds ids of order details that are included in invoice
     * @throws PrestaShopException
     */
    function setProductIds($orderDetailIds)
    {
        // insert products
        $sql = 'insert into '._DB_PREFIX_.'order_invoice_product (order_invoice_id, order_detail_id, shipped_qty_in_invoice) values ';
        foreach ($orderDetailIds as $orderDetailId)
        {
            $sql .= '('.$this->id.','.$orderDetailId.', 0),';
        }
        $sql{strlen($sql)-1} = ';';
        Db::getInstance()->execute($sql);
    }
    
    
    /**
     * Sets list of order details included in invoice. Method for shipped only products
     * @param array $orderDetailIds ids of order details that are included in invoice
     *    Should be passed in case if it is shipped only invoice.
     * @throws PrestaShopException
     */
    function setShippedProductIds($shippedQtys=[])
    {
        // insert products
        $sql = 'insert into '._DB_PREFIX_.'order_invoice_product (order_invoice_id, order_detail_id, shipped_qty_in_invoice) values ';
        foreach ($shippedQtys as $orderDetailId=>$shippedQty)
        {
            $sql .= '('.$this->id.','.$orderDetailId.','.$shippedQty.'),';
        }
        $sql{strlen($sql)-1} = ';';
        Db::getInstance()->execute($sql);
    }
    
    /**
     * Returns shipped products of this invoice
     * @return [orderDetailId => shipped qty in cur invoice]
     */
    function getShippedInvoiceProducts()
    {
        $result = [];
        $products = Db::getInstance()->executeS('select order_detail_id, shipped_qty_in_invoice from '._DB_PREFIX_.
                'order_invoice_product where order_invoice_id='.$this->id);
        foreach($products as $product)
        {
            $result[$product['order_detail_id']] = $product['shipped_qty_in_invoice'];
        }
        return $result;
    }
    
    
    /**
     * Calculates current quantites of shipped products not included in existing invoices
     * @param $orderDetailIds array with ids of order details for that quantities will be calculated
     * @param $filterOutZero if true zero quantities will not be returned.
     * @return [orderDetailId=>qty]
     */
    static function getShippedQtyForNewInvoice($orderDetailIds, $filterOutZero=true)
    {
        // reading quantities of already shipped and included in previous invoices products
        $previouslyIncludedQtys = self::getTotalShipOrderProduct($orderDetailIds);
        // reading current number of shipped products
        $orderDetails = Db::getInstance()->executeS('select id_order_detail, shipped from ' . _DB_PREFIX_ . 
                'order_detail where id_order_detail in ('.implode(',', $orderDetailIds) . ')');
        $invoiceQtys = [];   // quantites that will be included in invoice
        foreach ($orderDetails as $detail)
        {
            $qty = $detail['shipped'] - (isset($previouslyIncludedQtys[$detail['id_order_detail']]) ? $previouslyIncludedQtys[$detail['id_order_detail']] : 0);
            if ($qty<=0)
            {
                if ($filterOutZero)
                {
                    continue;
                }
                $qty = 0;
            }
            $invoiceQtys [$detail['id_order_detail']] = $qty;
        }
        
        return $invoiceQtys;
    }

    
    /**
     * Returns sum of shipped quantities in all invoices of order by each given order detail
     * @param type $orderDetailIds
     * @return array [id=>sum of shipped quantities in all invoices of order]
     */
    static function getTotalShipOrderProduct($orderDetailIds)
    {
        $qtys = Db::getInstance()->executeS('select order_detail_id, sum(shipped_qty_in_invoice) as qty from '._DB_PREFIX_.'order_invoice_product '.
                'where order_detail_id in ('.implode(',', $orderDetailIds).') group by order_detail_id');
        $result = [];
        foreach ($qtys as $qty)
        {
            $result[$qty['order_detail_id']] = $qty['qty'];
        }
        
        return $result;
    }

    
    public function getProductsDetail()
    {
        if ($this->shipped_products_only)
        {
            $shippedInvoiceProducts = $this->getShippedInvoiceProducts();
            
            $products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT * FROM `'._DB_PREFIX_.'order_detail` od
		LEFT JOIN `'._DB_PREFIX_.'product` p
		ON p.id_product = od.product_id
		LEFT JOIN `'._DB_PREFIX_.'product_shop` ps ON (ps.id_product = p.id_product AND ps.id_shop = od.id_shop)
		WHERE od.`id_order` = '.(int)$this->id_order.' and id_order_detail in ('.implode(',', array_keys($shippedInvoiceProducts)).')');
            foreach($products as $key=>$product)
            {
                $products[$key]['product_quantity'] = $shippedInvoiceProducts[$product['id_order_detail']];
                $products[$key]['total_price_tax_excl'] = $product['unit_price_tax_excl']*$shippedInvoiceProducts[$product['id_order_detail']];
                $products[$key]['total_price_tax_incl'] = $product['unit_price_tax_incl']*$shippedInvoiceProducts[$product['id_order_detail']];
            }
            
            return $products;
        }
        
        $productIds = $this->getProductIds();
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		SELECT *
		FROM `'._DB_PREFIX_.'order_detail` od
		LEFT JOIN `'._DB_PREFIX_.'product` p
		ON p.id_product = od.product_id
		LEFT JOIN `'._DB_PREFIX_.'product_shop` ps ON (ps.id_product = p.id_product AND ps.id_shop = od.id_shop)
		WHERE od.`id_order` = '.(int)$this->id_order.
                (!empty($productIds)?' and id_order_detail in ('.implode(',', $productIds).')':''));
		//.($this->id && $this->number ? ' AND od.`id_order_invoice` = '.(int)$this->id : ''));
    }
    
    /**
     * @return string path there invoice file should be stored (independent if it saved or not). 
     * If object is not initialized returns empty string
     */
    function getInvoiceFilePath()
    {
        $fileName = $this->getInvoiceFileName();
        if (!empty($fileName))
        {
            return self::InvoiceFolderPath.$fileName;
        }
    }
    
    
    /**
     * returns just name of invoice file. If object is not initialized returns empty string
     */
    function getInvoiceFileName()
    {
        if ($this->id_order && $this->id && $this->template_id)
        {
            if ($this->delivery_number != 0)
            {
                $prefix = 'LS_'.$this->delivery_number;
            }
            else
            {
                switch ($this->getInvoiceType())
                {
                    case BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP:
                        $prefix = 'GS';
                        break;
                    case BaOrderInvoice::PAYMENT_TYPE_ORDER_CONFIRM:
                        $prefix = 'AB';
                        break;
                    default:
                        $prefix = 'RE';
                }
                $prefix .= '_'.$this->number;
            }
            return $prefix.'_'.$this->id_order.'_'.$this->id.'.pdf';
        }
    }
    
    
    /**
     * Returns type constant of this invoice
     */
    function getInvoiceType()
    {
        include_once _PS_MODULE_DIR_.'ba_prestashop_invoice/includes/baorderinvoice.php';
        return Db::getInstance()->getValue('select payment_type from '._DB_PREFIX_.'ba_prestashop_invoice where id='.$this->template_id);
    }
    
    
    /**
     * Checks if file was generated and gives link on it.
     * @returns url of generated file or false if file was yet generated
     */
    function getInvoiceFileLink()
    {
        $path = $this->getInvoiceFilePath();
        if (empty($path) || !file_exists($path))
        {
            return false;
        }
        
        return self::InvoiceFolderUrl.$this->getInvoiceFileName();
    }
    
    
    function delete()
    {
        if (empty($this->number))
        {
            // this means current object is not created/constructed
            $orderInvoice = new OrderInvoice($this->id);
            $filePath = $orderInvoice->getInvoiceFilePath();
        }
        else
        {
            $filePath = $this->getInvoiceFilePath();
        }
        OrderInvoiceProduct::deleteInvoiceProducts($this->id);
        return parent::delete() && unlink($filePath);
    }
    
    
    /**
     * Set paid status for several invoices
     * @param array $ids array with ids of invoices for that stus need to be set
     * @param bool $paid paid status, true if paid
     */
    public static function setPaidState(array $ids, $paid)
    {
        Db::getInstance()->execute('update '._DB_PREFIX_.'order_invoice set paid='.($paid?'1, payment_date=\''.date('Y-m-d H:i:s').'\'':'0').
                ' where id_order_invoice in ('.implode(',', $ids).')');
    }
    
    
    /**
     * 
     * @return new/current state
     */
    function toggleInvoicePaidState()
    {
        $this->paid = $this->paid?0:1;
        $this->paid_id_employee = Context::getContext()->employee->id;
        if ($this->paid)
        {
            $this->payment_date = date('Y-m-d H:i:s');
        }
        $this->update(); 
        
        return $this->paid;
    }
    
    
    static function setReminderStatus($invoiceIds, $status)
    {
        $dbData = array(
            'reminder_state' => $status,
            'reminder_date' => date('Y-m-d')
        );
        
        $reminder2Fee = intval(Configuration::get('dpReminder2Fee'));
        
        if( $reminder2Fee && ($status == 2) ){
            $dbData['reminder_fee'] = $reminder2Fee;
            $dbData['sum_paid'] = array(
                'type' => 'sql', 'value' => 'sum_paid + '. $reminder2Fee
            );
        }
        
        Db::getInstance()->update('order_invoice', $dbData, 'id_order_invoice IN('. implode(',', $invoiceIds) .')');
        
        /*Db::getInstance()->execute('update ' . _DB_PREFIX_ . 'order_invoice set reminder_state=' . $status .
                        ', reminder_date=\'' . date('Y-m-d') . '\' where id_order_invoice in(' . implode(',', $invoiceIds) .
                        ')');*/
    }
    
    
    static function saveComment($id, $comment)
    {
        return Db::getInstance()->execute('update ' . _DB_PREFIX_ . 'order_invoice set comment=\''.addslashes($comment).
                '\' where id_order_invoice='.$id);
    }
    
    
    /**
     * Returns path to saved reminder file, if $checkExistance true returns empty string if file doen't exist, in case if
     * $checkExistance is false returns path anyway, even if file doesn't exist
     * @param type $invoiceId
     * @param type $reminderNum
     * @param type $checkExistance
     */
    static function getReminderFilePath($invoiceId, $reminderNum, $langId, $checkExistance=true)
    {
        $filePath = self::InvoiceReminderFolderPath.self::getReminderFileName($invoiceId, $reminderNum, $langId);
        if ($checkExistance && !file_exists($filePath))
        {
            return '';
        }
        
        return $filePath;
    }
    
    
    static function getReminderFileName($invoiceId, $reminderNum, $langId)
    {
        return $invoiceId.'_'.$reminderNum.'_'.Language::getIsoById($langId).'.pdf';
    }
    
    
    /**
     * Returns url to saved reminder file, if $checkExistance true returns empty string if file doen't exist, in case if
     * $checkExistance is false returns path anyway, even if file doesn't exist
     * @param type $invoiceId
     * @param type $reminderNum
     * @param type $checkExistance
     */
    static function getReminderFileUrl($invoiceId, $reminderNum, $langId, $checkExistance=true)
    {
        if ($checkExistance && self::getReminderFilePath($invoiceId, $reminderNum, $langId, $checkExistance)==false)
        {
            return '';
        }
        
        return self::InvoiceReminderFolderUrl.self::getReminderFileName($invoiceId, $reminderNum, $langId);
    }
    
    
    /**
     * Generates pdf reminder and saves it in reminders folder
     * @param type $invoiceId
     * @param type $reminderNum
     * @return string full path to generated file
     */
    static function generateReminder($invoice, $reminderNum, $langId)
    {
        $context = Context::getContext();
        // generate pdf
        $pdfRenderer = new PDFGenerator((bool) Configuration::get('PS_PDF_USE_CACHE'), '','A4', 0, '', 15, 15, 16,0,9,9);
        // $pdfRenderer->SetMargins(50, 10, 10); 
        $langIso = Language::getIsoById($langId);
        $pdfRenderer->setFontForLang($langIso);
        
        $reminderFee = 0;
        $invoiceSumToPayWithFees = $invoice['sum_paid'];
        if( !empty($invoice['reminder_fee']) ){
            $reminderFee = $invoice['reminder_fee'];
            $invoiceSumToPayWithFees += $reminderFee;
        }

        // assign data
        $template_vars = array(
            'customerFirstName' => $invoice['firstname'],
            'id_currency' => $invoice['id_currency'],
            'customerLastName' => $invoice['lastname'],
            'customerSalutation' => $invoice['salutation'] ? $invoice['salutation'] : 'Frau',
            'customerAddr1' => $invoice['address1'],
            'customerAddr2' => $invoice['address2'],
            'customerCity' => $invoice['city'],
            'customerPostcode' => $invoice['postcode'],
            'customerCountry' => $invoice['countryName'],
            'customerCompany' => $invoice['company'],
            'currentDate' => Tools::displayDateLang(date('Y-m-d'), $langId),
            'invoiceNumber' => sprintf('%1$s%2$06d', Configuration::get('PS_INVOICE_PREFIX', $langId, null, $context->shop->id), $invoice['number']),
            'invoiceDate' => Tools::displayDateLang($invoice['invoice_date'], $langId),
            // used 'sum_paid', since it is indicate how much left to pay
            'invoiceSumToPay' => Tools::displayPrice( $invoice['sum_paid'], intval($invoice['id_currency'])),
            'today10' => Tools::displayDateLang(date('Y-m-d', time() + 10 * 3600 * 24), $langId),
            'reminderFee' => Tools::displayPrice( $reminderFee, intval($invoice['id_currency']) ),
            'invoiceSumToPayWithFees' => Tools::displayPrice( $invoiceSumToPayWithFees, intval($invoice['id_currency']))
        );

        $template_raw_html = array();
        $template_raw_html['header'] =
            file_get_contents(_PS_MODULE_DIR_ . 'product_list/views/templates/reminders/'.$langIso.'/header.tpl')
        ;
        $template_raw_html['footer'] =
            file_get_contents(_PS_MODULE_DIR_ . 'product_list/views/templates/reminders/'.$langIso.'/footer.tpl')
        ;
        $template_raw_html['content'] =
            file_get_contents(_PS_MODULE_DIR_ . 'product_list/views/templates/reminders/'.$langIso.'/top_address.tpl')
            .file_get_contents(_PS_MODULE_DIR_ . 'product_list/views/templates/reminders/'.$langIso.'/reminder' . $reminderNum . '.tpl')
        ;
        
        foreach( $template_raw_html as &$template_part ){
            foreach($template_vars as $serach => $replace){
                $template_part = str_replace('['.$serach.']', $replace, $template_part);
            }
        }
        unset($template_part);
        
        $stylesContent = '<style>'
            . "\n\r"
            . file_get_contents(_PS_MODULE_DIR_ . 'product_list/views/templates/reminders/'.$langIso.'/styles.css')
            . "\n\r"
            . '</style>'
            . "\n\r"
        ;

        $template_raw_html['content'] = $stylesContent . $template_raw_html['content'];
        $pdfRenderer->createHeader( $template_raw_html['header'] );
        $pdfRenderer->createFooter($template_raw_html['footer'], true);
        $pdfRenderer->createContent($template_raw_html['content']);
        
        $pdfRenderer->writePage();
        
        // clean the output buffer
        if (ob_get_level() && ob_get_length() > 0)
        {
            ob_clean();
        }
        $filePath = self::getReminderFilePath($invoice['id_order_invoice'], $reminderNum, $langId, false);
        $pdfRenderer->render($filePath, 'F');
        
        return $filePath;
    }
}
/**
ALTER TABLE `prs_order_invoice` ADD `paid_id_employee` INT NOT NULL AFTER `reminder_fee`;
 */