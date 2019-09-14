<?php

class BurgelCall extends ObjectModel
{

    public $id;
    public $raw_data;
    public $resp_firstname;
    public $resp_lastname;
    public $resp_street;
    public $resp_house_number;
    public $resp_score;
    public $call_date;
    public $resp_city;
    public $resp_decision_text;
    public $order_id;
    public $customer_id;
    public $address_id;
    public $cache_used;
    
    protected $fieldsRequired = array('customer_id', 'address_id');
    protected $fieldsSize = array();
    protected $table = 'burgel_call';
    protected $identifier = 'id';


    public function getFields()
    {
        parent::validateFields();
        $fields = array('id' => $this->id,
            'raw_data' => $this->raw_data,
            'resp_firstname' => $this->resp_firstname,
            'resp_lastname' => $this->resp_lastname,
            'resp_street' => $this->resp_street,
            'resp_house_number' => $this->resp_house_number,
            'resp_score' => $this->resp_score,
            'call_date' => $this->call_date,
            'resp_city' => $this->resp_city,
            'resp_decision_text' => $this->resp_decision_text,
            'customer_id' => $this->customer_id,
            'address_id' => $this->address_id,
            'order_id' => $this->order_id,
            'cache_used' => $this->cache_used
        );


        return $fields;
    }

    /**
     * Reads cached score and decision text from database
     * @returns BurgelCall object or false if no cache record
     * or cache expired
     */
    static function getCachedByAddress($addressId)
    {
        $sql = 'select * from '._DB_PREFIX_.'burgel_call where address_id=' .$addressId. ' and cache_used=0 and resp_decision_text<>\'\' and '.
                'call_date>\'' . date('Y-m-d H:i:s', time() - 24 * 3600 * Configuration::get('BURGEL_CACHE_SCORE_DAYS')) . '\' order by id desc';
        
        $data = Db::getInstance()->getRow($sql);
        if ($data)
        {
            $result = new BurgelCall();
            $result->hydrate($data);
            return $result;
        }
        
        return false;
    }

    /**
     * @param $orderId
     * @returns score associated with order
     */
    static function getOrderScore($orderId)
    {
        return Db::getInstance()->getValue('select resp_score from ' . _DB_PREFIX_ . 'burgel_call where order_id=' . $orderId);
    }

    /**
     * @param $orderId
     * @returns array(score => associated with order, decisionTxt, personKnown
     * -- true or false, actualReqDate -- date of actual(not cache) request to burgel that is used), if no corresponding record returns false
     */
    static function getOrderScoreAndDecisionTxt($orderId)
    {
        $data = Db::getInstance()->getRow('select id, address_id, resp_score as score, resp_decision_text as decisionTxt, '.
                'call_date as actualReqDate, cache_used from '._DB_PREFIX_.'burgel_call where order_id=' . $orderId.' order by id desc');
        if ($data)
        {
            if (strpos($data['decisionTxt'], 'Person und Anschrift bekannt') !== false || 
                    strpos($data['decisionTxt'], 'Mehrere Personen bekannt') !== false)
            {
                $data['personKnown'] = true;
            }
            else
            {
                $data['personKnown'] = false;
            }
        }
        // reading date of actual burgel call
        if ($data['cache_used'])
        {
            $callDate = Db::getInstance()->getRow('select id, call_date from '._DB_PREFIX_.'burgel_call where address_id='.$data['address_id'].
                    ' and id<'.$data['id'].' and cache_used=0 order by id desc');
            $data['actualReqDate'] = $callDate['call_date'];
        }
        return $data;
    }

    /**
     * @param $orderId
     * @returns score associated with order
     */
    static function getCustomerScore($customerId)
    {
        return Db::getInstance()->getValue('select resp_score from ' . _DB_PREFIX_ . 'burgel_call where customer_id=' . $customerId . ' order by id desc');
    }

}
