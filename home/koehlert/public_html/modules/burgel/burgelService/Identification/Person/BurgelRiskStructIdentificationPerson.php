<?php
/**
 * File for class BurgelRiskStructIdentificationPerson
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructIdentificationPerson originally named identificationPerson
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructIdentificationPerson extends BurgelRiskWsdlClass
{
    /**
     * The firstname
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $firstname;
    /**
     * The lastname
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $lastname;
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
     * The phone
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $phone;
    /**
     * Constructor method for identificationPerson
     * @see parent::__construct()
     * @param string $_firstname
     * @param string $_lastname
     * @param date $_dateOfBirth
     * @param string $_emailAddress
     * @param string $_phone
     * @return BurgelRiskStructIdentificationPerson
     */
    public function __construct($_firstname = NULL,$_lastname = NULL,$_dateOfBirth = NULL,$_emailAddress = NULL,$_phone = NULL)
    {
        parent::__construct(array('firstname'=>$_firstname,'lastname'=>$_lastname,'dateOfBirth'=>$_dateOfBirth,'emailAddress'=>$_emailAddress,'phone'=>$_phone),false);
    }
    /**
     * Get firstname value
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    /**
     * Set firstname value
     * @param string $_firstname the firstname
     * @return string
     */
    public function setFirstname($_firstname)
    {
        return ($this->firstname = $_firstname);
    }
    /**
     * Get lastname value
     * @return string|null
     */
    public function getLastname()
    {
        return $this->lastname;
    }
    /**
     * Set lastname value
     * @param string $_lastname the lastname
     * @return string
     */
    public function setLastname($_lastname)
    {
        return ($this->lastname = $_lastname);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructIdentificationPerson
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
