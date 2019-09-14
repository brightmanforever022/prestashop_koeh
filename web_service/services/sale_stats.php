<?php

require_once _PS_MODULE_DIR_ . '/khlbasic/classes/KoehlertSaleStats.php';

function getSaleStats()
{
    $response = array(
        'status' => false,
        'message' => '',
        'data' => array()
    );
    if( ($_POST['web_service'] == 'sale_stats_daily') && !empty($_POST['date_year_month']) ){
        $dateYearMonthParts = explode('-', $_POST['date_year_month']);
        
        $dateFrom = $dateYearMonthParts[0] .'-'. $dateYearMonthParts[1] . '-01';
        $dateTo = $dateYearMonthParts[0] .'-'. $dateYearMonthParts[1] . '-01';
        
        $dateFromObj = new DateTime($dateFrom);
        
        $dateToObj = new DateTime($dateTo);
        $dateToObj->modify( '+1 month' );
        $dateToObj->modify( '-1 day' );
        
        $filterParams = prepareSaleStatsFilters();
        
        $stats = KoehlertSaleStats::getDaily($dateFromObj, $dateToObj, $filterParams);
        
        $response['status'] = true;
        $response['data'] = $stats;
    }
    elseif( ($_POST['web_service'] == 'sale_stats_weekly') && !empty($_POST['date_year']) ){
        $dateFrom = $_POST['date_year'] .'-01-01';
        $dateTo = $_POST['date_year'] .'-01-01';
        
        $dateFromObj = new DateTime($dateFrom);
        
        $dateToObj = new DateTime($dateTo);
        $dateToObj->modify( '+1 year' );
        $dateToObj->modify( '-1 day' );
        
        $filterParams = prepareSaleStatsFilters();
        
        $stats = KoehlertSaleStats::getWeekly($dateFromObj, $dateToObj, $filterParams);
        
        $response['status'] = true;
        $response['data'] = $stats;
        
    }
    elseif( ($_POST['web_service'] == 'sale_stats_monthly') && !empty($_POST['date_year']) ){
        $dateFrom = $_POST['date_year'] .'-01-01';
        $dateTo = $_POST['date_year'] .'-01-01';
        
        $dateFromObj = new DateTime($dateFrom);
        
        $dateToObj = new DateTime($dateTo);
        $dateToObj->modify( '+1 year' );
        $dateToObj->modify( '-1 day' );
        
        $filterParams = prepareSaleStatsFilters();
        
        $stats = KoehlertSaleStats::getMonthly($dateFromObj, $dateToObj, $filterParams);
        
        $response['status'] = true;
        $response['data'] = $stats;
        
    }
    else{
        $response['message'] = 'Invalid web_service or parameters';
    }
    
    return $response;
}

function prepareSaleStatsFilters()
{
    $filterParams = array();
    mb_regex_encoding('UTF-8');
    
    if( !empty($_POST['customer_name']) ){
        $filterParams['customer_name'] = mb_eregi_replace ('#[<>"\?\%\*]#u', '', $_POST['customer_name']);
    }
    
    if( !empty($_POST['company_name']) ){
        $filterParams['company_name'] = mb_eregi_replace ('#[<>"\?\%\*]#u', '', $_POST['company_name']);
    }
    
    if( isset($_POST['country_id']) && is_array($_POST['country_id']) ){
        $filterParams['country_id'] = array_map(function($val){
            return intval($val);
        }, $_POST['country_id']);
    }
    
    if( isset($_POST['agent_id']) && is_array($_POST['agent_id']) ){
        $filterParams['agent_id'] = array_map(function($val){
            return intval($val);
        }, $_POST['agent_id']);
    }
    
    return $filterParams;
    
}