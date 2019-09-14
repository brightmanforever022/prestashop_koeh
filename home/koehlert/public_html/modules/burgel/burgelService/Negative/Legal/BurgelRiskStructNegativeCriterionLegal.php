<?php
/**
 * File for class BurgelRiskStructNegativeCriterionLegal
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructNegativeCriterionLegal originally named NegativeCriterionLegal
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructNegativeCriterionLegal extends BurgelRiskStructNegativeCriterion
{
    /**
     * The reference
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $reference;
    /**
     * The court
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructCourt
     */
    public $court;
    /**
     * Constructor method for NegativeCriterionLegal
     * @see parent::__construct()
     * @param string $_reference
     * @param BurgelRiskStructCourt $_court
     * @return BurgelRiskStructNegativeCriterionLegal
     */
    public function __construct($_reference = NULL,$_court = NULL)
    {
        BurgelRiskWsdlClass::__construct(array('reference'=>$_reference,'court'=>$_court),false);
    }
    /**
     * Get reference value
     * @return string|null
     */
    public function getReference()
    {
        return $this->reference;
    }
    /**
     * Set reference value
     * @param string $_reference the reference
     * @return string
     */
    public function setReference($_reference)
    {
        return ($this->reference = $_reference);
    }
    /**
     * Get court value
     * @return BurgelRiskStructCourt|null
     */
    public function getCourt()
    {
        return $this->court;
    }
    /**
     * Set court value
     * @param BurgelRiskStructCourt $_court the court
     * @return BurgelRiskStructCourt
     */
    public function setCourt($_court)
    {
        return ($this->court = $_court);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructNegativeCriterionLegal
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
