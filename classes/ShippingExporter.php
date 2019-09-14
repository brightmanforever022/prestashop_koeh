<?php
  // Wheelronix Ltd. development team
  // site: http://www.wheelronix.com
  // mail: info@wheelronix.com
  //

require _PS_TOOL_DIR_ . '/phpqrcode/qrlib.php';

class ShippingExporterCore
{
    const RowEnd = "\r\n";
    const Separator = '|';
    const DHLSaveFolder = '/dhl/';  // related with shop root
    const EUZoneId = 7;
    const DEZoneId = 6;
    
    public static $dhlCarrierIds = array(34, 41, 45, 44);
    public static $dhlExpressCarrierIds = array(38, 39);

    public static $germanIslandZips = array(18565,25846,25847,25849,25859,25863,25869,25929,25930,25931,25932,25933,25938,25939,25940,25941,25942,25946,25947,25948,25949,25952,
                                            25953,25954,25955,25961,25962,25963,25964,25965,25966,25967,25968,25969,25970,25980,25985,25986,25988,25989,25990,25992,25993,25994,
                                            25996,25997,25998,25999,25845,26465,26474,26486,26548,26571,26579,26757,27498,83209,83256);
    
    const GermanyCountryId = 1;
    // min quantity product should have to be shown in summary list in shipping info
    const ProductSummaryMinQty = 4; 
                                    
    
    /**
     * Generates csv list of shipping info/addresses for given orders. Format of
     * list is following:
     * Name	Vorname	Strasse	PLZ	Ort	Email	Land	Versandart OrderId
     * Outputs xls and exits.
     * @param $orderIds array of ids of order for that we need to generate list.
     */
    static function generateDHLList($orderIds)
    {
        if(count($orderIds)==0)
        {
            return;
        }


        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=package_info.zip");

        header('Pragma: no-cache',true);
        header('Expires: 0',true);

        //ini_set('display_errors', 'on');
        
        $saveFileNameDpd = _PS_ROOT_DIR_.self::DHLSaveFolder.'dpd.csv';
        $saveFileNameDhl = _PS_ROOT_DIR_.self::DHLSaveFolder.'dhl.csv';
        $saveFileNameForeign = _PS_ROOT_DIR_.self::DHLSaveFolder.'auslaender.csv';
        $saveFileNameZip = _PS_ROOT_DIR_.self::DHLSaveFolder.'package_info.zip';

        $dpdCsv = $dhlCsv = $foreignCsv = self::encodeField('Name').self::Separator.self::encodeField('Vorname').self::Separator.self::encodeField('Strasse').
            self::Separator.self::encodeField('PLZ').self::Separator.self::encodeField('Ort').self::Separator.
            self::encodeField('Email').self::Separator.self::encodeField('Land').self::Separator.self::encodeField('Versandart').self::Separator.
            self::encodeField('Strasse2').self::Separator.self::encodeField('Firma').self::Separator.
            self::encodeField('Order id').self::Separator.self::encodeField('serviceliste').self::Separator.self::encodeField('verfahren').self::Separator.
            self::encodeField('produkt').self::Separator.self::encodeField('teilnahme').self::Separator.self::encodeField('method').self::Separator.
            self::encodeField('cash on delivery amount').self::Separator.self::encodeField('Currency').self::Separator.self::encodeField('payment type').
            self::Separator.self::encodeField('phone').self::Separator.self::encodeField('zhd').self::Separator.self::encodeField('benachrichtigungsart').
            self::Separator.self::encodeField('email').self::Separator.self::encodeField('flex').self::Separator.self::encodeField('flex4').
            self::Separator.self::encodeField('Name').self::RowEnd;
        
        // reading orders
        $db = Db::getInstance();
        $sql = 'select ad.firstname, ad.lastname, ad.address1, ad.address2, ad.company, ad.postcode, ad.city, ad.other, c.email, country.name as country_name,'.
            ' o.id_order, source, o.module, o.id_carrier, o.total_paid, o.id_cart, o.payment, ad.phone, ad.phone_mobile, ad.id_country FROM '
            ._DB_PREFIX_.'orders o, '.
            _DB_PREFIX_.'customer c, '._DB_PREFIX_.'address ad, '._DB_PREFIX_.'country_lang country WHERE '.
            'o.id_customer=c.id_customer and id_address_delivery=ad.id_address and ad.id_country=country.id_country and country.id_lang= '.Configuration::get('PS_LANG_DEFAULT').
            ' and id_order in('.implode(',', $orderIds).')';

        $orders = $db->ExecuteS($sql);

        if ($orders)
        {
            self::sortOrders($orders);
        }

        foreach($orders as $order)
        {
            if ($order['id_country']!=self::GermanyCountryId && !($order['payment']=='Nachnahme' && $order['module']=='Ebay'))
            {
                $foreignCsv .= self::getDhlCsvLine($order, true);
            }
            else
            {
                $gluedAddress = $order['address1'].' '.$order['address2'].' '.$order['company'].$order['postcode'].' '.$order['city'].$order['other'].$order['lastname'].
                    $order['firstname'];
                if (stripos($gluedAddress, 'packstation')!==false)
                {
                    // cut numbers
                    if (preg_match('/\D(\d{3})\D/', 'a'.$gluedAddress, $num1) && preg_match('/\D(\d{7,12})\D/', 'a'.$gluedAddress, $num2))
                    {
                        $order['address1'] = 'Packstation '.$num1[1];
                        $order['address2'] = $num2[1];
                    }
                    $dhlCsv .= self::getDhlCsvLine($order);
                }
                elseif (self::isDhlOrder($order))
                {
                    $dhlCsv .= self::getDhlCsvLine($order);
                }
                else
                {
                    $dpdCsv .= self::getDhlCsvLine($order, true);
                }
            }
        }

        // convert to ANSI aka WIN-1252
        $dpdCsv = iconv("UTF8", "WINDOWS-1252//TRANSLIT", $dpdCsv);
        $dhlCsv = iconv("UTF8", "WINDOWS-1252//TRANSLIT", $dhlCsv);
        $foreignCsv = iconv("UTF8", "WINDOWS-1252//TRANSLIT", $foreignCsv);
        
        // save files
        file_put_contents($saveFileNameDpd, $dpdCsv);
        file_put_contents($saveFileNameDhl, $dhlCsv);
        file_put_contents($saveFileNameForeign, $foreignCsv);
        
        // output
        $zip = new ZipArchive();
        if ($zip->open($saveFileNameZip, ZIPARCHIVE::CREATE)!==TRUE) {
            exit('Can\'t open zip file');
        }
        $zip->addFromString('dpd.csv', $dpdCsv);
        $zip->addFromString('dhl.csv', $dhlCsv);
        $zip->addFromString('auslaender.csv', $foreignCsv);
        $zip->close();
        
        readfile($saveFileNameZip);
        exit;
    }


