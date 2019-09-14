<?php

require '../../config/config.inc.php';
require_once _PS_TOOL_DIR_ .'phpqrcode/qrlib.php';

if( !empty($_GET['text']) ){
    $text = $_GET['text'];
    $text = preg_replace('#[^a-z0-9&\-\_\s]#i', '', $text);
}

if( !empty($_GET['size']) ){
    $size = intval($_GET['size']);
}
else{
    $size = 3;
}

if( !empty($_GET['output']) && in_array($_GET['output'], array('bin','base64')) ){
    $output = $_GET['output'];
}
else{
    $output = 'bin';
}

if( !empty($text) && !empty($size) && !empty($output) ){
    moduleQrCodeGenerate($text, $size, $output);
}
else{
    echo 'Invalid data';
}

function moduleQrCodeGenerate($text, $size, $outputType)
{
    $tempFilePath = _PS_TMP_IMG_DIR_ . DIRECTORY_SEPARATOR . uniqid();

    if($outputType == 'bin'){
        QRcode::png($text, false, QR_ECLEVEL_M, $size, 2);
    }
    elseif( $outputType == 'base64' ){
        QRcode::png($text, $tempFilePath, QR_ECLEVEL_M, $size, 2);
        $tempfileContent = file_get_contents($tempFilePath);
        
        echo base64_encode($tempfileContent);
    }
    unlink($tempFilePath);
}


