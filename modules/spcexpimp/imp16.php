<?php

define('SCRIPT_FOLDER', realpath(dirname(__FILE__)));
require SCRIPT_FOLDER . '/../../config/config.inc.php';

$csv = fopen('export.csv', 'r');
while( $csvData = fgetcsv($csv, 1000, ';', '"') ){
    $prod = Db::getInstance()->getRow('
        SELECT * 
        FROM `'. _DB_PREFIX_ .'product` 
        WHERE `supplier_reference` LIKE "'. pSQL($csvData[0]) .'"
    ');
    if( !is_array($prod) || !count($prod) ){
        echo 'Product not found "'. $csvData[0] .'"<br>';
        continue;
    }
    
    $updData = array(
        'wholesale_price' => $csvData[1],
        'price' => $csvData[2]
    );
    
    Db::getInstance()->update('product', $updData, 'id_product = '. (int)$prod['id_product']);
    Db::getInstance()->update('product_shop', $updData, 'id_product = '. (int)$prod['id_product']);
    
    echo 'Updated: ID '.$prod['id_product'].', "'. implode(' / ', $csvData) .'"<br>';
    //die;
}