<?php

class productWithSpecificTagSegment extends SegmentCustom
{
    public $name="Products with a specific tag";
    public $liste_hooks = array("segmentAutoConfig","segmentAutoSqlQuery","segmentAutoSqlQueryGrid");

    public function _executeHook_segmentAutoConfig($name, $params=array())
    {
        $html='<strong>'._l("Tag:").'</strong><br/>
		<select id="id_tag" name="id_tag" style="width: 100%;">
			<option value="">--</option>';

        $values = array();
        if(!empty($params["values"]))
            $values = unserialize($params["values"]);

        $sql="	SELECT t.id_tag,t.name,t.id_lang FROM "._DB_PREFIX_."tag t
					LEFT JOIN "._DB_PREFIX_."lang l ON (t.id_lang=l.id_lang)
					GROUP BY t.id_tag
					ORDER BY t.name";
        $tags=Db::getInstance()->ExecuteS($sql);
        foreach($tags as $tag)
        {
            $html.='<option value="'.$tag['id_tag'].'" '.($tag['id_tag']==$values["id_tag"]?'selected':'').'>'.$tag['name'].'</option>';
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
            if(!empty($auto_params["id_tag"]))
            {
                $sql = "SELECT DISTINCT(pt.id_product)
													FROM "._DB_PREFIX_."product_tag pt
														WHERE pt.id_tag='".intval($auto_params["id_tag"])."'";
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
            if(!empty($auto_params["id_tag"]))
            {
                $where = " AND p.id_product IN (SELECT DISTINCT(pt.id_product)
													FROM "._DB_PREFIX_."product_tag pt
														WHERE pt.id_tag='".intval($auto_params["id_tag"])."'
													)";
            }
        }
        return $where;
    }
}