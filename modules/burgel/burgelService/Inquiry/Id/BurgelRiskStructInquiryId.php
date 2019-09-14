<?php
/**
 * File for class BurgelRiskStructInquiryId
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructInquiryId originally named inquiryId
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructInquiryId extends BurgelRiskWsdlClass
{
    /**
     * The buergelAgencyNumber
     * @var int
     */
    public $buergelAgencyNumber;
    /**
     * The inquiryNumber
     * @var int
     */
    public $inquiryNumber;
    /**
     * Constructor method for inquiryId
     * @see parent::__construct()
     * @param int $_buergelAgencyNumber
     * @param int $_inquiryNumber
     * @return BurgelRiskStructInquiryId
     */
    public function __construct($_buergelAgencyNumber = NULL,$_inquiryNumber = NULL)
    {
        parent::__construct(array('buergelAgencyNumber'=>$_buergelAgencyNumber,'inquiryNumber'=>$_inquiryNumber),false);
    }
    /**
     * Get buergelAgencyNumber value
     * @return int|null
     */
    public function getBuergelAgencyNumber()
    {
        return $this->buergelAgencyNumber;
    }
    /**
     * Set buergelAgencyNumber value
     * @param int $_buergelAgencyNumber the buergelAgencyNumber
     * @return int
     */
    public function setBuergelAgencyNumber($_buergelAgencyNumber)
    {
        return ($this->buergelAgencyNumber = $_buergelAgencyNumber);
    }
    /**
     * Get inquiryNumber value
     * @return int|null
     */
    public function getInquiryNumber()
    {
        return $this->inquiryNumber;
    }
    /**
     * Set inquiryNumber value
     * @param int $_inquiryNumber the inquiryNumber
     * @return int
     */
    public function setInquiryNumber($_inquiryNumber)
    {
        return ($this->inquiryNumber = $_inquiryNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructInquiryId
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
