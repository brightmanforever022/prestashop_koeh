<?php

require_once _PS_MODULE_DIR_ .'ba_prestashop_invoice/ba_prestashop_invoice.php';
require_once _PS_MODULE_DIR_ .'ba_prestashop_invoice/includes/baorderinvoice.php';
include_once _PS_MODULE_DIR_ .'shopcomments/classes/ShopComment.php';
require_once _PS_TOOL_DIR_ . 'php_excel/PHPExcel.php';

/**
 * Admin tab controller
 */
class AdminDiffPaymentsController extends ModuleAdminController
{
    var $reminderStates;
    
    public function __construct()
    {
        $this->reminderStates = [
            OrderInvoice::ReminderNotSent=>$this->l('Not sent'), 
            OrderInvoice::Reminder1Sent=>$this->l('1. Reminder'), 
            OrderInvoice::Reminder2Sent=>$this->l('2. Reminder'), 
            OrderInvoice::Reminder3Sent=>$this->l('3. Reminder'), 
            OrderInvoice::ReminderInkasso=>$this->l('Inkasso'),
            OrderInvoice::ReminderCredit => $this->l('Credit note'),
            OrderInvoice::ReminderInkasSccs => $this->l('Abgeschrieben/Inkasso n. Erfolgr.'),
        ];
        
        $this->module = 'product_list';
        $this->bootstrap = true;
        $this->list_no_link = true;
        $this->explicitSelect = true;
        $this->_defaultOrderBy = 'id_order_invoice';
        $this->_defaultOrderWay = 'desc';
        $this->_where = 'and a.number>0';
        $this->identifier = 'id_order_invoice';
        /*
        $this->_where = 'and a.active=1';
        $this->imageType = 'jpg';
        $this->_defaultOrderBy = 'product_supplier_reference';
        */
        parent::__construct();

        // configure list 
        $this->className = 'OrderInvoice';
        $this->table = 'order_invoice';
        
        $this->_select = 'a.id_order_invoice, \'\' as reminder_files, a.id_order, number, reminder_state, a.paid, sum_to_pay, '
                . 'due_date, payment_date, o.id_customer, a.template_id AS invoice_template_id, '.
                'reminder_date, c.firstname, c.lastname, c.company, c.postcode, c.email, c.city, 
                c.address1, c.address2, c.phone_mobile, c.phone,
                a.date_add, a.total_paid_tax_incl, o.current_state, osl.name as osname, '
                . 'os.color, o.id_currency, cl.name as countryname, va.vat_number,'
                . ' concat(e.firstname, \' \',e.lastname) as employee_name, 
                bai.name AS invoice_tmpl_name , o.id_address_invoice,
                concat(ep.firstname, \' \',ep.lastname) as paid_employee_name,
                ccl.name AS cst_cntr_name
        ';
        //, cl.name as countryname
        $this->_join = ' 
            left join '._DB_PREFIX_.'orders o on o.id_order=a.id_order 
            left join '._DB_PREFIX_.'customer c on c.id_customer=o.id_customer 
            LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (o.`current_state` = osl.`id_order_state` '
                . 'AND osl.`id_lang` = '.(int)$this->context->language->id.') 
            LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = o.`current_state`) 
            right join (SELECT * from '._DB_PREFIX_.'address group by id_customer) ad ON c.id_customer=ad.id_customer 
            left join '._DB_PREFIX_.'country_lang cl ON (ad.id_country=cl.id_country AND cl.id_lang='.(int)$this->context->language->id.') 
            LEFT JOIN `'._DB_PREFIX_.'address` va ON va.id_address = o.id_address_invoice 
            LEFT JOIN `'._DB_PREFIX_.'employee` e ON e.id_employee = a.id_employee
            LEFT JOIN `'._DB_PREFIX_.'ba_prestashop_invoice` bai ON a.template_id = bai.id 
            left join '._DB_PREFIX_.'employee ep on ep.id_employee=a.paid_id_employee
            LEFT JOIN `'._DB_PREFIX_.'country_lang` ccl ON (c.`id_country` = ccl.`id_country` AND ccl.`id_lang` = '.(int)$this->context->language->id.')
        ';
        //left join '._DB_PREFIX_.'address ad ON c.id_customer=ad.id_customer left join '._DB_PREFIX_.'country_lang cl ON (ad.id_country=cl.id_country AND cl.id_lang='.(int)$this->context->language->id.')
        /*
                ' left join ' . _DB_PREFIX_ . 'product_attribute pa on pa.id_product=a.id_product left join ' . _DB_PREFIX_ .
                'stock_available sa on sa.id_product=a.id_product and sa.id_product_attribute=0 and sa.id_shop=' . $this->context->shop->id .
                ' left join ' . _DB_PREFIX_ . 'stock_available sa1 on sa1.id_product=a.id_product and sa1.id_product_attribute=' .
                'pa.id_product_attribute and sa1.id_shop=' . $this->context->shop->id.' left join ' . _DB_PREFIX_ .
                'product_attribute_combination pac on pa.id_product_attribute=pac.id_product_attribute left join ' . _DB_PREFIX_ .
                'attribute_lang al on al.id_attribute=pac.id_attribute and al.id_lang=' . $this->context->language->id.
                ' left join ' . _DB_PREFIX_ . 'image i on i.id_product=a.id_product and cover=1 left join ' . _DB_PREFIX_ . 
                'product_supplier ps on a.id_product=ps.id_product and ps.id_product_attribute=0 left join ' . _DB_PREFIX_ .
                'supplier s on s.id_supplier=ps.id_supplier';*/

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
        $this->_join .= ' LEFT JOIN ('. $overduedRemindersSubquery .') odi ON odi.id_customer = o.id_customer ';
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
    		) AS cst_ink ON cst_ink.id_customer = o.id_customer
        ';
        
        
        $this->fields_list = array();
        $this->fields_list['id_order_invoice'] = array(
            'title' => $this->l('ID'),
            'align' => 'center',
            'class' => 'fixed-width-xs',
            'type' => 'int',
        );
        $this->fields_list['number'] = array(
            'title' => $this->l('Number'),
            'align' => 'center',
            'class' => 'fixed-width-xs',
            'callback' => 'showInvoiceNumber',
            'type' => 'int'
        );
        $this->fields_list['a!id_order'] = array(
            'title' => $this->l('Order Id'),
            'align' => 'center',
            'class' => 'fixed-width-xs',
            'type' => 'int',
            'filter_key' => 'a!id_order',
            'callback' => 'showOrderId'
        );
        
        $this->fields_list['c!lastname'] = array(
            'title' => $this->l('Customer lastname'),
            'align' => 'left',
            'filter_key' => 'c!lastname',
        );
        $this->fields_list['o!id_customer'] = array(
            'title' => $this->l('Cust.ID'),
            'align' => 'left',
            'filter_key' => 'o!id_customer',
        );
        
        $this->fields_list['cst_cntr_name'] = array(
            'title' => $this->l('Country'),
            //'align' => 'left',
            'filter_key' => 'c!id_country',
            'type' => 'select',
            'list' => $this->getCountriesListForFilter(),
            'filter_type' => 'multiint',
            'order_key' => 'ccl!name',
            'multiple' => true,
            'width' => '100',
            'multipleWidth' => '200',
            'id' => 'cst_cntr_name'
        );
        $this->fields_list['c!company'] = array(
            'title' => $this->l('Company'),
            'align' => 'left',
            'filter_key' => 'c!company',
            'callback' => 'formatListCompany',
        );
        $this->fields_list['vat_number'] = array(
            'title' => $this->l('VAT ID'),
            'align' => 'left',
            'filter_key' => 'va!vat_number',
        );
        
        // reading order states
        $statuses = OrderState::getOrderStates((int)$this->context->language->id);
        foreach ($statuses as $status) {
            $statusesArray[$status['id_order_state']] = $status['name'];
        }
        $this->fields_list['osname'] = array(
                'title' => $this->l('Order status'),
                'type' => 'select',
                'color' => 'color',
                'list' => $statusesArray,
                'filter_key' => 'o!current_state',
                'filter_type' => 'int',
                'order_key' => 'osname'
            );
        $this->fields_list['date_add'] = array(
                'title' => $this->l('Invoice Date'),
                'align' => 'text-right',
                'type' => 'date',
                'filter_key' => 'a!date_add'
            );
        $this->fields_list['due_date'] = array(
                'title' => $this->l('Due Date'),
                'align' => 'text-right',
                'type' => 'date',
                'filter_key' => 'due_date',
            'class' => 'dueDate'
            );
        $this->fields_list['payment_date'] = array(
                'title' => $this->l('Payment Date'),
                'align' => 'text-right',
                'type' => 'date',
                'filter_key' => 'payment_date'
            );
        $this->fields_list['sum_to_pay'] = array(
            'title' => $this->l('Invoice amount'),
            'align' => 'text-right',
            'type' => 'price',
            'currency' => true,
            'callback' => 'setOrderCurrency',
            'badge_success' => true,
            //'class' => 'sumToPay'
        );
        $this->fields_list['sum_paid'] = array(
            'title' => $this->l('Due amount'),
            'align' => 'text-right',
            'type' => 'price',
            'currency' => true,
            'callback' => 'setOrderCurrency',
            'badge_success' => true,
            'class' => 'sumToPay'
        );
        
        $this->fields_list['note'] = array(
            'title' => $this->l('Comment'),
            //'filter_key' => 'a!comment',
            'search' => false,
            'align' => 'text-center',
            'type' => 'text',
            //'class' => 'invoiceComment',
            'class' => 'note invoiceComment',
            'orderby' => false,
            'callback' => 'showComment'
        );
        $this->fields_list['a!paid'] = array(
            'title' => $this->l('Paid'),
            'filter_key' => 'a!paid',
            'align' => 'text-center',
            'type' => 'bool',
            'class' => 'fixed-width-sm',
            'order_key' => 'a!payment_date',
            'callback' => 'showPaidColumn'
        );
        $this->fields_list['reminder_date'] = array(
                'title' => $this->l('Reminder Date'),
                'align' => 'text-right',
                'type' => 'date',
                'filter_key' => 'reminder_date'
            );
        $this->fields_list['reminder_state'] = array(
                'title' => $this->l('Reminder state'),
                'type' => 'select',
                'list' => $this->reminderStates,
                'filter_key' => 'reminder_state',
                //'filter_type' => 'int',
                'multiple' => true,
                'filter_type' => 'multiint',
                'width' => '100',
                'callback' => 'showReminderState',
                'multipleWidth' => '200',
                'id' => 'reminder_state'
            );
        $this->fields_list['reminder_files'] = array(
                'title' => $this->l('Reminder files'),
                'type' => 'text',
                'orderby' => false,
                'search' => false,
                'callback' => 'showReminderFiles'
            );
        
        // add bulk actions
        $this->bulk_actions = array();
        if( $this->tabAccess['edit'] == '1' ){
            $this->bulk_actions = $this->bulk_actions + array(
                'setInvoicesPaid' => array('text' => $this->l('Set invoices paid'), 'icon' => 'icon-check'),
                'setInvoicesNotPaid' => array('text' => $this->l('Set invoices not paid'), 'icon' => 'icon-remove'),
                'sendReminder1de' => array('text' => $this->l('Send de reminder 1'), 'targetBlank'=>'genReminder1de'),
                'sendReminder2de' => array('text' => $this->l('Send de reminder 2'), 'targetBlank'=>'genReminder2de'),
                'sendReminder3de' => array('text' => $this->l('Send de reminder 3'), 'targetBlank'=>'genReminder3de'),
                'sendReminder1en' => array('text' => $this->l('Send en reminder 1'), 'targetBlank'=>'genReminder1en'),
                'sendReminder2en' => array('text' => $this->l('Send en reminder 2'), 'targetBlank'=>'genReminder2en'),
                'sendReminder3en' => array('text' => $this->l('Send en reminder 3'), 'targetBlank'=>'genReminder3en'),
                'setInkasso' => array('text' => $this->l('Set Inkasso status')),
                'setInkasSccs' => array('text' => $this->l('Set Abgeschreiben/Inkasso n. Erfolgr.'),),
            );
        }
        elseif( $this->tabAccess['edit'] == '0' ){
            
        }
        $this->bulk_actions = $this->bulk_actions + array(
            'exportCsv' => array('text' => $this->l('Export to CSV'))
        );

        if( class_exists('ShopComment') ){
            $this->_select .= ', IF(object_comment.id, "CMNT_YES", "CMNT_NO") AS note';
            $this->_join .= '
                LEFT JOIN (
                    SELECT id, reference_id
                    FROM `'._DB_PREFIX_.'shop_comment`
                    WHERE `reference_type` = '. ShopComment::REFERENCE_TYPE_DIFFPMNT .'
                    GROUP BY reference_type, reference_id
                ) AS object_comment ON object_comment.reference_id = a.id_order_invoice
            ';
        }
        
        // workaround for profiles that does not have 'edit' permissions, but have 'view' permissions
        $actionTreatAsViewList = array('submitBulkexportCsvorder_invoice');
        foreach($actionTreatAsViewList as $actionTreatAsView){
            if( in_array($actionTreatAsView, array_keys($_GET)) && ($this->tabAccess['view'] == 1) && ($this->tabAccess['edit'] == '0')){
                $this->tabAccess['edit'] = '1';
            }
        }
        
        
        $this->context->smarty->assign(array(
            'invoice_payment_type_options' => BaOrderInvoice::getPaymentTypes(),
            'invoice_payment_type_selected' => array(),
            'tab_access' => $this->tabAccess
        ));
        
    }

