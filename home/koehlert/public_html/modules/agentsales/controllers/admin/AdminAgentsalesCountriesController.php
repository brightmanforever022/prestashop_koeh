<?php

class AdminAgentsalesCountriesController extends ModuleAdminController
{
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->table = 'agentsales_country';
        $this->className = 'AgentSalesCountry';
        
    }
    
    
    public function ajaxProcessList()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array(),
            'html' => ''
        );
        
        $id_agent = Tools::getValue('id_agent');
        
        /**
         * 
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query->select('ac.id, ac.postcodes, cl.name AS country_name')
            ->from('agentsales_country', 'ac')
            ->innerJoin('country_lang', 'cl', 
                'cl.id_country = ac.id_country AND cl.id_lang = '. $this->context->language->id)
            ->where('ac.id_agent = '. $id_agent)
            ->orderBy('cl.name ASC')
        ;
        
        $agentCountriesList = Db::getInstance()->executeS($query);
        foreach($agentCountriesList as &$agentCountry){
            $agentCountry['postcodes'] = str_replace("\n", '|', $agentCountry['postcodes']);
        }
        unset($agentCountry);
        
        $this->context->smarty->assign(array(
            'agent_countries_list' => $agentCountriesList
        ));
        
        $responseData['html'] = $this->context->smarty->fetch($this->module->getLocalPath() . '/views/templates/admin/agent_countries_list.tpl');
        $responseData['success'] = true;
        
        
        echo json_encode($responseData);
    }
    
    public function ajaxProcessGet()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        
        if($id){
            $agentCountry = new AgentSalesCountry($id);
        }
        else{
            $responseData['message'] = 'ID not set';
            echo json_encode($responseData);
            die;
        }
        
        if( !ValidateCore::isLoadedObject($agentCountry) ){
            $responseData['message'] = 'Object not found';
            echo json_encode($responseData);
            die;
        }
        
        $responseData['success'] = true;
        $responseData['data'] = $agentCountry->getFields();
        
        echo json_encode($responseData);
    }
    
    public function ajaxProcessEdit()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        $id = Tools::getValue('id', null);
        
        if($id){
            $agentCountry = new AgentSalesCountry($id);
            
            if( !ValidateCore::isLoadedObject($agentCountry) ){
                $responseData['message'] = 'Object not found';
                echo json_encode($responseData);
                die;
            }
            
        }
        else{
            $agentCountry = new AgentSalesCountry();
        }
        
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
            $id_agent = intval($_POST['id_agent']);
            $id_country = intval($_POST['id_country']);
            $postcodesBulk = $_POST['postcodes'];
            
            $agentCountry->id_agent = $id_agent;
            $agentCountry->id_country = $id_country;
            
            $postcodesList = array();
            $postcodesListRaw = explode(PHP_EOL, $postcodesBulk);
            
            if( is_array($postcodesListRaw) ){
                foreach($postcodesListRaw as $postcodeRaw){
                    $postcodeRaw = preg_replace('#[^a-z0-9]#i', '', $postcodeRaw);
                    
                    if( strlen($postcodeRaw) ){
                        $postcodesList[] = $postcodeRaw;
                    }
                }
                
                if( count($postcodesList) ){
                    $agentCountry->postcodes = implode("\n", $postcodesList);
                }
            }
            
            try{
                $agentCountry->save();
                $responseData['success'] = true;
                $responseData['data'] = $agentCountry->getFields();
                
                // reset object, so form will be empty
                $agentCountry = new AgentSalesCountry();
            }
            catch( Exception $e ){
                $responseData['message'] = $e->getMessage();
            }
            
        }
        else{
            $responseData['data'] = $agentCountry->getFields();
            $responseData['success'] = true;
        }
        
        $countriesList = CountryCore::getCountries($this->context->language->id);
        $countriesOptions = array();
        foreach($countriesList as $countryData){
            $countriesOptions[ $countryData['id_country'] ] = $countryData['country'];
        }
        
        $this->context->smarty->assign(array(
            'agent_country' => $agentCountry->getFields(),
            'countries_options' => $countriesOptions
        ));
        
        $responseData['html'] = $this->context->smarty->fetch($this->module->getLocalPath() . '/views/templates/admin/agent_country_form.tpl');
        
        echo json_encode($responseData);
    }
    
    public function ajaxProcessDelete()
    {
        $responseData = array(
            'success' => false,
            'message' => '',
            'data' => array()
        );
        
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        
        if($id){
            $agentCountry = new AgentSalesCountry($id);
        }
        else{
            $responseData['message'] = 'ID not set';
            echo json_encode($responseData);
            die;
        }
        
        if( !ValidateCore::isLoadedObject($agentCountry) ){
            $responseData['message'] = 'Object not found';
            echo json_encode($responseData);
            die;
        }
        
        try{
            $agentCountry->delete();
            $responseData['success'] = true;
        }
        catch( Exception $e ){
            $responseData['message'] = $e->getMessage();
        }
        
        echo json_encode($responseData);
        
    }
}