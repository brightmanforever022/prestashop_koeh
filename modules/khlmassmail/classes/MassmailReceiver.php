<?php

class MassmailReceiver extends ObjectModel
{
    
    public $id_customer;
    
    public $options;
    
    public static $definition = array(
        'table' => 'massmail_receiver',
        'primary' => 'id_receiver',
        'multilang' => false,
        'fields' => array(
            'id_customer' => array(
                'type' => self::TYPE_INT
            ),
            'options' => array(
                'type' => self::TYPE_STRING, 
            ),
        ),
    );
}

