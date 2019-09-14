<?php
/**
 * 
 */

require_once _PS_MODULE_DIR_ .'shopcomments/classes/ShopComment.php';

if (!defined('_PS_VERSION_'))
    exit;

class Shopcomments extends Module
{
    public function __construct()
    {
        $this->name = 'shopcomments';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'NSWEB';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Store comments for various objects');
    }
    
    public function install()
    {
        parent::install();
        
        $dbQueries = array(
            'CREATE TABLE `'._DB_PREFIX_.'shop_comment` (
              `id` int(10) UNSIGNED NOT NULL,
              `reference_type` int(10) UNSIGNED NOT NULL,
              `reference_id` int(10) UNSIGNED NOT NULL,
              `employee_id` int(10) UNSIGNED NOT NULL,
              `date_created` datetime NOT NULL,
              `message` text NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;',
            'ALTER TABLE `'._DB_PREFIX_.'shop_comment` ADD PRIMARY KEY (`id`), ADD KEY `reference_type` (`reference_type`)',
            'ALTER TABLE `'._DB_PREFIX_.'shop_comment` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT'
        );
        
        foreach($dbQueries as $query){
            Db::getInstance()->query($query);
        }
        
        $tab = new Tab ();
        $tab->class_name = 'AdminShopCommentsComments';
        $tab->module = $this->name;
        $tab->id_parent = -1;
        foreach (Language::getLanguages () as $lang){
            $tab->name[(int)$lang['id_lang']] = 'Shop comments';
        }
        if (! $tab->save ()){
            $this->_errors[] = $this->l('Tab "'.$tab->class_name.'" install error');
            return false;
        }
        
        $this->registerHook('actionAdminControllerSetMedia');
        $this->registerHook('displayAdminAfterHeader');
        
        return true;
    }
    
    public function hookActionAdminControllerSetMedia($params)
    {
        if( ($this->context->controller instanceof AdminCustomersController) 
            || ($this->context->controller instanceof AdminDiffPaymentsController)
            || ($this->context->controller instanceof AdminOrdersController)
        ){
            
        }
        else{
            return;
        }
        $this->context->controller->addJS($this->_path.'views/admin.js');
    }
    
    public function hookDisplayAdminAfterHeader()
    {
        
        if( ($this->context->controller instanceof AdminCustomersController)
            || ($this->context->controller instanceof AdminOrdersController)
        ){
            $commentReference = ShopComment::REFERENCE_TYPE_CUSTOMER;
        }
        elseif( $this->context->controller instanceof AdminDiffPaymentsController ){
            $commentReference = ShopComment::REFERENCE_TYPE_DIFFPMNT;
        }
        else{
            return;
        }
        
        
        
        $this->context->smarty->assign(array(
            'shop_comments_controller_url' => 
                $this->context->link->getAdminLink('AdminShopCommentsComments'),
            'shop_comment_reference' => $commentReference
        ));
        
        return $this->context->smarty->fetch($this->getTemplatePath('views/templates/admin/form_modal.tpl'));
        
    }
}

/**
 * 
insert into prs_shop_comment
(reference_type, reference_id, employee_id, message)

select 1, id_customer, 8, note
from prs_customer
where note != ""

 * 
 */