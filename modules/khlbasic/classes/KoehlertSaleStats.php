<?php

class KoehlertSaleStats
{
    public static $categoriesCountable = array(12,13,20,34,35,36,37);
    public static $customersIgnore = array(31,39,192,270,364,452,800,842,833,830,829);
    public static $productSplRefWordIgnore = array('position','transport');
    
    public static function getExcludedObjectsText()
    {
        $categoriesCountableNoteText = 'Categories counted: ';
        foreach(self::$categoriesCountable as $categoryCountable){
            $category = new Category($categoryCountable, Context::getContext()->language->id);
        
            $categoriesCountableNoteText .= $category->name .', ';
        }
        $categoriesCountableNoteText = trim($categoriesCountableNoteText, ', ');
        
        $customersIgnoreNoteText = 'Customer\'s orders ignored: ';
        foreach( self::$customersIgnore as $customerIgnore ){
            $customer = new Customer($customerIgnore);
            if( empty($customer->id) ){
                continue;
            }
            $customersIgnoreNoteText .= $customer->lastname .' '. $customer->firstname .', ';
        }
        $customersIgnoreNoteText = trim($customersIgnoreNoteText, ', ');
        
        $supplierRefsExcluded = 'Supplier references ignored: '
            . '"'. implode('", "', self::$productSplRefWordIgnore) .'"'
        ;
        
        return $categoriesCountableNoteText .'<br>'
            . $customersIgnoreNoteText .'<br>'
            . $supplierRefsExcluded .'<br>'
        ;
    }
    
    public static function getDaily($dateFrom, $dateTo, $filterParams = null)
    {
        if( is_string($dateFrom) ){
            $dateFrom = new DateTime($dateFrom);
        }
        
        if( is_string($dateTo) ){
            $dateTo = new DateTime($dateTo);
        }
        
        $dbQuery = self::getDbQueryObject('daily', $dateFrom, $dateTo, $filterParams);
        
        $statsDetailed = Db::getInstance()->executeS($dbQuery);

        $stats = array();
        foreach( $statsDetailed as $statsDetail ){
            if( isset($stats[ $statsDetail['report_date'] ]) ){
                $stats[ $statsDetail['report_date'] ]['sold_quantity'] += intval($statsDetail['sold_quantity']);
                $stats[ $statsDetail['report_date'] ]['sale_revenue'] += intval($statsDetail['sale_revenue']);
            }
            else{
                $stats[ $statsDetail['report_date'] ] = array(
                    'sold_quantity' => intval($statsDetail['sold_quantity']),
                    'sale_revenue' => floatval($statsDetail['sale_revenue']),
                    'report_date' => $statsDetail['report_date'],
                    'report_date_formatted' => $statsDetail['report_date_formatted']
                );
            }
        }
        
        krsort($stats);
        
        return $stats;
    }

    public static function getTest($dateFrom, $dateTo, $filterParams = null)
    {
        if( is_string($dateFrom) ){
            $dateFrom = new DateTime($dateFrom);
        }
    
        if( is_string($dateTo) ){
            $dateTo = new DateTime($dateTo);
        }
    
        $dbQuery = self::getDbQueryObject('daily', $dateFrom, $dateTo, $filterParams);
    
        $statsDetailed = Db::getInstance()->executeS($dbQuery);
    
    
        return $statsDetailed;
    }
    
