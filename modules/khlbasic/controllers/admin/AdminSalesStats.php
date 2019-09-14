<?php

require_once _PS_MODULE_DIR_ . '/khlbasic/classes/KoehlertSaleStats.php';
require_once _PS_TOOL_DIR_ . 'php_excel/PHPExcel.php';

class AdminSalesStatsController extends ModuleAdminController
{
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->context = Context::getContext();
    }
    
    public function setMedia()
    {
        parent::setMedia();
        
        $this->addJS( $this->module->getPath() .'statistics.js' );
        
        $this->addJS(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.js');
        $this->addCss(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.css');
        
    }
    
    public function init()
    {
        parent::init();
        
        if( empty($_GET['action']) && empty($_POST['action']) ){
            $this->action = 'index';
        }
        
    }
    
    public function processIndex()
    {
        //$statsDaily = KoehlertSaleStats::getDaily('2018-03-01', '2018-03-31');
        //var_dump($statsDaily);
        $this->context->smarty->assign('currentIndex', self::$currentIndex);
        $stats_mode = Tools::getValue('mode', 'daily');
        $this->context->smarty->assign('stats_mode', $stats_mode);
        
        
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
			SELECT DISTINCT c.id_country, cl.`name`
			FROM `'._DB_PREFIX_.'orders` o
			'.Shop::addSqlAssociation('orders', 'o').'
			INNER JOIN `'._DB_PREFIX_.'address` a ON a.id_address = o.id_address_delivery
			INNER JOIN `'._DB_PREFIX_.'country` c ON a.id_country = c.id_country
			INNER JOIN `'._DB_PREFIX_.'country_lang` cl ON (c.`id_country` = cl.`id_country` AND cl.`id_lang` = '.(int)$this->context->language->id.')
			ORDER BY cl.name ASC
        ');
        
        $country_array = array();
        foreach ($result as $row) {
            $country_array[$row['id_country']] = $row['name'];
        }
        $this->context->smarty->assign('countries_list', $country_array);
        
        $agentSalesModule = Module::getInstanceByName('agentsales');
        $agents = $agentSalesModule->getAgentsList(0);
        $agentsFilterOptions = array();
        foreach($agents as $agent){
            $agentsFilterOptions[ $agent['id_customer'] ] = $agent['firstname'] .' '. $agent['lastname'];
        }
        $this->context->smarty->assign('agents_list', $agentsFilterOptions);
        
        $this->context->smarty->assign('note_text', KoehlertSaleStats::getExcludedObjectsText());
        
        $this->content .= $this->context->smarty->fetch($this->module->getTemplatePath('views/templates/admin/salesstats/stats.tpl'));
        $this->context->smarty->assign('content', $this->content);
        
    }
    
    protected function prepareRequestFilterParams()
    {
        $filterParams = array();
        mb_regex_encoding('UTF-8');
        
        if( !empty($_GET['customer_name']) ){
            $filterParams['customer_name'] = mb_eregi_replace ('#[<>"\?\%\*]#u', '', $_GET['customer_name']);
        }
        
        if( !empty($_GET['company_name']) ){
            $filterParams['company_name'] = mb_eregi_replace ('#[<>"\?\%\*]#u', '', $_GET['company_name']);
        }
        
        if( isset($_GET['country_id']) && is_array($_GET['country_id']) ){
            $filterParams['country_id'] = array_map(function($val){
                return intval($val);
            }, $_GET['country_id']);
        }
        
        if( isset($_GET['agent_id']) && is_array($_GET['agent_id']) ){
            $filterParams['agent_id'] = array_map(function($val){
                return intval($val);
            }, $_GET['agent_id']);
        }
        
        return $filterParams;
    }
    
    public function ajaxProcessGetDaily()
    {
        if( !empty($_GET['date_from']) && $_GET['date_to'] ){
            $dateFrom = $_GET['date_from'];
            $dateTo = $_GET['date_to'];
            
            $dateFromObj = new DateTime($dateFrom);
            $dateToObj = new DateTime($dateTo);
            
        }
        elseif( !empty($_GET['date_year_month']) ){
            $dateYearMonthParts = explode('-', $_GET['date_year_month']);
            
            $dateFrom = $dateYearMonthParts[0] .'-'. $dateYearMonthParts[1] . '-01';
            $dateTo = $dateYearMonthParts[0] .'-'. $dateYearMonthParts[1] . '-01';
            
            $dateFromObj = new DateTime($dateFrom);
            
            $dateToObj = new DateTime($dateTo);
            $dateToObj->modify( '+1 month' );
            $dateToObj->modify( '-1 day' );
        }
        
        $filterParams = $this->prepareRequestFilterParams();

        $statsDaily = KoehlertSaleStats::getDaily($dateFromObj, $dateToObj, $filterParams);
        
        if( count($statsDaily) == 0 ){
            array_push($statsDaily, array('no_records' => true));
        }
        
        array_unshift( $statsDaily, array('period_name' => $dateFromObj->format('Y F')) );

        $this->context->smarty->assign('stats_daily', $statsDaily);
        $stats_rows = $this->context->smarty->fetch($this->module->getTemplatePath('views/templates/admin/salesstats/stats_daily_rows.tpl'));
        
        echo json_encode(array(
            'stats_html' => $stats_rows,
        ));
    }
    
    public function ajaxProcessGetWeekly()
    {
        $this->ajax = true;
        if( !empty($_GET['date_from']) && $_GET['date_to'] ){
            $dateFrom = $_GET['date_from'];
            $dateTo = $_GET['date_to'];
        
            $dateFromObj = new DateTime($dateFrom);
            $dateToObj = new DateTime($dateTo);
        
        }
        elseif( !empty($_GET['date_year']) ){
            //$dateYearMonthParts = explode('-', $_GET['date_year_month']);
        
            $dateFrom = $_GET['date_year'] .'-01-01';
            $dateTo = $_GET['date_year'] .'-01-01';
        
            $dateFromObj = new DateTime($dateFrom);
        
            $dateToObj = new DateTime($dateTo);
            $dateToObj->modify( '+1 year' );
            $dateToObj->modify( '-1 day' );
        }
        
        $filterParams = $this->prepareRequestFilterParams();
        $stats = KoehlertSaleStats::getWeekly($dateFromObj, $dateToObj, $filterParams);
        
        $this->context->smarty->assign('stats_weekly', $stats);
        $stats_rows = $this->context->smarty->fetch($this->module->getTemplatePath('views/templates/admin/salesstats/stats_weekly_rows.tpl'));
        
        echo json_encode(array(
            'stats_html' => $stats_rows
        ));die;
    }
    
    public function ajaxProcessGetMonthly()
    {
        if( !empty($_GET['date_from']) && $_GET['date_to'] ){
            $dateFrom = $_GET['date_from'];
            $dateTo = $_GET['date_to'];
        
            $dateFromObj = new DateTime($dateFrom);
            $dateToObj = new DateTime($dateTo);
        
        }
        elseif( !empty($_GET['date_year']) ){
            //$dateYearMonthParts = explode('-', $_GET['date_year_month']);
        
            $dateFrom = $_GET['date_year'] .'-01-01';
            $dateTo = $_GET['date_year'] .'-01-01';
        
            $dateFromObj = new DateTime($dateFrom);
        
            $dateToObj = new DateTime($dateTo);
            $dateToObj->modify( '+1 year' );
            $dateToObj->modify( '-1 day' );
        }
        
        $filterParams = $this->prepareRequestFilterParams();

        $stats = KoehlertSaleStats::getMonthly($dateFromObj, $dateToObj, $filterParams);
        $statsRevenueTotal = 0;
        $statsSoldTotal = 0;
        foreach( $stats as $statRow ){
            $statsRevenueTotal += $statRow['sale_revenue'];
            $statsSoldTotal += $statRow['sold_quantity'];
        }
        //print_r($stats);
        if( count($stats) == 0 ){
            array_push($stats, array('no_records' => true));
        }
        
        array_unshift( $stats, array(
            'period_name' => $dateFromObj->format('Y'), 
            'sale_revenue_total' => $statsRevenueTotal,
            'sold_quantity_total' => $statsSoldTotal
        ));
        
        $this->context->smarty->assign('stats_monthly', $stats);
        $stats_rows = $this->context->smarty->fetch($this->module->getTemplatePath('views/templates/admin/salesstats/stats_monthly_rows.tpl'));
        
        echo json_encode(array(
            'stats_html' => $stats_rows,
        ));
        
    }

    public function processExportToExcel()
    {
        $this->ajax = true;
        $mode = $_GET['mode'];
        
        $exportColumnsConfig = array(
            'A' => array(
                'name' => 'report_date_formatted',
                'title' => 'Period'
            ),
            'B' => array(
                'name' => 'sold_quantity',
                'title' => 'Sold dresses',
            ),
            'C' => array(
                'name' => 'sale_revenue',
                'title' => 'Revenue',
                'format' => 'price'
            )
        );
        
        $filterParams = $this->prepareRequestFilterParams();

        if( $mode == 'daily' ){
            $dateFrom = new DateTime($_GET['date_from'] .'-01');
            //$dateTo = $_GET['date_to'];
            $dateTo = new DateTime($_GET['date_to'] .'-01');
            $dateTo->modify('last day of this month');
            $dateRangeText = $dateFrom->format('m.Y') .'-'. $dateTo->format('m.Y');

            $statsList = KoehlertSaleStats::getDaily($dateFrom, $dateTo, $filterParams);
        }
        elseif( $mode == 'weekly' ){
            $dateFrom = new DateTime($_GET['date_from'] .'-01-01');
            $dateTo = new DateTime($_GET['date_to'] .'-01-01');
            $dateTo->modify('last day of this year');
            
            if( $dateFrom->format('Y') < $dateTo->format('Y') ){
                $dateRangeText = $dateFrom->format('Y') .'-'. $dateTo->format('Y');
            }
            else{
                $dateRangeText = $dateFrom->format('Y');
            }
            
            $statsList = KoehlertSaleStats::getWeekly($dateFrom, $dateTo, $filterParams);
            
            $exportColumnsConfig['A']['name'] = 'report_date';
        }
        elseif( $mode == 'monthly' ){
            $dateFrom = new DateTime($_GET['date_from'] .'-01-01');
            $dateTo = new DateTime($_GET['date_to'] .'-01-01');
            $dateTo->modify('last day of this year');
            
            if( $dateFrom->format('Y') < $dateTo->format('Y') ){
                $dateRangeText = $dateFrom->format('Y') .'-'. $dateTo->format('Y');
            }
            else{
                $dateRangeText = $dateFrom->format('Y');
            }
            
            $statsList = KoehlertSaleStats::getMonthly($dateFrom, $dateTo, $filterParams);
        }
        else{
            $this->ajax = false;
            $this->errors[] = 'Invalid period';
            return;
        }
        
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->getProperties()
            ->setCreator($this->context->shop->name .' ('. $this->context->shop->domain .')')
            ->setLastModifiedBy($this->context->shop->name.' ('. $this->context->shop->domain .')')
            ->setTitle("Statistics")
        ;
        
        
        $objPHPExcel->setActiveSheetIndex(0);
        $rowNumber = 0;
        $rowNumber++;
        $colCharNum = ord('A');
        foreach($exportColumnsConfig as $fieldOptions){
            $objPHPExcel
                ->getActiveSheet()
                ->setCellValue( (chr($colCharNum).$rowNumber), $fieldOptions['title'])
            ;
            $objPHPExcel->getActiveSheet()->getStyle( (chr($colCharNum).$rowNumber) )
                ->getNumberFormat()
                ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT)
            ;
        
            //$objPHPExcel->getActiveSheet()->getColumnDimension( chr($colCharNum) )->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( chr($colCharNum) )->setWidth(25);
            $colCharNum++;
        }
        
        
        foreach($statsList as $statsItem){
            $rowNumber++;
            $colCharNum = ord('A');
        
            foreach($exportColumnsConfig as $fieldOptions){
                $fieldName = $fieldOptions['name'];
                
                $value = $statsItem[$fieldName];
                
                if( !empty($fieldOptions['format']) && ($fieldOptions['format'] == 'price') ){
                    $value = Tools::displayPrice($value);
                }
                
                $objPHPExcel
                    ->getActiveSheet()
                    ->setCellValue( (chr($colCharNum).$rowNumber), $value)
                ;
                $objPHPExcel->getActiveSheet()->getStyle( (chr($colCharNum).$rowNumber) )
                    ->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT)
                ;
                $colCharNum++;
            }
        
        }
        $objPHPExcel->getActiveSheet()->setTitle('Statistics');
        $objPHPExcel->setActiveSheetIndex(0);
        $fileName = 'Statistics_' . ucfirst($mode) .'_'. $dateRangeText;
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $fileName .'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
        
    }
}