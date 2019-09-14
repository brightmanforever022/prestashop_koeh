<?php

require _PS_MODULE_DIR_ .'agentsales/classes/AgentSalesOrder.php';
require _PS_MODULE_DIR_ .'agentsales/classes/AgentSalesInvoice.php';
require_once _PS_TOOL_DIR_ . 'php_excel/PHPExcel.php';
require_once _PS_MODULE_DIR_ .'ba_prestashop_invoice/ba_prestashop_invoice.php';
require_once _PS_MODULE_DIR_ .'ba_prestashop_invoice/includes/baorderinvoice.php';


class AdminAgentsalesAgentsController extends ModuleAdminController
{
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->table = 'agentsales_invoice';
        $this->className = 'AgentSalesInvoice';
        
        $this->identifier = 'id';
        $this->_defaultOrderBy = 'o!date_add';
        $this->_defaultOrderWay = 'DESC';
        $this->lang = false;
        $this->context = Context::getContext();
        $this->allow_export = true;
        
        $agentsOfEmployeeId = 0;
        if( !in_array($this->context->employee->id, $this->module->getWideAccessAdminIds()) ){
            $agentsOfEmployeeId = $this->context->employee->id;
        }
        
        $agents = $this->module->getAgentsList($agentsOfEmployeeId);
        $agentsFilterOptions = array();
        foreach($agents as $agent){
            $agentsFilterOptions[ $agent['id_customer'] ] = $agent['firstname'] .' '. $agent['lastname'];
        }
        
        $this->fields_list = array(
            'agent_name' => array(
                'title' => $this->l('Agent'), 
                'filter_key' => 'a!id_agent',
                //'filter_type' => 'int',
                'multiple' => true,
                'filter_type' => 'multiint',
                //'width' => 100,
                'type' => 'select',
                'list' => $agentsFilterOptions,
                'class' => 'agents_select',
                'multipleWidth' => '200'
            ),
            'id_order' => array(
                'title' => $this->l('Order ID'),
                'callback' => 'formatOrderId',
                'filter_key' => 'o!id_order',
                'filter_type' => 'int',
            ),
            'order_date_add' => array(
                'title' => $this->l('Order date'),
                'type' => 'date',
                'filter_key' => 'o!date_add',
            ),
            'total_paid_tax_excl' => array(
                'title' => $this->l('Order total tax excl'),
                'type' => 'price',
            ),
            'invoice_total_products' => array(
                'title' => $this->l('Inv. total'),
                'type' => 'price',
                'havingFilter' => 'invoice_total_products'
            ),
            'commision_value' => array(
                'title' => $this->l('Comm.'),
                'callback' => 'formatCommisionValue',
                'class' => 'commision_value'
            ),
            
            'invoice_commision' => array(
                'title' => $this->l('Inv. comm.'),
                'type' => 'price',
            ),
            'customer_name' => array(
                'title' => $this->l('Customer'),
                'havingFilter' => true,
                //'filter_key' => 'agent_name'
            ),
            'invoice_number' => array(
                'title' => $this->l('Invoice'),
                'align' => 'text-right',
                //'type' => 'string',
                'callback' => 'showInvoiceNumber',
                'filter_key' => 'oi!number',
                'filter_type' => 'int',
            ),
            'invoice_date_add' => array(
                'title' => $this->l('Inv. date'),
                'align' => 'text-right',
                'type' => 'date',
                //'callback' => 'showInvoiceNumber',
                'filter_key' => 'oi!date_add',
                //'filter_type' => 'int',
            ),
            'invoice_paid' => array(
                'title' => $this->l('Inv. Paid'),
                'align' => 'text-center',
                'type' => 'bool',
                'callback' => 'formatBool',
                //'filter_key' => 'oi!paid',
                //'filter_type' => 'int',
                'havingFilter' => 'invoice_paid',
            ),
            'invoice_payment_day' => array(
                'title' => $this->l('Payment date'),
                'align' => 'text-right',
                'type' => 'date',
                //'callback' => 'showInvoiceNumber',
                'filter_key' => 'oi!payment_date',
                //'filter_type' => 'int',
            ),
            
            'paidout' => array(
                'title' => $this->l('Comm. Paid'),
                'align' => 'text-center',
                //'filter_key' => 'paidout',
                'type' => 'bool',
                'callback' => 'formatBool',
                //'havingFilter' => 'invoice_paidout',
            ),
            
            'date_paidout' => array(
                'title' => $this->l('Paidout date'),
                'align' => 'text-right',
                'type' => 'date',
                //'filter_key' => 'o!date_add'
            )
        );
        
        $taxValue = 19;
        