    /**
     * @returns true if order should be exported to dhl list
     */
    static function isDhlOrder(&$order)
    {
        $gluedAddress = $order['address1'].' '.$order['address2'].' '.$order['company'].$order['postcode'].' '.$order['city'].$order['other'].$order['lastname'].
            $order['firstname'];
        return $order['module']=='maofree_cashondeliveryfee' || stripos($gluedAddress, 'postfach')!==false || stripos($gluedAddress, 'postfiliale')
            || ($order['payment']=='Nachnahme' && $order['module']=='Ebay' && $order['id_country']==self::GermanyCountryId)
            || in_array($order['postcode'], self::$germanIslandZips) || stripos($gluedAddress, 'packstation')!==false
        	|| stripos($gluedAddress, 'postfiliale')!==false || 
            ($order['id_country']==self::GermanyCountryId && Configuration::get('PS_DHL_DEFAULT_DELIVERY'));
    }
    
    
    /**
     * Generates file with name dhl.csv or dpd.csv with single given order,
     * saves it on server and sends to browser
     * @param $orderId id of order that we export
     * @param $dpd flag that tells if file should be called dhl or dpd
     */
    static function genSingleDhlFile($orderId, $dpd=false)
    {
        // reading order
        $sql = 'select ad.firstname, ad.lastname, ad.address1, ad.address2, ad.company, ad.postcode, ad.city, ad.other, c.email, country.name as country_name,'.
            ' o.id_order, source, o.module, o.id_carrier, o.total_paid, o.id_cart, ad.phone, ad.phone_mobile, ad.id_country, o.payment FROM '
            ._DB_PREFIX_.'orders o, '.
            _DB_PREFIX_.'customer c, '._DB_PREFIX_.'address ad, '._DB_PREFIX_.'country_lang country WHERE '.
            'o.id_customer=c.id_customer and id_address_delivery=ad.id_address and ad.id_country=country.id_country and country.id_lang= '.Configuration::get('PS_LANG_DEFAULT').
            ' and id_order = '.$orderId;
        $order = Db::getInstance()->getRow($sql);

        // generate output
        $csvLine = self::encodeField('Name').self::Separator.self::encodeField('Vorname').self::Separator.self::encodeField('Strasse').
            self::Separator.self::encodeField('PLZ').self::Separator.self::encodeField('Ort').self::Separator.
            self::encodeField('Email').self::Separator.self::encodeField('Land').self::Separator.self::encodeField('Versandart').self::Separator.
            self::encodeField('Strasse2').self::Separator.self::encodeField('Firma').self::Separator.
            self::encodeField('Order id').self::Separator.self::encodeField('serviceliste').self::Separator.self::encodeField('verfahren').self::Separator.
            self::encodeField('produkt').self::Separator.self::encodeField('teilnahme').self::Separator.self::encodeField('method').self::Separator.
            self::encodeField('cash on delivery amount').self::Separator.self::encodeField('Currency').self::Separator.self::encodeField('payment type').
            self::Separator.self::encodeField('phone').self::Separator.self::encodeField('zhd').self::Separator.self::encodeField('benachrichtigungsart').
            self::Separator.self::encodeField('email').self::Separator.self::encodeField('flex').self::Separator.self::encodeField('flex4').
            self::Separator.self::encodeField('Name').self::RowEnd;
        $csvLine .= self::getDhlCsvLine($order, $dpd);
        $csvLine = iconv("UTF8", "WINDOWS-1252//TRANSLIT", $csvLine);
        $resultFileName = _PS_ROOT_DIR_.self::DHLSaveFolder.($dpd?'dpd.csv':'dhl.csv');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename='.($dpd?'dpd.csv':'dhl.csv'));
      
        header('Pragma: no-cache',true);
        header('Expires: 0',true);
        
        file_put_contents($resultFileName, $csvLine);
        readfile($resultFileName);
        exit;
    }
    

    /**
     * @param $packstation flag tells to format "packstation" addresses
     */
    static function &getDhlCsvLine($order, $dpd=false)
    {
        if (Order::isAmazonOrderSt($order['source']) && !Configuration::get('PS_AMAZON_CSV_EMAIL_EXPORT'))
        {
            $exportEmail = false;
        }
        else
        {
            $exportEmail = true;
        }
        
        $csv = self::encodeField($order['firstname']).self::Separator.self::encodeField($order['lastname']).self::Separator.
            self::encodeField($order['address1']).self::Separator.self::encodeField($order['postcode']).self::Separator.self::encodeField($order['city']).
            self::Separator.self::encodeField(($exportEmail)?$order['email']:'').self::Separator.self::encodeField($order['country_name']).
            self::Separator.self::encodeField('DHL Paket').self::Separator.self::encodeField($order['address2']).self::Separator.
            self::encodeField($order['company']).self::Separator.self::encodeField($order['id_order']);

        $dpdMethodTail = $dpd?self::getDpdMethodFieldTail($order):'';
        $expressOrder = false;
        if (in_array($order['id_carrier'], self::$dhlExpressCarrierIds))
        {
            $expressOrder = true;
            if ($order['module']=='maofree_cashondeliveryfee' || $order['source']==Order::SourceEbay && $order['payment']=='Nachnahme')
            {
                $orderTotal = number_format($order['total_paid'], 2, ',', '');
                $csv .= self::Separator.self::encodeField('7210;7224='.$orderTotal)
                    .self::Separator.self::encodeField('72').self::Separator.self::encodeField('7202').self::Separator.self::encodeField('01').
                    self::Separator.self::encodeField('Express cash on delivery').$dpdMethodTail.self::Separator.self::encodeField($orderTotal);
            }
            else
            {
                $csv .= self::Separator.self::encodeField('7210').self::Separator.self::encodeField('72').self::Separator.
                    self::encodeField('7205').self::Separator.self::encodeField('01').self::Separator.self::encodeField('Express standard payment').
                    $dpdMethodTail.self::Separator.self::encodeField('');
            }
        }
        elseif(in_array($order['id_carrier'], self::$dhlCarrierIds))
        {
            if ($order['module']=='maofree_cashondeliveryfee' || $order['source']==Order::SourceEbay && $order['payment']=='Nachnahme')
            {
                $orderTotal = number_format($order['total_paid'], 2, ',', '');
                    
                $csv .= self::Separator.self::encodeField('134='.$orderTotal).self::Separator.self::encodeField('1').
                    self::Separator.self::encodeField('101').self::Separator.self::encodeField('02').self::Separator.self::encodeField('Standard cash on delivery').
                    $dpdMethodTail.self::Separator.self::encodeField($orderTotal);
            }
            else
            {
                $csv .= self::Separator.self::encodeField('').self::Separator.self::encodeField('1').self::Separator.self::encodeField('101').
                    self::Separator.self::encodeField('02').self::Separator.($dpdMethodTail?trim($dpdMethodTail):self::encodeField('Standard')).
                    self::Separator.self::encodeField('');
            }
        }
        else
        {
            // empty values for columns that we don't know how to fill
            $csv .= self::Separator.self::encodeField('').self::Separator.self::encodeField('').self::Separator.self::encodeField('').
                self::Separator.self::encodeField('').self::Separator.self::encodeField('').($dpd?self::getDpdMethodFieldTail($order):'').self::Separator.self::encodeField('');
        }

        $phone = empty($order['phone'])?$order['phone_mobile']:$order['phone'];
        $csv .= self::Separator.self::encodeField('EUR').self::Separator.self::encodeField('cash').self::Separator.self::encodeField($phone).
            self::Separator.self::encodeField($order['firstname'].' '.$order['lastname']);

        if ($expressOrder)
        {
            $csv .= self::Separator.self::encodeField('').self::Separator.self::encodeField('').self::Separator.self::encodeField('').self::Separator.self::encodeField('');
        }
        else
        {
            $csv .= self::Separator.self::encodeField('E').
                self::Separator.self::encodeField($exportEmail?$order['email']:'').
                self::Separator.self::encodeField('904').self::Separator.self::encodeField('DE');
        }
        
        $csv .= self::Separator.self::encodeField($order['firstname'].' '.$order['lastname']).self::RowEnd;

        return $csv;
    }


    /**
     * @param $order assoc array with order data. Must be dpd order.
     * @returns tail (string) that should be added to method field of csv file. 
     */
    static function getDpdMethodFieldTail(&$order)
    {
        if ((Configuration::get('PS_AMAZON_CSV_EMAIL_EXPORT') || !Order::isAmazonOrderSt($order['source'])) &&
            !in_array($order['id_carrier'], ShippingExporter::$dhlExpressCarrierIds) && !empty($order['email']))
        {
            return ' SCP,PRO';
        }
    }

