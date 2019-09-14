<?php

class DbkSaleStats
{
    public static function getDaily($dateFrom = null, $dateTo = null, $shopId = null)
    {
        $statsQuery = '
            SELECT
                SUM(`quantity`) AS sold_quantity,
                SUM(`dbk_sale_price` * `quantity`) AS dbk_income,
                SUM(`sale_price` * `quantity`) AS ck_income,
                DATE_FORMAT(`sale_date`, "%Y-%m-%d") AS report_date
            FROM '.VIPDRESS_DB_NAME.'.`os_dbk_sale`
            WHERE `quantity` > 0
                AND `deleted` = 0
        ';
        if( !is_null($dateFrom) && preg_match('#\d{4}-\d{2}-\d{2}#', $dateFrom) ){
            $dateFrom .= ' 00:00:00';
            $statsQuery .= ' AND `sale_date` >= "'. $dateFrom .'"';
        }
        
        if( !is_null($dateTo) && preg_match('#\d{4}-\d{2}-\d{2}#', $dateTo) ){
            $dateTo .= ' 23:59:59';
            $statsQuery .= ' AND `sale_date` <= "'. $dateTo .'"';
        }
        
        if ( !is_null($shopId) ) {
            $shopId = intval($shopId);
            $statsQuery .= ' AND `shop_id` = '. $shopId;
        }
        $statsQuery .= '
            GROUP BY report_date
            ORDER BY report_date DESC
        ';

        try{
            $result = Db::getInstance()->executeS($statsQuery);
        }
        catch(Exception $e){
            throw new Exception('Database SQL query error');
        }
        
        return $result;
    }
    
    public static function getMonthly($dateFrom = null, $dateTo = null, $shopId = null)
    {
        $statsQuery = '
            SELECT
                SUM(`quantity`) AS sold_quantity,
                SUM(`dbk_sale_price` * `quantity`) AS dbk_income,
                SUM(`sale_price` * `quantity`) AS ck_income,
                DATE_FORMAT(`sale_date`, "%Y-%m") AS report_date
            FROM '.VIPDRESS_DB_NAME.'.`os_dbk_sale`
            WHERE `quantity` > 0
                AND `deleted` = 0
        ';
        if( !is_null($dateFrom) && preg_match('#\d{4}-\d{2}#', $dateFrom) ){
            $dateFrom .= '-01 00:00:00';
            $statsQuery .= ' AND `sale_date` >= "'. $dateFrom .'"';
        }
    
        if( !is_null($dateTo) && preg_match('#\d{4}-\d{2}#', $dateTo) ){
            //$dateTo .= ' 23:59:59';
            $dateToParts = explode('-', $dateTo);
            $dateToInSeconds = mktime(0,0,0, ($dateToParts[1] + 1), 0, $dateToParts[0] );
            $dateTo = date('Y-m-d 23:59:59', $dateToInSeconds);
            
            $statsQuery .= ' AND `sale_date` <= "'. $dateTo .'"';
        }
    
        if ( !is_null($shopId) ) {
            $shopId = intval($shopId);
            $statsQuery .= ' AND `shop_id` = '. $shopId;
        }
        $statsQuery .= '
            GROUP BY report_date
            ORDER BY report_date DESC
        ';
    
        try{
            $result = Db::getInstance()->executeS($statsQuery);
        }
        catch(Exception $e){
            throw new Exception('Database SQL query error');
        }
    
        return $result;
    }
    