    protected function getCountriesListForFilter()
    {
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
			SELECT DISTINCT c.id_country, cl.`name`
			FROM `'._DB_PREFIX_.'orders` o
			'.Shop::addSqlAssociation('orders', 'o').'
			INNER JOIN `'._DB_PREFIX_.'address` a ON a.id_address = o.id_address_delivery
			INNER JOIN `'._DB_PREFIX_.'country` c ON a.id_country = c.id_country
			INNER JOIN `'._DB_PREFIX_.'country_lang` cl ON (c.`id_country` = cl.`id_country` AND cl.`id_lang` = '.(int)$this->context->language->id.')
			ORDER BY cl.name ASC
        ');
        
        $country_array = array();
        foreach ($result as $row) {
            $country_array[$row['id_country']] = $row['name'];
        }
        
        return $country_array;
    }
    
    function formatListCompany($field, $row)
    {
        if( $row['has_overdued_invoices'] ){
            return '<span class="label" style="background-color:#CC3300;">' . $field . '</span>';
        }
        else{
            return $field;
        }
    }
    
    function processResetFilters($list_id = null)
    {
        unset($this->context->cookie->plmSizesFilter);
        parent::processResetFilters($list_id);
    }
    
       
    function showInvoiceNumber($field, $row)
    {
        
        return '<a href="'.$this->context->link->getAdminLink('AdminPdf').'&submitAction=generateInvoicePDF&id_order_invoice='.
                $row['id_order_invoice'].'" target="_blank" title="'. htmlspecialchars($row['invoice_tmpl_name']) .'" data-toggle="tooltip" class="label-tooltip">'.
                sprintf('%1$s%2$06d', Configuration::get('PS_INVOICE_PREFIX', $this->context->language->id, null, $this->context->shop->id), 
                $field).'</a>';
    }
  
    
    function showOrderId($field, $row)
    {
        return '<a href="'.$this->context->link->getAdminLink('AdminOrders').'&id_order='.$field.'&vieworder" target="_blank">'.$field.'</a>';
    }
    
    
    function showReminderState($field, $row)
    {
        return $this->reminderStates[$field];
    }
    
    
    function showComment($note, $row)
    {
        $notesHtml = '';
        
        $notes = ShopComment::getDiffpayComments($row['id_order_invoice']);
        if( is_array($notes) && count($notes) ){
            $notesHtml .= '<table class="table table-condensed">';
            $notesHtml .= '
            	<tr>
            		<th>'. $this->l('Employee') .'</th>
            		<th>'. $this->l('Date') .'</th>
            		<th>'. $this->l('Comment') .'</th>
            	</tr>
            ';
            foreach($notes as $noteData){
                $notesHtml .= '
                	<tr>
                		<td>'. $noteData['employee_name'] .'</td>
                		<td>'. Tools::displayDate($noteData['date_created']) .'</td>
                		<td>'. $noteData['message'] .'</td>
                	</tr>
                ';
            }
            $notesHtml .= '</table>';
        }
        
        $customerComments = ShopComment::getCustomerComments($row['id_customer'], 1);
        if( is_array($customerComments) && count($customerComments) ){
            $notesHtml .= '&nbsp;<i title="View customer notes" class="icon-comments customer-comments" data-reference_id="'. $row['id_customer'] .'" data-reference_type="'. ShopComment::REFERENCE_TYPE_CUSTOMER .'"></i>';
            $notesHtml .= '<table hidden class="table table-condensed shop-comments-table"
                data-reference_id="'.$row['id_customer'].'" data-reference_type="'. ShopComment::REFERENCE_TYPE_CUSTOMER .'">';
            $notesHtml .= '
            	<tr>
            		<th>'. $this->l('Employee') .'</th>
            		<th>'. $this->l('Date') .'</th>
            		<th>'. $this->l('Comment') .'</th>
            	</tr>
            ';
            foreach($customerComments as $noteData){
                $notesHtml .= '
                	<tr data-comment_id="'. $noteData['id'] .'">
                		<td>'. $noteData['employee_name'] .'</td>
                		<td>'. Tools::displayDate($noteData['date_created']) .'</td>
                		<td>'. $noteData['message'] .'</td>
                	</tr>
                ';
            }
            $notesHtml .= '</table>';

        }
        
        
        return $notesHtml;
        
        //return nl2br($field);
        //return $note == 'CMNT_YES' ? '<i class="icon-table"></i>' : '&nbsp;';
    }
    
    
    function showPaidColumn($field, $row)
    {
        $result = '<a href="#" class="documentPaidChangeLink list-action-enable ';
        if ($field)
        {
            $result .= 'action-enabled label-tooltip" data-toggle="tooltip"
                title="At '. Tools::displayDate($row['payment_date'], null, 1) .' by '. $row['paid_employee_name'] .'"
                ><i class="icon-check"></i>';
        }
        else 
        {
            $result .= 'action-disabled"><i class="icon-remove"></i>';
        }
        $result .= '</a>';
        return $result;
    }
    
    
    function showReminderFiles($field, $row)
    {
        $result = '';
        $languages = [Language::getIdByIso('de'), Language::getIdByIso('en')];
        for($i=1; $i<4; $i++)
        {
            foreach ($languages as $lang)
            {
                if ($url = OrderInvoice::getReminderFileUrl($row['id_order_invoice'], $i, $lang, true))
                {
                    if ($result)
                    {
                        $result .= ' | ';
                    }
                    $result .= '<a href="' . $this->context->link->getAdminLink('AdminDiffPayments') . '&getPdfReminder&invoice_id=' .
                            $row['id_order_invoice'] . '&num=' . $i . '&id_lang='.$lang.'">' . basename($url) . '</a>';
                }
            }
        }
        
        return $result;
    }
    
    
    public static function setOrderCurrency($echo, $tr)
    {
        return Tools::displayPrice($echo, (int)$tr['id_currency']);
    }
    
