<?php

require realpath(dirname(__FILE__)) . '/../../config/config.inc.php';

require_once _PS_ROOT_DIR_ . '/modules/khlexclusivity/classes/Exclusivity.php';

exclusivity_cron();

function exclusivity_cron()
{
    $languageDefaultId = intval(Configuration::get('PS_LANG_DEFAULT'));
    $context = Context::getContext();
    
    /**
     * @var DbQueryCore $customersExclusivityQuery
     */
    $customersExclusivityQuery = new DbQuery();
    $customersExclusivityQuery
        ->select('id_exclusivity')
        ->from('exclusivity')
        ->where('date_start <= '. (new DateTime())->format('Ymd')  )
        ->where('date_end >= '. (new DateTime())->format('Ymd') )
        ->where('status = 1' )
    ;
    
    $customersExclusivity = Db::getInstance()->executeS($customersExclusivityQuery);

    if( !is_array($customersExclusivity) || !count($customersExclusivity) ){
        return;
    }
    
    $adminEmail = 'info@koehlert.com';
    
    foreach($customersExclusivity as $customerExclusive){
        $exclusivity = new Exclusivity($customerExclusive['id_exclusivity']);
        
        if( $exclusivity->areRequirementsSatisfied() ){
            continue;
        }
        // requirements not satisfied, react on this
        
        $notificationText = 
        "The customer {$exclusivity->getCustomer()->firstname} {$exclusivity->getCustomer()->lastname}"
        ." ( {$exclusivity->getCustomer()->email} ) did not ordered enough products for exclusivity."
        . PHP_EOL 
        ."Details can be found at Back office - Customers - Exclusivity - ID - {$exclusivity->id}";
        
        mail($adminEmail, 'Exclusivity', $notificationText);
    }
}