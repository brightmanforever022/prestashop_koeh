<?php
ini_set('opcache.enable', false);


require realpath(dirname(__FILE__)) . '/../../config/config.inc.php';
require './agentsales.php';
@ini_set('display_errors', 'on');
@error_reporting(E_ALL | E_STRICT);


$module = new Agentsales();

$agents = $module->getAgentsList();
echo 'jjj';
echo '<pre>';var_dump($agents);echo '</pre>';
foreach( $agents as $agentData ){
    $agentCountriesList = json_decode($agentData['agentsales_countries']);
    var_dump($agentData, $agentCountriesList);
    
    if( !empty($agentData['agentsales_postcodes']) ){
        Db::getInstance()->insert('agentsales_country', array(
            'id_agent' => $agentData['id_customer'],
            'id_country' => 1,
            'postcodes' => $agentData['agentsales_postcodes']
        ));
        
    }
    
    if( !is_array($agentCountriesList) || !count($agentCountriesList) ){
        continue;
    }
    
    
    
    foreach( $agentCountriesList as $agentCountryId ){
        $agentCountryId = intval($agentCountryId);
        
        Db::getInstance()->insert('agentsales_country', array(
            'id_agent' => $agentData['id_customer'],
            'id_country' => $agentCountryId
        ));
    }
}