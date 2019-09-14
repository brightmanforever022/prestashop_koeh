<?php

require_once _PS_MODULE_DIR_ .'ba_prestashop_invoice/ba_prestashop_invoice.php';
require_once _PS_MODULE_DIR_ .'ba_prestashop_invoice/includes/baorderinvoice.php';

require_once _PS_MODULE_DIR_ .'agentsales/classes/AgentSalesCountry.php';
require_once _PS_MODULE_DIR_ .'agentsales/classes/AgentSalesManager.php';

if (!defined('_PS_VERSION_'))
    exit;

class Agentsales extends Module
{
    const DISCOUNT_TYPE_PERCENT = 1;
    const DISCOUNT_TYPE_AMOUNT = 2;
    
    protected $config_form = false;
    
    public function __construct()
    {
        $this->name = 'agentsales';
        $this->tab = 'advertising_marketing';
        $this->version = '0.5.0';
        $this->author = 'NSWEB';
        $this->need_instance = 0;
        $this->bootstrap = true;
    
        //$this->controllers = array('commisions');
        
        parent::__construct();
    
        $this->displayName = $this->l('Agents sales');
        $this->description = $this->l('Koehlert agents sales');
    
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => '1.6.99.99');
        
        if( Module::isInstalled('agentsales') ){
            if(!$this->registerHooks()){
                PrestaShopLogger::addLog('Failed to register required hooks', 4, 1, 'Agentsales');
            }
        }
    }

    public function getAgentsList($id_employee = 0)
    {
        $agentsCustomerGroup = (int)Configuration::get('AGENTSALES_AGENT_GROUP');
        /**
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query->select('c.id_customer, c.company, c.firstname, c.lastname, c.email, 
            agentsales_commision_type,agentsales_commision_value,agentsales_id_employee');
        $query->from('customer', 'c');
        $query->innerJoin('customer_group', 'g', 'g.id_customer = c.id_customer');
        $query->where('g.id_group = '. $agentsCustomerGroup);
        if($id_employee > 0){
            $query->where('c.agentsales_id_employee = '. intval($id_employee));
        }
        $query->orderBy('c.lastname');
        
        return Db::getInstance()->executeS($query);
    }
    
    public function getCustomersOfAgent($id_agent)
    {
        /**
         *
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query->select('*');
        $query->from('customer');
        $query->where('agentsales_id_agent = '. (int)$id_agent );
        $query->orderBy('lastname');
        
        return Db::getInstance()->executeS($query);
        
    }
    
    /**
     * Is this employee can view and edit any agent
     * @return boolean
     */
    public function isAuthenticatedOwnerAdmin()
    {
        if( !empty($this->context->employee)
            && in_array($this->context->employee->id, $this->getWideAccessAdminIds())
        ){
            return true;
        }
        return false;
    }
    
    /**
     * @deprecated
     * @return number|NULL
     */
    public function getOwnerAdminId()
    {
        $shopEmployees = Db::getInstance()->executeS('
			SELECT *
			FROM `'._DB_PREFIX_.'employee`
			ORDER BY `lastname` ASC
		');
        foreach($shopEmployees as $employee){
            if( ($employee['id_profile'] == 1) && ($employee['email'] == 'info@vipdress.de') ){
                return intval($employee['id_employee']);
            }
        }
        return null;
    }
    
    /**
     * 
     * @return array
     */
    public function getWideAccessAdminIds()
    {
        $shopEmployees = Db::getInstance()->executeS('
			SELECT *
			FROM `'._DB_PREFIX_.'employee`
			ORDER BY `lastname` ASC
		');
        $adminIds = array();
        $accessEmails = array(
            'info@vipdress.de', 'developer@vipdress.de', 'davidszielenski@gmail.com', 'info@wheelronix.com'
        );
        foreach($shopEmployees as $employee){
            if( ($employee['id_profile'] == 1) && in_array($employee['email'], $accessEmails) ){
                $adminIds[] = intval($employee['id_employee']);
            }
        }
        
        return $adminIds;
    }
    
    
    public function getSalesByOrder($id_order)
    {
        /**
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query->select('*');
        $query->from('agentsales_order');
        $query->where('id_order = '. (int)$id_order);
        
        return Db::getInstance()->executeS($query);
    }
    
    // admin customer view
    public function hookDisplayAdminCustomers($params)
    {
        $agentsCustomersGroup = (int)Configuration::get('AGENTSALES_AGENT_GROUP');
        $customer = new Customer((int)$params['id_customer']);
        $customerGroups = $customer->getGroups();
        
        if( !in_array($agentsCustomersGroup, $customerGroups) ){
            return;
        }
        
        $customers = $this->getCustomersOfAgent($customer->id);
        
        $this->context->smarty->assign(array(
            'id_agent' => $customer->id,
            'customers_json' => json_encode($customers),
            'trnsl_Add' => $this->l('Add'),
            'trnsl_Remove' => $this->l('Remove'),
            'trnsl_No_Results' => $this->l('No results found'),
            'agentsalesAgentsControllerUrl' => $this->context->link->getAdminLink('AdminAgentsalesAgents')
        ));
        
        return $this->context->smarty->fetch($this->local_path.'views/templates/admin/customer.tpl');
    }
    
    public function hookActionObjectCustomerUpdateBefore(&$params)
    {
        $agentsales_countries = array();
        foreach( $_POST as $postKey => $postValue ){
            if( preg_match('#^agentsales_countries_(\d+)#', $postKey, $agentsales_countries_match) ){
                $agentsales_countries[] = intval($agentsales_countries_match[1]);
            }
        }

        $params['object']->agentsales_countries = json_encode($agentsales_countries);
    }
    
    public function hookActionAdminCustomersFormModifier($params)
    {
        $agentsCustomersGroup = (int)Configuration::get('AGENTSALES_AGENT_GROUP');
        $id_customer = (int)Tools::getValue('id_customer');
        $customer = new Customer($id_customer);
        $customerGroups = $customer->getGroups();
        
        if( !in_array($agentsCustomersGroup, $customerGroups) ){
            $agents = array(array('id' => '0', 'name' => $this->l('No agent')));
            $agentsList = $this->getAgentsList();
            foreach( $agentsList as $agentItem ){
                $agents[] = array(
                    'id' => $agentItem['id_customer'],
                    'name' => $agentItem['lastname'] .' '. $agentItem['firstname'] .' ('.$agentItem['company'].')'
                );
            }
            
            $params['fields'][] = array(
                'form' => array(
                    'legend' => array(
                        'title' => 'Module '. $this->displayName
                    ),
                    'input' => array(
                        array(
                            'type' => 'select',
                            'label' => $this->l('Customer\'s agent'),
                            'name' => 'agentsales_id_agent',
                            'multiple' => false,
                            'required' => false,
                            'desc' => $this->l('Shows to which agent belongs this customer, agent will receive commisions from orders of this customer'),
                            'options' => array(
                                'query' => $agents,
                                'id' => 'id',
                                'name' => 'name'
                            )
                        ),
                    ),
                    'submit' => array(
                        'title' => $this->l('Save')
                    )
                    
                )
            );
            
            $params['fields_value']['agentsales_id_agent'] = $customer->agentsales_id_agent;
        }
        // Form for agent options
        else{
            $employeeOwnerId = $this->getOwnerAdminId();
            $shopEmployees = Employee::getEmployees();
            $employeeOptions = array(
                array('id' => 0, 'name' => '---')
            );
            
            foreach($shopEmployees as $employee){
                if( $employee['id_employee'] == $employeeOwnerId ){
                    continue;
                }
                $employeeOptions[] = array(
                    'id' => $employee['id_employee'],
                    'name' => $employee['lastname'] .' '. $employee['firstname']
                );
            }
            
            $countries = CountryCore::getCountries($this->context->employee->id_lang);
            
            $formConfig = array(
                'form' => array(
                    'legend' => array(
                        'title' => 'Agents commision'
                    ),
                    'input' => array(
                        array(
                            'col' => 3,
                            'type' => 'radio',
                            //'prefix' => '%',
                            'required' => true,
                            'name' => 'agentsales_commision_type',
                            'label' => $this->l('Agent\'s commision type'),
                            'values' => array(
                                array(
                                    'id' => 'agentsales_commision_type_1',
                                    'value' => self::DISCOUNT_TYPE_PERCENT,
                                    'label' => $this->l('Percent') .' (%)'
                                ),
                                array(
                                    'id' => 'agentsales_commision_type_2',
                                    'value' => self::DISCOUNT_TYPE_AMOUNT,
                                    'label' => $this->l('Amount')
                                )
                            ),
                        ),
                        array(
                            'col' => 3,
                            'type' => 'text',
                            'required' => true,
                            'name' => 'agentsales_commision_value',
                            'label' => $this->l('Agent\'s commision value'),
                        ),
                        array(
                            'col' => 3,
                            'type' => 'textarea',
                            'required' => true,
                            'name' => 'agentsales_customer_exclude',
                            'label' => $this->l('Exclude customers'),
                            'desc' => $this->l('Customers ID from which agent will not receive commision. Each ID on a new line'),
                            'rows' => '10'
                        ),
                        
                    ),
                    'submit' => array(
                        'title' => $this->l('Save')
                    )
                )
            );
            
            if( $this->isAuthenticatedOwnerAdmin() ){
                $formConfig['form']['input'][] = array(
                    'col' => 9,
                    'type' => 'select',
                    'label' => $this->l('Admin of agent'),
                    'desc' => $this->l('Admin account that can manage this agent'),
                    'name' => 'agentsales_id_employee',
                    'multiple' => false,
                    'required' => false,
                    'options' => array(
                        'query' => $employeeOptions,
                        'id' => 'id',
                        'name' => 'name'
                    )
                );
            
            }
            $params['fields'][] = $formConfig;

            $params['fields_value']['agentsales_commision_type'] = $customer->agentsales_commision_type;
            $params['fields_value']['agentsales_commision_value'] = $customer->agentsales_commision_value;
            $params['fields_value']['agentsales_id_employee'] = $customer->agentsales_id_employee;
            $params['fields_value']['agentsales_customer_exclude'] = $customer->agentsales_customer_exclude;
            
        }
        
    }
    
    public function hookActionAdminControllerSetMedia()
    {
    
        $this->context->controller->addJs($this->_path.'js/back.js');
    }
    
    public function hookDisplayAdminOrderRight($params)
    {
        $agents = array();
    
        if( $this->isAuthenticatedOwnerAdmin() ){
            $agentsList = $this->getAgentsList();
        }
        else{
            $agentsList = $this->getAgentsList($this->context->employee->id);
        }
        
        
        foreach( $agentsList as $agentInfo ){
            $agentInfo['editable'] = true;
            $agents[] = $agentInfo;
        }
    
        //$agentSalesOrder = $this->getOrderData($params['id_order']);
        $agentsSales = $this->getSalesByOrder($params['id_order']);
        $orderAgents = array();
        foreach($agentsSales as $agentSale){
            $orderAgents[] = $agentSale['id_agent'];
        }
    
        if(is_array($agents)){
            foreach($agents as $ai => $agent){
                if(is_array($orderAgents) && in_array($agent['id_customer'], $orderAgents)){
                    $agents[$ai]['selected'] = true;
                }
                else{
                    $agents[$ai]['selected'] = false;
                }
            }
        }
    
        $this->context->smarty->assign(array(
            'id_order' => $params['id_order'],
            'agents' => $agents,
            //'agentsales_order' => $agentSalesOrder,
            'authenticated_owner_admin' => intval($this->isAuthenticatedOwnerAdmin()),
            'agentsalesAgentsControllerUrl' => $this->context->link->getAdminLink('AdminAgentsalesAgents')
        ));
        //$this->context->controller->addJqueryPlugin('select2');
        //$this->addBackJs();
    
        return $this->context->smarty->fetch($this->local_path.'views/templates/admin/display_admin_order_right.tpl');
    }
    
    public function hookActionValidateOrder($params)
    {
        if(empty($params['cart']->id_customer)){
            return;
        }
        
        $agentsCustomerGroup = (int)Configuration::get('AGENTSALES_AGENT_GROUP');
        
        
        $customer = new Customer($params['cart']->id_customer);
        $agentsManager = new AgentSalesManager($this);
        
        $agentsToOrderLink = $agentsManager->getAreaAgents($customer);
        
        $logMessage = 'Order #'. $params['order']->id .'. ';
        if( !count($agentsToOrderLink) ){
            $logMessage = 'No agents found for order';
        }
        else{
            foreach($agentsToOrderLink as $agent){
                try{
                    $this->linkCustomerOrderToAgent($agent, $params['order']);
                }
                catch(Exception $e){
                    PrestaShopLogger::addLog($e->getMessage(), 3);
                }
            }
            
            $linkedAgents = $this->getSalesByOrder($params['order']->id);
            $logMessage .= 'Agents: ';
            foreach( $linkedAgents as $linkedAgent ){
                $logMessage .= $linkedAgent['id_agent'] . ' ; ';
            }
            
        }
        
        
        PrestaShopLogger::addLog($logMessage, 1);
        mail('vitaliy@newstyleweb.net', 'Order agents', $logMessage);
    }
    
    public function hookActionObjectOrderInvoiceAddAfter($params)
    {
        //var_dump($params);
        $messages = array();
        $id_order = intval($params['object']->id_order);
        
        if( !intval($params['object']->number) ){
            return;
        }
        
        if( $params['object']->template_id > 0 ){
            $baOrderInvoiceTemplateData = Db::getInstance()->getRow('
                SELECT * FROM `'._DB_PREFIX_.'ba_prestashop_invoice`
                WHERE id = '. intval($params['object']->template_id) .'
            ');
            if( is_array($baOrderInvoiceTemplateData) && !empty($baOrderInvoiceTemplateData['id']) ){
                if( $baOrderInvoiceTemplateData['agentsales_ignore'] == '1' ){
                    return;
                }
            }
        }
        
        $agentsCustomerGroup = (int)Configuration::get('AGENTSALES_AGENT_GROUP');
        $agentsDefaultCommType = Configuration::get('AGENTSALES_COMM_TYPE');
        $agentsDefaultCommValue = Configuration::get('AGENTSALES_COMM_VALUE');
        
        $order = new Order($id_order);
        
        $agentsLinkedToOrder = Db::getInstance()->executeS('
            SELECT * FROM `'._DB_PREFIX_.'agentsales_order`
            WHERE `id_order` = '. $order->id .'
        ');
        
        if( !is_array($agentsLinkedToOrder) || !count($agentsLinkedToOrder) ){
            return;
        }
        
        foreach($agentsLinkedToOrder as $agentToOrder){
            $agentToInvoiceCheck = Db::getInstance()->getRow('
                SELECT * FROM `'._DB_PREFIX_.'agentsales_invoice`
                WHERE `id_agent` = '. intval($agentToOrder['id_agent']) .'
                    AND `id_invoice` = '. intval($params['object']->id) .'
            ');
            if( is_array($agentToInvoiceCheck) && count($agentToInvoiceCheck) ){
                $messages[] = 'Invoice "'. $params['object']->number .'" already linked';
                
                continue;
            }
            
            $agent = new Customer(intval($agentToOrder['id_agent']));
            
            $agentsalesInvoiceData = array(
                'id_agent' => $agent->id,
                'id_invoice' => $params['object']->id,
                'commision_type' => 0,
                'commision_value' => 0,
                'paidout' => 0
                
            );
            if( empty($agent->agentsales_commision_type) ){
                $agentsalesInvoiceData['commision_type'] = $agentsDefaultCommType;
                $agentsalesInvoiceData['commision_value'] = $agentsDefaultCommValue;
            }
            else{
                $agentsalesInvoiceData['commision_type'] = $agent->agentsales_commision_type;
                $agentsalesInvoiceData['commision_value'] = $agent->agentsales_commision_value;
            }
            
            Db::getInstance()->insert('agentsales_invoice', $agentsalesInvoiceData);
            
            $messages[] = 'Invoice "'. $params['object']->number .'"'.
                ' linked to "'. $agent->lastname.' '. $agent->firstname .'"';
        }
        return $messages;
    }
    
    public function hookActionObjectOrderInvoiceDeleteAfter($params)
    {
        Db::getInstance()->delete('agentsales_invoice', 'id_invoice = '. $params['object']->id);
    }
    
    
    public function hookDisplayAdminCustomersFormAfter()
    {
        $customerId = (int)Tools::getvalue('id_customer', 0);
        
        if(!$customerId){
            return;
        }
        
        $agent = new Customer($customerId);
        $agentsCustomerGroup = (int)Configuration::get('AGENTSALES_AGENT_GROUP');
        $agentGroups = $agent->getGroups();
        
        if( !in_array($agentsCustomerGroup, $agentGroups) ){
            return;
        }
        
        
        $countriesList = CountryCore::getCountries($this->context->language->id);
        $countriesOptions = array();
        foreach($countriesList as $countryData){
            $countriesOptions[ $countryData['id_country'] ] = $countryData['country'];
        }
        
        $agentCountry = new AgentSalesCountry();
        
        $this->context->smarty->assign(array(
            'id_customer' => $customerId,
            'agentsalescountries_controller_url' => $this->context->link->getAdminLink('AdminAgentsalesCountries'),
            'countries_options' => $countriesOptions,
            'agent_country' => $agentCountry->getFields(),
        ));
        return $this->context->smarty->fetch($this->local_path . '/views/templates/admin/customer_form_after.tpl');
    }
    
    protected function linkCustomerOrderToAgent($agent, $order)
    {
        $agentsCustomerGroup = (int)Configuration::get('AGENTSALES_AGENT_GROUP');
        
        $agentGroups = $agent->getGroups();
        
        if( !in_array($agentsCustomerGroup, $agentGroups) ){
            throw new Exception('Customer does not belongs to agents group');
        }
        
        $agentsalesOrderData = array(
            'id_agent' => $agent->id,
            'id_order' => $order->id,
        );

        Db::getInstance()->insert('agentsales_order', $agentsalesOrderData);
    }
    
    public function addBackJs()
    {
        $this->context->smarty->assign('agentsalesAgentsControllerUrl',
            $this->context->link->getAdminLink('AdminAgentsalesOrders'));
        $this->context->controller->addJS($this->_path.'js/back.js');
    }
    
    public function getLocalPath()
    {
        return $this->local_path;
    }
    
    public function getGlobalPath()
    {
        return $this->_path;
    }
    
    /*
    public function getOrdersByVoucher($id_cart_rule = null, $id_voucher = null)
    {
        if( is_null($id_cart_rule) && !empty($id_voucher) ){
            $agentCurrentVoucherInfo = Db::getInstance()->getRow('
                SELECT * FROM `'._DB_PREFIX_.'agentcomm_agent_voucher`
                WHERE `id_agent_voucher` = '. $id_voucher .'
            ');
            $id_cart_rule = $agentCurrentVoucherInfo['id_voucher'];
        }
        else{
            $agentCurrentVoucherInfo = Db::getInstance()->getRow('
                SELECT * FROM `'._DB_PREFIX_.'agentcomm_agent_voucher`
                WHERE `id_voucher` = '. $id_cart_rule .'
            ');
        }
        
        $agentsCommision = (float)Configuration::get('AGENTCOMM_VCHR_COMM');
        $query = '
            SELECT 
        		a.id_currency, a.id_order, a.reference,
        		CONCAT(LEFT(c.`firstname`, 1), ". ", c.`lastname`) AS `customer`,
        		osl.`name` AS `osname`, a.valid,
                a.total_paid_tax_excl AS total, 
                a.total_discounts_tax_excl AS total_discounts, 
                a.total_products AS total_products,
        		ocr.value AS cart_rule_value, ocr.value_tax_excl AS cart_rule_value_tax_excl 
            FROM `'._DB_PREFIX_.'orders` a
            '. Shop::addSqlAssociation('orders', 'o'). '
    		LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = a.`id_customer`)
    		LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = a.`current_state`)
    		LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)$this->context->language->id.')
    		INNER JOIN `'._DB_PREFIX_.'order_cart_rule` ocr ON (ocr.id_order = a.`id_order` AND ocr.`id_cart_rule` = '. ((int)$id_cart_rule) .')
    		WHERE
    		    a.`valid` = 1
        ';
        $orders = Db::getInstance()->executeS($query);
        
        if( $agentCurrentVoucherInfo['agent_commision'] > 0 ){
            $agentsCommisionType = $agentCurrentVoucherInfo['agent_commision_type'];
            $agentsCommision = $agentCurrentVoucherInfo['agent_commision'];
        }
        
        $ordersTotal = 0;
        $commisionsTotal = 0;
        foreach($orders as $oi => $orderData){
            $orders[$oi]['total_products'] = round($orderData['total_products'], 2);
            $ordersTotal += ($orderData['total_products'] - $orderData['total_discounts']);
            $orders[$oi]['total_discounts'] = round($orderData['total_discounts'], 2);
            
            if( $agentsCommisionType == self::DISCOUNT_TYPE_PERCENT ){
                $orders[$oi]['order_commision'] = round(
                    ($orderData['total_products'] - $orderData['total_discounts']) / 100 * $agentsCommision, 2);
            }
            else{
                $orders[$oi]['order_commision'] = round($agentsCommision, 2);
            }
            $commisionsTotal += $orders[$oi]['order_commision'];
        }
        
        return array(
            'orders_list' => $orders,
            'orders_products_total' => $ordersTotal,
            //'agent_commision' => $agentsCommision,
            'current_voucher_info' => $agentCurrentVoucherInfo,
            'commision_total' => $commisionsTotal
        );
    }
    */
    
    
    public function getContent()
    {
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
            $this->_postProcess();
        }
        
        $this->context->smarty->assign('module_dir', $this->_path);
    
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
    
        return $output.$this->renderForm();
    }
    
    protected function renderForm()
    {
        $helper = new HelperForm();
    
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
    
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitAgentcommModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
        .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
    
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
    
        return $helper->generateForm(array($this->getConfigForm()));
    }
    
    protected function getConfigForm()
    {
        $groups = Group::getGroups($this->context->language->id);
        
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col' => 3,
                        'type' => 'radio',
                        //'prefix' => '%',
                        'required' => true,
                        //'desc' => $this->l(''),
                        'name' => 'AGENTSALES_COMM_TYPE',
                        'label' => $this->l('Agent\'s commision type'),
                        'values' => array(
                            array(
                                'id' => 'AGENTSALES_COMM_TYPE_1',
                                'value' => self::DISCOUNT_TYPE_PERCENT,
                                'label' => $this->l('Percent') .' (%)'
                            ),
                            array(
                                'id' => 'AGENTSALES_COMM_TYPE_2',
                                'value' => self::DISCOUNT_TYPE_AMOUNT,
                                'label' => $this->l('Amount')
                            )
                        ),
                    
                    ),
                    
                    array(
                        'col' => 3,
                        'type' => 'text',
                        //'prefix' => '%',
                        'required' => true,
                        //'desc' => $this->l('Agent\'s commision value'),
                        'name' => 'AGENTSALES_COMM_VALUE',
                        'label' => $this->l('Agent\'s commision value'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Agents customers group'),
                        'name' => 'AGENTSALES_AGENT_GROUP',
                        'multiple' => false,
                        'required' => true,
                        'options' => array(
                            'query' => $groups,
                            'id' => 'id_group',
                            'name' => 'name'
                        )
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }
    
    protected function getConfigFormValues()
    {
        return array(
            'AGENTSALES_COMM_TYPE' => Configuration::get('AGENTSALES_COMM_TYPE'),
            'AGENTSALES_COMM_VALUE' => Configuration::get('AGENTSALES_COMM_VALUE'),
            'AGENTSALES_AGENT_GROUP' => Configuration::get('AGENTSALES_AGENT_GROUP'),
        );
    }
    
    protected function _postProcess()
    {
        $form_values = $this->getConfigFormValues();
    
        foreach (array_keys($form_values) as $key)
            Configuration::updateValue($key, Tools::getValue($key));
    }
    
    private function registerHooks()
    {
        $hookData = Db::getInstance()->ExecuteS('
        	SELECT * FROM `' . _DB_PREFIX_ . 'hook` WHERE `name` = "actionObjectOrderInvoiceAddAfter"
        ');
        if( empty($hookData) ){
            $hook = new Hook();
            $hook->name = 'actionObjectOrderInvoiceAddAfter';
            $hook->title = 'actionObjectOrderInvoiceAddAfter';
            $hook->position = 1;
            $hook->add();
        }
        $hookData = Db::getInstance()->ExecuteS('
        	SELECT * FROM `' . _DB_PREFIX_ . 'hook` WHERE `name` = "actionObjectOrderInvoiceDeleteAfter"
        ');
        if( empty($hookData) ){
            $hook = new Hook();
            $hook->name = 'actionObjectOrderInvoiceDeleteAfter';
            $hook->title = 'actionObjectOrderInvoiceDeleteAfter';
            $hook->position = 1;
            $hook->add();
        }
        
        
        $hookData = Db::getInstance()->ExecuteS('
        	SELECT * FROM `' . _DB_PREFIX_ . 'hook` WHERE `name` = "actionAdminCustomersFormModifier"
        ');
        if( empty($hookData) ){
            $hook = new Hook();
            $hook->name = 'actionAdminCustomersFormModifier';
            $hook->title = 'actionAdminCustomersFormModifier';
            $hook->position = 1;
            $hook->add();
        }
        
        $hookData = Db::getInstance()->ExecuteS('
        	SELECT * FROM `' . _DB_PREFIX_ . 'hook` WHERE `name` = "actionObjectCustomerUpdateBefore"
        ');
        if( empty($hookData) ){
            $hook = new Hook();
            $hook->name = 'actionObjectCustomerUpdateBefore';
            $hook->title = 'actionObjectCustomerUpdateBefore';
            $hook->position = 1;
            $hook->add();
        }
        
        $hookData = Db::getInstance()->ExecuteS('
        	SELECT * FROM `' . _DB_PREFIX_ . 'hook` WHERE `name` = "displayAdminOrderRight"
        ');
        if( empty($hookData) ){
            $hook = new Hook();
            $hook->name = 'displayAdminOrderRight';
            $hook->title = 'displayAdminOrderRight';
            $hook->position = 1;
            $hook->add();
        }
        
        if(
            !$this->registerHook('adminCustomers')
            || !$this->registerHook('actionAdminControllerSetMedia')
            || !$this->registerHook('actionAdminCustomersFormModifier')
            || !$this->registerHook('actionObjectCustomerUpdateBefore')
            || !$this->registerHook('displayAdminOrderRight')
            || !$this->registerHook('actionValidateOrder')
            || !$this->registerHook('actionObjectOrderInvoiceAddAfter')
            || !$this->registerHook('actionObjectOrderInvoiceDeleteAfter')
        ){
            return false;
        }
    }
    
    public function install()
    {
        
        
        if( !parent::install() ){
            return false;
        }
        
        $tableCreateQuery =
        'CREATE TABLE `'._DB_PREFIX_.'agentsales_order` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_agent` int(11) NOT NULL,
            `id_order` int(11) NOT NULL,
            PRIMARY KEY  (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        /*
            `commision_type` int(11) NOT NULL DEFAULT "0",
            `commision_value` int(11) NOT NULL DEFAULT "0",
            `paidout` int(1),
        */
        if (Db::getInstance()->execute($tableCreateQuery) == false){
            $this->_errors[] = Db::getInstance()->getMsgError();
            return false;
        }
        
        $tableCreateQuery =
        'CREATE TABLE `'._DB_PREFIX_.'agentsales_invoice` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_agent` int(11) NOT NULL,
            `id_invoice` int(11) NOT NULL,
            `commision_type` int(11) NOT NULL DEFAULT "0",
            `commision_value` int(11) NOT NULL DEFAULT "0",
            `paidout` int(1),
            PRIMARY KEY  (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        
        if (Db::getInstance()->execute($tableCreateQuery) == false){
            $this->_errors[] = Db::getInstance()->getMsgError();
            return false;
        }
        
        
        $customerFieldQuery = '
            ALTER TABLE `'._DB_PREFIX_.'customer`
                ADD `agentsales_commision_type` int(11) NOT NULL DEFAULT "0",
                ADD `agentsales_commision_value` int(11) NOT NULL DEFAULT "0",
                ADD `agentsales_id_agent` int(11) NOT NULL DEFAULT "0"
        ';
        if (Db::getInstance()->execute($customerFieldQuery) == false){
            $this->_errors[] = Db::getInstance()->getMsgError();
            return false;
        }
        Configuration::updateValue('AGENTSALES_COMM_TYPE', 1);
        Configuration::updateValue('AGENTSALES_COMM_VALUE', 5);
        Configuration::updateValue('AGENTSALES_AGENT_GROUP', 0);
        
        $tab = new Tab ();
        $tab->class_name = 'AdminAgentsalesAgents';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName ( 'AdminOrders' );
        foreach (Language::getLanguages () as $lang){
            $tab->name[(int)$lang['id_lang']] = 'Agents sales';
        }
        if (! $tab->save ()){
            $this->_errors[] = $this->l('Tab "Agents sales" install error');
            return false;
        }
        return true;
    }
    
    public function uninstall()
    {
        
        $tabId = (int) Tab::getIdFromClassName('AdminAgentsalesAgents');
        $tab = new Tab($tabId);
        $tab->delete();
        
        
        Db::getInstance()->execute('DROP TABLE `'._DB_PREFIX_.'agentsales_order`');
        Db::getInstance()->query('ALTER TABLE `'._DB_PREFIX_.'customer` DROP `agentsales_commision_type`');
        Db::getInstance()->query('ALTER TABLE `'._DB_PREFIX_.'customer` DROP `agentsales_commision_value`');
        Db::getInstance()->query('ALTER TABLE `'._DB_PREFIX_.'customer` DROP `agentsales_id_agent`');
        return parent::uninstall();
    }
}

/**
ALTER TABLE `prs_customer` 
CHANGE `agentsales_commision_value` `agentsales_commision_value` DECIMAL(5,2) NOT NULL DEFAULT '0'; 

ALTER TABLE `prs_customer` ADD `agentsales_id_employee` INT NOT NULL AFTER `agentsales_id_agent`;

ALTER TABLE `prs_agentsales_invoice` ADD `date_paidout` DATE NOT NULL AFTER `paidout`;

ALTER TABLE `prs_customer` ADD `agentsales_countries` TEXT NOT NULL AFTER `agentsales_postcodes`;
*/