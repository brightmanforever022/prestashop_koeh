<?php

class OrderType extends ObjectModel
{
    public $id;
    
    public $default;
    
    public $name;
    
    public static $definition = array(
        'table' => 'order_type',
        'primary' => 'id_order_type',
        'fields' => array(
            'default' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 32),
        ),
    );
    
}