    public function processBulkExportCsv()
    {
        $invoiceIds = Tools::getValue('order_invoiceBox', []);
        
        if( !count($invoiceIds) ){
            return;
        }
        
        if (ob_get_level() && ob_get_length() > 0) {
            ob_clean();
        }
        
        $this->_where .= ' AND a.id_order_invoice IN('. implode(',', $invoiceIds) .') ';
        
        $this->getList($this->context->language->id, null, null, 0, false);
        if (!count($this->_list)) {
            return;
        }
        
        $columns = array(
            'number' => $this->l('Number'),
            'a!id_order' => $this->l('Order Id'),
            'c!lastname' => $this->l('Customer lastname'),
            'email' => $this->l('Email'),
            'o!id_customer' => $this->l('Cust.ID'),
            'id_address_invoice' => $this->l('Addr. inv. ID'),
            'cl!name' => $this->l('Country'),
            'postcode' => $this->l('Postcode'),
            'address1' => $this->l('Address 1'),
            'address2' => $this->l('Address 2'),
            'city' => $this->l('City'),
            'phone' => $this->l('Phone'),
            'phone_mobile' => $this->l('Fax'),
            'c!company' => $this->l('Company'),
            'vat_number' => $this->l('VAT ID'),
            'date_add' => $this->l('Invoice Date'),
            'due_date' => $this->l('Due Date'),
            'sum_to_pay' => $this->l('Invoice amount'),
            'sum_paid' => $this->l('Due amount'),
            'a!paid' => $this->l('Paid')
        );
        
        $headers = array_values($columns);
        
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()
            ->setCreator($this->context->shop->name .' ('. $this->context->shop->domain .')')
            ->setLastModifiedBy($this->context->shop->name.' ('. $this->context->shop->domain .')')
            ->setTitle("Diff payments")
        ;
        
        $objPHPExcel->setActiveSheetIndex(0);
        $rowNumber = 0;
        $rowNumber++;
        $colCharNum = ord('A');
        foreach($headers as $header){
            $objPHPExcel
            ->getActiveSheet()
            ->setCellValue( (chr($colCharNum++).$rowNumber), $header)
            ;
        }
        
        foreach($this->_list as $dbRec){
            $rowNumber++;
            $colCharNum = ord('A');
        
            foreach($columns as $fieldName => $fieldOptions){
                $cellValue = $dbRec[$fieldName];
                if( in_array($fieldName, array('date_add','due_date')) ){
                    $cellValue = Tools::displayDate( $dbRec[$fieldName], $this->context->language->id, false );
                }
                elseif( in_array($fieldName, array('sum_to_pay','sum_paid')) ){
                    $cellValue = number_format( $dbRec[$fieldName], 2, '.', '' );
                }
                
                $objPHPExcel
                    ->getActiveSheet()
                    ->setCellValue( (chr($colCharNum++).$rowNumber), $cellValue)
                ;
            }
        }
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Diff payments');
        
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Diff_payments_'.date('Y-m-d_His').'.xlsx"');
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
     
    function postProcess()
    {
        if( ($_SERVER['REQUEST_METHOD'] == 'POST') && $this->tabAccess['edit'] == '0' ){
            $this->errors[] = $this->module->l('You do not have permissions to edit this');
            return;
        }
        
        if (Tools::isSubmit('submitBulksetInvoicesPaidorder_invoice') || Tools::isSubmit('submitBulksetInvoicesNotPaidorder_invoice'))
        {
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                OrderInvoice::setPaidState($invoiceIds, Tools::isSubmit('submitBulksetInvoicesPaidorder_invoice')?1:0);
            }
        }
        elseif(Tools::isSubmit('genReminder1de'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                
                $this->generatePdfReminder(1, $invoiceIds, Language::getIdByIso('de'));
            }
            else
            {
                echo $this->l('No invoices selected');
                exit;
            }
        }
        elseif(Tools::isSubmit('genReminder1en'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                
                $this->generatePdfReminder(1, $invoiceIds, Language::getIdByIso('en'));
            }
            else
            {
                echo $this->l('No invoices selected');
                exit;
            }
        }
        elseif(Tools::isSubmit('submitBulksendReminder1deorder_invoice') || Tools::isSubmit('submitBulksendReminder1enorder_invoice'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                                  
                // set new status
                OrderInvoice::setReminderStatus($invoiceIds, OrderInvoice::Reminder1Sent);
                Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
            }
        }
        elseif(Tools::isSubmit('genReminder2de'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                
                $this->generatePdfReminder(2, $invoiceIds, Language::getIdByIso('de'));
            }
            else
            {
                echo $this->l('No invoices selected');
                exit;
            }
        }
        elseif(Tools::isSubmit('genReminder2en'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                
                $this->generatePdfReminder(2, $invoiceIds, Language::getIdByIso('en'));
            }
            else
            {
                echo $this->l('No invoices selected');
                exit;
            }
        }
        elseif(Tools::isSubmit('submitBulksendReminder2deorder_invoice') || Tools::isSubmit('submitBulksendReminder2enorder_invoice'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                                  
                // set new status
                OrderInvoice::setReminderStatus($invoiceIds, OrderInvoice::Reminder2Sent);
                Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
            }
        }
        elseif(Tools::isSubmit('genReminder3de'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                
                $this->generatePdfReminder(3, $invoiceIds, Language::getIdByIso('de'));
            }
            else
            {
                echo $this->l('No invoices selected');
                exit;
            }
        }
        elseif(Tools::isSubmit('genReminder3en'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                
                $this->generatePdfReminder(3, $invoiceIds, Language::getIdByIso('en'));
            }
            else
            {
                echo $this->l('No invoices selected');
                exit;
            }
        }
        elseif(Tools::isSubmit('submitBulksendReminder3deorder_invoice') || Tools::isSubmit('submitBulksendReminder3enorder_invoice'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                                  
                // set new status
                OrderInvoice::setReminderStatus($invoiceIds, OrderInvoice::Reminder3Sent);
                Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
            }
        }
        elseif(Tools::isSubmit('submitBulksetInkassoorder_invoice'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
                                  
                // set new status
                OrderInvoice::setReminderStatus($invoiceIds, OrderInvoice::ReminderInkasso);
                Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
            }
        }
        elseif(Tools::isSubmit('submitBulksetInkasSccsorder_invoice'))
        {
            // prepare ids
            $invoiceIds = Tools::getValue('order_invoiceBox', []);
            if (count($invoiceIds))
            {
                array_walk($invoiceIds, function(&$item, $key){ $item = intval($item); });
        
                // set new status
                OrderInvoice::setReminderStatus($invoiceIds, OrderInvoice::ReminderInkasSccs);
                Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
            }
        }
        
        elseif(Tools::isSubmit('getPdfReminder'))
        {
            $filePath = OrderInvoice::getReminderFilePath(intval(Tools::getValue('invoice_id')), intval(Tools::getValue('num')), 
                    intval(Tools::getValue('id_lang')));
            
            if (!empty($filePath))
            {
                header("Content-type: application/pdf");
                header("Content-Disposition: attachment; filename=".basename($filePath));

                readfile($filePath);
            }
            else
            {
                echo $this->l('Error: file "'.$filePath.'" not found');
            }
            exit;
        }
        
        parent::postProcess();
    }
    
    
    function ajaxProcessSaveInvoiceComment()
    {
        if (!OrderInvoice::saveComment(intval(Tools::getValue('id')), Tools::getValue('comment')))
        {
                die(json_encode(['error'=>$this->l('Error occured, comment not saved')]));
        }
        die(Tools::jsonEncode(array(
                'error' => 0,
            )));
    }
    
    
    function generatePdfReminder($reminderNum, $invoiceIds, $langId)
    {
        // reading data
        $invoices = Db::getInstance()->executeS('select id_order_invoice, sum_to_pay, number, c.firstname, c.lastname, c.address1, c.company, ' .
                'c.address2, c.city, c.postcode, o.id_lang, oi.date_add as invoice_date, gl.name as salutation, cl.name as countryName, ' .
                'o.id_currency, sum_paid from ' . _DB_PREFIX_ .
                'order_invoice oi left join ' . _DB_PREFIX_ . 'orders o on o.id_order=oi.id_order left join ' . _DB_PREFIX_ . 'customer c ' .
                'on c.id_customer=o.id_customer left join ' . _DB_PREFIX_ . 'gender_lang gl on c.id_gender=gl.id_gender and gl.id_lang=' .
                'o.id_lang left join ' . _DB_PREFIX_ . 'address a on o.id_address_invoice=a.id_address left join ' .
                _DB_PREFIX_ . 'country_lang cl on cl.id_country=a.id_country and cl.id_lang=' .
                $langId . ' where id_order_invoice in (' . implode(',', $invoiceIds) . ')');

        $reminder2Fee = intval(Configuration::get('dpReminder2Fee'));
        $existingFilePaths = [];
        if (count($invoices))
        {
            // generate pdfs
            foreach ($invoices as $invoice)
            {
                if( $reminder2Fee ){
                    $invoice['reminder2_fee'] = $reminder2Fee;
                }
                
                $existingFilePaths [] = OrderInvoice::generateReminder($invoice, $reminderNum, $langId);
            }
        }

        // generate zip with pdf files
        $saveFileNameZip = tempnam(OrderInvoice::InvoiceReminderFolderPath, 'bulk_');
        if (!$saveFileNameZip)
        {
            exit('Can\'t create zip file');
        }
        $zip = new ZipArchive();
        if ($zip->open($saveFileNameZip, ZIPARCHIVE::CREATE)!==TRUE) {
            exit('Can\'t open zip file');
        }
        foreach ($existingFilePaths as $file)
        {
            $zip->addFile($file, basename($file));
        }
        
        $zip->close();
                
        // send to user
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=reminders.zip");

        header('Pragma: no-cache',true);
        header('Expires: 0',true);
        readfile($saveFileNameZip);
        
        unlink($saveFileNameZip);
        exit;
    }
    
    
    /*
    * module: ba_prestashop_invoice
    * date: 2016-12-15 08:45:59
    * version: 1.1.16
    */
    public function displayDate($date, $id_lang = null)
    {
        if (!$date || !($time = strtotime($date))) {
            return $date;
        }
        if ($date == '0000-00-00 00:00:00' || $date == '0000-00-00') {
            return '';
        }
        if (!Validate::isDate($date)) {
            return $date;
        }
        if ($id_lang == null) {
            $id_lang = $this->order->id_lang;
        }
        $context = Context::getContext();
        $lang = empty($id_lang) ? $context->language : new Language($id_lang);
        $date_format = $lang->date_format_lite;
        return date($date_format, $time);
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
        
        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);
        
