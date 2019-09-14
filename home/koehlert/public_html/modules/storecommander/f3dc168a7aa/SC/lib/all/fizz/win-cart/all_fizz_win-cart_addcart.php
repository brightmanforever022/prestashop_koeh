<?php
$products = Tools::getValue("products");

if(!empty($products))
{
    require_once (dirname(__FILE__)."/eservices_list.php");

    $products = explode(",", $products);
    foreach ($products as $product)
    {
        if(strpos($product, "|")===false)
            $quantity = 1;
        else
            list($product,$quantity) = explode("|", $product);

        $eService = $eServices_list[$product];
        if(!empty($eService["buyable"]))
        {
            if($quantity>$eService["max_qty"])
                $quantity=$eService["max_qty"];

            $sql="SELECT * FROM `"._DB_PREFIX_."sc_fizz_cart` WHERE product='".pSQL($product)."'";
            $exist = Db::getInstance()->getRow($sql);
            if(!empty($exist["id_fizz_cart"]))
            {
                if($quantity>0)
                    $sql="UPDATE `"._DB_PREFIX_."sc_fizz_cart` SET quantity = '".$quantity."' WHERE id_fizz_cart='".intval($exist["id_fizz_cart"])."'";
                else
                    $sql="DELETE FROM `"._DB_PREFIX_."sc_fizz_cart` WHERE id_fizz_cart='".intval($exist["id_fizz_cart"])."'";
                Db::getInstance()->execute($sql);
            }
            elseif($quantity>0)
            {
                $sql="INSERT INTO `"._DB_PREFIX_."sc_fizz_cart` (product,quantity) 
            VALUES ('".pSQL($product)."','".(int)$quantity."')";
                Db::getInstance()->execute($sql);
            }
        }
    }
}
