<?php
/**
 * File for class BurgelRiskStructNegativeCriterion
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructNegativeCriterion originally named NegativeCriterion
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructNegativeCriterion extends BurgelRiskWsdlClass
{
    /**
     * The quantity
     * @var int
     */
    public $quantity;
    /**
     * The typeOfCriterion
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructCodeAndText
     */
    public $typeOfCriterion;
    /**
     * The principalClaimAmount
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructMonetaryValue
     */
    public $principalClaimAmount;
    /**
     * The dateOfLastEntry
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var date
     */
    public $dateOfLastEntry;
    /**
     * Constructor method for NegativeCriterion
     * @see parent::__construct()
     * @param int $_quantity
     * @param BurgelRiskStructCodeAndText $_typeOfCriterion
     * @param BurgelRiskStructMonetaryValue $_principalClaimAmount
     * @param date $_dateOfLastEntry
     * @return BurgelRiskStructNegativeCriterion
     */
    public function __construct($_quantity = NULL,$_typeOfCriterion = NULL,$_principalClaimAmount = NULL,$_dateOfLastEntry = NULL)
    {
        parent::__construct(array('quantity'=>$_quantity,'typeOfCriterion'=>$_typeOfCriterion,'principalClaimAmount'=>$_principalClaimAmount,'dateOfLastEntry'=>$_dateOfLastEntry),false);
    }
    /**
     * Get quantity value
     * @return int|null
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    /**
     * Set quantity value
     * @param int $_quantity the quantity
     * @return int
     */
    public function setQuantity($_quantity)
    {
        return ($this->quantity = $_quantity);
    }
    /**
     * Get typeOfCriterion value
     * @return BurgelRiskStructCodeAndText|null
     */
    public function getTypeOfCriterion()
    {
        return $this->typeOfCriterion;
    }
    /**
     * Set typeOfCriterion value
     * @param BurgelRiskStructCodeAndText $_typeOfCriterion the typeOfCriterion
     * @return BurgelRiskStructCodeAndText
     */
    public function setTypeOfCriterion($_typeOfCriterion)
    {
        return ($this->typeOfCriterion = $_typeOfCriterion);
    }
    /**
     * Get principalClaimAmount value
     * @return BurgelRiskStructMonetaryValue|null
     */
    public function getPrincipalClaimAmount()
    {
        return $this->principalClaimAmount;
    }
    /**
     * Set principalClaimAmount value
     * @param BurgelRiskStructMonetaryValue $_principalClaimAmount the principalClaimAmount
     * @return BurgelRiskStructMonetaryValue
     */
    public function setPrincipalClaimAmount($_principalClaimAmount)
    {
        return ($this->principalClaimAmount = $_principalClaimAmount);
    }
    /**
     * Get dateOfLastEntry value
     * @return date|null
     */
    public function getDateOfLastEntry()
    {
        return $this->dateOfLastEntry;
    }
    /**
     * Set dateOfLastEntry value
     * @param date $_dateOfLastEntry the dateOfLastEntry
     * @return date
     */
    public function setDateOfLastEntry($_dateOfLastEntry)
    {
        return ($this->dateOfLastEntry = $_dateOfLastEntry);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructNegativeCriterion
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
