<?php

class OrderDetail extends OrderDetailCore
{
    public $in_stock;
    public $shipped;
    public $shipped_employee_id;
    public $shipped_date;
    
    public $note;
    
    public $note_date;
    
    public $note_employee_id;
    
    public $note_private;
    
    public $note_private_date;
    
    public $note_private_employee_id;
    
    public static $definition = array(
        'table' => 'order_detail',
        'primary' => 'id_order_detail',
        'fields' => array(
            'id_order' =>                    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_order_invoice' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_warehouse' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_shop' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'product_id' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'product_attribute_id' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'product_name' =>                array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'product_quantity' =>            array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
            'product_quantity_in_stock' =>    array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'product_quantity_return' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'product_quantity_refunded' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'product_quantity_reinjected' =>array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'product_price' =>                array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice', 'required' => true),
            'reduction_percent' =>            array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'reduction_amount' =>            array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'reduction_amount_tax_incl' =>  array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'reduction_amount_tax_excl' =>  array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'group_reduction' =>            array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'product_quantity_discount' =>    array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'product_ean13' =>                array('type' => self::TYPE_STRING, 'validate' => 'isEan13'),
            'product_upc' =>                array('type' => self::TYPE_STRING, 'validate' => 'isUpc'),
            'product_reference' =>            array('type' => self::TYPE_STRING, 'validate' => 'isReference'),
            'product_supplier_reference' => array('type' => self::TYPE_STRING, 'validate' => 'isReference'),
            'product_weight' =>            array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'tax_name' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'tax_rate' =>                    array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'tax_computation_method' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_tax_rules_group' =>        array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'ecotax' =>                    array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'ecotax_tax_rate' =>            array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'discount_quantity_applied' =>    array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'download_hash' =>                array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'download_nb' =>                array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'download_deadline' =>            array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
            'unit_price_tax_incl' =>        array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'unit_price_tax_excl' =>        array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'total_price_tax_incl' =>        array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'total_price_tax_excl' =>        array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'total_shipping_price_tax_excl' => array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'total_shipping_price_tax_incl' => array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'purchase_supplier_price' =>    array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'original_product_price' =>    array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'original_wholesale_price' =>    array('type' => self::TYPE_FLOAT, 'validate' => 'isPrice'),
            'in_stock' => array('type' => OrderDetailCore::TYPE_INT),
            'shipped' => array('type' => OrderDetailCore::TYPE_INT),
            'shipped_employee_id' => array('type' => OrderDetailCore::TYPE_INT),
            'shipped_date' => array('type' => OrderDetailCore::TYPE_DATE),
            'note' => array('type' => self::TYPE_STRING),
            'note_date' => array('type' => self::TYPE_DATE),
            'note_employee_id' => array('type' => self::TYPE_INT),
            'note_private' => array('type' => self::TYPE_STRING),
            'note_private_date' => array('type' => self::TYPE_DATE),
            'note_private_employee_id' => array('type' => self::TYPE_INT)
        ),
    );
    
    
    public function add($autodate = true, $null_values = false, $stockChanged=true)
    {
        $product_quantity = (int)Product::getQuantity($this->product_id, (int)$this->product_attribute_id);
        if ($stockChanged)
        {
            // ordered quantity already subtracted
            $this->in_stock = $product_quantity< 0 ?0:1;
        }
        else
        {
            // ordered quantity is not subtracted yet
            $this->in_stock = $product_quantity > 0? 1:0;
        }
        
        return parent::add($autodate, $null_values);
    }
    
    
    /**
     * Increases number of shipped products on 1
     * @param type $id
     */
    function increaseShippedQty($employeeId)
    {
        if ($this->shipped < $this->product_quantity - $this->product_quantity_refunded - $this->product_quantity_return)
        {
            $this->shipped++;
        }
        $this->shipped_employee_id = $employeeId;
        $this->shipped_date = date('Y-m-d H:i:s');
        $this->update();
        
        $this->reportShippedNumChanged();
    }
    
    
    /**
     * Decreases shipped number on given quantity, records who changed it and sends notification to central store
     * @param type $employeeId
     * @param type $quantity
     */
    function decreaseShippedQty($employeeId, $quantity)
    {
        $this->shipped -= $quantity;
        if ($this->shipped<0)
        {
            $this->shipped = 0;
        }
        
        $this->shipped_employee_id = $employeeId;
        $this->shipped_date = date('Y-m-d H:i:s');
        $this->update();
        
        $this->reportShippedNumChanged();
    }
    
    
    /**
     * Reports that shipped number was changed to central server by calling msss module
     */
    function reportShippedNumChanged()
    {
        $msss_client = ModuleCore::getInstanceByName('msss_client');
        $msss_client->scheduleStockUpdateById($this->product_id, $this->product_attribute_id,
                        0, $this->id_order);
        $msss_client->sendMessagesToServerParallel();
    }
    
    
    /**
     * Saves current object to database (add or update)
     *
     * @param bool $null_values
     * @param bool $auto_date
     * @param bool $stockChanged if true it means stock quantity of product was changed before this method call
     *
     * @return bool Insertion result
     * @throws PrestaShopException
     */
    public function save($null_values = false, $auto_date = true, $stockChanged=true)
    {
        return (int)$this->id > 0 ? $this->update($null_values) : $this->add($auto_date, $null_values, $stockChanged);
    }
}

/**
ALTER TABLE `prs_order_detail` ADD `note_private` TEXT NOT NULL AFTER `note`;

 */