<?php
/**
 * File for class BurgelRiskEnumSupportedLanguages
 * @package BurgelRisk
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskEnumSupportedLanguages originally named supportedLanguages
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl}
 * @package BurgelRisk
 * @subpackage Enumerations
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskEnumSupportedLanguages extends BurgelRiskWsdlClass
{
    /**
     * Constant for value 'DE'
     * @return string 'DE'
     */
    const VALUE_DE = 'DE';
    /**
     * Constant for value 'EN'
     * @return string 'EN'
     */
    const VALUE_EN = 'EN';
    /**
     * Constant for value 'ES'
     * @return string 'ES'
     */
    const VALUE_ES = 'ES';
    /**
     * Constant for value 'FR'
     * @return string 'FR'
     */
    const VALUE_FR = 'FR';
    /**
     * Constant for value 'IT'
     * @return string 'IT'
     */
    const VALUE_IT = 'IT';
    /**
     * Return true if value is allowed
     * @uses BurgelRiskEnumSupportedLanguages::VALUE_DE
     * @uses BurgelRiskEnumSupportedLanguages::VALUE_EN
     * @uses BurgelRiskEnumSupportedLanguages::VALUE_ES
     * @uses BurgelRiskEnumSupportedLanguages::VALUE_FR
     * @uses BurgelRiskEnumSupportedLanguages::VALUE_IT
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(BurgelRiskEnumSupportedLanguages::VALUE_DE,BurgelRiskEnumSupportedLanguages::VALUE_EN,BurgelRiskEnumSupportedLanguages::VALUE_ES,BurgelRiskEnumSupportedLanguages::VALUE_FR,BurgelRiskEnumSupportedLanguages::VALUE_IT));
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
