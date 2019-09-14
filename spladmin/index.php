<?php

require_once(dirname(__FILE__).'/../config/config.inc.php');
require_once './KoehlertSpladminIndexController.php';
require_once _PS_TOOL_DIR_ . 'mpdf/mpdf.php';
require_once _PS_TOOL_DIR_ .'ashberg-barcode/php-barcode.php';

//var_dump($_SERVER);die;
if (isset($_SERVER['HTTP_AUTHORIZATION']) && preg_match('/Basic\s+(.*)$/i', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
    list($name, $password) = explode(':', base64_decode($matches[1]));
    ///$_SERVER['PHP_AUTH_USER'] = strip_tags($name);
}
if( isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) ){
    $name = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
}

//set http auth headers for apache+php-cgi work around if variable gets renamed by apache
if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) && preg_match('/Basic\s+(.*)$/i', $_SERVER['REDIRECT_HTTP_AUTHORIZATION'], $matches)) {
    list($name, $password) = explode(':', base64_decode($matches[1]));
    //$_SERVER['PHP_AUTH_USER'] = strip_tags($name);
}

$authenticated = false;
if( isset($name) && isset($password) ) {
    $authCorrect = file_get_contents('.access');
    if( strlen($authCorrect) ){
        $authCorrectData = explode(':', $authCorrect);
        if( count($authCorrectData) && ($authCorrectData[0] == $name) && ($authCorrectData[1] == $password) ){
            $authenticated = true;
        }
    }
}
if(!$authenticated) {
    header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Welcome to PrestaShop Webservice, please enter the authentication key as the login. No password required."');
    var_dump($_SERVER);
    die('401 Unauthorized');
}
/*
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__)),
    get_include_path()
)));
*/

$controller = new KoehlertSpladminIndexController();
$viewVars = $controller->dispatch();

include './layout.phtml';
