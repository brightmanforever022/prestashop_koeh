<?php
/**
 * File for class BurgelRiskStructRcsResponse
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructRcsResponse originally named rcsResponse
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructRcsResponse extends BurgelRiskWsdlClass
{
    /**
     * The header
     * @var BurgelRiskStructBasicResultHeader
     */
    public $header;
    /**
     * Constructor method for rcsResponse
     * @see parent::__construct()
     * @param BurgelRiskStructBasicResultHeader $_header
     * @return BurgelRiskStructRcsResponse
     */
    public function __construct($_header = NULL)
    {
        parent::__construct(array('header'=>$_header),false);
    }
    /**
     * Get header value
     * @return BurgelRiskStructBasicResultHeader|null
     */
    public function getHeader()
    {
        return $this->header;
    }
    /**
     * Set header value
     * @param BurgelRiskStructBasicResultHeader $_header the header
     * @return BurgelRiskStructBasicResultHeader
     */
    public function setHeader($_header)
    {
        return ($this->header = $_header);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructRcsResponse
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