    public static function getGroupped($dateCustom = null)
    {

        $statsConfig = array(
            'sales' => array(
                'TDY' => array(
                    'label' => _('Sales today'),
                    'type' => 'qnt',
                    'sql_condition' => 'DATE(`sale_date`) = "'. date('Y-m-d') .'"',
                    'values' => array()
                ),
                'YST' => array(
                    'label' => _('Sales yesterday'),
                    'type' => 'qnt',
                    'sql_condition' => 'DATE(`sale_date`) = "'. date('Y-m-d', time() - 86400) .'"',
                    'values' => array()
                ),
                '7DY' => array(
                    'label' => _('Sales last 7 days'),
                    'type' => 'qnt',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,date('m'),date('d')-7,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'CMN' => array(
                    'label' => _('Sales this month'),
                    'type' => 'qnt',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'LMN' => array(
                    'label' => _('Sales last month'),
                    'type' => 'qnt',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))) .'"
                        AND DATE(`sale_date`) < "'. date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'CYR' => array(
                    'label' => _('Sales this year'),
                    'type' => 'qnt',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,1,1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'LYR' => array(
                    'label' => _('Sales last year'),
                    'type' => 'qnt',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,1,1,date('Y')-1)) .'"
                        AND DATE(`sale_date`) < "'. date('Y-m-d', mktime(0,0,0,1,1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
            ),
            /**
             * REVENUE
            */
            'dbk_rev' => array(
                'TDY' => array(
                    'label' => _('DBK revenue today'),
                    'type' => 'revenue',
                    'sql_column' => 'dbk_sale_price',
                    'sql_condition' => 'DATE(`sale_date`) = "'. date('Y-m-d') .'"',
                    'values' => array()
                ),
                'YST' => array(
                    'label' => _('DBK revenue yesterday'),
                    'type' => 'revenue',
                    'sql_column' => 'dbk_sale_price',
                    'sql_condition' => 'DATE(`sale_date`) = "'. date('Y-m-d', time() - 86400) .'"',
                    'values' => array()
                ),
                '7DY' => array(
                    'label' => _('DBK revenue last 7 days'),
                    'type' => 'revenue',
                    'sql_column' => 'dbk_sale_price',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,date('m'),date('d')-7,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'CMN' => array(
                    'label' => _('DBK revenue this month'),
                    'type' => 'revenue',
                    'sql_column' => 'dbk_sale_price',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'LMN' => array(
                    'label' => _('DBK revenue last month'),
                    'type' => 'revenue',
                    'sql_column' => 'dbk_sale_price',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))) .'"
                        AND DATE(`sale_date`) < "'. date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'CYR' => array(
                    'label' => _('DBK revenue this year'),
                    'type' => 'revenue',
                    'sql_column' => 'dbk_sale_price',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,1,1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'LYR' => array(
                    'label' => _('DBK revenue last year'),
                    'type' => 'revenue',
                    'sql_column' => 'dbk_sale_price',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,1,1,date('Y')-1)) .'"
                        AND DATE(`sale_date`) < "'. date('Y-m-d', mktime(0,0,0,1,1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
            ),
            'ck_rev' => array(
                'TDY' => array(
                    'label' => _('CK revenue today'),
                    'type' => 'revenue',
                    'sql_column' => 'sale_price',
                    'sql_condition' => 'DATE(`sale_date`) = "'. date('Y-m-d') .'"',
                    'values' => array()
                ),
                'YST' => array(
                    'label' => _('CK revenue yesterday'),
                    'type' => 'revenue',
                    'sql_column' => 'sale_price',
                    'sql_condition' => 'DATE(`sale_date`) = "'. date('Y-m-d', time() - 86400) .'"',
                    'values' => array()
                ),
                '7DY' => array(
                    'label' => _('CK revenue last 7 days'),
                    'type' => 'revenue',
                    'sql_column' => 'sale_price',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,date('m'),date('d')-7,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'CMN' => array(
                    'label' => _('CK revenue this month'),
                    'type' => 'revenue',
                    'sql_column' => 'sale_price',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'LMN' => array(
                    'label' => _('CK revenue last month'),
                    'type' => 'revenue',
                    'sql_column' => 'sale_price',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y'))) .'"
                        AND DATE(`sale_date`) < "'. date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'CYR' => array(
                    'label' => _('CK revenue this year'),
                    'type' => 'revenue',
                    'sql_column' => 'sale_price',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,1,1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
                'LYR' => array(
                    'label' => _('CK revenue last year'),
                    'type' => 'revenue',
                    'sql_column' => 'sale_price',
                    'sql_condition' => '
                        DATE(`sale_date`) >= "'. date('Y-m-d', mktime(0,0,0,1,1,date('Y')-1)) .'"
                        AND DATE(`sale_date`) < "'. date('Y-m-d', mktime(0,0,0,1,1,date('Y'))) .'"
                    ',
                    'values' => array()
                ),
            ),
        
            /**
             * REVENUE overall
            */
            'total_rev' => array(
                'DBK' => array(
                    'label' => _('Total DBK Revenue'),
                    'type' => 'revenue',
                    'sql_column' => 'dbk_sale_price',
                    'sql_condition' => '1=1',
                    'values' => array()
                ),
                'CK' => array(
                    'label' => _('Total CK Revenue'),
                    'type' => 'revenue',
                    'sql_column' => 'sale_price',
                    'sql_condition' => '1=1',
                    'values' => array()
                )
        
            )
        
        );
        
        if( !empty($dateCustom) && preg_match('#\d{4}-\d{2}-\d{2}#', $dateCustom) ){
            $statsConfig['sales']['CST'] = array(
                'label' => _('Sales custom'),
                'type' => 'qnt',
                'sql_condition' => 'DATE(`sale_date`) = "'. $dateCustom .'"',
                'values' => array()
            );
            $statsConfig['dbk_rev']['CST'] = array(
                'label' => _('DBK revenue custom'),
                'type' => 'revenue',
                'sql_column' => 'dbk_sale_price',
                'sql_condition' => 'DATE(`sale_date`) = "'. $dateCustom .'"',
                'values' => array()
            );
            $statsConfig['ck_rev']['CST'] = array(
                'label' => _('CK revenue custom'),
                'type' => 'revenue',
                'sql_column' => 'sale_price',
                'sql_condition' => 'DATE(`sale_date`) = "'. $dateCustom .'"',
                'values' => array()
            );
        
        }
        
        $shopsSql = 'select * from '.VIPDRESS_DB_NAME.'.os_dbk_shop where id != 12';
        
        //$dbkCities = $conn->query($shopsSql)->fetch_all(MYSQLI_ASSOC);
        try{
            $dbkCities = Db::getInstance()->executeS($shopsSql);
        }
        catch(Exception $e){
            throw new Exception('Database SQL query error');
        }
        
        
        foreach($statsConfig as $cnfGroupKey => $cnfGroups){
            foreach( $cnfGroups as $ci => $cnfGroup ){
                $statsConfig[$cnfGroupKey][$ci]['values']['total'] = 0;
                foreach( $dbkCities as $city ){
        
                    if( $statsConfig[$cnfGroupKey][$ci]['type'] == 'qnt' ){
                        $query = '
                            SELECT SUM(`quantity`) AS sold_quantity
                            FROM '.VIPDRESS_DB_NAME.'.`os_dbk_sale`
                            WHERE shop_id = '. $city['id'] .'
                                AND `quantity` > 0
                                AND `deleted` = 0
                                AND '. $statsConfig[$cnfGroupKey][$ci]['sql_condition'] .'
                        ';
                        //$value = $conn->query($query)->fetch_assoc();
                        //$soldQuantity = intval( $value['sold_quantity'] );
                        try{
                            $value = Db::getInstance()->getValue($query);
                        }
                        catch(Exception $e){
                            throw new Exception('Database SQL query error');
                        }
                        
                        $soldQuantity = intval( $value );
                        $statsConfig[$cnfGroupKey][$ci]['values'][$city['id']] = $soldQuantity;
                        $statsConfig[$cnfGroupKey][$ci]['values']['total'] += $soldQuantity;
                    }
                    elseif( $statsConfig[$cnfGroupKey][$ci]['type'] == 'revenue' ){
                        $query = '
                            SELECT SUM(`'. $statsConfig[$cnfGroupKey][$ci]['sql_column'] .'` * `quantity`) AS revenue_sum
                            FROM '.VIPDRESS_DB_NAME.'.`os_dbk_sale`
                            WHERE shop_id = '. $city['id'] .'
                                AND `quantity` > 0
                                AND `deleted` = 0
                                AND '. $statsConfig[$cnfGroupKey][$ci]['sql_condition'] .'
                        ';
        
                        //$value = $conn->query($query)->fetch_assoc();
                        //$revenueSum = floatval( $value['revenue_sum'] );
                        try{
                            $value = Db::getInstance()->getValue($query);
                        }
                        catch(Exception $e){
                            throw new Exception('Database SQL query error');
                        }
                        
                        $revenueSum = floatval( $value );
                        $statsConfig[$cnfGroupKey][$ci]['values'][$city['id']] = $revenueSum;
                        $statsConfig[$cnfGroupKey][$ci]['values']['total'] += $revenueSum;
        
                    }
                }
            }
        }
        //var_dump($statsConfig);
        //$statsConfig['cities'] = $dbkCities;
        return $statsConfig;
        
    }
}