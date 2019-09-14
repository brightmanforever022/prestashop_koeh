<?php
/**
 * File for class BurgelRiskStructRiskcheckInput
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructRiskcheckInput originally named riskcheckInput
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructRiskcheckInput extends BurgelRiskStructProductCC
{
    /**
     * The checkAddressFirst
     * Meta informations extracted from the WSDL
     * - use : required
     * @var boolean
     */
    public $checkAddressFirst;
    /**
     * The address
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructRequestAddress
     */
    public $address;
    /**
     * The buergelId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $buergelId;
    /**
     * Constructor method for riskcheckInput
     * @see parent::__construct()
     * @param boolean $_checkAddressFirst
     * @param BurgelRiskStructRequestAddress $_address
     * @param int $_buergelId
     * @return BurgelRiskStructRiskcheckInput
     */
    public function __construct($_checkAddressFirst,$_address = NULL,$_buergelId = NULL)
    {
        BurgelRiskWsdlClass::__construct(array('checkAddressFirst'=>$_checkAddressFirst,'address'=>$_address,'buergelId'=>$_buergelId),false);
    }
    /**
     * Get checkAddressFirst value
     * @return boolean
     */
    public function getCheckAddressFirst()
    {
        return $this->checkAddressFirst;
    }
    /**
     * Set checkAddressFirst value
     * @param boolean $_checkAddressFirst the checkAddressFirst
     * @return boolean
     */
    public function setCheckAddressFirst($_checkAddressFirst)
    {
        return ($this->checkAddressFirst = $_checkAddressFirst);
    }
    /**
     * Get address value
     * @return BurgelRiskStructRequestAddress|null
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * Set address value
     * @param BurgelRiskStructRequestAddress $_address the address
     * @return BurgelRiskStructRequestAddress
     */
    public function setAddress($_address)
    {
        return ($this->address = $_address);
    }
    /**
     * Get buergelId value
     * @return int|null
     */
    public function getBuergelId()
    {
        return $this->buergelId;
    }
    /**
     * Set buergelId value
     * @param int $_buergelId the buergelId
     * @return int
     */
    public function setBuergelId($_buergelId)
    {
        return ($this->buergelId = $_buergelId);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructRiskcheckInput
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
