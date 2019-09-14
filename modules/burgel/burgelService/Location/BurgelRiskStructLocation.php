<?php
/**
 * File for class BurgelRiskStructLocation
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructLocation originally named location
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructLocation extends BurgelRiskWsdlClass
{
    /**
     * The street
     * @var string
     */
    public $street;
    /**
     * The houseNumber
     * @var string
     */
    public $houseNumber;
    /**
     * The postalCode
     * @var string
     */
    public $postalCode;
    /**
     * The city
     * @var string
     */
    public $city;
    /**
     * The country
     * @var BurgelRiskStructCodeAndText
     */
    public $country;
    /**
     * Constructor method for location
     * @see parent::__construct()
     * @param string $_street
     * @param string $_houseNumber
     * @param string $_postalCode
     * @param string $_city
     * @param BurgelRiskStructCodeAndText $_country
     * @return BurgelRiskStructLocation
     */
    public function __construct($_street = NULL,$_houseNumber = NULL,$_postalCode = NULL,$_city = NULL,$_country = NULL)
    {
        parent::__construct(array('street'=>$_street,'houseNumber'=>$_houseNumber,'postalCode'=>$_postalCode,'city'=>$_city,'country'=>$_country),false);
    }
    /**
     * Get street value
     * @return string|null
     */
    public function getStreet()
    {
        return $this->street;
    }
    /**
     * Set street value
     * @param string $_street the street
     * @return string
     */
    public function setStreet($_street)
    {
        return ($this->street = $_street);
    }
    /**
     * Get houseNumber value
     * @return string|null
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }
    /**
     * Set houseNumber value
     * @param string $_houseNumber the houseNumber
     * @return string
     */
    public function setHouseNumber($_houseNumber)
    {
        return ($this->houseNumber = $_houseNumber);
    }
    /**
     * Get postalCode value
     * @return string|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    /**
     * Set postalCode value
     * @param string $_postalCode the postalCode
     * @return string
     */
    public function setPostalCode($_postalCode)
    {
        return ($this->postalCode = $_postalCode);
    }
    /**
     * Get city value
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * Set city value
     * @param string $_city the city
     * @return string
     */
    public function setCity($_city)
    {
        return ($this->city = $_city);
    }
    /**
     * Get country value
     * @return BurgelRiskStructCodeAndText|null
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * Set country value
     * @param BurgelRiskStructCodeAndText $_country the country
     * @return BurgelRiskStructCodeAndText
     */
    public function setCountry($_country)
    {
        return ($this->country = $_country);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructLocation
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
