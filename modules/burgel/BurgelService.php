<?php

class BurgelService
{
    /**
     * Call burgel, records call data in db and returns info
     * @param $customer customer object
     * @param $address address object
     * @returns BurgelCall object or false if customer is from not supported country or no answer from burgel
     */
    static function &validateCustomer(&$customer, &$address)
    {
        // check if customer is from germany
        $isoCode = Country::getIsoById($address->id_country);
        if ($isoCode!='DE')
        {
            return false;
        }
        
        require_once dirname(__FILE__) . '/burgelService/BurgelRiskAutoload.php';
        require_once dirname(__FILE__) . '/BurgelCall.php';
        
        try
        {
            // prepare input data for call
            $identification = new BurgelRiskStructIdentificationRequest($customer->company ? $customer->company : $customer->firstname . ' ' .
                    $customer->lastname, strtotime($customer->birthday) > 0 ? $customer->birthday : null, $customer->email, $customer->phone);

            $street = $address->address1;
            $houseNumber = Address::getHouseNumber($street);
            if ($houseNumber)
            {
                $street = trim(str_replace($houseNumber, '', $street));
            }
            else
            {
                throw new Exception('Can\'t extract house number');
            }
            $location = new BurgelRiskStructLocation($street, $houseNumber, $address->postcode, $address->city, 
                    new BurgelRiskStructCodeAndText('276'));
            $reqAddress = new BurgelRiskStructRequestAddress($identification, $location);
            $addressIn = new BurgelRiskStructRiskcheckInput(true, // check address first
                    $reqAddress /* , burgelid */); //42072189
            $header = new BurgelRiskStructInquiryHeader('46');
            $addressIn->setHeader($header);

            // call burgel service
            $wsdl = [BurgelRiskWsdlClass::WSDL_LOGIN => Configuration::get('BURGEL_LOGIN'),
            BurgelRiskWsdlClass::WSDL_PASSWD => Configuration::get('BURGEL_PASSWORD'),
            BurgelRiskWsdlClass::WSDL_URL => Configuration::get('BURGEL_URL')];
            $burgelRiskServiceRiskcheck = new BurgelRiskServiceRiskcheck($wsdl);
            $riskCheckInput = new BurgelRiskStructRiskcheck($addressIn);
            
            $burgelCallLog = new BurgelCall();
            $burgelCallLog->call_date = date('Y-m-d H:i:s');
            $burgelCallLog->customer_id = $customer->id;
            $burgelCallLog->address_id = $address->id; 
            $callResult = $burgelRiskServiceRiskcheck->riskcheck($riskCheckInput);
            $burgelCallLog->raw_data = "request:\n".$burgelRiskServiceRiskcheck::getSoapClient()->lastRequest;
            $burgelCallLog->raw_data .= "\nresponse:\n".$burgelRiskServiceRiskcheck::getSoapClient()->lastResponse;
            if (!$callResult)
            {
                $fault = $burgelRiskServiceRiskcheck->getLastError();
                if (!isset($fault['BurgelRiskServiceRiskcheck::riskcheck']))
                {
                    throw  new Exception('Unknow error: '.print_r($fault, true));
                }
                $fault = $fault['BurgelRiskServiceRiskcheck::riskcheck'];
                $burgelCallLog->raw_data .= "\nerror: ".$fault->getMessage()."\nfaultstring: ".$fault->faultstring.
                    "\nfaultcode ".$fault->faultcode."\ndetail: ".print_r($fault->detail, true);

                // try to resend request w/o wsdl cache
                ini_set('soap.wsdl_cache_ttl', '1'); 
                $burgelCallLog->raw_data .= "\n resend";
                $callResult = $burgelRiskServiceRiskcheck->riskcheck($riskCheckInput);
                $burgelCallLog->raw_data .= "\nresponse:\n".$burgelRiskServiceRiskcheck::getSoapClient()->lastResponse;
                if (!$callResult)
                {
                    $fault = $burgelRiskServiceRiskcheck->getLastError()['BurgelRiskServiceRiskcheck::riskcheck'];
                    $burgelCallLog->raw_data .= "\nerror: ".$fault->getMessage()."\nfaultstring: ".$fault->faultstring.
                        "\nfaultcode ".$fault->faultcode."\ndetail: ".print_r($fault->detail, true);
                    if (isset($fault->detail->buergelError) && isset($fault->detail->buergelError->text))
                    {
                        $burgelCallLog->resp_decision_text = $fault->detail->buergelError->text;
                    }
                    throw new Exception('was not able to contact with burgel');
                }
            }
            
            // save call log
            $response = $callResult->riskcheckOut;
            $burgelCallLog->resp_city = $response->address->location->city;
            $burgelCallLog->resp_decision_text = $response->decision->text;
            $burgelCallLog->resp_score = $response->decision->score;
            $burgelCallLog->resp_firstname = $response->address->identification->name;
            $burgelCallLog->resp_house_number = $response->address->location->houseNumber;
            $burgelCallLog->resp_street = $response->address->location->street;
            $burgelCallLog->add();
        }
        catch(Exception $e)
        {
            $burgelCallLog->raw_data .= "\nerror occured: ".$e->getMessage()."\nexit";
            $burgelCallLog->add();
        }
        
        return $burgelCallLog;
    }
}
