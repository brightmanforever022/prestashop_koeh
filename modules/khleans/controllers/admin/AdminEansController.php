<?php

require_once _PS_TOOL_DIR_ . 'php_excel/PHPExcel.php';

class AdminEansController extends ModuleAdminController
{
    public $bootstrap = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->table = 'ean';
        $this->className = 'Ean';
        $this->identifier = 'id';
        $this->context = Context::getContext();
        
        $this->_defaultOrderBy = 'supplier_reference';
        $this->_defaultOrderWay = 'ASC';
        $this->allow_export = true;
        $this->list_no_link = true;
        
        $this->fields_list = array(
            'code' => array(
                'title' => $this->l('EAN'),
            ),
            'supplier_reference' => array(
                'title' => $this->l('Supplier reference'),
            )
        );
        
    }
    
    public function processExport($text_delimiter = '"')
    {
        set_time_limit(300);
        // clean buffer
        if (ob_get_level() && ob_get_length() > 0) {
            ob_clean();
        }
        $this->getList($this->context->language->id, null, null, 0, false);
        if (!count($this->_list)) {
            return;
        }
    
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
    
        // Set document properties
        $objPHPExcel->getProperties()
        ->setCreator($this->context->shop->name .' ('. $this->context->shop->domain .')')
        ->setLastModifiedBy($this->context->shop->name.' ('. $this->context->shop->domain .')')
        ->setTitle("EANs")
        ;
    
        $objPHPExcel->setActiveSheetIndex(0);
        $rowNumber = 0;
        $rowNumber++;
        $colCharNum = ord('A');
        foreach($this->fields_list as $fieldOptions){
            $objPHPExcel
            ->getActiveSheet()
            ->setCellValue( (chr($colCharNum++).$rowNumber), $fieldOptions['title'])
            ;
        }
    
        foreach($this->_list as $dbRec){
            $rowNumber++;
            $colCharNum = ord('A');
    
            foreach($this->fields_list as $fieldName => $fieldOptions){
                $objPHPExcel
                ->getActiveSheet()
                ->setCellValue( (chr($colCharNum++).$rowNumber), $dbRec[$fieldName])
                ;
            }
        }
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('EANs');
    
    
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
    
    
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$this->table.'_'.date('Y-m-d_His').'.xlsx"');
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