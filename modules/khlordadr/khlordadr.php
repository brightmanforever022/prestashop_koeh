<?php

if (!defined('_PS_VERSION_'))
    exit;

class Khlordadr extends Module
{
    public function __construct()
    {
        $this->name = 'khlordadr';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        
        parent::__construct();
        
        //$this->controllers = array('map');
        
        $this->displayName = $this->l('Adresses of orders');
    }
    
    public function install()
    {
        if(!parent::install()){
            return false;
        }
        
        $queries = array(
            'ALTER TABLE `'._DB_PREFIX_.'address` 
            ADD `latitude` decimal(13,8) DEFAULT NULL,
            ADD `longitude` decimal(13,8) DEFAULT NULL'
        );
        
        foreach( $queries as $query ){
            Db::getInstance()->query($query);
        }
        
        $this->registerHook('actionAdminControllerSetMedia');
        
        $tab = new Tab ();
        $tab->class_name = 'AdminKhlordadrAdr';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName ( 'AdminCustomers' );
        foreach (Language::getLanguages () as $lang){
            $tab->name[(int)$lang['id_lang']] = 'Customers finder';
        }
        if (! $tab->save ()){
            $this->_errors[] = $this->l('Tab "Customers finder" install error');
            return false;
        }
        
        
        return true;
    }
    
    
    public function getContent()
    {
        
        $this->context->smarty->assign(array(
            'module_adr_url' => $this->context->link->getAdminLink('AdminKhlordadrAdr'),
            'module_url' => $this->_path,
            'map_url' => $this->context->link->getModuleLink($this->name, 'map')
        ));
        
        return $this->context->smarty->fetch( _PS_MODULE_DIR_ . $this->name . '/configuration.tpl');
    }
    
    public function hookActionAdminControllerSetMedia($params)
    {
        $this->context->controller->addJqueryPlugin('select2');
    }
    
}
