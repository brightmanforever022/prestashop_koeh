<?php

class AdminAddressesController extends AdminAddressesControllerCore
{
    public function __construct()
    {
        parent::__construct();
        $this->fields_list['address1']['filter_key'] = 'a!address1';
        $this->fields_list['postcode']['filter_key'] = 'a!postcode';
        $this->fields_list['city']['filter_key'] = 'a!city';
    }
    
    // // removed "vat_number", "dni"
    public function renderForm()
    {
        $object = $this->loadObject();
        if( Validate::isLoadedObject($object) && intval($object->id_customer) && ($this->context->employee->id_profile != '1') ){
            if( !EmployeeArea::isCustomerInEmployeeArea($this->context->employee->id, $object->id_customer) ){
                $this->errors[] = Tools::displayError('This customer is not within your area.');
                return;
            }
        }
        
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Addresses'),
                'icon' => 'icon-envelope-alt'
            ),
            'input' => array(
                array(
                    'type' => 'text_customer',
                    'label' => $this->l('Customer'),
                    'name' => 'id_customer',
                    'required' => false,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Address alias'),
                    'name' => 'alias',
                    'required' => true,
                    'col' => '4',
                    'hint' => $this->l('Invalid characters:').' &lt;&gt;;=#{}'
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Other'),
                    'name' => 'other',
                    'required' => false,
                    'cols' => 15,
                    'rows' => 3,
                    'hint' => $this->l('Forbidden characters:').' &lt;&gt;;=#{}'
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'id_order'
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'address_type',
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'back'
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            )
        );
        
        $this->fields_value['address_type'] = (int)Tools::getValue('address_type', 1);
        
        $id_customer = (int)Tools::getValue('id_customer');
        if (!$id_customer && Validate::isLoadedObject($this->object)) {
            $id_customer = $this->object->id_customer;
        }
        if ($id_customer) {
            $customer = new Customer((int)$id_customer);
            $token_customer = Tools::getAdminToken('AdminCustomers'.(int)(Tab::getIdFromClassName('AdminCustomers')).(int)$this->context->employee->id);
        }
        
        $this->tpl_form_vars = array(
            'customer' => isset($customer) ? $customer : null,
            'tokenCustomer' => isset($token_customer) ? $token_customer : null,
            'back_url' => urldecode(Tools::getValue('back'))
        );
        
        // Order address fields depending on country format
        $addresses_fields = $this->processAddressFormat();
        // we use  delivery address
        $addresses_fields = $addresses_fields['dlv_all_fields'];
        
        // get required field
        $required_fields = AddressFormat::getFieldsRequired();
        
        // Merge with field required
        $addresses_fields = array_unique(array_merge($addresses_fields, $required_fields));
        
        $temp_fields = array();
        
