<?php

class AdminExclusivityController extends ModuleAdminController
{
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->table = 'exclusivity';
        $this->className = 'Exclusivity';
        $this->identifier = 'id_exclusivity';
        $this->context = Context::getContext();
        
        $this->_defaultOrderBy = 'date_end';
        $this->_defaultOrderWay = 'DESC';
        $this->allow_export = true;
        //$this->list_no_link = true;
        $this->addRowAction('edit');
        $this->addRowAction('details');
        
        $this->_select .= 'CONCAT(c.firstname, " ", c.lastname) AS customer_name';
        $this->_join .= '
            INNER JOIN `'._DB_PREFIX_.'customer` c ON c.id_customer = a.id_customer
        ';
        
        $this->fields_list = array(
            'customer_name' => array(
                'title' => $this->l('Customer'),
            ),
            'radius' => array(
                'title' => $this->l('Radius'),
            ),
            'amount' => array(
                'title' => $this->l('Amount to order'),
            ),
            'date_start' => array(
                'title' => $this->l('Start'),
                'type' => 'date',
            ),
            'date_end' => array(
                'title' => $this->l('End'),
                'type' => 'date',
            ),
            
        );
        
    }
    
    public function renderForm()
    {
        if (!($obj = $this->loadObject(true))) {
            return;
        }
        
        $customersSql = '
            SELECT `id_customer`, `email`, `firstname`, `lastname`
			FROM `'._DB_PREFIX_.'customer`
			WHERE active = 1 '.Shop::addSqlRestriction(Shop::SHARE_CUSTOMER).'
			ORDER BY `firstname` ASC
        ';
        $customers = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($customersSql);
        //$customers = Customer::getCustomers();
        foreach($customers as &$customerData){
            $customerData['name'] = $customerData['firstname'] .' '. $customerData['lastname'];
        }
        unset($customerData);
        
        $this->fields_form = array(
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'name' => 'status',
                    'required' => true,
                    'is_bool' => true,
                    'default_value' => 1,
                    'values' => array(
                        array(
                            'id' => 'status',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'status',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    )
                ),
                
                array(
                    'type' => 'select',
                    'label' => $this->l('Customer'),
                    'name' => 'id_customer',
                    'required' => true,
                    'options' => array(
                        'query' => $customers,
                        'id' => 'id_customer',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Radius'),
                    'name' => 'radius',
                    'required' => true,
                    'col' => '3',
                    'hint' => $this->l('Which area cover this customer, integer')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Dresses to order'),
                    'name' => 'amount',
                    'required' => true,
                    'col' => '3',
                    'hint' => $this->l('How many dresses customer must order during period')
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Date start'),
                    'name' => 'date_start',
                    'required' => true,
                    //'col' => '4',
                    'hint' => $this->l('Start date of period'),
                    'autocomplete' => 'off'
                ),
                array(
                    'type' => 'free',
                    'label' => $this->l('Date end'),
                    'name' => 'date_end',
                    //'required' => true,
                    //'readonly' => 'readonly',
                    //'col' => '4',
                    //'hint' => $this->l('Date end of period')
                ),
                
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            )
            
        );
        
        return parent::renderForm();
    }
    
    
    protected function copyFromPost(&$object, $table)
    {
        parent::copyFromPost($object, $table);
        
        $post_date_start = $_POST['date_start'];
        
        $dateStart = new DateTime($post_date_start);
        $exclusivityPeriod = new DateInterval('P1Y');
        $dateEnd = new DateTime($post_date_start);
        $dateEnd->add($exclusivityPeriod);
        
        $object->date_end = $dateEnd->format('Y-m-d');
    }
    
    public function renderDetails()
    {
        if (!($obj = $this->loadObject(true))) {
            return;
        }
        
        $this->context->smarty->assign(array(
            'exclusivity' => $obj
        ));
        
        //return $this->setTemplate('details.tpl');
        $this->content = $this->context->smarty->fetch($this->module->getTemplatePath('views/templates/admin/details.tpl'));
    }
}