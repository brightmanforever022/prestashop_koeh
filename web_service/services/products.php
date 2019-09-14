<?php

function getProducts() {
    global $conn;
    $selShopId = 1;
    $output = array(
        'status' => false,
        'message' => '',
        'data' => array()
    );

    if (!empty($_POST['shop_id'])) {
        $selShopId = intval($_POST['shop_id']);
    }

    $customerId = null;
    if( !empty($_POST['customer_id']) ){
        $customerId = intval($_POST['customer_id']);
    }

    $sql = '
        select SQL_CALC_FOUND_ROWS p.*, ifnull(pa.supplier_reference, p.supplier_reference) as ps_sku, 
            i.id_image, pl.name, p.price, ps.name as supplier_name,p.id_supplier, 
            ifnull(pa.quantity, p.quantity) as ps_quantity, pa.ean13, p.stock_clearance
        from ' . _DB_PREFIX_ . 'product p 
        left join ' . _DB_PREFIX_ . 'product_attribute pa on pa.id_product=p.id_product 
        left join ' . _DB_PREFIX_ . 'image i on i.id_product=p.id_product and cover=1 
        left join ' . _DB_PREFIX_ . 'supplier ps on ps.id_supplier=p.id_supplier 
        left join ' . _DB_PREFIX_ . 'product_lang pl on pl.id_product=p.id_product 
        LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_combination` pac1 ON (pa.`id_product_attribute` = pac1.`id_product_attribute`) 
        LEFT JOIN `' . _DB_PREFIX_ . 'attribute_lang` pas1 ON (pas1.`id_attribute` = pac1.`id_attribute`) 
        LEFT JOIN `' . _DB_PREFIX_ . 'stock_available` past ON (pa.`id_product_attribute` = past.`id_product_attribute`) and pl.id_lang=' . $_POST['lang_id'] . ' 
        where 1
    ';


    if (isset($_POST['active'])) {
        $sql .= ' and p.active = ' . intval($_POST['active']);
    }
    if (isset($_POST['product_id']) && $_POST['product_id'] != 0) {
        $sql .= ' and p.id_product = ' . intval($_POST['product_id']);
    }

    if (!empty($_POST['supplier_id'])) {
        $sql .= ' and p.id_supplier = ' . intval($_POST['supplier_id']);
    }
    if (!empty($_POST['attr_id']) && is_array($_POST['attr_id']) && count($_POST['attr_id'])) {
        // check glued attr ids
        $attrIds = [];
        foreach ($_POST['attr_id'] as $attrId) {
            $ids = explode('_', $attrId);
            if( count($ids) > 1 ){
                $attrIds = array_merge($attrIds, $ids);
            }
        }

        // add table to filter by
        /* $sql = substr_replace($sql, ' inner join '._DB_PREFIX_.
          'product_attribute_combination pac on pac.id_product_attribute=pa.id_product_attribute ', strrpos($sql, 'where'), 0); */
        if( count($attrIds) ){
            $sql .= ' and pas1.id_attribute IN(' . implode(',', $attrIds) . ') AND past.quantity > 0';
        }
    }
    if (!empty($_POST['price'])) {
        $sql .= ' and p.price = ' . intval($_POST['price']);
    }

    if (!empty($_POST['ps_sku'])) {
        $sql .= " and ifnull(pa.supplier_reference, p.supplier_reference) Like  '%" . $_POST['ps_sku'] . "%'";
    }
    
    if(!empty($_POST['ean'])){
        if( $_POST['ean'] == '4250781849978' ){
            $output['status'] = false;
            $output['message'] = 'Invalid (dummy) ean code';
            $output['data'] = array();
            return $output;
            
        }
        $sql .= ' 
            AND (p.ean13 = "'. $conn->real_escape_string($_POST['ean']) .'" 
                OR pa.ean13 = "'. $conn->real_escape_string($_POST['ean']) .'" )
        ';
    }
    
    $sql .= ' group by p.id_product';
    if (!empty($_POST['perPage']) && $_POST['perPage'] != -1) {
        if (!empty($_POST['page']) && $_POST['page'] > 1) {
            // add paginationproduct_id
            $sql .= ' limit ' . ($_POST['page'] - 1) * $_POST['perPage'] . ',' . $_POST['perPage'];
        } else {
            $sql .= ' limit ' . $_POST['perPage'];
        }
    } 


    $completeSql = $sql;
    $result = $conn->query($completeSql);
    if( $result === false ){
        $output['status'] = false;
        $output['message'] = 'Internal error. Please notify admin';
        $output['_error_private'] = $conn->error;
        return $output;
    }


    $products = array();
    if ($result->num_rows > 0) {
        // output data of each row
        $message = $result->num_rows . ' products';
        $status = true;
        $num = 0;
        while ($row = $result->fetch_assoc()) {

            $id_product = 1; //set your product ID here
            $image = Image::getCover($row['id_product']);
            $product = new Product($row['id_product'], false, Context::getContext()->language->id);
            $link = new Link; //because getImageLInk is not static function
            $imagePath = $link->getImageLink($product->link_rewrite, $row['id_image'], 'home_default');
            $imageBigPath = $link->getImageLink($product->link_rewrite, $row['id_image'], 'thickbox_default');

            $products[$num]['id'] = $row['id_product'];
            $products[$num]['active'] = $row['active'];
            $sqlAttr = 'select sa.quantity,pa.supplier_reference from ' . _DB_PREFIX_ . 'product_attribute as pa left join ' . _DB_PREFIX_ . 'stock_available sa on pa.id_product_attribute=sa.id_product_attribute where sa.id_product=' . $row['id_product'] . '  group by sa.id_product_attribute';

            $resultAtr = $conn->query($sqlAttr);
            $totalQty = 0;
            if ($resultAtr->num_rows > 0) {
                $atrcnt = 0;
				setlocale(LC_MONETARY, 'de_DE.UTF-8');
                while ($rowAtr = $resultAtr->fetch_assoc()) {
                    //var_dump($rowAtr['supplier_reference']);
                    $prodAttrSplRefMatch = array();
                    if( preg_match(KOEHLERT_SPL_REF_WITHSIZE_REGEX, $rowAtr['supplier_reference'], $prodAttrSplRefMatch) ){
                        $products[$num]['atrr'][$atrcnt]['size'] = $prodAttrSplRefMatch[3];
                    }
                    else{
                        $products[$num]['atrr'][$atrcnt]['size'] = '';
                    }
                    /*
                    $AttrArray = explode(" ", $rowAtr['supplier_reference']);
                    if (!empty($AttrArray) && isset($AttrArray[1])) {
                        $attrsize = explode('_', $AttrArray[1]);
                        $products[$num]['atrr'][$atrcnt]['size'] = @utf8_encode($attrsize[1]);
                    } else {
                        $products[$num]['atrr'][$atrcnt]['size'] = '';
                    }
                    */
                    $products[$num]['atrr'][$atrcnt]['qty'] = utf8_encode($rowAtr['quantity']);
                    $totalQty = $totalQty + utf8_encode($rowAtr['quantity']);
                    $atrcnt++;
                }
            }
            $products[$num]['supplier'] = utf8_encode($row['supplier_name']);
            $products[$num]['price'] =  money_format('%.2n', $row['price']);
            
            // test reference first with size
            $prodSplRefMatch = array();
            if( preg_match(KOEHLERT_SPL_REF_WITHSIZE_REGEX, $row['ps_sku'], $prodSplRefMatch) ){
                $products[$num]['ps_sku'] = $prodSplRefMatch[1] .'_'. $prodSplRefMatch[2];
            }
            elseif( preg_match(KOEHLERT_SPL_REF_NOSIZE_REGEX, $row['ps_sku'], $prodSplRefMatch) ){
                $products[$num]['ps_sku'] = $prodSplRefMatch[1] .'_'. $prodSplRefMatch[2];
            }
			/*
            $sup_ref=	explode(" ",$row['ps_sku']);
			$sup_ref2 = explode("_",$sup_ref[1]);
            $products[$num]['ps_sku'] = utf8_encode($sup_ref[0])." ".$sup_ref2[0];
            */
            $products[$num]['quantity'] = $totalQty;
            $products[$num]['photo'] = 'https://' . $imagePath;
            $products[$num]['photo_big'] = 'https://' . $imageBigPath;
            $products[$num]['shop'] = utf8_encode($row['name']);
            $products[$num]['ean'] = $row['ean13'];
            $products[$num]['stock_clearance'] = intval($row['stock_clearance']);
            
            // exclusion group check
            $products[$num]['exclusion_group_allowed'] = null;
            if( $customerId ){
                $productBuyAllowed = CustomerMainToExcl::getCustomerAbleToBuyProduct($customerId, $product->id);
                if( !$productBuyAllowed['allowed'] ){
                    $products[$num]['exclusion_group_allowed'] = 0;
                }
                else{
                    $products[$num]['exclusion_group_allowed'] = 1;
                }
            }
            
            $num++;
        }
    } else {
        $message = 'No Product Found.';
        $status = false;
    }
    

    
    $output['status'] = $status;
    $output['message'] = $message;
    $output['data'] = $products;

    // log request
    $logMessage = 'Request URI: '. $_SERVER['REQUEST_URI'] . PHP_EOL;
    $logMessage .= 'Request body: '. print_r($_POST, true);
    $logMessage .= 'Response body: '. print_r($output, true);
    if( strlen($logMessage) > 16000 ){
        $logMessage = substr($logMessage, 0, 16000) .' .... partial response';
    }
    $logData = array(
        'severity' => 1,
        'error_code' => 1,
        'message' => $conn->real_escape_string($logMessage),
        'date_add' => 'NOW()',
        'date_upd' => 'NOW()'
    );
    
    try{
        $insRes = $conn->query('
            INSERT INTO `prs_log` ('. implode(' , ', array_keys($logData)) .')
            VALUES (
                '. $logData['severity'] .',
                '. $logData['error_code'] .',
                "'. $logData['message'] .'",
                '. $logData['date_add'] .',
                '. $logData['date_upd'] .'
            )
        ');
    }
    catch(Exception $e){
        
    }
    
    $conn->close();

    return $output;
}

function get_product_attribute($id_product = 0, $langid = 0) {
    
}
