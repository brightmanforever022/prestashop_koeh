<?php

class AdminInvoiceRulesController extends AdminController
{

    public function __construct()
    {
        $this->bootstrap = true;
        //$this->required_database = true;
        $this->table = 'invoice_rule';
        $this->className = 'InvoiceRule';
        $this->lang = false;
        
        parent::__construct();
        
        $this->context = Context::getContext();
        
    }

    public function processSearchRuleNRedirect()
    {
        $template_id = (int)Tools::getValue('template_id');
        
        $invoiceRuleId = (int)Db::getInstance()->getValue('
            SELECT id_invoice_rule
            FROM `'._DB_PREFIX_.'invoice_rule`
            WHERE `template_id` = '. $template_id .'
        ');
        
        
        if( $invoiceRuleId ){
            Tools::redirectAdmin( $this->context->link->getAdminLink('AdminInvoiceRules').'&updateinvoice_rule&id_invoice_rule='.$invoiceRuleId );
        }
        else{
            Tools::redirectAdmin( $this->context->link->getAdminLink('AdminInvoiceRules').'&addinvoice_rule&template_id='. $template_id );
        }
    }
    
    public function renderForm()
    {
        $this->fields_form = array(
            'input' => array(
                array(
                    'type' => 'hidden',
                    'name' => 'template_id'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Ship by invoice'),
                    'desc' => $this->l('Customer have status "Ship by invoice"'),
                    'name' => 'ship_by_invoice',
                    'required' => true,
                    'is_bool' => true,
                    'values' => array(
                        array(
                            //'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            //'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('VAT confirmed'),
                    'desc' => $this->l('Customer\'s VAT ID set and confirmed'),
                    'name' => 'siret_confirmed',
                    'required' => true,
                    'is_bool' => true,
                    'values' => array(
                        array(
                            //'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            //'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    )
                ),
                array(
                    'type' => 'checkbox',
                    'label' => $this->l('Countries'),
                    'desc' => $this->l('Customer in one of this countries'),
                    'name' => 'country',
                    'required' => true,
                    'values' => array(
                        'query' => CountryCore::getCountries($this->context->employee->id_lang, true, false, false),
                        'id' => 'id_country',
                        'name' => 'country'
                    ),
                    'expand' => array(
                        'default' => 'show',
                        'show' => array(
                            'icon' => '',
                            'text' => $this->l('Show countries')
                        ),
                        'hide' => array(
                            'icon' => '',
                            'text' => $this->l('Hide countries')
                        )
                    )
                ),
                
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            )
            
        );
        
        if( empty($this->object->id) ){
            $this->fields_value['template_id'] = (int)Tools::getValue('template_id');;
        }
        else{
            $countriesStr = trim($this->object->country, '|');
            $objectCountries = explode('|', $countriesStr);
            
            if( is_array($objectCountries) ){
                foreach($objectCountries as $objectCountryId){
                    $this->fields_value['country_'.$objectCountryId] = $objectCountryId;
                }
            }
        }
        
        return parent::renderForm();
    }
    
    public function processAdd()
    {
        $object = parent::processAdd();
        
        if( $object ){
            Tools::redirectAdmin( $this->context->link->getAdminLink('AdminModules').'&configure=ba_prestashop_invoice' );
        }
    }
    
    public function beforeAdd($object)
    {
        $this->beforeSave($object);
    }
    
    public function processUpdate()
    {
        $object = parent::processUpdate();
        
        if( $object ){
            Tools::redirectAdmin( $this->context->link->getAdminLink('AdminModules').'&configure=ba_prestashop_invoice' );
        }
        
    }
    
    public function beforeUpdate(&$object)
    {
        $this->beforeSave($object);
    }
    
    public function renderList()
    {
        $this->informations[] = 'Rules not possible to edit here. '
            .'To edit invoice rules go to Invoice templates module and click Details on the template'
        ;
    }
    
    protected function beforeSave(&$object)
    {
        $countryIds = array();
        foreach( $_POST as $postName => $postValue ){
            $postCountryMatch = array();
            if( preg_match('#country_(\d+)#', $postName, $postCountryMatch) ){
                $countryIds[] = (int)$postCountryMatch[1];
            }
        }
        
        $object->country = '|'. implode('|', $countryIds ) . '|';
    }
}

