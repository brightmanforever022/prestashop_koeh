<?php

/**
 * Class is purposed to work with db table there scheduled stock updates are stored
 */
class MSSSClientStockUpdater
{
    // statuses of messages
    const StatusNew= 0;
    const StatusInProcess = 1;
    const StatusError = 2;
    const TableName = 'ss_notification_slave';
    const StockClearanceNoChange = -1;
    
    var $pid;
    
    /**
     * Schedules stock update for send to server
     * @param type $sku sku of updated product
     * @param type $delta quantity change
     */
    static function scheduleClearanceModeChange($sku, $clearance)
    {
        // insert new record
        if (!empty($sku))
        {
            Db::getInstance()->execute('insert into '.self::TableName.'(sku, change_qty, order_id, status, stock_clearance) '.
                   'values(\''.addslashes($sku).'\',0,0,'.self::StatusNew.', '.$clearance.')');
        }
    }
    
    /**
     * Schedules stock update for send to server
     * @param type $sku sku of updated product
     * @param type $delta quantity change
     */
    static function scheduleStockUpdate($sku, $delta, $orderId)
    {
        // insert new record
        $delta = intval($delta);
        if (!empty($sku))
        {
            Db::getInstance()->execute('insert into '.self::TableName.'(sku, change_qty, order_id, status, stock_clearance) '.
                   'values(\''.addslashes($sku).'\','.$delta.','.$orderId.','.self::StatusNew.', '.self::StockClearanceNoChange.')');
        }
    }
    
    
    /**
     * Schedules stock update for send to server. Difference from scheduleStockUpdate is that update is created by ids, not by sku
     * @param int $productId
     * @param int $attributeId
     * @param int $delta
     * @param $notShippedQty
     */
    static function scheduleStockUpdateById($productId, $attributeId, $delta, $orderId)
    {
        // reading sku
        $sku = ProductSupplier::getProductSupplierReference($productId, $attributeId);
        self::scheduleStockUpdate($sku, $delta, $orderId);
    }
    
    
    /**
     * @returns array with messages that need to be sent
     */
    function getMessagesToSend()
    {
        // mark messages in process 
        $this->pid = substr(str_replace('.', '', strval(microtime(true))), -9);
        Db::getInstance()->execute('update '.self::TableName.' set status='.self::StatusInProcess.', pid='.$this->pid.' where status in ('.
                self::StatusNew.', '.self::StatusError.') and pid=0');
        // read not unique skus
        $skus = Db::getInstance()->executeS('select distinct ps1.product_supplier_reference, greatest(ps1.id_product, ps2.id_product)'
                .' as product_id, if(ps1.id_product>ps2.id_product, ps1.id_product_attribute, ps2.id_product_attribute) as combination_id '.
                'from '._DB_PREFIX_.'product_supplier ps1 inner join '._DB_PREFIX_.'product_supplier ps2 on 
                ps1.product_supplier_reference=ps2.product_supplier_reference and ps1.id_product_supplier<>ps2.id_product_supplier');
        
        $notUniqueSkus = [];
        foreach($skus as $sku)
        {
            $notUniqueSkus []= $sku['product_supplier_reference'];
        }
        
        if (count($notUniqueSkus))
        {
            $lastWarningSendTime = Configuration::get('MSSS_NOT_UNIQUE_SKU_WARNING_SEND_TIME');
            if (empty($lastWarningSendTime) || $lastWarningSendTime<time()-3600)
            {
                MSSSLog::reportError('errors during notification from client '._PS_BASE_URL_.' send', 
                    'Following products have not unique skus in '._PS_BASE_URL_.
                    ' db and will not be sent and updated in server'.
                    "\n".'To fix error you need to make all skus unique.'.
                    "\n".print_r($skus, true)."\n".'');
                Configuration::updateValue('MSSS_NOT_UNIQUE_SKU_WARNING_SEND_TIME', time());
            }
        }
            
        // read all that need to be sent and resent
        $messages = Db::getInstance()->executeS('select b.change, a.sku, a.order_id, a.stock_clearance, c.company as customer_company, '.
                'if(od.id_order_detail is null or o.current_state='.Configuration::get('PS_OS_CANCELED').', 0, (product_quantity - product_quantity_refunded - product_quantity_return - shipped)) '.
                'as not_shipped_qty, '.
                'osl.name as order_status, o.date_add as order_date from '.self::TableName.' a inner join '.
                '(select sum(change_qty) as `change`, max(id) as last_id from '.self::TableName.' where status ='.
                self::StatusInProcess.' and pid='.$this->pid.(count($notUniqueSkus)?' and sku not in (\''.implode('\',\'', $notUniqueSkus).
                        '\')':'').' group by sku, order_id) b on a.id=b.last_id '.
                'left join '._DB_PREFIX_.'orders o on o.id_order=a.order_id '.
                'left join '._DB_PREFIX_.'order_detail od on od.id_order=a.order_id and od.product_supplier_reference=a.sku '.
                'left join '._DB_PREFIX_.'customer c on o.id_customer=c.id_customer '.
                'left join '._DB_PREFIX_.'order_state_lang osl on o.current_state=osl.id_order_state and osl.id_lang=o.id_lang');
        
        return $messages;
    }
    
    
    /**
     * Marks all messages read in previous getUpdatesList call , that has specified destination, successfully processed
     */
    function markMessagesProcessed()
    {
        Db::getInstance()->execute('delete from '.self::TableName.' where pid='.$this->pid);
    }
    
    
    /**
     * Marks all messages read in previous getUpdatesList call processed with error
     */
    function markMessagesProcessedWithError()
    {
        Db::getInstance()->execute('update '.self::TableName.' set status='.self::StatusError.' where pid='.$this->pid);
    }
    
    
    /**
     * Updates stock of products in this shop
     * @param type $messages array of [sku=> sku of updating product, qty=>new quantity
     * @returns string with errors, if they occurred, empty string if all ok
     */
    static function updateStockBySku($messages)
    {
        $errors = '';
        foreach ($messages as $message)
        {
            // search for product by sku
            $psIds = Db::getInstance()->getRow('select ps.id_product_attribute, ps.id_product from ' . _DB_PREFIX_ . 'product_supplier ps'
                    . ' where ps.product_supplier_reference=\'' . addslashes($message['sku']) .'\'');
            if ($psIds)
            {
                if (isset($message['stock_clearance']) && $message['stock_clearance']!=self::StockClearanceNoChange)
                {
                    // update clearance status
                    $product = new Product($psIds['id_product']);
                    $product->changeClearanceStatus($message['stock_clearance'], false);
                }
                else
                {
                    // product found, update it
                    StockAvailable::setQuantityBoth($psIds['id_product'], $psIds['id_product_attribute'], $message['qty'], $message['phys_qty']);
                }
            }
            else
            {
                $errors .= "\n" . 'Product with sku "' . $message['sku'] . '" not found';
            }
        }
        
        if (!empty($errors))
        {
            $errors = "Following products were not found in local ("._PS_BASE_URL_.") db and were not updated. \n".
            "To fix error you need to either create products in "._PS_BASE_URL_." or disable synchronization with ".
            _PS_BASE_URL_." in vipdress stock management page.\n".
            $errors;
        }
        return $errors;
    }
    
    
    /**
     * Starts not blocking message sending to server (in papallel), process will continue work after script exit
     */
    static function sendMessagesToServerParallel()
    {
        exec('cd '._PS_MODULE_DIR_.'msss_client/; php send_messages.php >/dev/null 2>&1 &');
    }
}
