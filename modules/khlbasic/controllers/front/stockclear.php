<?php

class KhlbasicStockClearModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        set_time_limit(600);
        switch( Tools::getValue('action') ){
            case 'set_stock_clear':
                $this->setProductsStockClear();
                break;
            case 'set_sale_cat':
                $this->setCategoryForStockClearance();
                break;
            default:
                break;
        }
    }
    
    
    public function setProductsStockClear()
    {
        $this->ajax = 1;
        $responseData = array(
            'success' => false,
            'data' => array(),
            'messages' => array(),
        );
        $auth_key = @$_GET['auth_key'];
        
        if(empty($auth_key)){
            $responseData['success'] = false;
            $responseData['messages'][] = 'Invalid auth';
            echo json_encode($responseData);die;
        }
        
        $auth_key_found = Db::getInstance()->getRow('
            SELECT * 
            FROM `'._DB_PREFIX_.'webservice_account`
            WHERE active = 1 AND `key` = "'. pSQL($auth_key) .'"
        ');
        
        if( !is_array($auth_key_found) || empty($auth_key_found['id_webservice_account']) ){
            $responseData['success'] = false;
            $responseData['messages'][] = 'Invalid auth';
            echo json_encode($responseData);die;
        }
        
        $requestBody = file_get_contents("php://input");
        $requestParams = json_decode($requestBody, true);
        
        if( ($requestParams === false) || !is_array($requestParams) ){
            $responseData['success'] = false;
            $responseData['messages'][] = 'Invalid request';
            echo json_encode($responseData);die;
        }
        
        if( empty($requestParams['clearance_state']) || empty($requestParams['supplier_references']) ){
            $responseData['success'] = false;
            $responseData['messages'][] = 'Invalid params';
            echo json_encode($responseData);die;
        }

        $clearance_state = $requestParams['clearance_state'] == 'set' ? 1 : 0; 
        
        foreach($requestParams['supplier_references'] as $requestSplRef){
            $productQuery = '
                SELECT * 
                FROM `'. _DB_PREFIX_ .'product_supplier`
                WHERE `product_supplier_reference` = "'. pSQL($requestSplRef) .'"
            ';
            $productSupplierData = Db::getInstance()->getRow($productQuery);
            
            if( !is_array($productSupplierData) || empty($productSupplierData['id_product_supplier']) ){
                $responseData['messages'][] = 'Product not found "'. $requestSplRef .'"';
                continue;
            }
            
            Db::getInstance()->update('product', 
                array(
                    'stock_clearance' => $clearance_state
                ), 'id_product = '. $productSupplierData['id_product']);
            
            if($clearance_state){
                $product = new Product($productSupplierData['id_product']);
                // attach product to Sale category
                $product->addToCategories(35);
            }
            
            $responseData['messages'][] = 'Product stock clearance '
                . ($clearance_state ? ' set ' : ' unset ')
                .' "'. $requestSplRef .'"';
        }
        
        $responseData['success'] = true;
        echo json_encode($responseData);die;
    }
    
    protected function setCategoryForStockClearance()
    {
        $productQuery = '
                SELECT id_product
                FROM `'. _DB_PREFIX_ .'product`
                WHERE `stock_clearance` = 1
            ';
        $productsData = Db::getInstance()->executeS($productQuery);
        
        foreach($productsData as $productData){
            $product = new Product($productData['id_product']);
            $product->addToCategories(35);
            echo 'Set for '. $productData['id_product'].'<br>';
        }
        die;
    }
}