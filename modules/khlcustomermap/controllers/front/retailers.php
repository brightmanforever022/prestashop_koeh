<?php

class KhlcustomermapRetailersModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        
        $this->context->controller->addCss(_MODULE_DIR_.'khlcustomermap/views/css/retailers.css');
        $this->context->controller->addJS(_MODULE_DIR_.'khlcustomermap/views/js/retailers.js');
        
        switch( Tools::getValue('action', null) ){
            case 'search':
                $this->processSearch();
                break;
            default:
                $this->processIndex();
                break;
        }
    }

    public function processIndex()
    {
        $countriesOptions = array( '0' => $this->module->l('Select your country') );
        foreach( Country::getCountries($this->context->language->id, true, false, false) as $country ){
            $countriesOptions[ $country['id_country'] ] = $country['name'];
        }
        
        $userIP = $_SERVER['REMOTE_ADDR'];
        $userIPDecimal = ip2long($userIP);

        $userIpCountry = Db::getInstance()->getRow('
            SELECT * FROM '. _DB_PREFIX_ .'ip2loc_country
            WHERE ip_from <= '. $userIPDecimal .' AND ip_to >= '. $userIPDecimal .' 
        ');
        
        $countryDefaultId = Configuration::get('PS_COUNTRY_DEFAULT');
        $userCountry = null;
        if( is_array($userIpCountry) ){
            $userCountryId = Country::getByIso( $userIpCountry['country_code'] );
            $userCountry = new Country($userCountryId);
        }

        $this->context->smarty->assign(array(
            'hide_left_column' => true,
            'countries_options' => $countriesOptions,
            'google_maps_api_key' => Configuration::get('KHLCSTMAP_GGL_MAP_API_KEY'),
            'controller_url' => $this->context->link->getModuleLink('khlcustomermap','retailers'),
            'markers_dir_url' => $this->module->getPath() . 'images/',
            'user_country_id' => (!is_null($userCountry) ? $userCountry->id : $countryDefaultId)
        ));
        $this->setTemplate('retailers/index.tpl');
    }
    
    public function processSearch()
    {
        $responseData = array(
            'success' => true,
            'data' => array()
        );
        
        $area = Tools::getValue('area');
        $area = preg_replace('#[^\w\s\-]#i', '', $area);
        $countryId = (int)Tools::getValue('id_country');

        if( empty($area) || (strlen($area) < 2) || !$countryId ){
            $responseData['success'] = false;
            $responseData['message'] = $this->module->l('Invalid parameters');
            $this->ajaxDie(Tools::jsonEncode($responseData));
        }
        
        /**
         * 
         * @var CountryCore $country
         */
        $country = new Country($countryId, $this->context->language->id);
        
        /*
        $postcodeRegex = '#'. str_replace(array('N','L'), array('\d', '\w'), $country->zip_code_format) .'#';
        $dbQuery = new DbQuery();
        $dbQuery
            ->select('c.id_customer, c.company, c.latitude, c.longitude, ordt6.orders_total AS orders_total_6,
                c.id_country, c.address1, c.address2, c.postcode, c.city
            ')
            ->from('customer', 'c')
            ->join('LEFT JOIN(
                SELECT id_customer, SUM(`total_paid_tax_excl` / `conversion_rate`) AS orders_total
                FROM `'._DB_PREFIX_.'orders`
                WHERE `valid` = 1
                    AND date_add > DATE_SUB(NOW(), INTERVAL 6 MONTH)
                GROUP BY id_customer
                ) ordt6 ON ordt6.id_customer = c.id_customer
            ')
            ->where('( c.`latitude` BETWEEN -180 AND 180 AND c.`longitude` BETWEEN -180 AND 180)')
            ->where('c.active = 1')
            ->where('( !ISNULL(ordt6.orders_total) AND ordt6.orders_total > 0 )')
            ->where('c.id_country = '. $country->id)
            ->limit(2)
        ;

        if( preg_match($postcodeRegex, $area) ){
            $postcodeLength = strlen($area);
            $postcodeSearch = str_pad(substr($area, 0, 3), $postcodeLength, '_');
            $dbQuery->where('TRIM(c.postcode) LIKE "'.$postcodeSearch.'"');
            $responseData['zip'] = $postcodeSearch;
        }
        else{
            $dbQuery->where('TRIM(c.city) LIKE "'.$area.'"');
            
        }
        $dbQuery->limit(2);
        
        $retailers = Db::getInstance()->executeS($dbQuery);
        */
        
        //if( !count($retailers) ){
        /////////////
        $startAddress = $area .', '. $country->name;
        $google_maps_api_key = Configuration::get('KHLCSTMAP_GGL_MAP_API_KEY');
        $geoRequestUrl = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$google_maps_api_key.'&address='. urlencode($startAddress);
        
        $geoResponseJson = Tools::file_get_contents($geoRequestUrl);
        $geoResponse = json_decode($geoResponseJson, true);
        //echo $geoResponseJson;
        if($geoResponse['status'] != 'OK'){
            $responseData['success'] = false;
            $responseData['message'] = $this->module->l('Your address incomplete, please enter a more accurate address');
            $this->ajaxDie(Tools::jsonEncode($responseData));
        }
        $startLatitude = $geoResponse['results'][0]['geometry']['location']['lat'];
        $startLongitude = $geoResponse['results'][0]['geometry']['location']['lng'];
        
        /**
         * @var DbQueryCore $dbQuery
         */
        $dbQuery = new DbQuery();
        $dbQuery
            ->select('c.id_customer, c.company, c.latitude, c.longitude, ordt6.orders_total AS orders_total_6,
                c.id_country, c.address1, c.address2, c.postcode, c.city,
                (6371*(ACOS(SIN(RADIANS(`c`.`latitude`))*SIN(RADIANS('. $startLatitude .'))
                +COS(RADIANS(`c`.`latitude`))*COS(RADIANS('. $startLatitude .'))
                *COS(RADIANS(`c`.`longitude` - '. $startLongitude .'))))) AS distance
            ')
            ->from('customer', 'c')
            ->join('LEFT JOIN(
                SELECT id_customer, SUM(`total_paid_tax_excl` / `conversion_rate`) AS orders_total
                FROM `'._DB_PREFIX_.'orders`
                WHERE `valid` = 1
                    AND date_add > DATE_SUB(NOW(), INTERVAL 6 MONTH)
                GROUP BY id_customer
                ) ordt6 ON ordt6.id_customer = c.id_customer'
            )
            ->where('( c.`latitude` BETWEEN -180 AND 180 AND c.`longitude` BETWEEN -180 AND 180)')
            ->where('c.active = 1')
            ->where('( !ISNULL(ordt6.orders_total) AND ordt6.orders_total > 0 )')
            ->where('c.id_country = '. $country->id)
            ->orderBy('distance')
            ->limit(2)
        ;
        $responseData['start'] = $geoResponse['results'][0];
        //}
        
        
        $retailers = Db::getInstance()->executeS($dbQuery);
        
        foreach($retailers as &$retailer){
            $retailer['latitude'] = floatval($retailer['latitude']);
            $retailer['longitude'] = floatval($retailer['longitude']);
            unset($retailer['orders_total_6']);
            unset($retailer['order_date_recent']);
        }
        unset($retailer);
        
        $responseData['data'] = $retailers;
        
        
        $this->ajaxDie(Tools::jsonEncode($responseData));
    }
}