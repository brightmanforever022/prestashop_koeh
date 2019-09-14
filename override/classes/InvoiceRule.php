<?php

class InvoiceRule extends ObjectModel
{

    public $template_id;
    
    public $ship_by_invoice;
    
    public $siret_confirmed;
    
    public $country;
    
    public static $definition = array(
        'table' => 'invoice_rule',
        'primary' => 'id_invoice_rule',
        'fields' => array(
            'template_id' => array(
                'type' => self::TYPE_INT
            ),
            'ship_by_invoice' => array(
                'type' => self::TYPE_INT,
            ),
            'siret_confirmed' => array(
                'type' => self::TYPE_INT,
            ),
            'country' => array(
                'type' => self::TYPE_STRING
            )
        )
        
    );
}

