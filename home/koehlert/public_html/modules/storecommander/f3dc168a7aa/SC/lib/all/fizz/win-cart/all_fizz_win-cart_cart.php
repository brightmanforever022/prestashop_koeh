<?php

require_once (dirname(__FILE__)."/eservices_list.php");

$iso = ($user_lang_iso=="fr"?"fr":"en");
$id_lang_sc = ($user_lang_iso=="fr"?"2":"1");

$addresses = array();


$licence = SCI::getConfigurationValue('SC_LICENSE_KEY');
$headers = array();
$headers[] = "KEY: gt789zef132kiy789u13v498ve15nhry98";
$posts = array();
if(defined("IS_SUBS") && IS_SUBS=="1")
    $posts["SUBSCRIPTION"] = "1";
$ret = sc_file_post_contents('http://api.storecommander.com/Fizz/GetAddresses/'.$licence.'/'.$id_lang_sc.'/', $posts, $headers);
$ret = json_decode($ret, true);
if (!empty($ret['code']) && $ret['code'] == "200")
{
    $addresses = $ret['addresses'];
}

$cart = array();
$sql="SELECT * FROM `"._DB_PREFIX_."sc_fizz_cart`";
$cart = Db::getInstance()->ExecuteS($sql);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Store Commander</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="<?php echo SC_JQUERY;?>"></script>
    <link rel="stylesheet" href="lib/css/style.css">
    <style>
        html{
            padding: 0px;
            margin: 0px;
        }
        body {
            padding: 0px;
            margin: 0px;
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
        .btn.small {
            padding: 8px 20px;
        }

        .btn.grey {
            padding: 4px 10px;
            color: #fff;
            background-color: #aaaaaa;
            border-color: #aaaaaa;
        }
        .btn.grey:hover, .btn.grey:focus, .btn.grey:active, .btn.grey.active {
            color: #fff;
            background-color: #222222;
            border-color: #222222;
        }

        .bloc_address {
            width: 20%;
            border: 1px solid #800020;
            border-radius: 5px;
            margin: 2%;
            padding: 2%;
            float: left;
        }

        .bloc_right {
            width: 68%;
            margin: 2%;
            margin-left: 0;
            padding: 0;
            float: right;
        }

        .bloc_cart {
            width: 96%;
            margin: 0;
            padding: 2%;
            border: 1px solid #800020;
            border-radius: 5px;
            margin-bottom: 2em;
        }

        h2 {
            margin-top: 0px;
        }

        table tr td {
            border-top: 1px solid #cccccc;
        }
    </style>
</head>
<body>
    <div class="bloc_address">
        <h2><?php echo _l("Billing address"); ?></h2>
        <?php
        if(!empty($addresses))
        {
            if(count($addresses)>1)
            {
                $address = ($addresses[0]["address"]);
                echo '<select id="choosen_id_address" style="width: 100%">';
                foreach ($addresses as $add)
                    echo '<option value="'.$add["id_address"].'" '.($addresses[0]["id_address"]==$add["id_address"]?"selected":"").'>'.$add["alias"].'</option>';
                echo '</select>';
                ?>
                <script type="application/javascript">
                    $( "#choosen_id_address" ).live( "change", function() {
                        var address = list_addresses[$(this).val()];
                        $("#address").html(address);
                    });

                    var list_addresses = new Object();
                    <?php foreach ($addresses as $add) {
                    $add["address"] = str_replace("\n\r", "<br/>", $add["address"]);
                    $add["address"] = str_replace("<br/><br/><br/>", "<br/>", $add["address"]);
                    $add["address"] = str_replace("<br/><br/>", "<br/>", $add["address"]);
                    $add["address"] = str_replace("\n", " ", $add["address"]);
                    $add["address"] = str_replace("\r", " ", $add["address"]);
                    $add["address"] = str_replace("'", "\'", $add["address"]);
                        ?>
                    list_addresses[<?php echo $add["id_address"]; ?>] = '<?php echo $add["address"]; ?>';
                    <?php } ?>
                </script>
                <?php
            }
            else
            {
                $address = ($addresses[0]["address"]);
                echo '<input type="hidden" id="choosen_id_address" value="'.$addresses[0]["id_address"].'" />';
            }

            $address = str_replace("\n\r", "<br/>", $address);
            $address = str_replace("<br/><br/><br/>", "<br/>", $address);
            $address = str_replace("<br/><br/>", "<br/>", $address);
            echo '<center id="address">'.$address.'</center>';
        }
        else
            echo '<center><strong>'._l("You need an address to make order!").'</strong></center>';
        ?>
        <center style="margin-top: 10px;margin-bottom: 6px;"><a href="https://www.storecommander.com/<?php echo $iso; ?>/?controller=auth&back=addresses<?php if(!empty($addresses)) { ?>&is_email=<?php echo $addresses[0]["email"]; ?><?php } ?>" target="_blank" class="btn btn-primary btn-cta small"><?php echo _l("Modify"); ?></a></center>
        <?php if(!empty($addresses)) { ?><em style="font-size: 10px;"><?php echo _l("To update an address, you must be logged on storecommander.com with this account:")." ".$addresses[0]["email"]; ?></em><?php } ?>
    </div>
    <div class="bloc_right">
        <div class="bloc_cart">
            <?php
            $update_qty = 0;
            if(!empty($cart)) { ?>
                <table width="100%">
                    <tr>
                        <th align="left"><?php echo _l("Product"); ?></th>
                        <th align="center"><?php echo _l("Quantity"); ?></th>
                        <th align="right"><?php echo _l("Price excl. tax"); ?></th>
                        <th align="right"></th>
                    </tr>
                    <?php
                    $total = 0;
                    foreach ($cart as $pdt) {
                        $eService = $eServices_list[$pdt["product"]];
                        ?>
                        <tr>
                            <td align="left"><?php echo $eService["name"]; ?></td>
                            <td align="center">
                                <?php if($eService["max_qty"] >1) { $update_qty++; ?>
                                    <input class="quantity_pdt" id="quantity_pdt_<?php echo $pdt["product"]; ?>" type="text" value="<?php echo $pdt["quantity"]; ?>" style="width: 30px;"/>
                                <?php } else { ?>
                                    <?php echo $pdt["quantity"]; ?>
                                    <input class="quantity_pdt" id="quantity_pdt_<?php echo $pdt["product"]; ?>" type="hidden" value="<?php echo $pdt["quantity"]; ?>"/>
                                <?php } ?>
                            </td>
                            <td align="right"><?php echo $eService["price"].($eService["currency"]=="euro"?"€":" <img src=\"lib/img/fizz.png\" alt=\"Fizz\" title=\"Fizz\" style=\"margin-bottom: -3px;\" />"); ?></td>
                            <td align="right"><img src="lib/img/delete.gif" class="delete_cart" id="delete_cart_<?php echo $pdt["product"]; ?>" alt="<?php echo _l("Delete"); ?>" title="<?php echo _l("Delete"); ?>" /></td>
                        </tr>
                    <?php
                        if($eService["currency"]=="euro")
                            $total += $pdt["quantity"]*$eService["price"];
                    } ?>
                    <tr>
                        <td align="right" colspan="2"><strong><?php echo _l("Total"); ?></strong></td>
                        <td align="right"><?php echo $total; ?>€</td>
                        <td align="right"></td>
                    </tr>
                </table>

                <a href="javascript: void(0);" id="update_quantity" class="btn btn-primary btn-cta grey" style="float: right; <?php if(empty($update_qty)) {echo "display:none;";} ?>"><?php echo _l("Refresh cart"); ?></a>
                <div style="clear: both"></div>
            <?php } else { ?>
                <center><strong><?php echo _l("You don't have product in your cart."); ?></strong></center>
            <?php } ?>
        </div>
        <center><a href="<?php
        if($id_lang_sc=="2") echo "https://www.storecommander.com/fr/content/3-conditions-generales-de-ventes";
        else echo "https://www.storecommander.com/en/content/3-terms-and-conditions-of-use";
        ?>" target="_blank" style="text-decoration: no-underline; color: #800020; "><?php echo _l("Read the Terms & Conditions"); ?></a><br/>
        <a href="javascript: void(0);" id="send_cart" class="btn btn-primary btn-cta"><?php echo _l("I accept the T&C and I buy"); ?></a></center>
    </div>


<script type="application/javascript">
    $( "#update_quantity" ).live( "click", function() {
        var products = "";
        $(".quantity_pdt").each(function(index,elem) {
            var product = $(elem).attr("id").replace("quantity_pdt_","");
            var qty = $(elem).val();

            if(products!="")
                products = products+",";
            products = products+product+"|"+qty;
        });
        $.post('index.php?ajax=1&act=all_fizz_win-cart_addcart', {products: products}, function( data ) {
            parent.cell_eServicesPayment.attachURL('index.php?ajax=1&act=all_fizz_win-cart_cart');
        });
    });
    $( ".delete_cart" ).live( "click", function() {
        var product = $(this).attr("id").replace("delete_cart_","");
        $("#quantity_pdt_"+product).val("0");
        $( "#update_quantity" ).click();
    });


    $( "#send_cart" ).live( "click", function() {
        var id_address = $("#choosen_id_address").val();
        if(id_address!=undefined && id_address!=null && id_address!="" && id_address!=0)
        {
            if (!parent.dhxWins.isWindow('weServicesPayment'))
            {
                weServicesPayment = parent.dhxWins.createWindow('weServicesPayment', (($(parent.window).width()-1000)/2), (($(parent.window).height()-500)/2), 1000, 500);
                weServicesPayment.setIcon('lib/img/ruby.png','../../../lib/img/ruby.png');
                weServicesPayment.setText('<?php echo _l('e-Services', 1)." - "._l('Payment', 1); ?>');
                weServicesPayment.attachURL('index.php?ajax=1&act=all_fizz_win-cart_sendcart&id_address='+id_address);
            }else{
                weServicesPayment.show();
            }
        }
        else
            parent.dhtmlx.message({text:'<?php echo _l('You must choose an address.',1);?>',type:'error'});
    });
</script>
</body>
</html>