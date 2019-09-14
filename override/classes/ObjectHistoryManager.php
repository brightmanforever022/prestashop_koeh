<?php

class ObjectHistoryManager
{
    public static function saveCustomerVat($id_object, $value, $id_employee = 0)
    {
        $objectHistory = new ObjectHistory();
        $objectHistory->class_reference = ObjectHistory::CLASS_CUSTOMER;
        $objectHistory->property_reference = ObjectHistory::PROP_CUSTOMER_VAT;
        $objectHistory->id_employee = $id_employee;
        $objectHistory->object_reference = $id_object;
        $objectHistory->value = $value;
        
        try{
            $objectHistory->add();
        }
        catch(Exception $e){
            PrestaShopLoggerCore::addLog($e->getMessage(), 3, null, 'ObjectHistory');
        }
    }
    
    public static function saveCustomerVatConfirm($id_object, $value, $id_employee = 0)
    {
        $objectHistory = new ObjectHistory();
        $objectHistory->class_reference = ObjectHistory::CLASS_CUSTOMER;
        $objectHistory->property_reference = ObjectHistory::PROP_CUSTOMER_VAT_CONF;
        $objectHistory->id_employee = $id_employee;
        $objectHistory->object_reference = $id_object;
        $objectHistory->value = $value;
    
        try{
            $objectHistory->add();
        }
        catch(Exception $e){
            PrestaShopLoggerCore::addLog($e->getMessage(), 3, null, 'ObjectHistory');
        }
    }
    
    public static function getCustomerVatHistory($id_object)
    {
        /**
         * 
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query->select('oh.*, CONCAT(e.firstname, " ", e.lastname) AS employee_name')
            ->from('object_history', 'oh')
            ->leftJoin('employee', 'e', 'e.id_employee = oh.id_employee')
            ->where('`class_reference` = '. ObjectHistory::CLASS_CUSTOMER)
            ->where('`property_reference` IN('.ObjectHistory::PROP_CUSTOMER_VAT.','.ObjectHistory::PROP_CUSTOMER_VAT_CONF.')')
            ->where('`object_reference` = '. intval($id_object))
        ;
        
        $historyList = Db::getInstance()->executeS($query);
        
        if( !is_array($historyList) ){
            return array();
        }
        
        for( $i = 0; $i < count($historyList); $i++ ){
            $historyList[$i]['value_formatted'] = $historyList[$i]['value'];
            if( $historyList[$i]['property_reference'] == ObjectHistory::PROP_CUSTOMER_VAT ){
                $historyList[$i]['field'] = 'VAT ID';
            }
            if( $historyList[$i]['property_reference'] == ObjectHistory::PROP_CUSTOMER_VAT_CONF ){
                $historyList[$i]['field'] = 'VAT confirmation';
                $historyList[$i]['value_formatted'] = ($historyList[$i]['value'] == '1' ? 'Yes' : 'No');
            }
            $historyList[$i]['date_add_formatted'] = Tools::displayDate($historyList[$i]['date_add'], null, true);
            
        }
        
        return $historyList;
    }

    public static function saveCustomerStatus($id_object, $value, $id_employee = 0)
    {
        $objectHistory = new ObjectHistory();
        $objectHistory->class_reference = ObjectHistory::CLASS_CUSTOMER;
        $objectHistory->property_reference = ObjectHistory::PROP_CUSTOMER_ACTIVE;
        $objectHistory->id_employee = $id_employee;
        $objectHistory->object_reference = $id_object;
        $objectHistory->value = $value;
        
        try{
            $objectHistory->add();
        }
        catch(Exception $e){
            PrestaShopLoggerCore::addLog($e->getMessage(), 3, null, 'ObjectHistory');
        }
    }

    public static function getCustomerStatusHistory($id_object)
    {
        /**
         *
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query->select('oh.*, CONCAT(e.firstname, " ", e.lastname) AS employee_name')
            ->from('object_history', 'oh')
            ->leftJoin('employee', 'e', 'e.id_employee = oh.id_employee')
            ->where('`class_reference` = '. ObjectHistory::CLASS_CUSTOMER)
            ->where('`property_reference` = '. ObjectHistory::PROP_CUSTOMER_ACTIVE)
        ;
        
        if( is_scalar($id_object) && intval($id_object) ){
            $query->where('`object_reference` = '. intval($id_object));
        }
        elseif( is_array($id_object) && count($id_object) ){
            $query->where('`object_reference` IN( '. implode(' , ', $id_object) .' )');
        }
        
        $historyList = Db::getInstance()->executeS($query);
        
        if( !is_array($historyList) ){
            return array();
        }
        
        for( $i = 0; $i < count($historyList); $i++ ){
            $historyList[$i]['value_formatted'] = $historyList[$i]['value'] == '0' 
                ? 'Disabled' : 'Activated';
            $historyList[$i]['date_add_formatted'] = Tools::displayDate($historyList[$i]['date_add'], null, true);
            
        }
        
        return $historyList;
    }
    
}

