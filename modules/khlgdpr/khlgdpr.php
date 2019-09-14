<?php

if (!defined('_PS_VERSION_'))
    exit;

class Khlgdpr extends Module
{
    public function __construct()
    {
        $this->name = 'khlgdpr';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        
        parent::__construct();
        
        //$this->controllers = array('cron');
        
        $this->displayName = $this->l('Cookies notif');
        
    }
    
    public function install()
    {
        if( !parent::install() ){
            return false;
        }
        
        if( !$this->registerHook('displayTemplate') 
            || !$this->registerHook('displayHeader')){
            return false;
        }
        
        return true;
    }
    
    public function hookDisplayTemplate($params)
    {
        return $this->context->smarty->fetch( _PS_MODULE_DIR_ . $this->name . '/footer.tpl');
    }
    
    public function hookDisplayHeader($params)
    {
        $this->context->controller->addCSS($this->_path.'front.css');
        $this->context->controller->addJS($this->_path.'front.js');
    }
    
}