<?php
/**
 * File for class BurgelRiskStructCodeAndText
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructCodeAndText originally named codeAndText
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructCodeAndText extends BurgelRiskWsdlClass
{
    /**
     * The code
     * @var int
     */
    public $code;
    /**
     * The text
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $text;
    /**
     * Constructor method for codeAndText
     * @see parent::__construct()
     * @param int $_code
     * @param string $_text
     * @return BurgelRiskStructCodeAndText
     */
    public function __construct($_code = NULL,$_text = NULL)
    {
        parent::__construct(array('code'=>$_code,'text'=>$_text),false);
    }
    /**
     * Get code value
     * @return int|null
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * Set code value
     * @param int $_code the code
     * @return int
     */
    public function setCode($_code)
    {
        return ($this->code = $_code);
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
     * @return BurgelRiskStructCodeAndText
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
