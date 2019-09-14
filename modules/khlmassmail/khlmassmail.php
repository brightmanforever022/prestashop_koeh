<?php

require_once _PS_MODULE_DIR_ . 'khlmassmail/classes/MassmailTemplate.php';
require_once _PS_MODULE_DIR_ . 'khlmassmail/classes/MassmailReceiver.php';
require_once _PS_MODULE_DIR_ . 'khlmassmail/classes/MassmailReceiverOptions.php';
require_once _PS_MODULE_DIR_ . 'khlmassmail/classes/MassmailManager.php';

class Khlmassmail extends Module
{
    public function __construct()
    {
        $this->name = 'khlmassmail';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->displayName = $this->l('Mass mailing');
    }
    
    public function install()
    {
        if(!parent::install()){
            return false;
        }
        
        $tab = new Tab ();
        $tab->class_name = 'AdminMassMailTemplates';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName ( 'AdminCustomers' );
        foreach (Language::getLanguages () as $lang){
            $tab->name[(int)$lang['id_lang']] = 'Mass mailing';
        }
        if (! $tab->save ()){
            $this->_errors[] = $this->l('Tab install error');
            return false;
        }
        
        return true;
    }

    public function getPath()
    {
        return $this->_path;
    }
    
}