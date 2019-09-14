<?php
/**
 * File for class BurgelRiskEnumInquiryReasons
 * @package BurgelRisk
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskEnumInquiryReasons originally named inquiryReasons
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskEnumInquiryReasons extends BurgelRiskWsdlClass
{
    /**
     * Constant for value 'CREDIT_INQUIRY'
     * @return string 'CREDIT_INQUIRY'
     */
    const VALUE_CREDIT_INQUIRY = 'CREDIT_INQUIRY';
    /**
     * Constant for value 'BUSINESS_RELATIONSHIP'
     * @return string 'BUSINESS_RELATIONSHIP'
     */
    const VALUE_BUSINESS_RELATIONSHIP = 'BUSINESS_RELATIONSHIP';
    /**
     * Constant for value 'SOLVENCY_CHECK'
     * @return string 'SOLVENCY_CHECK'
     */
    const VALUE_SOLVENCY_CHECK = 'SOLVENCY_CHECK';
    /**
     * Constant for value 'CLAIM'
     * @return string 'CLAIM'
     */
    const VALUE_CLAIM = 'CLAIM';
    /**
     * Return true if value is allowed
     * @uses BurgelRiskEnumInquiryReasons::VALUE_CREDIT_INQUIRY
     * @uses BurgelRiskEnumInquiryReasons::VALUE_BUSINESS_RELATIONSHIP
     * @uses BurgelRiskEnumInquiryReasons::VALUE_SOLVENCY_CHECK
     * @uses BurgelRiskEnumInquiryReasons::VALUE_CLAIM
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(BurgelRiskEnumInquiryReasons::VALUE_CREDIT_INQUIRY,BurgelRiskEnumInquiryReasons::VALUE_BUSINESS_RELATIONSHIP,BurgelRiskEnumInquiryReasons::VALUE_SOLVENCY_CHECK,BurgelRiskEnumInquiryReasons::VALUE_CLAIM));
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
