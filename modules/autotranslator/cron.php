<?php

/**
ALTER TABLE `prs_product` ADD `default_text_hash` VARCHAR(32) NOT NULL AFTER `pack_stock_type`;
 */

require('../../config/config.inc.php');
require '../autotranslator/autotranslator.php';

set_time_limit(600);

$log = array();
$languageDefaultId = intval(Configuration::get('PS_LANG_DEFAULT'));
$languageDefault = new Language($languageDefaultId);
$yandexTransApiKey = Configuration::get('Y_API_KEY');

$languages = LanguageCore::getLanguages();

$translator = new AutoTranslator();

$productsQuery = '
    SELECT p.`id_product`, p.`default_text_hash`, pl.`name`, pl.`description`
    FROM `'._DB_PREFIX_.'product` p
    INNER JOIN `'._DB_PREFIX_.'product_lang` pl 
        ON pl.id_product = p.id_product
    WHERE 
        pl.id_lang = '. $languageDefaultId .'
        AND pl.id_shop = '. Context::getContext()->shop->id .'
';

//$productsQuery .= ' LIMIT 10';

$productsRes = Db::getInstance()->query($productsQuery);

while( $productData = Db::getInstance()->nextRow($productsRes) ){
    $productName = trim($productData['name']);
    $productDescription = trim($productData['description']);
    
    $productTextHash = md5( $productName . $productDescription );
    
    if( $productTextHash === $productData['default_text_hash'] ){
        //$log[] = 'Not changed: "'. $productName .'" ('. $productData['id_product'] .')';
        continue;
    }
    
    foreach( $languages as $languageToTranslate ){
        if( intval($languageToTranslate['id_lang']) === $languageDefaultId ){
            continue;
        }
        
        try{
            $translation = $translator->yandexTranslate(
                array(
                    'name' => $productName,
                    'description' => $productDescription
                ),
                $languageDefault->iso_code,
                $languageToTranslate['iso_code'],
                $yandexTransApiKey
            );
        }
        catch(Exception $e){
            $log[] = 'Exception: "'. $productName .'" ('. $productData['id_product'] .'). '. $e->getMessage() ;
            continue;
        }
        
        if( $translation === false ){
            $log[] = 'Error: "'. $productName .'" ('. $productData['id_product'] .'). '. 
                implode(' ; ', $translator->errors);
            continue;
        }
        
        $prodLangTblUpdCond = 'id_product = '. intval($productData['id_product']) . 
            ' AND id_lang = '. intval($languageToTranslate['id_lang']) .
            ' AND id_shop = '. Context::getContext()->shop->id;
        Db::getInstance()->update('product_lang', array(
            'name' => $translation['name'],
            'description' => $translation['description']
        ), $prodLangTblUpdCond);
        
        Db::getInstance()->update('product', array(
            'default_text_hash' => $productTextHash
        ), 'id_product = '. intval($productData['id_product']));
        
        $log[] = 'Translated: "'. $productName .'" ('. $productData['id_product'] .')' ;
    }
}

if( is_array($log) && count($log) ){
    PrestaShopLogger::addLog('Translations cron: <br><br>'. implode('<br>', $log));
    //echo implode('<br>', $log);
    mail('info@koehlert.com', 'Translations cron', implode("\n\r", $log));
}