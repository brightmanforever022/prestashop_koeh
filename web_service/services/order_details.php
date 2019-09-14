<?php

function getOrderDetails() {
    global $conn;
    $sql = 'select id_order,od.id_customer,od.total_products,od.total_products_wt,od.total_shipping,c.firstname as c_firstname,c.lastname as c_lastname,Concat(c.firstname,c.lastname) as CsName,ad.company as d_company,ad.firstname as d_first_name,ad.lastname as d_last_name,ad.vat_number as d_vat_number,ad.address1 as d_address1,ad.postcode as d_postcode,ad.city as d_city,col.name as d_name,ad.phone as d_phone,ad.phone_mobile as d_phone_mobile,ad1.company as i_company,ad1.firstname as i_first_name,ad1.lastname as i_last_name,ad1.vat_number as i_vat_number,ad1.address1 as i_address1,ad1.postcode as i_postcode,ad1.city as i_city,col1.name as i_name,ad1.phone as i_phone,ad1.phone_mobile as i_phone_mobile from ' . _DB_PREFIX_ . 'orders as od left join ' . _DB_PREFIX_ . 'customer c on c.id_customer=od.id_customer left join ' . _DB_PREFIX_ . 'address as ad on od.id_address_delivery=ad.id_address left join ' . _DB_PREFIX_ . 'country_lang as col on col.id_country=ad.id_country and col.id_lang = 2 left join ' . _DB_PREFIX_ . 'address as ad1 on od.id_address_invoice=ad1.id_address left join ' . _DB_PREFIX_ . 'country_lang as col1 on col1.id_country=ad1.id_country and col1.id_lang = ' . $_POST['lang_id'] . ' inner join ' . _DB_PREFIX_ . 'cart_product as cp on od.id_cart=cp.id_cart inner join ' . _DB_PREFIX_ . 'product as p on cp.id_product=p.id_product where od.id_order = ' . $_POST['id_order'] . ' group by od.id_order';


    $sqlorderHistory = 'SELECT * FROM ' . _DB_PREFIX_ . 'order_history as oh left join ' . _DB_PREFIX_ .
            'employee as pe on oh.id_employee=pe.id_employee left join ' . _DB_PREFIX_ .
            'order_state_lang as osl on oh.id_order_state=osl.id_order_state WHERE osl.id_lang = 2 and oh.id_order = ' . (int) $_POST['id_order'] . ' order by oh.id_order_history DESC';
    $historyresult = $conn->query($sqlorderHistory);

    $sqlorderPdt = 'SELECT od.*,i.id_image FROM `' . _DB_PREFIX_ . 'order_detail` od left join ' . _DB_PREFIX_ .
            'image i on i.id_product=od.product_id and cover=1 left join ' . _DB_PREFIX_ . 'product_lang pl on pl.id_product=od.product_id  WHERE `id_order` = ' . (int) $_POST['id_order'] . ' and pl.id_lang=' . $_POST['lang_id'];
    $completeSql = $sql;
    $result = $conn->query($completeSql);
    $pdtresult = $conn->query($sqlorderPdt);
    $row = $result->fetch_assoc();

    $orders = array();
    $products = array();
    if (!empty($row)) {
        // output data of each row
        $total_tax = $row['total_products_wt'] - $row['total_products'];
        $total_org = $row['total_shipping'] + $row['total_products'] + $total_tax;
		setlocale(LC_MONETARY, 'de_DE.UTF-8');
        $message = 'Order Details';
        $status = true;
        $orders['id'] = $row['id_order'];
        $orders['total_shipping'] = money_format('%.2n', $row['total_shipping']);
        $orders['total_products'] = money_format('%.2n', $row['total_products']);
        $orders['tax'] = money_format('%.2n', $total_tax);
        $orders['total'] = money_format('%.2n', $total_org);
        $orders['id_employee'] = utf8_encode($row['id_customer']);
        $orders['customer'] = utf8_encode($row['c_firstname'] . ' ' . $row['c_lastname']);
        $orders['address_delivery'] = utf8_encode($row['d_company'] . '<br/>' . $row['d_first_name'] . ' ' . $row['d_last_name'] . '<br/>' . $row['d_vat_number'] . '<br/>' . $row['d_address1'] . '<br/>' . $row['d_postcode'] . ' ' . $row['d_city'] . '<br/>' . $row['d_name'] . '<br/>' . $row['d_phone'] . '<br/>' . $row['d_phone_mobile']);
        $orders['address_invoice'] = utf8_encode($row['i_company'] . '<br/>' . $row['i_first_name'] . ' ' . $row['i_last_name'] . '<br/>' . $row['i_vat_number'] . '<br/>' . $row['i_address1'] . '<br/>' . $row['i_postcode'] . ' ' . $row['i_city'] . '<br/>' . $row['i_name'] . '<br/>' . $row['i_phone'] . '<br/>' . $row['i_phone_mobile']);
        if ($historyresult->num_rows > 0) {
            // output data of each row
            $message = $historyresult->num_rows . ' historyresult';
            $status = true;
            $cnt = 0;
            while ($rowhistory = $historyresult->fetch_assoc()) {
                $orders['order_state'][$cnt]['name'] = utf8_encode($rowhistory['name']);
                $orders['order_state'][$cnt]['employee'] = utf8_encode($rowhistory['firstname'] . ' ' . $rowhistory['lastname']);
                $orders['order_state'][$cnt]['dateadd'] = utf8_encode($rowhistory['date_add']);
                $cnt++;
            }
        }
        //$orders['order_state'] = (!empty($historyRows)?utf8_encode($historyRows['name']):'-');
        if ($pdtresult->num_rows > 0) {
            // output data of each row
            $message = $pdtresult->num_rows . ' products';
            $status = true;
            $num = 0;
            while ($rowPdt = $pdtresult->fetch_assoc()) {
                $products[$num]['id'] = $rowPdt['id'];
                $products[$num]['name'] = utf8_encode($rowPdt['product_supplier_reference']);
                $products[$num]['photo'] = _BASE_ . "/img/p/" . $rowPdt['id_image'] . '-large_default.jpg';
                $products[$num]['in_stock'] = $rowPdt['in_stock'];
                $products[$num]['is_shipped'] = $rowPdt['shipped'];
                $products[$num]['unit_price'] = money_format('%.2n', $rowPdt['unit_price_tax_excl']);
                $products[$num]['order_qty'] = $rowPdt['product_quantity'];
                $sqlavailable_qty = 'SELECT * FROM `' . _DB_PREFIX_ . 'stock_available` WHERE `id_product` = ' . (int) $rowPdt['product_id'] . ' and id_product_attribute =' . (int) $rowPdt['product_attribute_id'];
                $sqlavailableresult = $conn->query($sqlavailable_qty);
                $availablerow = $sqlavailableresult->fetch_assoc();
                $products[$num]['available_qty'] = $availablerow['quantity'];
                $products[$num]['total_price'] =  money_format('%.2n', $rowPdt['original_product_price']);

                $num++;
            }
        } else {
            $message = 'No Product Found.';
            $status = false;
        }
    } else {
        $message = 'No Order Found.';
        $status = false;
    }

    $conn->close();
//$data = array();
    $output1['status'] = $status;
    $output1['message'] = $message;
    $output1['orders'] = $orders;
    $output1['products'] = $products;
    return $output1;
}
