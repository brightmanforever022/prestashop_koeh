<?php
/**
 * File for class BurgelRiskStructBasicHeader
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructBasicHeader originally named basicHeader
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
abstract class BurgelRiskStructBasicHeader extends BurgelRiskWsdlClass
{
    /**
     * The customerReference
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $customerReference;
    /**
     * The externalUserid
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $externalUserid;
    /**
     * Constructor method for basicHeader
     * @see parent::__construct()
     * @param string $_customerReference
     * @param string $_externalUserid
     * @return BurgelRiskStructBasicHeader
     */
    public function __construct($_customerReference = NULL,$_externalUserid = NULL)
    {
        parent::__construct(array('customerReference'=>$_customerReference,'externalUserid'=>$_externalUserid),false);
    }
    /**
     * Get customerReference value
     * @return string|null
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
    }
    /**
     * Set customerReference value
     * @param string $_customerReference the customerReference
     * @return string
     */
    public function setCustomerReference($_customerReference)
    {
        return ($this->customerReference = $_customerReference);
    }
    /**
     * Get externalUserid value
     * @return string|null
     */
    public function getExternalUserid()
    {
        return $this->externalUserid;
    }
    /**
     * Set externalUserid value
     * @param string $_externalUserid the externalUserid
     * @return string
     */
    public function setExternalUserid($_externalUserid)
    {
        return ($this->externalUserid = $_externalUserid);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructBasicHeader
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
