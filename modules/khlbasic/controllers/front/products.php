<?php
/**
 * 
 * @author vitaliy

jsonFormat = {
    name : [
        {lang_code: 'en', value: 'Some name'},
        {lang_code: 'de', value: 'Some name'}
    ],
    description: [
        {lang_code: 'en', value: '<p>the description</p>'}
    ],
    category_id,
    supplier_id: 99,
    product_supplier_reference: '0000_reference',
    supplier_price_tax_excl: 50.00,
    price_tax_excl: 99.90,
    tax_rules_group_id: 2,
    combinations: [
        {
            default: 1,
            product_supplier_reference : '0000_reference_32',
            quantity: 1,
            ean13: '123123123123',
            price_impact: 0,
            attributes: [
                {name: 'Size', value: '32'},
                {name: 'Color', value: 'Red'}
            ]
        },
        {
            default: 0,
            product_supplier_reference : '0000_reference_34',
            quantity: 1,
            ean13: '123123123123',
            price_impact: 0,
            attributes: [
                {name: 'Size', value: '34'},
                {name: 'Color', value: 'Red'}
            ]
        }

    ]
};
 */
class KhlbasicProductsModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        set_time_limit(0);
        switch( Tools::getValue('action') ){
            case 'create':
                $this->processProductCreate();
                break;
            case 'images_add':
                $this->processImagesAdd();
                break;
            default:
                break;
        }
    }
    
    protected function checkAuth()
    {
        
        $auth_key = @$_GET['auth_key'];
        
        if(empty($auth_key)){
            throw new Exception('Invalid auth');
        }
        
        $auth_key_found = Db::getInstance()->getRow('
            SELECT *
            FROM `'._DB_PREFIX_.'webservice_account`
            WHERE active = 1 AND `key` = "'. pSQL($auth_key) .'"
        ');
        
        if( !is_array($auth_key_found) || empty($auth_key_found['id_webservice_account']) ){
            throw new Exception('Invalid auth');
        }
        
        return true;
    }
    
    public function processProductCreate()
    {
        $sizeGroupAttributeId = 1;
        $this->ajax = 1;
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        try{
            $this->checkAuth();
        }
        catch(Exception $e){
            $responseData['success'] = false;
            $responseData['message'] = $e->getMessage();
            echo json_encode($responseData);die;
        }
        
        $postInput = file_get_contents('php://input');
        $postJson = json_decode($postInput, true);
        
        if( ($postJson === false) || !is_array($postJson) ){
            $responseData['success'] = false;
            $responseData['messages'][] = 'Invalid request, json not decoded';
            echo json_encode($responseData);die;
        }
        
        $langDefaultId = Configuration::get('PS_LANG_DEFAULT');
        $langDefaultCode = null;
        $langCodeToId = array();
        $languages = Language::getLanguages();
        foreach( $languages as $language ){
            $langCodeToId[ $language['iso_code'] ] = $language['id_lang'];
            if( $language['id_lang'] == $langDefaultId ){
                $langDefaultCode = $language['iso_code'];
            }
        }

        
        $product = new Product();
        
        $product->active = false;
        
        $product->id_category_default = intval($postJson['category_id']);
        $product->id_category = array(intval($postJson['category_id']));
        $product->id_supplier = intval($postJson['supplier_id']);
        $product->supplier_reference = $postJson['product_supplier_reference'];
        
        if( isset($postJson['supplier_price_tax_excl']) ){
            $product->wholesale_price = floatval($postJson['supplier_price_tax_excl']);
        }
        $product->price = floatval($postJson['price_tax_excl']);
        $product->id_tax_rules_group = intval($postJson['tax_rules_group_id']);
        

        $nameDefault = null;
        foreach( $postJson['name'] as $postNameLang ){
            $product->name[ $langCodeToId[$postNameLang['lang_code']] ] = $postNameLang['value'];
            $product->link_rewrite [ $langCodeToId[$postNameLang['lang_code']] ] = Tools::str2url($postNameLang['value']);
            if( $postNameLang['lang_code'] == $langDefaultCode ){
                $nameDefault = $postNameLang['value'];
            }
        }
        
        $descriptionDefault = null;
        foreach( $postJson['description'] as $postDescriptionLang ){
            $product->description[ $langCodeToId[$postDescriptionLang['lang_code']] ] = $postDescriptionLang['value'];
            if( $postDescriptionLang['lang_code'] == $langDefaultCode ){
                $descriptionDefault = $postDescriptionLang['value'];
            }
        }
        
        
        foreach( $languages as $language ){
            if( empty($product->name[ $language['id_lang'] ]) ){
                $product->name[ $language['id_lang'] ] = $nameDefault;
                $product->link_rewrite[ $language['id_lang'] ] = Tools::str2url($nameDefault);
            }
            if( empty($product->description[ $language['id_lang'] ]) ){
                $product->description[ $language['id_lang'] ] = $descriptionDefault;
            }
        }
        
        try{
            $product->save();
            
            $product->updateCategories($product->id_category);
        }
        catch(Exception $e){
            $responseData['message'] = 'Product insert error: '. $e->getMessage();
            echo json_encode($responseData);die;
        }
        
        Search::indexation(false, $product->id);
        
        /**
         * @var ProductSupplier $productSupplier
         */
        $productSupplierMain = new ProductSupplier();
        $productSupplierMain->id_product = $product->id;
        $productSupplierMain->id_product_attribute = 0;
        $productSupplierMain->product_supplier_reference = $postJson['product_supplier_reference'];
        $productSupplierMain->id_supplier = $postJson['supplier_id'];
        if( isset($postJson['supplier_price_tax_excl']) ){
            $productSupplierMain->product_supplier_price_te = $postJson['supplier_price_tax_excl'];
        }
        
        try{
            $productSupplierMain->save();
        }
        catch(Exception $e){
            $product->delete();
            $responseData['message'] = 'Product supplier insert error: '. $e->getMessage();
            echo json_encode($responseData);die;
        }
        
        $combinationsInserted = array();
        
        if( is_array($postJson['combinations']) && count($postJson['combinations']) ){
            foreach( $postJson['combinations'] as $postCombination ){
                /**
                 * 
                 * @var CombinationCore $combination
                 */
                $combination = new Combination();
                $combination->default_on = $postCombination['default'];
                if( !empty($postCombination['ean13']) ){
                    $combination->ean13 = $postCombination['ean13'];
                }
                $combination->id_product = $product->id;
                $combination->quantity = $postCombination['quantity'];
                $combination->supplier_reference = $postCombination['product_supplier_reference'];
                
                try{
                    $combination->add();
                }
                catch(Exception $e){
                    $product->delete();
                    $productSupplierMain->delete();
                    
                    foreach($combinationsInserted as $combinationInserted){
                        $combinationInserted->delete();
                    }
                    
                    $responseData['message'] = 'Combinattion insert error: '. $e->getMessage();
                    echo json_encode($responseData);die;
                }
                
                
                
                $combinationAttributes = array();
                foreach( $postCombination['attributes'] as $postCombinationAttribute ){
                    if( $postCombinationAttribute['name'] == 'Size' ){
                        $attribute = Db::getInstance()->getRow('
                            SELECT a.*
                            FROM `'._DB_PREFIX_.'attribute` a
                            INNER JOIN `'._DB_PREFIX_.'attribute_lang` al
                                ON al.id_attribute = a.id_attribute AND al.id_lang = '. $langDefaultId .'
                            WHERE a.`id_attribute_group` = '. $sizeGroupAttributeId .'
                                AND al.name = "'. $postCombinationAttribute['value'] .'"
                        ');
                        if( is_array($attribute) && !empty($attribute['id_attribute']) ){
                            $combinationAttributes[] = intval($attribute['id_attribute']);
                        }
                    }
                }
                $combination->setAttributes($combinationAttributes);
                
                /**
                 * @var ProductSupplier $productSupplierAttr
                 */
                $productSupplierAttr = new ProductSupplier();
                $productSupplierAttr->id_product = $product->id;
                $productSupplierAttr->id_product_attribute = $combination->id;
                $productSupplierAttr->product_supplier_reference = $postCombination['product_supplier_reference'];
                $productSupplierAttr->id_supplier = $postJson['supplier_id'];
                if( isset($postJson['supplier_price_tax_excl']) ){
                    $productSupplierAttr->product_supplier_price_te = $postJson['supplier_price_tax_excl'];
                }
                
                try{
                    $productSupplierAttr->save();
                }
                catch(Exception $e){
                    $product->delete();
                    $productSupplierMain->delete();
                    
                    foreach($combinationsInserted as $combinationInserted){
                        $combinationInserted->deleteFromSupplier();
                        $combinationInserted->delete();
                    }
                    
                    $responseData['message'] = 'Product attr supplier insert error: '. $e->getMessage();
                    echo json_encode($responseData);die;
                }
                
                $combinationsInserted[] = $combination;
            }
        }
        $responseData['success'] = true;
        $responseData['data']['product_id'] = $product->id;
        echo json_encode($responseData);die;
    }

    public function processImagesAdd()
    {
        $this->ajax = 1;
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        try{
            $this->checkAuth();
        }
        catch(Exception $e){
            $responseData['success'] = false;
            $responseData['message'] = $e->getMessage();
            echo json_encode($responseData);die;
        }
        
        $productId = intval( $_GET['product_id'] );
        $product = new Product($productId);
        if( empty($product->id) ){
            $responseData['message'] = 'Product not found';
            echo json_encode($responseData);die;
        }
        
        if( empty($_FILES) ){
            $responseData['message'] = 'No uploaded files detected';
            echo json_encode($responseData);die;
        }
        
        $languages = Language::getLanguages();
        
        $postFiles = array();
        foreach($_FILES['image'] as $propKey => $postImageData){
            foreach($postImageData as $imageIndex => $postImageValue){
                if( !array_key_exists($imageIndex, $postFiles) ){
                    $postFiles[ $imageIndex ] = array();
                }
                if( !array_key_exists($propKey, $postFiles[ $imageIndex ]) ){
                    $postFiles[ $imageIndex ][ $propKey ] = array();
                }
                
                $postFiles[ $imageIndex ][ $propKey ] = $postImageValue;
            }
            
        }
        
        $product->deleteImages();
        
        foreach( $postFiles as $ii => $postFile ){
            $image = new Image();
            $image->id_product = intval($product->id);
            $image->cover = ($ii == 0 ? 1 : 0);
            $image->position = Image::getHighestPosition(intval($product->id)) + 1;
            $legend = array();
            
            foreach($languages as $language){
                $legend[ $language['id_lang'] ] = empty($product->name[ $language['id_lang'] ]) ? 'not set' : $product->name[ $language['id_lang'] ];
            }
            $image->legend = $legend;
            $image->add();
            
            $imagesTypes = ImageType::getImagesTypes('products');

            $imageInfo = getimagesize($postFile['tmp_name']);
            
            if (!$path = $image->getPathForCreation()){
                $responseData['message'][] = 'An error occurred during new folder creation.' . "\n";
            }
            
            if (!ImageManager::resize($postFile['tmp_name'], $path.'.'.$image->image_format )) {
                $image->delete();
                $responseData['message'][] = 'An error occurred while resizing image.' ."\n";
            }
            
            foreach ($imagesTypes AS $_i => $imageType){
                if (!ImageManager::resize($image->getPathForCreation().'.jpg', $image->getPathForCreation().'-'.stripslashes($imageType['name']).'.jpg', $imageType['width'], $imageType['height'])){
                    $image->delete();
                    $responseData['message'][] = 'An error occurred while copying image.'.' '.stripslashes($imageType['name']) . "\n";
                }
            }
            
        }
        
        $responseData['success'] = true;
        echo json_encode($responseData);die;
        
    }
}