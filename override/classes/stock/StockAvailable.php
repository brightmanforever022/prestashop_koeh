<?php

class StockAvailable extends StockAvailableCore
{
    public $physical_quantity;
    
    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);
        
        $this->def['fields']['physical_quantity'] = array(
            'type' => self::TYPE_INT
        );
    }
    
    public static function setQuantityBoth($id_product, $id_product_attribute, $quantity, $physical_quantity)
    {
        if (!Validate::isUnsignedId($id_product)) {
            return false;
        }
        
        $context = Context::getContext();
        
        $id_shop = (int)$context->shop->id;
        
        $depends_on_stock = StockAvailable::dependsOnStock($id_product);
        
        //Try to set available quantity if product does not depend on physical stock
        if (!$depends_on_stock) {
            $id_stock_available = (int)StockAvailable::getStockAvailableIdByProductId($id_product, $id_product_attribute, $id_shop);
            if ($id_stock_available) {
                $stock_available = new StockAvailable($id_stock_available);
                $stock_available->quantity = (int)$quantity;
                $stock_available->physical_quantity = (int)$physical_quantity;
                $stock_available->update();
            } else {
                $out_of_stock = StockAvailable::outOfStock($id_product, $id_shop);
                $stock_available = new StockAvailable();
                $stock_available->out_of_stock = (int)$out_of_stock;
                $stock_available->id_product = (int)$id_product;
                $stock_available->id_product_attribute = (int)$id_product_attribute;
                $stock_available->quantity = (int)$quantity;
                $stock_available->physical_quantity = (int)$physical_quantity;
        
                if ($id_shop === null) {
                    $shop_group = Shop::getContextShopGroup();
                } else {
                    $shop_group = new ShopGroup((int)Shop::getGroupFromShop((int)$id_shop));
                }
        
                // if quantities are shared between shops of the group
                if ($shop_group->share_stock) {
                    $stock_available->id_shop = 0;
                    $stock_available->id_shop_group = (int)$shop_group->id;
                } else {
                    $stock_available->id_shop = (int)$id_shop;
                    $stock_available->id_shop_group = 0;
                }
                $stock_available->add();
            }
        
            Hook::exec('actionUpdateQuantity',
                array(
                    'id_product' => $id_product,
                    'id_product_attribute' => $id_product_attribute,
                    'quantity' => $stock_available->quantity
                )
                );
        }
        
        Cache::clean('StockAvailable::getQuantityAvailableByProduct_'.(int)$id_product.'*');
    }
    
    public static function getPhysicalQuantityByProduct($id_product = null, $id_product_attribute = null, $id_shop = null)
    {
        // if null, it's a product without attributes
        if ($id_product_attribute === null) {
            $id_product_attribute = 0;
        }

        $query = new DbQuery();
        $query->select('SUM(physical_quantity)');
        $query->from('stock_available');

        // if null, it's a product without attributes
        if ($id_product !== null) {
            $query->where('id_product = '.(int)$id_product);
        }

        $query->where('id_product_attribute = '.(int)$id_product_attribute);
        $query = StockAvailable::addSqlShopRestriction($query, $id_shop);
        $result = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query);
        return $result;
    }
    
    
    /**
     * Reads available and physical quantities
     * @param type $id_product
     * @param type $id_product_attribute
     * @return assoc array('avQty'=>, 'physQty'=>)
     */
    public static function getQuantityBoth($id_product, $id_product_attribute)
    {
        $result = Db::getInstance()->executeS('select quantity, physical_quantity from '._DB_PREFIX_.'stock_available where id_product='.
                $id_product.' and id_product_attribute='.$id_product_attribute.' and id_shop='.(int)$context->shop->id);
        if ($result)
        {
            return ['avQty'=>$result['quantity'], 'physQty'=>$result['physical_quantity']];
        }
        else
        {
            return ['avQty'=>0, 'physQty'=>0];
        }
    }
}