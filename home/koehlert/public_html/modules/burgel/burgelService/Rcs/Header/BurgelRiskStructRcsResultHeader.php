<?php
/**
 * File for class BurgelRiskStructRcsResultHeader
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructRcsResultHeader originally named rcsResultHeader
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructRcsResultHeader extends BurgelRiskStructBasicResultHeader
{
    /**
     * The customerId
     * @var int
     */
    public $customerId;
    /**
     * The returnTMS
     * @var dateTime
     */
    public $returnTMS;
    /**
     * Constructor method for rcsResultHeader
     * @see parent::__construct()
     * @param int $_customerId
     * @param dateTime $_returnTMS
     * @return BurgelRiskStructRcsResultHeader
     */
    public function __construct($_customerId = NULL,$_returnTMS = NULL)
    {
        BurgelRiskWsdlClass::__construct(array('customerId'=>$_customerId,'returnTMS'=>$_returnTMS),false);
    }
    /**
     * Get customerId value
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }
    /**
     * Set customerId value
     * @param int $_customerId the customerId
     * @return int
     */
    public function setCustomerId($_customerId)
    {
        return ($this->customerId = $_customerId);
    }
    /**
     * Get returnTMS value
     * @return dateTime|null
     */
    public function getReturnTMS()
    {
        return $this->returnTMS;
    }
    /**
     * Set returnTMS value
     * @param dateTime $_returnTMS the returnTMS
     * @return dateTime
     */
    public function setReturnTMS($_returnTMS)
    {
        return ($this->returnTMS = $_returnTMS);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructRcsResultHeader
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