        $this->_select = '
            a.paidout AS invoice_paidout,
            CONCAT_WS(" ", ca.`firstname`, ca.lastname) AS agent_name,
            o.`id_order`, o.`reference` AS order_reference, o.date_add as order_date_add, o.total_paid_tax_excl,
            IF((bai.payment_type != '. BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP .') OR 
                (bai.payment_type = '. BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP .' AND oi.`sum_to_pay` < 0 ), 
                (oi.`sum_to_pay` - if(oi.total_paid_tax_excl=oi.total_paid_tax_incl, 0, (oi.`sum_to_pay` * '.$taxValue.' / (100 + '.$taxValue.')))),
                (-oi.`sum_to_pay` - if(oi.total_paid_tax_excl=oi.total_paid_tax_incl, 0, (-oi.`sum_to_pay` * '.$taxValue.' / (100 + '.$taxValue.'))))
            ) AS invoice_total_products,
            IF(a.commision_type = 1, 
                IF((bai.payment_type != '. BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP .') OR 
                        (bai.payment_type = '. BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP .' AND oi.`sum_to_pay` < 0 ), 
                    (oi.`sum_to_pay` - if(oi.total_paid_tax_excl=oi.total_paid_tax_incl, 0, (oi.`sum_to_pay` * '.$taxValue.' / (100 + '.$taxValue.'))) ),
                    (-oi.`sum_to_pay` - if(oi.total_paid_tax_excl=oi.total_paid_tax_incl, 0, (-oi.`sum_to_pay` * '.$taxValue.' / (100 + '.$taxValue.'))))) / 100 * a.commision_value
                ,
                IF(
                    (bai.payment_type != '. BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP .') OR 
                        (bai.payment_type = '. BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP .' AND oi.`sum_to_pay` < 0 ), 
                    a.commision_value, 
                    -a.commision_value
                )
            ) AS invoice_commision,
            oi.date_add AS invoice_date_add, oi.payment_date as invoice_payment_day,
            concat(IF(LENGTH(cc.company), 
                CONCAT(cc.`firstname`, " ", cc.lastname, " (", cc.company, ")"), 
                CONCAT(cc.`firstname`, " ", cc.lastname) ),", ",cc.id_customer) AS customer_name,
            oi.id_order_invoice, oi.paid AS invoice_paid, oi.number AS invoice_number
        ';
        $this->_join = '
            INNER JOIN `'._DB_PREFIX_.'order_invoice` oi ON oi.id_order_invoice = a.id_invoice
            INNER JOIN `'._DB_PREFIX_.'orders` o ON o.id_order = oi.id_order
			INNER JOIN `'._DB_PREFIX_.'customer` cc ON (cc.`id_customer` = o.`id_customer`)
			INNER JOIN `'._DB_PREFIX_.'customer` ca ON (ca.`id_customer` = a.`id_agent`)
			INNER JOIN `'._DB_PREFIX_.'ba_prestashop_invoice` bai 
			    ON (bai.id = oi.template_id)
        ';
        
        $this->_where .= ' AND oi.number > 0';
        
        if( !in_array($this->context->employee->id, $this->module->getWideAccessAdminIds()) ){
            $this->_where .= ' AND ca.agentsales_id_employee = '. $this->context->employee->id;
        }
        
        /*
         * INNER JOIN `'._DB_PREFIX_.'agentsales_invoice` asi ON asi.id_invoice = oi.id_order_invoice
         */
        $this->bulk_actions = array(
            'paidout' => array(
                'text' => $this->l('Mark as paidout'),
                'icon' => 'icon-money',
                'confirm' => $this->l('Mark as paidout selected items?')
            ),
            'notpaidout' => array(
                'text' => $this->l('Mark as unpaid'),
                'icon' => 'icon-money',
                'confirm' => $this->l('Mark as not paidout selected items?')
            ),
            'export' => array(
                'text' => $this->l('Export to Excel'),
                'icon' => 'icon-export',
            )
        );
        
        //$this->addRowAction('edit');
        
        $this->toolbar_title = $this->l('Statistics');
        $this->list_no_link = true;
        
