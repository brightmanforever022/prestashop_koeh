<?php

class AdminMainexclCustomersController extends ModuleAdminController
{
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->table = 'customer_main_to_excl';
        $this->className = 'CustomerMainToExcl';
        $this->identifier = 'id_customer_main_to_excl';
        $this->context = Context::getContext();
        
        $this->_defaultOrderBy = 'date_end';
        $this->_defaultOrderWay = 'DESC';
        $this->allow_export = true;        
    }
    
    public function ajaxProcessAdd()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        $customerMainId = (int)Tools::getValue('id_main');
        $customerExcludedId = (int)Tools::getValue('id_excluded');
        
        if( empty($customerMainId) || empty($customerExcludedId) ){
            $responseData['message'] = 'Invalid parameters';
            echo json_encode($responseData);
            return;
        }
        
        $customerMainExclusivityRow = Db::getInstance()->getRow('
            SELECT *
            FROM '._DB_PREFIX_.'customer_main_to_excl 
            WHERE id_excluded = '. $customerMainId .'
        ');

        if( empty($customerMainExclusivityRow) ){
            // create new group(bunch)
            $exclusivityBunchMax = Db::getInstance()->getValue('
                SELECT MAX(id_bunch)
                FROM '._DB_PREFIX_.'customer_main_to_excl
            ');
            $exclusivityBunchNew = $exclusivityBunchMax+1;
            
            $customerMainExclusivity = new CustomerMainToExcl();
            $customerMainExclusivity->id_bunch = $exclusivityBunchNew;
            $customerMainExclusivity->id_excluded = $customerMainId;
            
            try{
                $customerMainExclusivity->add();
            }
            catch( Exception $e ){
                $responseData['message'] = $e->getMessage();
                echo json_encode($responseData);
                return;
            }
            
            $customerMainExclusivityRow = Db::getInstance()->getRow('
                SELECT *
                FROM '._DB_PREFIX_.'customer_main_to_excl
                WHERE id_excluded = '. $customerMainId .'
            ');
        }
        
        $customerMainToExcluded = new CustomerMainToExcl();
        $customerMainToExcluded->id_bunch = $customerMainExclusivityRow['id_bunch'];
        $customerMainToExcluded->id_excluded = $customerExcludedId;
        
        try{
            $customerMainToExcluded->add();
        }
        catch( Exception $e ){
            $responseData['message'] = $e->getMessage();
            echo json_encode($responseData);
            return;
        }
        
        $responseData['success'] = true;
        $responseData['data'] = $customerMainToExcluded->getFields();
        
        echo json_encode($responseData);
    }
    
    public function ajaxProcessList()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        $customerMainId = (int)Tools::getValue('id_main');
        if( empty($customerMainId) ){
            $responseData['message'] = 'Invalid parameters';
            echo json_encode($responseData);
            return;
        }
        
        /**
         * 
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query
            ->select('ce2m.id_customer_main_to_excl, ce2m.id_excluded, c.company, c.firstname, c.lastname')
            ->from('customer_main_to_excl', 'cm2e')
            ->innerJoin('customer_main_to_excl', 'ce2m', 'ce2m.id_bunch = cm2e.id_bunch')
            ->innerJoin('customer', 'c', 'c.id_customer = ce2m.id_excluded')
            ->where('cm2e.id_excluded = '. $customerMainId)
            ->where('ce2m.id_excluded != '. $customerMainId)
        ;
        
        $customersExcluded = Db::getInstance()->executeS($query);
        
        $this->context->smarty->assign(array(
            'customers_excluded' => $customersExcluded,
            //'mainexcl_controller_url' => $this->context->link->getAdminLink('AdminMainexclCustomers')
        ));
        
        $responseData['data'] = $this->context->smarty->fetch($this->module->getLocalPath() . '/views/templates/admin/customers_excluded_list.tpl');
        $responseData['success'] = true;
        echo json_encode($responseData);
    }
    
    public function ajaxProcessRemove()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        $mainToExclId = (int)Tools::getValue('id_main_to_excl');
        
        if( empty($mainToExclId) ){
            $responseData['message'] = 'Invalid parameters';
            echo json_encode($responseData);
            return;
        }
        
        $customerMainToExcluded = new CustomerMainToExcl($mainToExclId);
        
        try{
            $customerMainToExcluded->delete();
        }
        catch( Exception $e ){
            $responseData['message'] = $e->getMessage();
            echo json_encode($responseData);
            return;
        }
        
        $responseData['success'] = true;
        
        echo json_encode($responseData);
    }

    public function ajaxProcessAddedToCartLog()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        //$id_customer = (int)Tools::getValue('id_customer');
        $id_cart = (int)Tools::getValue('id_cart');
        $id_product = (int)Tools::getValue('id_product');
        
        $logMessage = "Excluded customers, product added to cart. Product:$id_product, Cart:$id_cart";
        
        PrestaShopLogger::addLog($logMessage);
        
        $responseData['success'] = true;
        
        echo json_encode($responseData);
        
    }
}