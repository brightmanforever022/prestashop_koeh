<?php


require_once _PS_TOOL_DIR_ . 'CurlWrapper/CurlWrapper.php';

if (!defined('_PS_VERSION_')){
    exit;
}

class Khlbasic extends Module
{
    public function __construct()
    {
        $this->name = 'khlbasic';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
    
        parent::__construct();
    
        //$this->controllers = array('map');
    
        $this->displayName = $this->l('Koehlert shop basic functions');
        
        /*$makesTab = new Tab ();
        $makesTab->class_name = 'AdminDbkStats';
        $makesTab->module = $this->name;
        $makesTab->id_parent = (int)Tab::getIdFromClassName ( 'AdminOrders' );
        foreach (Language::getLanguages () as $lang){
            $makesTab->name[(int)$lang['id_lang']] = 'DBK stats';
        }
        if (! $makesTab->save ()){
            $this->_errors[] = $this->l('Tab install error');
            return false;
        }*/
        
    }
    
    public function install()
    {
        if(!parent::install()){
            return false;
        }
        
        $this->registerHook('displayHeader');
        $this->registerHook('displayAdminOrderRight');
        $this->registerHook('actionValidateOrder');
        $this->registerHook('actionObjectAddressAddAfter');
        $this->registerHook('actionObjectAddressUpdateAfter');
        
        $makesTab = new Tab ();
        $makesTab->class_name = 'AdminKhlbasicOrderType';
        $makesTab->module = $this->name;
        $makesTab->id_parent = (int)Tab::getIdFromClassName ( 'AdminOrders' );
        foreach (Language::getLanguages () as $lang){
            $makesTab->name[(int)$lang['id_lang']] = 'Order types';
        }
        if (! $makesTab->save ()){
            $this->_errors[] = $this->l('Tab install error');
            return false;
        }
        
    }
    
    public function hookDisplayHeader($params)
    {
        $this->context->controller->addJS($this->_path.'cookies.js');
        $this->context->controller->addJS($this->_path.'hdpr.js');
        
        if( isset($_COOKIE['hide_price']) && ($_COOKIE['hide_price'] == 'true') ){
            return '<style>.content_price,.our_price_display{visibility:hidden;}</style>';
        }
        
    }

