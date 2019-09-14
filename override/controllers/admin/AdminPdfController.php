<?php

class AdminPdfController extends AdminPdfControllerCore
{
    public function generatePDF($object, $template)
    {
        if (is_array($object))
        {
            $fileName = $object[0]->getInvoiceFileName();
        }
        else
        {
            $fileName = $object->getInvoiceFileName();
        }
        // send to browser
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=$fileName");

        header('Pragma: no-cache',true);
        header('Expires: 0',true);
        
        if (!is_array($object) && file_exists($object->getInvoiceFilePath()))
        {
            readfile($object->getInvoiceFilePath());
        }
        else
        {
            $pdf = new PDF($object, $template, Context::getContext()->smarty);
            $pdfFileContent = $pdf->render('S');
            // save file, don't overwrite existing invoice file + don't save several invoies in one file
            if (!is_array($object))
            {
                file_put_contents($object->getInvoiceFilePath(), $pdfFileContent);
            }
            echo $pdfFileContent;
        }
    }

    public function processgeneratePDFlabels() 
    {
        $productsLabelPrint = json_decode(Tools::getValue('products'), TRUE);
        $id_order = (int)Tools::getValue('id_order');
        $labelsData = array();
        
        if( !is_array($productsLabelPrint) ){
            $this->errors[] = 'Invalid parameters';
            return;
        }
        
        $order = new Order($id_order);

        foreach( $order->getProductsDetail() as $orderDetail ){
            if( !in_array(intval($orderDetail['id_order_detail']), $productsLabelPrint) ){
                continue;
            }
            
            $splRefPartsMatches = array();
            if( !preg_match(KOEHLERT_SPL_REF_WITHSIZE_REGEX, $orderDetail['product_supplier_reference'], $splRefPartsMatches) ){
                continue;
            }
            $labelsData[] = array(
                'supplier_reference' => $splRefPartsMatches[1],
                'name' => $splRefPartsMatches[2],
                'id_product' => intval($orderDetail['product_id']),
                'id_product_attribute' => intval($orderDetail['product_attribute_id']),
                'size' => $splRefPartsMatches[3],
                'ean13' => $orderDetail['product_ean13'],
                'quantity' => 1
            );
            
        }

        if( !count($labelsData) ){
            $this->errors[] = 'No object loaded';
            return;
        }
        
        ProductLabel::generatePdf($labelsData);
    }
}