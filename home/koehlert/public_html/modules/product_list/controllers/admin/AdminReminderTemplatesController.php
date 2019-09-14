<?php

class AdminReminderTemplatesController extends ModuleAdminController
{
    protected $_default_pagination = 1000;
    
    protected $_templates_dir;
    
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'reminder_template';// does not going to be used, just for PS to work 0_0
        
        $this->addRowAction('edit');
        
        $this->fields_list = array(
            'name' => array(
                'title' => $this->l('Template'),
                'align' => 'left'
            ),
        );
        
        $this->_templates_dir = _PS_MODULE_DIR_ . '/product_list/views/templates/reminders';
        
        parent::__construct();
    }

    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false)
    {
        $this->_list = array();
        
        $reminderTemplsFolders = array('de', 'en', 'es', 'fr', 'it');
        foreach( $reminderTemplsFolders as $folderLang ){
            $scanDirPath = $this->_templates_dir .'/'. $folderLang;
            $files = scandir( $scanDirPath );
            foreach($files as $file){
                if( is_dir($scanDirPath .'/'. $file) || ($file == '.') || ($file == '..')){
                    continue;
                }
                $this->_list[] = array(
                    'id_reminder_template' => $folderLang .'-'. $file,
                    'name' => strtoupper($folderLang) .' '. $file
                );
            }
        }
        
        
        $this->_listTotal = count($this->_list);
    }
    
    public function renderForm()
    {
        $id_reminder_template = Tools::getValue('id_reminder_template');

        
        $id_reminder_template_parts = explode('-', $id_reminder_template);
        $template_file_path = $this->_templates_dir .'/'. $id_reminder_template_parts[0] .'/'. $id_reminder_template_parts[1];
        $template_content = file_get_contents($template_file_path);
        
        $values = array();
        $values['description'] = $template_content;
        
        $loadRTE = true;
        if( $id_reminder_template_parts[1] == 'styles.css' ){
            $loadRTE = false;
        }
        
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Reminder template content'),
                ),
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Content'),
                        'name' => 'description',
                        'autoload_rte' => $loadRTE,
                        'required' => true,
                        'size' => 12,
                        'rows' => 50
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            )
        );
        $helper = new HelperForm();
        
        $helper->show_toolbar = false;
        //$helper->table = $this->table;
        $helper->module = $this->module;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->show_cancel_button = true;
        
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitReminderTemplate';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminReminderTemplates', false)
            .'&id_reminder_template='.$id_reminder_template;
        $helper->token = Tools::getAdminTokenLite('AdminReminderTemplates');
        
        $helper->tpl_vars = array(
            'fields_value' => $values,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );
        
        $form = $helper->generateForm(array($fields_form));
        
        
        $this->context->smarty->assign(array(
            'form' => ''
        ));
        
        $this->content = $form .
            $this->context->smarty->fetch( $this->module->getTemplatePath('views/templates/admin/reminder_templates/form.tpl') );
    }
    
    public function postProcess()
    {
        $id_reminder_template = Tools::getValue('id_reminder_template');

        if( !empty($id_reminder_template) ){
            $id_reminder_template_parts = explode('-', $id_reminder_template);
            $template_file_path = $this->_templates_dir .'/'. $id_reminder_template_parts[0] .'/'. $id_reminder_template_parts[1];
        }
        
        if( ($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($id_reminder_template_parts) ){
            $template_content = $_POST['description'];
            file_put_contents($template_file_path, $template_content);
            
            Tools::redirectAdmin( $this->context->link->getAdminLink('AdminReminderTemplates') );
        }
        
        
    }
}