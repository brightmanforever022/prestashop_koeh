<?php

/**

CREATE TABLE `prs_customer_credit_limit_history` (
  `id_customer_credit_limit_history` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `note` text NOT NULL,
  `credit_limit` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `prs_customer_credit_limit_history`
  ADD PRIMARY KEY (`id_customer_credit_limit_history`),
  ADD KEY `id_customer` (`id_customer`);
ALTER TABLE `prs_customer_credit_limit_history`
  MODIFY `id_customer_credit_limit_history` int(11) NOT NULL AUTO_INCREMENT;

 */

class CustomerCreditLimitHistory extends ObjectModel
{
    public $id;
    
    public $date_add;
    
    public $id_customer;
    
    public $id_employee;
    
    public $note;
    
    public $credit_limit;
    
    public static $definition = array(
        'table' => 'customer_credit_limit_history',
        'primary' => 'id_customer_credit_limit_history',
        'fields' => array(
            'date_add' => array(
                'type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false
            ),
            'id_customer' => array(
                'type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true
            ),
            'id_employee' => array(
                'type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true
            ),
            'note' => array(
                'type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'size' => 1000, 'required' => true
            ),
            'credit_limit' => array(
                'type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true
            ),
        )
    );
    
    public function add($autodate = true, $null_values = true)
    {
        $this->date_add = date('Y-m-d H:i:s');
        
        $success = parent::add($autodate, $null_values);
        
        return $success;
    }
}