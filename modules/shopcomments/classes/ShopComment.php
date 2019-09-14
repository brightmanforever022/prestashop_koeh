<?php

class ShopComment extends ObjectModel
{
    const REFERENCE_TYPE_CUSTOMER = 1;
    const REFERENCE_TYPE_DIFFPMNT = 2;
    const REFERENCE_TYPE_ORDER_IGNORE_NO_INVOICE = 3;
    
    const STATUS_ARCHIVE = 0;
    const STATUS_ACTIVE = 1;
    
    
    public $id;
    
    public $reference_type;
    
    public $reference_id;
    
    public $employee_id;
    
    public $date_created;
    
    public $status;
    
    public $message;
    
    public static $definition = array(
        'table' => 'shop_comment',
        'primary' => 'id',
        'fields' => array(
            'id' => array(
                'type' => self::TYPE_INT, 
                'validate' => 'isUnsignedId'
            ),
            'reference_type' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'reference_id' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'employee_id' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId'
            ),
            'date_created' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),
            'status' => array(
                'type' => self::TYPE_INT,
            ),
            
            'message' => array(
                'type' => self::TYPE_STRING,
                //'validate' => 'isMessage'
            ),
            
        )
    );
    
    public static function getComments($referenceType, $referenceId, $status = null)
    {
        $query = '
            SELECT sc.*, CONCAT(e.lastname, " ", e.firstname) AS employee_name
            FROM `'._DB_PREFIX_.'shop_comment` sc
            INNER JOIN `'._DB_PREFIX_.'employee` e ON e.id_employee = sc.employee_id
            WHERE sc.`reference_type` = '. intval($referenceType) .'
                AND sc.`reference_id` = '. intval($referenceId) .'
                '. (!is_null($status) ? ' AND `status` = '. $status .'' : '') .'
            ORDER BY sc.date_created ASC
        ';
        $comments = Db::getInstance()->executeS($query);
        return $comments;
    }
    
    public static function getCustomerComments($customerId, $status = null)
    {
        return self::getComments(self::REFERENCE_TYPE_CUSTOMER, $customerId, $status);
    }
    
    public static function getDiffpayComments($diffpayId, $status = null)
    {
        return self::getComments(self::REFERENCE_TYPE_DIFFPMNT, $diffpayId, $status);
    }
    
    public static function getOrderIgnoreNoInvoiceComment($orderId)
    {
        $comments = self::getComments(self::REFERENCE_TYPE_ORDER_IGNORE_NO_INVOICE, $orderId);
        
        if( count($comments) ){
            return array_pop($comments);
        }
        else{
            return array();
        }
    }
}
