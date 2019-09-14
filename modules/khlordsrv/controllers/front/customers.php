<?php

class KhlordsrvCustomersModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $action = Tools::getValue('action');
    
        switch($action){
            case 'create':
            //case 'get':
                $this->processCommand($action);
                break;
    
            case 'help_app':
                $this->content_only = true;
                $this->display_header = false;
                $this->display_footer = false;
    
                return $this->setTemplate('doc_app.tpl');
                break;
    
            default:
                break;
        }
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
    
    public function processCommand($action)
    {
        $this->ajax = true;
    
        $responseData = array(
            'success' => false,
            'data' => array(),
            'messages' => array()
        );
    
        $authenticated = false;
        $customerId = null;
    
        if( isset($_GET['ws_key']) ){
            try{
                $this->authenticateByWsKey();
                $authenticated = true;
            }
            catch(Exception $e){
                $responseData['messages'][] = $e->getMessage();
            }
        }
        else{
            $responseData['messages'][] = 'Not authenticated (111)';
        }
    
    
    
        if( $authenticated ){
            if( $action == 'create' ){
                $input = file_get_contents('php://input');
                
                $postData = json_decode($input, true);
                
                if( ($_SERVER['REQUEST_METHOD'] != 'POST') || !is_array($postData) ){
                    $responseData['messages'][] = 'Invalid request';
                }
                else{
                    $actionData = $this->createCustomer($postData);
                    
                    if( $actionData['success'] ){
                        $responseData['success'] = true;
                        $responseData['data']['customer'] = $actionData['data']['customer'];
                    }
                    else{
                        $responseData['messages'] = $actionData['messages'];
                    }
                }
            }
            /*elseif( $action == 'get' ){
                $id_order = intval($_GET['order_id']);
                try{
                    $responseData['data'] = $this->getOrder($customer, $id_order);
                    $responseData['success'] = true;
                }
                catch (Exception $e){
                    $responseData['message'] = $e->getMessage();
                    $responseData['success'] = false;
                }
    
            }*/
        }
    
        echo json_encode($responseData);
    }
    
    protected function createCustomer($customerData)
    {
        $actionData = array(
            'success' => false,
            'data' => array(),
            'messages' => array()
        );
        
        if( ($validation = $this->validateCustomerData($customerData)) !== true ){
            $actionData['messages'] = $validation;
            return $actionData;
        }
        
        $customerLanguageId = intval(Configuration::get('PS_LANG_DEFAULT'));
        if( !empty($customerData['lang_id']) && intval($customerData['lang_id']) ){
            $customerLanguageId = intval($customerData['lang_id']);
        }
        
        $customerGroupsDefaultId = 3;
        
        $customer = new Customer();
        $customer->id_shop = $this->context->shop->id ;
        $customer->id_lang = $customerLanguageId;
        $customer->firstname = $customerData['firstname'];
        $customer->lastname = $customerData['lastname'];
        $customer->email = $customerData['email'];
        $customer->passwd = Tools::passwdGen(8);
        if( !empty($customerData['siret']) ){
            $customer->siret = $customerData['siret'];
        }
        $customer->company = $customerData['company'];
        
        $customer->id_country = intval($customerData['country_id']);
        $customer->id_default_group = $customerGroupsDefaultId;
        $customer->address1 = $customerData['address1'];
        if( !empty($customerData['address2']) ){
            $customer->address2 = $customerData['address2'];
        }
        $customer->postcode = $customerData['postcode'];
        $customer->city = $customerData['city'];
        
        if( !empty($customerData['phone']) ){
            $customer->phone = $customerData['phone'];
        }
        
        try{
            $customer->add();
        }
        catch(Exception $e){
            $actionData['messages'][] = $e->getMessage();
            return $actionData;
        }
        $customer->addGroups( array($customerGroupsDefaultId) );
        
        $address = new Address();
        $address->id_customer = $customer->id;
        $address->firstname = $customerData['firstname'];
        $address->lastname = $customerData['lastname'];
        
        $address->id_country = intval($customerData['country_id']);
        $address->address1 = $customerData['address1'];
        if(!empty($customerData['address2'])){
            $address->address2 = $customerData['address2'];
        }
        $address->postcode = $customerData['postcode'];
        $address->city = $customerData['city'];
        if( !empty($customerData['phone']) ){
            $address->phone = $customerData['phone'];
        }
        $address->company = $customerData['company'];
        $address->alias = 'Main address';
        
        try{
            $address->add();
        }
        catch(Exception $e){
            $customer->delete();
            $actionData['messages'][] = $e->getMessage();
            return $actionData;
        }
        
        $actionData['success'] = true;
        unset($customer->passwd);
        $actionData['data']['customer'] = $customer;
        
        return $actionData;
    }
    
    protected function validateCustomerData($customerData)
    {
        $errors = array();
        
        if( empty($customerData['firstname']) 
            || !ValidateCore::isName($customerData['firstname'])
            || (Tools::strlen($customerData['firstname']) > 32)
        ){
            $errors[] = '"firstname": empty or invalid or too long';
        }
        
        if( empty($customerData['lastname'])
            || !ValidateCore::isName($customerData['lastname'])
            || (Tools::strlen($customerData['lastname']) > 32)
        ){
            $errors[] = '"lastname": empty or invalid or too long';
        }

        if( empty($customerData['email'])
            || !ValidateCore::isEmail($customerData['email'])
        ){
            $errors[] = '"email": empty or invalid';
        }
        
        if( Customer::customerExists($customerData['email']) ){
            $errors[] = '"email": already registered';
        }
        
        if( empty($customerData['company'])
            || !ValidateCore::isGenericName($customerData['company'])
        ){
            $errors[] = '"company": empty or invalid';
        }

        if( !empty($customerData['siret'])
            && !ValidateCore::isString($customerData['siret'])
        ){
            $errors[] = '"siret": invalid';
        }

        if( empty($customerData['country_id'])
            || !intval($customerData['country_id'])
        ){
            $errors[] = '"country_id": empty or invalid';
        }
        
        if( empty($customerData['address1'])
            || !ValidateCore::isAddress($customerData['address1'])
        ){
            $errors[] = '"address1": empty or invalid';
        }
        
        if( !empty($customerData['address2'])
            && !ValidateCore::isString($customerData['address2'])
        ){
            $errors[] = '"address2": invalid';
        }
        
        if( empty($customerData['postcode'])
            || !ValidateCore::isPostCode($customerData['postcode'])
        ){
            $errors[] = '"postcode": empty or invalid';
        }
        
        if( empty($customerData['city'])
            || !ValidateCore::isCityName($customerData['city'])
        ){
            $errors[] = '"city": empty or invalid';
        }
        
        if( !empty($customerData['phone'])
            && !ValidateCore::isPhoneNumber($customerData['phone'])
        ){
            $errors[] = '"phone": invalid';
        }

        if( count($errors) ){
            return $errors;
        }
        
        return true;
    }
}

