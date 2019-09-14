<?php
/**
 * File for class BurgelRiskStructResultAddress
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructResultAddress originally named resultAddress
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructResultAddress extends BurgelRiskWsdlClass
{
    /**
     * The identification
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var anyType
     */
    public $identification;
    /**
     * The location
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructLocation
     */
    public $location;
    /**
     * Constructor method for resultAddress
     * @see parent::__construct()
     * @param anyType $_identification
     * @param BurgelRiskStructLocation $_location
     * @return BurgelRiskStructResultAddress
     */
    public function __construct($_identification = NULL,$_location = NULL)
    {
        parent::__construct(array('identification'=>$_identification,'location'=>$_location),false);
    }
    /**
     * Get identification value
     * @return anyType|null
     */
    public function getIdentification()
    {
        return $this->identification;
    }
    /**
     * Set identification value
     * @param anyType $_identification the identification
     * @return anyType
     */
    public function setIdentification($_identification)
    {
        return ($this->identification = $_identification);
    }
    /**
     * Get location value
     * @return BurgelRiskStructLocation|null
     */
    public function getLocation()
    {
        return $this->location;
    }
    /**
     * Set location value
     * @param BurgelRiskStructLocation $_location the location
     * @return BurgelRiskStructLocation
     */
    public function setLocation($_location)
    {
        return ($this->location = $_location);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructResultAddress
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
