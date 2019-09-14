<?php
/**
 * File for the class which returns the class map definition
 * @package BurgelRisk
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
/**
 * Class which returns the class map definition by the static method BurgelRiskClassMap::classMap()
 * @package BurgelRisk
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
class BurgelRiskClassMap
{
    /**
     * This method returns the array containing the mapping between WSDL structs and generated classes
     * This array is sent to the SoapClient when calling the WS
     * @return array
     */
    final public static function classMap()
    {
        return array (
  'NegativeCriterion' => 'BurgelRiskStructNegativeCriterion',
  'NegativeCriterionLegal' => 'BurgelRiskStructNegativeCriterionLegal',
  'NonStandardParameter' => 'BurgelRiskStructNonStandardParameter',
  'RiskcheckResult' => 'BurgelRiskStructRiskcheckResult',
  'basicHeader' => 'BurgelRiskStructBasicHeader',
  'basicResultHeader' => 'BurgelRiskStructBasicResultHeader',
  'buergelError' => 'BurgelRiskStructBuergelError',
  'codeAndText' => 'BurgelRiskStructCodeAndText',
  'companyRelation' => 'BurgelRiskStructCompanyRelation',
  'court' => 'BurgelRiskStructCourt',
  'decision' => 'BurgelRiskStructDecision',
  'identificationBusinessRequest' => 'BurgelRiskStructIdentificationBusinessRequest',
  'identificationBusinessResult' => 'BurgelRiskStructIdentificationBusinessResult',
  'identificationCompany' => 'BurgelRiskStructIdentificationCompany',
  'identificationPerson' => 'BurgelRiskStructIdentificationPerson',
  'identificationRequest' => 'BurgelRiskStructIdentificationRequest',
  'inquiryHeader' => 'BurgelRiskStructInquiryHeader',
  'inquiryId' => 'BurgelRiskStructInquiryId',
  'inquiryReasons' => 'BurgelRiskEnumInquiryReasons',
  'location' => 'BurgelRiskStructLocation',
  'monetaryValue' => 'BurgelRiskStructMonetaryValue',
  'nonStandardParameters' => 'BurgelRiskStructNonStandardParameters',
  'productCC' => 'BurgelRiskStructProductCC',
  'productResultHeader' => 'BurgelRiskStructProductResultHeader',
  'rcsResponse' => 'BurgelRiskStructRcsResponse',
  'rcsResultHeader' => 'BurgelRiskStructRcsResultHeader',
  'requestAddress' => 'BurgelRiskStructRequestAddress',
  'resultAddress' => 'BurgelRiskStructResultAddress',
  'riskcheck' => 'BurgelRiskStructRiskcheck',
  'riskcheckAdvancedServiceResult' => 'BurgelRiskStructRiskcheckAdvancedServiceResult',
  'riskcheckInput' => 'BurgelRiskStructRiskcheckInput',
  'riskcheckOut' => 'BurgelRiskStructRiskcheckOut',
  'riskcheckProfServiceResult' => 'BurgelRiskStructRiskcheckProfServiceResult',
  'riskcheckResponse' => 'BurgelRiskStructRiskcheckResponse',
  'supportedLanguages' => 'BurgelRiskEnumSupportedLanguages',
);
    }
}
