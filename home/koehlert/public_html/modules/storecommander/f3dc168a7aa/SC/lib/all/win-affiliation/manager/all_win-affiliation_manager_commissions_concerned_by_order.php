<?php

$liste_com = array();
$liste_aff = array();

if(!empty($_POST["ids"]))
{
	$ids = ($_POST["ids"]);

	$sql_comm = "SELECT *
		FROM "._DB_PREFIX_."scaff_commission
		WHERE order_id IN (".psql($ids).")";
	$res=Db::getInstance()->ExecuteS($sql_comm);
	foreach($res AS $comm)
	{
		if(!empty($comm["id_commission"]))
		{
			$liste_com[] = $comm["id_commission"];			
		}
		if(!empty($comm["customer_id"]))
		{
			$liste_aff[] = $comm["customer_id"];			
		}
	}
}

echo json_encode(array("liste"=>$liste_com,"liste_aff"=>$liste_aff));