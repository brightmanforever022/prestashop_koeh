<?php

class SupplyBook extends ObjectModel
{
    public $id;

    public $date_production_start;

    public $name;

    public static $definition = array(
        'table' => 'supply_book',
        'primary' => 'id',
        'fields' => array(
            'date_production_start' => array(
                'type' => self::TYPE_DATE, 
                'validate' => 'isDate', 
            ),
            'name' => array(
                'type' => self::TYPE_STRING, 
                'validate' => 'isGenericName',
                'size' => 32
            ),
        ),
    );

}