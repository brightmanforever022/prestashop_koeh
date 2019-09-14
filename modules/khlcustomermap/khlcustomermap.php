<?php

require_once _PS_TOOL_DIR_ . 'CurlWrapper/CurlWrapper.php';

if (!defined('_PS_VERSION_')){
    exit;
}

class Khlcustomermap extends Module
{

    public function __construct()
    {
        $this->name = 'khlcustomermap';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->controllers = array('retailers');
        
        $this->displayName = $this->l('Koehlert customers map');
        
    }
    
    public function install()
    {
        if(!parent::install()){
            return false;
        }
        
        return true;
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
            Configuration::updateValue('KHLCSTMAP_GGL_MAP_API_KEY', Tools::getValue('KHLCSTMAP_GGL_MAP_API_KEY'));
        }
        
        if (count($errors) > 0){
            $this->html .= $this->displayError(implode('<br />', $errors));
        }
        
        $form = array(
            'form' => array(
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Google Maps API key'),
                        'name' => 'KHLCSTMAP_GGL_MAP_API_KEY',
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
            'KHLCSTMAP_GGL_MAP_API_KEY' => Configuration::get('KHLCSTMAP_GGL_MAP_API_KEY')
        );
        
        $helper->tpl_vars = array(
            'fields_value' => $form_fields_value,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
        
        $this->html .= $helper->generateForm(array($form));
        
        return $this->html;
    }
    
    /**
     * 
     * @param Customer $customer
     */
    public function extractCustomerAddress($customer)
    {
        $languageDefaultId = (int) Configuration::get('PS_LANG_DEFAULT');
        $addressString = '';
        $addressString .= $customer->address1 .' '. $customer->address2;
        $addressString .= ', '. $customer->city;
        $addressString .= ' '. $customer->postcode;
        $customerCountry = Country::getNameById($languageDefaultId, $customer->id_country);
        $addressString .= ', '. $customerCountry;
        
        $addressString = strip_tags($addressString);
        
        return $addressString;
    }
    
    public function geocodeAddress($addressText)
    {
        $curlWrapper = new CurlWrapper();
        $googleGeocodeUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
        $geocodeParams = array(
            'key' => Configuration::get('KHLCSTMAP_GGL_MAP_API_KEY'),
            'address' => $addressText
        );
        
        $curlWrapper->addOption(CURLOPT_SSL_VERIFYPEER, false);
        
        try {
            $geocodeResponse = $curlWrapper->get($googleGeocodeUrl, $geocodeParams);
        } 
        catch (Exception $e) {
            PrestaShopLoggerCore::addLog($e->getMessage() . ', '. $e->getTraceAsString(), 4);
            throw $e;
        }
        
        $geocoded = json_decode($geocodeResponse, true);
        
        if( !is_array($geocoded) ){
            throw new Exception( 'Response not decoded' );
        }

        if($geocoded['status'] != 'OK'){
            throw new Exception( 'Status: '. $geocoded['status'] .'. Address not geocoded: '. $addressText );
        }
        
        return array(
            'latitude' => $geocoded['results'][0]['geometry']['location']['lat'],
            'longitude' => $geocoded['results'][0]['geometry']['location']['lng']
        );
        
    }
}

