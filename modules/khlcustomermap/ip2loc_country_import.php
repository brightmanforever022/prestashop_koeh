<?php

require realpath(dirname(__FILE__)) . '/../../config/config.inc.php';

function khlcustomermap_import_countries()
{
    $dbTable = 'ip2loc_country';
    Db::getInstance()->query('TRUNCATE '. _DB_PREFIX_ . $dbTable);
    
    /**
     * CSV file from here https://download.ip2location.com/lite/IP2LOCATION-LITE-DB1.CSV.ZIP
     */
    $csvHandl = fopen('./IP2LOCATION-LITE-DB1.CSV', 'r');
    while( ($csvRow = fgetcsv($csvHandl, null, ',', '"')) != false ){
        if( empty($csvRow[2]) || ($csvRow[2] == '-') ){
            continue;
        }
        $dbData = array(
            'ip_from' => $csvRow[0],
            'ip_to' => $csvRow[1],
            'country_code' => $csvRow[2],
            'country_name' => pSQL($csvRow[3]),
        );
        
        Db::getInstance()->insert($dbTable, $dbData);
    }
}

khlcustomermap_import_countries();