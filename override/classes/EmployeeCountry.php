<?php

class EmployeeCountry extends ObjectModel
{
    public $id_employee;
    
    public $id_country;
    
    public static $definition = array(
        'table' => 'employee_country',
        'primary' => 'id_employee_country',
        'fields' => array(
            'id_employee' => array(
                'type' => self::TYPE_INT 
            ),
            'id_country' => array(
                'type' => self::TYPE_INT,
            )
        )
    );

    public function getPostcodes()
    {
        $query = '
            SELECT * 
            FROM `'._DB_PREFIX_.'employee_postcode` 
            WHERE id_employee_country = '. $this->id .'
            ORDER BY postcode ASC
        ';
        
        return Db::getInstance()->executeS($query);
    }
    
    public function getPostcodesString($separator)
    {
        $postcodesString = '';
        $postcodesList = $this->getPostcodes();
        
        if( !count($postcodesList) ){
            return $postcodesString;
        }
        
        foreach( $postcodesList as $postcodeItem ){
            $postcodesString .= $postcodeItem['postcode'] . $separator;
        }
        
        return rtrim($postcodesString, $separator);
    }
}

