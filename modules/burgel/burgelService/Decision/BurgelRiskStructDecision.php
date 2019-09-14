<?php
/**
 * File for class BurgelRiskStructDecision
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructDecision originally named decision
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructDecision extends BurgelRiskWsdlClass
{
    /**
     * The score
     * @var decimal
     */
    public $score;
    /**
     * The text
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $text;
    /**
     * The addressOrigin
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var BurgelRiskStructCodeAndText
     */
    public $addressOrigin;
    /**
     * Constructor method for decision
     * @see parent::__construct()
     * @param decimal $_score
     * @param string $_text
     * @param BurgelRiskStructCodeAndText $_addressOrigin
     * @return BurgelRiskStructDecision
     */
    public function __construct($_score = NULL,$_text = NULL,$_addressOrigin = NULL)
    {
        parent::__construct(array('score'=>$_score,'text'=>$_text,'addressOrigin'=>$_addressOrigin),false);
    }
    /**
     * Get score value
     * @return decimal|null
     */
    public function getScore()
    {
        return $this->score;
    }
    /**
     * Set score value
     * @param decimal $_score the score
     * @return decimal
     */
    public function setScore($_score)
    {
        return ($this->score = $_score);
    }
    /**
     * Get text value
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }
    /**
     * Set text value
     * @param string $_text the text
     * @return string
     */
    public function setText($_text)
    {
        return ($this->text = $_text);
    }
    /**
     * Get addressOrigin value
     * @return BurgelRiskStructCodeAndText|null
     */
    public function getAddressOrigin()
    {
        return $this->addressOrigin;
    }
    /**
     * Set addressOrigin value
     * @param BurgelRiskStructCodeAndText $_addressOrigin the addressOrigin
     * @return BurgelRiskStructCodeAndText
     */
    public function setAddressOrigin($_addressOrigin)
    {
        return ($this->addressOrigin = $_addressOrigin);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructDecision
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
