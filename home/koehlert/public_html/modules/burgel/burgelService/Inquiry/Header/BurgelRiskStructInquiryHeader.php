<?php
/**
 * File for class BurgelRiskStructInquiryHeader
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructInquiryHeader originally named inquiryHeader
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructInquiryHeader extends BurgelRiskStructBasicHeader
{
    /**
     * The productNumber
     * @var int
     */
    public $productNumber;
    /**
     * The inquiryReason
     * Meta informations extracted from the WSDL
     * - default : SOLVENCY_CHECK
     * @var BurgelRiskEnumInquiryReasons
     */
    public $inquiryReason;
    /**
     * The language
     * Meta informations extracted from the WSDL
     * - default : DE
     * @var BurgelRiskEnumSupportedLanguages
     */
    public $language;
    /**
     * The nonStandardParameters
     * @var BurgelRiskStructNonStandardParameters
     */
    public $nonStandardParameters;
    /**
     * Constructor method for inquiryHeader
     * @see parent::__construct()
     * @param int $_productNumber
     * @param BurgelRiskEnumInquiryReasons $_inquiryReason
     * @param BurgelRiskEnumSupportedLanguages $_language
     * @param BurgelRiskStructNonStandardParameters $_nonStandardParameters
     * @return BurgelRiskStructInquiryHeader
     */
    public function __construct($_productNumber = NULL,$_inquiryReason = 'SOLVENCY_CHECK',$_language = 'DE',$_nonStandardParameters = NULL)
    {
        BurgelRiskWsdlClass::__construct(array('productNumber'=>$_productNumber,'inquiryReason'=>$_inquiryReason,'language'=>$_language,'nonStandardParameters'=>$_nonStandardParameters),false);
    }
    /**
     * Get productNumber value
     * @return int|null
     */
    public function getProductNumber()
    {
        return $this->productNumber;
    }
    /**
     * Set productNumber value
     * @param int $_productNumber the productNumber
     * @return int
     */
    public function setProductNumber($_productNumber)
    {
        return ($this->productNumber = $_productNumber);
    }
    /**
     * Get inquiryReason value
     * @return BurgelRiskEnumInquiryReasons|null
     */
    public function getInquiryReason()
    {
        return $this->inquiryReason;
    }
    /**
     * Set inquiryReason value
     * @uses BurgelRiskEnumInquiryReasons::valueIsValid()
     * @param BurgelRiskEnumInquiryReasons $_inquiryReason the inquiryReason
     * @return BurgelRiskEnumInquiryReasons
     */
    public function setInquiryReason($_inquiryReason)
    {
        if(!BurgelRiskEnumInquiryReasons::valueIsValid($_inquiryReason))
        {
            return false;
        }
        return ($this->inquiryReason = $_inquiryReason);
    }
    /**
     * Get language value
     * @return BurgelRiskEnumSupportedLanguages|null
     */
    public function getLanguage()
    {
        return $this->language;
    }
    /**
     * Set language value
     * @uses BurgelRiskEnumSupportedLanguages::valueIsValid()
     * @param BurgelRiskEnumSupportedLanguages $_language the language
     * @return BurgelRiskEnumSupportedLanguages
     */
    public function setLanguage($_language)
    {
        if(!BurgelRiskEnumSupportedLanguages::valueIsValid($_language))
        {
            return false;
        }
        return ($this->language = $_language);
    }
    /**
     * Get nonStandardParameters value
     * @return BurgelRiskStructNonStandardParameters|null
     */
    public function getNonStandardParameters()
    {
        return $this->nonStandardParameters;
    }
    /**
     * Set nonStandardParameters value
     * @param BurgelRiskStructNonStandardParameters $_nonStandardParameters the nonStandardParameters
     * @return BurgelRiskStructNonStandardParameters
     */
    public function setNonStandardParameters($_nonStandardParameters)
    {
        return ($this->nonStandardParameters = $_nonStandardParameters);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructInquiryHeader
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
