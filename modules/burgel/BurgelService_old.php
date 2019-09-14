<?php
  // Wheelronix Ltd. development team
  // site: http://www.wheelronix.com
  // mail: info@wheelronix.com
  //

  //require_once 'burgel_sopa_types.php';

namespace Burgel;
use SoapClient, SoapFault, SoapHeader, SoapParam, SoapVar;

define('BURGEL_PRODUCT_ID', 42);

class BurgelService extends SoapClient
{
    protected $lastRequest = null;
    protected $lastResponse = null;
    public $username;
    public $password;

    /**
     * $burgelConfig array that should contain following keys (all are
     * obligatory): wsdlUrl, username, password
     *
     */
    function __construct($burgelConfig)
    {
        $this->username = $burgelConfig['username'];
        $this->password = $burgelConfig['password'];
        parent::__construct($burgelConfig['wsdlUrl']); // , array('soap_version' => SOAP_1_1)
    }

    
    
    /**
     * @param $customerData array('firstname', lastname, email, street,
     * houseNumber, postalCode, city)
     * @returns values from burgel reponse: assoc. array(score, firstname, lastname,
     * street, houseNumber, city, decisionText)
     * @throws exception in case of error
     */
    function validateCustomer($customerData)
    {
        $req = new \Burgel\concheckInput();

        $req->header = new \Burgel\inquiryHeader();
        $req->header->productNumber = 42;
        $req->header->inquiryReason = inquiryReasons::SOLVENCY_CHECK;
        $req->header->language = supportedLanguages::DE;
        $req->scoreVersion = 2;

        $req->address = new \Burgel\address();
        $req->address->person = new \Burgel\person();
        $req->address->person->firstname = $customerData['firstname'];
        $req->address->person->lastname = $customerData['lastname'];
        $req->address->person->emailAddress = $customerData['email'];

        $req->address->location = new \Burgel\location();
        $req->address->location->street = $customerData['street'];
        $req->address->location->houseNumber = $customerData['houseNumber'];
        $req->address->location->postalCode = $customerData['postalCode'];
        $req->address->location->city = $customerData['city'];
        $req->address->location->country = new \Burgel\codeAndText();
        $req->address->location->country->code = '276';
        $req->checkAddressFirst = true;

        $req2 = new \Burgel\concheck();
        $req2->concheckIn = $req;

        // generate authentication header
        $prefix = gethostname();
        $nonce = base64_encode( substr( md5( uniqid( $prefix.'_', true)), 0, 16));

        $created = date('c');
        $authheader = '
<wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
<wsse:UsernameToken wsu:Id="UsernameToken-6">
<wsse:Username>'.$this->username.'</wsse:Username>
<wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">'.$this->password.'</wsse:Password>
<wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">'.$nonce.'</wsse:Nonce>
<wsu:Created>'.$created.'</wsu:Created>
</wsse:UsernameToken>
</wsse:Security>';

        $wsse_header = new SoapHeader("http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd", "Security", new SoapVar($authheader,XSD_ANYXML));

        $this->__setSoapHeaders(array($wsse_header));

        $response = $this->concheck($req2);
        $response = $response->concheckOut;
        
        // prepare return array
        return array('score'=>$response->decision->score, 'firstname'=>$response->address->person->firstname, 'lastname'=>$response->address->person->lastname,
                     'street'=>$response->address->location->street, 'houseNumber'=>$response->address->location->houseNumber, 'city'=>$response->address->location->city,
                     'decisionText'=>$response->decision->text
            );
    }
    
    
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    
    public function __doRequest($request , $location , $action , $version, $oneWay=null)
    {
        $this->lastRequest = str_replace(array('SOAP-ENV', 'ns1', 'ns2'), array('soapenv', 'v1', 'wsse'), $request);
        $this->lastResponse = parent::__doRequest($this->lastRequest, $location, $action, $version, $oneWay);
        return $this->lastResponse;
    }
}


// interface types definition
class concheck {
  public $concheckIn; // concheckInput
}

class concheckInput extends productCC{
  public $address; // address
  public $checkAddressFirst; // boolean
}

class productCC {
  public $header; // inquiryHeader
  public $scoreVersion; // int
}

class address {
  public $person; // person
  public $location; // location
}

class person {
  public $firstname; // string
  public $lastname; // string
  public $dateOfBirth; // date
  public $emailAddress; // string
  public $phone; // string
}

class location {
  public $street; // string
  public $houseNumber; // string
  public $postalCode; // string
  public $city; // string
  public $country; // codeAndText
}

class codeAndText {
  public $code; // int
  public $text; // string
}

class inquiryHeader {
  public $productNumber; // int
  public $inquiryReason; // inquiryReasons
  public $language; // supportedLanguages
  public $nonStandardParameters; // nonStandardParameters
}

class nonStandardParameters {
  public $nonStandardParameter; // NonStandardParameter
}

class basicHeader {
  public $customerReference; // string
  public $externalUserid; // string
}

class NonStandardParameter {
  public $_; // string
  public $name; // string
}

class concheckResponse {
  public $concheckOut; // concheckOut
}

class concheckOut {
}

class rcsResponse {
  public $header; // basicResultHeader
}

class basicResultHeader {
}

class rcsResultHeader {
  public $customerId; // int
  public $returnTMS; // dateTime
}

class productResultHeader {
  public $productNumber; // int
  public $language; // supportedLanguages
}

class ConcheckBasicResult {
  public $inquiryId; // inquiryId
  public $decision; // decision
  public $address; // address
}

class inquiryId {
  public $buergelAgencyNumber; // int
  public $inquiryNumber; // int
}

class decision {
  public $score; // decimal
  public $text; // string
  public $addressOrigin; // codeAndText
}

class ConcheckResult {
  public $negativeCriterion; // NegativeCriterion
  public $companyRelation; // companyRelation
}

class NegativeCriterion {
  public $quantity; // int
  public $typeOfCriterion; // codeAndText
  public $principalClaimAmount; // monetaryValue
  public $dateOfLastEntry; // date
}

class monetaryValue {
  public $_; // decimal
  public $currency; // string
}

class NegativeCriterionLegal {
  public $reference; // string
  public $court; // court
}

class court {
  public $postalCode; // string
  public $city; // string
}

class companyRelation {
  public $buergelId; // int
  public $companyName; // string
  public $postalCode; // string
  public $city; // string
  public $country; // codeAndText
  public $type; // codeAndText
}

class ConcheckJurResult {
}

class negativeCheck {
  public $negativeCheckIn; // negativeCheckInput
}

class negativeCheckInput {
}

class negativeCheckResponse {
  public $negativeCheckOut; // rcsResponse
}

class negativeCheckServiceResult {
  public $inquiryId; // inquiryId
  public $address; // address
  public $decision; // negativeCheckDecision
  public $negativeCriterion; // NegativeCriterion
}

class negativeCheckDecision {
  public $text; // string
  public $addressOrigin; // codeAndText
}

class inquiryReasons {
  const CREDIT_INQUIRY = 'CREDIT_INQUIRY';
  const BUSINESS_RELATIONSHIP = 'BUSINESS_RELATIONSHIP';
  const SOLVENCY_CHECK = 'SOLVENCY_CHECK';
  const CLAIM = 'CLAIM';
}

class supportedLanguages {
  const DE = 'DE';
  const EN = 'EN';
  const ES = 'ES';
  const FR = 'FR';
  const IT = 'IT';
}

class buergelError {
  public $code; // string
  public $additionalText; // string
  public $text; // string
}
