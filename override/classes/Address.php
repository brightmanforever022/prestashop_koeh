<?php

class Address extends AddressCore
{
    public $latitude;
    public $longitude;


    // removed "vat_number" 
    public static $definition = array(
        'table' => 'address',
        'primary' => 'id_address',
        'fields' => array(
            'id_customer' =>        array('type' => self::TYPE_INT, 'validate' => 'isNullOrUnsignedId', 'copy_post' => false),
            'id_manufacturer' =>    array('type' => self::TYPE_INT, 'validate' => 'isNullOrUnsignedId', 'copy_post' => false),
            'id_supplier' =>        array('type' => self::TYPE_INT, 'validate' => 'isNullOrUnsignedId', 'copy_post' => false),
            'id_warehouse' =>        array('type' => self::TYPE_INT, 'validate' => 'isNullOrUnsignedId', 'copy_post' => false),
            'id_country' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_state' =>            array('type' => self::TYPE_INT, 'validate' => 'isNullOrUnsignedId'),
            'alias' =>                array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 32),
            'company' =>            array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 64),
            'lastname' =>            array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
            'firstname' =>            array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
            'address1' =>            array('type' => self::TYPE_STRING, 'validate' => 'isAddress', 'required' => true, 'size' => 128),
            'address2' =>            array('type' => self::TYPE_STRING, 'validate' => 'isAddress', 'size' => 128),
            'postcode' =>            array('type' => self::TYPE_STRING, 'validate' => 'isPostCode', 'size' => 12),
            'city' =>                array('type' => self::TYPE_STRING, 'validate' => 'isCityName', 'required' => true, 'size' => 64),
            'other' =>                array('type' => self::TYPE_STRING, 'validate' => 'isMessage', 'size' => 300),
            'phone' =>                array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'size' => 32),
            'phone_mobile' =>        array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'size' => 32),
            'dni' =>                array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 16),
            'deleted' =>            array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false),
            'date_add' =>            array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
            'date_upd' =>            array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
            'latitude' => ['type' => self::TYPE_FLOAT],
            'longitude' => ['type' => self::TYPE_FLOAT]
        ),
    );

    public function __construct($id_address = null, $id_lang = null)
    {
        parent::__construct($id_address);
    
        /* Get and cache address country name */
        if ($this->id) {
            $this->country = Country::getNameById($id_lang ? $id_lang : Configuration::get('PS_LANG_DEFAULT'), $this->id_country);
            
            if( $this->id_customer ){
                $customer = new Customer($this->id_customer);
                
                if( $customer->id ){
                    $this->vat_number = $customer->siret;
                }
            }
        }
    }
    
    
    /**
     * Updates latitude, longitude fields of object, based on address fields
     * @throws Exception with error message
     */
    function updateGeoData()
    {
        $addressFields = AddressFormat::getOrderedAddressFields($this->id_country);
        $addressFormatedValues = AddressFormat::getFormattedAddressFieldsValues($this, $addressFields);
        $addressText = $addressFormatedValues['address1'] . ', '
            . $addressFormatedValues['city'] . ' '
            . (!empty($addressFormatedValues['State:name']) ? $addressFormatedValues['State:name'] . ', ' : '')
            . $addressFormatedValues['postcode'] . ', '
            . $addressFormatedValues['Country:name'];
        try{
            $data = self::geoCoordinates($addressText);
            $this->latitude = $data['lat'];
            $this->longitude = $data['lng'];
        }
        catch(Exception $e)
        {
            PrestaShopLoggerCore::addLog($e->getMessage(), 3, 0, 'Address', $this->id);
        }
    }
    
    
    /**
     * Calculates geo coordinates by given address
     * @param string $address
     * @return array ['lat'=>latitude, 'lng'=>longitude]
     * @throws Exception with error message
     */
    static function geoCoordinates($address)
    {
        $geoRequestUrl = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDKouTLt8-gQrPWn47VusoDkzuTjJX_p2M&address='. 
                urlencode($address);
        
        $geoResponseJson = Tools::file_get_contents($geoRequestUrl);
        $geoResponse = json_decode($geoResponseJson, true);
        //var_dump($geoResponse);die;
        if($geoResponse['status'] != 'OK'){
            throw new Exception('Error answer from google: '. print_r($geoResponse, true));
        }
        
        return array(
            'lat' => $geoResponse['results'][0]['geometry']['location']['lat'],
            'lng' => $geoResponse['results'][0]['geometry']['location']['lng']
        );

    }
    
    
    function add($autodate = true, $null_values = false)
    {
        if (empty($this->latitude))
        {
            $this->updateGeoData();
        }
        return parent::add($autodate, $null_values);
    }
    
    
    function update($null_values = false, $calcGeo=true)
    {
        if ($calcGeo)
        {
            $this->updateGeoData();
        }
        return parent::update($null_values);
    }
    
    
    /**
     * Cuts house number from string and returns it
     * @param $address string with street and house number
     * @returns house number or empty string if there is no house number
     */
    static function getHouseNumber($address)
    {
        if (preg_match('/\d[\d\w]*/', $address, $matches))
        {
            return $matches[0];
        }

        return '';
    }
}