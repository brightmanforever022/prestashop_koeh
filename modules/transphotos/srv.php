<?php

define('SCRIPT_FOLDER', realpath(dirname(__FILE__)));
require SCRIPT_FOLDER . '/../../config/config.inc.php';
require_once('../../images.inc.php');

$response = array(
    'success' => false,
    'message' => ''
);
ini_set('memory_limit', '1024M');
$languageDefaultId = (int)Configuration::get('PS_LANG_DEFAULT');
$languages = Language::getLanguages(false);
$splRef = Tools::getValue('supplier_reference');
$imageNumber = intval( Tools::getValue('number') );

function error_handler_for_15($errno, $errstr, $errfile, $errline)
{
    return $errstr;
}


if( ($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($splRef) && !empty($_FILES) ){
    $cover = intval( $_POST['cover'] );
    
    if( version_compare(_PS_VERSION_, '1.6') >= 0 ){
        $productData = Db::getInstance()->getRow('
            SELECT id_product, product_supplier_reference AS supplier_reference
            FROM `'. _DB_PREFIX_ .'product_supplier`
            WHERE `product_supplier_reference` LIKE "'. pSQL($splRef) .'"
                AND id_product_attribute = 0
        ');
        
    }
    else{
        set_error_handler('error_handler_for_15');
        $productData = Db::getInstance()->getRow('
            SELECT *
            FROM `'. _DB_PREFIX_ .'product`
            WHERE `supplier_reference` LIKE "'. pSQL($splRef) .'"
        ');

    }
    
    $fileSize = $_FILES['image']['size'];
    if( $fileSize <= 0 ){
        $response['message'] = 'File size is: '. $fileSize;
    }
    
    if( is_array($productData) && !empty($productData['id_product']) ){
        $product = new Product($productData['id_product'], false, $languageDefaultId);
        
        // delete images if they are
        if($imageNumber === 0){
            $product->deleteImages();
        }
        
        $tmpfile = $_FILES['image']['tmp_name'];
        
        
        $coverImage = Db::getInstance()->getRow('
            SELECT *
            FROM `'._DB_PREFIX_.'image` i
            WHERE i.`id_product` = '. intval($product->id) .'
                AND i.cover = 1
        ');
        
            
        $image = new Image();
        $image->id_product = intval($product->id);
        $image->cover = $cover;
        if( is_array($coverImage) && !empty($coverImage['id_image']) ){
            $image->cover = 0;
        }
        $image->position = Image::getHighestPosition(intval($product->id)) + 1;
        $legend = array();
        
        foreach($languages as $language){
            $legend[ $language['id_lang'] ] = empty($product->name) ? 'not set' : $product->name;
        }
        $image->legend = $legend;
        $image->add();
        
        $imagesTypes = ImageType::getImagesTypes('products');
        
        if( class_exists('ImageManager') ){
            $imageInfo = getimagesize($tmpfile);
            
            if (!$path = $image->getPathForCreation()){
                $response['message'] = 'An error occurred during new folder creation.' . "\n";
            }
            
            if (!ImageManager::resize($tmpfile, $path.'.'.$image->image_format )) {
                $image->delete();
                $response['message'] = 'An error occurred while resizing image.' ."\n";
            }
            
            foreach ($imagesTypes AS $_i => $imageType){
                if (!ImageManager::resize($image->getPathForCreation().'.jpg', $image->getPathForCreation().'-'.stripslashes($imageType['name']).'.jpg', $imageType['width'], $imageType['height'])){
      				$image->delete();
      				$response['message'] = 'An error occurred while copying image.'.' '.stripslashes($imageType['name']) . "\n";
                }
            }
        }
        else{
            $id_image = strval($image->id);
            $len = strlen($id_image);
            $path = _PS_PROD_IMG_DIR_;
            for($i=0; $i<$len; $i++)
            {
                $path .= $id_image[$i].'/';
                if (!file_exists($path))
                {
                    mkdir($path);
                }
            }
            $path .= $id_image;
            
            imageResize($tmpfile, $path.'.jpg');
            
            foreach ($imagesTypes AS $k => $imageType){
                $imageResizeResult = imageResize($tmpfile, $path.'-'.stripslashes($imageType['name']).'.jpg', $imageType['width'], $imageType['height'], 'jpg', $imageType['dont_expand']);
                if( $imageResizeResult !== true ){
                    if( is_string($imageResizeResult) ){
                        $response['message'] = 'Error resizing image: '. $imageResizeResult;
                    }
                    else{
                        $response['message'] = 'Error resizing image. Details not available';
                    }
                    $response['success'] = false;
                    break;
                }
            }
            
        }
        
        
        if( file_exists($path.'.jpg') ){
            $response['success'] = true;
            $response['message'] = 'Image created';
        }
    }
    else{
        $response['message'] = 'Product not found';
    }
}
else{
    $response['message'] = 'Invalid request';
}

die(json_encode($response));