<?php

class CustomerMainToExcl extends ObjectModelCore
{
    const EXCLUSIVE_PERIOD_DAYS = 180;
    
    public $id_bunch;
    
    public $id_excluded;
    
    public static $definition = array(
        'table' => 'customer_main_to_excl',
        'primary' => 'id_customer_main_to_excl',
        'fields' => array(
            'id_bunch' => array(
                'type' => self::TYPE_INT,
                'required' => true,
            ),
            'id_excluded' => array(
                'type' => self::TYPE_INT,
                'required' => true,
            ),
        )
    );

    /**
     * Checks if given customer can order product based on dominant / slave customer feature.
     * @param int $id_customer
     * @param int $id_product
     * @param int $id_product_attribute
     * @return array
     */
    public static function getCustomerAbleToBuyProduct($id_customer, $id_product, $id_product_attribute = null)
    {
        $returnData = array(
            'allowed' => true,
            'data' => array(
                'dominants' => array()
            )
        );
        
        $customerExcludedBunch = Db::getInstance()->getRow('
            SELECT *
            FROM `'._DB_PREFIX_.'customer_main_to_excl`
            WHERE id_excluded = '. intval($id_customer) .'
        ');
        
        if( !is_array($customerExcludedBunch) || !count($customerExcludedBunch) ){
            $returnData['allowed'] = true;
            return $returnData;
        }
        

        $product = new Product($id_product);
        if( !Validate::isLoadedObject($product) ){
            $returnData['allowed'] = true;
            return $returnData;
        }
        
        $productSupplierRefParts = array();
        if( !preg_match(KOEHLERT_SPL_REF_NOSIZE_REGEX, $product->supplier_reference, $productSupplierRefParts) ){
            $returnData['allowed'] = true;
            return $returnData;
        }
        
        $orderInvalidStates = array(
            Configuration::get('PS_OS_CANCELED'), Configuration::get('PS_OS_ERROR'),
        );

        /**
         * @var DbQueryCore $dominantBoughtProductQuery
         */
        $dominantBoughtProductQuery = new DbQuery();
        $dominantBoughtProductQuery
            ->select('o.id_order, o.date_add, od.product_supplier_reference, o.id_customer')
            ->from('order_detail', 'od')
            ->innerJoin('orders', 'o', 'o.id_order = od.id_order')
            ->innerJoin('customer_main_to_excl', 'cm2e', 'cm2e.id_excluded = o.id_customer')
            ->where('od.product_supplier_reference LIKE "'. pSQL($product->supplier_reference) .'%"')
            ->where('o.date_add > DATE_SUB(NOW(), INTERVAL '. self::EXCLUSIVE_PERIOD_DAYS .' DAY)')
            ->where('o.current_state NOT IN('. implode(',', $orderInvalidStates) .')')
            ->where('od.product_quantity > (od.product_quantity_return - od.product_quantity_refunded - od.product_quantity_reinjected)')
            ->where('cm2e.id_bunch = '. intval($customerExcludedBunch['id_bunch']))
            ->where('cm2e.id_excluded != '. $id_customer)
        ;
        
        $productBoughtByBunch = Db::getInstance()->executeS($dominantBoughtProductQuery);
        
        if( !is_array($productBoughtByBunch) || !count($productBoughtByBunch) ){
            $returnData['allowed'] = true;
            return $returnData;
        }
        
        $returnData['allowed'] = false;
        $returnData['data']['product'] = $product;
        $returnData['data']['dominants'] = array();
        
        foreach($productBoughtByBunch as $productBoughtByNeigbour){
            $neighbourCustomer = new Customer($productBoughtByNeigbour['id_customer']);
            $returnData['data']['dominants'][] = array(
                'customer' => $neighbourCustomer,
                'order' => $productBoughtByNeigbour
            );
            
        }
        
        return $returnData;
    }
    
    
    
}

