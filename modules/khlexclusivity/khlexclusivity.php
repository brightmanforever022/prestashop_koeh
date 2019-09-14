<?php

require_once _PS_ROOT_DIR_ . '/modules/khlexclusivity/classes/Exclusivity.php';

class Khlexclusivity extends Module
{
    public function __construct()
    {
        $this->name = 'khlexclusivity';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->displayName = $this->l('Exclusivity');
    }
    
    public function hookDisplayAdminOrderContentOrder($params)
    {
        /**
         * @var DbQueryCore $customerOrdersQuery
         */
        $customerExclusivityQuery = new DbQuery();
        $customerExclusivityQuery
            ->select('id_exclusivity')
            ->from('exclusivity')
            ->where('id_customer = '. $params['customer']->id)
            ->where('date_start <= '. (new DateTime())->format('Ymd')  )
            ->where('date_end >= '. (new DateTime())->format('Ymd') )
            ->where('status = 1' )
        ;
        
        $customerExclusivity = Db::getInstance()->getRow($customerExclusivityQuery);

        if( is_array($customerExclusivity) && !empty($customerExclusivity['id_exclusivity']) ){
            $this->context->smarty->assign('customer_exclusivity', new Exclusivity($customerExclusivity['id_exclusivity']));
        }
    }
    
    public function hookDisplayAdminCustomers($params)
    {
        /**
         * @var DbQueryCore $customerOrdersQuery
         */
        $customerExclusivityQuery = new DbQuery();
        $customerExclusivityQuery
            ->select('id_exclusivity')
            ->from('exclusivity')
            ->where('id_customer = '. $params['id_customer'])
            ->where('date_start <= '. (new DateTime())->format('Ymd')  )
            ->where('date_end >= '. (new DateTime())->format('Ymd') )
            ->where('status = 1' )
        ;
        
        $customerExclusivity = Db::getInstance()->getRow($customerExclusivityQuery);
        
        if( is_array($customerExclusivity) && !empty($customerExclusivity['id_exclusivity']) ){
            $this->context->smarty->assign('exclusivity', new Exclusivity($customerExclusivity['id_exclusivity']));
        }
        else{
            $this->context->smarty->assign('exclusivity_url', 
                $this->context->link->getAdminLink('AdminExclusivity') .'&addexclusivity');
        }
        return $this->context->smarty->fetch($this->local_path . '/views/templates/admin/details_customer.tpl');
    }
    
    public function install()
    {
        if(!parent::install()){
            return false;
        }

        $this->setupHooks();
    
        $tab = new Tab ();
        $tab->class_name = 'AdminExclusivity';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName ( 'AdminCustomers' );
        foreach (Language::getLanguages () as $lang){
            $tab->name[(int)$lang['id_lang']] = 'Exclusivity';
        }
        if (! $tab->save ()){
            $this->_errors[] = $this->l('Tab install error');
            return false;
        }
    
        return true;
    }
    
    protected function setupHooks()
    {
        $hooks = array(
            'displayAdminOrderContentOrder',
            'displayAdminCustomers'
        );
        
        foreach($hooks as $hookName){
            $hookData = Db::getInstance()->ExecuteS('
            	SELECT * FROM `' . _DB_PREFIX_ . 'hook` WHERE `name` = "'. pSQL($hookName) .'"
            ');
            if( empty($hookData) ){
                $hook = new Hook();
                $hook->name = $hookName;
                $hook->title = $hookName;
                $hook->position = 1;
                $hook->add();
            }
            
            $this->registerHook($hookName);
        }
    }
    
}

/**

DROP TABLE IF EXISTS `prs_exclusivity`;
CREATE TABLE `prs_exclusivity` (
  `id_exclusivity` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `status` int(11) NOT NULL,
  `radius` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `prs_exclusivity`  ADD PRIMARY KEY (`id_exclusivity`);

ALTER TABLE `prs_exclusivity`  MODIFY `id_exclusivity` int(11) NOT NULL AUTO_INCREMENT;

 */