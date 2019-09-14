<?php
/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Burgel extends Module
{
    protected $_html = '';
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'burgel';
        $this->tab = 'merchandizing';
        $this->version = '1.0.0';
        $this->author = 'wheelronix';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Burgel');
        $this->description = $this->l('Interracts with burgel service. Requests creditworthiness of customer, saves and shows it');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }
    

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        // add tab
        $tab = new Tab();
        $tab->name = self::getMultilangField('Burgel calls');
        $tab->class_name = 'AdminBurgelCalls';
        $tab->module = $this->name;
        $tab->id_parent = TabCore::getIdFromClassName('AdminOrders');
        
        return (include dirname(__FILE__).'/sql/install.php') && parent::install() && $this->registerHook('actionValidateOrder')
                && $this->registerHook('displayBurgelInfoOrder') && $tab->save();
    }

    
    public function uninstall()
    {
        $sql = '
		SELECT `id_tab` FROM `' . _DB_PREFIX_ . 'tab` WHERE `module` = "' . pSQL($this->name) . '"';

        $result = Db::getInstance()->ExecuteS($sql);

        if ($result && sizeof($result))
        {
            foreach ($result as $tabData)
            {
                $tab = new Tab($tabData['id_tab']);

                if (Validate::isLoadedObject($tab))
                    $tab->delete();
            }
        }

        return parent::uninstall();
    }
       
    public function getContent()
    {
        if (Tools::isSubmit('btnSubmit'))
        {
            $postErrors = $this->_postValidation();
            if (!count($postErrors))
                $this->_postProcess();
            else
                foreach ($postErrors as $err)
                    $this->_html .= $this->displayError($err);
        }
        else
            $this->_html .= '<br />';

        $this->_html .= $this->renderForm();

        return $this->_html;
    }

    protected function &_postValidation()
    {
        $postErrors = [];
        if (Tools::isSubmit('btnSubmit'))
        {
            if (!Tools::getValue('BURGEL_LOGIN'))
                $postErrors[] = $this->l('Burgel login required.');
            if (!Tools::getValue('BURGEL_PASSWORD'))
                $postErrors[] = $this->l('Burgel password required.');
            if (!Tools::getValue('BURGEL_URL'))
                $postErrors[] = $this->l('Burgel url required.');
            if (!Tools::getValue('BURGEL_WARN_SCORE'))
                $postErrors[] = $this->l('Burgel warning score threshold required.');
        }
        
        return $postErrors;
    }

    protected function _postProcess()
    {
        if (Tools::isSubmit('btnSubmit'))
        {
            Configuration::updateValue('BURGEL_LOGIN', Tools::getValue('BURGEL_LOGIN'));
            Configuration::updateValue('BURGEL_PASSWORD', Tools::getValue('BURGEL_PASSWORD'));
            Configuration::updateValue('BURGEL_URL', Tools::getValue('BURGEL_URL'));
            Configuration::updateValue('BURGEL_WARN_SCORE', Tools::getValue('BURGEL_WARN_SCORE'));
            Configuration::updateValue('BURGEL_CACHE_SCORE_DAYS', Tools::getValue('BURGEL_CACHE_SCORE_DAYS'));
        }
        $this->_html .= $this->displayConfirmation($this->l('Settings updated'));
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Burgel config'),
                    'icon' => 'icon-envelope'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('login'),
                        'name' => 'BURGEL_LOGIN',
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('password'),
                        'name' => 'BURGEL_PASSWORD',
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('WSDL burgel url'),
                        'name' => 'BURGEL_URL',
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Warning score threshold'),
                        'name' => 'BURGEL_WARN_SCORE',
                        'desc' => $this->l('If customer score is greater then this threshould, then warning email is sent to admin. Greater score means bigger risk.').
                           ' <a href="'._MODULE_DIR_.'burgel/doc/PB-CRIFBUERGEL-Score-0717.pdf">'.$this->l('More info').'</a>',
                        'required' => true
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Burgel cache (days)'),
                        'name' => 'BURGEL_CACHE_SCORE_DAYS',
                        'desc' => $this->l('Number of days during which burgel response is stored in cache. Burgel will not be called again for same customer and delivery address second time.'),
                        'required' => true
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->id = (int) Tools::getValue('id_carrier');
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => array(
		'BURGEL_LOGIN' => Tools::getValue('BURGEL_LOGIN', Configuration::get('BURGEL_LOGIN')),
                'BURGEL_PASSWORD' => Tools::getValue('BURGEL_PASSWORD', Configuration::get('BURGEL_PASSWORD')),
                'BURGEL_URL' => Tools::getValue('BURGEL_URL', Configuration::get('BURGEL_URL')),
                'BURGEL_WARN_SCORE' => Tools::getValue('BURGEL_WARN_SCORE', Configuration::get('BURGEL_WARN_SCORE')),
                'BURGEL_CACHE_SCORE_DAYS' => Tools::getValue('BURGEL_CACHE_SCORE_DAYS', Configuration::get('BURGEL_CACHE_SCORE_DAYS')),
                ),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    
    function hookActionValidateOrder($params)
    {
        $order = $params['order'];
        
        // check burgel cache
        include_once 'BurgelCall.php';
        $burgelCall = BurgelCall::getCachedByAddress($order->id_address_delivery);

        if ($burgelCall)
        {
            // cache info found, use it
            // save cached call
            $burgelCall->raw_data = '';
            $burgelCall->cache_used = 1;
            $burgelCall->order_id = $order->id;
            $burgelCall->add();
        }
        else
        {
            // no cache info, validate customer in burgel
            include_once 'BurgelService.php';
            $customer = new Customer($order->id_customer);
            $address = new Address($order->id_address_delivery);
            $burgelCall = BurgelService::validateCustomer($customer, $address);
            
            if ($burgelCall)
            {
                // connect with order
                $burgelCall->order_id = $order->id;
                $burgelCall->update();
            }
        }
        
        // decide if we need to send warning email to admin
        if ($burgelCall && $burgelCall->resp_score > Configuration::get('BURGEL_WARN_SCORE'))
        {
            // send warning to admin
            $idLang = Context::getContext()->cookie->id_lang;
            $idShop = Context::getContext()->shop->id;
            Mail::Send(
                $idLang, 'low_score_warning', _PS_BASE_URL_.': '.$this->l('order with low burgel score placed'), ['{orderId}' => $order->id,
                    '{customerName}' => $burgelCall->resp_firstname.(empty($burgelCall->resp_lastname?'':' '.$burgelCall->resp_lastname)), 
                    '{customerId}'=>$order->id_customer, '{score}'=>$burgelCall->resp_score, 
                    '{decision_text}' => $burgelCall->resp_decision_text], Configuration::get('PS_SHOP_EMAIL'), 
                null, (string) Configuration::get('PS_SHOP_EMAIL', null, null, $idShop), 
                (string) Configuration::get('PS_SHOP_NAME', null, null, $idShop), null, null, dirname(__FILE__) . '/mails/', false, $idShop
            );
        }
    }
    
    
    function hookDisplayBurgelInfoOrder($params)
    {
        if (!empty($params['order_id']))
        {
            include_once 'BurgelCall.php';
            $info = BurgelCall::getOrderScoreAndDecisionTxt($params['order_id']);
            if ($info)
            {
                return '<b>'.$this->l('Score:').'</b> '.$info['score'].' <b>'.$this->l('Decision:').'</b> '.$info['decisionTxt'].
                        '<div class="hidden" id="burgelHelp"><div>'.
                        sprintf($this->l('Burgel service called periodically every %d days. Between calls result from last call is used (cache). '
                        . 'Result of burgel call is stored for each order, so for old orders you see old burgel answers, that were actual at that time.'
                        . 'You can see list of burgel calls in %s '), Configuration::get('BURGEL_CACHE_SCORE_DAYS'), 'Orders &gt; Burgel calls').
                        sprintf($this->l(' page. For this order burgel answer from %s was used.'),Tools::displayDate($info['actualReqDate'], null, true)).
                        '<br />'.
                        sprintf($this->l('At time then new order is created and customer has score greater %s admin will receive notification email about this.'), 
                        Configuration::get('BURGEL_WARN_SCORE')).
                        '</div></div>';
            }
        }
    }
}