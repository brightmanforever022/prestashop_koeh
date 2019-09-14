<?php

define('SCRIPT_FOLDER', realpath(dirname(__FILE__)));
require SCRIPT_FOLDER . '/../../config/config.inc.php';
require_once _PS_TOOL_DIR_ . 'CurlWrapper/CurlWrapper.php';
require SCRIPT_FOLDER . '/transphotos.php';

$module = new Transphotos();

$languageDefaultId = (int)Configuration::get('PS_LANG_DEFAULT');

$response = array(
    'success' => false,
    'message' => array()
);

$splref = trim(strip_tags($_POST['ref']));
$curl = new CurlWrapper();

if( strlen($splref) ){
    
    $wsRequestUrl = $module->getServerUrl($_POST['server']);
    
    if( version_compare(_PS_VERSION_, '1.6') >= 0 ){
        $productData = Db::getInstance()->getRow('
            SELECT id_product, product_supplier_reference AS supplier_reference
            FROM `'. _DB_PREFIX_ .'product_supplier`
            WHERE `product_supplier_reference` LIKE "'. pSQL($splref) .'"
                AND id_product_attribute = 0
        ');
    }
    else{
        $productData = Db::getInstance()->getRow('
            SELECT id_product, supplier_reference
            FROM `'. _DB_PREFIX_ .'product`
            WHERE `supplier_reference` LIKE "'. pSQL($splref) .'"
        ');
        
    }
    
    if( is_array($productData) && !empty($productData['id_product']) ){
        $product = new Product($productData['id_product']);
        //$images = $product->getImages($languageDefaultId);
        $refDefault = $productData['supplier_reference'];
        
        $images = Db::getInstance()->ExecuteS('
            SELECT *
            FROM `'._DB_PREFIX_.'image` i
            LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image`)
            WHERE i.`id_product` = '. intval($product->id) .' AND il.`id_lang` = '.(int)$languageDefaultId.'
            ORDER BY i.`cover` DESC, i.`position` ASC
        ');
        
        $response['message'][] = 'Images to export: '. count($images);
        
        $stats = array(
            'success' => 0,
            'failure' => 0
        );
        foreach($images as $ii => $imageData){
            $curl->reset();
            $image = new Image($imageData['id_image'], $languageDefaultId);
            
            $imagePath = _PS_PROD_IMG_DIR_ . $image->getExistingImgPath() . '.jpg';
            //$wsRequestUrl = 'https://www.vipdress.de/modules/transphotos/srv.php';
            //$wsRequestUrl = 'http://nsweb.server/vipdress/modules/transphotos/srv.php';
            $curlFile = new CURLFile($imagePath, 'image/jpg', 'img.jpg');
            try{
                $responseImage = $curl->post($wsRequestUrl, array(
                    'image' => $curlFile,
                    'cover' => intval($imageData['cover']),
                    'supplier_reference' => $productData['supplier_reference'],
                    'number' => $ii
                ));
            }
            catch(Exception $e){
                $response['success'] = false;
                $response['message'][] = $e->getMessage();
                continue;
            }
            //$response['message'][] = $responseImage;
            $imageRespData = json_decode($responseImage, true);
            
            if( $imageRespData == null ){
                $response['message'][] = $responseImage;
                $stats['failure']++;
                continue;
            }
            
            if( !$imageRespData['success'] ){
                $response['message'][] = $imageRespData['message'];
                $response['message'][] = print_r($curl->getTransferInfo(), true);
                $stats['failure']++;
                continue;
            }
            
            $stats['success']++;
        }
        
        $response['message'][] = 'Images created: '. $stats['success'] .'. Images failure: '. $stats['failure'];
        
    }
    else{
        $response['message'][] = 'Product not found on local server';
    }
}
$response['message'] = implode('. ', $response['message']);
die(json_encode($response));
