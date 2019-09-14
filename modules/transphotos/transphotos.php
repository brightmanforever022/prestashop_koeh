<?php

class Transphotos extends Module
{
    public $servers;
    
    public function __construct()
    {
        $this->name = 'transphotos';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'NSWEB';
        $this->need_instance = 0;
    
        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;
    
        parent::__construct();
    
        $this->displayName = $this->l('Transfer photos');
    
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => '1.6.99.99');
        
        $this->servers = array(
            'prod' => array(
                'www.vipdress.de' => 'https://www.vipdress.de/modules/transphotos/srv.php',
                'www.koehlert.com' => 'https://www.koehlert.com/modules/transphotos/srv.php',
            ),
            'dev' => array(
                'DEV-vipdress.de' => 'http://nsweb.server/vipdress/modules/transphotos/srv.php',
                'DEV-koehlert.com' => 'http://nsweb.server/koehlert/modules/transphotos/srv.php',
            )
        );
        
        if(!isset($this->local_path)){
            $this->local_path = dirname(__FILE__) .'/';
        }
    }
    
    public function getServerUrl($name)
    {
        foreach( $this->servers as $type => $srvs ){
            foreach( $srvs as $srvName => $srvUrl ){
                if( $srvName == $name ){
                    return $srvUrl;
                }
            }
        }
        
    }
    
    public function getContent()
    {
        if( isset($this->context) ){
            $domain = $this->context->shop->domain;
            $smarty = $this->context->smarty;
        }
        else{
            $domain = Configuration::get('PS_SHOP_DOMAIN');
            global $smarty;
        }

        $serversActual = array();
        foreach( $this->servers as $type => $srvs ){
            foreach( $srvs as $srvName => $srvUrl ){
                if( $srvName == $domain ){
                    $serversActual = $srvs;
                    unset($serversActual[$domain]);
                }
            }
        }
        if(!count($serversActual)){
            $serversActual = $this->servers['dev'];
        }
        if( count($serversActual) > 1 ){
            $serversActual = array_merge(array('Select server' => 'Select server'), $serversActual);
        }

        $smarty->assign('services', $serversActual);
        
        $smarty->assign('module_dir', $this->_path);
        
        $output = $smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
        
        return $output;
    }
    
}