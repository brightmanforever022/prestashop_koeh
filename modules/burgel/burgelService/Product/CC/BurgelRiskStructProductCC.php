<?php
/**
 * File for class BurgelRiskStructProductCC
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructProductCC originally named productCC
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructProductCC extends BurgelRiskWsdlClass
{
    /**
     * The header
     * @var BurgelRiskStructInquiryHeader
     */
    public $header;
    /**
     * The scoreVersion
     * @var int
     */
    public $scoreVersion;
    /**
     * Constructor method for productCC
     * @see parent::__construct()
     * @param BurgelRiskStructInquiryHeader $_header
     * @param int $_scoreVersion
     * @return BurgelRiskStructProductCC
     */
    public function __construct($_header = NULL,$_scoreVersion = NULL)
    {
        parent::__construct(array('header'=>$_header,'scoreVersion'=>$_scoreVersion),false);
    }
    /**
     * Get header value
     * @return BurgelRiskStructInquiryHeader|null
     */
    public function getHeader()
    {
        return $this->header;
    }
    /**
     * Set header value
     * @param BurgelRiskStructInquiryHeader $_header the header
     * @return BurgelRiskStructInquiryHeader
     */
    public function setHeader($_header)
    {
        return ($this->header = $_header);
    }
    /**
     * Get scoreVersion value
     * @return int|null
     */
    public function getScoreVersion()
    {
        return $this->scoreVersion;
    }
    /**
     * Set scoreVersion value
     * @param int $_scoreVersion the scoreVersion
     * @return int
     */
    public function setScoreVersion($_scoreVersion)
    {
        return ($this->scoreVersion = $_scoreVersion);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructProductCC
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
