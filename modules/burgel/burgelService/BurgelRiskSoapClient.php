<?php

// Wheelronix Ltd. development team
// site: http://www.wheelronix.com
// mail: info@wheelronix.com

class BurgelRiskSoapClient extends SoapClient
{
    public $lastRequest = null;
    public $lastResponse = null;
    public $options;
    
    public function __construct ($wsdl, $options=null)
    {
        $this->options = $options;
        //var_dump($wsdl, $options);
        //exit;
        parent::__construct($wsdl, $options);
    }

    
    public function __doRequest($request , $location , $action , $version, $oneWay=null)
    {
        $this->lastRequest = str_replace(array('SOAP-ENV', 'ns1', 'ns2'), array('soapenv', 'v1', 'wsse'), $request);
        $this->lastResponse = parent::__doRequest($this->lastRequest, $location, $action, $version, $oneWay);
        return $this->lastResponse;
    }
    
    
    
    function __call ( $function_name, $arguments)
    {
        $options = $this->options;
        
           // generate authentication header
        $prefix = gethostname();
        $nonce = base64_encode( substr( md5( uniqid( $prefix.'_', true)), 0, 16));

        $created = date('c');
        $authheader = '
<wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
<wsse:UsernameToken wsu:Id="UsernameToken-6">
<wsse:Username>'.$options['login'].'</wsse:Username>
<wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">'.$options['password'].'</wsse:Password>
<wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">'.$nonce.'</wsse:Nonce>
<wsu:Created>'.$created.'</wsu:Created>
</wsse:UsernameToken>
</wsse:Security>';

        $wsse_header = new SoapHeader("http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd", "Security", new SoapVar($authheader,XSD_ANYXML));
        $this->__setSoapHeaders($wsse_header);
        
        return parent::__call ( $function_name, $arguments);
    }
}
