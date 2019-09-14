<?php

require_once _PS_ROOT_DIR_ . '/modules/khlsupply/classes/SupplyBook.php';

if (!defined('_PS_VERSION_')){
    exit;
}

class Khlsupply extends Module
{
    public function __construct()
    {
        $this->name = 'khlsupply';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
    
        parent::__construct();
    
        $this->displayName = $this->l('Koehlert supplier order planning');
    }
    
    public function install()
    {
        $triggerHooks = array(
            //'actionValidateOrder',
            //'actionObjectOrderUpdateAfter',
            //'actionOrderEdited',
            //'actionOrderStatusPostUpdate'
        );
    
        if(!parent::install()){
            return false;
        }
    
        foreach( $triggerHooks as $hookName ){
            if( !$this->registerHook($hookName) ){
                $this->uninstall();
                return false;
            }
        }
        
        $this->setupTab();
    
        return true;
    }
    
    protected function setupTab()
    {
        $tab = new Tab ();
        $tab->class_name = 'AdminSupplyBook';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName ( 'AdminCatalog' );
        foreach (Language::getLanguages () as $lang){
            $tab->name[(int)$lang['id_lang']] = 'Supplier order planning';
        }
        if (! $tab->save ()){
            $this->_errors[] = $this->l('Tab install error');
            return false;
        }
    
        return true;
    }

    public function getContent()
    {
        $errors = array();
    
        $this->html = '';
    
        if (Tools::isSubmit('submit'.$this->name)){
            Configuration::updateValue('KHLSPLBK_PRDCTN_DAYS', Tools::getValue('KHLSPLBK_PRDCTN_DAYS'));
        }
    
        if (count($errors) > 0)
            $this->html .= $this->displayError(implode('<br />', $errors));
    
            $form = array(
                'form' => array(
                    'input' => array(
                        array(
                            'type' => 'text',
                            'label' => $this->l('Production time, days'),
                            'name' => 'KHLSPLBK_PRDCTN_DAYS',
                            'desc' => $this->l('How many days supplier production normally takes')
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
                'KHLSPLBK_PRDCTN_DAYS' => Configuration::get('KHLSPLBK_PRDCTN_DAYS'),
            );
    
            $helper->tpl_vars = array(
                'fields_value' => $form_fields_value,
                'languages' => $this->context->controller->getLanguages(),
                'id_language' => $this->context->language->id
            );
    
            $this->html .= $helper->generateForm(array($form));
    
            return $this->html;
    }
    
}