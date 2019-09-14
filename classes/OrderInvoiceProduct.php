<?php

// Wheelronix Ltd. development team
// site: http://www.wheelronix.com
// mail: info@wheelronix.com

class OrderInvoiceProduct extends ObjectModel
{
    public $order_invoice_id;
    public $order_detail_id;
    public $shipped_qty_in_invoice;
    
    public static $definition = array(
        'table' => 'order_invoice_product',
        'primary' => 'id',
        'fields' => array(
            'order_invoice_id' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'order_detail_id' =>         array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'shipped_qty_in_invoice' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            )
        );
    
    public static function deleteInvoiceProducts($invoiceId)
    {
        Db::getInstance()->execute('delete from '._DB_PREFIX_.'order_invoice_product where order_invoice_id='.$invoiceId);
    }
}
