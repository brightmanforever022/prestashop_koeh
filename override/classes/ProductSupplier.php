<?php

// Wheelronix Ltd. development team
  // site: http://www.wheelronix.com
  // mail: info@wheelronix.com

class ProductSupplier extends ProductSupplierCore
{
    /**
     * For a given product and supplier, gets the product supplier reference
     *
     * @param int $id_product
     * @param int $id_product_attribute
     * @param int $id_supplier optional, if ommited default supplier is used
     * @return string
     */
    public static function getProductSupplierReference($id_product, $id_product_attribute, $id_supplier=0)
    {
        // build query
        $query = new DbQuery();
        $query->select('ps.product_supplier_reference');
        $query->from('product_supplier', 'ps');
        if (!$id_supplier)
        {
            $query->join('inner join '._DB_PREFIX_.'product p on p.id_product=ps.id_product');
            $query->where('ps.id_product = '.(int)$id_product.'
			AND ps.id_product_attribute = '.(int)$id_product_attribute.'
			AND ps.id_supplier = p.id_supplier'
            );
        }
        else
        {
            $query->where('ps.id_product = '.(int)$id_product.'
			AND ps.id_product_attribute = '.(int)$id_product_attribute.'
			AND ps.id_supplier = '.(int)$id_supplier
            );
        }

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query);
    }
}

