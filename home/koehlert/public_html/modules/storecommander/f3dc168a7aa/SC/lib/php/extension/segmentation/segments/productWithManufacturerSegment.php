<?php

class productWithManufacturerSegment extends SegmentCustom
{
    public $name="Products with a specific manufacturer";
    public $liste_hooks = array("segmentAutoConfig","segmentAutoSqlQuery","segmentAutoSqlQueryGrid");

    public function _executeHook_segmentAutoConfig($name, $params=array())
    {
        $html='<strong>'._l("Manufacturer:").'</strong><br/>
		<select id="id_manufacturer" name="id_manufacturer" style="width: 100%;">
			<option value="">--</option>';

        $values = array();
        if(!empty($params["values"]))
            $values = unserialize($params["values"]);

        $sql="SELECT t.id_manufacturer,t.name FROM "._DB_PREFIX_."manufacturer t ORDER BY t.name";
        $manufacturers=Db::getInstance()->ExecuteS($sql);
        foreach($manufacturers as $manufacturer)
        {
            $html.='<option value="'.$manufacturer['id_manufacturer'].'" '.($manufacturer['id_manufacturer']==$values["id_manufacturer"]?'selected':'').'>'.$manufacturer['name'].'</option>';
        }
        $html.='</select>';

        return $html;
    }

    public function _executeHook_segmentAutoSqlQueryGrid($name, $params=array())
    {
        $array = array();

        if(!empty($params["auto_params"]))
        {
            $auto_params = unserialize($params["auto_params"]);
            if(!empty($auto_params["id_manufacturer"]))
            {
                $sql = "SELECT id_product
                        FROM "._DB_PREFIX_."product WHERE id_manufacturer='".intval($auto_params["id_manufacturer"])."'";
                
                $res=Db::getInstance()->ExecuteS($sql);
                foreach($res AS $row)
                {
                    $type = _l('Product');
                    if(SCMS)
                        $element = new Product($row['id_product'], true);
                    else
                        $element = new Product($row['id_product']);
                    $name = $element->name[$params["id_lang"]];
                    $infos = "#".$row['id_product']." / "._l('Ref:')." ".$element->reference;
                    $array[] = array($type, $name, $infos, "id"=>"product_".$row['id_product']);
                }
            }
        }

        return $array;
    }

    public function _executeHook_segmentAutoSqlQuery($name, $params=array())
    {
        $where = "";
        if(!empty($params["auto_params"]))
        {
            $auto_params = unserialize($params["auto_params"]);
            if(!empty($auto_params["id_manufacturer"]))
            {
                $where = " AND p.id_manufacturer ='".intval($auto_params["id_manufacturer"])."'";
            }
        }
        return $where;
    }
}