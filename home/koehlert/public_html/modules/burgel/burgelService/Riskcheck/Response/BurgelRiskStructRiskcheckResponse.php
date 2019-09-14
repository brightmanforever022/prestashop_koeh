<?php
/**
 * File for class BurgelRiskStructRiskcheckResponse
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructRiskcheckResponse originally named riskcheckResponse
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructRiskcheckResponse extends BurgelRiskWsdlClass
{
    /**
     * The riskcheckOut
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructRiskcheckOut
     */
    public $riskcheckOut;
    /**
     * Constructor method for riskcheckResponse
     * @see parent::__construct()
     * @param BurgelRiskStructRiskcheckOut $_riskcheckOut
     * @return BurgelRiskStructRiskcheckResponse
     */
    public function __construct($_riskcheckOut = NULL)
    {
        parent::__construct(array('riskcheckOut'=>$_riskcheckOut),false);
    }
    /**
     * Get riskcheckOut value
     * @return BurgelRiskStructRiskcheckOut|null
     */
    public function getRiskcheckOut()
    {
        return $this->riskcheckOut;
    }
    /**
     * Set riskcheckOut value
     * @param BurgelRiskStructRiskcheckOut $_riskcheckOut the riskcheckOut
     * @return BurgelRiskStructRiskcheckOut
     */
    public function setRiskcheckOut($_riskcheckOut)
    {
        return ($this->riskcheckOut = $_riskcheckOut);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructRiskcheckResponse
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
