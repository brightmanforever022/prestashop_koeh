<?php

require_once _PS_ROOT_DIR_ . '/modules/khleans/EanManager.php';
require_once _PS_ROOT_DIR_ . '/modules/khleans/classes/Ean.php';

if (!defined('_PS_VERSION_'))
    exit;

class Khleans extends Module
{
    public function __construct()
    {
        $this->name = 'khleans';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->controllers = array('cron');
        
        $this->displayName = $this->l('EANs managment');
        //$this->setupTab();
    }
    
    
    public function hookActionObjectCombinationUpdateAfter($params)
    {
        $this->exportToVD(intval($params['object']->id_product), intval($params['object']->id));
    }
    
    public function hookActionObjectCombinationAddAfter($params)
    {
        $this->exportToVD(intval($params['object']->id_product), intval($params['object']->id));
    }
    
    
    public function exportToVD($id_product, $id_product_attribute = null)
    {
        $prodAttrsQuery = '
            SELECT ps.`product_supplier_reference` AS supplier_reference, pa.`ean13`
            FROM `'._DB_PREFIX_.'product_attribute` pa
            INNER JOIN `'._DB_PREFIX_.'product_supplier` ps
                ON ps.id_product_attribute = pa.id_product_attribute
                AND ps.id_product = pa.id_product
            WHERE pa.`id_product` = '. intval($id_product) .'
        ';
        
        $id_product_attribute = intval($id_product_attribute);
        if($id_product_attribute){
            $prodAttrsQuery .= ' AND pa.id_product_attribute = '. intval($id_product_attribute); 
        }
                
        $prodAttrs = Db::getInstance()->executeS($prodAttrsQuery);
        
        if( !is_array($prodAttrs) || !count($prodAttrs) ){
            return;
        }
        
        if($this->context->shop->domain == 'www.koehlert.com'){
            $remoteExportUrl = 'https://www.vipdress.de/modules/khleans/service.php';
        }
        else{
            $remoteExportUrl = 'http://nsweb.server/vipdress/modules/khleans/service.php';
        }
        
        $eansManager = new EanManager();
        
        try{
            $exportResult = $eansManager->exportToRemote($remoteExportUrl, $prodAttrs);
        }
        catch(Exception $e){
            PrestaShopLogger::addLog($e->getMessage());
        }
        return $exportResult;
        
    }
    
    public function install()
    {
        if(!parent::install()){
            return false;
        }
        
        $hookData = Db::getInstance()->ExecuteS('
        	SELECT * FROM `' . _DB_PREFIX_ . 'hook` WHERE `name` = "actionObjectCombinationUpdateAfter"
        ');
        if( empty($hookData) ){
            $hook = new Hook();
            $hook->name = 'actionObjectCombinationUpdateAfter';
            $hook->title = 'actionObjectCombinationUpdateAfter';
            $hook->position = 1;
            $hook->add();
        }
        $hookData = Db::getInstance()->ExecuteS('
        	SELECT * FROM `' . _DB_PREFIX_ . 'hook` WHERE `name` = "actionObjectCombinationAddAfter"
        ');
        if( empty($hookData) ){
            $hook = new Hook();
            $hook->name = 'actionObjectCombinationAddAfter';
            $hook->title = 'actionObjectCombinationAddAfter';
            $hook->position = 1;
            $hook->add();
        }
        
        
        if( 
            !$this->registerHook('actionObjectCombinationUpdateAfter')
            || !$this->registerHook('actionObjectCombinationAddAfter')
        ){
            return false;
        }
        
        $tableQuery = '
            CREATE TABLE `'._DB_PREFIX_.'ean` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `code` varchar(13) NOT NULL,
                `used` tinyint(1) NOT NULL,
                PRIMARY KEY  (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        ';
        Db::getInstance()->query($tableQuery);
        
        $this->setupTab();
        
        return true;
    }
    
    protected function setupTab()
    {
        $tab = new Tab ();
        $tab->class_name = 'AdminEans';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName ( 'AdminCatalog' );
        foreach (Language::getLanguages () as $lang){
            $tab->name[(int)$lang['id_lang']] = 'EANs';
        }
        if (! $tab->save ()){
            $this->_errors[] = $this->l('Tab install error');
            return false;
        }
        
    }
}

/**
ALTER TABLE `prs_ean` ADD `supplier_reference` VARCHAR(64) NOT NULL AFTER `used`;

ALTER TABLE `prs_ean` ADD `keeper` INT NOT NULL AFTER `supplier_reference`;
UPDATE `prs_ean` SET `keeper`= 1 WHERE used = 1
 * 
 */