<?php

require_once 'classes/GallerySource.php';
require_once 'classes/GalleryItem.php';
require_once 'classes/GalleryManager.php';

if (!defined('_PS_VERSION_')){
    exit;
}

class Khlphotogallery extends Module
{
    public function __construct()
    {
        $this->name = 'khlphotogallery';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        
        parent::__construct();
        
        //$this->controllers = array('');
        
        $this->displayName = $this->l('Create photos gallery to access via API');
        
    }
    
    public function getContent()
    {
        $errors = array();
        
        $this->html = '';
        
        if (Tools::isSubmit('submit'.$this->name)){
            Configuration::updateValue('KHLPGAL_GGL_DRV_CLIENT_ID', Tools::getValue('KHLPGAL_GGL_DRV_CLIENT_ID'));
            Configuration::updateValue('KHLPGAL_GGL_DRV_API_KEY', Tools::getValue('KHLPGAL_GGL_DRV_API_KEY'));
        }
        
        if (count($errors) > 0)
            $this->html .= $this->displayError(implode('<br />', $errors));
            
            $form = array(
                'form' => array(
                    'input' => array(
                        array(
                            'type' => 'text',
                            'label' => $this->l('Google Drive Client ID'),
                            'name' => 'KHLPGAL_GGL_DRV_CLIENT_ID',
                        ),
                        array(
                            'type' => 'text',
                            'label' => $this->l('Google Drive API key'),
                            'name' => 'KHLPGAL_GGL_DRV_API_KEY',
                        ),
                    ),
                    
                    'submit' => array(
                        'title' => $this->l('Save'),
                        'class' => 'btn btn-default pull-right',
                        'name' => 'submit'. $this->name,
                    )
                )
            );
            
            $helper = new HelperForm();
            $helper->show_toolbar = false;
            $helper->table = $this->table;
            $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            $helper->default_form_language = $lang->id;
            $helper->module = $this;
            $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
            $helper->identifier = $this->identifier;
            $helper->submit_action = 'submit'.$this->name.'Configuration';
            $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name .'&tab_module='.$this->tab .'&module_name='.$this->name;
            $helper->token = Tools::getAdminTokenLite('AdminModules');
            
            $form_fields_value = array(
                'KHLPGAL_GGL_DRV_CLIENT_ID' => Configuration::get('KHLPGAL_GGL_DRV_CLIENT_ID'),
                'KHLPGAL_GGL_DRV_API_KEY' => Configuration::get('KHLPGAL_GGL_DRV_API_KEY'),
            );
            
            $helper->tpl_vars = array(
                'fields_value' => $form_fields_value,
                'languages' => $this->context->controller->getLanguages(),
                'id_language' => $this->context->language->id
            );
            
            $this->html .= $helper->generateForm(array($form));
            
            return $this->html;
            
    }
    
    public function getPath()
    {
        return $this->_path;
    }
}