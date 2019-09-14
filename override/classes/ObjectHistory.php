<?php

class ObjectHistory extends ObjectModel
{
    public $id_employee;
    
    public $date_add;
    
    public $class_reference;
    
    public $property_reference;
    
    public $object_reference;
    
    public $value;
    
    public static $definition = array(
        'table' => 'object_history',
        'primary' => 'id_object_history',
        'fields' => array(
            'id_employee' => array(
                'type' => self::TYPE_INT, 
                'validate' => 'isNullOrUnsignedId', 
            ),
            'date_add' => array(
                'type' => self::TYPE_DATE, 
                'validate' => 'isDate', 
                'copy_post' => false
            ),
            'class_reference' => array(
                'type' => self::TYPE_INT, 
                'validate' => 'isUnsignedId', 
                'required' => true
            ),
            'property_reference' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId',
                'required' => true
            ),
            'object_reference' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId',
                'required' => true
            ),
            'value' => array(
                'type' => self::TYPE_STRING,
                //'validate' => 'isUnsignedId',
                'required' => true
            ),
            
        )
    );
    
    const CLASS_CUSTOMER = 1;
    
    const PROP_CUSTOMER_VAT = 1;
    const PROP_CUSTOMER_VAT_CONF = 2;
    const PROP_CUSTOMER_ACTIVE = 3;
}