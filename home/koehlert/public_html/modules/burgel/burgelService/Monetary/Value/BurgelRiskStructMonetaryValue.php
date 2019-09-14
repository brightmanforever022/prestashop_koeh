<?php
/**
 * File for class BurgelRiskStructMonetaryValue
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructMonetaryValue originally named monetaryValue
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructMonetaryValue extends BurgelRiskWsdlClass
{
    /**
     * The _
     * @var decimal
     */
    public $_;
    /**
     * The currency
     * @var string
     */
    public $currency;
    /**
     * Constructor method for monetaryValue
     * @see parent::__construct()
     * @param decimal $__
     * @param string $_currency
     * @return BurgelRiskStructMonetaryValue
     */
    public function __construct($__ = NULL,$_currency = NULL)
    {
        parent::__construct(array('_'=>$__,'currency'=>$_currency),false);
    }
    /**
     * Get _ value
     * @return decimal|null
     */
    public function get_()
    {
        return $this->_;
    }
    /**
     * Set _ value
     * @param decimal $__ the _
     * @return decimal
     */
    public function set_($__)
    {
        return ($this->_ = $__);
    }
    /**
     * Get currency value
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    /**
     * Set currency value
     * @param string $_currency the currency
     * @return string
     */
    public function setCurrency($_currency)
    {
        return ($this->currency = $_currency);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructMonetaryValue
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