        $creditNoteInvoiceTemplatesQuery = '
            SELECT *
            FROM `'._DB_PREFIX_.'ba_prestashop_invoice` 
            WHERE payment_type = '. (BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP) .'    
        ';
        $creditNoteInvoiceTemplatesList = Db::getInstance()->executeS($creditNoteInvoiceTemplatesQuery);
        $creditNoteInvoiceTemplatesId = array();
        foreach( $creditNoteInvoiceTemplatesList as $creditNoteInvoiceTemplate ){
            $creditNoteInvoiceTemplatesId[] = intval( $creditNoteInvoiceTemplate['id'] );
        }
    
        // calculate total
        $sqlTail = stristr($this->_listsql, 'from');
        $sqlTailLimit = stristr($sqlTail, 'limit', true);
        if( strlen($sqlTailLimit) ){
            $sqlTail = $sqlTailLimit;
        }
        $sqlTailOrder = stristr($sqlTail, 'order by', true);
        if( strlen($sqlTailOrder) ){
            $sqlTail = $sqlTailOrder;
        }
        
        //$sqlTail = stristr(stristr(stristr($this->_listsql, 'from'), 'limit', true), 'order by', true);
        $sumToPayTotalQuery = 'select sum(a.sum_paid) '.$sqlTail.' and a.paid=0 and a.sum_paid > 0';
        if( count($creditNoteInvoiceTemplatesId) ){
            $sumToPayTotalQuery .= ' AND a.template_id NOT IN('. implode(',', $creditNoteInvoiceTemplatesId) .') ';
        }
        $sumToPayTotal = Db::getInstance()->getValue($sumToPayTotalQuery);
        
