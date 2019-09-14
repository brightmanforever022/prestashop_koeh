<?php
/**
 * File for class BurgelRiskStructRiskcheckOut
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructRiskcheckOut originally named riskcheckOut
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
abstract class BurgelRiskStructRiskcheckOut extends BurgelRiskStructRcsResponse
{
    /**
     * The buergelId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $buergelId;
    /**
     * The inquiryId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructInquiryId
     */
    public $inquiryId;
    /**
     * The decision
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructDecision
     */
    public $decision;
    /**
     * The address
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructResultAddress
     */
    public $address;
    /**
     * The nonStandardField
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * @var BurgelRiskStructNonStandardParameter
     */
    public $nonStandardField;
    /**
     * Constructor method for riskcheckOut
     * @see parent::__construct()
     * @param int $_buergelId
     * @param BurgelRiskStructInquiryId $_inquiryId
     * @param BurgelRiskStructDecision $_decision
     * @param BurgelRiskStructResultAddress $_address
     * @param BurgelRiskStructNonStandardParameter $_nonStandardField
     * @return BurgelRiskStructRiskcheckOut
     */
    public function __construct($_buergelId = NULL,$_inquiryId = NULL,$_decision = NULL,$_address = NULL,$_nonStandardField = NULL)
    {
        BurgelRiskWsdlClass::__construct(array('buergelId'=>$_buergelId,'inquiryId'=>$_inquiryId,'decision'=>$_decision,'address'=>$_address,'nonStandardField'=>$_nonStandardField),false);
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
     * Get inquiryId value
     * @return BurgelRiskStructInquiryId|null
     */
    public function getInquiryId()
    {
        return $this->inquiryId;
    }
    /**
     * Set inquiryId value
     * @param BurgelRiskStructInquiryId $_inquiryId the inquiryId
     * @return BurgelRiskStructInquiryId
     */
    public function setInquiryId($_inquiryId)
    {
        return ($this->inquiryId = $_inquiryId);
    }
    /**
     * Get decision value
     * @return BurgelRiskStructDecision|null
     */
    public function getDecision()
    {
        return $this->decision;
    }
    /**
     * Set decision value
     * @param BurgelRiskStructDecision $_decision the decision
     * @return BurgelRiskStructDecision
     */
    public function setDecision($_decision)
    {
        return ($this->decision = $_decision);
    }
    /**
     * Get address value
     * @return BurgelRiskStructResultAddress|null
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * Set address value
     * @param BurgelRiskStructResultAddress $_address the address
     * @return BurgelRiskStructResultAddress
     */
    public function setAddress($_address)
    {
        return ($this->address = $_address);
    }
    /**
     * Get nonStandardField value
     * @return BurgelRiskStructNonStandardParameter|null
     */
    public function getNonStandardField()
    {
        return $this->nonStandardField;
    }
    /**
     * Set nonStandardField value
     * @param BurgelRiskStructNonStandardParameter $_nonStandardField the nonStandardField
     * @return BurgelRiskStructNonStandardParameter
     */
    public function setNonStandardField($_nonStandardField)
    {
        return ($this->nonStandardField = $_nonStandardField);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructRiskcheckOut
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