    /**
     * Prints information about given orders as html
     */
    static function exportHtmlInfo($orderIds)
    {
        $db = Db::getInstance();
        
        // reading orders
        $sql = 'select o.id_order, o.id_cart, o.id_carrier, o.payment, o.module, ad.firstname, ad.lastname, ad.address1, ad.address2, ad.company, ad.postcode,'.
            ' ad.city, ad.other, '.
            ' c.email, ad.id_country, cr.name as carrier_name, country.name as country_name, (select oh.date_add from '.
            _DB_PREFIX_.'order_history oh  where oh.id_order=o.id_order and id_order_state='._PS_OS_PAYMENT_.' order by date_add desc limit 1) as paid_date'.
            ' FROM '._DB_PREFIX_.'orders o left join '._DB_PREFIX_.'carrier cr on o.id_carrier=cr.id_carrier, '.
            _DB_PREFIX_.'customer c, '._DB_PREFIX_.'address ad, '._DB_PREFIX_.'country_lang country WHERE '.
            'o.id_customer=c.id_customer and id_address_delivery=ad.id_address and ad.id_country=country.id_country and country.id_lang='.Configuration::get('PS_LANG_DEFAULT').
            ' and o.id_order in('.implode(',', $orderIds).')';

        //echo $sql;
        $orders = $db->s($sql);

        if ($orders)
        {
            self::sortOrders($orders);
        }

        // prepare data
        $summaryProducts = array();
        foreach($orders as $key => $order)
        {
            // reading messages
            $messages = '';
            $dbMessages = $db->s('select message from '._DB_PREFIX_.'message where id_order='.$order['id_order']);
            for($i=0; $i<count($dbMessages); $i++)
            {
                if ($i>0)
                {
                    $messages .= "<hr>\n";
                }
                $messages .= $dbMessages[$i]['message'];
            }
            $orders[$key]['messages'] = $messages;
            
            // output order
            $orders[$key]['products'] = self::getProductsInfo($order['id_order']);

            // prepare summary products
            foreach($orders[$key]['products'] as $product)
            {
                // combine products for summary list
                $productId = $product['product_id'].'-'.$product['product_attribute_id'];
                if (isset($summaryProducts[$productId]))
                {
                    $summaryProducts[$productId]['product_quantity'] += $product['product_quantity'];
                }
                else
                {
                    $summaryProducts[$productId] = $product;
                }
            }
        }

        // copy to preserve keys
        $summaryProductsUnsorted = $summaryProducts;
        
        // sort summary products by quantity
        usort($summaryProducts, function($product1, $product2){

                return $product1['product_quantity']<$product2['product_quantity'];
            });


        // output orders, table header
        echo '<html>
              <head>
              <link href="themes/default/css/admin-theme.css" rel="stylesheet" type="text/css">
              <style type="text/css" media="all">
               * {font-size: 16px;}
               body{background-color: #fff;}
               .icon-check {color: #72C279;}
               .icon-remove {color: #E08F95;}
               table {border-collapse: collapse; border:1px solid black}
               table th {background-color: #ccc;} 
               table td {border: 1px solid black; padding:10px; border-spacing:0px}
               table.products {border: none;}
               table.products td {border: none; padding:3px;}
               .bold { font-weight: bold;}
               .boldRed { font-weight: bold; color:red }
               .redBg {background-color: red;}
               .supplierReference{font-size: 18px;}
                .summaryReference{color: red}
              </style>
              </head>
              <body>';
        
        //show summary products list
        $link = new Link();

        $summaryProductsList = '';
        foreach($summaryProducts as $product)
        {
            if ($product['product_quantity']>=self::ProductSummaryMinQty)
            {
                $summaryProductsList .= '<tr><td '.($product['product_quantity']!=1?'class="boldRed"':'').'>'.$product['product_quantity'].
                    '</td><td>'.($product['quantity_in_stock']>0?'<i class="icon-check"></i>':'<i class="icon-remove"></i>').
                    '</td><td><img src="//'.$link->getImageLink('aaa', $product['product_id'].'-'.$product['id_image'], 'cart_default').
                    '"></td><td>'.$product['product_name'];
                if(!empty($product['attribute_location']))
                {
                    $productLocation = ', '.$product['attribute_location'];
                }
                elseif(!empty($product['location']))
                {
                    $productLocation = ', '.$product['location'];
                }
                else
                {
                    $productLocation = '';
                }
            
                $summaryProductsList .= '</td><td class="bold supplierReference">'.$product['product_supplier_reference'].$productLocation.'</td></tr>';
            }
        }

        if (!empty($summaryProductsList))
        {
            echo '<h1>Summary products</h1><table><tr><th>Anzahl</th><th>Auf Lager</th><th>Foto</th><th>Artikel</th><th>Artikelnummer</th></tr>';
            echo $summaryProductsList;
            echo '</table>';
        }
        

        echo '<h1>Orders:</h1><table>
              <tr>
                 <th>Bestellnummer</th><th>Produkte</th><th>Kommentare</th><th>Anschrift</th>
              </tr>';
        foreach($orders as $order)
        {
            // prepare product details
            $warningQuantity = false;
            $details = '<table class="products"><tr><th>Anzahl</th><th>Auf Lager</th><th>Shipped</th><th>Foto</th><th>Artikel</th><th>Artikelnummer</th></tr>';
            foreach($order['products'] as $product)
            {
                if ($product['product_quantity']>1)
                {
                    $warningQuantity = true;
                }
                
               $details .= '<tr><td '.($product['product_quantity']!=1?'class="boldRed"':'').'>'.$product['product_quantity'].
                    '</td><td>'.($product['quantity_in_stock']>0?'<i class="icon-check"></i>':'<i class="icon-remove"></i>').
                    '</td><td>'.($product['shipped']==1?'<i class="icon-check"></i>':'<i class="icon-remove"></i>').'</td><td><img src="//'.$link->getImageLink('aaa', $product['product_id'].'-'.$product['id_image'], 'cart_default').'"></td>'.
                    '<td>'.$product['product_name'];

                /*
                 if(!empty($product['attribute_value']))
                 {
                 $result .= '<br>'.$product['attribute_name'].': '.$product['attribute_value'];
                 }
                */
            
                if(!empty($product['attribute_location']))
                {
                    $productLocation = ', '.$product['attribute_location'];
                }
                elseif(!empty($product['location']))
                {
                    $productLocation = ', '.$product['location'];
                }
                else
                {
                    $productLocation = '';
                }

                // deal with supplier reference highlight for summaty products
                $productId = $product['product_id'].'-'.$product['product_attribute_id'];
                
                if ($summaryProductsUnsorted[$productId]['product_quantity']>=self::ProductSummaryMinQty)
                {
                    $details .= '</td><td class="bold supplierReference summaryReference">';
                }
                else
                {
                    $details .= '</td><td class="bold supplierReference">';
                }
                $details .= $product['product_supplier_reference'].$productLocation.'</td></tr>';
            }
            if(count($order['products'])==0)
            {
                $details .= '<tr><td colspan="6"><em>There is no not shipped products in this order</em></td></tr>';
            }
            $details .= '</table>';

            
            // dealing with customer column class
            $customerColumnClass = '';
            if ($order['id_country'] != self::GermanyCountryId)
            {
                $customerColumnClass = 'class="boldRed"';
            }
            if ($warningQuantity)
            {
                $customerColumnClass = 'class="redBg"';
            }

            if (in_array($order['id_carrier'], self::$dhlExpressCarrierIds))
            {
                $carrier = '<span class="boldRed">'.$order['carrier_name'].'</span>';
            }
            else
            {
                $carrier = $order['carrier_name'];
            }
            
            echo '<tr><td>'.$order['id_order'].'<br/>'.$carrier.
                '</td><td>'.$details
                .'</td><td>'.$order['messages'].'</td>'.
                '<td '.$customerColumnClass.'>'.
                $order['firstname'].' '.$order['lastname'].'<br>'.$order['address1'].' '.$order['address2'].'<br> '.$order['postcode'].' '.$order['city'].
                '<br> '.$order['country_name'].(!empty($order['paid_date'])?'<br><br>Paid: '.strftime('%c', strtotime($order['paid_date'])):'').'</td></tr>';
        }

        // output footer
        echo '</table></body></html>';
    }

    
    /**
     * Prints information about given orders as html
     */
    static function exportPdfInfo($orderIds)
    {
        $db = Db::getInstance();
        
        // reading orders
        $sql = 'select o.id_order, o.id_cart, o.id_carrier, o.payment, o.module, o.id_customer, ad.firstname, ad.lastname, ad.address1, '
                . 'ad.address2, ad.company, ad.postcode, ad.city, ad.other, c.email, c.company AS customer_company, ad.id_country, '
                . 'cr.name as carrier_name, country.name as country_name, o.date_add, (select oh.date_add from '.
            _DB_PREFIX_.'order_history oh  where oh.id_order=o.id_order and id_order_state='._PS_OS_PAYMENT_.' order by date_add desc limit 1)'
                . ' as paid_date, c.credit_limit, (SELECT SUM(oi1.sum_to_pay) 
                        FROM `' . _DB_PREFIX_ . 'order_invoice` oi1
                        INNER JOIN `' . _DB_PREFIX_ . 'orders` o1 ON o1.id_order = oi1.id_order
                        INNER JOIN `' . _DB_PREFIX_ . 'ba_prestashop_invoice` bai1 
                            ON oi1.template_id = bai1.id 
                            AND bai1.payment_type != ' . (BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP) . '
                        WHERE 
                            o1.id_customer = o.id_customer
                            AND oi1.number > 0
                            AND oi1.paid = 0
                            AND o1.current_state != ' . intval(Configuration::get('PS_OS_CANCELED')) . '
                        ) as 
                unpaid_amount'.
            ' FROM '._DB_PREFIX_.'orders o left join '._DB_PREFIX_.'carrier cr on o.id_carrier=cr.id_carrier, '.
            _DB_PREFIX_.'customer c, '._DB_PREFIX_.'address ad, '._DB_PREFIX_.'country_lang country WHERE '.
            'o.id_customer=c.id_customer and id_address_delivery=ad.id_address and ad.id_country=country.id_country and country.id_lang='.Configuration::get('PS_LANG_DEFAULT').
            ' and o.id_order in('.implode(',', $orderIds).')
            order by o.date_add ASC
        ';

        //echo $sql;
        $orders = $db->s($sql);

        // reading shipping priority info
        $serverInfo = Tools::getCentralServerUrl();
        $url = $serverInfo['serverUrl'].'admin123/index_service.php/dbk_ext_shop_delivery/get_stock_status_koehlert2';
            
        $postdata = http_build_query(
            array(
                 'order_ids' => $orderIds,
            )
        );
        $opts = $serverInfo['fgcOptions'];
        $opts['http'] = array(
                    'method' => 'POST',
                    'header' => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => $postdata
        );
        $context = stream_context_create($opts);

        $result = file_get_contents($url, false, $context);
        $shippingProducts = json_decode($result, true);
        //print_r($shippingProducts);

        // reading delivery requests info
        
        $dlvrReqUrl = $serverInfo['serverUrl'] . 'admin123/index_service.php/dbk_ext_shop_delivery/get_dlvr_req_info2/' .
                Configuration::get('MSSS_CLIENT_SOURCE_ID') . '?orderIds[]=' . implode('&orderIds[]=', $orderIds);
        $dlvrReqInfo = file_get_contents($dlvrReqUrl, false, stream_context_create($serverInfo['fgcOptions']));

        $dlvrReqInfo = json_decode($dlvrReqInfo, true);
        
        $deliveryRequestInfoDetailed = self::parseVdDeliveryRequestInfo($dlvrReqInfo);

        
        // prepare data
        $summaryProducts = array();
        foreach($orders as $key => $order)
        {
            // reading messages
            $messages = '';
            $orderFirstMessage = null;
            $orderFirstMessageSql = '
                SELECT ct.*, cm.*
                FROM '._DB_PREFIX_.'customer_thread ct
                LEFT JOIN '._DB_PREFIX_.'customer_message cm
                    ON ct.id_customer_thread = cm.id_customer_thread
                WHERE ct.id_order = '.(int)$order['id_order'].' 
                ORDER BY cm.id_customer_message ASC
            ';
            $orderFirstMessage = Db::getInstance()->getRow($orderFirstMessageSql);
            
            // add only private messages by staff
            $orderMessagesList = CustomerThread::getCustomerMessagesByOrderId($order['id_order']);
            foreach ($orderMessagesList as $orderMessage){
                if( ($orderMessage['id_employee'] == 0) || ($orderMessage['private'] == 0) ){
                    continue;
                }
                // some messages were not saved as 'private messages by staff', exclude them if they were saved like this
                if( $orderFirstMessage['id_customer_message'] == $orderMessage['id_customer_message'] ){
                    $orderFirstMessage = null;
                }
                $messages .= $orderMessage['message'] ."<hr>\n";
            }
            if( is_array($orderFirstMessage) && count($orderFirstMessage) ){
                $messages = $orderFirstMessage['message'] . "<hr>\n" . $messages;
            }
            
            $orders[$key]['messages'] = $messages;
            
            // output order
            $orders[$key]['products'] = self::getProductsInfo($order['id_order']);

            // prepare summary products
            foreach($orders[$key]['products'] as $product)
            {
                // combine products for summary list
                $productId = $product['product_id'].'-'.$product['product_attribute_id'];
                if (isset($summaryProducts[$productId]))
                {
                    $summaryProducts[$productId]['product_quantity'] += $product['product_quantity'];
                }
                else
                {
                    $summaryProducts[$productId] = $product;
                }
            }
        }

        // copy to preserve keys
        $summaryProductsUnsorted = $summaryProducts;
        
        // sort summary products by quantity
        usort($summaryProducts, function($product1, $product2){

                return $product1['product_quantity']<$product2['product_quantity'];
            });


        // output orders, table header
            
        $result = '<html>
              <head>
              <link href="themes/default/css/admin-theme.css" rel="stylesheet" type="text/css">
              <style type="text/css" media="all">
               * {font-size: 16px;}
               body{background-color: #fff;}
               .icon-check {color: #72C279; font-family: fontawesome; }
               .icon-remove {color: #E08F95; font-family: fontawesome;}
               table {border-collapse: collapse; border:1px solid black}
               table th {background-color: #ccc;} 
               table td {border: 1px solid black; padding:10px; border-spacing:0px}
               table.products {border: none;}
               table.products td {border: none; padding:3px;}
               .bold { font-weight: bold;}
               .boldRed { font-weight: bold; color:red }
               .redBg {background-color: red;}
               .supplierReference{}
                .summaryReference{color: red}
              </style>
              </head>
              <body>';
        
        //show summary products list
        $link = new Link();

        $summaryProductsList = '';
        foreach($summaryProducts as $product)
        {
            if ($product['product_quantity']>=self::ProductSummaryMinQty)
            {
                $summaryProductsList .= '<tr><td '.($product['product_quantity']!=1?'class="boldRed"':'').'>'.$product['product_quantity'].
                    '</td><td>'.($product['quantity_in_stock']>0?'<span class="icon-check">&#xf00c;</span>':'<span class="icon-remove">&#xf00d;</span>').
                    '</td><td><img src="//'.$link->getImageLink('aaa', $product['product_id'].'-'.$product['id_image'], 'cart_default').
                    '"></td><td>'.$product['product_name'].
                    '<br>Phys. Bestand: '.$product['physical_quantity'].'<br>Verf. Bestand: '.$product['av_quantity'];
                if(!empty($product['attribute_location']))
                {
                    $productLocation = ', '.$product['attribute_location'];
                }
                elseif(!empty($product['location']))
                {
                    $productLocation = ', '.$product['location'];
                }
                else
                {
                    $productLocation = '';
                }
            
                $summaryProductsList .= '</td><td class="bold supplierReference">'.$product['product_supplier_reference'].$productLocation.'</td></tr>';
            }
        }

        if (!empty($summaryProductsList))
        {
            $result .=  '<h1>Summary products</h1><table><tr><th>Anzahl</th><th>Auf Lager</th><th>Foto</th><th>Artikel</th><th>Artikelnummer</th></tr>';
            $result .=  $summaryProductsList;
            $result .=  '</table>';
            $result .= '<pagebreak />';
        }
        

        $result .=  '<h1>Bestellungen:</h1>';
        foreach($orders as $i=>$order)
        {
            if($i>0)
            {
                $result .= '<pagebreak />';
            }
            
            $result .= '<h2>'. $order['customer_company'] .', '. $order['country_name'] .'</h2>';
            
            $result .= 'Credit limit: '.Tools::displayPrice($order['unpaid_amount']).' / '.
                        Tools::displayPrice($order['credit_limit']).'<br>';
            
            if (in_array($order['id_carrier'], self::$dhlExpressCarrierIds))
            {
                $carrier = '<span class="boldRed">'.$order['carrier_name'].'</span>';
            }
            else
            {
                $carrier = $order['carrier_name'];
            }
            
            $qrCodeImageName = uniqid() .'.png';
            $qrCodeImagePath = _PS_TMP_IMG_DIR_ . $qrCodeImageName ;
            $qrCodeImageUrl = _PS_TMP_IMG_ . $qrCodeImageName;
            QRcode::png($order['id_order'], $qrCodeImagePath, QR_ECLEVEL_H, 2, 4);
            
            $result .=  '
                <table width="100%" class="products"><tr><td width="50%">
                Bestellnummer: '.$order['id_order'].'<br/>'.$carrier.'<br>'.
                    'Order date: '.Tools::displayDate($order['date_add']).
                    '</td>'.
                '<td width="50%" style="text-align:right"><img src="'. $qrCodeImageUrl .'" /></td></tr></table>';
            
            $contentRowsRendered = -1;
            $customerComments = ShopComment::getCustomerComments($order['id_customer'], 1);
            if( is_array($customerComments) && count($customerComments) ){
                $contentRowsRendered++;
                $result .= '<table>';
                foreach( $customerComments as $customerComment ){
                    $result .= '<tr>
                        <td>'.$customerComment['employee_name'].'</td>
                        <td>'. Tools::displayDate($customerComment['date_created'], null) .'</td>
                        <td>'. $customerComment['message'] .'</td>
                    </tr>';
                }
                $result .= '</table>';
            }
            
            $result .= '<table >
              <tr>
                 <th width="80%">Produkte</th><th width="20%">Kommentare</th>
              </tr>';
            // prepare product details
            $warningQuantity = false;
            $detailsParts = []; //'<table class="products"><tr><th>Anzahl</th><th>Auf Lager</th><th>Shipped</th><th>Foto</th><th>Artikel</th><th>Artikelnummer</th></tr>';
            $details = '';
            
            
            foreach($order['products'] as $productI=>$product)
            {
                $contentRowsRendered++;
                if ($product['product_quantity']>1)
                {
                    $warningQuantity = true;
                }
                /*
                $heigth = '';
                if (count($detailsParts)==0 && count($order['products'])>6)
                {
                    if ($i==0)
                    {
                        $heigth = 'height="115px"';
                    }
                    else
                    {
                        $heigth = 'height="120px"';
                    }
                }*/
                $avForCur = $shippingProducts[$order['id_order']][$product['product_supplier_reference']]['avForCur'];
                $details .= '<tr><td '.($product['needToBeShipped']>1?'class="boldRed"':'').'>'.($product['needToBeShipped']).
                    '</td><td>'.($avForCur>0?'<span class="icon-check">&#xf00c;</span>':'<span class="icon-remove">&#xf00d;</span>').
                        '<br>Avail for ship: '.$avForCur.
                    '</td><td>'.($product['needToBeShipped']<=0?'<span class="icon-check">&#xf00c;</span>':'<span class="icon-remove">&#xf00d;</span>').
                    '</td><td><img height="134" src="//'.$link->getImageLink('aaa', $product['product_id'].'-'.$product['id_image'], 'cart_default').'"></td>'.
                    '<td>Phys. Bestand: '.$product['physical_quantity'].'<br>Verf. Bestand: '.$product['av_quantity'];
                if( !empty($product['product_note_public']) ){
                    $details .= '<br>Note public: '. $product['product_note_public'];
                }
                if( !empty($product['product_note_private']) ){
                    $details .= '<br>Interne Notiz: '. $product['product_note_private'];
                }
                
                /*
                 if(!empty($product['attribute_value']))
                 {
                 $result .= '<br>'.$product['attribute_name'].': '.$product['attribute_value'];
                 }
                */
            
                if(!empty($product['attribute_location']))
                {
                    $productLocation = ', '.$product['attribute_location'];
                }
                elseif(!empty($product['location']))
                {
                    $productLocation = ', '.$product['location'];
                }
                else
                {
                    $productLocation = '';
                }

                // deal with supplier reference highlight for summaty products
                $productId = $product['product_id'].'-'.$product['product_attribute_id'];
                
                if ($summaryProductsUnsorted[$productId]['product_quantity']>=self::ProductSummaryMinQty)
                {
                    $details .= '</td><td class="bold supplierReference summaryReference">';
                }
                else
                {
                    $details .= '</td><td class="bold supplierReference">';
                }
                $details .= $product['product_supplier_reference'].$productLocation.'</td></tr>';
                
                if( !empty($deliveryRequestInfoDetailed[ $order['id_order'] ][ $product['product_supplier_reference'] ]) ){
                    $contentRowsRendered++;
                    $details .= '<tr><td colspan="6" width="80%" style="font-size:10px;">'.
                        $deliveryRequestInfoDetailed[ $order['id_order'] ][ $product['product_supplier_reference'] ] .
                        '</td></tr>';
                }
                
                
                // less products in first page
                if ($contentRowsRendered==4 || $contentRowsRendered>7 && ($contentRowsRendered-4)%7 == 0)
                {
                    $detailsParts []= $details;
                    $details = '';
                }
            }
            
            if(count($order['products'])==0)
            {
                $detailsParts[0] = '<tr><td colspan="6"><em>There is no not shipped products in this order</em></td></tr>';
            }
            elseif(!empty ($details))
            {
                    $detailsParts []= $details;
            }
            
            // dealing with customer column class
            $customerColumnClass = '';
            if ($order['id_country'] != self::GermanyCountryId)
            {
                $customerColumnClass = 'class="boldRed"';
            }
            if ($warningQuantity)
            {
                $customerColumnClass = 'class="redBg"';
            }

            $result .=  '<tr><td style="font-size:14px;">
                <table class="products"><tr>
                    <th>Anzahl</th>
                    <th>Auf Lager</th>
                    <th>Versendet</th>
                    <th>Foto</th>
                    <th>Artikel</th>
                    <th>Artikelnummer</th>
                </tr>'.$detailsParts[0].'
                </table></td>
                <td>'.$order['messages'].'</td>
                </tr>'
            ;
            
            if (count($detailsParts)>1)
            {
                for($partsI=1; $partsI<count($detailsParts); $partsI++)
                {
                    $result .= '<tr><td style="font-size:14px;">
                        <table class="products"><tr>
                            <th>Anzahl</th>
                            <th>Auf Lager</th>
                            <th>Versendet</th>
                            <th>Foto</th>
                            <th>Artikel</th>
                            <th>Artikelnummer</th>
                        </tr>'.$detailsParts[$partsI].'</table></td>
                    <td>&nbsp;</td></tr>';
                }
            }
            $result .=  '</table>';
            /*
            if (!empty($dlvrReqInfo[$order['id_order']]))
            {
                $result .= '<br/> Produkt anforderungen für bestellnummer: '.$order['id_order'].'<br>'.$dlvrReqInfo[$order['id_order']];
            }
            */
        }

        // html is complete
        $result .=  '</body></html>';
        //echo $result;
        //exit;
        // generate pdf
        $pdfRenderer = new PDFGenerator((bool) Configuration::get('PS_PDF_USE_CACHE'), '','A4');
        $pdfRenderer->mpdf->use_kwt = true;
        $pdfRenderer->mpdf->setFooter('{PAGENO}');
        $pdfRenderer->createContent($result);
        $pdfRenderer->writePage();
        $pdfRenderer->render('shipping_info.pdf', 'D');
    }

    static function parseVdDeliveryRequestInfo($ordersDeliveryRequestInfo)
    {
        $ordersDeliveryRequestDetailed = array();
        $excludeValuesFromDelReqInfo = array(
            'CK Artikelnr.', 'Fälligkeitsdatum', 'Grund', 'Kommentare'
        );
        
        foreach( $ordersDeliveryRequestInfo as $orderId => $deliveryRequestInfo ){
            $ordersDeliveryRequestDetailed[ $orderId ] = array();
            
            if( !preg_match('#<thead>.*</thead>#is', $deliveryRequestInfo, $htmlHeaderMatch) ){
                continue;
            }
            $htmlHeader = $htmlHeaderMatch[0];
            
            $fieldNames = explode('</th>', $htmlHeader);
            array_pop($fieldNames);
            foreach($fieldNames as &$fieldName){
                $fieldName = trim(strip_tags($fieldName));
            }
            unset($fieldName);

            if( !preg_match('#<tbody>.*</tbody>#is', $deliveryRequestInfo, $htmlBodyMatch) ){
                continue;
            }
            $htmlBody = $htmlBodyMatch[0];
            
            $htmlBody = str_replace('</tr>', '</tr><!--SPLITTER-->', $htmlBody);
            $htmlBodyParts = explode('<!--SPLITTER-->', $htmlBody);
            
            if( !is_array($htmlBodyParts) ){
                continue;
            }
            
            foreach( $htmlBodyParts as $bodyPart ){
                $splRefMatch = array();
                if( !preg_match('#<td class="ps_sku">([^<]+)</td>#', $bodyPart, $splRefMatch) ){
                    continue;
                }
                
                $fieldValues = explode('</td>', $bodyPart);
                array_pop($fieldValues);
                foreach($fieldValues as &$fieldValue){
                    $fieldValue = strip_tags($fieldValue, '<br>');
                }
                unset($fieldValue);
                
                $newTableHtml = '<ul >';
                for( $ti = 0; $ti < count($fieldNames); $ti++  ){
                    if( in_array($fieldNames[$ti], $excludeValuesFromDelReqInfo) ){
                        // skip this value
                        continue;
                    }
                    
                    if( $fieldNames[$ti] == 'Status' ){
                        $fieldValues[$ti] = str_replace('Datum', 'Lieferdatum: ', $fieldValues[$ti]);
                    }
                    
                    $newTableHtml .= '<li>'. $fieldNames[$ti] .' : '. $fieldValues[$ti] .'</li>';
                }
                $newTableHtml .= '</ul>';
                
                $ordersDeliveryRequestDetailed[ $orderId ][ $splRefMatch[1] ] = $newTableHtml;
            }
        }
        
        return $ordersDeliveryRequestDetailed;
    }
    
    /**
     * @returns information about not shipped orders products 
     */
    static function &getProductsInfo($orderId, $skuList=[])
    {
        $db = Db::getInstance();
        $sql = 'select distinct(id_order_detail), od.product_name, od.product_quantity, od.product_price, od.product_id, od.shipped, '
                . 'i.id_image, p.location,'.
        'ps.product_supplier_reference, od.in_stock as quantity_in_stock, pa.location as attribute_location, od.product_attribute_id,'.
                'sa.quantity as av_quantity, sa.physical_quantity, (cast(product_quantity as signed) - cast(product_quantity_return as signed) '.
                '- cast(product_quantity_refunded as signed) - cast(od.shipped as signed)) as needToBeShipped, 
                 od.note AS product_note_public, od.note_private AS product_note_private
            from '._DB_PREFIX_.'order_detail od left join '._DB_PREFIX_.'product p on od.product_id = p.id_product left join '.
            _DB_PREFIX_.'product_attribute pa on od.product_attribute_id=pa.id_product_attribute '.
            'left join '._DB_PREFIX_.'image i on (i.`id_product` = od.product_id AND i.`cover`= 1) '.
            'left join '._DB_PREFIX_.'product_supplier ps on ps.id_product = od.product_id AND ps.id_product_attribute=od.product_attribute_id '.
            'left join '._DB_PREFIX_.'stock_available sa on sa.id_product=od.product_id and od.product_attribute_id=sa.id_product_attribute'.
            ' where od.id_order='.$orderId.' and product_quantity>product_quantity_return+product_quantity_refunded and od.shipped < '.
                'product_quantity - product_quantity_return - product_quantity_refunded';
        if (count($skuList))
        {
            array_walk($skuList, function (&$value){ $value = '\''.addslashes($value).'\''; });
            $sql .= ' and od.product_supplier_reference in ('.implode(',', $skuList).')';
        }
        /* al.name as attribute_value, agl.public_name as attribute_name
           _DB_PREFIX_.'product_attribute_combination pac on(od.product_attribute_id = pac.id_product_attribute) '.
            'left join '._DB_PREFIX_.'attribute a on (pac.id_attribute = a.id_attribute) '.
            'left join '._DB_PREFIX_.'attribute_lang al on(pac.id_attribute=al.id_attribute and al.id_lang=3) '.
            'left join '._DB_PREFIX_.'attribute_group_lang agl on (agl.id_lang=3 and a.id_attribute_group=agl.id_attribute_group) '.
         */
        //echo $sql;
        $products = $db->s($sql);

        return $products;
    }


    static function calculateOrderWeight(&$order)
    {
        // express go first
        if (in_array($order['id_carrier'], ShippingExporter::$dhlExpressCarrierIds))
        {
            return 100;
        }

        // not germany orders second
        if ($order['id_country']!=ShippingExporter::GermanyCountryId)
        {
            return 90;
        }

        // dhl orders third
        if (self::isDhlOrder($order))
        {
            return 80;
        }

        return 0;
    }
    
    /**
     * Sorts orders array, makes DHL express orders go firt, makes germany
     * orders go first.
     */
    static function sortOrders(&$orders)
    {
        usort($orders, function($order1, $order2){

                // calculate orders weights and compare order by them
                $weight1 = ShippingExporter::calculateOrderWeight($order1);
                $weight2 = ShippingExporter::calculateOrderWeight($order2);
                if ($weight1==$weight2)
                {
                    if($order1['id_order']<$order2['id_order'])
                    {
                        return -1;
                    }
                    else
                    {
                        return 1;
                    }
                }
                elseif ($weight1 > $weight2)
                {
                    return -1;
                }
                else
                {
                    return 1;
                }
              });
    }


    /**
     * Prepares field to be palced in csv row. Adds quotes to it
     */
    static function encodeField($field)
    {
        $field = str_replace(array("\r", "\n"), array('\r', '\n'), $field);
        return $field;
    }


    static function isEUZoneId($zoneId)
    {
        return $zoneId == self::DEZoneId || $zoneId == self::EUZoneId;
    }
    
    
    /**
     * Sends request to vipdress (central store) and returns list of order ids that can be shipped right now
     * @return array with order ids
     */
    function getShippingPossibleOrdersList()
    {
        if ($_SERVER["HTTP_HOST"] == 'dmitri.wheel')
        {
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            $reqUrl = 'https://dmitri.wheel/vipdress.de1/admin123/index_service.php/dbk_ext_shop_delivery/get_shipping_possible_orders';
            $orderIds = file_get_contents($reqUrl, false, stream_context_create($arrContextOptions));
        }
        elseif ($_SERVER["HTTP_HOST"] == 'nsweb.server')
        {
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            $reqUrl = 'http://nsweb.server/vipdress/admin123/index_service.php/dbk_ext_shop_delivery/get_shipping_possible_orders';
            $orderIds = file_get_contents($reqUrl, false, stream_context_create($arrContextOptions));
        }
        else
        {
            $reqUrl = 'https://www.vipdress.de/admin123/index_service.php/dbk_ext_shop_delivery/get_shipping_possible_orders';
            $orderIds = file_get_contents($reqUrl);
        }
        return json_decode($orderIds, true);
    }
    
    /**
     * 
     * @param type $orderIds if given smart shipping list will be generated only based on given orders
     */
    function getSmartShippingList($orderIds=false)
    {
        if ($orderIds && count($orderIds))
        {
            $sql = 'select o.id_order, o.id_carrier, o.id_customer, ad.firstname, ad.lastname, ad.address1, o.date_add, ' .
                    'ad.address2, ad.company, ad.postcode, ad.city, ad.other, c.email, c.credit_limit, 
                group_concat(distinct m.message separator \'<hr>\n\') as messages,
                    (SELECT SUM(oi1.sum_to_pay) 
                        FROM `' . _DB_PREFIX_ . 'order_invoice` oi1
                        INNER JOIN `' . _DB_PREFIX_ . 'orders` o1 ON o1.id_order = oi1.id_order
                        INNER JOIN `' . _DB_PREFIX_ . 'ba_prestashop_invoice` bai1 
                            ON oi1.template_id = bai1.id 
                            AND bai1.payment_type != ' . (BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP) . '
                        WHERE 
                            o1.id_customer = o.id_customer
                            AND oi1.number > 0
                            AND oi1.paid = 0
                            AND o1.current_state != ' . intval(Configuration::get('PS_OS_CANCELED')) . '
                        ) as 
                unpaid_amount, c.company AS customer_company, ' .
                    'ad.id_country, cr.name as carrier_name, country.name as country_name from ' . _DB_PREFIX_ . 'orders o ' .
                    'LEFT JOIN `' . _DB_PREFIX_ . 'customer` c ON (c.`id_customer` = o.`id_customer`)
                left join ' . _DB_PREFIX_ . 'carrier cr on o.id_carrier=cr.id_carrier
                left join ' . _DB_PREFIX_ . 'message m on m.id_order=o.id_order

                INNER JOIN `' . _DB_PREFIX_ . 'order_detail` ns_od ON ns_od.id_order = o.id_order
                LEFT JOIN `' . _DB_PREFIX_ . 'order_invoice` i3p_oi ON i3p_oi.id_order = o.id_order
                LEFT JOIN `' . _DB_PREFIX_ . 'ba_prestashop_invoice` i3p_bai ON i3p_bai.id = i3p_oi.template_id, ' .
                    _DB_PREFIX_ . 'address ad, ' . _DB_PREFIX_ . 'country_lang country ' .
                    'where id_address_delivery=ad.id_address and ad.id_country=country.id_country and country.id_lang=' .
                    Configuration::get('PS_LANG_DEFAULT') . ' group by o.id_order order by c.id_customer';

            $listOrders = Db::getInstance()->ExecuteS($sql);
        }
        else
        {
            // reading ids of orders that can be shipped from payment point of view
            $overduedRemindersSubquery = '
            SELECT id_customer
            FROM ' . _DB_PREFIX_ . 'order_invoice oi2
            INNER JOIN ' . _DB_PREFIX_ . 'orders o2 ON o2.id_order=oi2.id_order
            INNER JOIN `' . _DB_PREFIX_ . 'ba_prestashop_invoice` bai2 
                ON oi2.template_id = bai2.id 
                    AND bai2.payment_type != ' . (BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP) . '
            WHERE oi2.paid = 0
                AND oi2.number > 0
                AND o2.current_state != ' . intval(Configuration::get('PS_OS_CANCELED')) . '
                AND (
                    (oi2.due_date > 0 AND oi2.due_date < NOW()) 
                    OR
                    (oi2.reminder_state BETWEEN ' . OrderInvoice::Reminder1Sent . ' AND ' . OrderInvoice::Reminder3Sent . ')
                )
            GROUP BY o2.id_customer
        ';
            // o.id_cart, o.payment, o.module,
            $sql = 'select o.id_order, o.id_carrier, o.id_customer, ad.firstname, ad.lastname, ad.address1, o.date_add, ' .
                    'ad.address2, ad.company, ad.postcode, ad.city, ad.other, c.email, c.credit_limit, 
                group_concat(distinct m.message separator \'<hr>\n\') as messages,
                    (SELECT SUM(oi1.sum_to_pay) 
                        FROM `' . _DB_PREFIX_ . 'order_invoice` oi1
                        INNER JOIN `' . _DB_PREFIX_ . 'orders` o1 ON o1.id_order = oi1.id_order
                        INNER JOIN `' . _DB_PREFIX_ . 'ba_prestashop_invoice` bai1 
                            ON oi1.template_id = bai1.id 
                            AND bai1.payment_type != ' . (BaOrderInvoice::PAYMENT_TYPE_CREDIT_SLIP) . '
                        WHERE 
                            o1.id_customer = o.id_customer
                            AND oi1.number > 0
                            AND oi1.paid = 0
                            AND o1.current_state != ' . intval(Configuration::get('PS_OS_CANCELED')) . '
                        ) as 
                unpaid_amount, c.company AS customer_company, ' .
                    'ad.id_country, cr.name as carrier_name, country.name as country_name from ' . _DB_PREFIX_ . 'orders o ' .
                    'LEFT JOIN `' . _DB_PREFIX_ . 'customer` c ON (c.`id_customer` = o.`id_customer`)
                left join ' . _DB_PREFIX_ . 'carrier cr on o.id_carrier=cr.id_carrier
                left join ' . _DB_PREFIX_ . 'message m on m.id_order=o.id_order

                INNER JOIN `' . _DB_PREFIX_ . 'order_detail` ns_od ON ns_od.id_order = o.id_order
                LEFT JOIN `' . _DB_PREFIX_ . 'order_invoice` i3p_oi ON i3p_oi.id_order = o.id_order
                LEFT JOIN `' . _DB_PREFIX_ . 'ba_prestashop_invoice` i3p_bai ON i3p_bai.id = i3p_oi.template_id, ' .
                    _DB_PREFIX_ . 'address ad, ' . _DB_PREFIX_ . 'country_lang country ' .
                    'where id_address_delivery=ad.id_address and ad.id_country=country.id_country and country.id_lang=' .
                    Configuration::get('PS_LANG_DEFAULT') . ' and o.id_customer not in(' . $overduedRemindersSubquery .
                    ') and o.id_customer not in (SELECT o3.id_customer FROM ' . _DB_PREFIX_ . 'order_invoice oi3 LEFT JOIN ' .
                    _DB_PREFIX_ . 'orders o3 ON o3.id_order = oi3.id_order WHERE oi3.reminder_state = ' . OrderInvoice::ReminderInkasso .
                    ' AND oi3.paid = 0 GROUP BY o3.id_customer) 
                and o.current_state not in (15, 18, 19, 16, 42, ' . intval(Configuration::get('PS_OS_CANCELED')) . ')    
                AND ns_od.shipped < (ns_od.product_quantity - ns_od.product_quantity_refunded - ns_od.product_quantity_return - ns_od.product_quantity_reinjected)
                AND ( (i3p_bai.payment_type IN (' . BaOrderInvoice::PAYMENT_TYPE_30 . ',' . (BaOrderInvoice::PAYMENT_TYPE_PREPAY) . ') AND i3p_oi.paid = 1)
                    OR c.ship_by_invoice = 1 ) group by o.id_order
                having unpaid_amount<c.credit_limit order by c.id_customer';

            $listOrders = Db::getInstance()->ExecuteS($sql);
            $orderIds = [];
            foreach ($listOrders as $row)
            {
                $orderIds [] = $row['id_order'];
            }
        }

        $shippingProducts = [];
        // select orders that can be shipped from shipping priority and stock state point of view (among good from payment point of view)
        if (count($orderIds))
        {
            $opts = [];

            if ($_SERVER["HTTP_HOST"] == 'dmitri.wheel')
            {
                $opts['ssl'] = array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                );
                
                $url = 'https://dmitri.wheel/vipdress.de1/admin123/index_service.php/dbk_ext_shop_delivery/get_shipping_list_koehlert';
                
                $dlvrReqUrl = 'https://dmitri.wheel/vipdress.de1/admin123/index_service.php/dbk_ext_shop_delivery/get_dlvr_req_info2/' .
                    Configuration::get('MSSS_CLIENT_SOURCE_ID') . '?orderIds[]=' . implode('&orderIds[]=', $orderIds);
            }
            elseif ($_SERVER["HTTP_HOST"] == 'nsweb.server')
            {
                $opts['ssl'] = array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                );

                $url = 'http://nsweb.server/vipdress/admin123/index_service.php/dbk_ext_shop_delivery/get_shipping_list_koehlert';
            }
            else
            {
                $url = 'https://www.vipdress.de/admin123/index_service.php/dbk_ext_shop_delivery/get_shipping_list_koehlert';
            }
            
            // reading delivery requests info
            $dlvrReqInfo = file_get_contents($dlvrReqUrl, false, stream_context_create($opts));
            $dlvrReqInfo = json_decode($dlvrReqInfo, true);
        
            $deliveryRequestInfoDetailed = self::parseVdDeliveryRequestInfo($dlvrReqInfo);
            //print_r($deliveryRequestInfoDetailed);

            // reading items that can be shipped
            $postdata = http_build_query(
                    array(
                        'order_ids' => $orderIds,
                    )
            );

            $opts['http'] =
                array(
                    'method' => 'POST',
                    'header' => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => $postdata
                );
            $context = stream_context_create($opts);

            $result = file_get_contents($url, false, $context);
            $shippingProducts = json_decode($result, true);
        }
        
        if (!empty($_REQUEST['dbg11']))
        {
            echo $result;
        }
        
        // generating html shipping list
        // table header
        $result = '<html>
              <head>
              <link href="themes/default/css/admin-theme.css" rel="stylesheet" type="text/css">
              <style type="text/css" media="all">
               * {font-size: 16px;}
               body{background-color: #fff;}
               .icon-check {color: #72C279; font-family: fontawesome; }
               .icon-remove {color: #E08F95; font-family: fontawesome;}
               table {border-collapse: collapse; border:1px solid black}
               table th {background-color: #ccc;} 
               table td {border: 1px solid black; padding:10px; border-spacing:0px}
               table.products {border: none;}
               table.products td {border: none; padding:3px;}
               .bold { font-weight: bold;}
               .boldRed { font-weight: bold; color:red }
               .redBg {background-color: red;}
               .supplierReference{}
                .summaryReference{color: red}
              </style>
              </head>
              <body>';
        
        if (count($shippingProducts))
        {
            //show summary products list
            $link = new Link();

            $result .= '<h1>Bestellungen:</h1>';
            $firstOrder = true;
            foreach ($listOrders as $order)
            {
                // filter orders by returned products that can be shipped
                if (!isset($shippingProducts[$order['id_order']]))
                {
                    continue;
                }
                
                if (!$firstOrder)
                {
                    $result .= '<pagebreak />';
                }
                $firstOrder = false;

                $result .= '<h2>' . $order['customer_company'] . ', ' . $order['country_name'] . '</h2>';

                $result .= 'Credit limit: '.Tools::displayPrice($order['unpaid_amount']).' / '.
                        Tools::displayPrice($order['credit_limit']).'<br>';
                
                if (in_array($order['id_carrier'], self::$dhlExpressCarrierIds))
                {
                    $carrier = '<span class="boldRed">' . $order['carrier_name'] . '</span>';
                }
                else
                {
                    $carrier = $order['carrier_name'];
                }

                $qrCodeImageName = uniqid() . '.png';
                $qrCodeImagePath = _PS_TMP_IMG_DIR_ . $qrCodeImageName;
                $qrCodeImageUrl = _PS_TMP_IMG_ . $qrCodeImageName;
                QRcode::png($order['id_order'], $qrCodeImagePath, QR_ECLEVEL_H, 2, 4);

                $result .= '
                <table width="100%" class="products"><tr><td width="50%">
                Bestellnummer: ' . $order['id_order'] . '<br/>' . $carrier . '<br>'.
                        'Order date: '.Tools::displayDate($order['date_add']).
                        '</td>' .
                        '<td width="50%" style="text-align:right"><img src="' . $qrCodeImageUrl . '" /></td></tr></table>';

                $contentRowsRendered = -1;
                $customerComments = ShopComment::getCustomerComments($order['id_customer'], 1);
                if (is_array($customerComments) && count($customerComments))
                {
                    $contentRowsRendered++;
                    $result .= '<table>';
                    foreach ($customerComments as $customerComment)
                    {
                        $result .= '<tr>
                        <td>' . $customerComment['employee_name'] . '</td>
                        <td>' . Tools::displayDate($customerComment['date_created'], null) . '</td>
                        <td>' . $customerComment['message'] . '</td>
                    </tr>';
                    }
                    $result .= '</table>';
                }

                // show order messages
                $orderMessages = Message::getMessagesByOrderId($order['id_order'], true);
                if (is_array($orderMessages) && count($orderMessages))
                {
                    $contentRowsRendered++;
                    $result .= '<table>';
                    foreach ($orderMessages as $orderMessage)
                    {
                        $result .= '<tr>';
                        if ($orderMessage['id_employee'])
                        {
                            $result .= '<td>'.$orderMessage['efirstname'].' '.$orderMessage['elastname'].($orderMessage['private']?' - private':'').'</td>';
                        }
                        else
                        {
                            $result .= '<td>'.$orderMessage['cfirstname'].' '.$orderMessage['clastname'].'</td>';
                        }
                        $result .= '<td>' . Tools::displayDate($orderMessage['date_add'], null) . '</td>
                        <td>' . $orderMessage['message'] . '</td>
                    </tr>';
                    }
                    $result .= '</table>';
                }
                
                $result .= '<table >
              <tr>
                 <th width="80%">Produkte</th><th width="20%">Kommentare</th>
              </tr>';
                // prepare product details
                $warningQuantity = false;
                $detailsParts = []; 
                $details = '';
                
                $products = self::getProductsInfo($order['id_order'], array_keys($shippingProducts[$order['id_order']]));
                foreach ($products as $product)
                {
                    $contentRowsRendered++;
                    if ($product['product_quantity'] > 1)
                    {
                        $warningQuantity = true;
                    }
                    /*
                      $heigth = '';
                      if (count($detailsParts)==0 && count($order['products'])>6)
                      {
                      if ($i==0)
                      {
                      $heigth = 'height="115px"';
                      }
                      else
                      {
                      $heigth = 'height="120px"';
                      }
                      } */
                    $avForCur = $shippingProducts[$order['id_order']][$product['product_supplier_reference']]['avForCur'];
                    $details .= '<tr><td ' . ($product['needToBeShipped'] > 1 ? 'class="boldRed"' : '') . '>' . 
                            $product['product_quantity'].'/'.$product['shipped'].
                            '</td><td>' .($avForCur>$product['needToBeShipped']?$product['needToBeShipped']:$avForCur).
                            '</td><td><img height="134" src="//' . $link->getImageLink('aaa', $product['product_id'] . '-' . $product['id_image'], 'cart_default') . '"></td>' .
                            '<td>Phys. Bestand: ' . $product['physical_quantity'] . '<br>Verf. Bestand: ' . $product['av_quantity'];
                    if (!empty($product['product_note_public']))
                    {
                        $details .= '<br>Note public: ' . $product['product_note_public'];
                    }
                    if (!empty($product['product_note_private']))
                    {
                        $details .= '<br>Interne Notiz: ' . $product['product_note_private'];
                    }

                    /*
                      if(!empty($product['attribute_value']))
                      {
                      $result .= '<br>'.$product['attribute_name'].': '.$product['attribute_value'];
                      }
                     */

                    if (!empty($product['attribute_location']))
                    {
                        $productLocation = ', ' . $product['attribute_location'];
                    }
                    elseif (!empty($product['location']))
                    {
                        $productLocation = ', ' . $product['location'];
                    }
                    else
                    {
                        $productLocation = '';
                    }

                    // deal with supplier reference highlight for summaty products
                    $productId = $product['product_id'] . '-' . $product['product_attribute_id'];

                    if ($summaryProductsUnsorted[$productId]['product_quantity'] >= self::ProductSummaryMinQty)
                    {
                        $details .= '</td><td class="bold supplierReference summaryReference">';
                    }
                    else
                    {
                        $details .= '</td><td class="bold supplierReference">';
                    }
                    $details .= $product['product_supplier_reference'] . $productLocation . '</td></tr>';

                    if (!empty($deliveryRequestInfoDetailed[$order['id_order']][$product['product_supplier_reference']]))
                    {
                        $contentRowsRendered++;
                        $details .= '<tr><td colspan="6" width="80%" style="font-size:10px;">' .
                                $deliveryRequestInfoDetailed[$order['id_order']][$product['product_supplier_reference']] .
                                '</td></tr>';
                    }


                    // less products in first page
                    if ($contentRowsRendered == 4 || $contentRowsRendered > 7 && ($contentRowsRendered - 4) % 7 == 0)
                    {
                        $detailsParts [] = $details;
                        $details = '';
                    }
                }

                if (count($products) == 0)
                {
                    $detailsParts[0] = '<tr><td colspan="6"><em>There is no not shipped products in this order</em></td></tr>';
                }
                elseif (!empty($details))
                {
                    $detailsParts [] = $details;
                }

                // dealing with customer column class
                $customerColumnClass = '';
                if ($ordersData[$orderId]['id_country'] != self::GermanyCountryId)
                {
                    $customerColumnClass = 'class="boldRed"';
                }
                if ($warningQuantity)
                {
                    $customerColumnClass = 'class="redBg"';
                }

                $result .= '<tr><td style="font-size:14px;">
                <table class="products"><tr>
                    <th>Bestellt/Versendet&nbsp;</th>
                    <th>Jetzt versendbar</th>
                    <th>Foto</th>
                    <th>Artikel</th>
                    <th>Artikelnummer</th>
                </tr>' . $detailsParts[0] . '
                </table></td>
                <td>' . $order['messages'] . '</td>
                </tr>'
                ;

                if (count($detailsParts) > 1)
                {
                    for ($partsI = 1; $partsI < count($detailsParts); $partsI++)
                    {
                        $result .= '<tr><td style="font-size:14px;">
                        <table class="products"><tr>
                            <th>Bestellt/Versendet&nbsp;</th>
                            <th>Jetzt versendbar</th>
                            <th>Foto</th>
                            <th>Artikel</th>
                            <th>Artikelnummer</th>
                        </tr>' . $detailsParts[$partsI] . '</table></td>
                    <td>&nbsp;</td></tr>';
                    }
                }
                $result .= '</table>';
            }
        }
        else
        {
            $result .= 'No products can be shipped now';
        }

        // html is complete
        $result .=  '</body></html>';
        if (!empty($_REQUEST['dbg11']))
        {
            echo $result;
            exit;
        }
        // generate pdf
        $pdfRenderer = new PDFGenerator((bool) Configuration::get('PS_PDF_USE_CACHE'), '','A4');
        $pdfRenderer->mpdf->use_kwt = true;
        $pdfRenderer->mpdf->setFooter('{PAGENO}');
        $pdfRenderer->createContent($result);
        $pdfRenderer->writePage();
        $pdfRenderer->render('smart_shipping_list.pdf', 'D');
    }
}

