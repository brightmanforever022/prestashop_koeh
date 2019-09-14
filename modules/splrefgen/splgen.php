<?php

define('SCRIPT_FOLDER', realpath(dirname(__FILE__)));
require SCRIPT_FOLDER . '/../../config/config.inc.php';

$splref = trim(strip_tags( $_REQUEST['ref'] ));
$response = array(
    'message' => ''
);
$languageDefaultId = (int)Configuration::get('PS_LANG_DEFAULT');
$languages = Language::getLanguages(false);

if( strlen($splref) ){
    $processProductId = 0;
    $refDefault = '';
    $productAttr = Db::getInstance()->getRow('
        SELECT * 
        FROM `'. _DB_PREFIX_ .'product_attribute` 
        WHERE `supplier_reference` LIKE "'. pSQL($splref) .'"
            AND `default_on` = 1
    ');
    $productSpl = Db::getInstance()->getRow('
        SELECT * 
        FROM `'. _DB_PREFIX_ .'product_supplier` 
        WHERE `product_supplier_reference` LIKE "'. pSQL($splref) .'"
            AND id_product_attribute = 0
    ');

    if( is_array($productAttr) && count($productAttr) ){
        $processProductId = (int)$productAttr['id_product'];
        $refDefault = $productAttr['supplier_reference'];
    }
    elseif( is_array($productSpl) && count($productSpl) ){
        $processProductId = (int)$productSpl['id_product'];
        $refDefault = $productSpl['product_supplier_reference'];
    }
    if( $processProductId ){
        $color = null;
        if( preg_match('#^\d+_(.+)$#', $refDefault, $colorMatch) ){
            $color = $colorMatch[1];
        }
        
        $productSizesQuery = '
            SELECT pa.id_product_attribute, pa.id_product, pa.supplier_reference, pa.default_on, 
                al.name AS size_name
            FROM `'. _DB_PREFIX_ .'product_attribute` pa
            INNER JOIN `'. _DB_PREFIX_ .'product_attribute_combination` pac
                ON pac.id_product_attribute = pa.id_product_attribute
            INNER JOIN `'. _DB_PREFIX_ .'attribute` a
                ON a.id_attribute = pac.id_attribute
            INNER JOIN `'. _DB_PREFIX_ .'attribute_lang` al
                ON al.id_attribute = a.id_attribute AND al.id_lang = '. $languageDefaultId .'
            WHERE 
                a.id_attribute_group = 1
                AND pa.id_product = '. $processProductId .'
        ';
        $productSizes = Db::getInstance()->executeS($productSizesQuery);
        if( is_array($productSizes) && count($productSizes) ){
            foreach($productSizes as $pSize){
                // if ref already correct
                /*if( preg_match('#^'. $refDefault .'_'. $pSize['size_name'] .'$#', $pSize['supplier_reference']) ){
                    continue;
                }*/
                
                $prodAttrData = array(
                    'supplier_reference' => $refDefault .'_'. $pSize['size_name']
                );
                
                Db::getInstance()->update('product_attribute', $prodAttrData, 
                    'id_product_attribute = '. (int)$pSize['id_product_attribute'] 
                );
                
                $prodSplData = array(
                    'product_supplier_reference' => $refDefault .'_'. $pSize['size_name']
                );
                Db::getInstance()->update('product_supplier', $prodSplData,
                    'id_product = '. (int)$pSize['id_product'] .
                    ' AND id_product_attribute = '. (int)$pSize['id_product_attribute'] 
                );
            }
            
            if(!empty($color)){
                foreach($languages as $language){
                    $colorUpdData = array(
                        'available_now' => $color
                    );
                    Db::getInstance()->update(
                        'product_lang',
                        $colorUpdData,
                        'id_product = '. (int)$pSize['id_product'] .' AND id_lang = '. $language['id_lang']
                    );
                }
            }
            
            $response['message'] = 'Combinations supplier references updated';
        }
        else{
            $response['message'] = 'Combinations not found with supplier reference "'. $splref .'"';
        }
    }
    else{
        $response['message'] = 'Product not found with supplier reference "'. $splref .'"';
    }
}
else{
    $response['message'] = '"Reference" empty';
}

die(json_encode($response));