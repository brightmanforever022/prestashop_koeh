<?php

class AgentSalesInvoice extends ObjectModel
{
    public $id;

    public $id_agent;
    
    public $id_invoice;
    
    public $commision_type;
    
    public $commision_value;
    
    public $paidout;
    
    public $date_paidout;

    public static $definition = array(
        'table' => 'agentsales_invoice',
        'primary' => 'id',
        'multilang' => false,
        'fields' => array(
            'id_agent' => array('type' => self::TYPE_INT),
            'id_invoice' => array('type' => self::TYPE_INT),
            'commision_type' => array('type' => self::TYPE_INT),
            'commision_value' => array('type' => self::TYPE_FLOAT),
            'paidout' => array('type' => self::TYPE_BOOL),
            'date_paidout' => array('type' => self::TYPE_DATE)
        )
    );

    
}