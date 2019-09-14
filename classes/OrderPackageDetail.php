<?php

/**
 * 
 * @author vitaliy
 * Used for order packages 
 */
class OrderPackageDetail extends ObjectModel
{
    public $id_order_package;
    
    public $id_order_detail;
    
    public static $definition = array(
        'table' => 'order_package_detail',
        'primary' => 'id_order_package_detail',
        'fields' => array(
            'id_order_package' => array('type' => self::TYPE_INT, 'required' => true, 'copy_post' => false),
            'id_order_detail' => array('type' => self::TYPE_INT, 'required' => true),
        ),
    );
    
    protected $webserviceParameters = array(
        'objectsNodeName' => 'order_package_details',
        'fields' => array(
            'id_order_package' => array('xlink_resource'=> 'order_packages'),
            'id_order_detail' => array('xlink_resource'=> 'order_details'),
        ),
        //'objectMethods' => array('add' => 'addWs'),
    );
 
    
    function add($auto_date = true, $null_values = false)
    {
        $result = parent::add($auto_date, $null_values);
        if ($result)
        {
            // reading employee id
            $orderPackage = new OrderPackage($this->id_order_package);
            $orderDetail = new OrderDetail($this->id_order_detail);
            $orderDetail->increaseShippedQty($orderPackage->id_employee);
        }
        return $result;
    }
}