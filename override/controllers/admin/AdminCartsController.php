<?php

class AdminCartsController extends AdminCartsControllerCore
{
    protected $addSkuInNameFlag = false;

    public function __construct()
    {
        parent::__construct();
        
        $this->_select .= ', cl.name AS country_name';
        $this->_join .= '
            LEFT JOIN `'._DB_PREFIX_.'country_lang` cl ON cl.id_country = c.id_country 
                AND cl.id_lang = '. $this->context->employee->id_lang .' 
        ';
        $fieldListNew = array();
        foreach($this->fields_list as $columnName => $columnConfig){
            $fieldListNew[ $columnName ] = $columnConfig;
            if( $columnName == 'customer' ){
                $fieldListNew['company'] = array(
                    'title' => $this->l('Company'),
                );

                $fieldListNew['country_name'] = array(
                    'title' => $this->l('Country'),
                    'filter_key' => 'cl!name'
                );
                
            }
        }
        
        $this->fields_list = $fieldListNew;
    }
    
    public function ajaxProcessUpdateQty()
    {
        if ($this->tabAccess['edit'] === '1') {
            $errors = array();
            if (!$this->context->cart->id) {
                return;
            }
            if ($this->context->cart->OrderExists()) {
                $errors[] = Tools::displayError('An order has already been placed with this cart.');
            } elseif (!($id_product = (int)Tools::getValue('id_product')) || !($product = new Product((int)$id_product, true, $this->context->language->id))) {
                $errors[] = Tools::displayError('Invalid product');
            } elseif (!($qty = Tools::getValue('qty')) || $qty == 0) {
                $errors[] = Tools::displayError('Invalid quantity');
            }

            // Don't try to use a product if not instanciated before due to errors
            if (isset($product) && $product->id) {
                if (($id_product_attribute = Tools::getValue('id_product_attribute')) != 0) {
                    if (!Product::isAvailableWhenOutOfStock($product->out_of_stock) && !Attribute::checkAttributeQty((int)$id_product_attribute, (int)$qty)) {
                        $errors[] = Tools::displayError('There is not enough product in stock.');
                    }
                } elseif (!$product->checkQty((int)$qty)) {
                    $errors[] = Tools::displayError('There is not enough product in stock.');
                }
                if (!($id_customization = (int)Tools::getValue('id_customization', 0)) && !$product->hasAllRequiredCustomizableFields()) {
                    $errors[] = Tools::displayError('Please fill in all the required fields.');
                }
                $this->context->cart->save();
            } else {
                $errors[] = Tools::displayError('This product cannot be added to the cart.');
            }
            
            if (!count($errors)) {
                if ((int)$qty < 0) {
                    $qty = str_replace('-', '', $qty);
                    $operator = 'down';
                } else {
                    $operator = 'up';
                }

                if (!($qty_upd = $this->context->cart->updateQty($qty, $id_product, (int)$id_product_attribute, (int)$id_customization, $operator))) {
                    $errors[] = Tools::displayError('You already have the maximum quantity available for this product.');
                } elseif ($qty_upd < 0) {
                    $minimal_qty = $id_product_attribute ? Attribute::getAttributeMinimalQty((int)$id_product_attribute) : $product->minimal_quantity;
                    $errors[] = sprintf(Tools::displayError('You must add a minimum quantity of %d', false), $minimal_qty);
                }
            }
            
            $this->addSkuInNameFlag = true;
            echo Tools::jsonEncode(array_merge($this->ajaxReturnVars(), array('errors' => $errors)));
        }
    }
    
    
    protected function getCartSummary()
    {
        $summary = $this->context->cart->getSummaryDetails(null, true);
        $currency = Context::getContext()->currency;
        if (count($summary['products'])) {
            $prodsTemp = array();
            foreach( $summary['products'] as $summaryProduct ){
                array_unshift($prodsTemp, $summaryProduct);
            }
            $summary['products'] = $prodsTemp;
            foreach ($summary['products'] as &$product) {
                $product['numeric_price'] = $product['price'];
                $product['numeric_total'] = $product['total'];
                $product['price'] = str_replace($currency->sign, '', Tools::displayPrice($product['price'], $currency));
                $product['total'] = str_replace($currency->sign, '', Tools::displayPrice($product['total'], $currency));
                $product['image_link'] = $this->context->link->getImageLink($product['link_rewrite'], $product['id_image'], 'small_default');
                if (!isset($product['attributes_small'])) {
                    $product['attributes_small'] = '';
                }
                $product['customized_datas'] = Product::getAllCustomizedDatas((int)$this->context->cart->id, null, true);
                //if ($this->addSkuInNameFlag)
                //{
                    $product['name'] = $product['supplier_reference'].' - '.$product['name'];
                //}
            }
        }
        if (count($summary['discounts'])) {
            foreach ($summary['discounts'] as &$voucher) {
                $voucher['value_real'] = Tools::displayPrice($voucher['value_real'], $currency);
            }
        }

        if (isset($summary['gift_products']) && count($summary['gift_products'])) {
            foreach ($summary['gift_products'] as &$product) {
                $product['image_link'] = $this->context->link->getImageLink($product['link_rewrite'], $product['id_image'], 'small_default');
                if (!isset($product['attributes_small'])) {
                    $product['attributes_small'] = '';
                }
            }
        }


        return $summary;
    }

    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false)
    {
        // restrict list of allowed orders
        $employeeAreas = EmployeeArea::getEmployeeCountries($this->context->employee->id, $this->context->employee->id_lang);
        if( is_array($employeeAreas) && count($employeeAreas) ){
            EmployeeArea::setListSqlConditions('c', $this->context->employee->id, array(
                'select' => &$this->_select,
                'join' => &$this->_join,
                'where' => &$this->_where,
                'orderBy' => &$this->_orderBy,
                'orderWay' => &$this->_orderWay,
                'groupBy' => &$this->_group,
                'having' => &$this->_filterHaving
            ));
        }
        
        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);
    }
    
}