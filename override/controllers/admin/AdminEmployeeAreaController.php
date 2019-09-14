<?php

class AdminEmployeeAreaController extends AdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->required_database = true;
        $this->table = 'employee_country';
        $this->className = 'EmployeeCountry';
        $this->lang = false;
        
        parent::__construct();
        
        $this->context = Context::getContext();
            
    }
    
    public function ajaxProcessList()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array(),
            'html' => ''
        );
        
        if( $this->tabAccess['view'] != '1' ){
            $responseData['message'] = 'Access denied';
            echo json_encode($responseData);
            die;
        }
        
        $id_employee = Tools::getValue('id_employee');
        
        /**
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query->select('ec.id_employee_country, cl.name AS country_name, 
                GROUP_CONCAT(ep.postcode ORDER BY ep.postcode ASC SEPARATOR "|") AS postcodes')
            ->from('employee_country', 'ec')
            ->innerJoin('country_lang', 'cl',
                'cl.id_country = ec.id_country AND cl.id_lang = '. $this->context->language->id)
            ->leftJoin('employee_postcode', 'ep', 'ep.id_employee_country = ec.id_employee_country')
            ->where('ec.id_employee = '. $id_employee)
            ->orderBy('cl.name ASC')
            ->groupBy('ec.id_employee_country')
        ;

        $employeeCountriesList = Db::getInstance()->executeS($query);
        
        $this->context->smarty->assign(array(
            'employee_countries_list' => $employeeCountriesList
        ));
        
        $responseData['html'] = $this->context->smarty->fetch($this->context->smarty->getTemplateDir(1) . 'employees/employee_countries_list.tpl');
        $responseData['success'] = true;
        
        
        echo json_encode($responseData);
    }

    public function ajaxProcessEdit()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        if( $this->tabAccess['edit'] != '1' ){
            $responseData['message'] = 'Access denied';
            echo json_encode($responseData);
            die;
        }
        
        
        $id = Tools::getValue('id', null);
        
        if($id){
            $employeeCountry = new EmployeeCountry($id);
            
            if( !ValidateCore::isLoadedObject($employeeCountry) ){
                $responseData['message'] = 'Object not found';
                echo json_encode($responseData);
                die;
            }
            
        }
        else{
            $employeeCountry = new EmployeeCountry();
        }
        
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
            $id_employee = intval($_POST['id_employee']);
            $id_country = intval($_POST['id_country']);
            
            if( empty($id_employee) ){
                $responseData['message'] = 'Employee ID not set';
                echo json_encode($responseData);
                die;
            }
            
            if( empty($id_country) ){
                $responseData['message'] = 'Country ID not set';
                echo json_encode($responseData);
                die;
            }
            
            $postcodesBulk = $_POST['postcodes'];
            
            $employeeCountry->id_employee = $id_employee;
            $employeeCountry->id_country = $id_country;
            
            try{
                $employeeCountry->save();
                $responseData['success'] = true;
                $responseData['data'] = $employeeCountry->getFields();
                $employeeCountryId = $employeeCountry->id;
                
                // reset object, so form will be empty
                $employeeCountry = new EmployeeCountry();
            }
            catch( Exception $e ){
                $responseData['message'] = $e->getMessage();
                echo json_encode($responseData);
                die;
            }
            
            Db::getInstance()->delete('employee_postcode', 'id_employee_country = '. $employeeCountryId);

            $postcodesList = array();
            $postcodesListRaw = explode(PHP_EOL, $postcodesBulk);
            
            /*$existenEmployeeCountryList = Db::getInstance()->executeS('
                SELECT *
                FROM `'._DB_PREFIX_.'employee_postcode`
                WHERE id_employee_country = '. $employeeCountryId .'
            ');*/
            
            if( is_array($postcodesListRaw) ){
                foreach($postcodesListRaw as $postcodeRaw){
                    $postcodeRaw = preg_replace('#[^a-z0-9*]#i', '', $postcodeRaw);
                    
                    if( strlen($postcodeRaw) ){
                        $postcodesList[] = $postcodeRaw;
                    }
                }
                
                if( count($postcodesList) ){
                    //$employeeCountry->postcodes = implode("\n", $postcodesList);
                    foreach($postcodesList as $postcodeItem){
                        $employeePostcode = new EmployeePostcode();
                        $employeePostcode->id_employee_country = $employeeCountryId;
                        $employeePostcode->postcode = $postcodeItem;
                        
                        try{
                            $employeePostcode->save();
                        }
                        catch( Exception $e ){
                            echo json_encode($responseData);
                            die;
                        }
                    }
                }
                else{
                    $employeePostcode = new EmployeePostcode();
                    $employeePostcode->id_employee_country = $employeeCountryId;
                    $employeePostcode->postcode = '*';
                    
                    try{
                        $employeePostcode->save();
                    }
                    catch( Exception $e ){
                        echo json_encode($responseData);
                        die;
                    }
                    
                }
            }
            
        }
        else{
            $responseData['data'] = $employeeCountry->getFields();
            $responseData['data']['postcodes'] = $employeeCountry->getPostcodesString("\n");
            $responseData['success'] = true;
        }
        
        $countriesList = CountryCore::getCountries($this->context->language->id);
        $countriesOptions = array();
        foreach($countriesList as $countryData){
            $countriesOptions[ $countryData['id_country'] ] = $countryData['country'];
        }
        
        $employeeCountryArray = $employeeCountry->getFields();
        $employeeCountryArray['postcodes'] = '';
        
        $this->context->smarty->assign(array(
            'employee_country' => $employeeCountryArray,
            'countries_options' => $countriesOptions
        ));
        
        $responseData['html'] = $this->context->smarty->fetch($this->context->smarty->getTemplateDir(1) . 'employees/employee_country_form.tpl');
        
        echo json_encode($responseData);
    }
    
    public function ajaxProcessDelete()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        if( $this->tabAccess['delete'] != '1' ){
            $responseData['message'] = 'Access denied';
            echo json_encode($responseData);
            die;
        }
        
        
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        
        if($id){
            $employeeCountry = new EmployeeCountry($id);
        }
        else{
            $responseData['message'] = 'ID not set';
            echo json_encode($responseData);
            die;
        }
        
        if( !ValidateCore::isLoadedObject($employeeCountry) ){
            $responseData['message'] = 'Object not found';
            echo json_encode($responseData);
            die;
        }
        
        try{
            $employeeCountry->delete();
            $responseData['success'] = true;
        }
        catch( Exception $e ){
            $responseData['message'] = $e->getMessage();
        }
        
        echo json_encode($responseData);
        
    }
    
}