    public function hookDisplayAdminOrderRight($params)
    {
        $order = new Order($params['id_order']);
        
        $orderImagesDownloadUrl = '../modules/'. $this->name
            .'/admin.php?action=get_order_images&amp;id_order='. $params['id_order'];
        $orderEansDownloadUrl = '../modules/'. $this->name
            .'/admin.php?action=get_order_eans&amp;id_order='. $params['id_order'];
            
        //$orderTypeSelected = new OrderType($order->id_order_type);
        
        $orderTypesList = Db::getInstance()->executeS('
            SELECT id_order_type, `name`
            FROM `'._DB_PREFIX_.'order_type`
            ORDER BY `default` DESC, `name` ASC
        ');
        $orderTypes = array('0' => 'No type');
        foreach($orderTypesList as $orderType){
            $orderTypes[ $orderType['id_order_type'] ] = $orderType['name'];
        }
        
        $this->context->smarty->assign(array(
            'order_images_download_url' => $orderImagesDownloadUrl,
            'order_eans_download_url' => $orderEansDownloadUrl,
            'order_types' => $orderTypes,
            'order_type_selected' => $order->id_order_type
            
        ));
        
        return $this->context->smarty->fetch($this->local_path . '/views/templates/hook/displayAdminOrderRight.tpl');
        /*return '<div class="col-lg-12"><div class="panel">
            <a href="'.$downloadUrl.'" class="btn btn-primary" target="_blank">Download order images</a>
        </div></div>';*/
    }

    public function hookActionValidateOrder($params)
    {
        $this->setCustomerShipByInvoice($params['customer']);
    }
    
    public function hookActionObjectAddressAddAfter($params)
    {
        $this->addressSaveTrigger($params['object']);
    }
    
    public function hookActionObjectAddressUpdateAfter($params)
    {
        $this->addressSaveTrigger($params['object']);
    }
        
    protected function addressSaveTrigger($address)
    {
        if( empty($address->id_customer) || empty($address->vat_number)){
            return;
        }
        
        $customer = new Customer($address->id_customer);
        
        $customer->siret = $address->vat_number;
        
        try{
            $customer->update();
        }
        catch(Exception $e){
            
        }
    }
    
    protected function setCustomerShipByInvoice(&$customer)
    {
        if( $customer->ship_by_invoice == 1 ){
            return;
        }
        
        $ordersCount = Order::getCustomerNbOrders($customer->id);
        
        if( $ordersCount < 2 ){
            return ;
        }
        
        $email = Configuration::get('PS_SHOP_EMAIL');
        $message = "Following customer ID $customer->id ($customer->company) placed his second order.".
            "Please check if you can enable customer for pay by invoice setting. ";
        mail($email, 'Pay by invoice customer', $message);
        
    }

    
    public function hookActionObjectProductSupplierAddBefore($params)
    {
        $query = '
            SELECT ps.*
            FROM `'._DB_PREFIX_.'product_supplier` ps
            INNER JOIN `'._DB_PREFIX_.'product` p
                ON p.id_product = ps.id_product AND p.id_supplier = ps.id_supplier
            WHERE ps.`id_product` = '. intval($params['object']->id_product) .'
                AND ps.`id_product_attribute` = '. intval( $params['object']->id_product_attribute ) .'
                AND ps.product_supplier_reference != ""
        ';
        $productSupplierDefaultData = Db::getInstance()->getRow($query);
        if( is_array($productSupplierDefaultData) && !empty($productSupplierDefaultData['id_product_supplier']) ){
            $params['object']->product_supplier_reference = $productSupplierDefaultData['product_supplier_reference'];
        }
        
    }
    
    public function getPath()
    {
        return $this->_path;
    }
    
    public function getContent()
    {
        $errors = array();
        
        $this->html = '';
        
        if (Tools::isSubmit('submit'.$this->name)){
            Configuration::updateValue('KHLBSC_VD_API_KEY', Tools::getValue('KHLBSC_VD_API_KEY'));
            Configuration::updateValue('KHLBSC_BIG_SIZE_PRICE_IMPACT', Tools::getValue('KHLBSC_BIG_SIZE_PRICE_IMPACT'));
            //if (!)
            //    $errors[] = $this->l('Cannot update settings');
            
        }
        
        if (count($errors) > 0)
            $this->html .= $this->displayError(implode('<br />', $errors));
        
        $form = array(
            'form' => array(
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Vipdress API key'),
                        'name' => 'KHLBSC_VD_API_KEY',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Big size price impact'),
                        'name' => 'KHLBSC_BIG_SIZE_PRICE_IMPACT',
                        'desc' => $this->l('A percent to change the price of sizes 50 and bigger. Price changed by cron')
                    ),
                    
                ),
                
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                    'name' => 'submit'. $this->name,
                )
            )
        );
        
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submit'.$this->name.'Configuration';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name .'&tab_module='.$this->tab .'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        
        $form_fields_value = array(
            'KHLBSC_VD_API_KEY' => Configuration::get('KHLBSC_VD_API_KEY'),
            'KHLBSC_BIG_SIZE_PRICE_IMPACT' => Configuration::get('KHLBSC_BIG_SIZE_PRICE_IMPACT'),
        );
        
        $helper->tpl_vars = array(
            'fields_value' => $form_fields_value,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        
        $this->html .= $helper->generateForm(array($form));
        
        return $this->html;
    }
}

/*

select a.id_address, a.id_customer, a.vat_number, c.siret 
FROM prs_address a inner JOIN prs_customer c on c.id_customer = a.id_customer 
where a.`active` = 1 and a.`deleted` = 0 and a.vat_number != "" 
ORDER BY `a`.`id_customer` ASC

UPDATE prs_address a inner JOIN prs_customer c on c.id_customer = a.id_customer 
SET c.siret = a.vat_number
where a.`active` = 1 and a.`deleted` = 0 and a.vat_number != ""

 */