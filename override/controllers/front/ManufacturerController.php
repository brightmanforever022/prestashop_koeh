<?php

class ManufacturerController extends ManufacturerControllerCore
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
            if ($id_manufacturer = Tools::getValue('id_manufacturer')) {
                $this->manufacturer = new Manufacturer((int)$id_manufacturer, $this->context->language->id);
                if (!Validate::isLoadedObject($this->manufacturer) || !$this->manufacturer->active || !$this->manufacturer->isAssociatedToShop()) {
                    header('HTTP/1.1 404 Not Found');
                    header('Status: 404 Not Found');
                    $this->errors[] = Tools::displayError('The manufacturer does not exist.');
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