    public static function getWeekly($dateFrom, $dateTo, $filterParams = null)
    {
        $statsWeekly = array();
        
        $todayDate = new DateTime();
        
        $dateFromFirstMonday = clone $dateFrom;
        $dateFromWeekDay = $dateFromFirstMonday->format('N');
        if( $dateFromWeekDay > 1 ){
            $dateFromFirstMonday->modify('-'. ($dateFromWeekDay - 1) .' day');
        }
        
        if( $dateTo > $todayDate ){
            $dateTo = new DateTime(date('Y-m-d 00:00:00'));
        }

        $dateToLastSunday = clone $dateTo;
        $dateToWeekDay = $dateToLastSunday->format('N');
        if( $dateToWeekDay < 7 ){
            $dateToLastSunday->modify('+'. (7 - $dateToWeekDay) .' days');
        }
        
        $dbQuery = self::getDbQueryObject('weekly', $dateFrom, $dateTo, $filterParams);
        $statsDaily = Db::getInstance()->executeS($dbQuery);
        $weeksFormatter = clone $dateFromFirstMonday;
        $weeksFormatter->modify('-1 days');
        while( $weeksFormatter < $dateToLastSunday ){
            $weeksFormatter->modify('+1 days');
            $weekMondayDate = clone $weeksFormatter;
            $weeksFormatter->modify('+6 days');
            $weekSundayDate = clone $weeksFormatter;
            
            $includeThisWeek = true;
            
            if( ($weekMondayDate->format('Y') != $weekSundayDate->format('Y')) 
                && ($weekMondayDate->format('n') > $weekSundayDate->format('n'))  
            ){
                // begin of a year
                if( $weekMondayDate->format('Y') < $dateTo->format('Y') ){
                    $daysSinceBeginOfYear = $weekSundayDate->format('z') + 1;
                    if( $daysSinceBeginOfYear < 4 ){
                        $includeThisWeek = false;
                    }
                }
                // end of a year
                if( ($weekSundayDate->format('Y') > $dateTo->format('Y')) ){
                    $daysToEndOfYear = ($weekMondayDate->format('L') ? 365 : 364) - $weekMondayDate->format('z');
                    $daysToEndOfYear += 1;
                    if( $daysToEndOfYear < 4 ){
                        $includeThisWeek = false;
                    }
                }
            }
            
            if( $includeThisWeek ){
                $reportDateString = $weekMondayDate->format('d.m.Y')
                    . ' - '
                    . $weekSundayDate->format('d.m.Y')
                ;
                $statsWeekly[] = array(
                    'report_date' => $reportDateString,
                    'week_number' => $weeksFormatter->format('W'),
                    'sold_quantity' => 0,
                    'sale_revenue' => 0
                );
            }
        }
        
        krsort($statsWeekly);

        foreach($statsDaily as $statsDay){
            $statDayDate = new DateTime($statsDay['report_date']);
            $statDayWeek = $statDayDate->format('W');
            
            for( $wi = 0; $wi < count($statsWeekly); $wi++ ){
                if( $statsWeekly[$wi]['week_number'] == $statDayWeek ){
                    $statsWeekly[$wi]['sold_quantity'] += $statsDay['sold_quantity'];
                    $statsWeekly[$wi]['sale_revenue'] += $statsDay['sale_revenue'];
                    break;
                }
            }
        }
        return $statsWeekly;
    }
    
    public static function getMonthly($dateFrom, $dateTo, $filterParams = null)
    {
        if( is_string($dateFrom) ){
            $dateFrom = new DateTime($dateFrom);
        }
        
        if( is_string($dateTo) ){
            $dateTo = new DateTime($dateTo);
        }
        
        $dbQuery = self::getDbQueryObject('monthly', $dateFrom, $dateTo, $filterParams);
        
        $statsDetailed = Db::getInstance()->executeS($dbQuery);
        
        $stats = array();
        foreach( $statsDetailed as $statsDetail ){
            if( isset($stats[ $statsDetail['report_date'] ]) ){
                $stats[ $statsDetail['report_date'] ]['sold_quantity'] += intval($statsDetail['sold_quantity']);
                $stats[ $statsDetail['report_date'] ]['sale_revenue'] += intval($statsDetail['sale_revenue']);
            }
            else{
                $stats[ $statsDetail['report_date'] ] = array(
                    'sold_quantity' => intval($statsDetail['sold_quantity']),
                    'sale_revenue' => floatval($statsDetail['sale_revenue']),
                    'report_date' => $statsDetail['report_date'],
                    'report_date_formatted' => $statsDetail['report_date_formatted']
                );
            }
        }
        
        krsort($stats);
        
        return $stats;
        
    }

