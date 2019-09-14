<?php

/**
 * 
 * @author vitaliy
 * Customers in the group can not buy same products for certain period
 */

class Khlexclcstm extends Module
{

    public function __construct()
    {
        $this->name = 'khlexclcstm';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->displayName = $this->l('Main/excluded customers');
        
    }
    
    public function install()
    {
        if(!parent::install()){
            return false;
        }
        
        $this->setupHooks();
        
        $tab = new Tab ();
        $tab->class_name = 'AdminMainexclCustomers';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName ( 'AdminCustomers' );
        foreach (Language::getLanguages () as $lang){
            $tab->name[(int)$lang['id_lang']] = 'Main/excluded customers';
        }
        if (! $tab->save ()){
            $this->_errors[] = $this->l('Tab install error');
            return false;
        }
        
        return true;
    }
    
    public function setupHooks()
    {
        $hooks = array(
            'actionFrontControllerInit',
            'displayAdminCustomersFormAfter',
            'actionAdminControllerSetMedia'
        );
        
        foreach($hooks as $hookName){
            $hookData = Db::getInstance()->ExecuteS('
            	SELECT * FROM `' . _DB_PREFIX_ . 'hook` WHERE `name` = "'. pSQL($hookName) .'"
            ');
            if( empty($hookData) ){
                $hook = new Hook();
                $hook->name = $hookName;
                $hook->title = $hookName;
                $hook->position = 1;
                $hook->add();
            }
            
            $this->registerHook($hookName);
        }
        
    }
    
    public function getLocalPath()
    {
        return $this->local_path;
    }
    
    public function hookDisplayAdminCustomersFormAfter()
    {
        $customerId = (int)Tools::getvalue('id_customer', 0);
        
        if(!$customerId){
            return;
        }
        
        $this->context->smarty->assign(array(
            'id_customer' => $customerId,
            'mainexcl_controller_url' => $this->context->link->getAdminLink('AdminMainexclCustomers'),
            'excluded_period_days' => CustomerMainToExcl::EXCLUSIVE_PERIOD_DAYS
        ));
        return $this->context->smarty->fetch($this->local_path . '/views/templates/admin/customer_form_after.tpl');
    }
    
    public function hookActionFrontControllerInit(&$params)
    {
        if( !$params['controller'] instanceof CartController ){
            return;
        }
        
        if( !$this->context->cookie->exists() || !$this->context->customer->isLogged() ){
            return;
        }
        
        if( !Tools::getIsset('add') && !Tools::getIsset('update') ){
            return;
        }
        
        $id_product = (int)Tools::getValue('id_product', null);
        $id_product_attribute = (int)Tools::getValue('id_product_attribute', Tools::getValue('ipa'));
        $customization_id = (int)Tools::getValue('id_customization');
        $qty = abs(Tools::getValue('qty', 1));
        $id_address_delivery = (int)Tools::getValue('id_address_delivery');
        
        $buyAllowed = CustomerMainToExcl::getCustomerAbleToBuyProduct($this->context->customer->id, $id_product, $id_product_attribute);
        
        
        if( !$buyAllowed['allowed'] ){
            $message = $this->l('This dress can not be ordered in your area because it was ordered by another customer in your area already. Please do not hesitate to contact our customer service if you have questions.');
            $params['controller']->errors[] = $message;
            
            $logMessage = 'Excluded customer denied order: Product - '. $buyAllowed['data']['product']->supplier_reference . " : ";
            $logMessage .= 'Excluded customer cart: '. $this->context->cart->id ." ; ";
            foreach( $buyAllowed['data']['dominants'] as $dominantInfo ){
                $logMessage .= 'Primary customer: '. $dominantInfo['customer']->company ." ; ";
                $logMessage .= 'Order: '. $dominantInfo['order']['id_order'] .'; Date: '. $dominantInfo['order']['date_add'] ." || ";
                $logMessage .= "";
            }
            
            PrestaShopLogger::addLog($logMessage);
            
        }
        
    }
    
    public function hookActionAdminControllerSetMedia($params)
    {
        if( ($this->context->controller->controller_name == 'AdminCustomers') && Tools::getIsset('id_customer') && Tools::getIsset('updatecustomer') ){
            $this->context->controller->addJqueryPlugin('typewatch');
            $this->context->controller->addJS(($this->_path) . 'views/mainexcl_customers.js');
        }
        
    }
    
}


