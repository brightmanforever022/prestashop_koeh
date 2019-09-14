<?php

require_once (dirname(__FILE__)."/eservices_list.php");

$iso = ($user_lang_iso=="fr"?"fr":"en");

$licence = SCI::getConfigurationValue('SC_LICENSE_KEY');

$id_address = Tools::getValue("id_address");

$ecart = array();
$sql="SELECT * FROM `"._DB_PREFIX_."sc_fizz_cart`";
$cart = Db::getInstance()->ExecuteS($sql);
foreach ($cart as $pdt)
{
    $eService = $eServices_list[$pdt["product"]];
    $ecart[$eService["id_product"]]=$pdt["quantity"];
}
$ecart = json_encode($ecart);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Store Commander</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="<?php echo SC_JQUERY;?>"></script>
</head>
<body>
    <br/><br/><br/>
    <center><img src="lib/img/loading.gif" alt="" title="" /></center>

    <script type="application/javascript">
        $( document ).ready(function() {


            
             location.href="https://www.storecommander.com/<?php echo $iso; ?>/index.php?controller=eservicescart&content_only=1&license=<?php echo $licence; ?>&id_address=<?php echo $id_address; ?>&ecart=<?php echo urlencode($ecart); ?>";
        });
    </script>
</body>
</html>