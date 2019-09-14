<?php

class SupplierController extends SupplierControllerCore
{
    public function init()
    {
        FrontController::init();
    
        if( !Configuration::get('PS_DISPLAY_SUPPLIERS') ){
            header('HTTP/1.1 404 Not Found');
            header('Status: 404 Not Found');
            $this->setTemplate(_PS_THEME_DIR_.'404.tpl');
            return;
        }
        else{
            if ($id_supplier = (int)Tools::getValue('id_supplier')) {
                $this->supplier = new Supplier($id_supplier, $this->context->language->id);
            
                if (!Validate::isLoadedObject($this->supplier) || !$this->supplier->active) {
                    header('HTTP/1.1 404 Not Found');
                    header('Status: 404 Not Found');
                    $this->errors[] = Tools::displayError('The chosen supplier does not exist.');
                } else {
                    $this->canonicalRedirection();
                }
            }
        }
    }
    
    public function initContent()
    {
        if( !Configuration::get('PS_DISPLAY_SUPPLIERS') ){
            FrontController::initContent();
        }
        else{
            parent::initContent();
        }
    }
    
}