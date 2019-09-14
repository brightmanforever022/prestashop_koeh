<?php

class AgentSalesOrder extends ObjectModel
{
    public $id;

    public $id_agent;
    
    public $id_order;
    
    public static $definition = array(
        'table' => 'agentsales_order',
        'primary' => 'id',
        'multilang' => false,
        'fields' => array(
            'id_agent' => array('type' => self::TYPE_INT),
            'id_order' => array('type' => self::TYPE_INT),
        )
    );

    
}