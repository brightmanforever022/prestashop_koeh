<?php

require_once _PS_ROOT_DIR_ . '/modules/khleans/EanManager.php';

class KhleansServiceModuleFrontController extends ModuleFrontController
{
    public function process()
    {
        $this->ajax = true;
        
        $methodName = 'action'. Tools::toCamelCase(Tools::getValue('action', 'index'), true);
        if( method_exists($this, $methodName) ){
            call_user_func(array($this, $methodName));
        }
    }
    
    public function actionIndex()
    {
        echo __FUNCTION__;
    }
    
    public function actionGetEanForRef()
    {
        $response = array('success' => false, 'data' => array(), 'messages' => array());
        $reference = Tools::getValue('reference');
        
        $eanAssigned = Db::getInstance()->getRow('
            SELECT * 
            FROM `'._DB_PREFIX_.'ean` 
            WHERE `supplier_reference` = "'. pSQL($reference) .'"
                AND `keeper` = '. Ean::KEEPER_VIPDRESS .'
        ', false);

        if( is_array($eanAssigned) && !empty($eanAssigned['id'])){
            $response['success'] = true;
            $response['data']['ean'] = $eanAssigned['code'];
            die( json_encode($response) );
        }
        else{
            $eanFree = Db::getInstance()->getRow('
                SELECT *
                FROM `'._DB_PREFIX_.'ean`
                WHERE `used` = 0
            ', false);
            if( is_array($eanFree) && !empty($eanFree['id']) ){
                
                $result = Db::getInstance()->update('ean', array(
                    'used' => 1,
                    'supplier_reference' => pSQL($reference),
                    'keeper' => Ean::KEEPER_VIPDRESS
                ), 'id = '. $eanFree['id']);
                
                $response['success'] = true;
                $response['data']['ean'] = $eanFree['code'];
                die( json_encode($response) );
            }
            else{
                $response['success'] = false;
                $response['messages'] = 'NO_FREE_EAN';
                die( json_encode($response) );
            }
        }
            
        die( json_encode($response) );
    }
    
    public function actionSetEanUsed()
    {
        $response = array('success' => false, 'data' => array(), 'messages' => array());
        $ean = $_POST['ean'];
        $used = intval($_POST['used']);
        $reference = $_POST['reference'];
        
        $eanToUpdate = Db::getInstance()->getRow('
            SELECT *
            FROM `'._DB_PREFIX_.'ean`
            WHERE `code` = "'. pSQL($ean) .'"
        ', false);
        
        if( !is_array($eanToUpdate) || empty($eanToUpdate['id']) ){
            $response['success'] = false;
            $response['messages'] = 'EAN_NOT_FOUND';
            die( json_encode($response) );
        }
        
        if( $used ){
            if($eanToUpdate['used'] == '1'){
                if( $eanToUpdate['supplier_reference'] == $reference ){
                    $response['success'] = true;
                    die( json_encode($response) );
                }
                else{
                    $response['success'] = false;
                    $response['messages'] = 'EAN_ALREADY_USED';
                    die( json_encode($response) );
                }
            }
            else{
                $result = Db::getInstance()->update('ean', array(
                    'used' => 1,
                    'supplier_reference' => pSQL($reference),
                    'keeper' => Ean::KEEPER_VIPDRESS
                ), 'id = '. $eanToUpdate['id']);
                
                if($result){
                    $response['success'] = true;
                }
                else{
                    $response['success'] = false;
                    $response['messages'] = Db::getInstance()->displayError();
                }
                die( json_encode($response) );
            }
        }
        else{
            
        }
    }
}

