<?php

require realpath(dirname(__FILE__)) . '/../../config/config.inc.php';
require_once _PS_TOOL_DIR_ . 'php_excel/PHPExcel.php';
//Dispatcher::getInstance()->dispatch();

$languageDefaultId = intval(Configuration::get('PS_LANG_DEFAULT'));
$context = Context::getContext();

switch($_GET['action']){
    case 'get_order_eans':
        $order = new Order( intval($_GET['id_order']) );
        
        if(empty($order->id)){
            die('Order not found');
        }
        
        if (ob_get_level() && ob_get_length() > 0) {
            ob_clean();
        }
        
        $fields_list = array(
            'product_ean13' => array(
                'title' => 'EAN',
            ),
            'product_supplier_reference' => array(
                'title' => 'Supplier reference',
            )
        );
        
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->getProperties()
            ->setCreator($context->shop->name .' ('. $context->shop->domain .')')
            ->setLastModifiedBy($context->shop->name.' ('. $context->shop->domain .')')
            ->setTitle("EANs")
        ;
        

        $objPHPExcel->setActiveSheetIndex(0);
        $rowNumber = 0;
        $rowNumber++;
        $colCharNum = ord('A');
        foreach($fields_list as $fieldOptions){
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
            
        
        foreach($order->getProductsDetail() as $orderProd){
            $rowNumber++;
            $colCharNum = ord('A');
            
            foreach($fields_list as $fieldName => $fieldOptions){
                $objPHPExcel
                    ->getActiveSheet()
                    ->setCellValue( (chr($colCharNum).$rowNumber), $orderProd[$fieldName])
                ;
                $objPHPExcel->getActiveSheet()->getStyle( (chr($colCharNum).$rowNumber) )
                    ->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT)
                ;
                $colCharNum++;
            }
            
        }
        $objPHPExcel->getActiveSheet()->setTitle('EANs');
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="EANs_order_'.$order->id.'.xlsx"');
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
        
    break;
    case 'get_order_images':
        
        $zip = new ZipArchive();
        //$zipFilename = _PS_TMP_IMG_DIR_ .'order_'. intval($_GET['id_order']) .'_images.zip';
        $zipFile = tempnam("tmp", "zip");
        
        if ($zip->open($zipFile, ZipArchive::CREATE)!==TRUE) {
            die("cannot open <$zipFile>\n");
        }
        
        $order = new Order( intval($_GET['id_order']) );
        
        if(empty($order->id)){
            die('Order not found');
        }
        
        $splRefQuery = new DbQuery();
        $splRefQuery->select('ps.product_supplier_reference');
        $splRefQuery->from('product_supplier', 'ps');
        $splRefQuery->where('ps.id_product_attribute = 0');
        
        foreach($order->getProductsDetail() as $orderProd){
            $splRefQueryClone = clone $splRefQuery;
            $splRefQueryClone->where('ps.id_product = '. intval($orderProd['product_id']));
            $reference = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($splRefQueryClone);
            
            $imagesList = Image::getImages($languageDefaultId, $orderProd['product_id']);
            foreach($imagesList as $ii => $imageRow){
                $image = new Image($imageRow['id_image']);
                $imgArchiveName = $reference .'_'. ($ii+1) .'.jpg';
                $imagePath = _PS_PROD_IMG_DIR_ . $image->getImgPath() .'.jpg';
                if( file_exists($imagePath) ){
                    $zip->addFile($imagePath, $imgArchiveName);
                }
            }
        }
        
        if( $zip->numFiles == 0 ){
            die('No images added to the archive');
        }
        
        try{
            $closed = $zip->close();
        }
        catch(Exception $e){
            die('ERROR: '. $e->getMessage());
        }
        
        if( $closed !== true){
            die('ERROR: Closed with status - '. $closed);
        }
        
        if( headers_sent($filename, $linenum) ){
            die("Archive can not be downloaded, headers already sent in $filename on line $linenum");
        }
        
        $archiveName = 'order_'. intval($_GET['id_order']) .'_images.zip';
        header("Content-Type: application/zip");
        header("Content-Length: " . filesize($zipFile));
        header("Content-Disposition: attachment; filename=\"$archiveName\"");
        readfile($zipFile);
        
        unlink($zipFile);
        
        break;
}
die;