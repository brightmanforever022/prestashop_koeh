<?php

function getPhotos()
{
    global $conn;
    
    $link = new Link();
    $rowsLimit = 100;
    
    $query = '
        SELECT SQL_CALC_FOUND_ROWS p.id_product, p.supplier_reference, i.id_image 
        FROM ' . _DB_PREFIX_ . 'product p 
        INNER JOIN ' . _DB_PREFIX_ . 'image i 
            ON i.id_product = p.id_product and i.cover=1
        GROUP BY p.id_product
    ';
    
    
    $result = $conn->query($query);
    $totalRowsResult = $conn->query('SELECT FOUND_ROWS()');
    
    $totalRows = $totalRowsResult->fetch_row();
    
    //print_r($totalRows);
    $products = array();
   // print_r($result->num_rows);
    if( $result->num_rows ){
        while ($row = $result->fetch_assoc()){
            $product = new Product($row['id_product'], false, Context::getContext()->language->id);
            $row['photo'] = 'https://'. $link->getImageLink($product->link_rewrite, $row['id_image'], 'thickbox_default');
            $products[] = $row;
        }
    }
    $output = array();
    $output['status'] = true;
    $output['message'] = '';
    $output['total_rows'] = intval($totalRows[0]);
    $output['data'] = $products;
    
    return $output;
}