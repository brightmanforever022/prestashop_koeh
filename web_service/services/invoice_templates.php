<?php

function getInvoiceTemplates()
{
    global $conn;
    $status = false;
    $message = '';
    
    $data = array(
        'status' => false,
        'message' => '',
        'data' => array()
    );
    
    $countryId = null;
    if( isset($_POST['country_id']) ){
        $countryId = (int)$_POST['country_id'];
    }
    
    $invoiceRequireVat = 0;
    if( isset($_POST['customer_id']) ){
        $customerDataRes = $conn->query('
            SELECT * FROM `prs_customer` WHERE id_customer = '. intval($_POST['customer_id']) .' 
        ');
        if( $customerDataRes->num_rows ){
            $customerData = $customerDataRes->fetch_assoc();
            if( empty($customerData['siret']) || ($customerData['siret_confirmed'] == '0') ){
                $invoiceRequireVat = 1;
            }
        }
    }

    $queryParts = array(
        'select' => 'SELECT ',
        'from' => 'FROM ',
        'where' => 'WHERE 1 '
    );
    $queryParts['select'] .= 'bai.id, bai.name, bai.description';
    $queryParts['from'] .= 'prs_ba_prestashop_invoice bai';
    
    if( $countryId ){
        $queryParts['from'] .= ' INNER JOIN `prs_ba_invoice_tpl_to_category` bai2c 
            ON bai2c.template_id = bai.id';
        $queryParts['from'] .= ' INNER JOIN `prs_ba_invoice_category_to_country` baicat2cnt 
            ON baicat2cnt.category_id = bai2c.category_id';
        $queryParts['where'] .= ' AND baicat2cnt.country_id = '. $countryId;
    }
    
    if( $invoiceRequireVat ){
        $queryParts['where'] .= ' AND bai.require_vat = '. ($invoiceRequireVat == 1 ? '0' : '1');
    }
    
    $query = $queryParts['select'] .' '. $queryParts['from'] .' '. $queryParts['where'];
    
    $resource = $conn->query($query);
    
    $products = array();
    if( $resource->num_rows ){
        //$message = $resource->num_rows . ' templates';
        while( $row = $resource->fetch_assoc() ){
            $row['name'] = utf8_encode($row['name']);
            $row['description'] = utf8_encode($row['description']);
            $row['template_type'] = 1;
            $products[] = $row;
        }
    }
    
    // add delivery slip to the list
    if( $countryId ){
        $countryCategoryRes = $conn->query('
            SELECT * 
            FROM `prs_ba_invoice_category_to_country`
            WHERE country_id = '. $countryId .'
        ');
        if( $countryCategoryRes->num_rows ){
            $countryCategory = $countryCategoryRes->fetch_assoc();
            if( ($countryCategory['category_id'] >= 1) && ($countryCategory['category_id'] <= 3) ){
                $deliverySlipLanguage = LanguageCore::getIdByIso('de');
            }
            else{
                $deliverySlipLanguage = LanguageCore::getIdByIso('en');
            }
            
            $deliverySlipsRes = $conn->query('
                SELECT id, name, description
                FROM prs_ba_prestashop_delivery_slip
                WHERE `status` = 1
                    AND id_lang = '. $deliverySlipLanguage .'
            ');
            if( $deliverySlipsRes->num_rows ){
                while( $deliverySlip = $deliverySlipsRes->fetch_assoc() ){
                    $deliverySlip['name'] = utf8_encode($deliverySlip['name']);
                    $deliverySlip['description'] = utf8_encode($deliverySlip['description']);
                    $deliverySlip['template_type'] = 2;
                    $products[] = $deliverySlip;
                }
            }
        }
    }
    
    $data['status'] = true;
    $data['message'] = $message;
    $data['data'] = $products;
    
    return $data;
}