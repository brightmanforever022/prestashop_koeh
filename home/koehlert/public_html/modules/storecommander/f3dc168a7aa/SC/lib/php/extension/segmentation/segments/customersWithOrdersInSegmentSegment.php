<?php

class customersWithOrdersInSegmentSegment extends SegmentCustom
{
	public $name="Customers with orders in segment ...";
	public $liste_hooks = array("segmentAutoConfig","segmentAutoSqlQuery","segmentAutoSqlQueryGrid");

	public function _executeHook_segmentAutoConfig($name, $params=array())
	{
		$html='<strong>'._l("Segment:").'</strong><br/>
		<select id="id_segment" name="id_segment" style="width: 100%;">
			<option value="">--</option>';

		$values = array();
		if(!empty($params["values"]))
			$values = unserialize($params["values"]);

		$html.=$this->getLevelFromDB(0, $values);

		$html.='</select>';

		return $html;
	}

	public function _executeHook_segmentAutoSqlQueryGrid($name, $params=array())
	{
		$array = array();

		if(!empty($params["auto_params"]))
		{
			$auto_params = unserialize($params["auto_params"]);
			if(!empty($auto_params["id_segment"]))
			{
				$segment = new ScSegment($auto_params["id_segment"]);
				if($segment->type=="manual")
				{
					$sql = "SELECT DISTINCT(c.id_customer)
					FROM "._DB_PREFIX_."customer c
						INNER JOIN "._DB_PREFIX_."orders o ON (c.id_customer = o.id_customer AND o.valid=1)
							INNER JOIN "._DB_PREFIX_."sc_segment_element se ON (se.id_element = o.id_order AND se.type_element='order' AND se.id_segment='".intval($auto_params["id_segment"])."')";
				}
				elseif($segment->type=="auto")
				{
					$ids = array();
					$res_segment=SegmentHook::hookByIdSegment("segmentAutoSqlQueryGrid", $segment, array("id_lang"=>$params["id_lang"]));
					if(is_array($res_segment) && !empty($res_segment))
					{
						foreach($res_segment as $row)
						{
							if(strpos($row["id"],"order_")!==false)
							{
								$exp = explode("_", $row["id"]);
								$ids[] = end($exp);
							}
						}
						
						$sql = "SELECT DISTINCT(c.id_customer)
									FROM "._DB_PREFIX_."customer c
										INNER JOIN "._DB_PREFIX_."orders o ON (c.id_customer = o.id_customer AND o.valid=1)
								WHERE o.id_order IN (".pSQL(implode(",", $ids)).")";
					}
				}
				if(!empty($sql))
				{
					$res=Db::getInstance()->ExecuteS($sql);
					//echo $sql;
					foreach($res AS $row)
					{
						$type = _l('Customer');
						$element = new Customer($row['id_customer']);
						$name = $element->firstname." ".$element->lastname;
						$infos = "#".$row['id_customer']." / ".$element->email;
						$array[] = array($type, $name, $infos, "id"=>"customer_".$row['id_customer']);
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
			if(!empty($auto_params["id_segment"]))
			{
				$segment = new ScSegment($auto_params["id_segment"]);
				if($segment->type=="manual")
				{
					if(!empty($params["is_customer"]))
					{
						$where = " AND c.id_customer IN (SELECT DISTINCT(c.id_customer)
														FROM "._DB_PREFIX_."customer c
															INNER JOIN "._DB_PREFIX_."orders o ON (c.id_customer = o.id_customer AND o.valid=1)
																INNER JOIN "._DB_PREFIX_."sc_segment_element se ON (se.id_element = o.id_order AND se.type_element='order' AND se.id_segment='".intval($auto_params["id_segment"])."')
														)";
					}
					else
					{
						$where = " AND a.id_customer IN (SELECT DISTINCT(c.id_customer)
														FROM "._DB_PREFIX_."customer c
															INNER JOIN "._DB_PREFIX_."orders o ON (c.id_customer = o.id_customer AND o.valid=1)
																INNER JOIN "._DB_PREFIX_."sc_segment_element se ON (se.id_element = o.id_order AND se.type_element='order' AND se.id_segment='".intval($auto_params["id_segment"])."')
														)";
					}
				}
				elseif($segment->type=="auto")
				{
					$ids = array();
					$res_segment=SegmentHook::hookByIdSegment("segmentAutoSqlQueryGrid", $segment, array("id_lang"=>$params["id_lang"]));
					if(is_array($res_segment) && !empty($res_segment))
					{
						foreach($res_segment as $row)
						{
							if(strpos($row["id"],"order_")!==false)
							{
								$exp = explode("_", $row["id"]);
								$ids[] = end($exp);
							}
						}
						if(!empty($params["is_customer"]) && !empty($ids))
						{
							$where = " AND c.id_customer IN (SELECT DISTINCT(c.id_customer)
														FROM "._DB_PREFIX_."customer c
															INNER JOIN "._DB_PREFIX_."orders o ON (c.id_customer = o.id_customer AND o.valid=1)
														WHERE o.id_order IN (".pSQL(implode(",", $ids)).")
														)";
						}
						elseif(!empty($ids))
						{
							$where = " AND a.id_customer IN (SELECT DISTINCT(c.id_customer)
														FROM "._DB_PREFIX_."customer c
															INNER JOIN "._DB_PREFIX_."orders o ON (c.id_customer = o.id_customer AND o.valid=1)
														WHERE o.id_order IN (".pSQL(implode(",", $ids)).")
														)";
						}
					}
				}
			}
		}
		return $where;
	}

	public function getLevelFromDB($parent_id, $values, $niveau=0)
	{
		$html = "";
		$sql = "SELECT *
					FROM "._DB_PREFIX_."sc_segment
					WHERE id_parent = '".intval($parent_id)."'
					ORDER BY name";

		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res AS $row)
		{
			if($niveau>0)
				$name = "|- ".$row['name'];
			else
				$name = $row['name'];
			for($i=1; $i<=$niveau; $i++)
				$name = "&nbsp;&nbsp;&nbsp;".$name;
				
			$html.='<option value="'.$row['id_segment'].'" '.($row['id_segment']==$values["id_segment"]?'selected':'').'>'.$name.'</option>';
			$html.= $this->getLevelFromDB($row['id_segment'], $values, ($niveau+1));
		}
		return $html;
	}
}