<?php
/**
 * File for class BurgelRiskStructCompanyRelation
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructCompanyRelation originally named companyRelation
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructCompanyRelation extends BurgelRiskWsdlClass
{
    /**
     * The buergelId
     * @var int
     */
    public $buergelId;
    /**
     * The companyName
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $companyName;
    /**
     * The postalCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $postalCode;
    /**
     * The city
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $city;
    /**
     * The country
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructCodeAndText
     */
    public $country;
    /**
     * The type
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructCodeAndText
     */
    public $type;
    /**
     * Constructor method for companyRelation
     * @see parent::__construct()
     * @param int $_buergelId
     * @param string $_companyName
     * @param string $_postalCode
     * @param string $_city
     * @param BurgelRiskStructCodeAndText $_country
     * @param BurgelRiskStructCodeAndText $_type
     * @return BurgelRiskStructCompanyRelation
     */
    public function __construct($_buergelId = NULL,$_companyName = NULL,$_postalCode = NULL,$_city = NULL,$_country = NULL,$_type = NULL)
    {
        parent::__construct(array('buergelId'=>$_buergelId,'companyName'=>$_companyName,'postalCode'=>$_postalCode,'city'=>$_city,'country'=>$_country,'type'=>$_type),false);
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
     * Get companyName value
     * @return string|null
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }
    /**
     * Set companyName value
     * @param string $_companyName the companyName
     * @return string
     */
    public function setCompanyName($_companyName)
    {
        return ($this->companyName = $_companyName);
    }
    /**
     * Get postalCode value
     * @return string|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    /**
     * Set postalCode value
     * @param string $_postalCode the postalCode
     * @return string
     */
    public function setPostalCode($_postalCode)
    {
        return ($this->postalCode = $_postalCode);
    }
    /**
     * Get city value
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * Set city value
     * @param string $_city the city
     * @return string
     */
    public function setCity($_city)
    {
        return ($this->city = $_city);
    }
    /**
     * Get country value
     * @return BurgelRiskStructCodeAndText|null
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * Set country value
     * @param BurgelRiskStructCodeAndText $_country the country
     * @return BurgelRiskStructCodeAndText
     */
    public function setCountry($_country)
    {
        return ($this->country = $_country);
    }
    /**
     * Get type value
     * @return BurgelRiskStructCodeAndText|null
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Set type value
     * @param BurgelRiskStructCodeAndText $_type the type
     * @return BurgelRiskStructCodeAndText
     */
    public function setType($_type)
    {
        return ($this->type = $_type);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructCompanyRelation
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
