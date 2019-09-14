<?php
$id_image = Tools::getValue("id_image");

$return = array("type"=>"error","message"=>_l('No image sended',1));

if(!empty($id_image))
{
    $sql = 'SELECT * FROM `'._DB_PREFIX_.'image` WHERE id_image = "'.intval($id_image).'"';
    $res=Db::getInstance()->getRow($sql);
    if(!empty($res["id_product"]))
    {
        $id_product = $res["id_product"];
        if (file_exists(SC_PS_PATH_REL."img/p/".getImgPath(intval($id_product),intval($id_image))))
        {
            $path = SC_PS_PATH_REL."img/p/".getImgPath(intval($id_product),intval($id_image));

            $return = CutOut::upload($path);
        }
        else
        {
            $return = array("type"=>"error","message"=>_l('No image founded'));
        }
    }
    else
    {
        $return = array("type"=>"error","message"=>_l('No image founded'));
    }
}

echo json_encode($return);