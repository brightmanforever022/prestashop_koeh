<?php

class AdminKhlbasicOrderTypeController extends ModuleAdminController
{
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->table = 'order_type';
        $this->className = 'OrderType';
        $this->identifier = 'id_order_type';
        $this->context = Context::getContext();
        
        $this->_defaultOrderBy = 'name';
        $this->_defaultOrderWay = 'ASC';
        
    }
    
    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        
        $this->fields_list = array(
            'name' => array(
                'title' => $this->l('Name'),
                'filter_key' => 'name',
            )
        );
        
        return parent::renderList();
    }
    
    public function renderForm()
    {
        $this->toolbar_title = $this->l('Order type');
        
        $this->fields_form = array(
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Name'),
                    'name' => 'name',
                    'lang' => false,
                    'col' => 4,
                    'required' => true,
                    //'hint' => $this->trans('Invalid characters:', array(), 'Admin.Notifications.Info').' &lt;&gt;;=#{}'
                ),
            )
        );
        
        $this->fields_form['submit'] = array(
            'title' => $this->l('Save')
        );
        
        return parent::renderForm();
        
    }
}