        // workaround for profiles that does not have 'edit' permissions, but have 'view' permissions
        $actionTreatAsViewList = array('submitBulkexportagentsales_invoice');
        foreach($actionTreatAsViewList as $actionTreatAsView){
            if( in_array($actionTreatAsView, array_keys($_GET)) && ($this->tabAccess['view'] == 1) && ($this->tabAccess['edit'] == '0')){
                $this->tabAccess['edit'] = '1';
            }
        }
        
        
        $this->context->smarty->assign(array(
            'agents_selected' => array()
        ));
        
    }
    
    function showInvoiceNumber($field, $row)
    {
        /*$invoices = Db::getInstance()->executeS('
            SELECT id_order_invoice, number, paid 
            FROM `'._DB_PREFIX_.'order_invoice`
            WHERE id_order = '. intval($row['id_order']) .'
        ');
        if( !is_array($invoices) || !count($invoices) ){
            return '--';
        }*/
        
        $invoiceHtml = '';
        //foreach( $invoices as $invoice ){
        $invoiceHtml = 
                '<a href="'.$this->context->link->getAdminLink('AdminPdf').'&submitAction=generateInvoicePDF&id_order_invoice='.
                $row['id_order_invoice'].'" target="_blank"'. 
            ' class="label '. ($row['invoice_paid'] ? ' label-success' : 'label-danger') .'"'.
            ' style="line-height:2;">'.
            sprintf('%1$s%2$06d', Configuration::get('PS_INVOICE_PREFIX', $this->context->language->id, null, $this->context->shop->id),
                $field).'</a>';
        //}
        return $invoiceHtml;// implode('<br>', $invoicesHtml);
    }
    
    public function processExport($text_delimiter = '"')
    {
        // clean buffer
        if (ob_get_level() && ob_get_length() > 0) {
            ob_clean();
        }
        $this->getList($this->context->language->id, null, null, 0, false);
        if (!count($this->_list)) {
            return;
        }
        
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()
            ->setCreator($this->context->shop->name .' ('. $this->context->shop->domain .')')
            ->setLastModifiedBy($this->context->shop->name.' ('. $this->context->shop->domain .')')
            ->setTitle("Agents sales")
        ;
        
        $objPHPExcel->setActiveSheetIndex(0);
        $rowNumber = 0;
        $rowNumber++;
        $colCharNum = ord('A');
        foreach($this->fields_list as $fieldOptions){
            $objPHPExcel
                ->getActiveSheet()
                ->setCellValue( (chr($colCharNum++).$rowNumber), $fieldOptions['title'])
            ;
        }
        
        foreach($this->_list as $dbRec){
            $rowNumber++;
            $colCharNum = ord('A');
            
            foreach($this->fields_list as $fieldName => $fieldOptions){
                $objPHPExcel
                    ->getActiveSheet()
                    ->setCellValue( (chr($colCharNum++).$rowNumber), $dbRec[$fieldName])
                ;
            }
        }
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Commisions');
        
        
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
    
    public function renderForm()
    {
        $this->toolbar_title = $this->l('Edit order commision');
        
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Agents commision'),
                'icon' => 'icon-money'
            ),
            'input' => array(
                array(
                    'col' => 3,
                    'type' => 'radio',
                    //'prefix' => '%',
                    'required' => true,
                    'name' => 'commision_type',
                    'label' => $this->l('Agent\'s commision type'),
                    'values' => array(
                        array(
                            'id' => 'agentsales_commision_type_1',
                            'value' => Agentsales::DISCOUNT_TYPE_PERCENT,
                            'label' => $this->l('Percent') .' (%)'
                        ),
                        array(
                            'id' => 'agentsales_commision_type_2',
                            'value' => Agentsales::DISCOUNT_TYPE_AMOUNT,
                            'label' => $this->l('Amount')
                        )
                    ),
                ),
                array(
                    'col' => 3,
                    'type' => 'text',
                    'required' => true,
                    'name' => 'commision_value',
                    'label' => $this->l('Agent\'s commision value'),
                ),
                
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            )
        );
        
        $id = (int)Tools::getValue('id');
        
        $agentsOrder = new AgentSalesOrder($id);
        
        $this->fields_value['commision_type'] = $agentsOrder->commision_type;
        $this->fields_value['commision_value'] = $agentsOrder->commision_value;
        
        return '<div class="bootstrap" style="padding:0;margin:15px;">'. 
            parent::renderForm() .'</div>';
    }
    
    public function formatBool($field, $tr)
    {
        return ($field ? ' <i class="icon-check text-success"></i>' : '<i class="icon-remove text-danger"></i>');
    }
    
    public function formatCommisionValue($id, $tr)
    {
        return $tr['commision_value'] . ($tr['commision_type'] == Agentsales::DISCOUNT_TYPE_PERCENT ? '%' : 
            $this->context->currency->sign);
    }
    
    public function formatOrderId($id, $tr)
    {
        return '<a href="'. $this->context->link->getAdminLink('AdminOrders').'&vieworder&id_order='. $tr['id_order'] .'" target="_blank">'. 
            $tr['id_order'] .'</a>';
    }
    
    public function initToolbar()
    {
        parent::initToolbar();
        
        if(empty($this->display)){
            unset($this->toolbar_btn['new']);
        }
    }
    
    public function init()
    {
        parent::init();
        $action = Tools::getValue('action', 'default');

        /*if( ($action == 'default') && !empty($_POST)){
            if(!empty($_POST['agentsales_invoiceBox'])){
                $action = 'bulk_paidout';
            }
        }*/
        
        switch($action){
            case 'save_order_agent':
                $this->actionSaveOrderAgent();
                break;
            case 'search_customers':
                $this->actionSearchCustomers();
                break;
            case 'link_customer_to_agent':
                $this->actionLinkCustomerToAgent();
                break;
            case 'commision_update':
                $this->actionCommisionUpdate();
                break;
            case 'show_conf':
                $this->showConfInvPaid();
                break;
            default:
                //$this->getStats();
                break;
        }
    }
    
    
    
    public function initContent()
    {
        parent::initContent();
        $this->module->addBackJs();
        if(empty($this->display) && !$this->ajax){
            $tplData = array( 'agents_stats' => array() );
            $tplData['agents_stats']['total'] = 0;
            $tplData['agents_stats']['commision_invoice_paid'] = 0;
            $tplData['agents_stats']['commision_invoice_unpaid'] = 0;

            $this->getList($this->context->language->id, null, null, 0, false);
            $listOptForInvoicesTotal = array();
            
            foreach ($this->_list as $row){
                // summarize amounts for statistics. negative values(credit invoices) must be deducted from the total 
                if( ($row['invoice_paid'] == 1) && ($row['paidout'] == 0) ){
                    $tplData['agents_stats']['commision_invoice_paid'] += floatval($row['invoice_commision']);
                }
                
                if( ($row['invoice_paid'] == 0) && ($row['paidout'] == 0) ){
                    $tplData['agents_stats']['commision_invoice_unpaid'] += floatval($row['invoice_commision']);
                }
                
                $listOptForInvoicesTotal[ intval($row['id_order_invoice']) ] = $row['invoice_total_products'];
            }
            foreach ($listOptForInvoicesTotal as $row){
                $tplData['agents_stats']['total'] += $row;
            }
            
            $tplData['agents_stats']['total'] = Tools::displayPrice($tplData['agents_stats']['total']);
            $tplData['agents_stats']['commision_invoice_paid'] = Tools::displayPrice($tplData['agents_stats']['commision_invoice_paid']);
            $tplData['agents_stats']['commision_invoice_unpaid'] = Tools::displayPrice( $tplData['agents_stats']['commision_invoice_unpaid'] );
            
            $tplData['agents_stats']['pending_commissions'] = Tools::displayPrice($this->getPendingCommissionsAmount());
    
            $this->context->smarty->assign($tplData);//die;
            
            $this->content .= $this->context->smarty->fetch($this->module->getTemplatePath('views/templates/admin/stats.tpl'));
            $this->context->smarty->assign('content', $this->content);
        }
    }
    
    private function getPendingCommissionsAmount()
    {
        $requestAgentsId = null;
        if( is_array(@$_POST['agentsales_invoiceFilter_a!id_agent']) && count(@$_POST['agentsales_invoiceFilter_a!id_agent']) ){
            $requestAgentsId = $_POST['agentsales_invoiceFilter_a!id_agent'];
            $requestAgentsId = array_filter($requestAgentsId, function($val){
                return (intval($val) > 0);
            });
        }
        
        /**
         * @var DbQueryCore
         */
        $pendingCommissionsQuery = new DbQuery();
        $pendingCommissionsQuery
            ->select('o.id_order,
                o.total_paid_tax_excl,
                o.total_paid_tax_incl,
                inv_isd_sum.total_sum_to_pay,
                GROUP_CONCAT(aso.id_agent) AS agents_ids
            ')
            ->from('orders', 'o')
            ->join('INNER JOIN `'._DB_PREFIX_.'agentsales_order` aso ON aso.id_order = o.id_order')
            ->join('
                LEFT JOIN (
                    SELECT o.id_order, 
                        SUM(ABS( IF(ISNULL(oi.`sum_to_pay`), 0.0, oi.`sum_to_pay`) )) as total_sum_to_pay
                    FROM `'._DB_PREFIX_.'orders` o
                    LEFT JOIN `'._DB_PREFIX_.'order_invoice` oi ON oi.id_order = o.id_order
                    LEFT JOIN `'._DB_PREFIX_.'ba_prestashop_invoice` bai
                        ON (bai.id = oi.template_id)
                    WHERE (bai.agentsales_ignore = 0 OR ISNULL(bai.agentsales_ignore))
                    GROUP BY oi.id_order
                ) AS inv_isd_sum ON inv_isd_sum.id_order = o.id_order
            ')
            ->where( 'o.current_state != '. intval(Configuration::get('PS_OS_CANCELED')) )
            ->where(' o.total_paid_tax_incl > 0 ')
            ->where(' ISNULL(inv_isd_sum.total_sum_to_pay) OR ROUND(o.total_paid_tax_incl, 2) > ROUND(inv_isd_sum.total_sum_to_pay, 2)')
            ->groupBy('o.id_order')
        ;
        if( count($requestAgentsId) ){
            $pendingCommissionsQuery->where('aso.id_agent IN('.implode(',',$requestAgentsId).')');
        }
        if( !$this->module->isAuthenticatedOwnerAdmin() ){
            $pendingCommissionsQuery->join('INNER JOIN `'._DB_PREFIX_.'customer` ca ON (ca.`id_customer` = aso.`id_agent`)');
            $pendingCommissionsQuery->where(' ca.agentsales_id_employee = '. $this->context->employee->id );
        }
        
        $pendingCommissionsList = Db::getInstance()->executeS($pendingCommissionsQuery);
        
        $agentsDefaultCommType = Configuration::get('AGENTSALES_COMM_TYPE');
        $agentsDefaultCommValue = Configuration::get('AGENTSALES_COMM_VALUE');
        
        $agentsCache = array();
        $totalCommissions = 0;
        $pendingCommissionsDetailsList = array();
        
        foreach( $pendingCommissionsList as $pendingCommissionData ){
            $pendingCommissionsDetail = $pendingCommissionData;
            $agentsIdList = explode(',', $pendingCommissionData['agents_ids']);
            $orderPendingCommissionBaseTaxIncl = $pendingCommissionData['total_paid_tax_incl'] - $pendingCommissionData['total_sum_to_pay'];
            $orderPendingCommissionBase = $orderPendingCommissionBaseTaxIncl - ($orderPendingCommissionBaseTaxIncl * 19 / (100 + 19));
            
            foreach($agentsIdList as $agentId){
                $agentId = intval($agentId);
                
                if(!$agentId){
                    continue;
                }
                
                if( empty($agentsCache[$agentId]) ){
                    $agentsCache[$agentId] = new Customer($agentId);
                }
                
                if( empty($agentsCache[$agentId]->agentsales_commision_type) ){
                    $commision_type = $agentsDefaultCommType;
                    $commision_value = $agentsDefaultCommValue;
                }
                else{
                    $commision_type = $agentsCache[$agentId]->agentsales_commision_type;
                    $commision_value = $agentsCache[$agentId]->agentsales_commision_value;
                }
                
                if( $commision_type == Agentsales::DISCOUNT_TYPE_PERCENT ){
                    $pendingCommission = $orderPendingCommissionBase / 100 * $commision_value;
                }
                elseif( $commision_type == Agentsales::DISCOUNT_TYPE_AMOUNT ){
                    $pendingCommission = $commision_value;
                }
                $pendingCommissionsDetail['commission_base'] = $orderPendingCommissionBase;
                $pendingCommissionsDetail['commission_value'] = $pendingCommission;
                $pendingCommissionsDetail['agent_name'] = $agentsCache[$agentId]->firstname .' '. $agentsCache[$agentId]->lastname;
                
                $totalCommissions += $pendingCommission;
                $pendingCommissionsDetailsList[] = $pendingCommissionsDetail;
            }
        }
        
        $this->context->smarty->assign('pending_commissions_list', $pendingCommissionsDetailsList);
        
        return $totalCommissions;
    }
    
    function processFilter()
    {
        parent::processFilter();
        
        if( !empty($_POST['agentsales_invoiceFilter_oi!number']) ){
            
            $this->_filter = preg_replace('#AND oi\.`number` = \d+#', '', $this->_filter);
            $invNumberSearch = null;
            $invNumberRegexMatch = array();
            if( preg_match('#^[a-z]{2}(\d+)$#i', $_POST['agentsales_invoiceFilter_oi!number'], $invNumberRegexMatch) ){
                $invNumberSearch = intval($invNumberRegexMatch[1]);
            }
            elseif( preg_match('#^(\d+)$#i', $_POST['agentsales_invoiceFilter_oi!number'], $invNumberRegexMatch) ){
                $invNumberSearch = intval($invNumberRegexMatch[1]);
            }
            else{
                $invNumberSearch = -1;
            }
            
            $this->_filter .= ' AND oi.number = '. $invNumberSearch;
        }
        
    }
    
    public function setMedia()
    {
        parent::setMedia();
        
        $this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.js');
        $this->context->controller->addCss(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.css');
    }
    
    public function actionCommisionUpdate()
    {
        $agentsales_invoice_id = intval(Tools::getValue('agentsales_invoice_id'));
        $commision_value = Tools::getValue('commision_value');
        $commision_type = null;
        
        if( preg_match('#\%#', $commision_value) ){
            $commision_type = Agentsales::DISCOUNT_TYPE_PERCENT;
            $commision_value = floatval( str_replace('%', '', $commision_value) );
        }
        else{
            $commision_type = Agentsales::DISCOUNT_TYPE_AMOUNT;
            $commision_value = floatval(str_replace('€', '', $commision_value));
        }
        
        Db::getInstance()->update('agentsales_invoice', array(
            'commision_type' => $commision_type,
            'commision_value' => $commision_value
        ), 'id = '. $agentsales_invoice_id);
        
        echo json_encode(array('success' => true));
    }

    public function actionSaveOrderAgent()
    {
        $this->ajax = true;
        $responseData = array(
            'success' => false,
            'data' => array(),
            'message' => ''
        );
        $id_order = (int)Tools::getValue('id_order');
        $id_agents = (array)Tools::getValue('id_agent');
        
        $agentsales_orders_id = (int)Tools::getValue('agentsales_orders_id');
        $agentsCustomerGroup = (int)Configuration::get('AGENTSALES_AGENT_GROUP');
        $agentsDefaultCommType = Configuration::get('AGENTSALES_COMM_TYPE');
        $agentsDefaultCommValue = Configuration::get('AGENTSALES_COMM_VALUE');
        
        
        if(empty($id_order) || !is_array($id_agents)){
            $responseData['message'] .= '. '. $this->module->l('Required parameters not sent');
            die(json_encode($responseData));
        }
        
        $order = new Order($id_order);
        
        $logMessage = 'Order #'. $order->id .PHP_EOL;
        
        $orderInvoicesQuery = '
            select *
            from `'._DB_PREFIX_.'order_invoice`
            where id_order = '. $order->id .' and number > 0
        ';
        $orderInvoices = Db::getInstance()->executeS($orderInvoicesQuery);
        
        $logMessage .= 'Added agents: ';
        foreach($id_agents as $id_agent){
            if( empty($id_agent) ){
                continue;
            }
            $agent = new Customer($id_agent);
            $agentGroups = $agent->getGroups();
            
            if( !in_array($agentsCustomerGroup, $agentGroups) ){
                $responseData['message'] .= '. '. $this->module->l('Customer does not belongs to agents group');
                //die(json_encode($responseData));
                continue;
            }
            
            if( !$this->module->isAuthenticatedOwnerAdmin() && 
                ( $this->context->employee->id != $agent->agentsales_id_employee )
            ){
                //$responseData['message'] .= '. '. $this->module->l('You are not allowed to manage agent') .': '. $agent->id;
                continue;
            }
            
            $agentLinkedToOrder = Db::getInstance()->getRow('
                SELECT * FROM `'._DB_PREFIX_.'agentsales_order`
                WHERE `id_order` = '. $order->id .' AND `id_agent` = '. $agent->id .'
            ');
            if( is_array($agentLinkedToOrder) && !empty($agentLinkedToOrder['id']) ){
                continue;
            }
            
            // check for excluded customers
            if( !empty($agent->agentsales_customer_exclude) ){
                $agentsCustomersExcludeIds = explode(PHP_EOL, $agent->agentsales_customer_exclude);
                $agentsCustomersExcludeIds = array_map('intval', (array)$agentsCustomersExcludeIds);
                 
                if(is_array($agentsCustomersExcludeIds) && in_array($order->id_customer, $agentsCustomersExcludeIds)){
                    $responseData['message'] .= '. '. 'Customer ('.$order->id_customer.') excluded from this agent ('. $agent->id .')';
                    continue;
                }
            }
            
            
            $agentsalesOrderData = array(
                'id_agent' => $agent->id,
                'id_order' => $order->id,
            );
            
            try{
                $result = Db::getInstance()->insert('agentsales_order', $agentsalesOrderData);
            }
            catch(Exception $e){
                $responseData['message'] .= '. '. $e->getMessage();
                continue;
            }
            
            if(!$result){
                $responseData['message'] .= '. '. Db::getInstance()->getMsgError();
                continue;
            }
            
            $insertedId = Db::getInstance()->Insert_ID();
            $logMessage .= $agent->id .' ; ';
            
            foreach($orderInvoices as $orderInvoice){
                
                if( $orderInvoice['template_id'] > 0 ){
                    $baOrderInvoiceTemplateData = Db::getInstance()->getRow('
                        SELECT * FROM `'._DB_PREFIX_.'ba_prestashop_invoice`
                        WHERE id = '. intval($orderInvoice['template_id']) .'
                    ');
                    if( is_array($baOrderInvoiceTemplateData) && !empty($baOrderInvoiceTemplateData['id']) ){
                        if( $baOrderInvoiceTemplateData['agentsales_ignore'] == '1' ){
                            continue;
                        }
                    }
                }
                
                $agentSaleInvoiceData = array(
                    'id_agent' => $agent->id,
                    'id_invoice' => $orderInvoice['id_order_invoice'],
                    'paidout' => 0
                );
                if( empty($agent->agentsales_commision_type) ){
                    $agentSaleInvoiceData['commision_type'] = $agentsDefaultCommType;
                    $agentSaleInvoiceData['commision_value'] = $agentsDefaultCommValue;
                }
                else{
                    $agentSaleInvoiceData['commision_type'] = $agent->agentsales_commision_type;
                    $agentSaleInvoiceData['commision_value'] = $agent->agentsales_commision_value;
                }
                
                try{
                    Db::getInstance()->insert('agentsales_invoice', $agentSaleInvoiceData);
                }
                catch(Exception $e){
                    $responseData['message'] .= '. '. $e->getMessage();
                    continue;
                }
            }
            
        }
        $logMessage .= PHP_EOL;
        
        $agentsSales = $this->module->getSalesByOrder($order->id);
        if( is_array($agentsSales) ){
            $logMessage .= 'Removed agents: ';
            foreach($agentsSales as $agentSale){
                $agent = new Customer($agentSale['id_agent']);
                
                if( !$this->module->isAuthenticatedOwnerAdmin() &&
                    ( $this->context->employee->id != $agent->agentsales_id_employee )
                ){
                    //$responseData['message'] .= '. '. $this->module->l('You are not allowed to manage agent') .': '. $agent->id;
                    continue;
                }
                
                
                if( in_array($agentSale['id_agent'], $id_agents) ){
                    continue;
                }
                
                try{
                    Db::getInstance()->delete('agentsales_order', 
                        '`id_order` = '. $order->id .' AND `id_agent` = '. $agentSale['id_agent']);
                }
                catch(Exception $e){
                    $responseData['message'] .= '. '. $e->getMessage();
                }
                
                $logMessage .= $agentSale['id_agent'] .' ; ';
                
                foreach($orderInvoices as $orderInvoice){
                    try{
                        Db::getInstance()->delete(
                            'agentsales_invoice',
                            '`id_invoice` = '. $orderInvoice['id_order_invoice'].
                                ' AND `id_agent` = '. $agentSale['id_agent']
                        );
                        
                    }
                    catch(Exception $e){
                        $responseData['message'] .= '. '. $e->getMessage();
                    }
                }
            }
        }
        
        PrestaShopLogger::addLog($logMessage, 1);
        mail('vitaliy@newstyleweb.net', 'Order agents changed', $logMessage);
        
        
        $responseData['success'] = true;
        $responseData['message'] .= '. '.  $this->module->l('Data saved');
        $responseData['data']['sales'] = $this->module->getSalesByOrder($order->id);
        die(json_encode($responseData));
    }
    
    public function actionSearchCustomers()
    {
        $this->ajax = true;
        $searches = explode(' ', Tools::getValue('q'));
        $customers = array();
        $searches = array_unique($searches);
        foreach ($searches as $search) {
            if (!empty($search) && $results = Customer::searchByName($search, 50)) {
                foreach ($results as $result) {
                    if ($result['active']) {
                        $customers[$result['id_customer']] = $result;
                    }
                }
            }
        }
    
        if (count($customers)) {
            $to_return = array(
                'customers' => $customers,
                'found' => true
            );
        } else {
            $to_return = array('found' => false);
        }
    
        $this->content = Tools::jsonEncode($to_return);
    }

    public function actionLinkCustomerToAgent()
    {
        $this->ajax = true;
        $responseData = array(
            'success' => false,
            'data' => array(),
            'message' => ''
        );
        
        $id_agent = (int)Tools::getValue('id_agent');
        $id_customer = (int)Tools::getValue('id_customer');
        $cmdLink = (int)Tools::getValue('link');
        $agentsCustomerGroup = (int)Configuration::get('AGENTSALES_AGENT_GROUP');
        
        if( empty($id_agent) || empty($id_customer) ){
            $responseData['message'] = $this->module->l('Required parameters not sent');
            die(json_encode($responseData));
        }
        
        $agent = new Customer($id_agent);
        $customer = new Customer($id_customer);
        
        $agentGroups = $agent->getGroups();
        
        if( !in_array($agentsCustomerGroup, $agentGroups) ){
            $responseData['message'] = $this->module->l('Customer does not belongs to agents group');
            die(json_encode($responseData));
        }

        if( $cmdLink ){
            $customer->agentsales_id_agent = $agent->id;
            try{
                $customer->update();
            }
            catch(Exception $e){
                $responseData['message'] = $e->getMessage();
                die(json_encode($responseData));
            }
        }
        else{
            $customer->agentsales_id_agent = 0;
            try{
                $customer->update();
            }
            catch(Exception $e){
                $responseData['message'] = $e->getMessage();
                die(json_encode($responseData));
            }
        }
        
        $responseData['success'] = true;
        $responseData['data']['customer'] = $customer->getFields();
        $responseData['data']['customer']['id_customer'] = $customer->id;
        
        die(json_encode($responseData));
    }
    
    public function processBulkPaidout()
    {
        if( !is_array($this->boxes) || empty($this->boxes)){
            Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
        }
        
        //$idsToPaidout = $_POST['agentsales_invoiceBox'];
        //var_dump($idsToPaidout);die;
        foreach($this->boxes as $id){
            Db::getInstance()->update(
                'agentsales_invoice', 
                array(
                    'paidout' => 1,
                    'date_paidout' => date('Y-m-d')
                ), 
                'id = '. (int)$id
            );
        }
        
        Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
    }
    
    public function processBulkNotpaidout()
    {
        if( !is_array($this->boxes) || empty($this->boxes)){
            Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
        }
        
        //$idsToPaidout = $_POST['agentsales_invoiceBox'];
        //var_dump($idsToPaidout);die;
        foreach($this->boxes as $id){
            Db::getInstance()->update(
                'agentsales_invoice',
                array(
                    'paidout' => 0,
                    'date_paidout' => '0000-00-00'
                ),
                'id = '. (int)$id
            );
        }
        
        Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
    }
    
    
    public function processBulkExport()
    {
        if( !is_array($this->boxes) || empty($this->boxes)){
            Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
        }
        
        if (ob_get_level() && ob_get_length() > 0) {
            ob_clean();
        }
        
        /*foreach ($this->boxes as $id){
            
        }*/
        
        $this->_where .= ' AND a.id IN('. implode(',', $this->boxes) .')';
        
        $this->getList($this->context->language->id, null, null, 0, false);
        //var_dump($this->_list);die;
        if (!count($this->_list)) {
            return;
        }

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()
            ->setCreator($this->context->shop->name .' ('. $this->context->shop->domain .')')
            ->setLastModifiedBy($this->context->shop->name.' ('. $this->context->shop->domain .')')
            ->setTitle("Agents sales")
        ;
        
        $objPHPExcel->setActiveSheetIndex(0);
        $rowNumber = 0;
        $rowNumber++;
        $colCharNum = ord('A');
        foreach($this->fields_list as $fieldOptions){
            $objPHPExcel
            ->getActiveSheet()
            ->setCellValue( (chr($colCharNum++).$rowNumber), $fieldOptions['title'])
            ;
        }
        
        foreach($this->_list as $dbRec){
            $rowNumber++;
            $colCharNum = ord('A');
            
            foreach($this->fields_list as $fieldName => $fieldOptions){
                $cellValue = $dbRec[$fieldName];
                
                
                if( isset($fieldOptions['type']) ){
                    if( $fieldOptions['type'] == 'date' ){
                        if( false && !strtotime($cellValue) ){
                            $cellValue = '-';
                        }
                        else{
                            $cellValue = Tools::displayDate($cellValue);
                        }
                        
                    }
                    elseif( $fieldOptions['type'] == 'price' ){
                        $cellValue = Tools::displayPrice($cellValue);
                    }
                    elseif( $fieldOptions['type'] == 'bool' ){
                        $cellValue = $cellValue == '0' ? 'No' : 'Yes';
                    }
                }
                
                if( $fieldName == 'commision_value' ){
                    if( intval($dbRec['commision_type']) == Agentsales::DISCOUNT_TYPE_PERCENT ){
                        $cellValue .= '%'; 
                    }
                    elseif( intval($dbRec['commision_type']) == Agentsales::DISCOUNT_TYPE_AMOUNT ){
                        $cellValue = Tools::displayPrice($cellValue);
                    }
                }
                
                /*if( $fieldName == 'invoice_commision' || $fieldName == 'invoice_total_products' ){
                    $cellValue = Tools::displayPrice($cellValue);
                }*/
                
                $objPHPExcel
                    ->getActiveSheet()
                    ->setCellValue( (chr($colCharNum++).$rowNumber), $cellValue)
                ;
            }
        }
        
        $objPHPExcel->getActiveSheet()->setTitle('Commisions');
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
        
        //Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
    }
    
    /*
    public function renderList()
    {
        $listHtml = parent::renderList();

        echo $this->_listsql;
        return $listHtml;
    }*/
    /*
    private function _addMissedCommisions()
    {
        $query = '
            select aso.id_agent, aso.id_order, oi.id_order_invoice
            from `'._DB_PREFIX_.'agentsales_order` aso
            inner join `'._DB_PREFIX_.'order_invoice` oi on oi.id_order = aso.id_order
            where oi.number > 0
        ';
        
        $cooms = Db::getInstance()->executeS($query);
        //var_dump($cooms);die;
        foreach($cooms as $coms){
            $invoice = new OrderInvoice($coms['id_order_invoice']);
            
            $messages = $this->module->hookActionObjectOrderInvoiceAddAfter(array(
                'object' => $invoice
            ));
            echo implode('<br>', $messages).'<br>===========<br>';
        }
        die;
    }
    

    public function fixDoubles()
    {
        set_time_limit(60);
        $this->ajax = true;
        $q1 = '
            select id_invoice, count(id_invoice) as count from prs_agentsales_invoice
            group by id_invoice
            having count > 1
        ';
        
        $r1 = Db::getInstance()->executeS($q1);
        //var_dump($r1);
        
        $agq = '
            select id_agent from prs_agentsales_invoice
            where id_invoice = %d
            group by id_agent
        ';
        
        $aginvdblsQuery = '
            select * from prs_agentsales_invoice
            where id_invoice = %1$d and id_agent = %2$d
            order by id
        ';
        
        foreach( $r1 as $invoices ){
            $invAgents = Db::getInstance()->executeS( sprintf($agq, intval($invoices['id_invoice'])) );
            
            var_dump($invAgents);
            
            foreach($invAgents as $invAg){
                $doubles = Db::getInstance()->executeS( sprintf($aginvdblsQuery, intval($invoices['id_invoice']), intval($invAg['id_agent'])) );
                if(!is_array($doubles) || !count($doubles)){
                    continue;
                }
                var_dump($doubles);
                foreach($doubles as $di => $double){
                    if($di == 0){
                        echo 'SKIPING: '. $double['id'] .'<br>';
                        continue;
                    }
                    echo 'DELETING: '. $double['id'] .'<br>';
                    Db::getInstance()->delete('agentsales_invoice', 'id = '. $double['id']);
                }
            }
        }
    }

    public function fillEmptyComms()
    {
        set_time_limit(120);
        $this->ajax = 1;
        
        $agentsDefaultCommType = Configuration::get('AGENTSALES_COMM_TYPE');
        $agentsDefaultCommValue = Configuration::get('AGENTSALES_COMM_VALUE');
        
        
        $zeroVals = Db::getInstance()->executeS('
            select asi.* , c.agentsales_commision_type, c.agentsales_commision_value
            from `'._DB_PREFIX_.'agentsales_invoice` asi
            inner join `'._DB_PREFIX_.'customer` c on c.id_customer = asi.id_agent
            where (asi.commision_type = 0 OR asi.commision_value = 0)
        ');
        //
        foreach( $zeroVals as $i => $zeroRow ){
            var_dump($zeroRow);//if($i > 30){break;}
            
            $updateData = array();
            if( ($zeroRow['agentsales_commision_type'] == '0') && ($zeroRow['agentsales_commision_value'] == '0') ){
                $updateData['commision_type'] = $agentsDefaultCommType;
                $updateData['commision_value'] = $agentsDefaultCommValue;
            }
            else{
                $updateData['commision_type'] = $zeroRow['agentsales_commision_type'];
                $updateData['commision_value'] = $zeroRow['agentsales_commision_value'];
            }
            var_dump($updateData);
            
            Db::getInstance()->update('agentsales_invoice', $updateData,
                'id = '. intval($zeroRow['id']));
        }
    }
    
    public function movedatatoinvoices()
    {
        $query = '
            select aso.id_agent, aso.id_order, aso.commision_type, aso.commision_value, 
                aso.paidout, oi.id_order_invoice
            from `'._DB_PREFIX_.'agentsales_order` aso 
            inner join `'._DB_PREFIX_.'order_invoice` oi on oi.id_order = aso.id_order
            where oi.number > 0
        ';
        
        $cooms = Db::getInstance()->executeS($query);
        //var_dump($cooms);die;
        foreach($cooms as $coms){
            var_dump($coms);
            $comInvData = array(
                'id_agent' => $coms['id_agent'],
                'id_invoice' => $coms['id_order_invoice'],
                'commision_type' => $coms['commision_type'],
                'commision_value' => $coms['commision_value'],
                'paidout' => $coms['paidout']
            );
            
            Db::getInstance()->insert('agentsales_invoice', $comInvData);
        }
    }
    */
}