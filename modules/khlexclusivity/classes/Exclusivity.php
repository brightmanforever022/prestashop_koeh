<?php

class Exclusivity extends ObjectModel
{
    public $id;
    
    public $id_customer;
    
    public $date_start;
    
    public $date_end;
    
    public $status;
    
    public $radius;
    
    public $amount;
    
    protected $customer;
    
    const PERIOD_MONTHES = 12;
    
    public static $definition = array(
        'table' => 'exclusivity',
        'primary' => 'id_exclusivity',
        'fields' => array(
            'id_customer' => array(
                'type' => self::TYPE_INT, 
                'required' => true, 
            ),
            'date_start' => array(
                'type' => self::TYPE_DATE, 
                'validate' => 'isDate'
            ),
            'date_end' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),
            'status' => array(
                'type' => self::TYPE_INT,
                'required' => true,
            ),
            'radius' => array(
                'type' => self::TYPE_INT,
                'required' => true,
            ),
            'amount' => array(
                'type' => self::TYPE_INT,
                'required' => true,
            ),
            
        ),
    );
    
    public function getCustomer()
    {
        if( empty($this->customer) ){
            $this->customer = new Customer($this->id_customer);
        }
        return $this->customer;
    }
    
    public function areRequirementsSatisfied()
    {
        $itemsPerMonth = $this->amount / self::PERIOD_MONTHES;
        
        $dateStartObj = new DateTime( $this->date_start );
        $dateEndObj = new DateTime( $this->date_end );
        $dateNowObj = new DateTime();
        
        if( $dateEndObj < $dateNowObj ){
            $datesDiff = $dateEndObj->diff($dateStartObj, true);
        }
        else{
            $datesDiff = $dateNowObj->diff($dateStartObj, true);
        }
        
        if( ($datesDiff->y == 0) && ($datesDiff->m == 0) ){
            // no period to check
            return true;
        }
        
        $itemsRequiredToDate = ( ($datesDiff->y * 12) + $datesDiff->m ) * $itemsPerMonth;
        $customerTotalOrdered = $this->getAmountOrdered();
        
        if( $itemsRequiredToDate <= $customerTotalOrdered ){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function getAmountShouldBeOrdered()
    {
        $itemsPerMonth = $this->amount / self::PERIOD_MONTHES;
        
        $dateStartObj = new DateTime( $this->date_start );
        $dateEndObj = new DateTime( $this->date_end );
        $dateNowObj = new DateTime();
        
        if( $dateEndObj < $dateNowObj ){
            $datesDiff = $dateEndObj->diff($dateStartObj, true);
        }
        else{
            $datesDiff = $dateNowObj->diff($dateStartObj, true);
        }
        
        $itemsRequiredToDate = ( ($datesDiff->y * 12) + $datesDiff->m ) * $itemsPerMonth;
        
        return $itemsRequiredToDate;
    }
    
    public function getCustomerOrders()
    {
        $dateStartObj = new DateTime( $this->date_start );
        $dateEndObj = new DateTime( $this->date_end );
        $dateNowObj = new DateTime();
        
        $datesDiff = $dateNowObj->diff($dateStartObj, true);
        
        /**
         *
         * @var DbQueryCore $customerOrdersQuery
         */
        $customerOrdersQuery = new DbQuery();
        $customerOrdersQuery
            ->select('id_order')
            ->from('orders')
            ->where('id_customer = '. $this->id_customer)
            ->where('date_add >= '. $dateStartObj->format('Ymd') )
            ->where('date_add <= '. $dateEndObj->format('Ymd') )
            ->where('current_state != '. _PS_OS_CANCELED_ )
        ;
        
        $customerOrdersId = Db::getInstance()->executeS($customerOrdersQuery);
        $customerOrders = array();
        
        foreach($customerOrdersId as $orderId){
            $customerOrders[] = new Order($orderId['id_order']);
        }
        
        return $customerOrders;
    }
    
    /**
     * 
     * @return boolean|number
     */
    public function getAmountOrdered()
    {
        $itemsPerMonth = $this->amount / self::PERIOD_MONTHES;
        
        //$dateStartPrimitive = strtotime($this->date_start);
        //$dateNowPrimitive = time();
        $dateStartObj = new DateTime( $this->date_start );
        $dateEndObj = new DateTime( $this->date_end );
        $dateNowObj = new DateTime();
        
        $datesDiff = $dateNowObj->diff($dateStartObj, true);
        
        if($datesDiff->m == 0){
            // no period to check
            return true;
        }
        
        $itemsRequiredToDate = $datesDiff->m * $itemsPerMonth;
        
        $customerTotalOrdered = 0;
        
        foreach ($this->getCustomerOrders() as $customerOrder){
            foreach($customerOrder->getOrderDetailList() as $orderDetail){
                $customerTotalOrdered =
                $customerTotalOrdered
                    + intval($orderDetail['product_quantity'])
                    - intval($orderDetail['product_quantity_refunded'])
                    - intval($orderDetail['product_quantity_return'])
                ;
            }
        }
        
        return $customerTotalOrdered;
    }
}