<?php

class KhlbasicEmployeeModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        set_time_limit(0);
        switch( Tools::getValue('action') ){
            case 'login':
                $this->loginEmployee();
                break;
            default:
                $this->getEmployee();
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
    
    
    public function loginEmployee()
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
        
        $postInput = file_get_contents('php://input');
        $postJson = json_decode($postInput, true);
        
        if( ($postJson === false) || !is_array($postJson) ){
            $responseData['success'] = false;
            $responseData['message'] = 'Invalid request, json not decoded';
            echo json_encode($responseData);die;
        }
        
        $requiredFields = array('email','password');
        $hasRequiredFields = true;
        foreach( $requiredFields as $requiredField ){
            if( !isset( $postJson[$requiredField] ) ){
                $hasRequiredFields = false;
            }
        }
        
        if(!$hasRequiredFields){
            $responseData['success'] = false;
            $responseData['message'] = 'Required fields not sent';
            echo json_encode($responseData);die;
        }
        
        $userEmail = $postJson['email'];
        $userPassword = $postJson['password'];
        
        $employeeData = Db::getInstance()->getRow('
    		SELECT *
    		FROM `'._DB_PREFIX_.'employee`
    		WHERE 
                `email` = "'.pSQL($userEmail).'"
                AND `active_ws` = 1 
                AND `passwd` = "'.Tools::encrypt($userPassword).'"
        ');
        
        if( !is_array($employeeData) || !count($employeeData) ){
            $responseData['success'] = false;
            $responseData['message'] = 'Invalid credentials';
            echo json_encode($responseData);die;
        }
        
        $responseData['success'] = true;
        unset($employeeData['passwd']);
        $responseData['data'] = $employeeData;
        echo json_encode($responseData);die;
    }
    
    public function getEmployee()
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
        
        $employeeId = Tools::getValue('id_employee', null);
        if( is_null($employeeId) ){
            $responseData['success'] = false;
            $responseData['message'] = 'Required parameters not set';
            echo json_encode($responseData);die;
        }
        
        $employeeId = intval($employeeId);
        
        $employeeData = Db::getInstance()->getRow('
    		SELECT *
    		FROM `'._DB_PREFIX_.'employee`
    		WHERE id_employee = '. intval($employeeId) .'
        ');
        
        if( !is_array($employeeData) || !count($employeeData) ){
            $responseData['success'] = false;
            $responseData['message'] = 'Employee not found';
            echo json_encode($responseData);die;
        }
        
        $responseData['success'] = true;
        unset($employeeData['passwd']);
        $responseData['data'] = $employeeData;
        echo json_encode($responseData);die;
        
    }
}