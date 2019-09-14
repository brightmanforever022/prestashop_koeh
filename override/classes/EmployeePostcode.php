<?php

class EmployeePostcode extends ObjectModel
{
    public $id_employee_country;
    
    public $postcode;
    
    public static $definition = array(
        'table' => 'employee_postcode',
        'primary' => 'id_employee_postcode',
        'fields' => array(
            'id_employee_country' => array(
                'type' => self::TYPE_INT, 
            ),
            'postcode' => array(
                'type' => self::TYPE_STRING,
                'size' => 32
            )
            
        )
    );
}

