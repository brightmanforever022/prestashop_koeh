<?php

class AdminSupplyBookController extends ModuleAdminController
{
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
    
        $this->table = 'supply_book';
        $this->className = 'SupplyBook';
        $this->identifier = 'id';
        $this->context = Context::getContext();
    
        $this->_defaultOrderBy = 'date_production_start';
        $this->_defaultOrderWay = 'ASC';
        $this->allow_export = true;
        //$this->list_no_link = true;
        
        $this->addRowAction('edit');
        $this->addRowAction('delete');
    
        $this->fields_list = array(
            'name' => array(
                'title' => $this->l('Name'),
            ),
            'date_production_start' => array(
                'title' => $this->l('Prod. start'),
                'type' => 'date',
                'align' => 'text-right'
            )
        );
    }

    public function renderForm()
    {
        $this->fields_form = array(
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Name'),
                    'name' => 'name',
                    'required' => true,
                    'maxlength' => 32,
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Production start date'),
                    'name' => 'date_production_start',
                    'required' => false,
                ),
            )
        );
    
    
        $this->fields_form['submit'] = array(
            'title' => $this->l('Save'),
        );
    
        if (!($obj = $this->loadObject(true))) {
            return;
        }
    
        //$this->getFieldsValues($obj);
        
        $this->addJqueryUI('ui.datepicker');
        return parent::renderForm();
    }
    
    public function initPageHeaderToolbar()
    {
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['new_product'] = array(
                'href' => self::$currentIndex.'&addsupply_book&token='.$this->token,
                'desc' => $this->l('Add new', null, null, false),
                'icon' => 'process-icon-new'
            );
            $this->page_header_toolbar_btn['configure'] = array(
                'href' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=khlsupply&tab_module=administration&module_name=khlsupply',
                'desc' => $this->l('Configure', null, null, false),
            );
        }
        parent::initPageHeaderToolbar();
    }
    
}