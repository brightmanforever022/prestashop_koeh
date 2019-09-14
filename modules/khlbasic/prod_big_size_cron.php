<?php

require realpath(dirname(__FILE__)) . '/../../config/config.inc.php';

$context = Context::getContext();

$sizeMin = 50;
$sizePercentImpact = floatval( Configuration::get('KHLBSC_BIG_SIZE_PRICE_IMPACT') );
$yesterday = new DateTime('-1 day');

$query = '
    SELECT p.id_product, ps.price
    FROM `'._DB_PREFIX_.'product` p
    INNER JOIN `'._DB_PREFIX_.'product_shop` ps 
        ON ps.id_product = p.id_product AND ps.id_shop = '. $context->shop->id .'
    WHERE 
        DATE_FORMAT(p.date_add, "%Y%m%d") = '. $yesterday->format('Ymd') .'
';

$productsNewList = Db::getInstance()->executeS($query);

foreach($productsNewList as $productNew){
    $price = floatval($productNew['price']);
    if( !$price || ($price < 0) ){
        continue;
    }
    
    $attributesQuery = '
        SELECT *
        FROM `'._DB_PREFIX_.'product_attribute`
        WHERE id_product = '. intval($productNew['id_product']) .'
    ';
    
    $produtAttributesList = Db::getInstance()->executeS($attributesQuery);
    
    if( !count($produtAttributesList) ){
        continue;
    }
    
    $bigSizePriceImpact = $price / 100 * $sizePercentImpact;

    foreach( $produtAttributesList as $produtAttribute ){
        if( !preg_match(KOEHLERT_SPL_REF_WITHSIZE_REGEX, $produtAttribute['supplier_reference'], $attrRefMatch) ){
            continue;
        }

        if( $attrRefMatch[3] >= $sizeMin ){
            $combination = new Combination($produtAttribute['id_product_attribute']);
            $combination->price = $bigSizePriceImpact;
            
            try{
                $combination->update();
            }
            catch(Exception $e){
                
            }
            
        }
    }
}