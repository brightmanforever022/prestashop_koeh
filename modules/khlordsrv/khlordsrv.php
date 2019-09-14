<?php

if (!defined('_PS_VERSION_')){
    exit;
}

class Khlordsrv extends Module
{
    public function __construct()
    {
        $this->name = 'khlordsrv';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->controllers = array('orders');
        
        $this->displayName = $this->l('Order creation service');
        //$this->displayName = $this->l('Offers service for remote creating orders');
    }
    
    public function install()
    {
        if(!parent::install()){
            return false;
        }
        
        //$query = 'ALTER TABLE `prs_customer` ADD `order_create_key` VARCHAR(32) NOT NULL AFTER `discount`';
        
        $triggerHooks = array(
            'actionAdminCustomersFormModifier',
        );
        
        foreach( $triggerHooks as $hookName ){
            if( !$this->registerHook($hookName) ){
                $this->uninstall();
                return false;
            }
        }
        
        
        return true;
    }
    
    public function getContent()
    {
        $this->context->smarty->assign(array(
            'order_create_service_general_url' => $this->context->link->getModuleLink($this->name, 'orders'),
            'order_create_service_help_url' => $this->context->link->getModuleLink($this->name, 'orders') .'?action=help',
        ));
        
        return $this->context->smarty->fetch($this->local_path.'views/templates/admin/configuration.tpl');
        
    }
    
    public function hookActionAdminCustomersFormModifier($params)
    {
        $id_customer = (int)Tools::getValue('id_customer');
        $customer = new Customer($id_customer);
        
        $params['fields'][] = array(
            'form' => array(
                'legend' => array(
                    'title' => 'Module '. $this->displayName
                ),
                'input' => array(
                    array(
                        'type' => 'textbutton',
                        'label' => $this->l('Authentication key for order creation service'),
                        'name' => 'order_create_key',
                        'id' => 'code',
                        'required' => false,
                        'hint' => $this->l('Webservice account key.'),
                        'button' => array(
                            'label' => $this->l('Generate!'),
                            'attributes' => array(
                                'onclick' => 'gencode(32)'
                            )
                        )
                    ),
                    
                ),
                'submit' => array(
                    'title' => $this->l('Save')
                )
        
            )
        );
        
        $params['fields_value']['order_create_key'] = $customer->order_create_key;
        
    }
}