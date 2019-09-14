<?php

require_once _PS_MODULE_DIR_ . 'ba_prestashop_invoice/ba_prestashop_invoice.php';
require_once _PS_MODULE_DIR_ . 'ba_prestashop_invoice/includes/baorderinvoice.php';

class Customer extends CustomerCore {
    public $phone;
    public $phone_mobile;
    public $address1;
    public $address2;
    public $postcode;
    public $city;
    
    public $id_country;
    
    public $ship_by_invoice;
    
    /**
     * Maximum customer's credit, goods that can be sent by invoice 
     * @var int
     */
    public $credit_limit;
    
    public $agentsales_id_employee;
    
    public $discount;
    
    public $order_create_key;
    
    public $phone_mobile_2;
    
    public $siret_confirmed;
    
    public $latitude;
    public $longitude;
    
    
    public static $definition = array(
        'table' => 'customer',
        'primary' => 'id_customer',
        'fields' => array(
            'secure_key' =>                array('type' => self::TYPE_STRING, 'validate' => 'isMd5', 'copy_post' => false),
            'lastname' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
            'firstname' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
            'email' =>                        array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 128),
            'passwd' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isPasswd', 'required' => true, 'size' => 32),
            'last_passwd_gen' =>            array('type' => self::TYPE_STRING, 'copy_post' => false),
            'id_gender' =>                    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'birthday' =>                    array('type' => self::TYPE_DATE, 'validate' => 'isBirthDate'),
            'newsletter' =>                array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'newsletter_date_add' =>        array('type' => self::TYPE_DATE,'copy_post' => false),
            'ip_registration_newsletter' =>    array('type' => self::TYPE_STRING, 'copy_post' => false),
            'optin' =>                        array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'website' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isUrl'),
            'company' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'siret' =>                        array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'ape' =>                        array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'year_open' =>                    array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'size_shop'=>                   array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'reference_brand'=>             array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'phone' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'phone_mobile' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'address1' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'address2' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'postcode' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'city'  => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'outstanding_allow_amount' =>    array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat', 'copy_post' => false),
            'show_public_prices' =>            array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
            'id_risk' =>                    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'copy_post' => false),
            'max_payment_days' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'copy_post' => false),
            'active' =>                    array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
            'deleted' =>                    array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
            'note' =>                        array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'size' => 65000, 'copy_post' => false),
            'is_guest' =>                    array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
            'id_shop' =>                    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'copy_post' => false),
            'id_shop_group' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'copy_post' => false),
            'id_default_group' =>            array('type' => self::TYPE_INT, 'copy_post' => false),
            'id_lang' =>                    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'copy_post' => false),
            'date_add' =>                    array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
            'date_upd' =>                    array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
            'id_country' =>                  array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'agentsales_commision_type' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => false
            ),
            'agentsales_commision_value' => array(
                'type' => self::TYPE_FLOAT,
                'validate' => 'isUnsignedFloat',
                'required' => false
            ),
            'agentsales_id_agent' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => false
            ),
            'ship_by_invoice' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'credit_limit' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => false,
                'copy_post' => false
            ),
            'agentsales_id_employee' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => false
                
            ),
            'agentsales_customer_exclude' => array(
                'type' => self::TYPE_STRING,
                'required' => false
            ),
            'discount' => array(
                'type' => self::TYPE_FLOAT,
                'validate' => 'isUnsignedFloat',
                'required' => false
            ),
            'order_create_key' => array(
                'type' => self::TYPE_STRING,
                'required' => false
            ),
            'phone_mobile_2' => array(
                'type' => self::TYPE_STRING,
                'required' => false,
                'validate' => 'isString',
                'size' => 32
            ),
            'siret_confirmed' => array(
                'type' => self::TYPE_BOOL,
                'required' => false,
            ),
            'latitude' => array('type' => self::TYPE_FLOAT),
            'longitude' => array('type' => self::TYPE_FLOAT)
            
        ),
    );
    
    protected $webserviceParameters = array(
        'fields' => array(
            'id_default_group' => array('xlink_resource' => 'groups'),
            'id_lang' => array('xlink_resource' => 'languages'),
            'newsletter_date_add' => array(),
            'ip_registration_newsletter' => array(),
            'last_passwd_gen' => array('setter' => null),
            'secure_key' => array('setter' => null),
            'deleted' => array(),
            'passwd' => array('setter' => 'setWsPasswd'),
            'invoices_all_unpaid_total' => array(
                'getter' => 'getWsInvoiceAllUnpaidTotal', 
                'setter' => null
            ),
            'invoices_overdued_unpaid_total' => array(
                'getter' => 'getWsInvoiceOverduedUnpaidTotal', 
                'setter' => null
            )
        ),
        'associations' => array(
            'groups' => array('resource' => 'group'),
        )
    );
    
    
    public function update($nullValues = false)
    {
        if (!$this->deleted && !empty($this->siret)) 
        {
            Db::getInstance()->execute('
                update '._DB_PREFIX_.'address 
                set vat_number=\''.addslashes($this->siret).'\', 
                dni=\''. addslashes($this->siret).'\' 
                where id_customer='.$this->id
            );
        }
        $result = parent::update(true);
        
        if( $result && isset($this->edited_fields) && is_array($this->edited_fields) ){
            if( array_search('id_lang', $this->edited_fields) !== false ){
                // update language of customer's orders
                try{
                    Db::getInstance()->execute('
                        UPDATE `'._DB_PREFIX_.'orders`
                        SET `id_lang` = '. intval($this->id_lang) .'
                        WHERE `id_customer` = '. intval($this->id) .'
                    ');
                }
                catch(Exception $e){
                
                }
            }
        }
        
        return $result;
    }
    
    public function add($auto_date = true, $null_values = false)
    {
        $this->credit_limit = 1500;
        
        return parent::add($auto_date, $null_values);
    }
    
    public function getBoughtProducts($addPhoto = false)
    {
        $sql = 'SELECT o.*, od.*'.($addPhoto?', i.id_image':'').' FROM `'._DB_PREFIX_.'orders` o	LEFT JOIN `'._DB_PREFIX_.
                'order_detail` od ON o.id_order = od.id_order';
        if ($addPhoto)
        {
            $sql .= ' left join '._DB_PREFIX_.'image i on i.id_product=od.product_id and cover=1';
        }
	$sql .= ' WHERE o.valid = 1 AND o.`id_customer` = '.(int)$this->id;
                
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);       
    }
    
    public static function searchByName($query, $limit = null)
    {
        $sql_base = 'SELECT *
				FROM `'._DB_PREFIX_.'customer`';
        $sql = '('.$sql_base.' WHERE `email` LIKE \'%'.pSQL($query).'%\' '.Shop::addSqlRestriction(Shop::SHARE_CUSTOMER).')';
        $sql .= ' UNION ('.$sql_base.' WHERE `id_customer` = '.(int)$query.' '.Shop::addSqlRestriction(Shop::SHARE_CUSTOMER).')';
        $sql .= ' UNION ('.$sql_base.' WHERE `lastname` LIKE \'%'.pSQL($query).'%\' '.Shop::addSqlRestriction(Shop::SHARE_CUSTOMER).')';
        $sql .= ' UNION ('.$sql_base.' WHERE `firstname` LIKE \'%'.pSQL($query).'%\' '.Shop::addSqlRestriction(Shop::SHARE_CUSTOMER).')';
        $sql .= ' UNION ('.$sql_base.' WHERE `company` LIKE \'%'.pSQL($query).'%\' '.Shop::addSqlRestriction(Shop::SHARE_CUSTOMER).')';
    
        if ($limit) {
            $sql .= ' LIMIT 0, '.(int)$limit;
        }
    
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
    }
    
    /**
     * Returns list of unpaid invoices
     * @param $overdue bool TRUE = List only overdue invoices, FALSE = all invoices
     * @return false|NULL|mysqli_result|PDOStatement|resource
     */
    public function getInvoicesUnpaidList($overdue = true)
    {
        $query = '
            SELECT oi.*
            FROM '._DB_PREFIX_.'order_invoice oi
            INNER JOIN '. _DB_PREFIX_.'orders o ON o.id_order=oi.id_order
            INNER JOIN `'._DB_PREFIX_.'ba_prestashop_invoice` bai 
                ON oi.template_id = bai.id 
                    AND bai.payment_type != '. (BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP) .'
            WHERE o.id_customer = '. $this->id .'
                AND oi.paid = 0
                AND oi.number > 0
                AND o.current_state != '. intval(Configuration::get('PS_OS_CANCELED')) .'
        ';
        
        if( $overdue ){
            $query .= '
                AND (
                    (oi.due_date > 0 AND oi.due_date < NOW()) 
                    OR
                    (oi.reminder_state BETWEEN '. OrderInvoice::Reminder1Sent .' AND '. OrderInvoice::Reminder3Sent .')
                )
            ';
        }

        return Db::getInstance()->executeS($query);
    }
    
    /**
     * Returns total amount of unpaid invoices
     * @param $overdue bool TRUE = List only overdue invoices, FALSE = all invoices
     * @return number
     */
    public function getInvoicesUnpaidTotalAmount($overdue = true)
    {
        $invoicesList = $this->getInvoicesUnpaidList($overdue);

        $unpaidTotalAmount = 0;
        foreach( $invoicesList as $invoiceData ){
            $unpaidTotalAmount += $invoiceData['sum_to_pay'] - ($invoiceData['sum_to_pay'] - $invoiceData['sum_paid']);
        }
        
        return $unpaidTotalAmount;
    }
    
    public function getCreditLimitHistoryList()
    {
        $query = '
            SELECT cclh.*, CONCAT_WS(" ", e.firstname, e.lastname) AS employee_name
            FROM `'._DB_PREFIX_.'customer_credit_limit_history` cclh
            LEFT JOIN `'._DB_PREFIX_.'employee` e
                ON e.id_employee = cclh.id_employee
            WHERE cclh.id_customer = '. intval($this->id) .'
            ORDER BY cclh.date_add DESC
        ';
        
        return Db::getInstance()->executeS($query);
    }
    
    public function hasInkassoInvoice()
    {
        $query = '
    		SELECT o.id_customer
    		FROM '._DB_PREFIX_.'order_invoice oi
    		LEFT JOIN '._DB_PREFIX_.'orders o ON o.id_order = oi.id_order
    		WHERE oi.reminder_state = '. OrderInvoice::ReminderInkasso .'
    		    AND o.id_customer = '. intval($this->id) .'
    		    AND oi.paid = 0
    		GROUP BY o.id_customer
        ';
        
        $inkassoInvoice = Db::getInstance()->getRow($query);
        if( is_array($inkassoInvoice) && isset($inkassoInvoice['id_customer']) ){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function getWsInvoiceAllUnpaidTotal()
    {
        return (float)$this->getInvoicesUnpaidTotalAmount(false);
    }
    
    public function getWsInvoiceOverduedUnpaidTotal()
    {
        return (float)$this->getInvoicesUnpaidTotalAmount(true);
    }
    
    /*
    * module: agentsales
    * date: 2018-01-12 15:42:08
    * version: 0.4.0
    */
    public $agentsales_commision_type;
    
    /*
    * module: agentsales
    * date: 2018-01-12 15:42:08
    * version: 0.4.0
    */
    public $agentsales_commision_value;
    
    /*
    * module: agentsales
    * date: 2018-01-12 15:42:08
    * version: 0.4.0
    */
    public $agentsales_id_agent;
    
   
    public $agentsales_customer_exclude;
}
/**
ALTER TABLE `prs_customer` ADD `discount` DECIMAL(5,2) NOT NULL DEFAULT '0.0' AFTER `credit_limit`;

ALTER TABLE `prs_customer` ADD `agentsales_customer_exclude` TEXT NOT NULL AFTER `agentsales_countries`;

ALTER TABLE `prs_customer` ADD `phone_mobile_2` VARCHAR(32) NOT NULL AFTER `order_create_key`;
*/
