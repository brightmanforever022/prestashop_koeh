<?php

class Validate extends ValidateCore
{
    /**
     * Check for price validity
     *
     * @param string $price Price to validate
     * @return bool Validity is ok or not
     */
    public static function isPrice($price)
    {
        return preg_match('/^[0-9]{1,10}(\.[0-9]+)?$/', $price);
    }
    
    public static function isPhoneNumber($number)
    {
        return preg_match('/^[+0-9. ()-\/]*$/', $number);
    }
    
    public static function isUpc($upc)
    {
        return !$upc || preg_match('/^[0-9a-z]*$/i', $upc);
    }
    
}

