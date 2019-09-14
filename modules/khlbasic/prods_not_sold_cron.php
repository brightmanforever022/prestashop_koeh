<?php
require realpath(dirname(__FILE__)) . '/../../config/config.inc.php';
require_once _PS_TOOL_DIR_ . 'php_excel/PHPExcel.php';
include_once(_PS_SWIFT_DIR_.'Swift.php');
include_once(_PS_SWIFT_DIR_.'Swift/Connection/SMTP.php');
include_once(_PS_SWIFT_DIR_.'Swift/Connection/NativeMail.php');
include_once(_PS_SWIFT_DIR_.'Swift/Plugin/Decorator.php');


$context = Context::getContext();

$monthPeriods = array(3,6);
$adminEmail = 'info@koehlert.com';
$supplierId = 4;
/**
 * @var SupplierCore $supplier
 */
$supplier = new Supplier($supplierId);

$queryTemplate = '
    SELECT p.id_product, p.active, p.supplier_reference, p.stock_clearance, p_sales.total_sold_quantity,
        p_stock.stock_quantity
    FROM `'. _DB_PREFIX_ .'product` p
    LEFT JOIN (
        SELECT od.product_id AS id_product, SUM(od.`product_quantity`) AS total_sold_quantity
        FROM `'._DB_PREFIX_.'order_detail` od
        INNER JOIN `'._DB_PREFIX_.'orders` o ON o.id_order = od.id_order
        WHERE
            o.current_state != '. intval(Configuration::get('PS_OS_CANCELED')) .'
            AND o.date_add >= %1$d
        GROUP BY od.product_id
    ) AS p_sales ON p_sales.id_product = p.id_product
    INNER JOIN (
        SELECT id_product, SUM(`quantity`) AS stock_quantity
        FROM `'._DB_PREFIX_.'stock_available`
        WHERE id_product_attribute > 0
        GROUP BY `id_product`
    ) AS p_stock ON p_stock.id_product = p.id_product
    WHERE p.id_supplier = '. $supplierId .'
    HAVING (p_stock.stock_quantity > 0) AND ISNULL(p_sales.total_sold_quantity)
';



$reportParts = array();
$reportParts[] = '<p>Rules for this list</p>';
$reportParts[] = '<ol>
    <li>Cancelled orders ignored</li>
    <li>Dress was not sold for particular period</li>
    <li>Supplier of the dress is "'. $supplier->name .'"</li>
    <li>At least 1 dress in stock</li>
</ol>';

$exportList = array();

foreach( $monthPeriods as $monthPeriod ){
    $report = '<h3>Following products were not sold in the last '.$monthPeriod.' Months</h3>';
    
    $datePast = new DateTime('- '.$monthPeriod.' month');

    $query = sprintf($queryTemplate, $datePast->format('Ymd'));

    $productsSalesTotal = DB::getInstance()->executeS($query);

    $report .= '<p>';
    foreach($productsSalesTotal as $productSalesTotal){
        if( !is_null($productSalesTotal['total_sold_quantity']) ){
            continue;
        }
        
        $report .= $productSalesTotal['supplier_reference'] .' ('
            . ($productSalesTotal['active'] ? 'Active' : 'Disabled') .', '
            . ($productSalesTotal['stock_clearance'] ? 'Clearance' : 'Regular') 
            .')<br>' . PHP_EOL;
        
        $exportList[ $productSalesTotal['supplier_reference'] ] = array(
            'supplier_reference' => $productSalesTotal['supplier_reference'],
            'status' => ($productSalesTotal['active'] ? 'Active' : 'Disabled'),
            'stock_clearance' => ($productSalesTotal['stock_clearance'] ? 'Yes' : 'No') ,
            'not_sold_period' => $monthPeriod
        );
    }
    $report .= '</p>';
    
    $reportParts[] = $report;
}

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()
->setTitle("Not sold dresses")
;
$objPHPExcel->setActiveSheetIndex(0);
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Not sold dresses');

$excelColsConfig = array(
    array('field' => 'supplier_reference', 'title' => 'Supplier reference', 'width' => 30),
    array('field' => 'status', 'title' => 'Status', 'width' => 15),
    array('field' => 'stock_clearance', 'title' => 'Clearance', 'width' => 15),
    array('field' => 'not_sold_period', 'title' => 'Not sold monthes', 'width' => 15)
);

$objPHPExcel->setActiveSheetIndex(0);
$rowNumber = 0;
$rowNumber++;
$colCharNum = ord('A');
foreach($excelColsConfig as $fieldOptions){
    $objPHPExcel
        ->getActiveSheet()
        ->setCellValue( (chr($colCharNum).$rowNumber), $fieldOptions['title'])
    ;
    $objPHPExcel->getActiveSheet()->getColumnDimension( chr($colCharNum) )->setWidth($fieldOptions['width']);
    $colCharNum++;
}

foreach($exportList as $exportItem){
    $rowNumber++;
    $colCharNum = ord('A');
    
    foreach($excelColsConfig as $fieldOptions){
        $objPHPExcel
        ->getActiveSheet()
        ->setCellValue( (chr($colCharNum++).$rowNumber), $exportItem[$fieldOptions['field']])
        ;
    }
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$excelDate = date('Y-m-d');
$excelTmpPath = _PS_TMP_IMG_DIR_ . 'Not_sold_dresses_'.$excelDate.'.xlsx';
$objWriter->save($excelTmpPath);

$attachment = array(
    'content' => file_get_contents($excelTmpPath),
    'name' => 'Not_sold_dresses_'.$excelDate.'.xlsx',
    'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
);


$notificationHtml = implode(' ', $reportParts);

$subject = 'Not sold dresses';
$to_list = new Swift_RecipientList();
$to_list->addTo($adminEmail);
$connection = new Swift_Connection_NativeMail();
$swift = new Swift($connection, 'www.koehlert.com');
$message = new Swift_Message($subject);
$message->setCharset('utf-8');
/* Set Message-ID - getmypid() is blocked on some hosting */
//$message->setId(Mail::generateId());
$message->headers->setEncoding('Q');

$message->attach(new Swift_Message_Part($notificationHtml, 'text/html', '8bit', 'utf-8'));
$message->attach(new Swift_Message_Attachment($attachment['content'], $attachment['name'], $attachment['mime']));

$send = $swift->send($message, $to_list, new Swift_Address($adminEmail, $adminEmail));
$swift->disconnect();

unlink($excelTmpPath);