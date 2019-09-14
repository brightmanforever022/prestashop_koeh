<?php
/**
 * File for class BurgelRiskStructRiskcheckAdvancedServiceResult
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructRiskcheckAdvancedServiceResult originally named riskcheckAdvancedServiceResult
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructRiskcheckAdvancedServiceResult extends BurgelRiskStructRiskcheckResult
{
    /**
     * The negativeCriterion
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * @var BurgelRiskStructNegativeCriterion
     */
    public $negativeCriterion;
    /**
     * Constructor method for riskcheckAdvancedServiceResult
     * @see parent::__construct()
     * @param BurgelRiskStructNegativeCriterion $_negativeCriterion
     * @return BurgelRiskStructRiskcheckAdvancedServiceResult
     */
    public function __construct($_negativeCriterion = NULL)
    {
        BurgelRiskWsdlClass::__construct(array('negativeCriterion'=>$_negativeCriterion),false);
    }
    /**
     * Get negativeCriterion value
     * @return BurgelRiskStructNegativeCriterion|null
     */
    public function getNegativeCriterion()
    {
        return $this->negativeCriterion;
    }
    /**
     * Set negativeCriterion value
     * @param BurgelRiskStructNegativeCriterion $_negativeCriterion the negativeCriterion
     * @return BurgelRiskStructNegativeCriterion
     */
    public function setNegativeCriterion($_negativeCriterion)
    {
        return ($this->negativeCriterion = $_negativeCriterion);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructRiskcheckAdvancedServiceResult
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
