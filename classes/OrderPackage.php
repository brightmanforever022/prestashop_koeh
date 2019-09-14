<?php

/**
 * 
 * @author vitaliy
 * Used for order packages 
 */
class OrderPackage extends ObjectModel
{
    public $id_order;
    
    public $id_employee;
    
    public $date_add;
    
    public $cancelled;
    
    public static $definition = array(
        'table' => 'order_package',
        'primary' => 'id_order_package',
        'fields' => array(
            'id_order' => array('type' => self::TYPE_INT, 'required' => true, 'copy_post' => false),
            'id_employee' => array('type' => self::TYPE_INT, 'required' => true),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'cancelled' => array('type' => self::TYPE_INT, 'required' => false),
        ),
    );
    
    protected $webserviceParameters = array(
        'objectsNodeName' => 'order_packages',
        'fields' => array(
            'id_order' => array('xlink_resource'=> 'orders'),
            'id_employee' => array('xlink_resource'=> 'employees'),
        ),
    );
    
    
    /**
     * Returns list products in order package, same products are glued
     * @param bool $withName Flag that tells that product name field should be included in list
     * @returns [order_detail_id, quantity, product_name -- optional]
     */
    function getGluedDetailsList($withName=false)
    {
        $sql = 'select opd.id_order_detail, count(opd.id_order_detail) as quantity'.($withName?', product_name, product_supplier_reference':'').
                ' from '._DB_PREFIX_.'order_package_detail opd'.
                ($withName?' left join '._DB_PREFIX_.'order_detail od on od.id_order_detail=opd.id_order_detail':'').
                ' where id_order_package='.$this->id.' group by opd.id_order_detail';
        return Db::getInstance()->executeS($sql);
    }
}