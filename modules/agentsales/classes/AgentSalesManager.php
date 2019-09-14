<?php

class AgentSalesManager
{
    protected $module;
    
    /**
     * 
     * @param Agentsales $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }
    
    /**
     * 
     * @param Customer $customer
     */
    public function getAreaAgents($customer)
    {
        $areaAgents = array();
        
        if( !empty($customer->agentsales_id_agent) ){
            $areaAgents[] = new Customer($customer->agentsales_id_agent);
        }

        /*
        $agents = $this->module->getAgentsList();
        foreach($agents as $agentData){
            
        }
        */
        $agentsCustomerGroup = (int)Configuration::get('AGENTSALES_AGENT_GROUP');
        /**
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query
            ->select('c.id_customer AS id_agent, c.company, c.firstname, c.lastname, c.email, agentsales_commision_type,
                agentsales_commision_value, agentsales_id_employee, ac.postcodes')
            ->from('customer', 'c')
            ->innerJoin('customer_group', 'g', 'g.id_customer = c.id_customer')
            ->innerJoin('agentsales_country', 'ac', 'ac.id_agent = c.id_customer')
            ->where('g.id_group = '. $agentsCustomerGroup)
            ->where('ac.id_country = '. intval($customer->id_country))
            ->orderBy('c.lastname')
        ;
        
        $areaAgentsMatchList = Db::getInstance()->executeS($query);
        
        foreach($areaAgentsMatchList as $areaAgentsMatchData){
            $agent = new Customer($areaAgentsMatchData['id_agent']);
            
            if( !empty($agent->agentsales_customer_exclude) ){
                $agentsCustomersExcludeIds = explode(PHP_EOL, $agent->agentsales_customer_exclude);
                $agentsCustomersExcludeIds = array_map('intval', (array)$agentsCustomersExcludeIds);
                
                if(is_array($agentsCustomersExcludeIds) && in_array(intval($customer->id), $agentsCustomersExcludeIds)){
                    continue;
                }
            }
            
            $countryPostcodes = explode("\n", $areaAgentsMatchData['postcodes']);
            $countryPostcodes = array_map('trim', $countryPostcodes);
            $countryPostcodes = array_filter($countryPostcodes, function($val){
                return strlen($val) > 0;
            });
            // if no postcodes set, this agent linked to entire country
            if( empty($countryPostcodes) ){
                $areaAgents[] = $agent;
            }
            elseif( is_array($countryPostcodes) && count($countryPostcodes) ){
                foreach($countryPostcodes as $countryPostcode){
                    $countryPostcode = preg_quote($countryPostcode, '#');
                    if( preg_match('#^'. $countryPostcode .'#', $customer->postcode) ){
                        $areaAgents[] = $agent;
                    }
                }
            }
        }
        
        return $areaAgents;
    }
}

