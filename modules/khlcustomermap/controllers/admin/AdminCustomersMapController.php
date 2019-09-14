<?php

class AdminCustomersMapController extends ModuleAdminController
{
    /**
     * 
     * @var Khlcustomermap
     */
    public $module;
    
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function initContent()
    {
        parent::initContent();
        //var_dump($this->action, $this->display);
        if( empty(Tools::getValue('action')) ){
            $this->content .= $this->renderView();
            
            $this->context->smarty->assign(array(
                'content' => $this->content,
                'url_post' => self::$currentIndex.'&token='.$this->token,
                'google_maps_api_key' => Configuration::get('KHLBSC_GGL_MAP_API_KEY')
                //'show_page_header_toolbar' => $this->show_page_header_toolbar,
                //'page_header_toolbar_title' => $this->page_header_toolbar_title,
                //'page_header_toolbar_btn' => $this->page_header_toolbar_btn
            ));
        }
    }
    
    public function renderView()
    {
        $this->addJS( $this->module->getPath() .'customers_map.js');

        $searchFormOptions = array(
            'status' => array(
                null => $this->l('Any status'),
                '0' => $this->l('Show only disabled'),
                '1' => $this->l('Show only active')
            ),
            'not_order_for_latest' => array(
                //null => $this->l('All order dates'),
                '3' => $this->l('Not ordered in the 3 monthes'),
                '6' => $this->l('Not ordered in the 6 monthes'),
                '12' => $this->l('Not ordered in the 12 or more monthes'),
            ),
            'id_country' => array(
                null => 'All countries'
            )
        );
        
        foreach( Country::getCountries($this->context->employee->id_lang, true, false, false) as $country ){
            $searchFormOptions['id_country'][ $country['id_country'] ] = $country['name'];
        }

        $this->context->smarty->assign(array(
            'customers_map_controller_url' => self::$currentIndex.'&token='.$this->token,
            'markercluster_js_url' => $this->module->getPath() . '/markerclusterer.js',
            'markers_dir_url' => $this->module->getPath() . 'images/',
            'google_maps_api_key' => Configuration::get('KHLCSTMAP_GGL_MAP_API_KEY'),
            'customers_no_geodata_count' => count($this->getCustomersNoGeodata()),
            'customers_invalid_geodata_list' => $this->getCustomersInvalidGeodata(),
            'search_form_element_options' => $searchFormOptions
        ));
        
        return parent::renderView();
    }
    
