<?php

class OrderDetailController extends OrderDetailControllerCore
{
    public function initContent()
    {
        $id_order = intval(Tools::getValue('id_order'));
        $order = new Order($id_order);
        
        if( $order->id && ($order->id_customer == $this->context->customer->id) ){
            $invoicesQuery = '
                SELECT a.id_order_invoice, \'\' as reminder_files, a.id_order, number, a.paid, 
                    a.sum_to_pay, a.due_date, a.payment_date, a.date_add, a.total_paid_tax_incl
                FROM `'._DB_PREFIX_.'order_invoice` a
                WHERE a.id_order = '. intval($order->id) .'
            ';
            $order_invoices = Db::getInstance()->executeS($invoicesQuery);
            
            foreach($order_invoices as $i => $invoice){
                $order_invoices[$i]['invoice_pdf_link'] = $this->context->link->getPageLink(
                    'pdf-invoice', true, null, 'id_order='. $order->id.'&id_order_invoice='. $invoice['id_order_invoice']
                );
                $order_invoices[$i]['number_formatted'] = 
                    sprintf(
                        '%1$s%2$06d', 
                        Configuration::get('PS_INVOICE_PREFIX', $this->context->language->id, null, $this->context->shop->id), 
                        $invoice['number']);
            }
            
            $this->context->smarty->assign(array(
                'order_invoices' => $order_invoices
            ));
        }
        
        return parent::initContent();
    }
}