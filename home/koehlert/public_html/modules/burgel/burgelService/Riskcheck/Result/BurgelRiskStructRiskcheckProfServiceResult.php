<?php
/**
 * File for class BurgelRiskStructRiskcheckProfServiceResult
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructRiskcheckProfServiceResult originally named riskcheckProfServiceResult
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructRiskcheckProfServiceResult extends BurgelRiskStructRiskcheckAdvancedServiceResult
{
    /**
     * The companyRelation
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * @var BurgelRiskStructCompanyRelation
     */
    public $companyRelation;
    /**
     * Constructor method for riskcheckProfServiceResult
     * @see parent::__construct()
     * @param BurgelRiskStructCompanyRelation $_companyRelation
     * @return BurgelRiskStructRiskcheckProfServiceResult
     */
    public function __construct($_companyRelation = NULL)
    {
        BurgelRiskWsdlClass::__construct(array('companyRelation'=>$_companyRelation),false);
    }
    /**
     * Get companyRelation value
     * @return BurgelRiskStructCompanyRelation|null
     */
    public function getCompanyRelation()
    {
        return $this->companyRelation;
    }
    /**
     * Set companyRelation value
     * @param BurgelRiskStructCompanyRelation $_companyRelation the companyRelation
     * @return BurgelRiskStructCompanyRelation
     */
    public function setCompanyRelation($_companyRelation)
    {
        return ($this->companyRelation = $_companyRelation);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructRiskcheckProfServiceResult
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