    public function ajaxProcessGetCustomers()
    {
        $responseData = array(
            'success' => true,
            'data' => array()
        );
        /**
         * 
         * @var DbQueryCore $dbQuery
         */
        $dbQuery = new DbQuery();
        $dbQuery
            ->select('c.id_customer, c.active, c.company, c.firstname, c.lastname, c.latitude, c.longitude,  
                ordt.orders_total, ordt12.orders_total AS orders_total_12, ordt6.orders_total AS orders_total_6,
                IF( ISNULL(cgk.id_group) , 0, cgk.id_group ) AS customer_group_key_account,
                (SELECT MAX(date_add) FROM `'._DB_PREFIX_.'orders` WHERE id_customer = c.id_customer) AS order_date_recent
            ')
            ->from('customer', 'c')
            ->join('LEFT JOIN(
                SELECT id_customer, SUM(`total_paid_tax_excl` / `conversion_rate`) AS orders_total
                FROM `'._DB_PREFIX_.'orders`
                WHERE `valid` = 1
                GROUP BY id_customer 
            ) ordt ON ordt.id_customer = c.id_customer')
            ->join('LEFT JOIN(
                SELECT id_customer, SUM(`total_paid_tax_excl` / `conversion_rate`) AS orders_total
                FROM `'._DB_PREFIX_.'orders`
                WHERE `valid` = 1
                    AND date_add > DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY id_customer
            ) ordt12 ON ordt12.id_customer = c.id_customer')
            ->join('LEFT JOIN(
                SELECT id_customer, SUM(`total_paid_tax_excl` / `conversion_rate`) AS orders_total
                FROM `'._DB_PREFIX_.'orders`
                WHERE `valid` = 1
                    AND date_add > DATE_SUB(NOW(), INTERVAL 6 MONTH)
                GROUP BY id_customer
            ) ordt6 ON ordt6.id_customer = c.id_customer')
            ->join(' LEFT JOIN `'._DB_PREFIX_.'customer_group` cgk
                ON cgk.id_customer = c.id_customer AND cgk.id_group = '. CUSTOMER_GROUP_KEY_ACC)
            ->where('( c.`latitude` BETWEEN -180 AND 180 AND c.`longitude` BETWEEN -180 AND 180)')
        ;
        
        if( isset($_POST['status']) ){
            $dbQuery->where('c.active = '. intval($_POST['status']));
        }
        if( isset($_POST['id_country']) ){
            $dbQuery->where('c.id_country = '. intval($_POST['id_country']));
        }
        if( isset($_POST['postcode_start']) ){
            $dbQuery->where('c.postcode LIKE "'. pSQL($_POST['postcode_start']) .'%"');
        }
        if( isset($_POST['no_order_for_latest']) ){
            $noOrderForLatestPeriods = $_POST['no_order_for_latest'];
            $_havingPeriodsArr = array();
            foreach( $noOrderForLatestPeriods as $noOrderPeriod ){
                //$_having .= ' ';
                if( $noOrderPeriod == '3' ){
                    $_havingPeriodsArr[] = ' order_date_recent < DATE_SUB(NOW(), INTERVAL 3 MONTH) ';
                }
                elseif( $noOrderPeriod == '6' ){
                    $_havingPeriodsArr[] = ' order_date_recent < DATE_SUB(NOW(), INTERVAL 6 MONTH) ';
                }
                elseif( $noOrderPeriod == '12' ){
                    $_havingPeriodsArr[] = ' order_date_recent < DATE_SUB(NOW(), INTERVAL 12 MONTH) ';
                }
            }
            if( count($_havingPeriodsArr) ){
                $_having = ' OR ( '. implode(' OR ', $_havingPeriodsArr) .' ) ';
                $dbQuery->having('ISNULL(order_date_recent) '. $_having);
                
            }
        }
        $dbQuery;
 
        $customers = Db::getInstance()->executeS($dbQuery);
        for($i = 0; $i < count($customers); $i++){
            $customers[$i]['latitude'] = floatval($customers[$i]['latitude']);
            $customers[$i]['longitude'] = floatval($customers[$i]['longitude']);
            $customers[$i]['active'] = boolval( intval($customers[$i]['active']) );
            $customers[$i]['customer_group_key_account'] = intval($customers[$i]['customer_group_key_account']);
            
            $customers[$i]['order_recent_seconds'] = null;
            if( !is_null($customers[$i]['order_date_recent']) ){
                $customers[$i]['order_recent_seconds'] = strtotime($customers[$i]['order_date_recent']);
                $customers[$i]['order_recent_date_formatted'] = date($this->context->language->date_format_lite, $customers[$i]['order_recent_seconds']);
            }
            
            if( !is_null($customers[$i]['orders_total']) ){
                $customers[$i]['orders_total'] = floatval($customers[$i]['orders_total']);
                $customers[$i]['orders_total_formatted'] = Tools::displayPrice($customers[$i]['orders_total']);
            }
            if( !is_null($customers[$i]['orders_total_12']) ){
                $customers[$i]['orders_total_12'] = floatval($customers[$i]['orders_total_12']);
                $customers[$i]['orders_total_12_formatted'] = Tools::displayPrice($customers[$i]['orders_total_12']);
            }
            if( !is_null($customers[$i]['orders_total_6']) ){
                $customers[$i]['orders_total_6'] = floatval($customers[$i]['orders_total_6']);
                $customers[$i]['orders_total_6_formatted'] = Tools::displayPrice($customers[$i]['orders_total_6']);
            }
            
        }
        $responseData['data'] = $customers;
        
        echo json_encode($responseData);
    }
    
    public function ajaxProcessGeocodeCustomers()
    {
        set_time_limit(600);
        $responseData = array(
            'success' => true,
            'message' => '',
            'data' => array(
                'geocode_success' => 0,
                'geocode_fail' => 0,
                'customers_no_geodata_count' => 0
            )
        );
        $limit = (int)Tools::getValue('limit');
        
        $customersList = $this->getCustomersNoGeodata($limit);

        foreach( $customersList as $customerData ){
            $customer = new Customer($customerData['id_customer']);
            $customerAddressString = $this->module->extractCustomerAddress($customer);
            
            try{
                $customerGeodata = $this->module->geocodeAddress($customerAddressString);
            }
            catch( Exception $e ){
                $responseData['data']['geocode_fail']++;
                $responseData['message'] .= $e->getMessage() .' ; ';
                //continue;
                $customerGeodata = array(
                    'latitude' => 1000, 'longitude' => 1000
                );
            }
            
            $customer->latitude = $customerGeodata['latitude'];
            $customer->longitude = $customerGeodata['longitude'];
            
            try{
                $customer->update();
            }
            catch( Exception $e ){
                $responseData['data']['geocode_fail']++;
                continue;
            }
            
            $responseData['data']['geocode_success']++;
        }
        
        $responseData['data']['customers_no_geodata_count'] = count($this->getCustomersNoGeodata());
        
        echo json_encode($responseData);
    }

    public function setMedia()
    {
        parent::setMedia();
        $this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.js');
        $this->context->controller->addCss(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.css');
        
    }
    
    protected function getCustomersNoGeodata($limit = null)
    {
        $query = '
            SELECT *
            FROM `'._DB_PREFIX_.'customer`
            WHERE `deleted` = 0 AND ( ISNULL(`latitude`) OR ISNULL(`longitude`) )
        ';
        
        if(!is_null($limit)){
            $query .= ' LIMIT '. intval($limit);
        }
        
        return Db::getInstance()->executeS($query);
        
    }
    
    protected function getCustomersInvalidGeodata()
    {
        $query = '
            SELECT id_customer
            FROM `'._DB_PREFIX_.'customer`
            WHERE `deleted` = 0 
                AND ( (`latitude` NOT BETWEEN -180 AND 180) AND (`longitude` NOT BETWEEN -180 AND 180))
        ';
        
        return Db::getInstance()->executeS($query);
        
    }
    
}

