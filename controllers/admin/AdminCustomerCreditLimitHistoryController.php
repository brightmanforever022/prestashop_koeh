<?php

class AdminCustomerCreditLimitHistoryController extends AdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'customer_credit_limit_history';
        $this->className = 'CustomerCreditLimitHistory';
        $this->lang = false;
        $this->explicitSelect = true;
        $this->_defaultOrderBy = 'a!date_add';
        $this->_defaultOrderWay = 'DESC';
        $this->allow_export = true;
        $this->list_no_link = true;
        
        
        $this->fields_list = array(
            'customer_name' => array(
                'title' => $this->l('Customer'),
                'filter_key' => 'a!id_customer',
                'order' => false
            ),
            'credit_limit' => array(
                'title' => $this->l('Limit'),
                'filter_key' => 'a!credit_limit',
                //'type' => 'select',
                //'list' => $titles_array,
                'filter_type' => 'int',
                //'order_key' => 'gl!name'
            ),
            'employee_name' => array(
                'title' => $this->l('Employee'),
                'filter_key' => 'a!id_employee',
                'order' => false
                
            ),
            'note' => array(
                'title' => $this->l('Note'),
                'search' => false,
                'order' => false,
                'filter_key' => 'a!note',
            ),
            'date_add' => array(
                'title' => $this->l('Date add'),
                'type' => 'date',
                'align' => 'text-right',
                'filter_key' => 'a!date_add',
            ),
        );
        
        $this->_select .= 'a.id_customer_credit_limit_history,
            CONCAT_WS(" ", c.lastname, c.firstname) AS customer_name,
            CONCAT_WS(" ", e.lastname, e.firstname) AS employee_name
        ';
        $this->_join .= '
            LEFT JOIN `'._DB_PREFIX_.'customer` c ON a.id_customer = c.id_customer
            LEFT JOIN `'._DB_PREFIX_.'employee` e ON a.id_employee = e.id_employee
        ';
        
        parent::__construct();
    }
    
    public function renderForm()
    {
        $this->fields_form = array(
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Credit limit'),
                    'name' => 'credit_limit',
                    'required' => true,
                    'col' => '4',
                    //'hint' => $this->l('Invalid characters:').' 0-9!&lt;&gt;,;?=+()@#"°{}_$%:'
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Note'),
                    'name' => 'note',
                    'required' => true,
                    //'col' => '4',
                    //'hint' => $this->l('Invalid characters:').' 0-9!&lt;&gt;,;?=+()@#"°{}_$%:'
                ),
                
            )
        );
        
        return parent::renderForm();
    }
    
    /**
     * 
     * @param $object CustomerCreditLimitHistory
     * @see AdminControllerCore::beforeAdd()
     */
    public function beforeAdd($object)
    {
        $object->id_employee = $this->context->employee->id;
    }
    
    public function ajaxProcessAdd()
    {
        $this->redirect_after = false;
        //$this->ajax = true;
        $customerCreditLimitHistory = parent::processAdd();
        
        
        if( !count($this->errors) && !empty($customerCreditLimitHistory->id) ){
            $customer = new Customer($customerCreditLimitHistory->id_customer);
            $customer->credit_limit = $customerCreditLimitHistory->credit_limit;
            
            try{
                $customer->update();
            }
            catch(Exception $e){
                $this->errors[] = $e->getMessage();
                return;
            }
            
            $customerCreditLimitHistory->credit_limit_formatted = Tools::displayPrice($customerCreditLimitHistory->credit_limit);
            
            echo json_encode($customerCreditLimitHistory);die;
        }
        
        //print_r($customerCreditLimitHistory );
        
    }
    /*
    public function postProcess()
    {
        var_dump($_POST);
        parent::postProcess();
    }
    
    public function processAdd()
    {
        $customerCreditLimitHistory = parent::processAdd();
        print_r($customerCreditLimitHistory );
    }*/
}