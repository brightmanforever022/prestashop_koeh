<?php
OrderSlipCore::$definition['fields']['crn_order_slip_number'] = array('type' => ObjectModel::TYPE_STRING);
class OrderSlip extends OrderSlipCore
{
    const InvoiceFolderPath = _PS_ROOT_DIR_.'/invoices/returns/';
    const InvoiceFolderUrl = __PS_BASE_URI__.'invoices/returns/';
    
    /**
     * @return string path there invoice file should be stored (independent if it saved or not). 
     * If object is not initialized returns empty string
     */
    function getInvoiceFilePath()
    {
        $fileName = $this->getInvoiceFileName();
        if (!empty($fileName))
        {
            return self::InvoiceFolderPath.$fileName;
        }
    }
    
    
    /**
     * returns just name of invoice file. If object is not initialized returns empty string
     */
    function getInvoiceFileName()
    {
        if ($this->id && $this->id_order)
        {
            return $this->id_order.'_'.$this->id.'.pdf';
        }
    }
    
    /**
     * Checks if file was generated and gives link on it.
     * @returns url of generated file or false if file was yet generated
     */
    function getInvoiceFileLink()
    {
        $path = $this->getInvoiceFilePath();
        if (empty($path) || !file_exists($path))
        {
            return false;
        }
        
        return self::InvoiceFolderUrl.$this->getInvoiceFileName();
    }
    
    
    public static function create(Order $order, $product_list, $shipping_cost = false, $amount = 0, $amount_choosen = false, $add_tax = true)
    {
        $currency = new Currency((int)$order->id_currency);
        $order_slip = new OrderSlip();
        $order_slip->id_customer = (int)$order->id_customer;
        $order_slip->id_order = (int)$order->id;
        $order_slip->conversion_rate = $currency->conversion_rate;

        if ($add_tax) {
            $add_or_remove = 'add';
            $inc_or_ex_1 = 'excl';
            $inc_or_ex_2 = 'incl';
        } else {
            $add_or_remove = 'remove';
            $inc_or_ex_1 = 'incl';
            $inc_or_ex_2 = 'excl';
        }

        $order_slip->{'total_shipping_tax_'.$inc_or_ex_1} = 0;
        $order_slip->{'total_shipping_tax_'.$inc_or_ex_2} = 0;
        $order_slip->partial = 0;

        if ($shipping_cost !== false) {
            $order_slip->shipping_cost = true;
            $carrier = new Carrier((int)$order->id_carrier);
            $address = Address::initialize($order->id_address_delivery, false);
            $tax_calculator = $carrier->getTaxCalculator($address);
            $order_slip->{'total_shipping_tax_'.$inc_or_ex_1} = ($shipping_cost === null ? $order->{'total_shipping_tax_'.$inc_or_ex_1} : (float)$shipping_cost);

            if ($tax_calculator instanceof TaxCalculator) {
                $order_slip->{'total_shipping_tax_'.$inc_or_ex_2} = Tools::ps_round($tax_calculator->{$add_or_remove.'Taxes'}($order_slip->{'total_shipping_tax_'.$inc_or_ex_1}), _PS_PRICE_COMPUTE_PRECISION_);
            } else {
                $order_slip->{'total_shipping_tax_'.$inc_or_ex_2} = $order_slip->{'total_shipping_tax_'.$inc_or_ex_1};
            }
        } else {
            $order_slip->shipping_cost = false;
        }

        $order_slip->amount = 0;
        $order_slip->{'total_products_tax_'.$inc_or_ex_1} = 0;
        $order_slip->{'total_products_tax_'.$inc_or_ex_2} = 0;

        foreach ($product_list as &$product) {
            $order_detail = new OrderDetail((int)$product['id_order_detail']);
            $price = (float)$product['unit_price'];
            $quantity = (int)$product['quantity'];
            $order_slip_resume = OrderSlip::getProductSlipResume((int)$order_detail->id);

            if ($quantity + $order_slip_resume['product_quantity'] > $order_detail->product_quantity) {
                $quantity = $order_detail->product_quantity - $order_slip_resume['product_quantity'];
            }

            if ($quantity == 0) {
                continue;
            }

            if (!Tools::isSubmit('cancelProduct') && $order->hasBeenPaid()) {
                $order_detail->product_quantity_refunded += $quantity;
            }

            $order_detail->save();

            $address = Address::initialize($order->id_address_invoice, false);
            $id_address = (int)$address->id;
            $id_tax_rules_group = Product::getIdTaxRulesGroupByIdProduct((int)$order_detail->product_id);
            $tax_calculator = TaxManagerFactory::getManager($address, $id_tax_rules_group)->getTaxCalculator();

            $order_slip->{'total_products_tax_'.$inc_or_ex_1} += $price * $quantity;

            if (in_array(Configuration::get('PS_ROUND_TYPE'), array(Order::ROUND_ITEM, Order::ROUND_LINE))) {
                if (!isset($total_products[$id_tax_rules_group])) {
                    $total_products[$id_tax_rules_group] = 0;
                }
            } else {
                if (!isset($total_products[$id_tax_rules_group.'_'.$id_address])) {
                    $total_products[$id_tax_rules_group.'_'.$id_address] = 0;
                }
            }

            $product_tax_incl_line = Tools::ps_round($tax_calculator->{$add_or_remove.'Taxes'}($price) * $quantity, _PS_PRICE_COMPUTE_PRECISION_);

            switch (Configuration::get('PS_ROUND_TYPE')) {
                case Order::ROUND_ITEM:
                    $product_tax_incl = Tools::ps_round($tax_calculator->{$add_or_remove.'Taxes'}($price), _PS_PRICE_COMPUTE_PRECISION_) * $quantity;
                    $total_products[$id_tax_rules_group] += $product_tax_incl;
                    break;
                case Order::ROUND_LINE:
                    $product_tax_incl = $product_tax_incl_line;
                    $total_products[$id_tax_rules_group] += $product_tax_incl;
                    break;
                case Order::ROUND_TOTAL:
                    $product_tax_incl = $product_tax_incl_line;
                    $total_products[$id_tax_rules_group.'_'.$id_address] += $price * $quantity;
                    break;
            }

            $product['unit_price_tax_'.$inc_or_ex_1] = $price;
            $product['unit_price_tax_'.$inc_or_ex_2] = Tools::ps_round($tax_calculator->{$add_or_remove.'Taxes'}($price), _PS_PRICE_COMPUTE_PRECISION_);
            $product['total_price_tax_'.$inc_or_ex_1] = Tools::ps_round($price * $quantity, _PS_PRICE_COMPUTE_PRECISION_);
            $product['total_price_tax_'.$inc_or_ex_2] = Tools::ps_round($product_tax_incl, _PS_PRICE_COMPUTE_PRECISION_);
        }

        unset($product);

        foreach ($total_products as $key => $price) {
            if (Configuration::get('PS_ROUND_TYPE') == Order::ROUND_TOTAL) {
                $tmp = explode('_', $key);
                $address = Address::initialize((int)$tmp[1], true);
                $tax_calculator = TaxManagerFactory::getManager($address, $tmp[0])->getTaxCalculator();
                $order_slip->{'total_products_tax_'.$inc_or_ex_2} += Tools::ps_round($tax_calculator->{$add_or_remove.'Taxes'}($price), _PS_PRICE_COMPUTE_PRECISION_);
            } else {
                $order_slip->{'total_products_tax_'.$inc_or_ex_2} += $price;
            }
        }

        //$order_slip->{'total_products_tax_'.$inc_or_ex_2} -= (float)$amount && !$amount_choosen ? (float)$amount : 0;
        $order_slip->amount = $amount_choosen ? (float)$amount : $order_slip->{'total_products_tax_'.$inc_or_ex_1};
        $order_slip->shipping_cost_amount = $order_slip->{'total_shipping_tax_'.$inc_or_ex_1};

        if ((float)$amount && !$amount_choosen) {
            $order_slip->order_slip_type = 1;
        }
        if (((float)$amount && $amount_choosen) || $order_slip->shipping_cost_amount > 0) {
            $order_slip->order_slip_type = 2;
        }

        if (!$order_slip->add()) {
            return false;
        }

        $res = true;

        foreach ($product_list as $product) {
            $res &= $order_slip->addProductOrderSlip($product);
        }

        return $res;
    }
    
    
    function delete()
    {
        // delete slip details
        Db::getInstance()->query('delete from '._DB_PREFIX_.'order_slip_detail where id_order_slip='.$this->id);
        $filePath = $this->getInvoiceFilePath();
        
        return parent::delete() && unlink($filePath);
    }
}