<?php

class KhlphotogalleryGalleryModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $this->ajax = true;
        $action = Tools::getValue('action');

        $responseData = array(
            'success' => false,
            'data' => array(),
            'message' => ''
        );
        
        try{
            $this->authenticateByWsKey();
        }
        catch(Exception $e){
            PrestaShopLoggerCore::addLog(__CLASS__ .', '. $e->getMessage() . $e->getTraceAsString(), 3);
            $responseData['message'] = $e->getMessage();
            
            echo json_encode($responseData);
            die;
        }
        
        
        switch($action){
            case 'list':
                $this->galleryList($responseData);
                break;
        }
        
        echo json_encode($responseData);
        die;
    }
    
    public function galleryList(&$responseData)
    {
        $this->ajax = true;
        
        $galleryItemsList = Db::getInstance()->executeS('
            SELECT gi.*, gs.*
            FROM '. _DB_PREFIX_ .'gallery_source gs
            INNER JOIN '. _DB_PREFIX_ .'gallery_item gi ON gi.id_gallery_source = gs.id_gallery_source
            ORDER BY gs.id_gallery_source
        ');
        
        $imageBaseUrl = $this->context->shop->getBaseURL(false, false) . $this->module->getPath() .'photos/';
        
        foreach($galleryItemsList as $galleryItemData){
            $responseData['data'][] = array(
                'url' => $imageBaseUrl . urlencode($galleryItemData['filename'])
            );
        }
        
        $responseData['success'] = true;
        
        return;
    }
    
    protected function authenticateByWsKey()
    {
        if( empty($_GET['ws_key']) ){
            throw new Exception('Not authenticated (121)');
        }
        
        $wsKey = $_GET['ws_key'];
        
        if( (strlen($wsKey) != 32) || !preg_match('#^[A-Z0-9]*$#', $wsKey) ){
            throw new Exception('Not authenticated (122)');
        }
        
        $ws_key_found = Db::getInstance()->getRow('
            SELECT *
            FROM `'._DB_PREFIX_.'webservice_account`
            WHERE active = 1 AND `key` = "'. pSQL($wsKey) .'"
        ');
        
        if( !is_array($ws_key_found) || empty($ws_key_found['id_webservice_account']) ){
            throw new Exception('Not authenticated (123)');
        }
        
        return true;
    }
    
}