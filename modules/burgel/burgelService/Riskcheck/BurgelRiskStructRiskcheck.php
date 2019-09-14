<?php
/**
 * File for class BurgelRiskStructRiskcheck
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructRiskcheck originally named riskcheck
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructRiskcheck extends BurgelRiskWsdlClass
{
    /**
     * The riskcheckIn
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructRiskcheckInput
     */
    public $riskcheckIn;
    /**
     * Constructor method for riskcheck
     * @see parent::__construct()
     * @param BurgelRiskStructRiskcheckInput $_riskcheckIn
     * @return BurgelRiskStructRiskcheck
     */
    public function __construct($_riskcheckIn = NULL)
    {
        parent::__construct(array('riskcheckIn'=>$_riskcheckIn),false);
    }
    /**
     * Get riskcheckIn value
     * @return BurgelRiskStructRiskcheckInput|null
     */
    public function getRiskcheckIn()
    {
        return $this->riskcheckIn;
    }
    /**
     * Set riskcheckIn value
     * @param BurgelRiskStructRiskcheckInput $_riskcheckIn the riskcheckIn
     * @return BurgelRiskStructRiskcheckInput
     */
    public function setRiskcheckIn($_riskcheckIn)
    {
        return ($this->riskcheckIn = $_riskcheckIn);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructRiskcheck
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
