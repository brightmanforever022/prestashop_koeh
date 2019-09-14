<?php
/**
 * File for class BurgelRiskStructBuergelError
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructBuergelError originally named buergelError
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructBuergelError extends BurgelRiskWsdlClass
{
    /**
     * The code
     * Meta informations extracted from the WSDL
     * - nillable : true
     * @var string
     */
    public $code;
    /**
     * The additionalText
     * Meta informations extracted from the WSDL
     * - nillable : true
     * @var string
     */
    public $additionalText;
    /**
     * The text
     * Meta informations extracted from the WSDL
     * - nillable : true
     * @var string
     */
    public $text;
    /**
     * Constructor method for buergelError
     * @see parent::__construct()
     * @param string $_code
     * @param string $_additionalText
     * @param string $_text
     * @return BurgelRiskStructBuergelError
     */
    public function __construct($_code = NULL,$_additionalText = NULL,$_text = NULL)
    {
        parent::__construct(array('code'=>$_code,'additionalText'=>$_additionalText,'text'=>$_text),false);
    }
    /**
     * Get code value
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * Set code value
     * @param string $_code the code
     * @return string
     */
    public function setCode($_code)
    {
        return ($this->code = $_code);
    }
    /**
     * Get additionalText value
     * @return string|null
     */
    public function getAdditionalText()
    {
        return $this->additionalText;
    }
    /**
     * Set additionalText value
     * @param string $_additionalText the additionalText
     * @return string
     */
    public function setAdditionalText($_additionalText)
    {
        return ($this->additionalText = $_additionalText);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructBuergelError
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
