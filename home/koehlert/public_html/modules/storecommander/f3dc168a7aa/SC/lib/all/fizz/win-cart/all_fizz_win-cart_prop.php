<?php
        
$id_eService = Tools::getValue("id_eService");

$descs = array();
$link = "";
if(!empty($id_eService))
{
    require_once (dirname(__FILE__)."/eservices_list.php");

    $eService = $eServices_list[$id_eService];
    if(!empty($eService["link"]))
        $link = $eService["link"];
    $iso = ($user_lang_iso=="fr"?"fr":"en");

    $headers = array();
    $headers[] = "KEY: gt789zef132kiy789u13v498ve15nhry98";
    $ret = sc_file_post_contents('http://api.storecommander.com/Fizz/GetPdtProp/'.(int)$eService['id_product'].'/', '', $headers);
    $ret = json_decode($ret, true);
    if (!empty($ret['code']) && $ret['code'] == "200")
    {
        $descs = $ret['short_desc'];
    }
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Store Commander</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="<?php echo SC_JQUERY;?>"></script>
    <link rel="stylesheet" href="lib/css/style.css">
    <style>
        body {
            line-height: 27px;
            font-weight: normal;
            font-family: Tahoma;
            font-size: 12px;
            color: #000000;
        }
        .btn {
            display: inline-block;
            padding: 12px 20px;
            padding-right: 20px;
            padding-left: 20px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 5px;
            white-space: nowrap;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }
        .btn {
            border: none;
            border-top-color: currentcolor;
            border-right-color: currentcolor;
            border-bottom-color: currentcolor;
            border-left-color: currentcolor;
            text-transform: uppercase;
            font-family: "Open Sans",sans-serif;
            font-weight: 200;
            transition: all 0.3s ease 0s;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active {
            color: #fff;
            background-color: #ae002b;
            border-color: #800020;
        }
        .btn-primary {
            color: #fff;
            background-color: #d70035;
            text-decoration: none;
        }
        .btn.btn-cta {
            padding-left: 40px;
            padding-right: 40px;
        }

        .btn.grey {
            padding: 4px 10px;
            color: #fff;
        }
        .btn.grey:hover, .btn.grey:active {
        }
    </style>
</head>
<body style="height: auto;">
    <?php if (!empty($eService["name"])) { ?>
        <h1><?php echo $eService["name"]; ?></h1>
        <?php if (!empty($eService["buyable"])) { ?>
        <a href="javascript:void(0);" onclick="addInCart();" class="btn btn-primary btn-cta grey"><?php echo _l("Add in cart"); ?></a>
        <?php } ?>
        <br/><br/>
        <?php echo $descs[$iso]; ?>
        <br/>
        <?php if(!empty($link)) { ?>
            <center><a href="<?php echo $link; ?>" target="_blank" class="btn btn-primary btn-cta"><?php echo _l("Read more"); ?></a></center>
        <?php } else { ?>
            <center><a href="https://www.storecommander.com/<?php echo $iso; ?>/?controller=product&id_product=<?php echo $eService['id_product']; ?>" target="_blank" class="btn btn-primary btn-cta"><?php echo _l("Read more"); ?></a></center>
        <?php } ?>
    <?php } ?>
    <script type="application/javascript">
        parent.col_eServicesRight.progressOff();

        function addInCart()
        {
            $.post('index.php?ajax=1&act=all_fizz_win-cart_addcart', {products: "<?php echo $id_eService; ?>"}, function( data ) {
                parent.cell_eServicesPayment.expand();
                parent.cell_eServicesPayment.attachURL('index.php?ajax=1&act=all_fizz_win-cart_cart');
            });
        }
    </script>
</body>
</html>