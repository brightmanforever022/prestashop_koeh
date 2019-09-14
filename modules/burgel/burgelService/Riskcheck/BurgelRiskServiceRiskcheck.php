<?php
/**
 * File for class BurgelRiskServiceRiskcheck
 * @package BurgelRisk
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * This class stands for BurgelRiskServiceRiskcheck originally named Riskcheck
 * @package BurgelRisk
 * @subpackage Services
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskServiceRiskcheck extends BurgelRiskWsdlClass
{
    /**
     * Method to call the operation originally named riskcheck
     * Documentation : method to call any RiskCheck product specified by its productnumber; although the parameter riskcheckIn maybe marked as optional it IS required
     * @uses BurgelRiskWsdlClass::getSoapClient()
     * @uses BurgelRiskWsdlClass::setResult()
     * @uses BurgelRiskWsdlClass::saveLastError()
     * @param BurgelRiskStructRiskcheck $_burgelRiskStructRiskcheck
     * @return BurgelRiskStructRiskcheckResponse
     */
    public function riskcheck(BurgelRiskStructRiskcheck $_burgelRiskStructRiskcheck)
    {
        try
        {
            return $this->setResult(self::getSoapClient()->riskcheck($_burgelRiskStructRiskcheck));
        }
        catch(SoapFault $soapFault)
        {
            return !$this->saveLastError(__METHOD__,$soapFault);
        }
    }
    /**
     * Returns the result
     * @see BurgelRiskWsdlClass::getResult()
     * @return BurgelRiskStructRiskcheckResponse
     */
    public function getResult()
    {
        return parent::getResult();
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
