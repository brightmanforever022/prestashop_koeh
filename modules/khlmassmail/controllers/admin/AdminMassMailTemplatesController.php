<?php

include_once(_PS_SWIFT_DIR_.'Swift.php');
include_once(_PS_SWIFT_DIR_.'Swift/Connection/SMTP.php');
include_once(_PS_SWIFT_DIR_.'Swift/Connection/NativeMail.php');
include_once(_PS_SWIFT_DIR_.'Swift/Plugin/Decorator.php');


class AdminMassMailTemplatesController extends ModuleAdminController
{
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->table = 'massmail_template';
        $this->list_id = 'massmail_templates';
        $this->className = 'MassMailTemplate';
        $this->identifier = 'id_template';
        $this->context = Context::getContext();
        $this->lang = true;
        
        $this->_defaultOrderBy = 'subject';
        $this->_defaultOrderWay = 'ASC';
        $this->allow_export = false;
        //$this->list_no_link = true;
        $this->addRowAction('edit');
        $this->addRowAction('details');
        
        $this->fields_list = array(
            'subject' => array(
                'title' => $this->l('Subject'),
            ),
            'date_add' => array(
                'title' => $this->l('Added'),
                'type' => 'date',
            ),
            
        );
        
    }
    
    public function setMedia()
    {
        parent::setMedia();
        $this->context->controller->addJS($this->module->getPath() .'mailing.js');
    }
    
    public function renderList()
    {
        $list = parent::renderList();
        
        $mailTemplatesList = Db::getInstance()->executeS('
            SELECT t.id_template, tl.subject
            FROM `'._DB_PREFIX_.'massmail_template` t
            INNER JOIN `'._DB_PREFIX_.'massmail_template_lang` tl 
                ON tl.id_template = t.id_template AND tl.id_lang = '. intval($this->context->language->id) .'
        ');
        
        $mailTemplatesOptions = array('0' => 'Select template');
        foreach($mailTemplatesList as $mailTemplateData){
            $mailTemplatesOptions[ $mailTemplateData['id_template'] ] = $mailTemplateData['subject'];
        }
        
        $this->context->smarty->assign(array(
            'receivers_count' => count( $this->getReceiversList() ),
            'mail_templates_list' => $mailTemplatesOptions,
            'massmail_controller_url' => $this->context->link->getAdminLink('AdminMassMailTemplates'),
            'receivers_list' => $this->getReceiversList()
        ));
        
        return $this->context->smarty->fetch($this->module->getTemplatePath('views/templates/admin/send_mails.tpl')) 
            . $list;
    }
    
    public function renderForm()
    {
        /*$this->informations[] = 'Template variables: 
            <br>{$customer_first_name} - customers first name
            <br>{$customer_last_name} - customers last name
        ';*/
        
        //$this->content .= ;
        
        $this->fields_form = array(
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Subject'),
                    'name' => 'subject',
                    'lang' => true,
                    'required' => true,
                    //'col' => '4',
                    //'hint' => $this->l('Your internal name for this attribute.').'&nbsp;'.$this->l('Invalid characters:').' <>;=#{}'
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Content'),
                    'name' => 'content',
                    'lang' => true,
                    'required' => true,
                    'autoload_rte' => true,
                    //'col' => '10',
                    //'hint' => $this->l('The public name for this attribute, displayed to the customers.').'&nbsp;'.$this->l('Invalid characters:').' <>;=#{}'
                ),
            )
        );
        
        $this->fields_form['submit'] = array(
            'title' => $this->l('Save'),
        );
        
        
        return parent::renderForm() . $this->context->smarty->fetch($this->module->getTemplatePath('views/templates/admin/template_variables.tpl'));
    }

    public function ajaxProcessSendEmails()
    {
        $responseData = array(
            'success' => false,
            'report' => array(
                'error_messages' => array(),
                'queue' => 0,
                'sent' => 0,
                'errors' => 0
            ),
            'message' => ''
        );
        
        $limit = Tools::getValue('limit', 5);
        $idTemplate = Tools::getValue('id_template');
        
        
        $receiversList = $this->getReceiversList($limit);
        $emailFrom = Configuration::get('PS_SHOP_EMAIL');
        $emailFromName = Configuration::get('PS_SHOP_NAME');
        
        $sentNumber = 0;
        foreach( $receiversList as $receiverData ){
            Db::getInstance()->delete('massmail_receiver', 'id_receiver = '. $receiverData['id_receiver']);
            
            $template = new MassMailTemplate($idTemplate, $receiverData['id_lang']);
            
            $emailSubject = $template->subject;
            $emailContent = $template->content;
            
            foreach( MassMailTemplate::$template_placeholders as $plchldConfig ){
                if( isset( $receiverData[ $plchldConfig['var_name'] ] ) ){
                    $emailContent = str_replace($plchldConfig['placeholder'], $receiverData[ $plchldConfig['var_name'] ], $emailContent);
                }
            }
            
            $receiverOptions = new MassmailReceiverOptions();
            $receiverOptionsData = json_decode($receiverData['options'], true);
            foreach( $receiverOptionsData as $name => $value ){
                if( property_exists($receiverOptions, $name) ){
                    $receiverOptions->{$name} = $value;
                }
            }
            
            $to_list = new Swift_RecipientList();
            $to_list->addTo($receiverData['email'], $receiverData['customer_first_name'] .' '. $receiverData['customer_last_name']);
            
            $connection = new Swift_Connection_NativeMail();
            $swift = new Swift($connection);
            
            $message = new Swift_Message($emailSubject);
            
            $message->setCharset('utf-8');
            //$message->setId(Mail::generateId());
            $message->headers->setEncoding('Q');

            $message->attach(new Swift_Message_Part($emailContent, 'text/html', '8bit', 'utf-8'));
            
            if( count( $receiverOptions->attachments ) ){
                foreach($receiverOptions->attachments as $receiverAttachment){
                    $attachment = array(
                        'content' => file_get_contents($receiverAttachment),
                        'name' => basename($receiverAttachment)
                    );
                    $message->attach(new Swift_Message_Attachment($attachment['content'], $attachment['name']));
                    
                }
            }
            
            try{
                $swift->send($message, $to_list, new Swift_Address($emailFrom, $emailFromName));
            }
            catch( Exception $e ){
                $responseData['report']['error_messages'][] = $e->getMessage();
                $swift->disconnect();
                continue;
            }
            
            $swift->disconnect();
            
            $sentNumber++;
        }
        
        $responseData['success'] = true;
        $responseData['report']['queue'] = count( $this->getReceiversList() );
        $responseData['report']['sent'] = $sentNumber;
        $responseData['report']['errors'] = 0;
        
        echo json_encode($responseData);
        die;
    }
    
    public function processDeleteReceivers()
    {
        Db::getInstance()->delete('massmail_receiver');
        $this->redirect_after = self::$currentIndex.'&token='.$this->token;
    }
    
    protected function getReceiversList($limit = null)
    {
        return Db::getInstance()->executeS('
            SELECT mmr.id_receiver, mmr.options, c.email, c.id_lang, 
                c.firstname AS customer_first_name, c.lastname AS customer_last_name 
            FROM `'._DB_PREFIX_.'massmail_receiver` mmr
            INNER JOIN `'._DB_PREFIX_.'customer` c 
                ON c.id_customer = mmr.id_customer
            '. (!is_null($limit) ? ' LIMIT '. $limit : '') .'
        ');
    }
}