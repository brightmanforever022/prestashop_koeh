<?php

class KoehlertWebServiceShippingLabel
{
    public function create()
    {
        $returnData = array(
            'success' => false,
            'status' => false,
            'data' => array(),
            'message' => ''
        );
        
        $orderId = null;
        $addressId = null;
        $labelsNumber = 1;
        
        if(!isset($_POST['order_id'])){
            $returnData['message'] = 'Order ID not set';
            return $returnData;
        }
        $orderId = intval($_POST['order_id']);
        
        if(!$orderId){
            $returnData['message'] = 'Order ID is invalid';
            return $returnData;
        }
        
        if(!isset($_POST['address_id'])){
            $returnData['message'] = 'Address ID not set';
            return $returnData;
        }
        $addressId = intval($_POST['address_id']);
        
        if(!$addressId){
            $returnData['message'] = 'Address ID is invalid';
            return $returnData;
        }
        
        if(isset($_POST['number']) && ( intval($_POST['number']) > 0 )){
            $labelsNumber = intval($_POST['number']);
        }
        
        $shippingLabelId = $this->add($orderId, $addressId, $labelsNumber);
        
        if( !$shippingLabelId ){
            $returnData['message'] = 'Error creating shipping label for print';
            return $returnData;
        }
        
        $returnData['success'] = true;
        $returnData['status'] = true;
        $returnData['data']['shipping_label_print_id'] = $shippingLabelId;
        return $returnData;
    }
    
    public function add($id_order, $id_address, $number = 1)
    {
        $shippingLabelPrintData = array(
            'id_order' => $id_order,
            'id_address' => $id_address,
            'number' => intval($number),
            'status' => 0,
            'date_upd' => array(
                'type' => 'sql',
                'value' => 'NOW()'
            )
        );
        
        try{
            Db::getInstance()->insert('shipping_label_print', $shippingLabelPrintData);
        }
        catch(Exception $e){
            return false;
        }
        
        return Db::getInstance()->Insert_ID();
    }
    
    public function listing($pending = true)
    {
        $returnData = array(
            'success' => false,
            'status' => false,
            'data' => array(),
            'message' => ''
        );
        
        /**
         * @var DbQueryCore $query
         */
        $query = new DbQueryCore();
        $query
            ->select('slp.id_shipping_label_print, slp.number AS print_number, id_shipping_label_print as id_order, slp.id_address,
                IF(LENGTH(a.company), a.company, c.company) AS company, a.firstname, a.lastname, c.email,
                IF(LENGTH(a.vat_number), a.vat_number, c.siret) AS vat_number, 
                IF(LENGTH(a.phone), a.phone, c.phone) AS phone, 
                IF(LENGTH(a.phone_mobile), a.phone_mobile, c.phone_mobile) AS fax, 
                c.phone_mobile_2 AS phone_mobile,
                a.address1, a.address2, a.postcode, a.city, cntr_a.name AS country_name'
            )
            ->from('shipping_label_print', 'slp')
            ->innerJoin('address', 'a', 'a.id_address = slp.id_address')
            ->innerJoin('country_lang', 'cntr_a', 'cntr_a.id_country = a.id_country AND cntr_a.id_lang = '.Configuration::get('PS_LANG_DEFAULT'))
            ->leftJoin('orders', 'o', 'o.id_order = slp.id_order')
            ->leftJoin('customer', 'c', 'c.id_customer = o.id_customer')
            ->leftJoin('country_lang', 'cntr_c', 'cntr_c.id_country = c.id_country AND cntr_c.id_lang = o.id_lang')
            
            ->where('slp.status = 0')
        ;
        
        $listing = Db::getInstance()->executeS($query);

        if( $listing === false ){
            $returnData['message'] = 'DB query error';
            return $returnData;
        }
        
        $returnData['success'] = true;
        $returnData['status'] = true;
        $returnData['data'] = $listing;
        
        return $returnData;
    }
    
    public function update($data)
    {
        $returnData = array(
            'success' => false,
            'status' => false,
            'data' => array(),
            'message' => ''
        );
        
        $shippingLabelPrintId = intval($data['id_shipping_label_print']);
        $processed = intval($data['processed']);
        
        try{
            Db::getInstance()->update('shipping_label_print', 
                array(
                    'status' => $processed, 
                    'date_upd' => array(
                        'type' => 'sql',
                        'value' => 'NOW()'
                    )
                ),
                'id_shipping_label_print = '. $shippingLabelPrintId);
        }
        catch(Exception $e){
            $returnData['message'] = 'Record not updated';
            return $returnData;
        }
        
        $returnData['success'] = true;
        $returnData['status'] = true;
        return $returnData;
    }
}
