<?php

// Wheelronix Ltd. development team
// site: http://www.wheelronix.com
// mail: info@wheelronix.com

class CategoryController extends CategoryControllerCore
{
    /**
     * Assigns product list page sorting variables
     */
    public function productSort()
    {
        $order_by_values  = array(0 => 'name', 1 => 'price', 2 => 'date_add', 3 => 'date_upd', 4 => 'position', 5 => 'manufacturer_name',
            6 => 'quantity', 7 => 'reference');
        $order_way_values = array(0 => 'asc', 1 => 'desc');

        $stock_management = Configuration::get('PS_STOCK_MANAGEMENT') ? true : false; // no display quantity order if stock management disabled
        
        $this->orderBy  = Tools::getProductsOrder('by', Tools::getValue('orderby'), false, $this->category->id);
        $this->orderWay = Tools::getProductsOrder('way', Tools::getValue('orderway'));
        
        $this->context->smarty->assign(array(
            'orderby'          => $this->orderBy,
            'orderway'         => $this->orderWay,
            'orderbydefault'   => $order_by_values[(int)Configuration::get('PS_PRODUCTS_ORDER_BY')],
            'orderwayposition' => $order_way_values[(int)Configuration::get('PS_PRODUCTS_ORDER_WAY')], // Deprecated: orderwayposition
            'orderwaydefault'  => $order_way_values[(int)Configuration::get('PS_PRODUCTS_ORDER_WAY')],
            'stock_management' => (int)$stock_management
        ));
    }
}