        $creditInvoicesTotal = 0;
        if( count($creditNoteInvoiceTemplatesId) ){
            $creditInvoicesListQuery = '
                select ABS(a.sum_paid) AS sum_paid '.$sqlTail.' and a.paid=0 and a.sum_paid != 0 
                AND a.template_id IN('. implode(',', $creditNoteInvoiceTemplatesId) .')
            ';
            $creditInvoicesList = Db::getInstance()->executeS($creditInvoicesListQuery);
            foreach( $creditInvoicesList as $creditInvoiceData ){
                $creditInvoicesTotal += abs($creditInvoiceData['sum_paid']);
            }

            $sumToPayTotal -= $creditInvoicesTotal;
        }

        $this->context->smarty->assign('sumToPayTotal', $sumToPayTotal?$sumToPayTotal:0);
        
        $sumsToPayByRmndState = Db::getInstance()->executeS('
            select a.reminder_state, SUM(ABS(a.sum_paid)) AS sum_paid '
            .$sqlTail.' 
            and a.paid=0 
            and a.sum_paid != 0
            group by a.reminder_state
        ');
        usort($sumsToPayByRmndState, function($a, $b)
            {
                if ($a['reminder_state'] == $b['reminder_state']) {
                    return 0;
                }
                return ($a['reminder_state'] < $b['reminder_state']) ? -1 : 1;
            }
        );
        for( $i = 0; $i < count($sumsToPayByRmndState); $i++ ){
            $sumsToPayByRmndState[$i]['reminder_state_name'] = 
                $this->reminderStates[ $sumsToPayByRmndState[$i]['reminder_state'] ];
        }
        $this->context->smarty->assign('sumsToPayByReminderState', $sumsToPayByRmndState);

        foreach($this->_list as &$diffPayment){
            
            if( in_array(intval($diffPayment['invoice_template_id']), $creditNoteInvoiceTemplatesId)){
                if (empty($diffPayment['class'])){
                    $diffPayment['class'] = 'creditNoteInvoice';
                }
                else{
                    $diffPayment['class'] .= ' creditNoteInvoice';
                }
            }
            elseif( intval($diffPayment['customer_inkasso']) ){
                if (empty($diffPayment['class'])){
                    $diffPayment['class'] = 'inkassoCustomer';
                }
                else{
                    $diffPayment['class'] .= ' inkassoCustomer';
                }
            }
            elseif( intval($diffPayment['has_overdued_invoices']) ){
                if (empty($diffPayment['class'])){
                    $diffPayment['class'] = 'notPaidInvoice';
                }
                else{
                    $diffPayment['class'] .= ' notPaidInvoice';
                }
            }
            
        }
    }
    
    
    public function setMedia()
    {
        parent::setMedia();

        $this->addJS(_PS_JS_DIR_.'admin/order_invoices.js');
        
        $this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.js');
        $this->context->controller->addCss(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.css');
        
    }
    
    
    public function renderList()
    { 
        $this->tpl_list_vars['reminder1Days'] = Configuration::get('dpReminder1Days');
        $this->tpl_list_vars['reminder2Days'] = Configuration::get('dpReminder2Days');
        $this->tpl_list_vars['reminder3Days'] = Configuration::get('dpReminder3Days');
        $this->tpl_list_vars['reminder2Fee'] = Configuration::get('dpReminder2Fee');
        return '<script type="text/javascript">
        //<![CDATA[
        var admin_order_tab_link = '.json_encode($this->context->link->getAdminLink('AdminOrders')).';
        var admin_diff_payments_link = '.json_encode($this->context->link->getAdminLink('AdminDiffPayments')).';
        var id_lang = '.$this->context->language->id.';
        var id_currency = "";
        var id_address = "";
        var id_customer = "";
        var currency_format = '.$this->context->currency->format.';
        var currency_sign = \''.$this->context->currency->sign.'\';
        var currency_blank = '.json_encode($this->context->currency->blank).';
        var priceDisplayPrecision = '._PS_PRICE_DISPLAY_PRECISION_.';
        var textSave = '.json_encode('Save').';
        var textCancel = '.json_encode('Cancel').';
        //]]>
      </script>'.parent::renderList();
    }
    
    public function processFilter()
    {
        parent::processFilter();
        
        $prefix = str_replace(array('admin', 'controller'), '', Tools::strtolower(get_class($this)));
        $filters = $this->context->cookie->getFamily($prefix.$this->list_id.'Filter_');
        
        foreach ($filters as $key => $value){
            if ($value == null || strncmp($key, $prefix.$this->list_id.'Filter_', 7 + Tools::strlen($prefix.$this->list_id))){
                continue;
            }
            $key = Tools::substr($key, 7 + Tools::strlen($prefix.$this->list_id));
            
            if( $key == 'payment_type' ){
                //var_dump($value);
                $value = unserialize($value);
                $paymentTypeValues = array_map(function($v){
                    return intval($v);
                }, $value);
                $paymentTypeValues = array_filter($paymentTypeValues, function($v){
                    return $v > 0;
                });
                
                if(count($paymentTypeValues)){
                    $this->_filter .= ' AND bai.payment_type IN ('. implode(',', $paymentTypeValues) .')';
                    $this->context->smarty->assign('invoice_payment_type_selected', $paymentTypeValues);
                    $this->tpl_list_vars['filters_has_value'] = true;
                }
            }
        }
    }
    
    function displayErrors()
    {
        
    }
    
    
    function ajaxProcessSaveRemindersCfg()
    {
        $error = '';
        if (!Validate::isInt($_POST['reminder1Days']))
        {
            $error .= $this->l('Days till 1st reminder must be integer');
        }
        
        if (!Validate::isInt($_POST['reminder2Days']))
        {
            $error .= '<br/>'.$this->l('Days till 2nd reminder must be integer');
        }
        
        if (!Validate::isInt($_POST['reminder3Days']))
        {
            $error .= '<br/>'.$this->l('Days till 3rd reminder must be integer');
        }

        if (!Validate::isInt($_POST['reminder2Fee']))
        {
            $error .= '<br/>'.$this->l('"2nd reminder fee" must be integer');
        }
        
        if ($error)
        {
            die(json_encode(['error'=>$error]));
        }
        
        Configuration::updateValue('dpReminder1Days', intval($_POST['reminder1Days']));
        Configuration::updateValue('dpReminder2Days', intval($_POST['reminder2Days']));
        Configuration::updateValue('dpReminder3Days', intval($_POST['reminder3Days']));
        
        Configuration::updateValue('dpReminder2Fee', intval($_POST['reminder2Fee']));
        
        die(json_encode(['error'=>'']));
    }

    public function processExportMassmail()
    {
        if( !is_array($_POST['order_invoiceBox']) || !count($_POST['order_invoiceBox'])){
            $this->errors[] = 'No items selected for export';
            return;
        }
        
        // just for classes to be included :(
        $massmailModule = Module::getInstanceByName('khlmassmail');
        
        $customersList = array();
        $customersOptions = array();
        foreach( $_POST['order_invoiceBox'] as $postInvoiceId ){
            $orderInvoice = new OrderInvoice($postInvoiceId);
            $order = new Order($orderInvoice->id_order);
            $id_customer = intval($order->id_customer);
            
            if( !isset($customersOptions[ $id_customer ]) ){
                $customersOptions[ $id_customer ] = array(
                    'attachments' => array()
                );
            }
            
            if( isset($_POST['attach_last_reminder']) && ($orderInvoice->reminder_state > 0) ){
                $reminderFilePath = OrderInvoice::getReminderFilePath(
                    $orderInvoice->id, $orderInvoice->reminder_state, $order->id_lang
                );
                if( !empty($reminderFilePath) ){
                    $customersOptions[$id_customer]['attachments'][] = $reminderFilePath;
                }
            }
        }
        
        foreach( $customersOptions as $customerId => $customerOptions ){
            $customersList[] = array(
                'id_customer' => $customerId,
                'attachments' => $customerOptions['attachments']
            );
        }
        
        MassmailManager::setReceivers($customersList);
        
        $this->redirect_after = $this->context->link->getAdminLink('AdminMassMailTemplates');
    }
    
}