    /**
     * 
     * @param string $period
     * @param DateTime $dateFrom
     * @param DateTime $dateTo
     * @param array $paramsAdditional
     * @return DbQueryCore
     */
    protected static function getDbQueryObject($period, $dateFrom, $dateTo, $paramsAdditional)
    {
        $dbSelectStatement = '';
        if( ($period == 'daily') || ($period == 'weekly') ){
            $dbSelectStatement = '
                od.id_order_detail, od.id_order,
                od.`product_quantity` - od.`product_quantity_refunded` - od.`product_quantity_return` - od.`product_quantity_reinjected`
                    AS sold_quantity,
                od.`unit_price_tax_excl` * (od.`product_quantity` - od.`product_quantity_refunded` - od.`product_quantity_return` - od.`product_quantity_reinjected`)
                    AS sale_revenue,
                DATE_FORMAT(o.`date_add`, "%Y-%m-%d") 
                    AS report_date,
                DATE_FORMAT(o.`date_add`, "%d.%m.%Y") 
                    AS report_date_formatted
            ';
        }
        elseif( $period == 'monthly' ){
            $dbSelectStatement = '
                od.id_order_detail, od.id_order,
                od.`product_quantity` - od.`product_quantity_refunded` - od.`product_quantity_return` - od.`product_quantity_reinjected`
                    AS sold_quantity,
                od.`unit_price_tax_excl` * (od.`product_quantity` - od.`product_quantity_refunded` - od.`product_quantity_return` - od.`product_quantity_reinjected`)
                    AS sale_revenue,
                DATE_FORMAT(o.`date_add`, "%Y-%m")
                    AS report_date,
                DATE_FORMAT(o.`date_add`, "%m.%Y")
                    AS report_date_formatted
            ';
            
        }
        
        $productSplRefWordIgnoreRegex = implode('|', self::$productSplRefWordIgnore);
        /**
         * @var DbQueryCore $dbQuery
         */
        $dbQuery = new DbQuery();
        $dbQuery
            ->select($dbSelectStatement)
            ->from('order_detail', 'od')
            ->innerJoin('orders', 'o', 'o.id_order = od.id_order')
            ->innerJoin('product', 'p', 'p.id_product = od.product_id')
            ->innerJoin('customer', 'c', 'c.id_customer = o.id_customer')
            ->innerJoin('address', 'ad', 'ad.id_address = o.id_address_delivery')
            ->where('o.current_state != '. intval(Configuration::get('PS_OS_CANCELED')) )
            ->where('od.product_supplier_reference NOT REGEXP "'. $productSplRefWordIgnoreRegex .'"')
            ->where('o.date_add >= "'. $dateFrom->format('Y-m-d 00:00:00') .'" ')
            ->where('o.date_add <= "'. $dateTo->format('Y-m-d 23:59:59') .'" ')
            ->where('p.id_category_default IN('. implode(',', self::$categoriesCountable) .')')
            ->where('o.id_customer NOT IN('. implode(',', self::$customersIgnore) .')')
            //->groupBy('report_date')
            ->orderBy('od.id_order DESC')
        ;
        
        if( !empty($paramsAdditional['customer_name']) ){
            $dbQuery->where('
                c.firstname LIKE "'. pSQL($paramsAdditional['customer_name']) .'%"
                OR 
                c.lastname LIKE "'. pSQL($paramsAdditional['customer_name']) .'%"
            ');
        }
        if( !empty($paramsAdditional['company_name']) ){
            $dbQuery->where('
                c.company LIKE "'. pSQL($paramsAdditional['company_name']) .'%"
            ');
        }
        if( isset($paramsAdditional['country_id']) && is_array($paramsAdditional['country_id']) && count($paramsAdditional['country_id']) ){
            $paramsAdditional['country_id'] = array_map(function($val){
                return intval($val);
            }, $paramsAdditional['country_id']); 
            $dbQuery->where('
                c.id_country IN ('. pSQL(implode(',', $paramsAdditional['country_id'])) .')
                OR
                ad.id_country IN ('. pSQL(implode(',', $paramsAdditional['country_id'])) .')
            ');
            
        }
        if( isset($paramsAdditional['agent_id']) && is_array($paramsAdditional['agent_id']) && count($paramsAdditional['agent_id']) ){
            $paramsAdditional['agent_id'] = array_map(function($val){
                return intval($val);
            }, $paramsAdditional['agent_id']);
            
            $dbQuery->innerJoin('agentsales_order', 'aso', 'aso.id_order = o.id_order');
            $dbQuery->where('
                aso.id_agent IN ('. pSQL(implode(',', $paramsAdditional['agent_id'])) .')
            ');
        }
        //echo $dbQuery->build();die;
        return $dbQuery;
    }
}