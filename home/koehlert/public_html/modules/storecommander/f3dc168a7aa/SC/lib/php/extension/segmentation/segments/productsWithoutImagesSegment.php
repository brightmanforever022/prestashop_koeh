<?php

class productsWithoutImagesSegment extends SegmentCustom
{
	public $name="Products without image";
	public $liste_hooks = array("segmentAutoSqlQuery","segmentAutoSqlQueryGrid");//array("segmentAutoConfig");

	public function _executeHook_segmentAutoSqlQueryGrid($name, $params=array())
	{
		$array = array();
		
		$sql = "SELECT id_product
		FROM "._DB_PREFIX_."product
		WHERE id_product NOT IN (SELECT DISTINCT(id_product) FROM "._DB_PREFIX_."image)";
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
		$where = " AND p.id_product NOT IN (SELECT DISTINCT(id_product) FROM "._DB_PREFIX_."image)";
		
		return $where;
	}
}