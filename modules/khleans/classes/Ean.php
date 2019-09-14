<?php

class Ean extends ObjectModel
{
    public $id;
    
    public $code;
    
    public $used;
    
    public $supplier_reference;
    
    public $keeper;
    
    const KEEPER_KOEHLERT = 1;
    const KEEPER_VIPDRESS = 2;
    
    public static $definition = array(
        'table' => 'ean',
        'primary' => 'id',
        'fields' => array(
            'code' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'copy_post' => false),
            'used' => array('type' => self::TYPE_INT, 'copy_post' => false),
            'supplier_reference' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => false),
            'keeper' => array('type' => self::TYPE_INT, 'copy_post' => false),
        ),
    );
    
}