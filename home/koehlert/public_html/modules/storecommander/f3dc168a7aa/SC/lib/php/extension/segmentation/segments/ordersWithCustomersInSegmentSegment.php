<?php

class ordersWithCustomersInSegmentSegment extends SegmentCustom
{
	public $name="Orders with customers in segment ...";
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
					$sql = "SELECT DISTINCT(o.id_order)
					FROM "._DB_PREFIX_."orders o
							INNER JOIN "._DB_PREFIX_."sc_segment_element se ON (se.id_element = o.id_customer AND se.type_element='customer' AND se.id_segment='".intval($auto_params["id_segment"])."')";
				}
				elseif($segment->type=="auto")
				{
					$ids = array();
					$res_segment=SegmentHook::hookByIdSegment("segmentAutoSqlQueryGrid", $segment, array("id_lang"=>$params["id_lang"]));
					if(is_array($res_segment) && !empty($res_segment))
					{
						foreach($res_segment as $row)
						{
							if(strpos($row["id"],"customer_")!==false && strpos($row["id"],"customer_service_")===false)
							{
								$exp = explode("_", $row["id"]);
								$ids[] = end($exp);
							}
						}
				
						$sql = "SELECT DISTINCT(o.id_order)
								FROM "._DB_PREFIX_."orders o
								WHERE o.id_customer IN (".pSQL(implode(",", $ids)).")";
					}
				}
				if(!empty($sql))
				{
					$res=Db::getInstance()->ExecuteS($sql);
					//echo $sql;
					foreach($res AS $row)
					{
						$type = _l('Order');
						$element = new Order($row['id_order']);
						$name = _l('Order placed ').$element->date_add;
						$infos = "#".$row['id_order'];
						$array[] = array($type, $name, $infos, "id"=>"order_".$row['id_order']);
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
					if(!empty($params["is_order"]))
					{
						$where = " AND o.id_order IN (SELECT DISTINCT(o.id_order)
														FROM "._DB_PREFIX_."orders o
															INNER JOIN "._DB_PREFIX_."sc_segment_element se ON (se.id_element = o.id_customer AND se.type_element='customer' AND se.id_segment='".intval($auto_params["id_segment"])."')
														)";
					}
					else
					{
						$where = " AND od.id_order IN (SELECT DISTINCT(o.id_order)
														FROM "._DB_PREFIX_."orders o
															INNER JOIN "._DB_PREFIX_."sc_segment_element se ON (se.id_element = o.id_customer AND se.type_element='customer' AND se.id_segment='".intval($auto_params["id_segment"])."')
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
							if(strpos($row["id"],"customer_")!==false && strpos($row["id"],"customer_service_")===false)
							{
								$exp = explode("_", $row["id"]);
								$ids[] = end($exp);
							}
						}
						if(!empty($params["is_order"]) && !empty($ids))
						{
							$where = " AND o.id_order IN (SELECT DISTINCT(o.id_order)
															FROM "._DB_PREFIX_."orders o
														WHERE o.id_customer IN (".pSQL(implode(",", $ids)).")
															)";
						}
						elseif(!empty($ids))
						{
							$where = " AND od.id_order IN (SELECT DISTINCT(o.id_order)
															FROM "._DB_PREFIX_."orders o
														WHERE o.id_customer IN (".pSQL(implode(",", $ids)).")
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