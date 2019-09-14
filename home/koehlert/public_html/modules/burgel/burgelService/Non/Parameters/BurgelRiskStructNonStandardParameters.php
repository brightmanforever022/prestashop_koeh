<?php
/**
 * File for class BurgelRiskStructNonStandardParameters
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructNonStandardParameters originally named nonStandardParameters
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructNonStandardParameters extends BurgelRiskWsdlClass
{
    /**
     * The nonStandardParameter
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * @var BurgelRiskStructNonStandardParameter
     */
    public $nonStandardParameter;
    /**
     * Constructor method for nonStandardParameters
     * @see parent::__construct()
     * @param BurgelRiskStructNonStandardParameter $_nonStandardParameter
     * @return BurgelRiskStructNonStandardParameters
     */
    public function __construct($_nonStandardParameter = NULL)
    {
        parent::__construct(array('nonStandardParameter'=>$_nonStandardParameter),false);
    }
    /**
     * Get nonStandardParameter value
     * @return BurgelRiskStructNonStandardParameter|null
     */
    public function getNonStandardParameter()
    {
        return $this->nonStandardParameter;
    }
    /**
     * Set nonStandardParameter value
     * @param BurgelRiskStructNonStandardParameter $_nonStandardParameter the nonStandardParameter
     * @return BurgelRiskStructNonStandardParameter
     */
    public function setNonStandardParameter($_nonStandardParameter)
    {
        return ($this->nonStandardParameter = $_nonStandardParameter);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructNonStandardParameters
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
