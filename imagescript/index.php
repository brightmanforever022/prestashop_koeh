<meta charset="utf-8"/>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../config/config.inc.php';
require_once '../init.php';
function siteOneImageUrl(){
	$imageUrl = array();
	$csvData = file_get_contents('Photo_copy.csv');
	$lines = explode(PHP_EOL, $csvData);
	$dbh = new PDO('mysql:host=localhost;dbname=grosshandel16', 'grosshandel16', 'T3g8xClgdity');
	$dbh->query("SET NAMES utf8;");	
	$array = array();
	foreach ($lines as $line) {
		$a = str_getcsv($line,';');
	    $stmt = $dbh->query("SELECT id_product FROM ps_product_lang WHERE name = '".$a[7]."'");
	    $id_product = $stmt->fetch();
	 //    $image_id = Image::getCover($id_product);
	 //    if (sizeof($image_id) > 0)
		// {
		// 	$image = new Image($image_id['id_image']);
		// 	$imageUrl[] = $_SERVER['DOCUMENT_ROOT']._THEME_PROD_DIR_.$image->getExistingImgPath().".jpg";
		// }
	}
	return $imageUrl;
}
function getFtp(){

}
var_dump(siteOneImageUrl());