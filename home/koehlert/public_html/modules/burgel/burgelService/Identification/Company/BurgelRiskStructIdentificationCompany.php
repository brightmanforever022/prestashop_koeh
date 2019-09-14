<?php
/**
 * File for class BurgelRiskStructIdentificationCompany
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructIdentificationCompany originally named identificationCompany
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructIdentificationCompany extends BurgelRiskWsdlClass
{
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $name;
    /**
     * The emailAddress
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $emailAddress;
    /**
     * The phone
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $phone;
    /**
     * The commercialRegisterEntry
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $commercialRegisterEntry;
    /**
     * Constructor method for identificationCompany
     * @see parent::__construct()
     * @param string $_name
     * @param string $_emailAddress
     * @param string $_phone
     * @param string $_commercialRegisterEntry
     * @return BurgelRiskStructIdentificationCompany
     */
    public function __construct($_name = NULL,$_emailAddress = NULL,$_phone = NULL,$_commercialRegisterEntry = NULL)
    {
        parent::__construct(array('name'=>$_name,'emailAddress'=>$_emailAddress,'phone'=>$_phone,'commercialRegisterEntry'=>$_commercialRegisterEntry),false);
    }
    /**
     * Get name value
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name value
     * @param string $_name the name
     * @return string
     */
    public function setName($_name)
    {
        return ($this->name = $_name);
    }
    /**
     * Get emailAddress value
     * @return string|null
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
    /**
     * Set emailAddress value
     * @param string $_emailAddress the emailAddress
     * @return string
     */
    public function setEmailAddress($_emailAddress)
    {
        return ($this->emailAddress = $_emailAddress);
    }
    /**
     * Get phone value
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * Set phone value
     * @param string $_phone the phone
     * @return string
     */
    public function setPhone($_phone)
    {
        return ($this->phone = $_phone);
    }
    /**
     * Get commercialRegisterEntry value
     * @return string|null
     */
    public function getCommercialRegisterEntry()
    {
        return $this->commercialRegisterEntry;
    }
    /**
     * Set commercialRegisterEntry value
     * @param string $_commercialRegisterEntry the commercialRegisterEntry
     * @return string
     */
    public function setCommercialRegisterEntry($_commercialRegisterEntry)
    {
        return ($this->commercialRegisterEntry = $_commercialRegisterEntry);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructIdentificationCompany
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
