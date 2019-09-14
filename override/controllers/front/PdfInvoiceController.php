<?php

class PdfInvoiceController extends PdfInvoiceControllerCore
{
    public function postProcess()
    {
        if (!$this->context->customer->isLogged() && !Tools::getValue('secure_key')) {
            Tools::redirect('index.php?controller=authentication&back=pdf-invoice');
        }
        
        if (!(int)Configuration::get('PS_INVOICE')) {
            die(Tools::displayError('Invoices are disabled in this shop.'));
        }
        
        $id_order = (int)Tools::getValue('id_order');
        if (Validate::isUnsignedId($id_order)) {
            $order = new Order((int)$id_order);
        }
        
        if (!isset($order) || !Validate::isLoadedObject($order)) {
            die(Tools::displayError('The invoice was not found.'));
        }
        
        if ((isset($this->context->customer->id) && $order->id_customer != $this->context->customer->id) || (Tools::isSubmit('secure_key') && $order->secure_key != Tools::getValue('secure_key'))) {
            die(Tools::displayError('The invoice was not found.'));
        }
        
        $this->order = $order;
        
    }
    
    public function display()
    {
        $id_order_invoice = intval($_GET['id_order_invoice']);
        
        $invoice = new OrderInvoice($id_order_invoice);
        
        if( !$invoice->id ){
            die(Tools::displayError('Invoices not found'));
        }
        
        $fileName = $invoice->getInvoiceFileName();
        
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=$fileName");
        
        header('Pragma: no-cache',true);
        header('Expires: 0',true);
        
        if (file_exists($invoice->getInvoiceFilePath()))
        {
            readfile($invoice->getInvoiceFilePath());
        }
        else
        {
            $pdf = new PDF($invoice, PDF::TEMPLATE_INVOICE, Context::getContext()->smarty);
            $pdfFileContent = $pdf->render('S');
            // save file
            file_put_contents($invoice->getInvoiceFilePath(), $pdfFileContent);
        
            echo $pdfFileContent;
        }
        
    }
}