        foreach ($addresses_fields as $addr_field_item) {
            if ($addr_field_item == 'company') {
                $temp_fields[] = array(
                    'type' => 'text',
                    'label' => $this->l('Company'),
                    'name' => 'company',
                    'required' => in_array('company', $required_fields),
                    'col' => '4',
                    'hint' => $this->l('Invalid characters:').' &lt;&gt;;=#{}'
                );
            } elseif ($addr_field_item == 'lastname') {
                if (isset($customer) &&
                    !Tools::isSubmit('submit'.strtoupper($this->table)) &&
                    Validate::isLoadedObject($customer) &&
                    !Validate::isLoadedObject($this->object)) {
                        $default_value = $customer->lastname;
                    } else {
                        $default_value = '';
                    }
        
                    $temp_fields[] = array(
                        'type' => 'text',
                        'label' => $this->l('Last Name'),
                        'name' => 'lastname',
                        'required' => true,
                        'col' => '4',
                        'hint' => $this->l('Invalid characters:').' 0-9!&amp;lt;&amp;gt;,;?=+()@#"�{}_$%:',
                        'default_value' => $default_value,
                    );
            } elseif ($addr_field_item == 'firstname') {
                if (isset($customer) &&
                    !Tools::isSubmit('submit'.strtoupper($this->table)) &&
                    Validate::isLoadedObject($customer) &&
                    !Validate::isLoadedObject($this->object)) {
                        $default_value = $customer->firstname;
                    } else {
                        $default_value = '';
                    }
        
                    $temp_fields[] = array(
                        'type' => 'text',
                        'label' => $this->l('First Name'),
                        'name' => 'firstname',
                        'required' => true,
                        'col' => '4',
                        'hint' => $this->l('Invalid characters:').' 0-9!&amp;lt;&amp;gt;,;?=+()@#"�{}_$%:',
                        'default_value' => $default_value,
                    );
            } elseif ($addr_field_item == 'address1') {
                $temp_fields[] = array(
                    'type' => 'text',
                    'label' => $this->l('Address'),
                    'name' => 'address1',
                    'col' => '6',
                    'required' => true,
                );
            } elseif ($addr_field_item == 'address2') {
                $temp_fields[] = array(
                    'type' => 'text',
                    'label' => $this->l('Address').' (2)',
                    'name' => 'address2',
                    'col' => '6',
                    'required' => in_array('address2', $required_fields),
                );
            } elseif ($addr_field_item == 'postcode') {
                $temp_fields[] = array(
                    'type' => 'text',
                    'label' => $this->l('Zip/Postal Code'),
                    'name' => 'postcode',
                    'col' => '2',
                    'required' => true,
                );
            } elseif ($addr_field_item == 'city') {
                $temp_fields[] = array(
                    'type' => 'text',
                    'label' => $this->l('City'),
                    'name' => 'city',
                    'col' => '4',
                    'required' => true,
                );
            } elseif ($addr_field_item == 'country' || $addr_field_item == 'Country:name') {
                $temp_fields[] = array(
                    'type' => 'select',
                    'label' => $this->l('Country'),
                    'name' => 'id_country',
                    'required' => in_array('Country:name', $required_fields) || in_array('country', $required_fields),
                    'col' => '4',
                    'default_value' => (int)$this->context->country->id,
                    'options' => array(
                        'query' => Country::getCountries($this->context->language->id),
                        'id' => 'id_country',
                        'name' => 'name'
                    )
                );
                $temp_fields[] = array(
                    'type' => 'select',
                    'label' => $this->l('State'),
                    'name' => 'id_state',
                    'required' => false,
                    'col' => '4',
                    'options' => array(
                        'query' => array(),
                        'id' => 'id_state',
                        'name' => 'name'
                    )
                );
            } elseif ($addr_field_item == 'phone') {
                $temp_fields[] = array(
                    'type' => 'text',
                    'label' => $this->l('Home phone'),
                    'name' => 'phone',
                    'required' => in_array('phone', $required_fields) || Configuration::get('PS_ONE_PHONE_AT_LEAST'),
                    'col' => '4',
                    'hint' => Configuration::get('PS_ONE_PHONE_AT_LEAST') ? sprintf($this->l('You must register at least one phone number.')) : ''
                );
            } elseif ($addr_field_item == 'phone_mobile') {
                $temp_fields[] = array(
                    'type' => 'text',
                    'label' => $this->l('Mobile phone'),
                    'name' => 'phone_mobile',
                    'required' =>  in_array('phone_mobile', $required_fields) || Configuration::get('PS_ONE_PHONE_AT_LEAST'),
                    'col' => '4',
                    'hint' => Configuration::get('PS_ONE_PHONE_AT_LEAST') ? sprintf($this->l('You must register at least one phone number.')) : ''
                );
            }
        }
        
        // merge address format with the rest of the form
        array_splice($this->fields_form['input'], 3, 0, $temp_fields);
        
        return AdminController::renderForm();
        
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
    }
    
    public function processUpdate()
    {
        $object = $this->loadObject();
        if( Validate::isLoadedObject($object) && intval($object->id_customer) && ($this->context->employee->id_profile != '1') ){
            if( !EmployeeArea::isCustomerInEmployeeArea($this->context->employee->id, $object->id_customer) ){
                $this->errors[] = Tools::displayError('This customer is not within your area.');
                return;
            }
        }
        
        return parent::processUpdate();
    }
    
    public function processDelete()
    {
        $object = $this->loadObject();
        
        if( Validate::isLoadedObject($object) && intval($object->id_customer) && $this->context->employee->id_profile != '1' ){
            if( !EmployeeArea::isCustomerInEmployeeArea($this->context->employee->id, $object->id_customer) ){
                $this->errors[] = Tools::displayError('This customer is not within your area.');
                return;
            }
        }
        
        return parent::processDelete();
    }
    
}