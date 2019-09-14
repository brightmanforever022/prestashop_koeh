<?php
/**
 * File for class BurgelRiskStructProductResultHeader
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructProductResultHeader originally named productResultHeader
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructProductResultHeader extends BurgelRiskStructRcsResultHeader
{
    /**
     * The productNumber
     * @var int
     */
    public $productNumber;
    /**
     * The language
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskEnumSupportedLanguages
     */
    public $language;
    /**
     * Constructor method for productResultHeader
     * @see parent::__construct()
     * @param int $_productNumber
     * @param BurgelRiskEnumSupportedLanguages $_language
     * @return BurgelRiskStructProductResultHeader
     */
    public function __construct($_productNumber = NULL,$_language = NULL)
    {
        BurgelRiskWsdlClass::__construct(array('productNumber'=>$_productNumber,'language'=>$_language),false);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructProductResultHeader
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
