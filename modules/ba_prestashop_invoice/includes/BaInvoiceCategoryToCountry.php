<?php

class BaInvoiceCategoryToCountry extends ObjectModel
{
    public $id;
    
    public $category_id;
    
    public $country_id;
    
    public static $definition = array(
        'table' => 'ba_invoice_category_to_country',
        'primary' => 'id',
    );
}