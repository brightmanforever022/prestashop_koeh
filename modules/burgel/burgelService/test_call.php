<?php
/**
 * Test with BurgelRisk for 'https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl'
 * @package BurgelRisk
 * @author WsdlToPhp Team <contact@wsdltophp.com>
 * @version 20150429-01
 * @date 2019-03-04
 */
ini_set('memory_limit','512M');
ini_set('display_errors',true);
error_reporting(-1);
/**
 * Load autoload
 */
require_once dirname(__FILE__) . '/BurgelRiskAutoload.php';
/**
 * Wsdl instanciation infos. By default, nothing has to be set.
 * If you wish to override the SoapClient's options, please refer to the sample below.
 * 
 * This is an associative array as:
 * - the key must be a BurgelRiskWsdlClass constant beginning with WSDL_
 * - the value must be the corresponding key value
 * Each option matches the {@link http://www.php.net/manual/en/soapclient.soapclient.php} options
 * 
 * Here is below an example of how you can set the array:
 * $wsdl = array();
 * $wsdl[BurgelRiskWsdlClass::WSDL_URL] = 'https://test.buergel-online.de/b2c-ws-test/services/b2c/v2/riskcheck?wsdl';
 * $wsdl[BurgelRiskWsdlClass::WSDL_CACHE_WSDL] = WSDL_CACHE_NONE;
 * $wsdl[BurgelRiskWsdlClass::WSDL_TRACE] = true;
 * $wsdl[BurgelRiskWsdlClass::WSDL_LOGIN] = 'myLogin';
 * $wsdl[BurgelRiskWsdlClass::WSDL_PASSWD] = '**********';
 * etc....
 * Then instantiate the Service class as: 
 * - $wsdlObject = new BurgelRiskWsdlClass($wsdl);
 */
/**
 * Examples
 */


/****************************************
 * Example for BurgelRiskServiceRiskcheck
 */

//$soapClient = new BurgelRiskSoapClient();
//BurgelRiskWsdlClass::setSoapClient($soapClient);

// test mode
$wsdl[BurgelRiskWsdlClass::WSDL_LOGIN] = '30200174';
$wsdl[BurgelRiskWsdlClass::WSDL_PASSWD] = 'z7i4evr9';
//$wsdl[BurgelRiskWsdlClass::WSDL_TRACE] = true;
$burgelRiskServiceRiskcheck = new BurgelRiskServiceRiskcheck($wsdl);
$soapClient = $burgelRiskServiceRiskcheck->getSoapClient();

// sample call for BurgelRiskServiceRiskcheck::riskcheck()
$identification = new BurgelRiskStructIdentificationRequest('Muster GmbH', null /* birthday */, 'info@muster-gmbh.de', '040/89803209');
$location = new BurgelRiskStructLocation('Alfred-Jahncke-Ring', '17', '22399', 'Hamburg', new BurgelRiskStructCodeAndText('276')); // '276'
$address = new BurgelRiskStructRequestAddress($identification, $location);
$addressIn = new BurgelRiskStructRiskcheckInput(true, // check address first
   $address /*, burgelid*/); //42072189
$header = new BurgelRiskStructInquiryHeader('46');
$addressIn->setHeader($header);

$res = $burgelRiskServiceRiskcheck->riskcheck(new BurgelRiskStructRiskcheck($addressIn));
print_r($res);
if($res)
    print_r($burgelRiskServiceRiskcheck->getResult());
else
{
    echo "error:\n";
    print_r($burgelRiskServiceRiskcheck->getLastError());
}

print_r($soapClient->lastRequest);
print_r($soapClient->lastResponse);