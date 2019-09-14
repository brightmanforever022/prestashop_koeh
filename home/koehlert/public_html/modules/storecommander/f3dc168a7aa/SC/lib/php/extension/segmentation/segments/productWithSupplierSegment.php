<?php

class productWithSupplierSegment extends SegmentCustom
{
    public $name="Products with a specific supplier";
    public $liste_hooks = array("segmentAutoConfig","segmentAutoSqlQuery","segmentAutoSqlQueryGrid");

    public function _executeHook_segmentAutoConfig($name, $params=array())
    {
        $html='<strong>'._l("Supplier:").'</strong><br/>
		<select id="id_supplier" name="id_supplier" style="width: 100%;">
			<option value="">--</option>';

        $values = array();
        if(!empty($params["values"]))
            $values = unserialize($params["values"]);

        $sql="SELECT t.id_supplier,t.name FROM "._DB_PREFIX_."supplier t ORDER BY t.name";
        $suppliers=Db::getInstance()->ExecuteS($sql);
        foreach($suppliers as $supplier)
        {
            $html.='<option value="'.$supplier['id_supplier'].'" '.($supplier['id_supplier']==$values["id_supplier"]?'selected':'').'>'.$supplier['name'].'</option>';
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
            if(!empty($auto_params["id_supplier"]))
            {
                $sql = "SELECT p.id_product
                        FROM "._DB_PREFIX_."product p 
                            INNER JOIN "._DB_PREFIX_."product_supplier psp ON (p.id_product=psp.id_product)
                        WHERE (p.id_supplier='".intval($auto_params["id_supplier"])."' OR psp.id_supplier='".intval($auto_params["id_supplier"])."')
                        GROUP BY p.id_product";

                $res=Db::getInstance()->ExecuteS($sql);
                if(!empty($res))
                {
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
        }

        return $array;
    }

    public function _executeHook_segmentAutoSqlQuery($name, $params=array())
    {
        $where = "";
        if(!empty($params["auto_params"]))
        {
            $auto_params = unserialize($params["auto_params"]);
            if(!empty($auto_params["id_supplier"]))
            {
                //$where = " AND p.id_supplier ='".intval($auto_params["id_supplier"])."'";

                $where = "AND (
                    p.id_supplier ='".intval($auto_params["id_supplier"])."'
                    OR
                    p.id_product IN (SELECT DISTINCT(psp_seg.id_product)
                        FROM "._DB_PREFIX_."product_supplier psp_seg 
                        WHERE psp_seg.id_product=p.id_product AND psp_seg.id_supplier='".intval($auto_params["id_supplier"])."')
                )";

            }
        }
        return $where;
    }
}