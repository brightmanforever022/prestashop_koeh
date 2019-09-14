<?php
/**
 * File for class BurgelRiskStructNonStandardParameter
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskStructNonStandardParameter originally named NonStandardParameter
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskStructNonStandardParameter extends BurgelRiskWsdlClass
{
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - use : required
     * @var string
     */
    public $name;
    /**
     * The _
     * @var string
     */
    public $_;
    /**
     * Constructor method for NonStandardParameter
     * @see parent::__construct()
     * @param string $_name
     * @param string $__
     * @return BurgelRiskStructNonStandardParameter
     */
    public function __construct($_name,$__ = NULL)
    {
        parent::__construct(array('name'=>$_name,'_'=>$__),false);
    }
    /**
     * Get name value
     * @return string
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
     * Get _ value
     * @return string|null
     */
    public function get_()
    {
        return $this->_;
    }
    /**
     * Set _ value
     * @param string $__ the _
     * @return string
     */
    public function set_($__)
    {
        return ($this->_ = $__);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see BurgelRiskWsdlClass::__set_state()
     * @uses BurgelRiskWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return BurgelRiskStructNonStandardParameter
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
