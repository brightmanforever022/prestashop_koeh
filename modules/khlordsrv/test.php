<?php

require '../../config/config.inc.php';
require_once _PS_TOOL_DIR_ .'CurlWrapper/CurlWrapper.php';
//require '.php';

$curl = new CurlWrapper();

$requestData = array(
    'products' => array(
        array(
            'supplier_reference' => '0006_Salsa Red_36',
            'quantity' => 1
        ),
        array(
            'supplier_reference' => 'lala & _ -',
            'quantity' => 1
        ),
        array(
            'supplier_reference' => ' ',
            'quantity' => 1
        ),
        
        array(
            'ean13' => '4250781810602\\n',
            'quantity' => 2
        ),
        array(
            'ean13' => "\t\n\r\032",
            'quantity' => 1
        )
        
    )
);

/*$url = 'http://nsweb.server/koehlert/module/khlordsrv/orders?auth_key=MVQRHEZ8IDT14TRCMYHLH2GGXQJ61LFF&action=create';
echo $response = $curl->rawPost($url, json_encode($requestData));
var_dump($curl->getTransferInfo());*/

$url = 'http://nsweb.server/koehlert/module/khlordsrv/orders?auth_key=MVQRHEZ8IDT14TRCMYHLH2GGXQJ61LFF&action=get&order_id=360';
echo $response = $curl->get($url);
$respData = json_decode($response, true);
var_dump($respData, $respData['data']['products']);
die;