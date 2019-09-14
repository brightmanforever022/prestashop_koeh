<?php

class AgentSalesCountry extends ObjectModel
{
    public $id_agent;
    
    public $id_country;
    
    public $postcodes;
    
    public static $definition = array(
        'table' => 'agentsales_country',
        'primary' => 'id',
        'multilang' => false,
        'fields' => array(
            'id_agent' => array('type' => self::TYPE_INT),
            'id_country' => array('type' => self::TYPE_INT),
            'postcodes' => array('type' => self::TYPE_STRING),
        )
        
    );
}

