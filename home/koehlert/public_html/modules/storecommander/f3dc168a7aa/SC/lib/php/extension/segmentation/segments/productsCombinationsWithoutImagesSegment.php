<?php

class productsCombinationsWithoutImagesSegment extends SegmentCustom
{
    public $name="Products combinations without image";
    public $liste_hooks = array("segmentAutoSqlQuery","segmentAutoSqlQueryGrid");

    public function _executeHook_segmentAutoSqlQueryGrid($name, $params=array())
    {
        $array = array();

        $sql =  "SELECT DISTINCT a.id_product
		FROM "._DB_PREFIX_."product AS a 
		INNER JOIN "._DB_PREFIX_."product_attribute AS b ON a.id_product =  b.id_product 
		WHERE b.id_product_attribute NOT IN (SELECT DISTINCT(id_product_attribute) FROM "._DB_PREFIX_."product_attribute_image)";
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

        return $array;
    }

    public function _executeHook_segmentAutoSqlQuery($name, $params=array())
    {

        $where = "AND p.id_product IN (SELECT DISTINCT pcws_pdt.id_product
		FROM "._DB_PREFIX_."product AS pcws_pdt 
		INNER JOIN "._DB_PREFIX_."product_attribute AS pcws_combi ON pcws_pdt.id_product =  pcws_combi.id_product 
		WHERE pcws_combi.id_product_attribute NOT IN (SELECT DISTINCT(id_product_attribute) FROM "._DB_PREFIX_."product_attribute_image))";

        return $where;
    }
}