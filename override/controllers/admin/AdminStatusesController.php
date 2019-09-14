<?php

class AdminStatusesController extends AdminStatusesControllerCore
{
    public function renderForm()
    {
        $this->fields_form = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Order status'),
                'icon' => 'icon-time'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Status name'),
                    'name' => 'name',
                    'lang' => true,
                    'required' => true,
                    'hint' => array(
                        $this->l('Order status (e.g. \'Pending\').'),
                        $this->l('Invalid characters: numbers and').' !<>,;?=+()@#"{}_$%:'
                    )
                ),
                array(
                    'type' => 'file',
                    'label' => $this->l('Icon'),
                    'name' => 'icon',
                    'hint' => $this->l('Upload an icon from your computer (File type: .gif, suggested size: 16x16).')
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Color'),
                    'name' => 'color',
                    'hint' => $this->l('Status will be highlighted in this color. HTML colors only.').' "lightblue", "#CC6600")'
                ),
                array(
                    'type' => 'checkbox',
                    'name' => 'logable',
                    'values' => array(
                        'query' => array(
                            array('id' => 'on', 'name' => $this->l('Consider the associated order as validated.'), 'val' => '1'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'checkbox',
                    'name' => 'invoice',
                    'values' => array(
                        'query' => array(
                            array('id' => 'on', 'name' => $this->l('Allow a customer to download and view PDF versions of his/her invoices.'), 'val' => '1'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'checkbox',
                    'name' => 'hidden',
                    'values' => array(
                        'query' => array(
                            array('id' => 'on', 'name' => $this->l('Hide this status in all customer orders.'), 'val' => '1'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'checkbox',
                    'name' => 'send_email',
                    'values' => array(
                        'query' => array(
                            array('id' => 'on', 'name' => $this->l('Send an email to the customer when his/her order status has changed.'), 'val' => '1'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'checkbox',
                    'name' => 'pdf_invoice',
                    'values' => array(
                        'query' => array(
                            array('id' => 'on',  'name' => $this->l('Attach invoice PDF to email.'), 'val' => '1'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'checkbox',
                    'name' => 'pdf_delivery',
                    'values' => array(
                        'query' => array(
                            array('id' => 'on',  'name' => $this->l('Attach delivery slip PDF to email.'), 'val' => '1'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'checkbox',
                    'name' => 'shipped',
                    'values' => array(
                        'query' => array(
                            array('id' => 'on',  'name' => $this->l('Set the order as shipped.'), 'val' => '1'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'checkbox',
                    'name' => 'paid',
                    'values' => array(
                        'query' => array(
                            array('id' => 'on', 'name' => $this->l('Set the order as paid.'), 'val' => '1'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'checkbox',
                    'name' => 'delivery',
                    'values' => array(
                        'query' => array(
                            array('id' => 'on', 'name' => $this->l('Show delivery PDF.'), 'val' => '1'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'select_template',
                    'label' => $this->l('Template'),
                    'name' => 'template',
                    'lang' => true,
                    'options' => array(
                        'query' => $this->getTemplates(),
                        'id' => 'id',
                        'name' => 'name',
                        'folder' => 'folder'
                    ),
                    'hint' => array(
                        $this->l('Only letters, numbers and underscores ("_") are allowed.'),
                        $this->l('Email template for both .html and .txt.')
                    )
                ),
                array(
                    'type' => 'checkbox',
                    'name' => 'need_date',
                    'values' => array(
                        'query' => array(
                            array(
                                'id' => 'on',
                                'name' => $this->l('Need date'),
                                'val' => '1'
                            ),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            )
        );
    
        if (Tools::isSubmit('updateorder_state') || Tools::isSubmit('addorder_state')) {
            return $this->renderOrderStatusForm();
        } elseif (Tools::isSubmit('updateorder_return_state') || Tools::isSubmit('addorder_return_state')) {
            return $this->renderOrderReturnsForm();
        } else {
            return AdminController::renderForm();
        }
    }
    
    protected function renderOrderStatusForm()
    {
        if (!($obj = $this->loadObject(true))) {
            return;
        }
        
        $this->fields_value = array(
            'logable_on' => $this->getFieldValue($obj, 'logable'),
            'invoice_on' => $this->getFieldValue($obj, 'invoice'),
            'hidden_on' => $this->getFieldValue($obj, 'hidden'),
            'send_email_on' => $this->getFieldValue($obj, 'send_email'),
            'shipped_on' => $this->getFieldValue($obj, 'shipped'),
            'paid_on' => $this->getFieldValue($obj, 'paid'),
            'delivery_on' => $this->getFieldValue($obj, 'delivery'),
            'pdf_delivery_on' => $this->getFieldValue($obj, 'pdf_delivery'),
            'pdf_invoice_on' => $this->getFieldValue($obj, 'pdf_invoice'),
            'need_date_on' => $this->getFieldValue($obj, 'need_date'),
        );

        if ($this->getFieldValue($obj, 'color') !== false) {
            $this->fields_value['color'] = $this->getFieldValue($obj, 'color');
        } else {
            $this->fields_value['color'] = "#ffffff";
        }
        
        return AdminController::renderForm();
    }
    
    public function postProcess()
    {
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
            if( (Tools::isSubmit('updateorder_state') || Tools::isSubmit('addorder_state') || Tools::isSubmit('submitAddorder_state')) ){
                $_POST['need_date'] = intval(Tools::getValue('need_date_on'));
            }
        }
        
        
        return parent::postProcess();
    }
}