<?php

class WebserviceRequest extends WebserviceRequestCore
{
    public static function getResources()
    {
        $resources = parent::getResources();
        
        $resources['order_packages'] = array(
            'description' => 'Order picking list', 
            'class' => 'OrderPackage'
        );
        
        $resources['order_package_details'] = array(
            'description' => 'Order picking list details',
            'class' => 'OrderPackageDetail'
        );
        
        $resources['order_types'] = array(
            'description' => 'Order types',
            'class' => 'OrderType'
        );
        
        ksort($resources);
        return $resources;
        
    }
    
    protected function returnOutput()
    {
        $return = parent::returnOutput();
        
        if( !empty($return['content']) ){
            $logMessage = 'Request URI: '. $_SERVER['REQUEST_URI'] . PHP_EOL;
            // convert xml/html to something not stripped
            $logMessage .= 'Request body: '. str_replace(array('<','>'), array('[',']'), $this->_inputXml);
            $logMessage .= 'Response body: '. str_replace(array('<','>'), array('[',']'), $return['content']);
            PrestaShopLogger::addLog($logMessage);
        }
        
        return $return;
    }
}