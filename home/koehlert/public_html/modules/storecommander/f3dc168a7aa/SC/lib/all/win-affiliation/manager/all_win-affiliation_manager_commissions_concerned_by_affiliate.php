<?php

$liste_com = array();

if(!empty($_POST["ids"]))
{
	$ids = ($_POST["ids"]);

	$sql = "SELECT *
			FROM "._DB_PREFIX_."orders
			WHERE id_customer IN (".psql($ids).")
			ORDER BY id_order";
	$res=Db::getInstance()->ExecuteS($sql);
	foreach($res AS $order)
	{
		if(!empty($order["id_order"]))
		{
			$sql_comm = "SELECT *
				FROM "._DB_PREFIX_."scaff_commission
				WHERE order_id = '".(int)$order["id_order"]."'";
			$comm=Db::getInstance()->getRow($sql_comm);
			if(!empty($comm["id_commission"]))
			{
				$liste_com[] = $comm["id_commission"];			
			}
		}
	}
}

echo json_encode(array("liste"=>$liste_com));