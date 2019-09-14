<?php
/**
 * File for class BurgelRiskStructIdentificationBusinessResult
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructIdentificationBusinessResult originally named identificationBusinessResult
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructIdentificationBusinessResult extends BurgelRiskWsdlClass
{
    /**
     * The buergelId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $buergelId;
    /**
     * The name
     * @var string
     */
    public $name;
    /**
     * The dateOfBirth
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var date
     */
    public $dateOfBirth;
    /**
     * The emailAddress
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $emailAddress;
    /**
     * The website
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $website;
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
     * The vatNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $vatNumber;
    /**
     * Constructor method for identificationBusinessResult
     * @see parent::__construct()
     * @param int $_buergelId
     * @param string $_name
     * @param date $_dateOfBirth
     * @param string $_emailAddress
     * @param string $_website
     * @param string $_phone
     * @param string $_commercialRegisterEntry
     * @param string $_vatNumber
     * @return BurgelRiskStructIdentificationBusinessResult
     */
    public function __construct($_buergelId = NULL,$_name = NULL,$_dateOfBirth = NULL,$_emailAddress = NULL,$_website = NULL,$_phone = NULL,$_commercialRegisterEntry = NULL,$_vatNumber = NULL)
    {
        parent::__construct(array('buergelId'=>$_buergelId,'name'=>$_name,'dateOfBirth'=>$_dateOfBirth,'emailAddress'=>$_emailAddress,'website'=>$_website,'phone'=>$_phone,'commercialRegisterEntry'=>$_commercialRegisterEntry,'vatNumber'=>$_vatNumber),false);
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
     * Get dateOfBirth value
     * @return date|null
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }
    /**
     * Set dateOfBirth value
     * @param date $_dateOfBirth the dateOfBirth
     * @return date
     */
    public function setDateOfBirth($_dateOfBirth)
    {
        return ($this->dateOfBirth = $_dateOfBirth);
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
     * Get website value
     * @return string|null
     */
    public function getWebsite()
    {
        return $this->website;
    }
    /**
     * Set website value
     * @param string $_website the website
     * @return string
     */
    public function setWebsite($_website)
    {
        return ($this->website = $_website);
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
     * Get vatNumber value
     * @return string|null
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }
    /**
     * Set vatNumber value
     * @param string $_vatNumber the vatNumber
     * @return string
     */
    public function setVatNumber($_vatNumber)
    {
        return ($this->vatNumber = $_vatNumber);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructIdentificationBusinessResult
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
